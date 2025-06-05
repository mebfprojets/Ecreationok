<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemandeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/callback', [DemandeController::class,'reponse_paiement'])
->withoutMiddleware('throttle')
->name('callback');
//Route::post('/callback', [DemandeController::class,'reponse_paiement'])->name('callback');
Route::get('/fnrccm', [DemandeController::class,'fnrccm'])->name('fnrccm');
// Ajout BARRO

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
