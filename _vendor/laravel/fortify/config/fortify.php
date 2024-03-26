<?php

use Laravel\Fortify\Features;

return [
    'guard' => 'web',
    'middleware' => ['web'],
    'auth_middleware' => 'auth',
    'passwords' => 'users',
    'username' => 'email',
    'email' => 'email',
    'views' => true,
    'home' => '/home',
    'prefix' => '',
    'domain' => null,
<<<<<<< HEAD
=======
    'lowercase_usernames' => false,
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    'limiters' => [
        'login' => null,
    ],
    'paths' => [
        'login' => null,
        'logout' => null,
<<<<<<< HEAD
        'password.request' => null,
        'password.reset' => null,
        'password.email' => null,
        'password.update' => null,
        'register' => null,
        'verification.notice' => null,
        'verification.verify' => null,
        'verification.send' => null,
        'user-profile-information.update' => null,
        'user-password.update' => null,
        'password.confirm' => null,
        'password.confirmation' => null,
        'two-factor.login' => null,
        'two-factor.enable' => null,
        'two-factor.confirm' => null,
        'two-factor.disable' => null,
        'two-factor.qr-code' => null,
        'two-factor.secret-key' => null,
        'two-factor.recovery-codes' => null,
=======
        'password' => [
            'request' => null,
            'reset' => null,
            'email' => null,
            'update' => null,
            'confirm' => null,
            'confirmation' => null,
        ],
        'register' => null,
        'verification' => [
            'notice' => null,
            'verify' => null,
            'send' => null,
        ],
        'user-profile-information' => [
            'update' => null,
        ],
        'user-password' => [
            'update' => null,
        ],
        'two-factor' => [
            'login' => null,
            'enable' => null,
            'confirm' => null,
            'disable' => null,
            'qr-code' => null,
            'secret-key' => null,
            'recovery-codes' => null,
        ],
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
    ],
    'redirects' => [
        'login' => null,
        'logout' => null,
        'password-confirmation' => null,
        'register' => null,
        'email-verification' => null,
        'password-reset' => null,
    ],
    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        Features::twoFactorAuthentication(),
    ],
];
