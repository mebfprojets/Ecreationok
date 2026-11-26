<?php

namespace App\Console\Commands;

use App\Support\DonneesEssai;
use Illuminate\Console\Command;

/** Supprime toutes les données d'essai (base et fichiers). Refusé en production. */
class EssaiSupprimer extends Command
{
    protected $signature = 'essai:supprimer {--force : Ne pas demander de confirmation}';

    protected $description = 'Supprime les données d\'essai : comptes @essai.test, personnes ESSAI…, leurs demandes, pièces et fichiers';

    public function handle()
    {
        if (app()->environment('production')) {
            $this->error('Refusé en production.');
            return 1;
        }

        $inv = DonneesEssai::inventaire();
        if ($inv['comptes']->isEmpty() && $inv['personnes']->isEmpty()) {
            $this->info('Aucune donnée d\'essai à supprimer.');
            return 0;
        }

        $this->line('À supprimer : '.$inv['comptes']->count().' compte(s), '.$inv['personnes']->count().' personne(s) (n° '
            .DonneesEssai::liste($inv['personnes']).'), '.$inv['demandes']->count().' demande(s) (n° '.DonneesEssai::liste($inv['demandes']).').');
        if ($inv['personnes_conservees']->isNotEmpty()) {
            $this->warn('Conservées car utilisées par des données réelles : personnes n° '.DonneesEssai::liste($inv['personnes_conservees']));
        }
        if ($inv['personnes_reelles_liees']->isNotEmpty()) {
            $this->warn('Personnes réelles liées à vos essais, conservées (seul le lien est retiré) : n° '.DonneesEssai::liste($inv['personnes_reelles_liees']));
        }
        if (!$this->option('force') && !$this->confirm('Supprimer définitivement ces données d\'essai ?', true)) {
            $this->line('Rien n\'a été supprimé.');
            return 0;
        }

        $bilan = DonneesEssai::supprimer($inv);
        $this->info('Données d\'essai supprimées.');
        $this->table(['Table', 'Lignes'], collect($bilan['tables'])->map(fn ($n, $t) => [$t, $n])->values()->all());
        $this->line('Dossiers de fichiers supprimés : '.$bilan['dossiers']);

        return 0;
    }
}
