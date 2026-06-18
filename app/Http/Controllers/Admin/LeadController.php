<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Client;
use App\Models\Service;
use Carbon\Carbon;

class LeadController extends Controller
{
    /**
     * 1. Afficher l'interface du Pipeline Commercial (Kanban & Liste)
     */
    public function index(Request $request)
    {
        $clients = Client::orderBy('nom')->get();
        $services = Service::where('actif', true)->orderBy('nom_service')->get();

        $search = $request->input('search');
        $sourceFilter = $request->input('source');

        $query = Lead::with(['client', 'services']);

        if ($search) {
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%");
            });
        }

        if ($sourceFilter && $sourceFilter !== 'all') {
            $query->where('source', $sourceFilter);
        }

        $allLeads = $query->latest()->get();

        $kanbanLeads = [
            'Nouveau'       => $allLeads->where('statut', 'Nouveau'),
            'Contacte'      => $allLeads->where('statut', 'Contacte'),
            'Devis_envoye'  => $allLeads->where('statut', 'Devis_envoye'),
            'Negociation'   => $allLeads->where('statut', 'Negociation'),
            'Gagne'         => $allLeads->where('statut', 'Gagne'),
            'Perdu'         => $allLeads->where('statut', 'Perdu'),
        ];

        return view('admin.leads.index', compact('clients', 'services', 'allLeads', 'kanbanLeads', 'search', 'sourceFilter'));
    }

    /**
     * 2. Créer une nouvelle opportunité (Store Lead)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_client'             => ['required', 'exists:clients,id_client'],
            'source'                => ['required', 'in:Site_web,WhatsApp,Chatbot,Appel_direct,Recommandation,Email'],
            'priorite'              => ['required', 'in:Haute,Normale,Basse'],
            'statut_initial'        => ['required', 'in:Nouveau,Contacte,Devis_envoye,Negociation'],
            'prochaine_relance'     => ['nullable', 'date'],
            'services_concernes'    => ['required', 'array', 'min:1'],
            'services_concernes.*'  => ['exists:services,id_service'],
            'message'               => ['nullable', 'string', 'max:500'],
        ]);

        $lead = Lead::create([
            'id_client'         => $validated['id_client'],
            'source'            => $validated['source'],
            'priorite'          => $validated['priorite'],
            'statut'            => $validated['statut_initial'],
            'prochaine_relance' => $validated['prochaine_relance'] ? Carbon::parse($validated['prochaine_relance']) : null,
            'message_origine'   => $validated['message'],
        ]);

        $lead->services()->sync($validated['services_concernes']);

        return redirect()->route('admin.leads.index')->with('success', 'L\'opportunité commerciale a bien été créée.');
    }

    /**
     * 3. Mettre à jour le statut au Glisser-Déposer (AJAX Kanban Drag & Drop)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'statut' => ['required', 'in:Nouveau,Contacte,Devis_envoye,Negociation,Gagne,Perdu']
        ]);

        $lead = Lead::findOrFail($id);
        $lead->statut = $request->input('statut');
        $lead->save();

        return response()->json([
            'success' => true,
            'message' => 'Le statut de l\'opportunité a été mis à jour avec succès.'
        ]);
    }

    /**
     * 4. API de détails d'une opportunité pour l'affichage du modal d'aperçu
     */
    public function getDetails($id)
    {
        $lead = Lead::with(['client', 'services', 'interactions.user'])->findOrFail($id);

        return response()->json([
            'id_lead'          => $lead->id_lead,
            'client_prenom'    => $lead->client->prenom,
            'client_nom'       => $lead->client->nom,
            'client_telephone' => $lead->client->telephone,
            'client_email'     => $lead->client->email ?? '—',
            'message_origine'  => $lead->message_origine ?? 'Aucune spécification de message renseignée.',
            'statut'           => str_replace('_', ' ', $lead->statut),
            'priorite'         => $lead->priorite,
            'source'           => str_replace('_', ' ', $lead->source),
            'cree_le'          => $lead->created_at->format('d/m/Y'),
            'services'         => $lead->services->map(function ($service) {
                return $service->nom_service;
            }),
            'interactions'     => $lead->interactions->map(function ($interaction) {
                return [
                    'type_canal' => $interaction->type_canal,
                    'note'       => $interaction->note,
                    'date'       => $interaction->date->format('d/m/Y H:i'),
                    'user_name'  => $interaction->user->prenom_user . ' ' . $interaction->user->nom_user
                ];
            })
        ]);
    }

    /**
     * 5. EXPORTATION DE LA BASE DE DONNÉES AU FORMAT CSV (Conforme à l'image)
     */
    public function export()
    {
        // Extraction ordonnée de tous les prospects avec leurs liaisons (MLD)
        $leads = Lead::with(['client', 'services'])->latest()->get();

        $fileName = 'leads_export_' . Carbon::now()->format('Y_m_d') . '.csv';

        // Configuration des en-têtes HTTP pour forcer le téléchargement du fichier CSV
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($leads) {
            $file = fopen('php://output', 'w');
            
            // Injection du BOM UTF-8 indispensable pour qu'Excel ouvre directement le fichier avec les accents (é, à, etc.)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // En-têtes des colonnes (Identique à votre image)
            fputcsv($file, [
                'Client', 
                'Téléphone', 
                'Statut', 
                'Priorité', 
                'Source', 
                'Services', 
                'Date création', 
                'Prochaine relance', 
                'Message'
            ], ';'); // Séparateur point-virgule pour une compatibilité Excel francophone immédiate

            // Remplissage des lignes de données
            foreach ($leads as $lead) {
                fputcsv($file, [
                    $lead->client->prenom . ' ' . $lead->client->nom,
                    $lead->client->telephone,
                    str_replace('_', ' ', $lead->statut), // Transforme Devis_envoye en Devis envoye (Conforme)
                    $lead->priorite,
                    str_replace('_', ' ', $lead->source),
                    $lead->services->pluck('nom_service')->join(', '), // Concatène les multiples services s'il y en a
                    $lead->created_at->format('d/m/Y'),
                    $lead->prochaine_relance ? $lead->prochaine_relance->format('d/m/Y') : '-',
                    $lead->message_origine ?? ''
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}