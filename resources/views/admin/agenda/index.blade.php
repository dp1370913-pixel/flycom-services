@extends('layouts.admin')

@section('title', 'Agenda & Relances | Flycom Services CRM')

@section('content')

@php
    // Configuration linguistique et temporelle locale (Congo-Brazzaville)
    $joursSemaine = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];

    $debutMois = $currentMonthDate->copy()->startOfMonth();
    $finMois = $currentMonthDate->copy()->endOfMonth();
    
    // Jour de la semaine du 1er jour du mois (1 = Lundi, 7 = Dimanche)
    $premierJourSemaine = $debutMois->dayOfWeekIso; 
    
    $totalJours = $currentMonthDate->daysInMonth;
    
    // Liens de navigation pour le mois précédent et suivant
    $prevMonth = $currentMonthDate->copy()->subMonth();
    $nextMonth = $currentMonthDate->copy()->addMonth();
@endphp

<!-- EN-TÊTE DE LA PAGE (Image 18) -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 animate-fade-in">
    <div>
        <h1 class="h3 fw-extrabold text-navy mb-1">Agenda &amp; Relances</h1>
        <p class="text-muted fs-8 mb-0">
            {{ $relancesDuMois->count() }} relances programmées · 
            <span class="text-danger fw-semibold">{{ $relancesEnRetard->count() }} en retard</span> · 
            {{ $relancesDeLaSemaine->count() }} cette semaine
        </p>
    </div>
    <div class="mt-3 mt-md-0">
        <button class="btn btn-cyan rounded-3 fs-8 fw-bold px-3 py-2 shadow-cyan-btn" data-bs-toggle="modal" data-bs-target="#newRelanceModal">
            <i class="bi bi-calendar-plus me-1"></i> Nouvelle relance
        </button>
    </div>
</div>

<!-- CONTAINER PRINCIPAL : CALENDRIER + COMPARTIMENT LATÉRAL -->
<div class="row g-4 animate-fade-in" style="animation-delay: 0.1s;">
    
    <!-- COLONNE DE GAUCHE : LE CALENDRIER MENSUEL (75% de largeur) -->
    <div class="col-12 col-lg-9">
        <div class="card border-0 shadow-sm p-4 bg-white rounded-4 h-100">
            
            <!-- Navigation entre les mois -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('admin.agenda.index', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}" class="btn btn-light btn-sm rounded-circle border-0" aria-label="Mois précédent">
                    <i class="bi bi-chevron-left"></i>
                </a>
                <h2 class="h5 fw-extrabold text-navy mb-0 text-capitalize">{{ $currentMonthDate->translatedFormat('F Y') }}</h2>
                <a href="{{ route('admin.agenda.index', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}" class="btn btn-light btn-sm rounded-circle border-0" aria-label="Mois suivant">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>

            <!-- Grille du calendrier -->
            <div class="table-responsive">
                <table class="table table-bordered calendar-table mb-0 text-center align-middle fs-8">
                    <thead>
                        <tr class="table-light">
                            @foreach($joursSemaine as $jour)
                            <th scope="col" class="fw-bold text-muted py-2" style="width: 14.28%;">{{ $jour }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <!-- 1. Cellules blanches de décalage pour le premier jour du mois -->
                            @for($i = 1; $i < $premierJourSemaine; $i++)
                            <td class="bg-light opacity-50 py-4" style="height: 100px;"></td>
                            @endfor

                            <!-- 2. Remplissage des jours du mois -->
                            @for($day = 1; $day <= $totalJours; $day++)
                                @php
                                    $currentDate = $currentMonthDate->copy()->day($day)->toDateString();
                                    $isToday = $currentDate === \Carbon\Carbon::today()->toDateString();
                                    
                                    // Filtrer les relances prévues pour ce jour précis
                                    $relancesCeJour = $relancesDuMois->filter(function($lead) use ($currentDate) {
                                        return $lead->prochaine_relance->toDateString() === $currentDate;
                                    });
                                @endphp

                                <td class="position-relative py-3 {{ $isToday ? 'calendar-today-cell' : '' }}" style="height: 100px; vertical-align: top;">
                                    <!-- Numéro du jour -->
                                    <span class="d-block fw-bold mb-2 {{ $isToday ? 'badge bg-cyan text-navy rounded-circle p-1 d-inline-block' : 'text-navy' }}" style="{{ $isToday ? 'width: 24px; height: 24px; line-height: 16px;' : '' }}">
                                        {{ $day }}
                                    </span>

                                    <!-- Événements / Relances du jour -->
                                    <div class="d-flex flex-column gap-1 overflow-hidden" style="max-height: 60px;">
                                        @foreach($relancesCeJour as $relance)
                                        <span class="badge bg-warning-transparent text-warning text-truncate d-block text-start fs-10 px-2 py-1 rounded-2" title="{{ $relance->client->prenom }} {{ $relance->client->nom }}">
                                            <i class="bi bi-circle-fill me-1" style="font-size: 5px;"></i> {{ $relance->client->prenom }} {{ substr($relance->client->nom, 0, 1) }}.
                                        </span>
                                        @endforeach
                                    </div>
                                </td>

                                <!-- Saut de ligne à la fin de chaque semaine (Dimanche) -->
                                @if(($day + $premierJourSemaine - 1) % 7 === 0 && $day < $totalJours)
                                </tr><tr>
                                @endif
                            @endfor

                            <!-- 3. Cellules de décalage final s'il reste des vides -->
                            @php
                                $cellulesRestantes = (7 - (($totalJours + $premierJourSemaine - 1) % 7)) % 7;
                            @endphp
                            @for($i = 0; $i < $cellulesRestantes; $i++)
                            <td class="bg-light opacity-50 py-4" style="height: 100px;"></td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- COLONNE DE DROITE : RELANCES EN RETARD ET DE LA SEMAINE (25% de largeur - Image 18) -->
    <div class="col-12 col-lg-3">
        <div class="d-flex flex-column gap-4 h-100">
            
            <!-- Liste En retard (6) -->
            <div class="card border-0 shadow-sm p-4 bg-white rounded-4 flex-grow-1">
                <h3 class="h6 fw-extrabold text-navy mb-4 d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i> En retard</span>
                    <span class="badge bg-danger rounded-circle fs-10" style="padding: 4px 6px;">{{ $relancesEnRetard->count() }}</span>
                </h3>
                
                <div class="d-flex flex-column gap-2 overflow-y-auto" style="max-height: 280px;">
                    @forelse($relancesEnRetard as $retard)
                    <div class="p-3 rounded-4 border-0 position-relative list-item-hover text-start" style="background-color: #FFF5F5; border: 1px solid #FED7D7 !important;">
                        <span class="badge bg-danger text-white fs-10 fw-bold px-2 py-0.5 rounded-pill mb-1">En retard</span>
                        <strong class="d-block text-navy fs-8 mt-1">{{ $retard->client->prenom }} {{ $retard->client->nom }}</strong>
                        <small class="text-muted fs-10 d-block mb-2">Planifiée le : {{ $retard->prochaine_relance->format('d/m/Y H:i') }}</small>
                        
                        <!-- Actions de relance immédiate (Conforme à l'image) -->
                        <div class="d-flex gap-2">
                            <button class="btn btn-success btn-sm rounded-pill fs-10 px-3 fw-bold"><i class="bi bi-check-lg"></i> Fait</button>
                            <button class="btn btn-outline-secondary btn-sm rounded-pill fs-10 px-3 fw-semibold">Demain</button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 my-auto">
                        <i class="bi bi-check-circle-fill text-success fs-1 mb-2 d-block"></i>
                        <span class="fs-8 text-muted fw-semibold">Aucun retard de relance !</span>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Liste Cette semaine -->
            <div class="card border-0 shadow-sm p-4 bg-white rounded-4 flex-grow-1">
                <h3 class="h6 fw-extrabold text-navy mb-4"><i class="bi bi-calendar-range text-cyan me-2"></i> Cette semaine</h3>
                
                <div class="d-flex flex-column gap-2 overflow-y-auto" style="max-height: 220px;">
                    @forelse($relancesDeLaSemaine as $semaine)
                    <div class="p-3 bg-light rounded-4 border border-light d-flex justify-content-between align-items-center list-item-hover">
                        <div>
                            <span class="fw-bold d-block fs-8 text-navy">{{ $semaine->client->prenom }} {{ $semaine->client->nom }}</span>
                            <small class="text-muted fs-10">{{ $semaine->prochaine_relance->format('l à H:i') }}</small>
                        </div>
                        <a href="tel:{{ $semaine->client->telephone }}" class="btn btn-cyan btn-sm rounded-circle"><i class="bi bi-telephone-fill"></i></a>
                    </div>
                    @empty
                    <div class="text-center py-4 my-auto">
                        <i class="bi bi-info-circle text-muted fs-1 mb-2 d-block"></i>
                        <span class="fs-8 text-muted fw-semibold">Aucune relance cette semaine</span>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</div>

<!-- ========================================== -->
<!-- MODAL : PROGRAMMER UNE RELANCE (Image 17)  -->
<!-- ========================================== -->
<div class="modal fade" id="newRelanceModal" tabindex="-1" aria-labelledby="newRelanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg bg-white text-navy">
            <div class="modal-header border-bottom border-light px-4">
                <h5 class="modal-title fw-extrabold text-navy" id="newRelanceModalLabel">Programmer une relance</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.agenda.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-4 row g-3 fs-8">
                    
                    <!-- Sélection de l'opportunité (Lead) -->
                    <div class="col-12">
                        <label for="id_lead" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Lead à relancer *</label>
                        <select name="id_lead" id="id_lead" class="form-select bg-light border-light py-2 fs-8" required>
                            <option value="" selected disabled>Sélectionner un lead</option>
                            @foreach($activeLeads as $lead)
                            <option value="{{ $lead->id_lead }}">{{ $lead->client->prenom }} {{ $lead->client->nom }} ({{ $lead->message_origine }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date de relance -->
                    <div class="col-md-6">
                        <label for="date_relance" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Date de relance *</label>
                        <input type="date" name="date_relance" id="date_relance" class="form-control bg-light border-light py-2 fs-8" required>
                    </div>

                    <!-- Heure de relance -->
                    <div class="col-md-6">
                        <label for="heure_relance" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Heure *</label>
                        <input type="time" name="heure_relance" id="heure_relance" class="form-control bg-light border-light py-2 fs-8" value="09:00" required>
                    </div>

                    <!-- Note de rappel -->
                    <div class="col-12">
                        <label for="note" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Note de rappel (optionnel)</label>
                        <textarea name="note" id="note" class="form-control bg-light border-light py-2 fs-8" rows="4" placeholder="Ex: Vérifier disponibilité technicien..."></textarea>
                    </div>

                </div>
                <div class="modal-footer border-top border-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-4 py-2" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-navy rounded-3 fs-8 fw-bold px-4 py-2 text-white">Programmer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- STYLISATION SPÉCIFIQUE DES CELLULES DE CALENDRIER -->
<style>
    .calendar-table {
        border-collapse: collapse;
    }
    .calendar-table td, .calendar-table th {
        border: 1px solid #E2E8F0 !important;
    }
    /* Cellule du jour actuel mise en valeur (Image 18) */
    .calendar-today-cell {
        background-color: rgba(0, 210, 244, 0.03) !important;
    }
</style>
@endsection