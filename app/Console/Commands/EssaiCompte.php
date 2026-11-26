<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Usager;
use App\Models\UsagerConjoint;
use App\Support\DonneesEssai;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Crée un compte promoteur d'essai (adresse @essai.test, déjà vérifiée), pour tester les parcours sans inscription.
 * Tout se retire avec « php artisan essai:supprimer ». Refusé en production.
 */
class EssaiCompte extends Command
{
    protected $signature = 'essai:compte
        {--fiche : Crée aussi la fiche du promoteur (pour aller directement aux demandes)}
        {--conjoint : Crée la fiche d\'un promoteur marié, avec son conjoint (implique --fiche)}
        {--prenom= : Prénom du promoteur d\'essai (par défaut « Promoteur N »)}
        {--mot-de-passe= : Mot de passe du compte (par défaut, un mot de passe généré)}';

    protected $description = 'Crée un compte promoteur d\'essai (local), à retirer ensuite avec essai:supprimer';

    public function handle()
    {
        if (app()->environment('production')) {
            $this->error('Refusé : les données d\'essai ne se créent pas en production.');
            return 1;
        }

        $numero = 1;
        while (DB::table('users')->where('email', 'essai'.$numero.'@'.DonneesEssai::DOMAINE)->exists()) {
            $numero++;
        }
        $email = 'essai'.$numero.'@'.DonneesEssai::DOMAINE;
        $prenom = $this->option('prenom') ?: 'Promoteur '.$numero;
        $motDePasse = $this->option('mot-de-passe') ?: Str::random(10);

        $conjoint = null;
        $fiche = null;
        DB::transaction(function () use ($email, $prenom, $motDePasse, &$fiche, &$conjoint) {
            $compte = new User();
            $compte->forceFill([
                'name' => DonneesEssai::PREFIXE, 'prenom' => $prenom, 'email' => $email,
                'password' => Hash::make($motDePasse), 'email_verified_at' => now(),
            ])->save();

            if (!$this->option('fiche') && !$this->option('conjoint')) {
                return;
            }
            $lieu = $this->lieuOuagadougou();
            $fiche = Usager::create($lieu + [
                'Type' => 1, 'NomRaisonSociale' => DonneesEssai::PREFIXE, 'Prenom' => $prenom, 'titre' => 'M.', 'Civility' => 'M.', 'Gender' => 2,
                'DateNaissance' => '01-01-1990', 'LieuNaissance' => 'OUAGADOUGOU', 'IdFonction' => '110',
                'SituationMatrimoniale' => $this->option('conjoint') ? 2 : 1, 'IdCategorieUsager' => 4,
                'IdAdresse' => 'ADRESSE D\'ESSAI', 'Boite_postale' => 'NP', 'Phone_No_' => '00000000', 'E-Mail' => $email,
                'CIN' => $this->nipEssai(), 'user_id' => $compte->id,
            ]);

            if ($this->option('conjoint')) {
                $conjoint = Usager::create($lieu + [
                    'Type' => 1, 'NomRaisonSociale' => DonneesEssai::PREFIXE.' CONJOINT', 'Prenom' => $prenom, 'titre' => 'MME', 'Civility' => 'MME', 'Gender' => 1,
                    'DateNaissance' => '01-01-1992', 'LieuNaissance' => 'OUAGADOUGOU', 'IdFonction' => '110',
                    'SituationMatrimoniale' => 2, 'IdCategorieUsager' => 4, 'IdAdresse' => 'ADRESSE D\'ESSAI', 'Boite_postale' => 'NP',
                    'Phone_No_' => '00000000', 'E-Mail' => 'NP', 'CIN' => $this->nipEssai(),
                ]);
                UsagerConjoint::create([
                    'usager_id' => $fiche->id, 'conjoint_id' => $conjoint->id, 'regime_matrimonial' => 4,
                    'date_mariage' => '20-06-2015', 'lieu_mariage' => 'OUAGADOUGOU',
                ]);
            }
        });

        $this->info('Compte d\'essai créé.');
        $this->table(['', ''], array_filter([
            ['Adresse de connexion', rtrim(config('app.url'), '/').'/login'],
            ['E-mail', $email],
            ['Mot de passe', $motDePasse],
            ['Fiche promoteur', $fiche ? DonneesEssai::nom($fiche).' (n° '.$fiche->id.')' : 'non : le compte arrive sur « Enregistrement du promoteur »'],
            $conjoint ? ['Conjoint', DonneesEssai::nom($conjoint).' (n° '.$conjoint->id.')'] : null,
        ]));
        $this->line('Dans les formulaires, commencez par <comment>'.DonneesEssai::PREFIXE.'</comment> le nom des personnes que vous créez (conjoint, associé, dirigeant) :');
        $this->line('essai:supprimer les retirera aussi. Aucun e-mail n\'est envoyé aux adresses @'.DonneesEssai::DOMAINE.' : il est écrit dans storage/logs.');
        $this->line('Vérifier ce qui a été enregistré : <comment>php artisan essai:voir</comment>   Tout retirer : <comment>php artisan essai:supprimer</comment>');

        return 0;
    }

    /** NIP de CNIB d'essai : 17 chiffres, inutilisé. */
    private function nipEssai(): string
    {
        do {
            $nip = '9999'.str_pad((string) random_int(0, 9999999999999), 13, '0', STR_PAD_LEFT);
        } while (DB::table('usagers')->where('CIN', $nip)->exists());

        return $nip;
    }

    /** Burkina Faso, Kadiogo : codes lus dans les tables de référence de la base. */
    private function lieuOuagadougou(): array
    {
        $province = DB::table('provinces')->where('name', 'KADIOGO')->first();
        $commune = $province ? DB::table('commune_departements')->where('province_code', $province->id)->orderBy('id')->first() : null;

        return [
            'Country_Code' => 'BF',
            'Nationality_No_' => (string) (DB::table('valeurs')->where('parametre_id', 6)->where('libelle', 'like', 'Burkin%')->value('code') ?? '37'),
            'Region_Code' => $province->region_code ?? null,
            'Province_Code' => $province->id ?? null,
            'Commun_Departement_Code' => $commune->id ?? null,
        ];
    }
}
