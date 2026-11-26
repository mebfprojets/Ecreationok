<?php

namespace App\Console\Commands;

use App\Support\DonneesEssai;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Affiche ce que les tests ont enregistré : comptes d'essai, fiches, conjoints, demandes (montants, CEFORE),
 * dirigeants, pièces. Lecture seule.
 */
class EssaiVoir extends Command
{
    protected $signature = 'essai:voir';

    protected $description = 'Affiche les données d\'essai enregistrées (comptes @essai.test et personnes ESSAI…)';

    private const TYPES_DIRIGEANT = [1 => 'Dirigeant', 2 => 'Associé', 3 => 'Notaire', 4 => 'Commissaire aux comptes'];
    private const SITUATIONS = [1 => 'Célibataire', 2 => 'Marié(e)', 3 => 'Divorcé(e)'];
    private const REGIMES = [1 => 'Monogamie, communauté universelle', 2 => 'Polygamie, séparation de biens', 3 => 'Monogamie, séparation de biens', 4 => 'Monogamie, biens communs'];

    public function handle()
    {
        $inv = DonneesEssai::inventaire();
        if ($inv['comptes']->isEmpty() && $inv['personnes']->isEmpty()) {
            $this->info('Aucune donnée d\'essai. Créez un compte avec : php artisan essai:compte');
            return 0;
        }

        foreach (DB::table('users')->whereIn('id', $inv['comptes']->all())->orderBy('id')->get() as $compte) {
            $this->newLine();
            $this->info('Compte '.$compte->email.' (n° '.$compte->id.')');
            $fiche = DB::table('usagers')->where('user_id', $compte->id)->first();
            if (!$fiche) {
                $this->line('  Pas encore de fiche promoteur.');
                continue;
            }
            $this->personne('  Promoteur', $fiche);

            foreach (DB::table('usager_conjoints')->where('usager_id', $fiche->id)->get() as $lien) {
                $conjoint = DB::table('usagers')->where('id', $lien->conjoint_id)->first();
                $this->personne('  Conjoint', $conjoint);
                $this->line('      Régime : '.(self::REGIMES[$lien->regime_matrimonial] ?? ($lien->regime_matrimonial ?? '—'))
                    .' ; mariage le '.($lien->date_mariage ? date('d/m/Y', strtotime($lien->date_mariage)) : '—').' à '.($lien->lieu_mariage ?: '—'));
            }

            $pieces = DB::table('piece_jointes')->where('usager_id', $fiche->id)->whereNull('demande_id')->pluck('type_piece');
            if ($pieces->isNotEmpty()) {
                $this->line('  Pièces sans demande : '.$pieces->implode(', '));
            }

            foreach (DB::table('demandes')->where('usager_id', (string) $fiche->id)->orderBy('id')->get() as $d) {
                $province = DB::table('provinces')->where('id', $d->province_code)->value('name');
                $this->line('  <comment>Demande '.$d->numero_demande.'</comment> (n° '.$d->id.') : '.$d->request_type.', '.($d->commercial_name ?: 'sans nom')
                    .', province '.($province ?: $d->province_code).', '.$d->organisation_code);
                $this->line('      Montant '.$d->montant.' ; total à payer '.$d->montant_total.' ; avec CPC : '.($d->avecCPC ? 'oui' : 'non')
                    .' ; payée : '.($d->paye ? 'oui' : 'non').' ; état '.$d->etat.' ; statut '.$d->statut);
                foreach (DB::table('demande_dirigeants')->where('demande_id', $d->id)->get() as $dg) {
                    $p = DB::table('usagers')->where('id', $dg->usager_id)->first();
                    $this->line('      '.(self::TYPES_DIRIGEANT[$dg->type] ?? 'Type '.$dg->type).' : '.DonneesEssai::nom($p)
                        .' ('.DonneesEssai::genre(optional($p)->Gender).')'.($dg->pourcentage_capital ? ', '.$dg->pourcentage_capital.' % du capital' : ''));
                }
                $types = DB::table('piece_jointes')->where('demande_id', $d->id)->pluck('type_piece');
                $this->line('      Pièces ('.$types->count().') : '.($types->isEmpty() ? 'aucune' : $types->implode(', ')));
                $paiements = DB::table('paiements')->where('numero_demande', 'like', $d->numero_command.'%')->count();
                $this->line('      Tentatives de paiement : '.$paiements);
            }
        }

        $orphelines = DB::table('usagers')->whereIn('id', $inv['personnes']->all())->whereNull('user_id')
            ->whereNotIn('id', DB::table('usager_conjoints')->select('conjoint_id'))->get();
        if ($orphelines->isNotEmpty()) {
            $this->newLine();
            $this->info('Personnes ESSAI créées dans les fenêtres (associés, dirigeants, conjoints non rattachés)');
            foreach ($orphelines as $p) {
                $this->personne('  Personne', $p);
            }
        }

        $this->newLine();
        $this->line('essai:supprimer retirerait : '.$inv['comptes']->count().' compte(s), '.$inv['personnes']->count().' personne(s), '
            .$inv['demandes']->count().' demande(s), avec leurs pièces, paiements, journaux et fichiers.');
        if ($inv['personnes_conservees']->isNotEmpty()) {
            $this->warn('Conservées (utilisées par des données réelles) : personnes n° '.DonneesEssai::liste($inv['personnes_conservees']));
        }
        if ($inv['personnes_reelles_liees']->isNotEmpty()) {
            $this->warn('Personnes réelles choisies dans vos essais (conservées, seul le lien est retiré) : n° '.DonneesEssai::liste($inv['personnes_reelles_liees']));
        }

        return 0;
    }

    private function personne(string $libelle, ?object $p): void
    {
        if (!$p) {
            $this->line($libelle.' : introuvable');
            return;
        }
        $this->line($libelle.' : '.DonneesEssai::nom($p).' (n° '.$p->id.') ; '.DonneesEssai::genre($p->Gender).' ; civilité '.($p->Civility ?: '—')
            .' ; pièce '.($p->CIN ?: '—').' ; '.(self::SITUATIONS[$p->SituationMatrimoniale] ?? 'situation '.($p->SituationMatrimoniale ?? '—')));
    }
}
