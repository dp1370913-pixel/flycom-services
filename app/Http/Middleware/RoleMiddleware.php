<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Gère la validation des accès en fonction du rôle utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles  (Liste des rôles acceptés pour la route, ex: 'Admin', 'Commercial')
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if (! in_array($request->user()->role, $roles)) {
            abort(403, "Accès refusé. Votre rôle (" . $request->user()->role . ") ne vous donne pas l'habilitation nécessaire pour effectuer cette action.");
        }

        return $next($request);
    }
}