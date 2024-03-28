<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsagerController;
use App\Http\Controllers\ValeurController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\CreaController;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ParametreController;





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

Route::get('/admin', function () {
    return view('backend.index');
});

Route::get('/createdemande', function () {
    return view('demande.create');
})->name('create');

Route::get('/signature', function () {
    return view('sign');
});
Route::get('/api', function () {
    return view('api');
});
Route::get('/facture', function () {
    return view('pdf.facture');
});
Route::get('/dash', function () {
    return view('backend.adminlte.main');
})->name('backend');
 
// Ajout BARRO
Route::get('/show/demande', [DemandeController::class,'liste'])->name('demande.liste');
Route::get('/detail/demande/{id}', [DemandeController::class,'detail'])->name('demande.detail');

//Pour la page d'accueil
Route::get('/', [DemandeController::class,'test'])->name('test');
Route::get('/', [DemandeController::class,'index'])->name('index');

// Test wizard
Route::get('/testdemande', [TestsController::class, 'index'])->name("createtest");
Route::post('/storetest', [TestsController::class, 'store'])->name("testdemande");

//Verifier email
Route::get('/email/existe', [UserController::class,'email_existe'])->name('email_existe');
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
Route::get('piecejointe/formalite/{id}', [DemandeController::class,'documentformalite'])->name('affiche_formalite');


Route::post('/update/piecejointe', [DemandeController::class, 'updatepiecejointe'])->name("piecejointe.update");
Route::post('/verifier/nom_commercial', [DemandeController::class, 'verifier_nom_commercial'])->name("verifier_nom_commercial");

Route::get('/create/usager', [UsagerController::class, 'create'])->name("create.usager");
Route::post('/usager-storing', [UsagerController::class, 'store'])->name("store.usager");
Route::get('/create/demande', [DemandeController::class, 'create'])->name("create.demande");
Route::post('/store/demande', [DemandeController::class, 'store'])->name("demande.store");
Route::get('/valeur', [ValeurController::class, 'selection'])->name("valeur.selection");
// Activite
Route::get('/valeur/activite', [ValeurController::class, 'activite'])->name("valeur.activite");
Route::get('/Valider/Paiement{iddemande}', [DemandeController::class, 'valider_paiement'])->name("valider.paiement");

Route::post('/user/store', [UserController::class, 'store_user'])->name("user.store");
Route::get('/tour', [DemandeController::class, 'ourr']);
Route::get('piecejointe/modif',[DemandeController::class, 'modifier'] )->name('piecejointe.modif');
Route::get('piecejointe/correct',[DemandeController::class, 'correct_piece'] )->name('piecejointe.correct_piece');

Route::get('piecejointe/getall', [DemandeController::class, 'getallpiecejointe'])->name('piecejointe.getall');
Route::post('reset_password_without_token',[AccountController::class, 'validatePasswordRequest']);
Route::post('reset-password', [AccountController::class, 'resetPassword'])->name('reset.password.post');
Route::get('forget-password/{token}', [AccountController::class, 'showForgetPasswordForm'])->name('reset.password.get');
Route::get('/test', [TestController::class,'syncrodata']);
Route::get('/loginss',[AccountController::class, 'getlogin']);
Route::resource('user', UserController::class);
Route::resource('permissions', PermissionController::class);
Route::resource("role",RoleController::class);

//Ajout BARRO
Route::get('/backend/liste', [DemandeController::class, 'liste_demande'])->name("list");
Route::get('/backend/liste/attentedepqrtenaire', [DemandeController::class, 'liste_en_attente_de_partenaire'])->name("list.en_attente_de_partenaire");
Route::post('/backend/ajouter/formalite', [DemandeController::class, 'add_formalite_retour'])->name("add_formalite_retour");
Route::post('/backend/update/formalite', [DemandeController::class, 'update_formalite_retour'])->name("update_formalite_retour");
Route::get('/backend/show/formalite/{formalite}', [DemandeController::class, 'show_formalite_retour'])->name("show_formalite_retour");

Route::get('/backend/statistique', [DemandeController::class, 'statistique'])->name("statistique");
Route::get('/backend/liste/rejet', [DemandeController::class, 'liste_demande_rejet'])->name("list.rejet");
Route::get('/backend/detail/{id}', [DemandeController::class,'detail_backend'])->name('detail.demande');
Route::get('/backend/valider/demande/{id}', [DemandeController::class, 'valider_demande'])->name("valider.demande");
Route::get('/home', [DemandeController::class, 'index_admin'])->name("dashboard");
Route::get('/liste/filtre', [DemandeController::class, 'liste_filtre'])->name("liste.filtre");
Route::get('/piecejointe/liste/{piecejointe}', [DemandeController::class, 'showpj'])->name("show.pj");
Route::get('/piecejointe/edit/{piecejointe}', [DemandeController::class, 'editpj'])->name("edit.pj");
Route::post('/piecejointe/update/{piecejointe}', [DemandeController::class, 'updatepj'])->name("update.pj");
Route::post('/piecejointecorrect/update', [DemandeController::class, 'updatepj_correct'])->name("update.pjcorrect");

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
Route::get('/listeval', [ValeurController::class,"listevakeur"])->name("valeur.listeval");
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard',[AccueilController::class, 'page_accueil'])->name('page_accueil');
Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::resource("parametres",ParametreController::class);
Route::resource("valeurs", ValeurController::class);
//Route::get('login', [UserController::class, 'login'])->name('login');


