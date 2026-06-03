<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\VitrineController;

/*
|--------------------------------------------------------------------------
| ROUTES PUBLIQUES — PLATEFORME VITRINE (FLYCOM SERVICES)
|--------------------------------------------------------------------------
*/

// 1. Page d'accueil
Route::get('/', [VitrineController::class, 'index'])->name('home');

// 2. Page d'exposition des 8 Services
Route::get('/services', [VitrineController::class, 'services'])->name('services');

// 3. Fiches Techniques individuelles des services (Route dynamique)
Route::get('/services/{slug}', [VitrineController::class, 'serviceDetail'])->name('service.detail');

// 4. Page Portfolio / Réalisations
Route::get('/portfolio', [VitrineController::class, 'portfolio'])->name('portfolio');

// 5. Page FAQ (Questions Fréquentes)
Route::get('/faq', [VitrineController::class, 'faq'])->name('faq');

// 6. Page À propos (Histoire et Équipe)
Route::get('/about', [VitrineController::class, 'about'])->name('about');

// 7. Page Contact (Coordonnées et Formulaire)
Route::get('/contact', [VitrineController::class, 'contact'])->name('contact');
