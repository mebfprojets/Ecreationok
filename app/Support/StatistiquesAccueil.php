<?php

namespace App\Support;

use App\Models\Demande;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Chiffres de l'année en cours affichés sur la page d'accueil : demandes payées, par type et pour le mois en cours.
 * Une requête groupée (et non le chargement de toutes les demandes), gardée 10 minutes en cache.
 * Utilisé par la page d'accueil (DemandeController::index) et par toute page qui la reprend, comme /login
 * (vue auth.login, qui étend « accueil » : AppServiceProvider fournit alors ces chiffres).
 */
class StatistiquesAccueil
{
    public static function calculer(): array
    {
        $annee = now()->year;

        return Cache::remember('accueil.statistiques.'.$annee, now()->addMinutes(10), function () use ($annee) {
            $parMois = Demande::where('paye', 1)
                ->where('created_at', '>=', $annee.'-01-01T00:00:00')   // format ISO : indépendant de la langue de SQL Server
                ->where('created_at', '<', ($annee + 1).'-01-01T00:00:00')
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->get([
                    DB::raw('MONTH(created_at) AS mois'),
                    DB::raw('COUNT(*) AS total'),
                    DB::raw("SUM(CASE WHEN company_type = 'EI' THEN 1 ELSE 0 END) AS individuelles"),
                    DB::raw('SUM(CASE WHEN etat = 1 THEN 1 ELSE 0 END) AS validees'),
                ])->keyBy('mois');

            $total = (int) $parMois->sum('total');
            $individuelles = (int) $parMois->sum('individuelles');

            return [
                'annee' => $annee,
                'total' => $total,
                'individuelles' => $individuelles,
                'societaires' => $total - $individuelles,   // sociétés et GIE
                'validees' => (int) $parMois->sum('validees'),
                'mois_en_cours' => (int) optional($parMois->get(now()->month))->total,
                'nom_mois' => now()->locale('fr')->isoFormat('MMMM'),
                'mis_a_jour' => now(),
            ];
        });
    }
}
