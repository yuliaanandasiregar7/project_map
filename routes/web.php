<?php

use App\Http\Controllers\RegencyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/population', [RegencyController::class,'population']);
Route::get('/sekolah', [RegencyController::class,'sekolah']);
Route::get('/puskesmas', [RegencyController::class,'puskesmas']);
