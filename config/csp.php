<?php

/*
|--------------------------------------------------------------------------
| Content-Security-Policy (ANSSI VUL-008 / VUL-009)
|--------------------------------------------------------------------------
|
| L'en-tête est envoyé par le middleware App\Http\Middleware\ContentSecurityPolicy,
| avec un nonce aléatoire par requête ajouté à script-src. Il n'y a ni 'unsafe-inline'
| ni 'unsafe-eval' dans script-src : chaque <script> écrit dans une vue doit porter
| nonce="{{ $cspNonce ?? '' }}", et les attributs onclick/onchange sont remplacés par
| des attributs data-csp-* (voir public/js/csp-handlers.js).
|
| IMPORTANT : ne pas laisser en parallèle une CSP définie dans Apache (VirtualHost),
| sinon les deux politiques s'appliquent et le scanner voit l'ancienne.
|
*/

return [

    /*
     | "report"  : Content-Security-Policy-Report-Only (observation, rien n'est bloqué)
     | "enforce" : Content-Security-Policy (politique appliquée)
     | "off"     : aucun en-tête envoyé par l'application
     */
    'mode' => env('CSP_MODE', 'report'),

    // Pages Jetstream (Alpine.js) qui ont besoin de 'unsafe-eval'. Réservées aux comptes connectés.
    'unsafe_eval_paths' => ['user/profile', 'user/api-tokens', 'dashboard'],

    'directives' => [
        'default-src' => ["'self'"],
        'script-src' => [
            "'self'",
            'https://cdn.jsdelivr.net',
            'https://cdnjs.cloudflare.com',
            'https://ajax.aspnetcdn.com',
        ],
        'style-src' => [
            "'self'",
            "'unsafe-inline'",
            'https://cdn.jsdelivr.net',
            'https://cdnjs.cloudflare.com',
            'https://fonts.googleapis.com',
            'https://code.ionicframework.com',
        ],
        'font-src' => [
            "'self'",
            'data:',
            'https://fonts.gstatic.com',
            'https://cdnjs.cloudflare.com',
            'https://code.ionicframework.com',
            'https://cdn.jsdelivr.net',
        ],
        'img-src' => ["'self'", 'data:', 'blob:'],
        'connect-src' => ["'self'"],
        'frame-ancestors' => ["'self'"],
        'object-src' => ["'none'"],
        'base-uri' => ["'self'"],
        'form-action' => ["'self'"],
    ],

];
