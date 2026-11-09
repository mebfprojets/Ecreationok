<?php

namespace App\Providers;
use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Support\TransportMicrosoftGraph;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if ($this->app->environment('production')) {
            URL::forceRootUrl(config('app.url'));
            URL::forceScheme('https');
        }

        // MAIL_MAILER=graph : envoi des e-mails par Microsoft Graph
        Mail::extend('graph', fn () => new TransportMicrosoftGraph(config('services.microsoft_graph')));

        // Menu de l'espace agents : nombre de demandes à payer, à valider et rejetées (mêmes critères que les listes),
        // limité au CEFORE de l'agent (le siège voit tout). Une seule requête groupée par page.
        View::composer('backend.adminlte.header', function ($view) {
            $agent = Auth::user();
            if (!$agent) {
                return;
            }
            $compteurs = Demande::query()
                ->when($agent->organisation !== Controller::ORGANISATION_SIEGE, fn ($q) => $q->where('organisation_code', $agent->organisation))
                ->first([
                    DB::raw('SUM(CASE WHEN paye = 0 THEN 1 ELSE 0 END) AS a_payer'),
                    DB::raw('SUM(CASE WHEN paye = 1 AND etat = 0 THEN 1 ELSE 0 END) AS a_valider'),
                    DB::raw('SUM(CASE WHEN etat = 2 THEN 1 ELSE 0 END) AS rejetees'),
                ]);
            $view->with('compteursMenu', [
                'a_payer' => (int) optional($compteurs)->a_payer,
                'a_valider' => (int) optional($compteurs)->a_valider,
                'rejetees' => (int) optional($compteurs)->rejetees,
            ]);
        });
    }
}
