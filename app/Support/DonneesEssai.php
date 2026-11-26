<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

/**
 * Données d'essai (commandes essai:compte, essai:voir, essai:supprimer) : de quoi tester un parcours complet
 * en local, puis tout retirer d'une commande.
 *
 * Est une donnée d'essai :
 *  - un compte dont l'adresse se termine par @essai.test (domaine réservé : il n'existe pas, et l'application
 *    n'y envoie jamais d'e-mail, voir AppServiceProvider) ;
 *  - la fiche promoteur de ce compte, ses demandes et tout ce qui s'y rattache ;
 *  - une personne (conjoint, associé, dirigeant...) dont le nom commence par ESSAI.
 * Une personne réelle choisie dans une liste pour une donnée d'essai n'est jamais supprimée : seul le lien l'est.
 */
class DonneesEssai
{
    public const DOMAINE = 'essai.test';
    public const PREFIXE = 'ESSAI';

    /** Inventaire des données d'essai (identifiants), sans rien modifier. */
    public static function inventaire(): array
    {
        $comptes = DB::table('users')->where('email', 'like', '%@'.self::DOMAINE)->pluck('id')->map(fn ($id) => (int) $id);

        $fiches = DB::table('usagers')->whereIn('user_id', $comptes->all())->pluck('id')->map(fn ($id) => (int) $id);
        $nommees = DB::table('usagers')->where('NomRaisonSociale', 'like', self::PREFIXE.'%')
            ->where(fn ($q) => $q->whereNull('user_id')->orWhereIn('user_id', $comptes->all()))
            ->pluck('id')->map(fn ($id) => (int) $id);
        $personnes = $fiches->merge($nommees)->unique()->values();

        $demandes = $personnes->isEmpty() ? collect() : DB::table('demandes')
            ->whereIn('usager_id', $personnes->map(fn ($id) => (string) $id)->all())->pluck('id')->map(fn ($id) => (int) $id);

        // Personnes d'essai choisies dans une donnée réelle (dirigeant d'une vraie demande, conjoint d'un vrai promoteur) :
        // on ne les supprime pas, pour ne pas casser la donnée réelle.
        $liees = collect();
        if ($personnes->isNotEmpty()) {
            $liees = $liees->merge(DB::table('demande_dirigeants')->whereIn('usager_id', $personnes->all())
                ->whereNotIn('demande_id', $demandes->all() ?: [0])->pluck('usager_id'));
            $liees = $liees->merge(DB::table('usager_conjoints')->whereIn('conjoint_id', $personnes->all())
                ->whereNotIn('usager_id', $personnes->all())->pluck('conjoint_id'));
        }
        $liees = $liees->map(fn ($id) => (int) $id)->unique()->values();

        // Personnes réelles rattachées à une donnée d'essai (conjoint ou dirigeant choisi dans une liste) : conservées
        $reelles = collect();
        if ($personnes->isNotEmpty()) {
            $reelles = $reelles->merge(DB::table('usager_conjoints')->whereIn('usager_id', $personnes->all())->pluck('conjoint_id'));
        }
        if ($demandes->isNotEmpty()) {
            $reelles = $reelles->merge(DB::table('demande_dirigeants')->whereIn('demande_id', $demandes->all())->pluck('usager_id'));
        }
        $reelles = $reelles->map(fn ($id) => (int) $id)->unique()->diff($personnes)->values();

        return [
            'comptes' => $comptes->values(),
            'personnes' => $personnes->diff($liees)->values(),
            'personnes_conservees' => $liees,
            'personnes_reelles_liees' => $reelles,
            'demandes' => $demandes->values(),
        ];
    }

    /**
     * Supprime les données d'essai (une transaction), puis leurs fichiers.
     * Renvoie le nombre de lignes supprimées par table et le nombre de dossiers de fichiers supprimés.
     */
    public static function supprimer(array $inv): array
    {
        $comptes = $inv['comptes']->all() ?: [0];
        $personnes = $inv['personnes']->all() ?: [0];
        $personnesTexte = array_map('strval', $personnes);
        $demandes = $inv['demandes']->all() ?: [0];
        $bilan = [];

        DB::transaction(function () use (&$bilan, $comptes, $personnes, $personnesTexte, $demandes, $inv) {
            $supprimer = function (string $table, callable $filtre) use (&$bilan) {
                if (Schema::hasTable($table)) {
                    $n = $filtre(DB::table($table))->delete();
                    if ($n) {
                        $bilan[$table] = ($bilan[$table] ?? 0) + $n;
                    }
                }
            };

            // Paiements : numero_demande commence par le numéro de commande de la demande
            $commandes = DB::table('demandes')->whereIn('id', $demandes)->whereNotNull('numero_command')->pluck('numero_command');
            foreach ($commandes as $commande) {
                $supprimer('paiements', fn ($q) => $q->where('numero_demande', 'like', $commande.'%'));
            }
            $terrains = DB::table('demandes')->whereIn('id', $demandes)->whereNotNull('id_terrain')->pluck('id_terrain')->all();

            $supprimer('envois_mail', fn ($q) => $q->whereIn('demande_id', $demandes)->orWhere('destinataire', 'like', '%@'.self::DOMAINE));
            $supprimer('journal_actions', fn ($q) => $q->whereIn('demande_id', $demandes)->orWhereIn('user_id', $comptes));
            $supprimer('activites_promoteur', fn ($q) => $q->whereIn('demande_id', $demandes)->orWhereIn('user_id', $comptes));
            $supprimer('historiques', fn ($q) => $q->whereIn('id_demande', $demandes));
            $supprimer('formalites', fn ($q) => $q->whereIn('demande_id', $demandes));
            $supprimer('piece_jointes', fn ($q) => $q->whereIn('demande_id', $demandes)->orWhereIn('usager_id', $personnes));
            $supprimer('demande_dirigeants', fn ($q) => $q->whereIn('demande_id', $demandes));
            $supprimer('demande_usager_dirigeants', fn ($q) => $q->whereIn('demande_id', $demandes));
            $supprimer('demande_usagers', fn ($q) => $q->whereIn('demande_id', $demandes));
            $supprimer('terrains', fn ($q) => $q->whereIn('id', $terrains ?: [0])->orWhereIn('id_usager', $personnesTexte));
            $supprimer('demandes', fn ($q) => $q->whereIn('id', $demandes));
            $supprimer('usager_conjoints', fn ($q) => $q->whereIn('usager_id', $personnes)->orWhereIn('conjoint_id', $personnes));
            $supprimer('usagers', fn ($q) => $q->whereIn('id', $personnes));
            $supprimer('sessions', fn ($q) => $q->whereIn('user_id', $comptes));
            $supprimer('password_resets', fn ($q) => $q->where('email', 'like', '%@'.self::DOMAINE));
            $supprimer('role_user', fn ($q) => $q->whereIn('user_id', $comptes));
            $supprimer('users', fn ($q) => $q->whereIn('id', $comptes));
        });

        // Fichiers : dossier de chaque personne supprimée et retours de formalités des demandes supprimées
        $dossiers = 0;
        foreach ($inv['personnes'] as $id) {
            $dossiers += self::supprimerDossier(storage_path('app/public/files/'.$id));
        }
        foreach ($inv['demandes'] as $id) {
            $dossiers += self::supprimerDossier(storage_path('app/public/files/formalite_retours/'.$id));
        }

        return ['tables' => $bilan, 'dossiers' => $dossiers];
    }

    private static function supprimerDossier(string $chemin): int
    {
        return File::isDirectory($chemin) && File::deleteDirectory($chemin) ? 1 : 0;
    }

    /** Libellé lisible d'une personne (fiche usagers). */
    public static function nom(?object $usager): string
    {
        return $usager ? trim($usager->NomRaisonSociale.' '.$usager->Prenom) : '—';
    }

    public static function genre($genre): string
    {
        return ['1' => 'Féminin', '2' => 'Masculin'][(string) $genre] ?? 'non renseigné';
    }

    /** Liste d'identifiants pour l'affichage (« 12, 15, 18 »). */
    public static function liste(Collection $ids): string
    {
        return $ids->isEmpty() ? 'aucune' : $ids->implode(', ');
    }
}
