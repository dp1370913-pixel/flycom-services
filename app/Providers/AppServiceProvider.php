<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // 1. Ne pas oublier d'importer la façade URL

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
        // 2. Si l'adresse de votre site utilise du HTTPS (comme l'URL publique de Ngrok),
        // nous forçons Laravel à générer TOUS les liens internes en HTTPS.
        if (str_contains(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}