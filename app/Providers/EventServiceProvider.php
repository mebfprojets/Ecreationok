<?php

namespace App\Providers;

use App\Models\ActivitePromoteur;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        // Historique des connexions des comptes (affiché aux agents dans la page de traitement d'une demande)
        Event::listen(Login::class, function (Login $evenement) {
            ActivitePromoteur::noter('connexion', null, $evenement->remember ? 'Option « Rester connecté » cochée' : null, $evenement->user);
        });
        Event::listen(Failed::class, function (Failed $evenement) {
            // Seulement pour un compte existant (une adresse inconnue n'est rattachée à personne)
            if ($evenement->user) {
                ActivitePromoteur::noter('connexion_echouee', null, null, $evenement->user);
            }
        });
        Event::listen(Logout::class, function (Logout $evenement) {
            if ($evenement->user) {
                $inactivite = request() ? request()->attributes->get('deconnexion_inactivite') : null;
                ActivitePromoteur::noter('deconnexion', null, $inactivite ? 'Automatique, après '.$inactivite.' minutes d’inactivité' : null, $evenement->user);
            }
        });
    }
}
