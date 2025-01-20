<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegencyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index']);

Route::get('/population', [RegencyController::class,'population']);
Route::get('/sekolah', [RegencyController::class,'sekolah']);
Route::get('/puskesmas', [RegencyController::class,'puskesmas']);
