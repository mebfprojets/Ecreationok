<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // API du Fichier national RCCM (vérification de la disponibilité des noms commerciaux).
    // Les identifiants se renseignent uniquement dans le fichier .env, jamais dans le code.
    'fnrccm' => [
        'url' => env('FNRCCM_URL', 'https://fichiernationalrccm.com'),
        'utilisateur' => env('FNRCCM_UTILISATEUR'),
        'mot_de_passe' => env('FNRCCM_MOT_DE_PASSE'),
        // Vérification du certificat HTTPS : ne la désactiver qu'en dépannage (voir curl.cainfo dans php.ini)
        'verifier_ssl' => env('FNRCCM_VERIFIER_SSL', true),
    ],

];
