<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    // 1. Afficher le formulaire de connexion (Image 5)
    public function showLoginForm()
    {
        // Si l'utilisateur est déjà connecté, on le redirige vers le dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    // 2. Traiter la tentative de connexion
    public function login(Request $request)
    {
        // Validation stricte des données d'entrée
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:150'],
            'password' => ['required', 'string'],
        ]);

        // Tentative de connexion native sécurisée contre les injections SQL et attaques de brute-force
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Régénérer la session pour éviter les attaques de fixation de session
            $request->session()->regenerate();

            // Mise à jour de la date de dernière connexion (Contrainte de votre MLD !)
            $user = Auth::user();
            $user->derniere_connexion = Carbon::now();
            $user->save();

            // Redirection vers la page demandée ou vers le Dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        // Si la connexion échoue, on retourne une erreur sur le champ email
        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    // 3. Traiter la déconnexion
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}