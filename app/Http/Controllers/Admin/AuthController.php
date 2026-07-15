<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    // 1. Afficher le formulaire de connexion (Image 5)
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    // 2. Traiter la tentative de connexion initiale
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:150'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::validate($credentials)) {
            $user = User::where('email', $credentials['email'])->first();

            $otp = rand(100000, 999999);
            Cache::put('2fa_otp_' . $user->id, $otp, now()->addMinutes(10));

            session([
                '2fa:user_id' => $user->id,
                '2fa:remember' => $request->boolean('remember')
            ]);

            try {
                Mail::raw("Bonjour,\n\nVotre code d'authentification temporaire pour accéder au CRM Flycom Services est : $otp\n\nCe code est confidentiel et expirera dans 10 minutes.\n\nL'équipe Sécurité Flycom.", function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject("Double Authentification — Accès CRM Flycom");
                });
            } catch (\Exception $e) {
                logger("Erreur d'envoi de mail 2FA : " . $e->getMessage());
            }

            return redirect()->route('2fa.index');
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    // 3. Afficher la page de saisie du code 2FA
    public function show2FAForm()
    {
        if (!session()->has('2fa:user_id')) {
            return redirect()->route('login');
        }
        return view('admin.auth.verify');
    }

    // 4. Valider le code de double authentification
    public function verify2FA(Request $request)
    {
        $request->validate([
            'otp_code' => ['required', 'numeric', 'digits:6'],
        ]);

        if (!session()->has('2fa:user_id')) {
            return redirect()->route('login');
        }

        $userId = session('2fa:user_id');
        $cachedOtp = Cache::get('2fa_otp_' . $userId);

        if ($cachedOtp && (int) $request->input('otp_code') === (int) $cachedOtp) {
            Auth::loginUsingId($userId, session('2fa:remember', false));

            Cache::forget('2fa_otp_' . $userId);
            session()->forget(['2fa:user_id', '2fa:remember']);

            $user = Auth::user();
            $user->derniere_connexion = Carbon::now();
            $user->save();

            // ── CORRECTIF ANTI-REDIRECTION AJAX (Fidèle à l'erreur rencontrée) ──
            // Si la dernière URL interceptée en session est une requête d'arrière-plan (comme l'API de notifications ou de recherche),
            // on l'efface pour rediriger proprement et par défaut vers le Dashboard d'accueil.
            $intendedUrl = session()->get('url.intended');
            if ($intendedUrl && (str_contains($intendedUrl, '/notifications') || str_contains($intendedUrl, '/global-search') || str_contains($intendedUrl, '/api/'))) {
                session()->forget('url.intended');
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'otp_code' => 'Le code de vérification est incorrect ou expiré.',
        ]);
    }

    // 5. Régénérer et renvoyer un nouveau code OTP par Email (100% opérationnel)
    public function resendOTP(Request $request)
    {
        if (!session()->has('2fa:user_id')) {
            return redirect()->route('login');
        }

        $userId = session('2fa:user_id');
        $user = User::findOrFail($userId);

        $otp = rand(100000, 999999);
        Cache::put('2fa_otp_' . $user->id, $otp, now()->addMinutes(10));

        try {
            Mail::raw("Bonjour,\n\nVous avez demandé un nouveau code d'authentification temporaire pour accéder au CRM Flycom Services.\n\nVotre nouveau code de sécurité est : $otp\n\nCe code est confidentiel et expirera dans 10 minutes.\n\nL'équipe Sécurité Flycom.", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject("Nouveau Code de Double Authentification — Flycom CRM");
            });
        } catch (\Exception $e) {
            logger("Erreur d'envoi de mail de secours 2FA : " . $e->getMessage());
            return back()->withErrors(['otp_code' => "Échec de l'envoi de l'e-mail de secours. Veuillez réessayer dans quelques instants."]);
        }

        return back()->with('success', 'Un nouveau code d\'authentification a été généré et expédié à votre adresse e-mail.');
    }

    // 6. Mettre à jour les informations du profil utilisateur connecté (Image 23)
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'prenom_user' => ['required', 'string', 'max:100'],
            'nom_user'    => ['required', 'string', 'max:100'],
            'email'       => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
            'avatar_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'] 
        ]);

        $avatarPath = $user->avatar;

        if ($request->hasFile('avatar_file')) {
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                @unlink(public_path($user->avatar));
            }

            if (!file_exists(public_path('assets/avatars'))) {
                mkdir(public_path('assets/avatars'), 0755, true);
            }

            $file = $request->file('avatar_file');
            $fileName = 'avatar_user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/avatars'), $fileName);
            $avatarPath = 'assets/avatars/' . $fileName;
        }

        DB::table('users')->where('id', $user->id)->update([
            'prenom_user' => $validated['prenom_user'],
            'nom_user'    => $validated['nom_user'],
            'email'       => $validated['email'],
            'avatar'      => $avatarPath
        ]);

        return back()->with('success', 'Vos informations de profil personnel ont été mises à jour avec succès.');
    }

    // 7. Mettre à jour le mot de passe personnel de l'utilisateur connecté
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password'     => ['required', 'string', Password::min(8)->letters()->numbers()->symbols(), 'confirmed'],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel que vous avez saisi est incorrect.']);
        }

        DB::table('users')->where('id', $user->id)->update([
            'password' => Hash::make($request->input('new_password'))
        ]);

        return back()->with('success', 'Votre mot de passe personnel a bien été modifié.');
    }

    // 8. Traiter la déconnexion
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}