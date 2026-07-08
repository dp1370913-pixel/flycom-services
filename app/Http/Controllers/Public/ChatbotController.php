<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Conversation;
use App\Models\MessageConversation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ChatbotController extends Controller
{
    /**
     * Traiter les messages entrants du widget de chat de la plateforme vitrine (Module M7)
     */
    public function handleMessage(Request $request)
    {
        $request->validate([
            'message'         => ['required', 'string', 'max:1000'],
            'conversation_id' => ['nullable', 'exists:conversations,id_conversation']
        ]);

        $userMessage = $request->input('message');
        $conversationId = $request->input('conversation_id');

        // 1. Initialiser ou récupérer la session de conversation (M3)
        $conversation = DB::transaction(function () use ($conversationId) {
            if ($conversationId) {
                return Conversation::find($conversationId);
            }
            
            return Conversation::create([
                'id_client'  => null, // Le client est anonyme tant qu'il ne s'est pas identifié
                'canal'      => 'Chatbot_site',
                'statut'     => 'En_cours',
                'date_debut' => now()
            ]);
        });

        // Enregistrer le message de l'internaute dans l'historique (MLD)
        MessageConversation::create([
            'id_conversation' => $conversation->id_conversation,
            'expediteur'      => 'Client',
            'contenu'         => $userMessage,
            'horodatage'      => now()
        ]);

        // 2. Extraire la configuration d'Intelligence Artificielle paramétrée en d'administration (Module M7)
        $configs = Config::all()->pluck('valeur', 'cle')->toArray();
        $apiKey = env('GEMINI_API_KEY');
        $model = $configs['gemini_model'] ?? 'gemini-1.5-flash';
        
        $systemPrompt = $configs['chatbot_system_prompt'] ?? "Tu es l'assistant virtuel de Flycom Services à Brazzaville. Reste courtois, professionnel et très concis.";
        $knowledgeBase = $configs['chatbot_knowledge_base'] ?? "";
        $pdfContent = $configs['chatbot_knowledge_pdf_text'] ?? "";

        // Assemblage unifié du contexte de connaissances de l'IA (RAG)
        $fullContext = $systemPrompt . "\n\n" .
                       "── CONNAISSANCES ENTREPRISE (BASE DE DONNÉES) ──\n" . $knowledgeBase . "\n\n" .
                       "── CONNAISSANCES SUPPLÉMENTAIRES (FICHIERS TECHNIQUES PDF IMPORTÉS) ──\n" . $pdfContent;

        $reply = "";

        // 3. Traitement de la réponse de l'IA
        if (!empty($apiKey)) {
            // Appel direct à l'API REST officielle de Google Gemini (sans dépendances lourdes)
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

            try {
                $response = Http::timeout(10)->post($url, [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => "Message de l'internaute : " . $userMessage]
                            ]
                        ]
                    ],
                    'systemInstruction' => [
                        'parts' => [
                            ['text' => $fullContext]
                        ]
                    ]
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                } else {
                    logger("Erreur d'appel API Gemini (Code " . $response->status() . ") : " . $response->body());
                }
            } catch (\Exception $e) {
                logger("Exception lors de l'appel API Gemini : " . $e->getMessage());
            }
        }

        // 4. Fallback intelligent en local si l'API est absente ou échoue (évite le plantage du widget)
        if (empty($reply)) {
            $reply = $this->generateLocalFallbackReply($userMessage, $configs);
        }

        // Enregistrer la réponse générée par l'IA dans l'historique
        MessageConversation::create([
            'id_conversation' => $conversation->id_conversation,
            'expediteur'      => 'IA',
            'contenu'         => $reply,
            'horodatage'      => now()
        ]);

        return response()->json([
            'success'         => true,
            'reply'           => $reply,
            'id_conversation' => $conversation->id_conversation
        ]);
    }

    /**
     * Moteur de réponses locales par détection de mots-clés en cas d'absence de connexion API
     */
    private function generateLocalFallbackReply(string $message, array $configs): string
    {
        $message = mb_strtolower($message);
        $nomEntreprise = $configs['nom_entreprise'] ?? 'Flycom Services';
        $tel = $configs['telephone_entreprise'] ?? '06 628 57 41';

        if (str_contains($message, 'contact') || str_contains($message, 'téléphone') || str_contains($message, 'appeler')) {
            return "Vous pouvez contacter directement notre équipe commerciale par téléphone au {$tel} ou nous envoyer un message via notre formulaire dans l'onglet Contact.";
        }

        if (str_contains($message, 'adresse') || str_contains($message, 'bureau') || str_contains($message, 'situé') || str_contains($message, 'brazzaville')) {
            return "Nos bureaux sont situés au 22, Avenue de Brazza — La Glacière, Brazzaville. N'hésitez pas à venir nous rendre visite !";
        }

        if (str_contains($message, 'tarif') || str_contains($message, 'prix') || str_contains($message, 'devis') || str_contains($message, 'combien')) {
            return "Nos tarifs dépendent de la complexité de votre projet. Nous serions ravis de vous établir un devis proforma gratuit sous 24h. Veuillez remplir le formulaire sur notre page Contact pour exprimer votre besoin.";
        }

        if (str_contains($message, 'reseau') || str_contains($message, 'wifi') || str_contains($message, 'vidéo') || str_contains($message, 'caméra') || str_contains($message, 'solaire')) {
            return "Nous proposons d'excellentes prestations d'ingénierie : réseaux d'entreprises, télésurveillance active, contrôle d'accès biométrique et kits d'énergie solaire. Quelle solution vous intéresse le plus ?";
        }

        return "Merci pour votre message ! Je suis l'assistant virtuel de {$nomEntreprise}. Pour toute demande d'audit ou de prix, vous pouvez également joindre nos techniciens au {$tel}.";
    }
}