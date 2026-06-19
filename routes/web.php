<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DemandeEmployeurController;
use App\Http\Controllers\EmployeurController;
use App\Http\Controllers\OffresController;

// ─── Pages publiques ───────────────────────────────────────────────
Route::get('/', [PageController::class, 'welcome'])->name('home');
Route::get('/offres', [OffresController::class, 'index'])->name('offres.index');

// ─── Authentification ──────────────────────────────────────────────
Route::get('/connexion',  [AuthController::class, 'showLogin'])->name('connexion');
Route::post('/connexion', [AuthController::class, 'login'])->name('connexion.submit');
Route::get('/inscrit',    [PageController::class, 'signUp'])->name('inscrit');
Route::post('/inscrit',   [AuthController::class, 'register'])->name('inscrit.submit');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// ─── Google OAuth ──────────────────────────────────────────────────
Route::get('/auth/google',          [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// ─── Candidat : dashboard & candidatures ──────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard',                  [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/notifications',    [DashboardController::class, 'liveNotifications'])->name('dashboard.notifs');
    Route::post('/notifications/marquer-lu',  [DashboardController::class, 'marquerLu']);
    Route::get('/postuler.php',           [CandidatureController::class, 'show'])->name('offer.apply');
    Route::post('/postuler',              [CandidatureController::class, 'postuler']);
    Route::post('/profil/mettre-a-jour',  [CandidatureController::class, 'mettreAJourProfil']);
});

// ─── Offres (soumission employeur) ────────────────────────────────
Route::post('/offres', [JobController::class, 'store'])->name('offres.store')->middleware('auth');

// ─── Admin ────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        if (!auth()->user()->isAdmin()) abort(403);
        $offresEnAttente   = \App\Models\Offre::with('entreprise')->enAttente()->orderByDesc('created_at')->get();
        $offresActives     = \App\Models\Offre::with('entreprise')->publiee()->orderByDesc('date_publication')->limit(20)->get();
        $demandesEnAttente = \App\Models\DemandeEmployeur::where('statut', 'pending')->orderByDesc('created_at')->get();
        return view('admin_dashboard', compact('offresEnAttente', 'offresActives', 'demandesEnAttente'));
    })->name('admin.dashboard');

    Route::post('/admin/offres/{offre}/approuver', [JobController::class, 'approuver'])->name('admin.offre.approuver');
    Route::post('/admin/offres/{offre}/rejeter',   [JobController::class, 'rejeter'])->name('admin.offre.rejeter');
    Route::post('/admin/demandes/{demande}/approuver', [DemandeEmployeurController::class, 'approuver'])->name('admin.demande.approuver');
    Route::post('/admin/demandes/{demande}/rejeter',   [DemandeEmployeurController::class, 'rejeter'])->name('admin.demande.rejeter');
});

// ─── Demande compte employeur ──────────────────────────────────────
Route::get('/demande-employeur',  [DemandeEmployeurController::class, 'showForm'])->name('demande-employeur.form');
Route::post('/demande-employeur', [DemandeEmployeurController::class, 'store'])->name('demande-employeur.store');

// ─── Tableau de bord Employeur ─────────────────────────────────────
Route::middleware('auth')->prefix('employeur')->name('employeur.')->group(function () {
    Route::get('/',                                     [EmployeurController::class, 'index'])->name('dashboard');
    Route::get('/offre/{offre}/candidats',              [EmployeurController::class, 'candidats'])->name('candidats');
    Route::get('/live',                                 [EmployeurController::class, 'liveData'])->name('live');
    Route::post('/candidature/{candidature}/entretien', [EmployeurController::class, 'programmerEntretien'])->name('entretien');
    Route::post('/candidature/{candidature}/rejeter',   [EmployeurController::class, 'rejeterDossier'])->name('rejeter');
});
