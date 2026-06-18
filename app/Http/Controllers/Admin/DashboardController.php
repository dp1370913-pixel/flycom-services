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
    public function index()
    {
        // 1. Calculs des KPIs en temps réel depuis MySQL (Module M5)
        $leadsDuJour = Lead::whereDate('created_at', Carbon::today())->count();
        $leadsActifs = Lead::whereNotIn('statut', ['Gagne', 'Perdu'])->count();
        $clientsActifs = Client::where('type_contact', 'Client')->count();
        $caEstimeMois = Devis::where('statut', 'Accepte')->sum('montant_ttc');

        // 2. Récupérer les 5 opportunités les plus récentes
        $leadsRecents = Lead::with('client')->latest()->take(5)->get();

        // 3. Récupérer les relances programmées pour aujourd'hui
        $relancesDuJour = Lead::with('client')
            ->whereDate('prochaine_relance', Carbon::today())
            ->whereNotIn('statut', ['Gagne', 'Perdu'])
            ->get();

        // 4. Récupérer les devis en attente depuis plus de 7 jours
        $devisEnAttente = Devis::with('client')
            ->where('statut', 'En_attente')
            ->where('created_at', '<=', Carbon::now()->subDays(7))
            ->get();

        // 5. PRÉ-CALCULS DES SÉRIES POUR LES 3 PÉRIODES DU GRAPHIQUE DONUT (M5)
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

        // 6. PRÉ-CALCULS DES SÉRIES POUR LES 3 PÉRIODES DU GRAPHIQUE LINÉAIRE
        $lineDatasets = [
            7 => [
                'labels' => [],
                'created' => [],
                'won' => []
            ],
            30 => [
                'labels' => [],
                'created' => [],
                'won' => []
            ],
            90 => [
                'labels' => [],
                'created' => [],
                'won' => []
            ]
        ];

        // 7 jours (Détail journalier)
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $lineDatasets[7]['labels'][] = $date->translatedFormat('D d');
            $lineDatasets[7]['created'][] = Lead::whereDate('created_at', $date)->count();
            $lineDatasets[7]['won'][] = Lead::where('statut', 'Gagne')->whereDate('created_at', $date)->count();
        }

        // 30 jours (Détail hebdomadaire sur 5 semaines)
        for ($i = 4; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
            $lineDatasets[30]['labels'][] = 'Sem ' . (5 - $i);
            $lineDatasets[30]['created'][] = Lead::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $lineDatasets[30]['won'][] = Lead::where('statut', 'Gagne')->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        }

        // 3 mois (Détail mensuel sur 3 mois)
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
}