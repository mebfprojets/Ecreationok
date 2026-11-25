# e-Création (Ecreationok)

Plateforme de création d'entreprise en ligne du MEBF et des CEFORE (`creerentreprise.me.bf`) :
espace promoteur (inscription, demande, pièces, paiement, suivi) et espace agents (traitement des demandes).
Laravel 8.83, PHP 8.1, SQL Server 2016. Production : Windows, Apache wamp64, dossier `C:\wamp64\www\Ecreation`.

## Règles de travail

- **Ne jamais commiter ni pousser** : le développeur relit et commite lui-même. Signaler en fin de tâche les fichiers à commiter,
  y compris les fichiers nouveaux (non suivis).
- **Ne pas modifier les `.env`** (local ou production) : donner les lignes à ajouter. `.env` n'est pas suivi par git (voir `DEPLOIEMENT.md` § 2.3).
- Répondre en français. Les libellés de l'interface et les messages d'erreur sont en français.
- Après une modification qui part en production, `DEPLOIEMENT.md` doit en rendre compte : utiliser le skill `/deploiement`.

## Environnement local

- PHP : `C:\wamp64\bin\php\php8.1.28\php.exe` (il contient `sqlsrv`). Le PHP du PATH (8.2, xampp) ne convient pas pour `artisan`.
- Ce `php.ini` a `curl.cainfo` renseigné ; sans lui, tout appel HTTPS sortant (Microsoft Graph, FNRCCM) échoue avec `cURL error 60`.
  En production, c'est `phpForApache.ini` qui compte pour les requêtes web.
- Base : SQL Server 2016 (`DB_CONNECTION=sqlsrv`).

## Pièges SQL Server

- Le serveur est en format de date français : les modèles déclarent `protected $dateFormat = 'd-m-Y H:i:s';`.
  Ne pas redéfinir `getDateFormat()` (cela a fait perdre l'heure de tous les comptes `users`).
- Comparer les dates en ISO (`Y-m-d`) via le query builder ; `TRY_CONVERT` est disponible.
- SQL Server 2016 : pas de `STRING_AGG`, pas de `TRANSLATE`.

## Code et interface

- **CSP stricte avec nonce** (`App\Http\Middleware\ContentSecurityPolicy`) : aucun `<script>`/`<style>` en ligne sans nonce,
  aucun `onclick=` ; mettre le JS dans `public/js/` (ex. `espace-agents.js`), chargé avec `asset_version()`, et utiliser des attributs `data-*`.
- **Blade** : tout contenu placé hors d'une `@section` est rendu avant le doctype et fait passer la page en mode dégradé (quirks).
  Les modales vont dans `@section('modal_parpage')`, les scripts dans `@section('additionnel_script')`.
- **Bootstrap** : un `href="#x"` posé sur un élément qui porte aussi `id="x"` se cible lui-même ; éviter les `id` en double.
- **Espace agents** : AdminLTE 4 / Bootstrap 5.3, DataTables 2 côté serveur (`table[data-ajax-url]`, `data-tri`, `data-non-triables`,
  `Controller::parametresTableau()`).
- `DemandeController::store()` passe une ligne brute `DB::table('usagers')` (stdClass) : typer `object`, pas `Usager`
  (une signature `Usager` a bloqué toutes les créations de demande en production).
- Les numéros RCCM, IFU, CNSS, CPC et leurs dates (`demandes`) arrivent de l'extérieur : aucun écran ne les saisit.
- Statuts d'une demande : voir `Demande::suivi()` (`paye` 0/1/2, `etat` 0/1/2).

## E-mails

- Envoi par Microsoft Graph (`MAIL_MAILER=graph`, `App\Support\TransportMicrosoftGraph`, boîte `cefore@me.bf`) ; MailerSend (SMTP) reste en secours.
- Chaque envoi, réussi ou non, est noté dans la table `envois_mail` (`EnvoiMail::noter`) : c'est le premier endroit à regarder en cas d'échec (colonne `erreur`).
- Gabarit commun `resources/views/emails/layout.blade.php` (logo `public/frontend/images/CEFORE.jpg`, nom en majuscules).
- Les liens vers une demande passent par `Demande::lienEmail()` (jeton chiffré) : ne pas mettre l'identifiant d'une demande dans un e-mail.

## Tester sans effet de bord

La base locale contient de vraies données. Pour vérifier une modification :

- script PHP jetable (hors du dépôt) qui démarre l'application, entoure le test de `DB::beginTransaction()` / `DB::rollBack()` ;
- aucun e-mail réel : `Mail::fake()`, mailer `array`, ou `Http::fake()` pour Microsoft Graph ;
- fichiers : `$app->useStoragePath(<dossier temporaire>)` ou `Storage::fake()`, jamais d'écriture dans `storage/app` sur une vraie demande ;
- page testée dans le navigateur avec une session temporaire : la supprimer ensuite ;
- ne pas afficher de données personnelles (noms, e-mails, téléphones) dans les sorties.

Le dossier `tests/` ne contient que les tests Jetstream d'origine, non maintenus.

## Déploiement

Procédure complète dans `DEPLOIEMENT.md`. À retenir : `composer install --no-dev` seulement si `composer.lock` a changé ;
`php artisan config:cache` et `view:cache` après chaque déploiement ; **pas de `route:cache`** (route en fonction anonyme dans `routes/api.php`).
