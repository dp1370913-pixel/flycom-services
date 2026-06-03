<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Importation indispensable pour forcer l'HTTPS

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force l'utilisation du protocole HTTPS en production (évite le Mixed Content sur Render)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}