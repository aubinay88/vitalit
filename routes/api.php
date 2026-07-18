<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\Api\LitController;

Route::get('/hopitaux/{hopital}/lits', [LitController::class, 'index']);

Route::patch('/lits/{lit}/etat', [LitController::class, 'updateEtat'])
    ->middleware('verifier.token.lit');

Route::post('/lits/{lit}/heartbeat', [LitController::class, 'heartbeat'])
    ->middleware('verifier.token.lit');    

Route::get('/etat-reseau', [LitController::class, 'etatReseau']);    