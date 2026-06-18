<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Carbon\Carbon;

class ClientController extends Controller
{
    /**
     * 1. Afficher l'interface de gestion de vos clients (Image 11 & 12)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $typeFilter = $request->input('type');

        $query = Client::query();

        // Filtrage par nom ou prénom (Recherche en temps réel)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%");
            });
        }

        // Filtrage par type de contact (Prospect, Client, Partenaire)
        if ($typeFilter && $typeFilter !== 'all') {
            $query->where('type_contact', $typeFilter);
        }

        $clients = $query->latest()->get();

        return view('admin.clients.index', compact('clients', 'search', 'typeFilter'));
    }

    /**
     * 2. Traiter la création manuelle d'un nouveau client (Image 14)
     */
    public function store(Request $request)
    {
        // Validation stricte incluant l'unicité du téléphone pour éviter de faire planter SQL (MLD)
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
     * 3. Traiter l'importation automatique de fichiers CSV (Image 13 - Logique UPSERT)
     */
    public function importCSV(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'] // Limite à 2 Mo
        ]);

        $file = $request->file('csv_file');
        $filePath = $file->getRealPath();

        // Ouverture du fichier de données
        if (($handle = fopen($filePath, 'r')) !== false) {
            
            // Ignorer le BOM UTF-8 s'il est présent
            $bom = fread($handle, 3);
            if ($bom !== "\xEF\xBB\xBF") {
                rewind($handle);
            }

            // Lecture de la ligne d'en-tête
            $header = fgetcsv($handle, 1000, ';'); // Séparateur point-virgule standard

            // Lecture ligne par ligne des clients
            while (($row = fgetcsv($handle, 1000, ';')) !== false) {
                // S'assurer que la ligne n'est pas vide et contient assez d'éléments
                if (count($row) < 3) continue;

                $prenom = trim($row[0] ?? '');
                $nom = trim($row[1] ?? '');
                $telephone = trim($row[2] ?? '');
                $email = trim($row[3] ?? null);
                $entreprise = trim($row[4] ?? null);
                $adresse = trim($row[5] ?? null);
                $type = trim($row[6] ?? 'Prospect');

                // Protection anti-doublon d'index unique (UPSERT) :
                // Si le téléphone existe, on met à jour la fiche, sinon on la crée (MLD)
                Client::updateOrCreate(
                    ['telephone' => $telephone], // Condition d'unicité
                    [
                        'prenom' => $prenom,
                        'nom' => $nom,
                        'email' => $email !== '' ? $email : null,
                        'entreprise' => $entreprise !== '' ? $entreprise : null,
                        'adresse' => $adresse !== '' ? $adresse : null,
                        'type_contact' => in_array($type, ['Prospect', 'Client', 'Partenaire']) ? $type : 'Prospect',
                    ]
                );
            }
            fclose($handle);
        }

        return redirect()->route('admin.clients.index')->with('success', 'L\'importation du fichier de contacts s\'est exécutée avec succès.');
    }

    /**
     * 4. EXPORTATION DU RÉFÉRENTIEL CLIENTS AU FORMAT CSV
     */
    public function export()
    {
        // Récupération ordonnée de tous les clients
        $clients = Client::latest()->get();

        $fileName = 'clients_export_' . Carbon::now()->format('Y_m_d') . '.csv';

        // Configuration des en-têtes HTTP pour forcer le téléchargement du fichier CSV
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($clients) {
            $file = fopen('php://output', 'w');
            
            // Injection du BOM UTF-8 indispensable pour qu'Excel ouvre directement le fichier avec les accents (é, à, etc.)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // En-têtes des colonnes de la fiche client
            fputcsv($file, [
                'Prénom', 
                'Nom', 
                'Téléphone', 
                'Email', 
                'Entreprise', 
                'Adresse', 
                'Type', 
                'Notes', 
                'Depuis'
            ], ';'); // Séparateur point-virgule pour une compatibilité Excel francophone immédiate

            // Remplissage des lignes de données
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