<?php

namespace App\Providers;
use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Support\DonneesEssai;
use App\Support\StatistiquesAccueil;
use App\Support\TransportMicrosoftGraph;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
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

        // Comptes d'essai (php artisan essai:compte) : aucun e-mail n'est envoyé aux adresses @essai.test (domaine qui
        // n'existe pas : l'envoi reviendrait en erreur dans la boîte du CEFORE). Le message est écrit dans le journal,
        // avec ses liens, pour pouvoir le vérifier.
        Event::listen(MessageSending::class, function (MessageSending $evenement) {
            $message = $evenement->message;
            $destinataires = array_keys(array_merge((array) $message->getTo(), (array) $message->getCc(), (array) $message->getBcc()));
            $essai = fn ($adresse) => str_ends_with(mb_strtolower((string) $adresse), '@'.DonneesEssai::DOMAINE);
            if ($destinataires === [] || count(array_filter($destinataires, $essai)) !== count($destinataires)) {
                return null; // au moins un vrai destinataire : envoi normal
            }
            $corps = (string) $message->getBody();
            preg_match_all('/href="([^"#][^"]*)"/i', $corps, $liens);
            Log::info('E-mail d\'essai non envoyé', [
                'a' => $destinataires,
                'objet' => $message->getSubject(),
                'texte' => mb_substr(trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($corps)))), 0, 1500),
                'liens' => array_values(array_unique($liens[1])),
            ]);

            return false; // annule l'envoi
        });

        // Chiffres de la page d'accueil, aussi pour les pages qui la reprennent sans passer par DemandeController::index :
        // /login (vue auth.login, qui étend « accueil »), où l'application renvoie tout visiteur non connecté
        // (bouton d'un e-mail, session expirée). Sans eux, la page partait en erreur 500.
        View::composer('partials.frontend.accueil_tarifs_statistiques', function ($view) {
            if (!array_key_exists('statistiques', $view->getData())) {
                $view->with('statistiques', StatistiquesAccueil::calculer());
            }
        });

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
