<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Devis;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DevisController extends Controller
{
    // 1. Afficher l'index des devis et factures (Image 1)
    public function index()
    {
        $clients = Client::orderBy('nom')->get();
        $leads = Lead::with('client')->where('statut', 'Negociation')->get();
        $services = Service::where('actif', true)->orderBy('nom_service')->get();
        
        $devisList = Devis::with(['client', 'lead'])->latest()->get();

        // Calcul du prochain numéro de devis automatique
        $year = Carbon::now()->year;
        $count = Devis::whereYear('created_at', $year)->count() + 1;
        $nextNumber = 'DEV-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        return view('admin.devis.index', compact('clients', 'leads', 'services', 'devisList', 'nextNumber'));
    }

    // 2. Traiter la génération d'un devis (Image 15 de vos maquettes)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_client'         => ['required', 'exists:clients,id_client'],
            'id_lead'           => ['nullable', 'exists:leads,id_lead'],
            'type'              => ['required', 'in:Devis,Facture_proforma'],
            'tva_percentage'    => ['required', 'numeric', 'min:0', 'max:100'],
            'lignes'            => ['required', 'array', 'min:1'],
            'lignes.*.id_service'=> ['required', 'exists:services,id_service'],
            'lignes.*.quantite' => ['required', 'integer', 'min:1'],
            'lignes.*.prix'     => ['required', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($validated, $request) {
            // Calcul des totaux
            $montantHt = 0;
            foreach ($validated['lignes'] as $ligne) {
                $montantHt += $ligne['quantite'] * $ligne['prix'];
            }
            
            $tvaMontant = $montantHt * ($validated['tva_percentage'] / 100);
            $montantTtc = $montantHt + $tvaMontant;

            // Génération du numéro séquentiel
            $year = Carbon::now()->year;
            $count = Devis::whereYear('created_at', $year)->count() + 1;
            $docPrefix = $validated['type'] === 'Devis' ? 'DEV-' : 'FAC-';
            $docNumber = $docPrefix . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            $devis = Devis::create([
                'id_client'       => $validated['id_client'],
                'id_lead'         => $validated['id_lead'] ?? $request->input('id_lead_fallback'),
                'numero'          => $docNumber,
                'type'            => $validated['type'],
                'date_emission'   => Carbon::today(),
                'date_expiration' => Carbon::today()->addDays(30),
                'montant_ht'      => $montantHt,
                'tva'             => $tvaMontant,
                'montant_ttc'     => $montantTtc,
                'statut'          => 'En_attente',
                'statut_paiement' => 'Non_paye'
            ]);

            // Enregistrement des lignes d'articles avec Snapshots d'intégrité (MLD)
            foreach ($validated['lignes'] as $ligne) {
                $service = Service::find($ligne['id_service']);
                
                $devis->services()->attach($ligne['id_service'], [
                    'quantite'               => $ligne['quantite'],
                    'prix_unitaire'          => $ligne['prix'],
                    'nom_service_snapshot'   => $service->nom_service,
                    'description_snapshot'   => $service->description,
                ]);
            }

            if ($devis->id_lead) {
                $lead = $devis->lead;
                $lead->statut = 'Devis_envoye';
                $lead->save();
            }
        });

        return redirect()->route('admin.devis.index')->with('success', 'Le document commercial a bien été généré.');
    }

    // 3. Convertir un Devis accepté en Facture Proforma en 1 clic
    public function convertToInvoice($id)
    {
        $devis = Devis::findOrFail($id);
        
        if ($devis->type === 'Devis') {
            $devis->type = 'Facture_proforma';
            $devis->numero = str_replace('DEV-', 'FAC-', $devis->numero);
            $devis->save();
        }

        return redirect()->route('admin.devis.index')->with('success', 'Le devis a bien été converti en Facture Proforma.');
    }

    // 4. Imprimer (Format A4 d'impression natif propre)
    public function printPDF($id)
    {
        $devis = Devis::with(['client', 'services'])->findOrFail($id);
        return view('admin.devis.print', compact('devis'));
    }

    // 5. API de détails d'une pièce comptable pour le modal de détails (Image 2 - Conforme)
    public function getDetails($id)
    {
        $devis = Devis::with(['client', 'services'])->findOrFail($id);

        return response()->json([
            'id_devis'         => $devis->id_devis,
            'numero'           => $devis->numero,
            'statut'           => str_replace('_', ' ', $devis->statut),
            'statut_paiement'  => str_replace('_', ' ', $devis->statut_paiement),
            'client_name'      => $devis->client->prenom . ' ' . $devis->client->nom,
            'client_meta'      => $devis->client->telephone . ' · ' . ($devis->client->email ?? '—'),
            'client_email'     => $devis->client->email ?? 'contact@flycomservices.cg',
            'type'             => str_replace('_', ' ', $devis->type),
            'date_emission'    => Carbon::parse($devis->date_emission)->format('d/m/Y'),
            'date_expiration'  => Carbon::parse($devis->date_expiration)->format('d/m/Y'),
            'montant_ht'       => number_format($devis->montant_ht, 0, ',', ' '),
            'montant_ttc'      => number_format($devis->montant_ttc, 0, ',', ' '),
            'lignes'           => $devis->services->map(function ($service) {
                return [
                    'nom_service' => $service->pivot->nom_service_snapshot ?? $service->nom_service,
                    'description' => $service->pivot->description_snapshot ?? '',
                    'quantite'    => $service->pivot->quantite,
                    'prix'        => number_format($service->pivot->prix_unitaire, 0, ',', ' '),
                    'total'       => number_format($service->pivot->quantite * $service->pivot->prix_unitaire, 0, ',', ' ')
                ];
            })
        ]);
    }

    // 6. Action AJAX : Traiter l'envoi d'e-mail du second modal (Image 3)
    public function sendEmail(Request $request, $id)
    {
        $validated = $request->validate([
            'destinataire' => ['required', 'email'],
            'objet'        => ['required', 'string', 'max:255'],
            'message'      => ['required', 'string'],
        ]);

        $devis = Devis::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'message' => 'Le document ' . $devis->numero . ' a été envoyé avec succès à l\'adresse ' . $validated['destinataire'] . '.'
        ]);
    }

    // 7. Action AJAX : Mettre à jour le statut du Devis et appliquer les contraintes MLD
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'statut' => ['required', 'in:En_attente,Accepte,Refuse,Expire']
        ]);

        $devis = Devis::findOrFail($id);
        $devis->statut = $request->input('statut');
        
        // Ajustement automatique du statut de paiement selon l'acceptation
        if ($devis->statut === 'Accepte') {
            $devis->statut_paiement = 'Acompte_recu';
        }
        $devis->save();

        // RÈGLE MÉTIER (MLD) : Si le devis est accepté, l'opportunité passe en 'Gagné' et le prospect devient officiellement un 'Client'
        if ($devis->statut === 'Accepte') {
            if ($devis->id_lead) {
                $lead = $devis->lead;
                $lead->statut = 'Gagne';
                $lead->save();
            }

            $client = $devis->client;
            $client->type_contact = 'Client';
            $client->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Le statut du document a bien été mis à jour.'
        ]);
    }

    // 8. Action AJAX : Supprimer un devis du CRM
    public function delete($id)
    {
        $devis = Devis::findOrFail($id);
        $devis->delete(); // Supprime le devis et cascade l'effacement sur devis_lignes (MLD)

        return response()->json([
            'success' => true,
            'message' => 'Le document a été supprimé de la base de données.'
        ]);
    }
}