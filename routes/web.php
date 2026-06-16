<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\JobController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/home', [PageController::class, 'welcome'])->name('home');

Route::get('/inscrit', [AuthController::class, 'showRegister'])->name('inscrit');
Route::post('/inscrit', [AuthController::class, 'register'])->name('inscrit.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/connexion', [AuthController::class, 'showLogin'])->name('connexion');
Route::post('/connexion', [AuthController::class, 'login'])->name('connexion.submit');
Route::get('/cv', [PageController::class, 'cvGallery'])->name('cv.gallery');
Route::get('/test', [PageController::class, 'test'])->name('test');

// Routes Google OAuth
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Route login (nécessaire pour le middleware auth)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Dashboard protégé
Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Déconnexion (POST)
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/a', [PageController::class, 'welcome']);
Route::get('/welcomP.php', [PageController::class, 'welcome']);
Route::get('/publier_offre.php', [JobController::class, 'publish'])->name('job.publish');
Route::get('/recherche-metier.php', [JobController::class, 'searchByKeyword'])->name('search.keyword');
Route::get('/recherche-localisation.php', [JobController::class, 'searchByLocation'])->name('search.location');
Route::get('/offre-detail.php', function () {
    return view('offre_detail');
})->name('offer.detail');
Route::get('/postuler.php', function () {
    return view('postuler');
})->name('offer.apply');
Route::get('/admin', function () {
    if (!auth()->check() || !auth()->user()->is_admin) {
        abort(403, 'Accès réservé aux administrateurs.');
    }
    return view('admin_dashboard');
})->name('admin.dashboard');
Route::get('/b', [PageController::class, 'test']);

