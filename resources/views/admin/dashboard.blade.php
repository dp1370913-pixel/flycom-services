@extends('layouts.admin')

@section('title', 'Tableau de Bord | Flycom Services CRM')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="mb-4 animate-fade-in">
    <h1 class="h3 fw-extrabold text-navy mb-1">Bienvenue, Flycom</h1>
    <p class="text-muted fs-8">Voici un aperçu de l'activité de Flycom Services aujourd'hui.</p>
</div>

<!-- LIGNE DES 4 WIDGETS DE STATISTIQUES (KPIs) -->
<div class="row g-4 mb-4 animate-fade-in" style="animation-delay: 0.1s;">
    
    <!-- Leads du jour -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm p-4 bg-white rounded-4 h-100 d-flex flex-column justify-content-between kpi-hover-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="fs-9 text-muted text-uppercase fw-bold tracking-wider d-block mb-1">Leads du jour</span>
                    <span class="display-6 fw-extrabold text-navy d-block">{{ $leadsDuJour }}</span>
                </div>
                <div class="kpi-icon-badge bg-cyan-soft text-cyan">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
            </div>
            <span class="fs-9 text-success fw-semibold"><i class="bi bi-arrow-up-right me-1"></i> Nouveau <span class="text-muted">vs hier</span></span>
        </div>
    </div>

    <!-- Leads actifs -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm p-4 bg-white rounded-4 h-100 d-flex flex-column justify-content-between kpi-hover-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="fs-9 text-muted text-uppercase fw-bold tracking-wider d-block mb-1">Leads Actifs</span>
                    <span class="display-6 fw-extrabold text-navy d-block">{{ $leadsActifs }}</span>
                </div>
                <div class="kpi-icon-badge bg-primary-soft text-primary">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
            </div>
            <span class="fs-9 text-muted"><i class="bi bi-clock me-1"></i> En cours de traitement</span>
        </div>
    </div>

    <!-- Clients actifs -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm p-4 bg-white rounded-4 h-100 d-flex flex-column justify-content-between kpi-hover-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="fs-9 text-muted text-uppercase fw-bold tracking-wider d-block mb-1">Clients actifs</span>
                    <span class="display-6 fw-extrabold text-navy d-block">{{ $clientsActifs }}</span>
                </div>
                <div class="kpi-icon-badge bg-success-soft text-success">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
            <span class="fs-9 text-success fw-semibold"><i class="bi bi-patch-check me-1"></i> Fidélisés</span>
        </div>
    </div>

    <!-- CA Estimé du mois -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm p-4 bg-white rounded-4 h-100 d-flex flex-column justify-content-between kpi-hover-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <span class="fs-9 text-muted text-uppercase fw-bold tracking-wider d-block mb-1">CA Estimé Mois</span>
                    <span class="display-6 fw-extrabold text-navy d-block" style="font-size: 1.45rem; line-height: 2;">{{ number_format($caEstimeMois, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="kpi-icon-badge bg-light-soft text-navy">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
            <span class="fs-9 text-muted"><i class="bi bi-graph-up me-1"></i> Basé sur les devis acceptés</span>
        </div>
    </div>

</div>

<!-- BARRE DE FILTRAGE DES PÉRIODES (Image 2) -->
<div class="d-flex align-items-center gap-2 mb-4 animate-fade-in" style="animation-delay: 0.15s;">
    <span class="fs-9 text-muted fw-bold text-uppercase me-2">Période :</span>
    <button class="btn btn-period-pill" data-period="7">7 jours</button>
    <button class="btn btn-period-pill active" data-period="30">30 jours</button>
    <button class="btn btn-period-pill" data-period="90">3 mois</button>
</div>

<!-- DOUBLE ENCADREMENT DE GRAPHIQUES ANIMÉS -->
<div class="row g-4 mb-4 animate-fade-in" style="animation-delay: 0.2s;">
    
    <!-- Graphique 1 : Donut Chart (Sources) -->
    <div class="col-12 col-lg-6">
        <div class="card border-0 shadow-sm p-4 bg-white rounded-4 h-100">
            <h2 class="h6 fw-extrabold text-navy mb-4">Leads par source</h2>
            <div class="chart-container mx-auto position-relative" style="height: 260px; max-width: 260px;">
                <canvas id="sourceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Graphique 2 : Line Chart (Évolution hebdomadaire) -->
    <div class="col-12 col-lg-6">
        <div class="card border-0 shadow-sm p-4 bg-white rounded-4 h-100">
            <h2 class="h6 fw-extrabold text-navy mb-4">Évolution des leads</h2>
            <div class="chart-container position-relative" style="height: 260px; width: 100%;">
                <canvas id="evolutionChart"></canvas>
            </div>
        </div>
    </div>

</div>

<!-- LISTE DES LEADS ET DES RAPPELS -->
<div class="row g-4 animate-fade-in" style="animation-delay: 0.25s;">
    
    <!-- Leads Récents -->
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm p-4 bg-white rounded-4 h-100">
            <h2 class="h6 fw-extrabold text-navy mb-4">Leads récents</h2>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 fs-8">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Client</th>
                            <th scope="col">Source</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leadsRecents as $lead)
                        <tr class="table-row-hover">
                            <td class="fw-bold">{{ $lead->client->prenom }} {{ $lead->client->nom }}</td>
                            <td>
                                @if($lead->source === 'WhatsApp')
                                    <span class="badge badge-source-whatsapp">WhatsApp</span>
                                @elseif($lead->source === 'Site_web')
                                    <span class="badge badge-source-siteweb">Site web</span>
                                @elseif($lead->source === 'Appel_direct')
                                    <span class="badge badge-source-appel">Appel direct</span>
                                @elseif($lead->source === 'Recommandation')
                                    <span class="badge badge-source-recom">Recommandation</span>
                                @else
                                    <span class="badge badge-source-email">Email</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-cyan-soft text-cyan px-2 py-1 rounded-3 fs-10 fw-bold">{{ $lead->statut }}</span>
                            </td>
                            <td class="text-muted">{{ $lead->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Aucun prospect enregistré pour l'instant.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Relances & Devis en attente -->
    <div class="col-12 col-lg-4">
        <div class="d-flex flex-column gap-4 h-100">
            
            <!-- Relances du jour -->
            <div class="card border-0 shadow-sm p-4 bg-white rounded-4 flex-grow-1">
                <h2 class="h6 fw-extrabold text-navy mb-4"><i class="bi bi-calendar-check text-cyan me-2"></i> Relances du jour</h2>
                @forelse($relancesDuJour as $relance)
                <div class="p-3 bg-light rounded-3 mb-2 d-flex justify-content-between align-items-center list-item-hover">
                    <div>
                        <span class="fw-bold d-block fs-8 text-navy">{{ $relance->client->prenom }} {{ $relance->client->nom }}</span>
                        <small class="text-muted fs-10">Tél : {{ $relance->client->telephone }}</small>
                    </div>
                    <a href="tel:{{ $relance->client->telephone }}" class="btn btn-cyan btn-sm rounded-circle"><i class="bi bi-telephone-fill"></i></a>
                </div>
                @empty
                <div class="text-center py-4 my-auto">
                    <i class="bi bi-check-circle text-success fs-1 mb-2 d-block"></i>
                    <span class="fs-8 text-muted fw-semibold">Aucune relance prévue aujourd'hui</span>
                </div>
                @endforelse
            </div>

            <!-- Devis en attente depuis +7 jours -->
            <div class="card border-0 shadow-sm p-4 bg-white rounded-4 flex-grow-1">
                <h2 class="h6 fw-extrabold text-navy mb-4"><i class="bi bi-exclamation-triangle text-danger me-2"></i> Devis en attente (+7j)</h2>
                @forelse($devisEnAttente as $devisItem)
                <div class="p-3 bg-light rounded-3 mb-2 d-flex justify-content-between align-items-center list-item-hover">
                    <div>
                        <span class="fw-bold d-block fs-8 text-navy">{{ $devisItem->numero }}</span>
                        <small class="text-muted fs-10">{{ $devisItem->client->prenom }} {{ $devisItem->client->nom }}</small>
                    </div>
                    <span class="badge bg-danger-transparent text-danger fs-9 fw-bold">{{ number_format($devisItem->montant_ttc, 0, ',', ' ') }} F</span>
                </div>
                @empty
                <div class="text-center py-4 my-auto">
                    <i class="bi bi-shield-check text-success fs-1 mb-2 d-block"></i>
                    <span class="fs-8 text-muted fw-semibold">Aucun devis en retard d'approbation</span>
                </div>
                @endforelse
            </div>

        </div>
    </div>

</div>

<!-- SCRIPT GRAPHISMES DYNAMIQUES AVEC GESTION DE FILTRES MORPHIQUES -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    // 1. Chargement des jeux de données complets pré-calculés par PHP pour les 3 périodes (7j, 30j, 90j)
    const donutDatasets = {!! json_encode($donutDatasets) !!};
    const lineDatasets = {!! json_encode($lineDatasets) !!};

    // 2. Initialisation du Donut Chart
    const ctxSource = document.getElementById('sourceChart').getContext('2d');
    const sourceChart = new Chart(ctxSource, {
        type: 'doughnut',
        data: {
            labels: ['Appel direct', 'Recommandation', 'Site web', 'WhatsApp'],
            datasets: [{
                data: donutDatasets[30], // Valeur par défaut : 30 jours
                backgroundColor: ['#fd7e14', '#6f42c1', '#0d6efd', '#198754'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15,
                        font: { size: 10, family: 'Plus Jakarta Sans', weight: 'bold' }
                    }
                }
            },
            cutout: '70%'
        }
    });

    // 3. Initialisation du Line Chart
    const ctxEvolution = document.getElementById('evolutionChart').getContext('2d');
    const evolutionChart = new Chart(ctxEvolution, {
        type: 'line',
        data: {
            labels: lineDatasets[30]['labels'], // Valeur par défaut : 30 jours
            datasets: [
                {
                    label: 'Créés',
                    data: lineDatasets[30]['created'],
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.05)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Gagnés',
                    data: lineDatasets[30]['won'],
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.05)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        font: { size: 10, family: 'Plus Jakarta Sans', weight: 'bold' }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { size: 9, family: 'Plus Jakarta Sans' }
                    },
                    grid: { color: 'rgba(0,0,0,0.03)' }
                },
                x: {
                    ticks: { font: { size: 9, family: 'Plus Jakarta Sans' } },
                    grid: { display: false }
                }
            }
        }
    });

    // 4. MOTEUR INTERACTIF : GESTION DES FILTRES DE PÉRIODE SANS RECHARGEMENT (Image 2)
    const periodButtons = document.querySelectorAll('.btn-period-pill');
    
    periodButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Retirer l'état actif de tous les boutons et l'appliquer au sélectionné
            periodButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            const period = button.getAttribute('data-period'); // Récupère 7, 30 ou 90

            // 1. Morphing du Donut Chart
            sourceChart.data.datasets[0].data = donutDatasets[period];
            sourceChart.update('active'); // Animation d'ajustement fluide

            // 2. Morphing du Line Chart
            evolutionChart.data.labels = lineDatasets[period]['labels'];
            evolutionChart.data.datasets[0].data = lineDatasets[period]['created'];
            evolutionChart.data.datasets[1].data = lineDatasets[period]['won'];
            evolutionChart.update('active'); // Animation de transition fluide
        });
    });

});
</script>
@endsection