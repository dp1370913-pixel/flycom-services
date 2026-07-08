<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\VitrineController;
use App\Http\Controllers\Public\ChatbotController;
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

// Route d'affichage et de réception de formulaire de contact
Route::get('/contact', [VitrineController::class, 'contact'])->name('contact');
Route::post('/contact', [VitrineController::class, 'storeContact'])->name('contact.store');

// Route d'API pour le chatbot intelligent public (Module M7)
Route::post('/api/chatbot/message', [ChatbotController::class, 'handleMessage'])->name('api.chatbot.message');

/*
|--------------------------------------------------------------------------
| 2. ROUTES D'AUTHENTIFICATION SÉCURISÉES (AVEC 2FA ET RATE LIMITING)
|--------------------------------------------------------------------------
*/
Route::get('/espace-securise-flycom', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/espace-securise-flycom', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Double Authentification (2FA) - OTP par Email
Route::get('/verify-identity', [AuthController::class, 'show2FAForm'])->name('2fa.index');
Route::post('/verify-identity', [AuthController::class, 'verify2FA'])->name('2fa.verify')->middleware('throttle:5,1');
Route::post('/verify-identity/resend', [AuthController::class, 'resendOTP'])->name('2fa.resend')->middleware('throttle:3,1');

/*
|--------------------------------------------------------------------------
| 3. GROUPE SÉCURISÉ DU CRM (SÉCURISATION PAR RÔLE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // ────────────────────────────────────────────────────────────
    // SOUS-GROUPE A : CONSULTATION ET LECTURE (Admin, Commercial, Lecture)
    // ────────────────────────────────────────────────────────────
    Route::middleware(['role:Admin,Commercial,Lecture'])->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        // API pour la cloche de notification dynamique (Module M5)
        Route::get('/notifications', [DashboardController::class, 'getNotifications'])->name('admin.notifications');
        
        // API pour la barre de recherche globale unifiée
        Route::get('/global-search', [DashboardController::class, 'globalSearch'])->name('admin.globalSearch');
        
        // Profil personnel
        Route::post('/settings/update-avatar', [SettingsController::class, 'updateAvatar'])->name('admin.settings.updateAvatar');
        Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('admin.profile.update');
        Route::post('/profile/password', [AuthController::class, 'updatePassword'])->name('admin.profile.password');
        
        // Leads
        Route::get('/leads', [LeadController::class, 'index'])->name('admin.leads.index');
        Route::get('/leads/{id}/details', [LeadController::class, 'getDetails'])->name('admin.leads.details');
        
        // Clients
        Route::get('/clients', [ClientController::class, 'index'])->name('admin.clients.index');
        Route::get('/clients/{id}/details', [ClientController::class, 'getDetails'])->name('admin.clients.details');
        
        // Devis & Factures
        Route::get('/devis', [DevisController::class, 'index'])->name('admin.devis.index');
        Route::get('/devis/{id}/print', [DevisController::class, 'printPDF'])->name('admin.devis.print');
        Route::get('/devis/{id}/download', [DevisController::class, 'downloadPDF'])->name('admin.devis.download');
        Route::get('/devis/{id}/details', [DevisController::class, 'getDetails'])->name('admin.devis.details');
        
        // Agenda, Catalogue et Documentation
        Route::get('/agenda', [AgendaController::class, 'index'])->name('admin.agenda.index');
        Route::get('/services-catalogue', [ServiceController::class, 'index'])->name('admin.services.index');
        Route::get('/documentation', [DocumentationController::class, 'index'])->name('admin.documentation.index');
    });

    // ────────────────────────────────────────────────────────────
    // SOUS-GROUPE B : ACTIONS D'ÉCRITURE CLASSIQUES (Admin, Commercial uniquement)
    // ────────────────────────────────────────────────────────────
    Route::middleware(['role:Admin,Commercial'])->group(function () {
        
        // Actions Leads
        Route::post('/leads', [LeadController::class, 'store'])->name('admin.leads.store');
        Route::post('/leads/{id}/update-status', [LeadController::class, 'updateStatus'])->name('admin.leads.updateStatus');
        Route::post('/leads/{id}/interaction', [LeadController::class, 'storeInteraction'])->name('admin.leads.storeInteraction');
        Route::post('/leads/{id}/update', [LeadController::class, 'update'])->name('admin.leads.update');

        // Actions Clients
        Route::post('/clients', [ClientController::class, 'store'])->name('admin.clients.store');
        Route::post('/clients/{id}/update', [ClientController::class, 'update'])->name('admin.clients.update');
        Route::post('/clients/import', [ClientController::class, 'importCSV'])->name('admin.clients.import');

        // Actions Devis
        Route::post('/devis', [DevisController::class, 'store'])->name('admin.devis.store');
        Route::post('/devis/{id}/convert', [DevisController::class, 'convertToInvoice'])->name('admin.devis.convert');
        Route::post('/devis/{id}/send-email', [DevisController::class, 'sendEmail'])->name('admin.devis.sendEmail');
        Route::post('/devis/{id}/update-status', [DevisController::class, 'updateStatus'])->name('admin.devis.updateStatus');
        Route::post('/devis/{id}/duplicate', [DevisController::class, 'duplicate'])->name('admin.devis.duplicate');

        // Actions Agenda
        Route::post('/agenda', [AgendaController::class, 'store'])->name('admin.agenda.store');
        Route::post('/agenda/{id}/complete', [AgendaController::class, 'complete'])->name('admin.agenda.complete');
        Route::post('/agenda/{id}/postpone', [AgendaController::class, 'postpone'])->name('admin.agenda.postpone');
    });

    // ────────────────────────────────────────────────────────────
    // SOUS-GROUPE C : ACTIONS CRITIQUES & PARAMÈTRES (Admin uniquement)
    // ────────────────────────────────────────────────────────────
    Route::middleware(['role:Admin'])->group(function () {
        
        // Devis et Factures
        Route::delete('/devis/{id}/delete', [DevisController::class, 'delete'])->name('admin.devis.delete');

        // Clients & Leads (Suppression réservée à l'Admin)
        Route::delete('/clients/{id}/delete', [ClientController::class, 'delete'])->name('admin.clients.delete');
        Route::delete('/leads/{id}/delete', [LeadController::class, 'delete'])->name('admin.leads.delete');

        // Catalogue Services
        Route::post('/services-catalogue', [ServiceController::class, 'store'])->name('admin.services.store');
        Route::post('/services-catalogue/{id}/update', [ServiceController::class, 'update'])->name('admin.services.update');
        Route::delete('/services-catalogue/{id}/delete', [ServiceController::class, 'delete'])->name('admin.services.delete');

        // Exportation des données sensibles (Uniquement par l'Admin)
        Route::get('/leads/export', [LeadController::class, 'export'])->name('admin.leads.export');
        Route::get('/clients/export', [ClientController::class, 'export'])->name('admin.clients.export');

        // Administration générale, gestion de l'IA et création de nouveaux utilisateurs
        Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/settings/update-entreprise', [SettingsController::class, 'updateEntreprise'])->name('admin.settings.updateEntreprise');
        Route::post('/settings/update-fiscal', [SettingsController::class, 'updateFiscal'])->name('admin.settings.updateFiscal');
        Route::post('/settings/update-ia', [SettingsController::class, 'updateIA'])->name('admin.settings.updateIA');
        Route::post('/settings/update-web-ia', [SettingsController::class, 'updateWebIA'])->name('admin.settings.updateWebIA');
        Route::post('/settings/users', [SettingsController::class, 'storeUser'])->name('admin.settings.storeUser');
    });

});