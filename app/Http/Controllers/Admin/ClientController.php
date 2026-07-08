<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ClientController extends Controller
{
    /**
     * 1. Afficher l'interface de gestion de vos clients
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $typeFilter = $request->input('type');

        $query = Client::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%");
            });
        }

        if ($typeFilter && $typeFilter !== 'all') {
            $query->where('type_contact', $typeFilter);
        }

        $clients = $query->latest()->get();

        return view('admin.clients.index', compact('clients', 'search', 'typeFilter'));
    }

    /**
     * 2. Création manuelle d'un nouveau client
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prenom'       => ['required', 'string', 'max:100'],
            'nom'          => ['required', 'string', 'max:100'],
            'telephone'    => ['required', 'string', 'max:20', 'unique:clients,telephone'],
            'email'        => ['nullable', 'email', 'max:150'],
            'entreprise'   => ['nullable', 'string', 'max:150'],
            'adresse'      => ['nullable', 'string'],
            'type_contact' => ['required', 'in:Prospect,Client,Partenaire'],
            'notes'        => ['nullable', 'string'],
        ]);

        Client::create($validated);

        return redirect()->route('admin.clients.index')->with('success', 'La fiche client a bien été créée.');
    }

    /**
     * 3. API pour obtenir les détails d'un client au clic sur "Modifier" (Nouveau)
     */
    public function getDetails($id)
    {
        $client = Client::findOrFail($id);
        return response()->json([
            'success' => true,
            'client'  => $client
        ]);
    }

    /**
     * 4. Enregistrer les modifications de la fiche client (Nouveau)
     */
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $validated = $request->validate([
            'prenom'       => ['required', 'string', 'max:100'],
            'nom'          => ['required', 'string', 'max:100'],
            'telephone'    => ['required', 'string', 'max:20', Rule::unique('clients', 'telephone')->ignore($client->id_client, 'id_client')],
            'email'        => ['nullable', 'email', 'max:150'],
            'entreprise'   => ['nullable', 'string', 'max:150'],
            'adresse'      => ['nullable', 'string'],
            'type_contact' => ['required', 'in:Prospect,Client,Partenaire'],
            'notes'        => ['nullable', 'string'],
        ]);

        $client->update($validated);

        return redirect()->route('admin.clients.index')->with('success', 'La fiche client a bien été mise à jour.');
    }

    /**
     * 5. Supprimer définitivement un client (Nouveau)
     */
    public function delete($id)
    {
        $client = Client::findOrFail($id);

        // Contrainte d'intégrité stricte (MLD) : Empêche la suppression si le client est rattaché à des devis/factures émis (sécurité financière)
        if ($client->devis()->exists()) {
            return redirect()->route('admin.clients.index')->with('error', 'Impossible de supprimer ce client car des devis ou factures y sont rattachés. Vous pouvez modifier ses informations ou le conserver tel quel.');
        }

        // Supprimer en cascade ses opportunités d'affaires (Leads) rattachées (ON DELETE CASCADE)
        $client->leads()->each(function ($lead) {
            $lead->services()->detach(); // Nettoie la table de liaison lead_services
            $lead->delete();
        });

        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Le client et ses opportunités rattachées ont été supprimés du CRM.');
    }

    /**
     * 6. Traiter l'importation de fichiers CSV
     */
    public function importCSV(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:2048']
        ]);

        $file = $request->file('csv_file');
        $filePath = $file->getRealPath();

        if (($handle = fopen($filePath, 'r')) !== false) {
            $bom = fread($handle, 3);
            if ($bom !== "\xEF\xBB\xBF") {
                rewind($handle);
            }

            fgetcsv($handle, 1000, ';'); // Saute les en-têtes

            while (($row = fgetcsv($handle, 1000, ';')) !== false) {
                if (count($row) < 3) continue;

                $prenom = trim($row[0] ?? '');
                $nom = trim($row[1] ?? '');
                $telephone = trim($row[2] ?? '');
                $email = trim($row[3] ?? null);
                $entreprise = trim($row[4] ?? null);
                $adresse = trim($row[5] ?? null);
                $type = trim($row[6] ?? 'Prospect');

                Client::updateOrCreate(
                    ['telephone' => $telephone],
                    [
                        'prenom'       => $prenom,
                        'nom'          => $nom,
                        'email'        => $email !== '' ? $email : null,
                        'entreprise'   => $entreprise !== '' ? $entreprise : null,
                        'adresse'      => $adresse !== '' ? $adresse : null,
                        'type_contact' => in_array($type, ['Prospect', 'Client', 'Partenaire']) ? $type : 'Prospect',
                    ]
                );
            }
            fclose($handle);
        }

        return redirect()->route('admin.clients.index')->with('success', 'L\'importation du fichier de contacts s\'est exécutée avec succès.');
    }

    /**
     * 7. Exportation au format CSV
     */
    public function export()
    {
        $clients = Client::latest()->get();
        $fileName = 'clients_export_' . Carbon::now()->format('Y_m_d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($clients) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['Prénom', 'Nom', 'Téléphone', 'Email', 'Entreprise', 'Adresse', 'Type', 'Notes', 'Depuis'], ';');

            foreach ($clients as $client) {
                fputcsv($file, [
                    $client->prenom,
                    $client->nom,
                    $client->telephone,
                    $client->email ?? '-',
                    $client->entreprise ?? '—',
                    $client->adresse ?? '',
                    $client->type_contact,
                    $client->notes ?? '',
                    $client->created_at->format('d/m/Y')
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}