<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ContentSecurityPolicy
{
    /**
     * Génère un nonce par requête, le partage avec les vues ($cspNonce)
     * et ajoute l'en-tête CSP aux pages HTML (configuration : config/csp.php).
     */
    public function handle(Request $request, Closure $next)
    {
        $nonce = base64_encode(random_bytes(16));
        View::share('cspNonce', $nonce);

        $response = $next($request);

        $mode = config('csp.mode', 'report');
        $contentType = (string) $response->headers->get('Content-Type');

        if ($mode === 'off' || ($contentType !== '' && stripos($contentType, 'text/html') === false)) {
            return $response;
        }

        $directives = config('csp.directives', []);
        $directives['script-src'][] = "'nonce-{$nonce}'";

        if ($request->is(...config('csp.unsafe_eval_paths', []))) {
            $directives['script-src'][] = "'unsafe-eval'";
        }

        $politique = collect($directives)
            ->map(function ($sources, $directive) {
                return $directive.' '.implode(' ', $sources);
            })
            ->implode('; ');

        $entete = $mode === 'enforce' ? 'Content-Security-Policy' : 'Content-Security-Policy-Report-Only';
        $response->headers->set($entete, $politique);

        return $response;
    }
}
