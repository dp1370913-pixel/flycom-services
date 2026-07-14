<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // Enregistrement de l'alias de rôle d'origine pour l'isolation des routes (Préservé)
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);

        // ── SÉCURITÉ WEBHOOK : EXEMPTION DU CONTRÔLE CSRF (Module M8 - Nouveau) ──
        // Permet au serveur de Meta (Facebook API) de transmettre les messages WhatsApp entrants
        // à votre application sans être bloqué par une erreur HTTP 419.
        $middleware->validateCsrfTokens(except: [
            'webhook/whatsapp',
            'webhook/whatsapp/*'
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();