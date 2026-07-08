<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Client;
use App\Models\Service;
use App\Models\Interaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeadController extends Controller
{
    /**
     * 1. Afficher l'interface du Pipeline Commercial
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
                $q->where('nom', 'like', '%' . $search . '%')
                  ->orWhere('prenom', 'like', '%' . $search . '%');
            });
        }

        if ($sourceFilter && $sourceFilter !== 'all') {
            $query->where('source', $sourceFilter);
        }

        $allLeads = $query->latest()->get();

        $kanbanLeads = [
            'Nouveau'      => $allLeads->where('statut', 'Nouveau'),
            'Contacte'     => $allLeads->where('statut', 'Contacte'),
            'Devis_envoye' => $allLeads->where('statut', 'Devis_envoye'),
            'Negociation'  => $allLeads->where('statut', 'Negociation'),
            'Gagne'        => $allLeads->where('statut', 'Gagne'),
            'Perdu'        => $allLeads->where('statut', 'Perdu'),
        ];

        return view('admin.leads.index', compact('allLeads', 'clients', 'services', 'kanbanLeads', 'search', 'sourceFilter'));
    }

    /**
     * 2. Création manuelle d'un lead
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_client' => ['required', 'exists:clients,id_client'],
            'source' => ['required', 'string'],
            'priorite' => ['required', 'string'],
            'statut_initial' => ['required', 'string'],
            'prochaine_relance' => ['nullable', 'date'],
            'message' => ['nullable', 'string', 'max:500'],
            'services_concernes' => ['required', 'array', 'min:1'],
            'services_concernes.*' => ['exists:services,id_service']
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
     * 3. Mettre à jour toutes les informations d'un Lead existant (Nouveau)
     */
    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $validated = $request->validate([
            'source'            => ['required', 'string'],
            'priorite'          => ['required', 'string'],
            'statut'            => ['required', 'string'],
            'prochaine_relance' => ['nullable', 'date'],
            'message_origine'   => ['nullable', 'string', 'max:500'],
            'services_concernes' => ['required', 'array', 'min:1'],
            'services_concernes.*' => ['exists:services,id_service']
        ]);

        DB::transaction(function () use ($lead, $validated) {
            $lead->update([
                'source'            => $validated['source'],
                'priorite'          => $validated['priorite'],
                'statut'            => $validated['statut'],
                'prochaine_relance' => $validated['prochaine_relance'] ? Carbon::parse($validated['prochaine_relance']) : null,
                'message_origine'   => $validated['message_origine'],
            ]);

            // Synchroniser la table associative lead_services
            $lead->services()->sync($validated['services_concernes']);
        });

        return response()->json([
            'success' => true,
            'message' => 'L\'opportunité commerciale a été modifiée avec succès.'
        ]);
    }

    /**
     * 4. Mettre à jour le statut au Glisser-Déposer (AJAX)
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
     * 5. Supprimer définitivement un Lead (Nouveau)
     */
    public function delete($id)
    {
        $lead = Lead::findOrFail($id);

        // Contrainte d'intégrité (MLD) : Empêche de supprimer un lead si un devis ou facture est rattaché
        if ($lead->devis()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer cette opportunité car un devis ou une facture y est rattaché.'
            ], 422);
        }

        DB::transaction(function () use ($lead) {
            // Nettoyage de ses liaisons
            $lead->services()->detach();
            $lead->interactions()->delete();
            $lead->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'L\'opportunité a été retirée définitivement du CRM.'
        ]);
    }

    /**
     * 6. Enregistrer une nouvelle interaction
     */
    public function storeInteraction(Request $request, $id)
    {
        $validated = $request->validate([
            'type_canal' => ['required', 'in:Appel,WhatsApp,Email,Rendez-vous,Visite_terrain,Chatbot'],
            'note'       => ['required', 'string'],
        ]);

        $lead = Lead::findOrFail($id);

        $interaction = Interaction::create([
            'id_client'   => $lead->id_client,
            'id_user'     => auth()->id(),
            'id_lead'     => $lead->id_lead,
            'type_canal'  => $validated['type_canal'],
            'date'        => now(),
            'note'        => $validated['note'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'L\'interaction a bien été ajoutée au journal du prospect.',
            'interaction' => [
                'type_canal' => str_replace('_', ' ', $interaction->type_canal),
                'note'       => $interaction->note,
                'date'       => $interaction->date->format('d/m/Y H:i'),
                'user_name'  => auth()->user()->prenom_user . ' ' . auth()->user()->nom_user
            ]
        ]);
    }

    /**
     * 7. API de détails d'un lead
     */
    public function getDetails($id)
    {
        $lead = Lead::with(['client', 'services', 'interactions.user'])->findOrFail($id);

        return response()->json([
            'id_lead'          => $lead->id_lead,
            'id_client'        => $lead->id_client,
            'client_prenom'    => $lead->client->prenom,
            'client_nom'       => $lead->client->nom,
            'client_telephone' => $lead->client->telephone,
            'client_email'     => $lead->client->email ?? 'Aucun email renseigné',
            'message_origine'  => $lead->message_origine ?? '',
            'statut'           => $lead->statut,
            'priorite'         => $lead->priorite,
            'source'           => $lead->source,
            'prochaine_relance'=> $lead->prochaine_relance ? $lead->prochaine_relance->format('Y-m-d\TH:i') : '',
            'cree_le'          => $lead->created_at->format('d/m/Y'),
            'services'         => $lead->services->map(function ($service) {
                return [
                    'id_service'  => $service->id_service,
                    'nom_service' => $service->nom_service
                ];
            }),
            'interactions'     => $lead->interactions->sortByDesc('date')->values()->map(function ($interaction) {
                return [
                    'type_canal' => str_replace('_', ' ', $interaction->type_canal),
                    'note'       => $interaction->note,
                    'date'       => $interaction->date->format('d/m/Y H:i'),
                    'user_name'  => $interaction->user->prenom_user . ' ' . $interaction->user->nom_user
                ];
            })
        ]);
    }

    /**
     * 8. Exportation au format CSV
     */
    public function export()
    {
        $leads = Lead::with(['client', 'services'])->latest()->get();
        $fileName = 'leads_export_' . Carbon::now()->format('Y_m_d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($leads) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['Client', 'Téléphone', 'Statut', 'Priorité', 'Source', 'Services', 'Date création', 'Prochaine relance', 'Message'], ';');

            foreach ($leads as $lead) {
                fputcsv($file, [
                    $lead->client->prenom . ' ' . $lead->client->nom,
                    $lead->client->telephone,
                    str_replace('_', ' ', $lead->statut),
                    $lead->priorite,
                    str_replace('_', ' ', $lead->source),
                    $lead->services->pluck('nom_service')->join(', '),
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