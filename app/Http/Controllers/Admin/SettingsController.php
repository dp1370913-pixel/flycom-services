<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\User;
use App\Models\Interaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Smalot\PdfParser\Parser;

class SettingsController extends Controller
{
    // 1. Charger l'index des paramètres
    public function index()
    {
        $configs = Config::all()->pluck('valeur', 'cle')->toArray();
        $users = User::orderBy('nom_user')->get();

        $iaLogs = Interaction::with('client')
            ->whereIn('type_canal', ['Chatbot', 'WhatsApp'])
            ->orderBy('date', 'desc')
            ->take(20) 
            ->get();

        return view('admin.settings.index', compact('configs', 'users', 'iaLogs'));
    }

    // 2. Traiter la modification d'avatar (Corrigé et sécurisé via DB directe)
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar_file' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'] // Limite à 2 Mo
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar_file')) {
            // Nettoyage de l'ancien fichier d'avatar physique s'il existe déjà sur le serveur
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                @unlink(public_path($user->avatar));
            }

            // Générer un dossier d'avatars s'il n'existe pas encore
            if (!file_exists(public_path('assets/avatars'))) {
                mkdir(public_path('assets/avatars'), 0755, true);
            }

            $file = $request->file('avatar_file');
            $fileName = 'avatar_user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/avatars'), $fileName);
            
            // Mise à jour directe et sécurisée en base de données pour cibler uniquement la colonne d'avatar (Bypasse l'erreur de colonne d'image)
            DB::table('users')->where('id', $user->id)->update([
                'avatar' => 'assets/avatars/' . $fileName
            ]);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Votre avatar de profil a bien été mis à jour.');
    }

    // 3. Mettre à jour les informations d'entreprise
    public function updateEntreprise(Request $request)
    {
        $validated = $request->validate([
            'nom_entreprise' => ['required', 'string', 'max:150'],
            'telephone'      => ['required', 'string', 'max:50'],
            'email_contact'  => ['required', 'email', 'max:150'],
            'adresse'        => ['required', 'string'],
        ]);

        Config::updateOrCreate(['cle' => 'nom_entreprise'], ['valeur' => $validated['nom_entreprise']]);
        Config::updateOrCreate(['cle' => 'telephone_entreprise'], ['valeur' => $validated['telephone']]);
        Config::updateOrCreate(['cle' => 'email_entreprise'], ['valeur' => $validated['email_contact']]);
        Config::updateOrCreate(['cle' => 'adresse_entreprise'], ['valeur' => $validated['adresse']]);

        return redirect()->route('admin.settings.index')->with('success', 'Les informations d\'entreprise ont bien été mises à jour.');
    }

    // 4. Mettre à jour la configuration fiscale
    public function updateFiscal(Request $request)
    {
        $validated = $request->validate([
            'tva_taux' => ['required', 'numeric', 'min:0', 'max:100'],
            'devise'   => ['required', 'string', 'max:10'],
        ]);

        Config::updateOrCreate(['cle' => 'tva_taux_defaut'], ['valeur' => $validated['tva_taux']]);
        Config::updateOrCreate(['cle' => 'devise_systeme'], ['valeur' => $validated['devise']]);

        return redirect()->route('admin.settings.index')->with('success', 'La configuration fiscale et monétaire a bien été enregistrée.');
    }

    // 5. Mettre à jour l'activation de l'IA WhatsApp
    public function updateIA(Request $request)
    {
        $validated = $request->validate([
            'heure_ouverture' => ['required', 'string'],
            'heure_fermeture' => ['required', 'string'],
            'jours_ouvrables' => ['required', 'string', 'max:100'],
        ]);

        $iaActive = $request->has('whatsapp_ia_active') ? 'true' : 'false';

        Config::updateOrCreate(['cle' => 'whatsapp_ia_active'], ['valeur' => $iaActive]);
        Config::updateOrCreate(['cle' => 'heure_ouverture'], ['valeur' => $validated['heure_ouverture']]);
        Config::updateOrCreate(['cle' => 'heure_fermeture'], ['valeur' => $validated['heure_fermeture']]);
        Config::updateOrCreate(['cle' => 'jours_ouvrables'], ['valeur' => $validated['jours_ouvrables']]);

        return redirect()->route('admin.settings.index')->with('success', 'Les paramètres de l\'agent IA WhatsApp ont bien été modifiés.');
    }

    // 6. Mettre à jour l'IA du site web (Avec import PDF)
    public function updateWebIA(Request $request)
    {
        $validated = $request->validate([
            'gemini_model'           => ['required', 'string', 'max:50'],
            'chatbot_system_prompt'  => ['required', 'string'],
            'chatbot_knowledge_base' => ['nullable', 'string'],
            'chatbot_knowledge_pdf'  => ['nullable', 'file', 'mimes:pdf', 'max:10240'], 
        ]);

        if ($request->hasFile('chatbot_knowledge_pdf')) {
            try {
                $pdfFile = $request->file('chatbot_knowledge_pdf');
                
                $parser = new Parser();
                $pdf = $parser->parseFile($pdfFile->getPathname());
                $extractedText = $pdf->getText();

                $extractedText = preg_replace('/\s+/', ' ', $extractedText);
                $extractedText = trim($extractedText);

                Config::updateOrCreate(
                    ['cle' => 'chatbot_knowledge_pdf_text'],
                    ['valeur' => $extractedText]
                );

                Config::updateOrCreate(
                    ['cle' => 'chatbot_knowledge_pdf_filename'],
                    ['valeur' => $pdfFile->getClientOriginalName()]
                );
            } catch (\Exception $e) {
                return redirect()->route('admin.settings.index')->with('error', 'Erreur lors de l\'analyse du fichier PDF : ' . $e->getMessage());
            }
        }

        $chatbotActive = $request->has('chatbot_active') ? 'true' : 'false';

        Config::updateOrCreate(['cle' => 'chatbot_active'], ['valeur' => $chatbotActive]);
        Config::updateOrCreate(['cle' => 'gemini_model'], ['valeur' => $validated['gemini_model']]);
        Config::updateOrCreate(['cle' => 'chatbot_system_prompt'], ['valeur' => $validated['chatbot_system_prompt']]);
        Config::updateOrCreate(['cle' => 'chatbot_knowledge_base'], ['valeur' => $validated['chatbot_knowledge_base'] ?? '']);

        Artisan::call('view:clear');
        Artisan::call('config:clear');

        return redirect()->route('admin.settings.index')->with('success', 'La configuration de l\'assistant IA du site vitrine a bien été enregistrée.');
    }

    // 7. Créer un nouveau collaborateur
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'prenom_user' => ['required', 'string', 'max:100'],
            'nom_user'    => ['required', 'string', 'max:100'],
            'email'       => ['required', 'email', 'max:150', 'unique:users,email'],
            'role'        => ['required', 'in:Admin,Commercial,Lecture,System_Bot'],
            'password'    => ['required', 'string', Password::min(8)->letters()->numbers()->symbols()],
        ]);

        User::create([
            'prenom_user' => $validated['prenom_user'],
            'nom_user'    => $validated['nom_user'],
            'email'       => $validated['email'],
            'role'        => $validated['role'],
            'password'    => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'L\'utilisateur a bien été ajouté avec succès.');
    }
}