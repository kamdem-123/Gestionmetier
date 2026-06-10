<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Route::get('/inscrit', function () {
    return view('inscrit');
})->name('inscrit');

Route::get('/connexion', function () {
    return view('connexion');
})->name('connexion');

// Routes Google OAuth
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');

Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Route login (nécessaire pour le middleware auth)
Route::get('/login', function () {
    return redirect('/auth/google');
})->name('login');

// Dashboard protégé
Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Déconnexion (POST)
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/a', function () {
    return view('welcomP');
    });

    Route::get('/b', function () {
    return view('test');
    });