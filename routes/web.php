<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\ApeController;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

// --------------------
// AUTH
// --------------------
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])
    ->name('logout');


// --------------------
// VERIFICATION CODE (ENSEIGNANT)
// --------------------
Route::get('/verification', [AuthController::class, 'showVerificationForm'])
    ->name('verification.code');

Route::post('/verification', [AuthController::class, 'verifyCode'])
    ->name('verification.check');


// --------------------
// ROUTES PROTÃ‰GÃ‰ES
// --------------------
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Classes
    Route::resource('classes', ClasseController::class)
        ->middleware('role:directeur');

    // Ã‰lÃ¨ves
    Route::resource('eleves', EleveController::class)
        ->parameters(['eleves' => 'eleve'])
        ->middleware('role:directeur,gestionnaire');
        Route::get('/eleves/{eleve}/carte', [EleveController::class, 'carte'])
    ->name('eleves.carte')
    ->middleware('role:directeur,gestionnaire');

Route::get('/eleves/{eleve}/carte/impression', [EleveController::class, 'imprimerCarte'])
    ->name('eleves.carte.impression')
    ->middleware('role:directeur,gestionnaire');

    // Paiements
    Route::resource('paiements', PaiementController::class)
        ->except(['edit', 'update'])
        ->middleware('role:directeur,gestionnaire');

    Route::get('/paiements/{paiement}/recu', [PaiementController::class, 'telechargerRecu'])
        ->name('paiements.recu')
        ->middleware('role:directeur,gestionnaire');

    // Notes
    Route::get('/notes/grille', [NoteController::class, 'grilleSaisie'])
        ->name('notes.grille')
        ->middleware('role:directeur,enseignant');

    Route::post('/notes/grille', [NoteController::class, 'enregistrerGrille'])
        ->name('notes.enregistrer')
        ->middleware('role:directeur,enseignant');

    Route::get('/notes/classement', [NoteController::class, 'classement'])
        ->name('notes.classement')
        ->middleware('role:directeur,enseignant');

    Route::get('/notes/bulletin/{eleve}/{trimestre}/{annee_scolaire}', [NoteController::class, 'bulletin'])
        ->name('notes.bulletin')
        ->middleware('role:directeur,enseignant');

    // Users
    Route::resource('users', UserController::class)
        ->middleware('role:directeur');

    // MatiÃ¨res
    Route::resource('matieres', MatiereController::class)
        ->middleware('role:directeur,enseignant');

    // Profil
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');

    // Export
    Route::get('/export/eleves', [ExportController::class, 'exportEleves'])
        ->name('export.eleves')
        ->middleware('role:directeur,gestionnaire');

    Route::get('/export/paiements', [ExportController::class, 'exportPaiements'])
        ->name('export.paiements')
        ->middleware('role:directeur,gestionnaire');

    // Recherche
    Route::get('/recherche', [RechercheController::class, 'index'])
        ->name('recherche.index');

    // APE Membres
    Route::get('/ape/membres', [ApeController::class, 'indexMembres'])
        ->name('ape.membres.index')
        ->middleware('role:directeur,gestionnaire');

    Route::get('/ape/membres/create', [ApeController::class, 'createMembre'])
        ->name('ape.membres.create')
        ->middleware('role:directeur');

    Route::post('/ape/membres', [ApeController::class, 'storeMembre'])
        ->name('ape.membres.store')
        ->middleware('role:directeur');

    Route::get('/ape/membres/{membre}/edit', [ApeController::class, 'editMembre'])
        ->name('ape.membres.edit')
        ->middleware('role:directeur');

    Route::put('/ape/membres/{membre}', [ApeController::class, 'updateMembre'])
        ->name('ape.membres.update')
        ->middleware('role:directeur');

    Route::delete('/ape/membres/{membre}', [ApeController::class, 'destroyMembre'])
        ->name('ape.membres.destroy')
        ->middleware('role:directeur');

    // APE Cotisations
    Route::get('/ape/cotisations', [ApeController::class, 'indexCotisations'])
        ->name('ape.cotisations.index')
        ->middleware('role:directeur,gestionnaire');

    Route::get('/ape/cotisations/create', [ApeController::class, 'createCotisation'])
        ->name('ape.cotisations.create')
        ->middleware('role:directeur,gestionnaire');

    Route::post('/ape/cotisations', [ApeController::class, 'storeCotisation'])
        ->name('ape.cotisations.store')
        ->middleware('role:directeur,gestionnaire');

    Route::delete('/ape/cotisations/{cotisation}', [ApeController::class, 'destroyCotisation'])
        ->name('ape.cotisations.destroy')
        ->middleware('role:directeur,gestionnaire');

    Route::get('/ape/cotisations/{cotisation}/recu', [ApeController::class, 'telechargerRecuCotisation'])
        ->name('ape.cotisations.recu')
        ->middleware('role:directeur,gestionnaire');

    // Activities
    Route::get('/activities', [ActivityController::class, 'index'])
        ->name('activities.index')
        ->middleware('role:directeur,gestionnaire');
});
