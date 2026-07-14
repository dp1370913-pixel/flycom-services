<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Client;
use App\Models\Conversation;
use App\Models\MessageConversation;
use App\Models\Interaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class WhatsAppController extends Controller
{
    /**
     * 1. Vérification du Webhook par Meta (Protocole de handshake sécurisé)
     */
    public function verifyWebhook(Request $request)
    {
        $verifyToken = env('WHATSAPP_VERIFY_TOKEN');

        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        if ($mode && $token) {
            if ($mode === 'subscribe' && $token === $verifyToken) {
                logger("WhatsApp Webhook : Vérification réussie avec succès.");
                return response($challenge, 200)->header('Content-Type', 'text/plain');
            }
        }

        return response('Vérification échouée ou jeton invalide.', 403);
    }

    /**
     * 2. Réception des notifications en direct de Meta (Messages des clients)
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();

        // Extraire les données utiles du payload complexe de Meta
        $entry = $payload['entry'][0] ?? null;
        $changes = $entry['changes'][0] ?? null;
        $value = $changes['value'] ?? null;
        $messageData = $value['messages'][0] ?? null;

        if (!$messageData) {
            return response()->json(['status' => 'No messages in payload'], 200);
        }

        $senderPhone = '+' . $messageData['from']; // Ajoute le préfixe international
        $profileName = $value['contacts'][0]['profile']['name'] ?? 'Prospect WhatsApp';
        $messageType = $messageData['type'] ?? 'text';
        $userMessage = '';

        if ($messageType === 'text') {
            $userMessage = $messageData['text']['body'] ?? '';
        } elseif ($messageType === 'interactive') {
            $userMessage = $messageData['interactive']['button_reply']['title'] ?? '';
        } else {
            // Ignorer temporairement les messages médias (audios, photos) pour éviter les plantages
            $userMessage = "[Fichier ou média non textuel envoyé par WhatsApp]";
        }

        if (empty($userMessage)) {
            return response()->json(['status' => 'Empty text ignored'], 200);
        }

        // 3. Charger la configuration de l'IA et de l'état d'activité du service
        $configs = Config::all()->pluck('valeur', 'cle')->toArray();
        $whatsappIaActive = $configs['whatsapp_ia_active'] ?? 'true';

        if ($whatsappIaActive !== 'true') {
            logger("WhatsApp Webhook : Service IA inactif dans les paramètres globaux.");
            return response()->json(['status' => 'IA Disabled'], 200);
        }

        // 4. Moteur de synchronisation d'identité (MLD)
        $client = Client::where('telephone', 'like', '%' . substr($senderPhone, -9))->first();

        if (!$client) {
            // Créer une fiche prospect provisoire à la volée pour initier la liaison commerciale
            $client = Client::create([
                'prenom'       => $profileName,
                'nom'          => 'Prospect WhatsApp',
                'telephone'    => $senderPhone,
                'type_contact' => 'Prospect',
                'notes'        => 'Créé automatiquement par l\'agent virtuel WhatsApp.'
            ]);
        }

        // Récupérer ou initialiser le thread de discussion de ce client
        $conversation = Conversation::where('id_client', $client->id_client)
            ->where('canal', 'WhatsApp')
            ->where('statut', 'En_cours')
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'id_client'  => $client->id_client,
                'canal'      => 'WhatsApp',
                'statut'     => 'En_cours',
                'date_debut' => now()
            ]);
        }

        // Consigner le message de l'utilisateur
        MessageConversation::create([
            'id_conversation' => $conversation->id_conversation,
            'expediteur'      => 'Client',
            'contenu'         => $userMessage,
            'horodatage'      => now()
        ]);

        // 5. Interroger l'IA configurée (avec notre double protection anti-astérisques)
        $aiProvider = $configs['ai_provider'] ?? 'gemini';
        $aiModel = $configs['ai_model'] ?? 'gemini-2.5-flash';
        
        if (str_contains($aiModel, 'gpt')) {
            $aiProvider = 'chatgpt_openrouter';
        } else {
            $aiProvider = 'gemini';
        }

        $systemPrompt = $configs['chatbot_system_prompt'] ?? "Tu es l'assistant de Flycom Services. Reste concis.";
        $knowledgeBase = $configs['chatbot_knowledge_base'] ?? "";
        $pdfContent = $configs['chatbot_knowledge_pdf_text'] ?? "";

        // Règle de sécurité UX prioritaire
        $uxFormattingInstruction = "\n\n" .
                                   "⚠️ DIRECTIVE DE SÉCURITÉ COMMERCIALE (UX) À RESPECTER STRICTEMENT : \n" .
                                   "Tu ne dois ABSOLUMENT JAMAIS écrire d'astérisques (comme **texte** ou *texte*), " .
                                   "de caractères gras, de listes à puces ou de symboles Markdown dans tes réponses. " .
                                   "Écris exclusivement en phrases fluides avec des retours à la ligne standard.";

        $fullContext = $systemPrompt . $uxFormattingInstruction . "\n\n" .
                       "── CONNAISSANCES ENTREPRISE ──\n" . $knowledgeBase . "\n\n" .
                       "── CONNAISSANCES SUPPLÉMENTAIRES (PDF) ──\n" . $pdfContent;

        $aiResponse = "";

        if ($aiProvider === 'chatgpt_openrouter') {
            $openRouterKey = env('OPENROUTER_API_KEY');
            if (!empty($openRouterKey)) {
                try {
                    $response = Http::timeout(12)->withHeaders([
                        'Authorization' => 'Bearer ' . $openRouterKey,
                        'Content-Type'  => 'application/json',
                    ])->post("https://openrouter.ai/api/v1/chat/completions", [
                        'model' => $aiModel,
                        'messages' => [
                            ['role' => 'system', 'content' => $fullContext],
                            ['role' => 'user', 'content' => $userMessage]
                        ],
                        'temperature' => 0.3
                    ]);

                    if ($response->successful()) {
                        $data = $response->json();
                        $aiResponse = $data['choices'][0]['message']['content'] ?? "";
                    }
                } catch (\Exception $e) {
                    logger("WhatsApp Agent exception (ChatGPT) : " . $e->getMessage());
                }
            }
        } else {
            $geminiKey = env('GEMINI_API_KEY');
            if (!empty($geminiKey)) {
                try {
                    $response = Http::timeout(12)->post("https://generativelanguage.googleapis.com/v1beta/models/{$aiModel}:generateContent?key={$geminiKey}", [
                        'contents' => [
                            [
                                'role' => 'user',
                                'parts' => [['text' => "Message : " . $userMessage]]
                            ]
                        ],
                        'systemInstruction' => [
                            'parts' => [['text' => $fullContext]]
                        ]
                    ]);

                    if ($response->successful()) {
                        $data = $response->json();
                        $aiResponse = $data['candidates'][0]['content']['parts'][0]['text'] ?? "";
                    }
                } catch (\Exception $e) {
                    logger("WhatsApp Agent exception (Gemini) : " . $e->getMessage());
                }
            }
        }

        // Fallback si l'IA d'expédition est inaccessible
        if (empty($aiResponse)) {
            $aiResponse = "Bonjour ! Nous prenons bien en compte votre message. Un conseiller technique de Flycom Services va prendre contact avec vous par appel téléphonique très rapidement.";
        }

        // 6. Archiver la réponse générée en base de données
        MessageConversation::create([
            'id_conversation' => $conversation->id_conversation,
            'expediteur'      => 'IA',
            'contenu'         => $aiResponse,
            'horodatage'      => now()
        ]);

        // Tracer l'activité en temps réel dans le journal du CRM (Module M5)
        Interaction::create([
            'id_client'  => $client->id_client,
            'id_user'    => 4, // ID d'utilisateur réservé au compte "System_Bot WhatsApp"
            'type_canal' => 'WhatsApp',
            'date'       => now(),
            'note'       => 'Interaction automatique gérée par l\'agent IA WhatsApp.'
        ]);

        // 7. Expédier physiquement le message final sur le mobile de l'utilisateur
        $this->sendWhatsAppMessage($senderPhone, $aiResponse);

        return response()->json(['status' => 'Message processed and sent'], 200);
    }

    /**
     * Expédier une requête POST vers Facebook Graph API pour acheminer le message (Module M8)
     */
    private function sendWhatsAppMessage(string $toPhone, string $messageText)
    {
        $accessToken = env('WHATSAPP_TOKEN');
        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');

        if (empty($accessToken) || empty($phoneNumberId)) {
            logger("WhatsApp API Error : Configuration d'envoi Meta manquante (Token ou ID numéro absent)");
            return false;
        }

        $url = "https://graph.facebook.com/v21.0/{$phoneNumberId}/messages";

        try {
            $response = Http::withToken($accessToken)
                ->post($url, [
                    'messaging_product' => 'whatsapp',
                    'recipient_type'    => 'individual',
                    'to'                => $toPhone,
                    'type'              => 'text',
                    'text'              => [
                        'body' => $messageText
                    ]
                ]);

            if (!$response->successful()) {
                logger("Meta API WhatsApp Send Fail (Code " . $response->status() . ") : " . $response->body());
                return false;
            }

            return true;
        } catch (\Exception $e) {
            logger("Meta API WhatsApp Communication Exception : " . $e->getMessage());
            return false;
        }
    }
}