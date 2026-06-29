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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class DevisController extends Controller
{
    // 1. Afficher l'index des devis et factures (Image 1)
    public function index()
    {
        $clients = Client::orderBy('nom')->get();
        $leads = Lead::with('client')->where('statut', 'Negociation')->get();
        $services = Service::where('actif', true)->orderBy('nom_service')->get();
        
        $devisList = Devis::with(['client', 'lead'])->latest()->get();

        // Calcul du prochain numéro de devis automatique via le helper résistant aux collisions
        $nextNumber = $this->generateNextNumber('Devis');

        return view('admin.devis.index', compact('clients', 'leads', 'services', 'devisList', 'nextNumber'));
    }

    // 2. Traiter la génération d'un devis (Image 3)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_client'         => ['required', 'exists:clients,id_client'],
            'id_lead'           => ['nullable', 'exists:leads,id_lead'],
            'id_lead_fallback'  => ['nullable', 'exists:leads,id_lead'],
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

            // Génération du numéro via le helper robuste (résout la collision)
            $docNumber = $this->generateNextNumber($validated['type']);

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

            // Enregistrement des lignes d'articles avec Snapshots d'intégrité
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

            // Génération automatique du PDF et stockage physique
            $pdf = Pdf::loadView('admin.devis.pdf_template', compact('devis'));
            $filename = 'devis/' . $devis->numero . '.pdf';
            Storage::disk('public')->put($filename, $pdf->output());

            $devis->fichier_pdf = $filename;
            $devis->save();
        });

        return redirect()->route('admin.devis.index')->with('success', 'Le document commercial a bien été généré.');
    }

    // 3. Convertir un Devis accepté en Facture Proforma en 1 clic
    public function convertToInvoice($id)
    {
        $devis = Devis::findOrFail($id);
        
        if ($devis->type === 'Devis') {
            DB::transaction(function () use ($devis) {
                $devis->type = 'Facture_proforma';
                $devis->numero = str_replace('DEV-', 'FAC-', $devis->numero);
                $devis->save();

                // Régénérer le fichier PDF avec le nouveau type et numéro
                $pdf = Pdf::loadView('admin.devis.pdf_template', compact('devis'));
                $filename = 'devis/' . $devis->numero . '.pdf';
                Storage::disk('public')->put($filename, $pdf->output());

                $devis->fichier_pdf = $filename;
                $devis->save();
            });
            return response()->json(['success' => true, 'message' => "Le devis {$devis->numero} a bien été converti en Facture Proforma."]);
        }

        return response()->json(['success' => false, 'message' => "Ce document n'est pas un devis."]);
    }

    // 4. Télécharger directement le fichier PDF depuis le CRM (Image 2)
    public function downloadPDF($id)
    {
        $devis = Devis::findOrFail($id);

        if (!$devis->fichier_pdf || !Storage::disk('public')->exists($devis->fichier_pdf)) {
            $pdf = Pdf::loadView('admin.devis.pdf_template', compact('devis'));
            $filename = 'devis/' . $devis->numero . '.pdf';
            Storage::disk('public')->put($filename, $pdf->output());
            
            $devis->fichier_pdf = $filename;
            $devis->save();
        }

        return Storage::disk('public')->download($devis->fichier_pdf);
    }

    // 5. Imprimer (Format HTML natif)
    public function printPDF($id)
    {
        $devis = Devis::with(['client', 'services'])->findOrFail($id);
        return view('admin.devis.print', compact('devis'));
    }

    // 6. API de détails d'une pièce comptable pour le modal de détails (Image 2)
    public function getDetails($id)
    {
        $devis = Devis::with(['client', 'services'])->findOrFail($id);

        return response()->json([
            'id_devis'         => $devis->id_devis,
            'numero'           => $devis->numero,
            'statut'           => $devis->statut,
            'statut_paiement'  => $devis->statut_paiement,
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

    // 7. Action AJAX : Traiter l'envoi d'e-mail du second modal (Image 2)
    public function sendEmail(Request $request, $id)
    {
        $validated = $request->validate([
            'destinataire' => ['required', 'email'],
            'objet'        => ['required', 'string', 'max:255'],
            'message'      => ['required', 'string'],
        ]);

        $devis = Devis::with(['client', 'services'])->findOrFail($id);
        
        if (!$devis->fichier_pdf || !Storage::disk('public')->exists($devis->fichier_pdf)) {
            $pdf = Pdf::loadView('admin.devis.pdf_template', compact('devis'));
            $filename = 'devis/' . $devis->numero . '.pdf';
            Storage::disk('public')->put($filename, $pdf->output());
            
            $devis->fichier_pdf = $filename;
            $devis->save();
        }

        $pdfPath = Storage::disk('public')->path($devis->fichier_pdf);

        Mail::send([], [], function ($message) use ($validated, $devis, $pdfPath) {
            $message->to($validated['destinataire'])
                    ->subject($validated['objet'])
                    ->html($validated['message'])
                    ->attach($pdfPath, [
                        'as' => $devis->numero . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
        });

        return response()->json([
            'success' => true,
            'message' => "Le document commercial {$devis->numero} a été envoyé avec succès à l'adresse {$validated['destinataire']}."
        ]);
    }

    // 8. Action AJAX : Mettre à jour le statut du Devis et appliquer les contraintes MLD (Image 2)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'statut' => ['required', 'in:En_attente,Accepte,Refuse,Expire']
        ]);

        $devis = Devis::findOrFail($id);
        $crm_notification = null;

        DB::transaction(function () use ($request, $devis, &$crm_notification) {
            $devis->statut = $request->input('statut');
            
            if ($devis->statut === 'Accepte') {
                $devis->statut_paiement = 'Acompte_recu';
            }
            $devis->save();

            if ($devis->statut === 'Accepte') {
                if ($devis->id_lead) {
                    $lead = $devis->lead;
                    $lead->statut = 'Gagne';
                    $lead->save();
                }

                $client = $devis->client;
                $client->type_contact = 'Client';
                $client->save();

                $crm_notification = "Lead lié passé à 'Gagné' et client passé à 'Client'";
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Le statut du document a bien été mis à jour.',
            'crm_action' => $crm_notification
        ]);
    }

    // 9. Dupliquer un document commercial existant
    public function duplicate($id)
    {
        $original = Devis::findOrFail($id);
        $duplicate = null;

        DB::transaction(function () use ($original, &$duplicate) {
            $duplicate = $original->replicate();
            
            // Génération du numéro de doublon via le helper
            $duplicate->numero = $this->generateNextNumber($original->type);
            
            $duplicate->date_emission = Carbon::today();
            $duplicate->date_expiration = Carbon::today()->addDays(30);
            $duplicate->statut = 'En_attente';
            $duplicate->statut_paiement = 'Non_paye';
            $duplicate->fichier_pdf = null;
            $duplicate->save();

            // Cloner l'ensemble des lignes d'articles associées
            foreach ($original->services as $service) {
                $duplicate->services()->attach($service->id_service, [
                    'quantite'               => $service->pivot->quantite,
                    'prix_unitaire'          => $service->pivot->prix_unitaire,
                    'nom_service_snapshot'   => $service->pivot->nom_service_snapshot,
                    'description_snapshot'   => $service->pivot->description_snapshot,
                ]);
            }

            // Génération de son fichier PDF spécifique
            $pdf = Pdf::loadView('admin.devis.pdf_template', ['devis' => $duplicate]);
            $filename = 'devis/' . $duplicate->numero . '.pdf';
            Storage::disk('public')->put($filename, $pdf->output());

            $duplicate->fichier_pdf = $filename;
            $duplicate->save();
        });

        return response()->json([
            'success' => true,
            'message' => "Le document {$original->numero} a bien été dupliqué sous la référence {$duplicate->numero}."
        ]);
    }

    // 10. Action AJAX : Supprimer un devis du CRM
    public function delete($id)
    {
        $devis = Devis::findOrFail($id);
        $numero = $devis->numero;
        
        DB::transaction(function () use ($devis) {
            if ($devis->fichier_pdf) {
                Storage::disk('public')->delete($devis->fichier_pdf);
            }
            $devis->delete();
        });

        return response()->json([
            'success' => true,
            'message' => "Le document {$numero} a bien été supprimé du CRM."
        ]);
    }

    /**
     * Génère le prochain numéro de devis ou facture de manière incrémentale et sécurisée.
     *
     * @param string $type ('Devis' ou 'Facture_proforma')
     * @param int|null $year
     * @return string
     */
    private function generateNextNumber(string $type, ?int $year = null): string
    {
        $year = $year ?? Carbon::now()->year;
        $docPrefix = $type === 'Devis' ? 'DEV-' : 'FAC-';

        // Cherche le document ayant le numéro le plus élevé pour ce préfixe et cette année
        $maxNumero = Devis::whereYear('created_at', $year)
            ->where('numero', 'like', $docPrefix . $year . '-%')
            ->orderBy('numero', 'desc')
            ->first();

        $nextSequence = 1;

        if ($maxNumero) {
            $parts = explode('-', $maxNumero->numero);
            if (count($parts) === 3) {
                // Extrait l'identifiant (ex: '0040' devient 40) et ajoute 1
                $nextSequence = ((int) $parts[2]) + 1;
            }
        }

        return $docPrefix . $year . '-' . str_pad($nextSequence, 4, '0', STR_PAD_LEFT);
    }
}