<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\VitrineController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DevisController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DocumentationController;


/*
|--------------------------------------------------------------------------
| 1. ROUTES PUBLIQUES — PLATEFORME VITRINE (FLYCOM SERVICES)
|--------------------------------------------------------------------------
*/
Route::get('/', [VitrineController::class, 'index'])->name('home');
Route::get('/services', [VitrineController::class, 'services'])->name('services');
Route::get('/services/{slug}', [VitrineController::class, 'serviceDetail'])->name('service.detail');
Route::get('/portfolio', [VitrineController::class, 'portfolio'])->name('portfolio');
Route::get('/faq', [VitrineController::class, 'faq'])->name('faq');
Route::get('/about', [VitrineController::class, 'about'])->name('about');
Route::get('/contact', [VitrineController::class, 'contact'])->name('contact');

/*
|--------------------------------------------------------------------------
| 2. ROUTES D'AUTHENTIFICATION (ACCESSIBLES À TOUS)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 3. GROUPE SÉCURISÉ DU CRM (ACCESSIBLES UNIQUEMENT APRÈS CONNEXION)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Page d'accueil du CRM (Dashboard - M5)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Pipeline Commercial (Kanban & Liste - M3)
    Route::get('/leads', [LeadController::class, 'index'])->name('admin.leads.index');
    Route::post('/leads', [LeadController::class, 'store'])->name('admin.leads.store');
    Route::post('/leads/{id}/update-status', [LeadController::class, 'updateStatus'])->name('admin.leads.updateStatus');
    Route::get('/leads/{id}/details', [LeadController::class, 'getDetails'])->name('admin.leads.details');
    Route::get('/leads/export', [LeadController::class, 'export'])->name('admin.leads.export');

    // Gestion des Clients (M3)
    Route::get('/clients', [ClientController::class, 'index'])->name('admin.clients.index');
    Route::post('/clients', [ClientController::class, 'store'])->name('admin.clients.store');
    Route::post('/clients/import', [ClientController::class, 'importCSV'])->name('admin.clients.import');
    Route::get('/clients/export', [ClientController::class, 'export'])->name('admin.clients.export');

    // Devis & Factures (Module M4)
    Route::get('/devis', [DevisController::class, 'index'])->name('admin.devis.index');
    Route::post('/devis', [DevisController::class, 'store'])->name('admin.devis.store');
    Route::post('/devis/{id}/convert', [DevisController::class, 'convertToInvoice'])->name('admin.devis.convert');
    Route::get('/devis/{id}/print', [DevisController::class, 'printPDF'])->name('admin.devis.print');
    Route::get('/devis/{id}/details', [DevisController::class, 'getDetails'])->name('admin.devis.details');
    Route::post('/devis/{id}/send-email', [DevisController::class, 'sendEmail'])->name('admin.devis.sendEmail');
    Route::post('/devis/{id}/update-status', [DevisController::class, 'updateStatus'])->name('admin.devis.updateStatus');
    Route::delete('/devis/{id}/delete', [DevisController::class, 'delete'])->name('admin.devis.delete');


    // Agenda & Relances (Module M3)
    Route::get('/agenda', [AgendaController::class, 'index'])->name('admin.agenda.index');
    Route::post('/agenda', [AgendaController::class, 'store'])->name('admin.agenda.store');

    // Catalogue des Services (Module M3)
    Route::get('/services-catalogue', [ServiceController::class, 'index'])->name('admin.services.index');
    Route::post('/services-catalogue', [ServiceController::class, 'store'])->name('admin.services.store');
    Route::post('/services-catalogue/{id}/update', [ServiceController::class, 'update'])->name('admin.services.update');

    // Paramètres Globaux du Système (Modules M3, M7 & M8)
    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings/update-entreprise', [SettingsController::class, 'updateEntreprise'])->name('admin.settings.updateEntreprise');
    Route::post('/settings/update-fiscal', [SettingsController::class, 'updateFiscal'])->name('admin.settings.updateFiscal');
    Route::post('/settings/update-ia', [SettingsController::class, 'updateIA'])->name('admin.settings.updateIA');
    Route::post('/settings/users', [SettingsController::class, 'storeUser'])->name('admin.settings.storeUser');

    // Documentation CRM (Module M3)
    Route::get('/documentation', [DocumentationController::class, 'index'])->name('admin.documentation.index');

    

});