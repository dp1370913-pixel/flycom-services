<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Interaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AgendaController extends Controller
{
    // 1. Afficher le calendrier et les listes de relances (Image 18)
    public function index(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $currentMonthDate = Carbon::createFromDate($year, $month, 1);

        $activeLeads = Lead::with('client')
            ->whereNotIn('statut', ['Gagne', 'Perdu'])
            ->get();

        $relancesDuMois = Lead::with('client')
            ->whereYear('prochaine_relance', $year)
            ->whereMonth('prochaine_relance', $month)
            ->whereNotIn('statut', ['Gagne', 'Perdu'])
            ->get();

        $relancesEnRetard = Lead::with('client')
            ->where('prochaine_relance', '<', Carbon::now())
            ->whereNotIn('statut', ['Gagne', 'Perdu'])
            ->orderBy('prochaine_relance', 'asc')
            ->get();

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

    // 2. Enregistrer ou mettre à jour la date de relance d'un prospect
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_lead'       => ['required', 'exists:leads,id_lead'],
            'date_relance'  => ['required', 'date'],
            'heure_relance' => ['required', 'string'],
            'note'          => ['nullable', 'string', 'max:500']
        ]);

        $dateTimeString = $validated['date_relance'] . ' ' . $validated['heure_relance'];
        $prochaineRelance = Carbon::parse($dateTimeString);

        $lead = Lead::findOrFail($validated['id_lead']);
        $lead->prochaine_relance = $prochaineRelance;
        
        if ($validated['note']) {
            $lead->message_origine = ($lead->message_origine ? $lead->message_origine . "\n" : "") . "[Note de relance] " . $validated['note'];
        }
        $lead->save();

        return redirect()->route('admin.agenda.index')->with('success', 'La relance a bien été planifiée dans votre agenda.');
    }

    // 3. Clôturer une relance en retard (Fait - Nouveau - 100% opérationnel)
    public function complete($id)
    {
        $lead = Lead::findOrFail($id);
        
        DB::transaction(function () use ($lead) {
            // Créer une interaction automatique pour conserver la traçabilité de l'appel (M3/MLD)
            Interaction::create([
                'id_client'   => $lead->id_client,
                'id_user'     => auth()->id(),
                'id_lead'     => $lead->id_lead,
                'type_canal'  => 'Appel',
                'date'        => now(),
                'note'        => 'Relance téléphonique d\'agenda effectuée. Tâche marquée comme terminée par le CRM.',
            ]);

            // Effacer la date de prochaine relance car traitée
            $lead->prochaine_relance = null;
            $lead->save();
        });

        return response()->json([
            'success' => true,
            'message' => 'La relance avec ' . $lead->client->prenom . ' ' . $lead->client->nom . ' a été marquée comme terminée.'
        ]);
    }

    // 4. Reporter une relance à demain à la même heure (Demain - Nouveau - 100% opérationnel)
    public function postpone($id)
    {
        $lead = Lead::findOrFail($id);

        // Reporter à demain à la même heure
        $lead->prochaine_relance = Carbon::now()->addDay();
        $lead->save();

        return response()->json([
            'success' => true,
            'message' => 'La relance avec ' . $lead->client->prenom . ' ' . $lead->client->nom . ' a bien été reportée à demain.'
        ]);
    }
}