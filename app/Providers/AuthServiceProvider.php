<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\UserPolicy;
use App\Policies\ParametrePoolicy;
use App\Policies\ValeurPolicy;
use App\Policies\RolePolicy;
use App\Policies\DemandePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::resource('role', RolePolicy::class);
        Gate::resource('parametre', ParametrePoolicy::class);
        Gate::resource('valeur', ValeurPolicy::class);
        Gate::resource('user', UserPolicy::class);
        Gate::define('lister.demande_a_valider',[DemandePolicy::class,'view'] );
        Gate::define('lister.demande',[DemandePolicy::class,'visualiser_demande'] );
        Gate::define('valider.demande',[DemandePolicy::class,'valider'] );
        Gate::define('save_formalite_retour',[DemandePolicy::class,'save_formalite_retour'] );
        Gate::define('visualiser_formalite_retour',[DemandePolicy::class,'visualiser_formalite_retour'] );


    }
}
