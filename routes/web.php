<?php
use App\Http\Controllers\HopitalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hopitaux', [HopitalController::class, 'index']);
Route::get('/hopitaux/{hopital}', [HopitalController::class, 'show']);