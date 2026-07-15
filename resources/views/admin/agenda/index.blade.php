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

<!-- EN-TÊTE DE LA PAGE -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 animate-fade-in gap-3">
    <div>
        <h1 class="h3 fw-extrabold text-navy mb-1">Agenda &amp; Relances</h1>
        <p class="text-muted fs-8 mb-0">
            {{ $relancesDuMois->count() }} relances programmées · 
            <span class="text-danger fw-semibold">{{ $relancesEnRetard->count() }} en retard</span> · 
            {{ $relancesDeLaSemaine->count() }} cette semaine
        </p>
    </div>
    <div class="mt-1 mt-md-0 w-100 w-md-auto text-end">
        <button class="btn btn-cyan rounded-3 fs-8 fw-bold px-3 py-2 shadow-cyan-btn w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#newRelanceModal" style="background-color: #00B4D8; border: none; color: #fff;">
            <i class="bi bi-calendar-plus me-1"></i> Nouvelle relance
        </button>
    </div>
</div>

<!-- CONTAINER PRINCIPAL : CALENDRIER + COMPARTIMENT LATÉRAL -->
<div class="row g-4 animate-fade-in" style="animation-delay: 0.1s;">
    
    <!-- COLONNE DE GAUCHE : LE CALENDRIER MENSUEL (75% de largeur) -->
    <div class="col-12 col-lg-9">
        <div class="card border-0 shadow-sm p-3 p-sm-4 bg-white rounded-4 h-100">
            
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
                <table class="table table-bordered calendar-table mb-0 text-center align-middle fs-8" style="min-width: 600px;">
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
                                        return $lead->prochaine_relance && $lead->prochaine_relance->toDateString() === $currentDate;
                                    });
                                @endphp

                                <td class="position-relative py-3 {{ $isToday ? 'calendar-today-cell' : '' }}" style="height: 100px; vertical-align: top;">
                                    <!-- Numéro du jour -->
                                    <span class="d-block fw-bold mb-2 {{ $isToday ? 'badge bg-cyan text-navy rounded-circle p-1 d-inline-block' : 'text-navy' }}" style="{{ $isToday ? 'width: 24px; height: 24px; line-height: 16px; background-color: #00B4D8; color: #fff;' : '' }}">
                                        {{ $day }}
                                    </span>

                                    <!-- Événements / Relances du jour -->
                                    <div class="d-flex flex-column gap-1 overflow-hidden" style="max-height: 60px;">
                                        @foreach($relancesCeJour as $relance)
                                        <span class="badge bg-warning-transparent text-warning text-truncate d-block text-start fs-10 px-2 py-1 rounded-2" title="{{ $relance->client->prenom }} {{ $relance->client->nom }}" style="background-color: rgba(245, 158, 11, 0.08); color: #D97706 !important;">
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

    <!-- COLONNE DE DROITE : RELANCES EN RETARD ET DE LA SEMAINE -->
    <div class="col-12 col-lg-3">
        <div class="d-flex flex-column gap-4 h-100">
            
            <!-- Liste En retard (100% opérationnel) -->
            <div class="card border-0 shadow-sm p-3 p-sm-4 bg-white rounded-4 flex-grow-1">
                <h3 class="h6 fw-extrabold text-navy mb-4 d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i> En retard</span>
                    <span class="badge bg-danger rounded-circle fs-10" style="padding: 4px 6px;">{{ $relancesEnRetard->count() }}</span>
                </h3>
                
                <div class="d-flex flex-column gap-2 overflow-y-auto" style="max-height: 280px;">
                    @forelse($relancesEnRetard as $retard)
                    <div class="p-3 rounded-4 border-0 position-relative list-item-hover text-start" style="background-color: #FFF5F5; border: 1px solid #FED7D7 !important; transition: all 0.4s ease-out;">
                        <span class="badge bg-danger text-white fs-10 fw-bold px-2 py-0.5 rounded-pill mb-1">En retard</span>
                        <strong class="d-block text-navy fs-8 mt-1 text-truncate">{{ $retard->client->prenom }} {{ $retard->client->nom }}</strong>
                        <small class="text-muted fs-10 d-block mb-2">Planifiée le : {{ $retard->prochaine_relance->format('d/m/Y H:i') }}</small>
                        
                        <!-- Actions de relance immédiates -->
                        <div class="d-flex gap-2">
                            <button class="btn btn-success btn-sm rounded-pill fs-10 px-3 fw-bold btn-agenda-done" data-id="{{ $retard->id_lead }}"><i class="bi bi-check-lg"></i> Fait</button>
                            <button class="btn btn-outline-secondary btn-sm rounded-pill fs-10 px-3 fw-semibold btn-agenda-tomorrow" data-id="{{ $retard->id_lead }}">Demain</button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 my-auto">
                        <i class="bi bi-check-circle-fill text-success fs-1 mb-2 d-block"></i>
                        <span class="fs-8 text-muted fw-semibold">Aucun retard !</span>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Liste Cette semaine -->
            <div class="card border-0 shadow-sm p-3 p-sm-4 bg-white rounded-4 flex-grow-1">
                <h3 class="h6 fw-extrabold text-navy mb-4"><i class="bi bi-calendar-range text-cyan me-2"></i> Cette semaine</h3>
                
                <div class="d-flex flex-column gap-2 overflow-y-auto" style="max-height: 220px;">
                    @forelse($relancesDeLaSemaine as $semaine)
                    <div class="p-3 bg-light rounded-4 border border-light d-flex justify-content-between align-items-center gap-2 list-item-hover">
                        <div class="text-truncate">
                            <span class="fw-bold d-block fs-8 text-navy text-truncate">{{ $semaine->client->prenom }} {{ $semaine->client->nom }}</span>
                            <small class="text-muted fs-10 d-block text-truncate">{{ $semaine->prochaine_relance ? $semaine->prochaine_relance->format('l à H:i') : '—' }}</small>
                        </div>
                        <a href="tel:{{ $semaine->client->telephone }}" class="btn btn-cyan btn-sm rounded-circle flex-shrink-0" style="background-color: #00B4D8; border: none; color: #fff; width: 30px; height: 32px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-telephone-fill" style="font-size: 0.85rem;"></i></a>
                    </div>
                    @empty
                    <div class="text-center py-4 my-auto">
                        <i class="bi bi-info-circle text-muted fs-1 mb-2 d-block"></i>
                        <span class="fs-8 text-muted fw-semibold">Aucune relance</span>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</div>

<!-- ========================================== -->
<!-- MODAL : PROGRAMMER UNE RELANCE             -->
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
                <div class="modal-body px-4 py-4 row g-3 fs-8 text-start">
                    
                    <!-- Sélection du Lead -->
                    <div class="col-12">
                        <label for="id_lead" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Lead à relancer *</label>
                        <select name="id_lead" id="id_lead" class="form-select bg-light border-light py-2 fs-8" required style="box-shadow: none !important;">
                            <option value="" selected disabled>Sélectionner un lead</option>
                            @foreach($activeLeads as $lead)
                            <option value="{{ $lead->id_lead }}">{{ $lead->client->prenom }} {{ $lead->client->nom }} ({{ $lead->message_origine }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date de relance -->
                    <div class="col-md-6">
                        <label for="date_relance" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Date de relance *</label>
                        <input type="date" name="date_relance" id="date_relance" class="form-control bg-light border-light py-2 fs-8" required style="box-shadow: none !important;">
                    </div>

                    <!-- Heure de relance -->
                    <div class="col-md-6">
                        <label for="heure_relance" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Heure *</label>
                        <input type="time" name="heure_relance" id="heure_relance" class="form-control bg-light border-light py-2 fs-8" value="09:00" required style="box-shadow: none !important;">
                    </div>

                    <!-- Note de rappel -->
                    <div class="col-12">
                        <label for="note" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Note de rappel (optionnel)</label>
                        <textarea name="note" id="note" class="form-control bg-light border-light py-2 fs-8" rows="4" placeholder="Ex: Vérifier disponibilité technicien..." style="box-shadow: none !important;"></textarea>
                    </div>

                </div>
                <div class="modal-footer border-top border-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-4 py-2" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-navy rounded-3 fs-8 fw-bold px-4 py-2 text-white" style="background:#0D1B4B; border:none; width: auto !important;">Programmer</button>
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
    .calendar-today-cell {
        background-color: rgba(0, 210, 244, 0.03) !important;
    }
</style>

<!-- CODE SCRIPT INTERACTIF DE TRAITEMENT ET ANIMATION -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    
    // Déclencheur de Toast de notification synchronisé avec le layout principal
    const showAgendaNotification = (message, type = 'success') => {
        if (window.showToast) {
            window.showToast(message, type === 'success' ? 'Relance effectuée' : 'Relance reportée');
        } else {
            alert(message);
        }
    };

    // 1. GESTION DU CLIC "FAIT"
    document.querySelectorAll('.btn-agenda-done').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const leadId = btn.getAttribute('data-id');
            const card = btn.closest('.list-item-hover');

            btn.disabled = true;
            btn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;

            fetch(`/admin/agenda/${leadId}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error("Erreur de communication avec le serveur");
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    showAgendaNotification(data.message, 'success');
                    
                    // Effet de transition fluide avant rechargement (UX)
                    if (card) {
                        card.style.opacity = '0';
                        card.style.transform = 'translateX(50px)';
                        card.style.transition = 'all 0.4s ease-out';
                        setTimeout(() => {
                            card.remove();
                            location.reload(); // Recharger pour rafraîchir le calendrier dynamique
                        }, 400);
                    } else {
                        location.reload();
                    }
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = `<i class="bi bi-check-lg"></i> Fait`;
                console.error("Flycom Agenda Action Error:", err);
            });
        });
    });

    // 2. GESTION DU CLIC "DEMAIN"
    document.querySelectorAll('.btn-agenda-tomorrow').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const leadId = btn.getAttribute('data-id');
            const card = btn.closest('.list-item-hover');

            btn.disabled = true;
            btn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;

            fetch(`/admin/agenda/${leadId}/postpone`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error("Erreur de communication avec le serveur");
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    showAgendaNotification(data.message, 'info');
                    
                    if (card) {
                        card.style.opacity = '0';
                        card.style.transform = 'translateX(50px)';
                        card.style.transition = 'all 0.4s ease-out';
                        setTimeout(() => {
                            card.remove();
                            location.reload();
                        }, 400);
                    } else {
                        location.reload();
                    }
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = `Demain`;
                console.error("Flycom Agenda Action Error:", err);
            });
        });
    });

});
</script>
@endsection