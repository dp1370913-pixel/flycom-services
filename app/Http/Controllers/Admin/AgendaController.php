<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use Carbon\Carbon;

class AgendaController extends Controller
{
    // 1. Afficher le calendrier et les listes de relances (Image 18)
    public function index(Request $request)
    {
        // On récupère le mois et l'année demandés (par défaut le mois actuel)
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $currentMonthDate = Carbon::createFromDate($year, $month, 1);

        // Récupération de tous les leads actifs pour alimenter le modal de programmation (M3)
        $activeLeads = Lead::with('client')
            ->whereNotIn('statut', ['Gagne', 'Perdu'])
            ->get();

        // Récupération des relances du mois sélectionné pour alimenter les cases du calendrier
        $relancesDuMois = Lead::with('client')
            ->whereYear('prochaine_relance', $year)
            ->whereMonth('prochaine_relance', $month)
            ->whereNotIn('statut', ['Gagne', 'Perdu'])
            ->get();

        // Récupération des relances en retard (Date de relance dépassée et prospect non signé/perdu - Image 18)
        $relancesEnRetard = Lead::with('client')
            ->where('prochaine_relance', '<', Carbon::now())
            ->whereNotIn('statut', ['Gagne', 'Perdu'])
            ->orderBy('prochaine_relance', 'asc')
            ->get();

        // Récupération des relances prévues pour la semaine en cours
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $relancesDeLaSemaine = Lead::with('client')
            ->whereBetween('prochaine_relance', [$startOfWeek, $endOfWeek])
            ->orderBy('prochaine_relance', 'asc')
            ->get();

        return view('admin.agenda.index', compact(
            'activeLeads',
            'relancesDuMois',
            'relancesEnRetard',
            'relancesDeLaSemaine',
            'currentMonthDate',
            'month',
            'year'
        ));
    }

    // 2. Enregistrer ou mettre à jour la date de relance d'un prospect (Image 17)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_lead'       => ['required', 'exists:leads,id_lead'],
            'date_relance'  => ['required', 'date'],
            'heure_relance' => ['required', 'string'],
            'note'          => ['nullable', 'string', 'max:500']
        ]);

        // Fusionner la date et l'heure pour former un DATETIME complet conforme (MLD)
        $dateTimeString = $validated['date_relance'] . ' ' . $validated['heure_relance'];
        $prochaineRelance = Carbon::parse($dateTimeString);

        // Mise à jour de la date de relance sur le lead concerné
        $lead = Lead::findOrFail($validated['id_lead']);
        $lead->prochaine_relance = $prochaineRelance;
        
        // Facultatif : enregistrer une note mémo ou mettre à jour le message d'origine
        if ($validated['note']) {
            $lead->message_origine = ($lead->message_origine ? $lead->message_origine . "\n" : "") . "[Note de relance] " . $validated['note'];
        }
        $lead->save();

        return redirect()->route('admin.agenda.index')->with('success', 'La relance a bien été planifiée dans votre agenda.');
    }
}