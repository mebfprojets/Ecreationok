<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Déconnexion après une période d'inactivité.
 * - Agents : config('session.inactivite_agents') minutes (30 par défaut) ; le cookie « Rester connecté »
 *   ne les reconnecte jamais (ils ont accès aux données de tous les promoteurs).
 * - Promoteurs : durée de la session (config('session.lifetime')), sauf s'ils ont choisi « Rester connecté ».
 */
class DeconnexionInactivite
{
    public const CLE = 'derniere_activite';

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user) {
            $agent = $user->isadmin != null;
            $minutes = (int) ($agent ? config('session.inactivite_agents', 30) : config('session.lifetime', 120));
            $derniere = (int) $request->session()->get(self::CLE, 0);
            $inactif = $derniere > 0 && (time() - $derniere) > $minutes * 60;

            if (($agent && Auth::viaRemember()) || ($inactif && !Auth::viaRemember())) {
                return $this->deconnecter($request, $minutes);
            }
            $request->session()->put(self::CLE, time());
        }

        return $next($request);
    }

    private function deconnecter(Request $request, int $minutes)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $message = 'Votre session a expiré après '.$minutes.' minutes d’inactivité. Reconnectez-vous pour continuer.';

        if ($request->expectsJson()) {
            return response()->json(['message' => $message], 401);
        }

        return redirect()->route('index')->with('message', $message)->with('ouvrir_connexion', true);
    }
}
