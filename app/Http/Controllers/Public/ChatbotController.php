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
     * Traiter les messages entrants du widget de chat de la plateforme vitrine (Module M7 - ChatGPT & Gemini)
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
                'id_client'  => null,
                'canal'      => 'Chatbot_site',
                'statut'     => 'En_cours',
                'date_debut' => now()
            ]);
        });

        // Enregistrer le message de l'internaute dans l'historique (MLD)
        MessageConversation::create([
            'id_conversation' => $conversation->id_conversation,
            'expediteur'      => 'Client',
            'contents'        => $userMessage,
            'contenu'         => $userMessage,
            'horodatage'      => now()
        ]);

        // 2. Extraire la configuration d'administration (Module M7)
        $configs = Config::all()->pluck('valeur', 'cle')->toArray();
        
        $provider = $configs['ai_provider'] ?? 'gemini'; 
        $model = $configs['ai_model'] ?? 'gemini-2.5-flash'; 
        
        // ── AUTO-CORRECTION DE SÉCURITÉ DE ROUTAGE UNIFIÉE ──
        if (str_contains($model, 'gpt')) {
            $provider = 'chatgpt_openrouter';
        } else {
            $provider = 'gemini';
        }

        $systemPrompt = $configs['chatbot_system_prompt'] ?? "Tu es l'assistant de Flycom Services à Brazzaville. Reste concis (2-3 phrases maximum).";
        $knowledgeBase = $configs['chatbot_knowledge_base'] ?? "";
        $pdfContent = $configs['chatbot_knowledge_pdf_text'] ?? "";

        // ── DOUBLE SÉCURITÉ UX ANTI-ASTÉRISQUES ──
        // Cette instruction force l'IA à écrire dans un français humain et aéré, sans résidus de code ou de puces.
        $uxFormattingInstruction = "\n\n" .
                                   "⚠️ IMPORTANT DIRECTIVE DE SÉCURITÉ COMMERCIALE (UX) : \n" .
                                   "Tu ne dois ABSOLUMENT JAMAIS écrire d'astérisques (comme **texte** ou *texte*), " .
                                   "de caractères gras, de listes à puces ou de symboles Markdown dans tes réponses. " .
                                   "Écris uniquement en phrases simples, courtoises et fluides avec des retours à la ligne standard pour aérer ton texte.";

        // Assemblage unifié du contexte de connaissances de l'IA (RAG + Instruction UX)
        $fullContext = $systemPrompt . $uxFormattingInstruction . "\n\n" .
                       "── CONNAISSANCES ENTREPRISE ──\n" . $knowledgeBase . "\n\n" .
                       "── CONNAISSANCES COMPLÉMENTAIRES (PDF TECHNIQUES) ──\n" . $pdfContent;

        $reply = "";

        // 3. Traiter la requête en fonction du fournisseur d'IA configuré
        if ($provider === 'chatgpt_openrouter') {
            // ────────────────────────────────────────────────────────────
            // PASSERELLE CHATGPT (OpenAI)
            // ────────────────────────────────────────────────────────────
            $openRouterKey = env('OPENROUTER_API_KEY');

            if (!empty($openRouterKey)) {
                $url = "https://openrouter.ai/api/v1/chat/completions";

                try {
                    $response = Http::timeout(10)->withHeaders([
                        'Authorization' => 'Bearer ' . $openRouterKey,
                        'Content-Type'  => 'application/json',
                        'HTTP-Referer'  => 'https://flycomservices.cg',
                        'X-Title'       => 'Flycom CRM'
                    ])->post($url, [
                        'model' => $model,
                        'messages' => [
                            ['role' => 'system', 'content' => $fullContext],
                            ['role' => 'user', 'content' => $userMessage]
                        ],
                        'temperature' => 0.3
                    ]);

                    if ($response->successful()) {
                        $data = $response->json();
                        $reply = $data['choices'][0]['message']['content'] ?? null;
                    } else {
                        logger("ÉCHEC API CHATGPT (Code " . $response->status() . ") : " . $response->body());
                    }
                } catch (\Exception $e) {
                    logger("EXCEPTION CANAL CHATGPT : " . $e->getMessage());
                }
            } else {
                logger("ERREUR CONFIGURATION : Clé d'API OPENROUTER_API_KEY manquante dans le fichier .env");
            }
        } else {
            // ────────────────────────────────────────────────────────────
            // MOTEUR DIRECT GOOGLE GEMINI (Direct & Gratuit)
            // ────────────────────────────────────────────────────────────
            $geminiApiKey = env('GEMINI_API_KEY');

            if (!empty($geminiApiKey)) {
                $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$geminiApiKey}";

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
                        logger("ÉCHEC API GEMINI (Code " . $response->status() . ") : " . $response->body());
                    }
                } catch (\Exception $e) {
                    logger("EXCEPTION CANAL GEMINI : " . $e->getMessage());
                }
            } else {
                logger("ERREUR CONFIGURATION : Clé d'API GEMINI_API_KEY manquante dans le fichier .env");
            }
        }

        // 4. MOTEUR DE SECOURS SILENCIEUX (Déclenché si l'appel API a échoué ou dépassé le Timeout)
        if (empty($reply)) {
            $reply = $this->generateLocalFallbackReply($userMessage, $configs);
        }

        // Enregistrer la réponse finale dans l'historique de discussion
        MessageConversation::create([
            'id_conversation' => $conversation->id_conversation,
            'expediteur'      => 'IA',
            'contents'        => $reply,
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
     * Dictionnaire de secours local par mots-clés
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

        return "Merci pour votre message ! Je suis l'assistant virtuel de {$nomEntreprise}. Pour toute demande de diagnostic ou de devis, vous pouvez joindre nos techniciens au {$tel} ou remplir notre formulaire de contact.";
    }
}