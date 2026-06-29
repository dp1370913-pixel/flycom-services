<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Conversation;
use App\Models\MessageConversation;
use App\Models\Service;
use App\Models\Config;

class ChatbotController extends Controller
{
    /**
     * Traite les requêtes de messages du chatbot public de manière dynamique.
     */
    public function handleMessage(Request $request)
    {
        // 1. Validation de l'entrée utilisateur
        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            'conversation_id' => ['nullable', 'integer']
        ]);

        $messageText = $request->input('message');
        $conversationId = $request->input('conversation_id');

        // Récupérer les configurations d'IA depuis la table locale 'config'
        $configs = Config::whereIn('cle', [
            'chatbot_active',
            'gemini_model',
            'chatbot_system_prompt',
            'chatbot_knowledge_base',
            'chatbot_knowledge_pdf_text' // Ajout de la base de connaissances PDF extraite
        ])->pluck('valeur', 'cle')->toArray();

        // RÈGLE DE SÉCURITÉ : Vérifier si l'IA est désactivée par l'administrateur
        $isActive = $configs['chatbot_active'] ?? 'true';
        if ($isActive === 'false') {
            return response()->json([
                'success' => true,
                'reply' => "L'assistant virtuel est actuellement hors-ligne. Un conseiller de Flycom Services prendra le relais rapidement.",
                'id_conversation' => $conversationId
            ]);
        }

        // 2. Récupérer ou créer la session de conversation Web
        if ($conversationId) {
            $conversation = Conversation::find($conversationId);
        }

        if (empty($conversation) || $conversation->statut !== 'En_cours') {
            $conversation = Conversation::create([
                'id_client'  => null,
                'canal'      => 'Chatbot_site',
                'statut'     => 'En_cours',
                'date_debut' => now()
            ]);
        }

        // 3. Enregistrer le message de l'internaute dans votre base locale (CRM)
        MessageConversation::create([
            'id_conversation' => $conversation->id_conversation,
            'expediteur'      => 'Client',
            'contenu'         => $messageText,
            'horodatage'      => now()
        ]);

        // 4. Récupérer le catalogue de services de Flycom pour guider l'IA
        $services = Service::where('actif', true)->get(['nom_service', 'prix_indicatif', 'description']);
        $catalogue = "";
        foreach ($services as $service) {
            $catalogue .= "- {$service->nom_service} : " . number_format($service->prix_indicatif, 0, ',', ' ') . " FCFA. {$service->description}\n";
        }

        // Récupérer le prompt système et la base de connaissances personnalisés par l'admin
        $defaultPrompt = $configs['chatbot_system_prompt'] ?? "Tu es l'assistant virtuel de Flycom Services à Brazzaville. Reste courtois, professionnel et très concis (2-3 phrases maximum).";
        $knowledgeBase = $configs['chatbot_knowledge_base'] ?? "";
        $pdfKnowledge = $configs['chatbot_knowledge_pdf_text'] ?? ""; // Contenu du PDF

        // Assemblage dynamique du prompt complet pour Gemini (Incorpore la base de connaissances textuelle et PDF)
        $systemInstruction = $defaultPrompt . "\n\n" .
                             "BASE DE CONNAISSANCES TEXTUELLE COMPLÉMENTAIRE DE L'ENTREPRISE :\n" . $knowledgeBase . "\n\n" .
                             "INFORMATIONS TECHNIQUES EXTRAITES DES DOCUMENTS INTERNES (PDF) :\n" . $pdfKnowledge . "\n\n" .
                             "SERVICES OFFICIELS ET TARIFS :\n" . $catalogue;

        // Configuration dynamique du modèle et de l'URL
        $model = $configs['gemini_model'] ?? 'gemini-2.5-flash';
        $apiKey = config('services.gemini.key');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $aiReply = null;

        try {
            // Appel à l'API Gemini avec force-resolve IPv4 et bypass SSL (développement local)
            $response = Http::withOptions([
                'verify' => false,
                'curl'   => [
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    CURLOPT_TIMEOUT   => 15,
                ]
            ])->post($url, [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $messageText]
                        ]
                    ]
                ],
                'systemInstruction' => [
                    'parts' => [
                        ['text' => $systemInstruction]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $aiReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
            } else {
                Log::error("Gemini API Error: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("Gemini Connection Exception: " . $e->getMessage());
        }

        if (empty($aiReply)) {
            $aiReply = "Désolé, je rencontre une petite perturbation réseau à Brazzaville. " .
                       "N'hésitez pas à nous contacter directement par téléphone au 06 628 57 41.";
        }

        // 5. Enregistrer la réponse de l'IA
        MessageConversation::create([
            'id_conversation' => $conversation->id_conversation,
            'expediteur'      => 'IA',
            'contenu'         => $aiReply,
            'horodatage'      => now()
        ]);

        return response()->json([
            'success'         => true,
            'reply'           => $aiReply,
            'id_conversation' => $conversation->id_conversation
        ]);
    }
}