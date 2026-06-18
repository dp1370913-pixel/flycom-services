<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\User;
use App\Models\Interaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    // 1. Charger l'index des paramètres (Image 19)
    public function index()
    {
        // Extraction de toutes les variables clés-valeurs de la table 'config'
        $configs = Config::all()->pluck('valeur', 'cle')->toArray();

        // Extraction de tous les utilisateurs (humains et bots) enregistrés (Image 23)
        $users = User::orderBy('nom_user')->get();

        // Extraction du journal d'activité de l'IA (Canal Chatbot & WhatsApp - Image 22)
        $iaLogs = Interaction::with('client')
            ->whereIn('type_canal', ['Chatbot', 'WhatsApp'])
            ->orderBy('date', 'desc')
            ->take(20) // Limite aux 20 dernières entrées pour la performance
            ->get();

        return view('admin.settings.index', compact('configs', 'users', 'iaLogs'));
    }

    // 2. Mettre à jour les informations d'entreprise
    public function updateEntreprise(Request $request)
    {
        $validated = $request->validate([
            'nom_entreprise' => ['required', 'string', 'max:150'],
            'telephone'      => ['required', 'string', 'max:50'],
            'email_contact'  => ['required', 'email', 'max:150'],
            'adresse'        => ['required', 'string'],
        ]);

        Config::where('cle', 'nom_entreprise')->update(['valeur' => $validated['nom_entreprise']]);
        Config::where('cle', 'telephone_entreprise')->update(['valeur' => $validated['telephone']]);
        Config::where('cle', 'email_entreprise')->update(['valeur' => $validated['email_contact']]);
        Config::where('cle', 'adresse_entreprise')->update(['valeur' => $validated['adresse']]);

        return redirect()->route('admin.settings.index')->with('success', 'Les informations d\'entreprise ont bien été mises à jour.');
    }

    // 3. Mettre à jour la configuration fiscale (Image 20)
    public function updateFiscal(Request $request)
    {
        $validated = $request->validate([
            'tva_taux' => ['required', 'numeric', 'min:0', 'max:100'],
            'devise'   => ['required', 'string', 'max:10'],
        ]);

        Config::where('cle', 'tva_taux_defaut')->update(['valeur' => $validated['tva_taux']]);
        Config::where('cle', 'devise_systeme')->update(['valeur' => $validated['devise']]);

        return redirect()->route('admin.settings.index')->with('success', 'La configuration fiscale et monétaire a bien été enregistrée.');
    }

    // 4. Mettre à jour les horaires et l'activation de l'IA WhatsApp (Image 21)
    public function updateIA(Request $request)
    {
        $validated = $request->validate([
            'heure_ouverture' => ['required', 'string'],
            'heure_fermeture' => ['required', 'string'],
            'jours_ouvrables' => ['required', 'string', 'max:100'],
        ]);

        // Gérer le commutateur ON/OFF de l'agent IA (Image 21)
        $iaActive = $request->has('whatsapp_ia_active') ? 'true' : 'false';

        Config::where('cle', 'whatsapp_ia_active')->update(['valeur' => $iaActive]);
        Config::where('cle', 'heure_ouverture')->update(['valeur' => $validated['heure_ouverture']]);
        Config::where('cle', 'heure_fermeture')->update(['valeur' => $validated['heure_fermeture']]);
        Config::where('cle', 'jours_ouvrables')->update(['valeur' => $validated['jours_ouvrables']]);

        return redirect()->route('admin.settings.index')->with('success', 'Les paramètres de l\'agent IA WhatsApp ont bien été modifiés.');
    }

    // 5. Créer un nouvel utilisateur / collaborateur (Image 1 & 23)
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'prenom_user' => ['required', 'string', 'max:100'],
            'nom_user'    => ['required', 'string', 'max:100'],
            'email'       => ['required', 'email', 'max:150', 'unique:users,email'],
            'role'        => ['required', 'in:Admin,Commercial,Lecture,System_Bot'],
            'password'    => ['required', 'string', 'min:6'], // Mot de passe temporaire
        ]);

        User::create([
            'prenom_user' => $validated['prenom_user'],
            'nom_user'    => $validated['nom_user'],
            'email'       => $validated['email'],
            'role'        => $validated['role'],
            'password'    => Hash::make($validated['password']), // Hachage bcrypt automatique
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'L\'utilisateur a bien été ajouté avec succès.');
    }
}