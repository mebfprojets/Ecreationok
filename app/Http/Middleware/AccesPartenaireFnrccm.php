<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Accès à l'API de consultation des paiements (/api/fnrccm), réservé au partenaire FNRCCM :
 * clé d'API dans l'en-tête X-Api-Key (FNRCCM_API_CLE) et/ou adresse IP autorisée (FNRCCM_API_IPS).
 * Sans aucune des deux configurée, l'accès est refusé (ANSSI : l'API était publique).
 */
class AccesPartenaireFnrccm
{
    public function handle(Request $request, Closure $next)
    {
        $cle = (string) config('services.fnrccm.api_cle');
        $ips = config('services.fnrccm.api_ips', []);

        if ($cle === '' && empty($ips)) {
            report(new \RuntimeException('API /api/fnrccm appelée alors qu’aucun accès n’est configuré : renseigner FNRCCM_API_CLE et/ou FNRCCM_API_IPS dans le fichier .env.'));
            return $this->refus();
        }
        // Une clé configurée doit être présentée ; une liste d'IP configurée doit contenir l'appelant
        if ($cle !== '' && !hash_equals($cle, (string) $request->header('X-Api-Key'))) {
            return $this->refus();
        }
        if (!empty($ips) && !in_array($request->ip(), $ips, true)) {
            return $this->refus();
        }

        return $next($request);
    }

    private function refus()
    {
        return response()->json(['message' => 'Accès non autorisé.'], 403);
    }
}
