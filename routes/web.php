<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsagerController;
use App\Http\Controllers\ValeurController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\PieceJointeController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('index');
// });
 
// Ajout BARRO
Route::get('/show/demande', [DemandeController::class,'liste'])->name('demande.liste');
Route::get('/detail/demande/{id}', [DemandeController::class,'detail'])->name('demande.detail');

//Pour la page d'accueil
//Route::get('/', [DemandeController::class,'test'])->name('test');
// Route::get('/', [DemandeController::class,'test'])->name('test');
Route::get('/', [DemandeController::class,'index'])->name('index');

Route::post('/paiement/orange/index', [DemandeController::class, 'orange'])->name('orange.index');
Route::post('/paiement/orange/store', [DemandeController::class, 'orange_paiement'])->name('orange.store');
Route::post('/paiement/moov/index', [DemandeController::class, 'moov'])->name('moov.index');
Route::post('/paiement/moov/store', [DemandeController::class, 'moov_store'])->name('moov.store');
Route::post('/paiement/moov/verifotp', [DemandeController::class, 'moov_verif_otp'])->name('moov.otp');

//Verifier email
Route::get('/email/existe', [UserController::class,'email_existe'])->name('email_existe')->middleware('throttle:20,1');
// Inscription : envoi du code de vérification de l'adresse e-mail (avant la création du compte)
Route::post('/inscription/code', [InscriptionController::class, 'envoyerCode'])->name('inscription.code')->middleware('throttle:6,1');
// Demande update
Route::put('demande/update/{id}', [DemandeController::class, 'update_demande'])->name('demande.update');
Route::post('demande/update/promoteur/{id}', [DemandeController::class, 'update_rejet'])->name('update.promoteur');

// Usager update
Route::put('usager/update/{id}', [DemandeController::class, 'update_usager'])->name('usager.update');

//Facture
Route::get('/facture/demande/{id}', [DemandeController::class,'facture'])->name('demande.facture');

Route::post('/load/piecejointe', [DemandeController::class, 'laodpiecejointe'])->name("piecejointe.laod");
Route::get('piece/detail/', [DemandeController::class,'detaildocument'])->name('detaildocument');
Route::get('piecejointe/afficher/{id}', [DemandeController::class,'detaildocument_affiche'])->name('detaildocument_affiche');
// Consultation des fichiers dans la page (promoteur propriétaire ou agent du CEFORE) : plus aucun lien direct vers /storage/files
Route::get('piecejointe/voir/{id}', [DemandeController::class,'voirPiece'])->name('piecejointe.voir');
Route::get('formalite/voir/{id}', [DemandeController::class,'voirFormalite'])->name('formalite.voir');
Route::get('piecejointe/formalite/{id}', [DemandeController::class,'documentformalite'])->name('affiche_formalite');
// Nouvelle Route ajout BARRO le 01/11/2025
Route::get('/view-document/{category}', [PieceJointeController::class, 'view'])->name('view.document');
Route::get('type/entreprise', [DemandeController::class,'typeEntreprise'])->name('type.entreprise');
Route::get('/process-type-entreprise/{type}', [DemandeController::class, 'processTypeEntreprise'])->name('process.type.entreprise');

Route::post('/update/piecejointe', [DemandeController::class, 'updatepiecejointe'])->name("piecejointe.update");
Route::post('/verifier/nom_commercial', [DemandeController::class, 'verifier_nom_commercial'])->name("verifier_nom_commercial")->middleware('throttle:20,1');

Route::get('/create/usager', [UsagerController::class, 'create'])->name("create.usager");
Route::post('/usager-storing', [UsagerController::class, 'store'])->name("store.usager");
Route::get('/create/demande', [DemandeController::class, 'create'])->name("create.demande");
Route::post('/store/demande', [DemandeController::class, 'store'])->name("demande.store");
Route::get('/valeur', [ValeurController::class, 'selection'])->name("valeur.selection");
// Activite
Route::get('/valeur/activite', [ValeurController::class, 'activite'])->name("valeur.activite");
//Route::get('/Valider/Paiement{iddemande}', [DemandeController::class, 'valider_paiement'])->name("valider.paiement");

// Route::get('/tour', [DemandeController::class, 'ourr']); // route de test désactivée (sécurité)
Route::get('piecejointe/modif',[DemandeController::class, 'modifier'] )->name('piecejointe.modif');
Route::get('piecejointe/correct',[DemandeController::class, 'correct_piece'] )->name('piecejointe.correct_piece');

Route::get('piecejointe/getall', [DemandeController::class, 'getallpiecejointe'])->name('piecejointe.getall');
// Mot de passe oublié : envois limités (le contrôleur n'accepte en plus qu'un envoi par minute et par adresse)
Route::post('reset_password_without_token',[AccountController::class, 'validatePasswordRequest'])->name('password.oubli')->middleware('throttle:5,1');
Route::post('reset-password', [AccountController::class, 'resetPassword'])->name('reset.password.post')->middleware('throttle:10,1');
Route::get('forget-password/{token}', [AccountController::class, 'showForgetPasswordForm'])->name('reset.password.get');
Route::get('/loginss',[AccountController::class, 'getlogin']);

//Ajout BARRO
//Commente
Route::middleware(['auth', 'admin'])->group(function () {
// Comptes, usagers, rôles et permissions : réservés aux agents (données personnelles)
Route::get('/user/compte', [UserController::class,'compte'])->name('user.compte');
Route::get('promoteur/liste', [UsagerController::class, 'promoteur'])->name('promoteur.liste');
// Données des deux listes, chargées page par page par le tableau (DataTables côté serveur)
Route::get('promoteur/liste/donnees', [UsagerController::class, 'promoteur_donnees'])->name('promoteur.liste.donnees');
Route::get('/user/compte/donnees', [UserController::class, 'compte_donnees'])->name('user.compte.donnees');
Route::resource('user', UserController::class);
Route::resource('permissions', PermissionController::class);
Route::resource("role",RoleController::class);

Route::get('/backend/liste', [DemandeController::class, 'liste_demande'])->name("list");
Route::get('/backend/liste/all', [DemandeController::class, 'all'])->name("all.list");
// Données de « Toutes les demandes », chargées page par page par le tableau (DataTables côté serveur)
Route::get('/backend/liste/all/donnees', [DemandeController::class, 'all_donnees'])->name("all.list.donnees");
Route::get('/backend/liste/attentedepqrtenaire', [DemandeController::class, 'liste_en_attente_de_partenaire'])->name("list.en_attente_de_partenaire");
Route::post('/backend/ajouter/formalite', [DemandeController::class, 'add_formalite_retour'])->name("add_formalite_retour");
Route::post('/backend/update/formalite', [DemandeController::class, 'update_formalite_retour'])->name("update_formalite_retour");
Route::get('/backend/show/formalite/{formalite}', [DemandeController::class, 'show_formalite_retour'])->name("show_formalite_retour");
//Commente
Route::get('/backend/statistique', [DemandeController::class, 'statistique'])->name("statistique");
Route::get('/backend/liste/rejet', [DemandeController::class, 'liste_demande_rejet'])->name("list.rejet");
Route::get('/backend/detail/{id}', [DemandeController::class,'detail_backend'])->name('detail.demande');
// Validation / rejet : formulaire POST protégé par jeton CSRF (plus de simple lien)
Route::post('/backend/valider/demande/{id}', [DemandeController::class, 'valider_demande'])->name("valider.demande");
Route::get('/home', [DemandeController::class, 'index_admin'])->name("dashboard");
Route::get('/liste/filtre', [DemandeController::class, 'liste_filtre'])->name("liste.filtre");
Route::get('/piecejointe/liste/{piecejointe}', [DemandeController::class, 'showpj'])->name("show.pj");
Route::get('/piecejointe/edit/{piecejointe}', [DemandeController::class, 'editpj'])->name("edit.pj");
Route::post('/piecejointe/update/{piecejointe}', [DemandeController::class, 'updatepj'])->name("update.pj");

// Paramètres et valeurs de référence : réservés aux agents (droits vérifiés dans les contrôleurs)
Route::resource("parametres",ParametreController::class);
Route::resource("valeurs", ValeurController::class);

// Anciennes routes de démonstration (/admin, /createdemande, /signature, /api, /facture, /dash)
// supprimées (sécurité) : gabarits non utilisés, contenant du JavaScript incompatible avec la CSP.
});
Route::post('/piecejointecorrect/update', [DemandeController::class, 'updatepj_correct'])->name("update.pjcorrect");
Route::get('/usagers/recherche', [UsagerController::class, 'rechercher'])
    ->name('usager.recherche')
    ->middleware('throttle:30,1');
// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
// Route::get('/register', function () {
//     return redirect()->route('index');
// });
Route::get('/register', [DemandeController::class,'index'])->name('register');

Route::get('/listeval', [ValeurController::class,"listevakeur"])->name("valeur.listeval");
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard',[AccueilController::class, 'page_accueil'])->name('page_accueil');
Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::resource("piece", PieceJointeController::class);
//Route::get('login', [UserController::class, 'login'])->name('login');


