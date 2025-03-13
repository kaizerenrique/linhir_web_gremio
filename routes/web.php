<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialiteAuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/redirect', [SocialiteAuthController::Class, 'redirect'])->name('auth.redirect');
Route::get('/auth/callback', [SocialiteAuthController::Class, 'callback'])->name('auth.callback');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/listado', function () {
        return view('seccion/listadodegremio');
    })->name('listado');
});


