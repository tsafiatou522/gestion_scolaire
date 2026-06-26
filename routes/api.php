<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ParentController;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::post('/login', [AuthController::class, 'login']);

// Routes protegees (necessitent un token Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/password', [AuthController::class, 'updatePassword']);

    Route::get('/enfants', [ParentController::class, 'mesEnfants']);
    Route::get('/eleves/{eleveId}/dashboard', [ParentController::class, 'dashboard']);
    Route::get('/eleves/{eleveId}/notes', [ParentController::class, 'notes']);
    Route::get('/eleves/{eleveId}/paiements', [ParentController::class, 'paiements']);
    Route::get('/eleves/{eleveId}/absences', [ParentController::class, 'absences']);
    Route::get('/annonces', [ParentController::class, 'annonces']);
});
