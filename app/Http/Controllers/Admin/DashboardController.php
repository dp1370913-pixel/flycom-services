<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Client;
use App\Models\Devis;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // 1. Afficher l'index du Dashboard (Module M5)
    public function index()
    {
        $leadsDuJour = Lead::whereDate('created_at', Carbon::today())->count();
        $leadsActifs = Lead::whereNotIn('statut', ['Gagne', 'Perdu'])->count();
        $clientsActifs = Client::where('type_contact', 'Client')->count();
        $caEstimeMois = Devis::where('statut', 'Accepte')->sum('montant_ttc');

        $leadsRecents = Lead::with('client')->latest()->take(5)->get();

        $relancesDuJour = Lead::with('client')
            ->whereDate('prochaine_relance', Carbon::today())
            ->whereNotIn('statut', ['Gagne', 'Perdu'])
            ->get();

        $devisEnAttente = Devis::with('client')
            ->where('statut', 'En_attente')
            ->where('created_at', '<=', Carbon::now()->subDays(7))
            ->get();

        // Séries Donut Chart
        $periods = [7, 30, 90];
        $donutDatasets = [];

        foreach ($periods as $days) {
            $counts = Lead::select('source', DB::raw('count(*) as total'))
                ->where('created_at', '>=', Carbon::now()->subDays($days))
                ->groupBy('source')
                ->pluck('total', 'source')
                ->toArray();

            $donutDatasets[$days] = [
                $counts['Appel_direct'] ?? 0,
                $counts['Recommandation'] ?? 0,
                $counts['Site_web'] ?? 0,
                $counts['WhatsApp'] ?? 0,
            ];
        }

        // Séries Line Chart
        $lineDatasets = [
            7 => ['labels' => [], 'created' => [], 'won' => []],
            30 => ['labels' => [], 'created' => [], 'won' => []],
            90 => ['labels' => [], 'created' => [], 'won' => []]
        ];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $lineDatasets[7]['labels'][] = $date->translatedFormat('D d');
            $lineDatasets[7]['created'][] = Lead::whereDate('created_at', $date)->count();
            $lineDatasets[7]['won'][] = Lead::where('statut', 'Gagne')->whereDate('created_at', $date)->count();
        }

        for ($i = 4; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
            $lineDatasets[30]['labels'][] = 'Sem ' . (5 - $i);
            $lineDatasets[30]['created'][] = Lead::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $lineDatasets[30]['won'][] = Lead::where('statut', 'Gagne')->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        }

        for ($i = 2; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $lineDatasets[90]['labels'][] = $date->translatedFormat('F');
            $lineDatasets[90]['created'][] = Lead::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count();
            $lineDatasets[90]['won'][] = Lead::where('statut', 'Gagne')->whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count();
        }

        return view('admin.dashboard', compact(
            'leadsDuJour',
            'leadsActifs',
            'clientsActifs',
            'caEstimeMois',
            'leadsRecents',
            'relancesDuJour',
            'devisEnAttente',
            'donutDatasets',
            'lineDatasets'
        ));
    }

    // 2. API d'obtention dynamique des notifications (M5)
    public function getNotifications()
    {
        $notifications = [];

        $overdueLeads = Lead::with('client')
            ->where('prochaine_relance', '<', now())
            ->whereNotIn('statut', ['Gagne', 'Perdu'])
            ->latest()
            ->take(3)
            ->get();

        foreach ($overdueLeads as $lead) {
            $notifications[] = [
                'title'   => 'Relance commerciale urgente !',
                'message' => 'Contacter le prospect ' . $lead->client->prenom . ' ' . $lead->client->nom . ' (' . $lead->client->telephone . ')',
                'time'    => $lead->prochaine_relance->diffForHumans(),
                'icon'    => 'bi-telephone-fill text-danger',
                'link'    => route('admin.leads.index') . '?search=' . urlencode($lead->client->nom)
            ];
        }

        $newLeads = Lead::with('client')
            ->where('statut', 'Nouveau')
            ->latest()
            ->take(3)
            ->get();

        foreach ($newLeads as $lead) {
            $notifications[] = [
                'title'   => 'Nouveau prospect entrant',
                'message' => $lead->client->prenom . ' ' . $lead->client->nom . ' : ' . ($lead->message_origine ?? 'Pas de message de description.'),
                'time'    => $lead->created_at->diffForHumans(),
                'icon'    => 'bi-person-plus-fill text-primary',
                'link'    => route('admin.leads.index')
            ];
        }

        $oldDevis = Devis::with('client')
            ->where('statut', 'En_attente')
            ->where('created_at', '<', now()->subDays(7))
            ->latest()
            ->take(2)
            ->get();

        foreach ($oldDevis as $devis) {
            $notifications[] = [
                'title'   => 'Devis en attente d\'approbation',
                'message' => 'Le document ' . $devis->numero . ' pour ' . $devis->client->prenom . ' ' . $devis->client->nom . ' est en attente depuis +7 jours.',
                'time'    => $devis->created_at->diffForHumans(),
                'icon'    => 'bi-file-earmark-exclamation-fill text-warning',
                'link'    => route('admin.devis.index')
            ];
        }

        return response()->json([
            'success'       => true,
            'count'         => count($notifications),
            'notifications' => $notifications
        ]);
    }

    /**
     * 3. API de recherche globale unifiée (Clients, Leads, Devis - Nouveau)
     */
    public function globalSearch(Request $request)
    {
        $query = $request->input('query');
        if (strlen($query) < 2) {
            return response()->json(['success' => true, 'results' => []]);
        }

        $results = [];

        // Recherche 1 : Les Clients
        $clients = Client::where('nom', 'like', "%{$query}%")
            ->orWhere('prenom', 'like', "%{$query}%")
            ->orWhere('telephone', 'like', "%{$query}%")
            ->take(3)
            ->get();

        foreach ($clients as $client) {
            $results[] = [
                'title'    => $client->prenom . ' ' . $client->nom,
                'category' => 'Contact Client',
                'meta'     => $client->telephone . ' · ' . ($client->email ?? 'Pas d\'email'),
                'link'     => route('admin.clients.index') . '?search=' . urlencode($client->nom),
                'icon'     => 'bi-people-fill text-primary'
            ];
        }

        // Recherche 2 : Les Leads (Opportunités)
        $leads = Lead::whereHas('client', function ($q) use ($query) {
            $q->where('nom', 'like', "%{$query}%")
              ->orWhere('prenom', 'like', "%{$query}%");
        })->orWhere('message_origine', 'like', "%{$query}%")
          ->with('client')
          ->take(3)
          ->get();

        foreach ($leads as $lead) {
            $results[] = [
                'title'    => $lead->client->prenom . ' ' . $lead->client->nom,
                'category' => 'Opportunité — ' . str_replace('_', ' ', $lead->statut),
                'meta'     => $lead->message_origine ?? 'Pas de description.',
                'link'     => route('admin.leads.index') . '?search=' . urlencode($lead->client->nom),
                'icon'     => 'bi-kanban-fill text-warning'
            ];
        }

        // Recherche 3 : Devis et Factures proforma
        $devisList = Devis::where('numero', 'like', "%{$query}%")
            ->orWhereHas('client', function ($q) use ($query) {
                $q->where('nom', 'like', "%{$query}%")
                  ->orWhere('prenom', 'like', "%{$query}%");
            })->with('client')
            ->take(3)
            ->get();

        foreach ($devisList as $devis) {
            $results[] = [
                'title'    => $devis->numero . ' — ' . str_replace('_', ' ', $devis->type),
                'category' => 'Pièce Comptable',
                'meta'     => $devis->client->prenom . ' ' . $devis->client->nom . ' (' . number_format($devis->montant_ttc, 0, ',', ' ') . ' F)',
                'link'     => route('admin.devis.index'),
                'icon'     => 'bi-file-earmark-pdf-fill text-danger'
            ];
        }

        return response()->json([
            'success' => true,
            'results' => $results
        ]);
    }
}