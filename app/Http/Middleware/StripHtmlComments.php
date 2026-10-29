<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StripHtmlComments
{
    /**
     * Retire les commentaires HTML (<!-- ... -->) des pages avant envoi,
     * sauf les commentaires conditionnels IE (<!--[if ...]>). ANSSI VUL-009.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof Response
            && str_contains((string) $response->headers->get('Content-Type'), 'text/html')) {
            $nettoye = preg_replace('/<!--(?!\s*\[if|<!\[endif)[\s\S]*?-->/', '', $response->getContent());

            if ($nettoye !== null) {
                $response->setContent($nettoye);
            }
        }

        return $response;
    }
}
