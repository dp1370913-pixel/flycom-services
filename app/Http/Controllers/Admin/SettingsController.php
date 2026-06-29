<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\User;
use App\Models\Interaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Rule;
use Smalot\PdfParser\Parser;

class SettingsController extends Controller
{
    // 1. Charger l'index des paramètres
    public function index()
    {
        // Extraction de toutes les variables clés-valeurs de la table 'config'
        $configs = Config::all()->pluck('valeur', 'cle')->toArray();

        // Extraction de tous les utilisateurs (humains et bots) enregistrés
        $users = User::orderBy('nom_user')->get();

        // Extraction du journal d'activité de l'IA (Canal Chatbot & WhatsApp)
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

        Config::updateOrCreate(['cle' => 'nom_entreprise'], ['valeur' => $validated['nom_entreprise']]);
        Config::updateOrCreate(['cle' => 'telephone_entreprise'], ['valeur' => $validated['telephone']]);
        Config::updateOrCreate(['cle' => 'email_entreprise'], ['valeur' => $validated['email_contact']]);
        Config::updateOrCreate(['cle' => 'adresse_entreprise'], ['valeur' => $validated['adresse']]);

        return redirect()->route('admin.settings.index')->with('success', 'Les informations d\'entreprise ont bien été mises à jour.');
    }

    // 3. Mettre à jour la configuration fiscale
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

    // 4. Mettre à jour les horaires et l'activation de l'IA WhatsApp
    public function updateIA(Request $request)
    {
        $validated = $request->validate([
            'heure_ouverture' => ['required', 'string'],
            'heure_fermeture' => ['required', 'string'],
            'jours_ouvrables' => ['required', 'string', 'max:100'],
        ]);

        // Gérer le commutateur ON/OFF de l'agent IA
        $iaActive = $request->has('whatsapp_ia_active') ? 'true' : 'false';

        Config::updateOrCreate(['cle' => 'whatsapp_ia_active'], ['valeur' => $iaActive]);
        Config::updateOrCreate(['cle' => 'heure_ouverture'], ['valeur' => $validated['heure_ouverture']]);
        Config::updateOrCreate(['cle' => 'heure_fermeture'], ['valeur' => $validated['heure_fermeture']]);
        Config::updateOrCreate(['cle' => 'jours_ouvrables'], ['valeur' => $validated['jours_ouvrables']]);

        return redirect()->route('admin.settings.index')->with('success', 'Les paramètres de l\'agent IA WhatsApp ont bien été modifiés.');
    }

    // 4.1 Mettre à jour la configuration de l'IA et de la base de connaissances du Site Web (Avec gestion d'import PDF)
    public function updateWebIA(Request $request)
    {
        $validated = $request->validate([
            'gemini_model'           => ['required', 'string', 'max:50'],
            'chatbot_system_prompt'  => ['required', 'string'],
            'chatbot_knowledge_base' => ['nullable', 'string'],
            'chatbot_knowledge_pdf'  => ['nullable', 'file', 'mimes:pdf', 'max:10240'], // Max 10 Mo (Image 21)
        ]);

        // Traiter l'extraction de texte du fichier PDF s'il est fourni (Image 21)
        if ($request->hasFile('chatbot_knowledge_pdf')) {
            try {
                $pdfFile = $request->file('chatbot_knowledge_pdf');
                
                // Instanciation du parseur de PDF
                $parser = new Parser();
                $pdf = $parser->parseFile($pdfFile->getPathname());
                $extractedText = $pdf->getText();

                // Nettoyage des espaces et retours à la ligne excessifs pour optimiser le contexte de l'IA
                $extractedText = preg_replace('/\s+/', ' ', $extractedText);
                $extractedText = trim($extractedText);

                // Enregistrer le texte extrait en base
                Config::updateOrCreate(
                    ['cle' => 'chatbot_knowledge_pdf_text'],
                    ['valeur' => $extractedText]
                );

                // Mémoriser le nom du fichier d'origine pour l'affichage dans le CRM
                Config::updateOrCreate(
                    ['cle' => 'chatbot_knowledge_pdf_filename'],
                    ['valeur' => $pdfFile->getClientOriginalName()]
                );
            } catch (\Exception $e) {
                return redirect()->route('admin.settings.index')->with('error', 'Erreur lors de l\'analyse du fichier PDF : ' . $e->getMessage());
            }
        }

        $chatbotActive = $request->has('chatbot_active') ? 'true' : 'false';

        Config::updateOrCreate(
            ['cle' => 'chatbot_active'],
            ['valeur' => $chatbotActive]
        );

        Config::updateOrCreate(
            ['cle' => 'gemini_model'],
            ['valeur' => $validated['gemini_model']]
        );

        Config::updateOrCreate(
            ['cle' => 'chatbot_system_prompt'],
            ['valeur' => $validated['chatbot_system_prompt']]
        );

        Config::updateOrCreate(
            ['cle' => 'chatbot_knowledge_base'],
            ['valeur' => $validated['chatbot_knowledge_base'] ?? '']
        );

        // Vider les caches pour une application immédiate des réglages d'IA
        Artisan::call('view:clear');
        Artisan::call('config:clear');

        return redirect()->route('admin.settings.index')->with('success', 'La configuration de l\'assistant IA du site vitrine et sa base de connaissances ont bien été enregistrées.');
    }

    // 5. Créer un nouvel utilisateur / collaborateur
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'prenom_user' => ['required', 'string', 'max:100'],
            'nom_user'    => ['required', 'string', 'max:100'],
            'email'       => ['required', 'email', 'max:150', 'unique:users,email'],
            'role'        => ['required', 'in:Admin,Commercial,Lecture,System_Bot'],
            'password'    => ['required', 'string', 'min:6'],
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