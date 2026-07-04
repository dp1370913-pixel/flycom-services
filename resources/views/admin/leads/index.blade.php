@extends('layouts.admin')

@section('title', 'Pipeline Commercial | Flycom Services CRM')

@section('content')

<!-- Zone de notification Toast pour les retours interactifs rapides -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1090;"></div>

<!-- HEADER DE PAGE -->
<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h1 class="fw-extrabold text-navy mb-1" style="font-size: 1.6rem;">Pipeline commercial</h1>
        <p class="text-muted mb-0" style="font-size: 0.8rem;">
            {{ $allLeads->count() }} leads · {{ $allLeads->whereNotIn('statut', ['Gagne', 'Perdu'])->count() }} actifs
        </p>
    </div>

    <div class="d-flex align-items-center gap-2 mt-1">
        <!-- Commutateur Kanban / Liste -->
        <div class="d-flex rounded-3 overflow-hidden" style="border: 1px solid #E2E8F0; background: #F8FAFC;">
            <button type="button" id="btnShowKanban" class="btn-view-toggle active px-3 py-2" style="font-size: 0.8rem; font-weight: 600; border: none; background: transparent; cursor: pointer;">Kanban</button>
            <button type="button" id="btnShowList" class="btn-view-toggle px-3 py-2" style="font-size: 0.8rem; font-weight: 600; border: none; background: transparent; cursor: pointer; color: #6B7280;">Liste</button>
        </div>

        @if(Auth::user()->role === 'Admin')
        <a href="{{ route('admin.leads.export') }}" class="btn btn-outline-secondary rounded-3 px-3 py-2" style="font-size: 0.8rem; font-weight: 600; text-decoration: none;">
            <i class="bi bi-download me-1"></i> Export
        </a>
        @endif

        @if(Auth::user()->role !== 'Lecture')
        <button class="btn rounded-3 px-3 py-2 text-white fw-bold" style="font-size: 0.8rem; background: #0D1B4B; border: none;" data-bs-toggle="modal" data-bs-target="#newLeadModal">
            <i class="bi bi-plus-lg me-1"></i> Nouveau lead
        </button>
        @endif
    </div>
</div>

<!-- BARRE DE RECHERCHE & FILTRE SOURCE -->
<form action="{{ route('admin.leads.index') }}" method="GET" class="d-flex gap-2 mb-4">
    <div class="position-relative flex-grow-1" style="max-width: 420px;">
        <span class="position-absolute start-0 top-50 translate-middle-y ms-3 text-muted" style="font-size: 0.85rem;">
            <i class="bi bi-search"></i>
        </span>
        <input type="text" name="search" class="form-control border rounded-3 py-2 ps-5" style="font-size: 0.82rem; background: #F8FAFC; border-color: #E2E8F0 !important;" placeholder="Rechercher un lead..." value="{{ $search }}">
    </div>
    <select name="source" class="form-select rounded-3 py-2" style="font-size: 0.82rem; background: #F8FAFC; border-color: #E2E8F0; max-width: 200px;" onchange="this.form.submit()">
        <option value="all">Toutes sources</option>
        <option value="Site_web" {{ $sourceFilter === 'Site_web' ? 'selected' : '' }}>Site web</option>
        <option value="WhatsApp" {{ $sourceFilter === 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
        <option value="Appel_direct" {{ $sourceFilter === 'Appel_direct' ? 'selected' : '' }}>Appel direct</option>
        <option value="Recommandation" {{ $sourceFilter === 'Recommandation' ? 'selected' : '' }}>Recommandation</option>
        <option value="Email" {{ $sourceFilter === 'Email' ? 'selected' : '' }}>Email</option>
    </select>
</form>

<!-- VUE KANBAN -->
<div id="kanbanView">
    <div class="kanban-grid">
        @php
        $colonnes = [
            'Nouveau'      => ['color' => '#3B82F6', 'bg' => '#EFF6FF'],
            'Contacte'     => ['color' => '#F97316', 'bg' => '#FFF7ED'],
            'Devis_envoye' => ['color' => '#8B5CF6', 'bg' => '#F5F3FF'],
            'Negociation'  => ['color' => '#EAB308', 'bg' => '#FEFCE8'],
            'Gagne'        => ['color' => '#22C55E', 'bg' => '#F0FDF4'],
            'Perdu'        => ['color' => '#EF4444', 'bg' => '#FFF1F2'],
        ];
        $labels = [
            'Nouveau'      => 'Nouveau',
            'Contacte'     => 'Contacté',
            'Devis_envoye' => 'Devis envoyé',
            'Negociation'  => 'Négociation',
            'Gagne'        => 'Gagné',
            'Perdu'        => 'Perdu',
        ];
        @endphp

        @foreach($colonnes as $statut => $style)
        <div class="kanban-col" style="background: {{ $style['bg'] }}; border: 1px solid {{ $style['color'] }}22; border-radius: 14px; padding: 16px; min-height: 260px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="d-flex align-items-center gap-2 fw-bold text-navy" style="font-size: 0.88rem;">
                    <span style="width:9px; height:9px; border-radius:50%; background:{{ $style['color'] }}; display:inline-block; flex-shrink:0;"></span>
                    {{ $labels[$statut] }}
                </span>
                <span class="fw-semibold" style="font-size: 0.8rem; color: #9CA3AF;">{{ $kanbanLeads[$statut]->count() }}</span>
            </div>

            <div class="kanban-col-body d-flex flex-column gap-2" data-status="{{ $statut }}" style="min-height: 120px;">
                @foreach($kanbanLeads[$statut] as $lead)
                <div class="kanban-card bg-white rounded-3 p-3 btn-view-lead" @if(Auth::user()->role !== 'Lecture') draggable="true" @endif data-id="{{ $lead->id_lead }}" data-bs-toggle="modal" data-bs-target="#leadDetailsModal" style="border: 1px solid #F1F5F9; cursor: pointer;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="fw-bold text-navy" style="font-size: 0.87rem; line-height: 1.3;">{{ $lead->client->prenom }} {{ $lead->client->nom }}</span>
                        @if(Auth::user()->role !== 'Lecture')
                        <span class="drag-handle text-muted ms-2" style="font-size: 0.7rem; letter-spacing: 1px; flex-shrink: 0;">⋮⋮</span>
                        @endif
                    </div>

                    <div class="d-flex flex-wrap gap-1 mb-2">
                        @if($lead->priorite === 'Haute')
                            <span class="badge-prio" style="background:#FEE2E2; color:#DC2626;">Haute</span>
                        @elseif($lead->priorite === 'Normale')
                            <span class="badge-prio" style="background:#FEF9C3; color:#CA8A04;">Normale</span>
                        @else
                            <span class="badge-prio" style="background:#F1F5F9; color:#64748B;">Basse</span>
                        @endif

                        @if($lead->source === 'WhatsApp')
                            <span class="badge-src" style="background:#DCFCE7; color:#16A34A;"><i class="bi bi-whatsapp me-1"></i>WhatsApp</span>
                        @elseif($lead->source === 'Site_web')
                            <span class="badge-src" style="background:#DBEAFE; color:#2563EB;"><i class="bi bi-search me-1"></i>Site web</span>
                        @elseif($lead->source === 'Appel_direct')
                            <span class="badge-src" style="background:#FFEDD5; color:#EA580C;"><i class="bi bi-telephone-fill me-1"></i>Appel direct</span>
                        @elseif($lead->source === 'Recommandation')
                            <span class="badge-src" style="background:#EDE9FE; color:#7C3AED;"><i class="bi bi-person-check me-1"></i>Recommandation</span>
                        @else
                            <span class="badge-src" style="background:#F1F5F9; color:#475569;"><i class="bi bi-envelope-fill me-1"></i>Email</span>
                        @endif
                    </div>

                    @if($lead->services->count())
                    <div class="d-flex flex-wrap gap-1 mb-2">
                        @foreach($lead->services as $service)
                        <span style="font-size: 0.72rem; color: #64748B;">{{ $service->nom_service }}</span>
                        @endforeach
                    </div>
                    @endif

                    <div class="d-flex align-items-center gap-1 mt-1" style="font-size: 0.73rem; color: #9CA3AF;">
                        <i class="bi bi-clock"></i>
                        <span>{{ $lead->created_at->translatedFormat('d M') }}</span>
                        @if($lead->prochaine_relance)
                        <span class="ms-auto {{ $lead->prochaine_relance->isPast() ? 'text-danger fw-semibold' : '' }}">
                            <i class="bi bi-bell"></i> {{ $lead->prochaine_relance->translatedFormat('d M') }}
                        </span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- VUE LISTE -->
<div id="listView" class="card border-0 shadow-sm p-4 bg-white rounded-4 d-none">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.82rem;">
            <thead class="table-light">
                <tr>
                    <th>Client</th>
                    <th>Statut</th>
                    <th>Priorité</th>
                    <th>Source</th>
                    <th>Services</th>
                    <th>Date entrée</th>
                    <th>Relance</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allLeads as $lead)
                <tr>
                    <td class="fw-bold text-navy btn-view-lead" style="cursor: pointer; transition: color 0.2s ease;" data-bs-toggle="modal" data-bs-target="#leadDetailsModal" data-id="{{ $lead->id_lead }}">{{ $lead->client->prenom }} {{ $lead->client->nom }}</td>
                    <td><span class="badge bg-cyan-soft text-cyan px-2 py-1 rounded-3">{{ $lead->statut }}</span></td>
                    <td>
                        @if($lead->priorite === 'Haute')
                            <span class="badge-prio" style="background:#FEE2E2; color:#DC2626;">Haute</span>
                        @elseif($lead->priorite === 'Normale')
                            <span class="badge-prio" style="background:#FEF9C3; color:#CA8A04;">Normale</span>
                        @else
                            <span class="badge-prio" style="background:#F1F5F9; color:#64748B;">Basse</span>
                        @endif
                    </td>
                    <td>
                        @if($lead->source === 'WhatsApp')
                            <span class="badge-src" style="background:#DCFCE7; color:#16A34A;">WhatsApp</span>
                        @elseif($lead->source === 'Site_web')
                            <span class="badge-src" style="background:#DBEAFE; color:#2563EB;">Site web</span>
                        @elseif($lead->source === 'Appel_direct')
                            <span class="badge-src" style="background:#FFEDD5; color:#EA580C;">Appel direct</span>
                        @elseif($lead->source === 'Recommandation')
                            <span class="badge-src" style="background:#EDE9FE; color:#7C3AED;">Recommandation</span>
                        @else
                            <span class="badge-src" style="background:#F1F5F9; color:#475569;">Email</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($lead->services as $service)
                            <span class="badge bg-light text-muted" style="font-size: 0.72rem;">{{ $service->nom_service }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td class="text-muted">{{ $lead->created_at->format('d/m/Y') }}</td>
                    <td class="text-muted">{{ $lead->prochaine_relance ? $lead->prochaine_relance->format('d/m/Y H:i') : '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">Aucune opportunité trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL DE CRÉATION DE LEAD -->
@if(Auth::user()->role !== 'Lecture')
<div class="modal fade" id="newLeadModal" tabindex="-1" aria-labelledby="newLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg bg-white text-navy">
            <div class="modal-header border-bottom border-light px-4">
                <h5 class="modal-title fw-extrabold text-navy" id="newLeadModalLabel">Nouveau lead</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.leads.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-4 row g-3" style="font-size: 0.82rem;">
                    <div class="col-md-6">
                        <label for="id_client" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Client *</label>
                        <select name="id_client" id="id_client" class="form-select bg-light border-light py-2" required>
                            <option value="" disabled selected>Choisir un client</option>
                            @foreach($clients as $client)
                            <option value="{{ $client->id_client }}">{{ $client->prenom }} {{ $client->nom }} — {{ $client->telephone }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="source" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Source *</label>
                        <select name="source" id="source" class="form-select bg-light border-light py-2" required>
                            <option value="Site_web">Site web</option>
                            <option value="WhatsApp" selected>WhatsApp</option>
                            <option value="Appel_direct">Appel direct</option>
                            <option value="Recommandation">Recommandation</option>
                            <option value="Email">Email</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="priorite" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Priorité *</label>
                        <select name="priorite" id="priorite" class="form-select bg-light border-light py-2" required>
                            <option value="Haute">Haute</option>
                            <option value="Normale" selected>Normale</option>
                            <option value="Basse">Basse</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="statut_initial" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Statut initial *</label>
                        <select name="statut_initial" id="statut_initial" class="form-select bg-light border-light py-2" required>
                            <option value="Nouveau" selected>Nouveau</option>
                            <option value="Contacte">Contacté</option>
                            <option value="Devis_envoye">Devis envoyé</option>
                            <option value="Negociation">Négociation</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="prochaine_relance" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Prochaine relance</label>
                        <input type="datetime-local" name="prochaine_relance" id="prochaine_relance" class="form-control bg-light border-light py-2">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold text-navy text-uppercase mb-2" style="font-size: 0.72rem;">Services concernés *</label>
                        <div class="row g-2">
                            @foreach($services as $service)
                            <div class="col-6 col-md-4">
                                <div class="form-check p-2 rounded-3 border border-light bg-light d-flex align-items-center gap-2">
                                    <input class="form-check-input ms-1" type="checkbox" name="services_concernes[]" value="{{ $service->id_service }}" id="svc{{ $service->id_service }}" style="width:15px; height:15px; accent-color: #0D1B4B;">
                                    <label class="form-check-label text-truncate text-navy" style="font-size: 0.78rem;" for="svc{{ $service->id_service }}">{{ $service->nom_service }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="message" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Message / Demande</label>
                        <textarea name="message" id="message" class="form-control bg-light border-light py-2" rows="3" maxlength="500" placeholder="Décrivez le besoin..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top border-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-3 fw-semibold px-4 py-2" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn rounded-3 fw-bold px-4 py-2 text-white" style="background: #0D1B4B;">Créer le lead</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- MODAL DE DÉTAILS D'UN LEAD -->
<div class="modal fade" id="leadDetailsModal" tabindex="-1" aria-labelledby="leadDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg bg-white text-navy">
            <div class="modal-header border-0 px-4 pt-4 pb-0">
                <div>
                    <h5 class="modal-title fw-extrabold text-navy fs-5" id="detailClientName">Chargement...</h5>
                    <small class="text-muted fs-8" id="detailClientMeta"></small>
                </div>
                <button type="button" class="btn-close shadow-none align-self-start" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body px-4 py-3 fs-8">
                <!-- Message d'origine -->
                <div class="mb-4">
                    <span class="field-label" style="color:#64748B;">Message d'origine</span>
                    <div class="p-3 rounded-4 mt-2" style="background-color: #F8FAFC; border: 1px solid #E2E8F0 !important;">
                        <p class="mb-0 text-muted leading-relaxed" id="detailMessage">Chargement des données du prospect en cours...</p>
                    </div>
                </div>

                <!-- Services concernés -->
                <div class="mb-4">
                    <span class="field-label" style="color:#64748B;">Services concernés</span>
                    <div class="d-flex flex-wrap gap-1 mt-2" id="detailServicesContainer"></div>
                </div>

                <!-- Grille de métadonnées -->
                <div class="row g-2 mb-4 text-start">
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:#F8FAFC;">
                            <span class="field-label" style="color:#94A3B8;">Statut</span>
                            <span class="fw-bold d-block text-navy mt-1" id="detailStatut">Nouveau</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:#F8FAFC;">
                            <span class="field-label" style="color:#94A3B8;">Priorité</span>
                            <span class="fw-bold d-block mt-1" id="detailPriorite">Normale</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:#F8FAFC;">
                            <span class="field-label" style="color:#94A3B8;">Source</span>
                            <span class="fw-bold d-block text-navy mt-1" id="detailSource">Site web</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:#F8FAFC;">
                            <span class="field-label" style="color:#94A3B8;">Créé le</span>
                            <span class="fw-bold d-block text-navy mt-1" id="detailCreeLe">--/--/----</span>
                        </div>
                    </div>
                </div>

                <!-- FORMULAIRE INLINE AJOUT D'INTERACTION (Rétractable d'ergonomie - Nouveau) -->
                @if(Auth::user()->role !== 'Lecture')
                <div class="mb-4 d-none" id="interactionFormContainer" style="border-top: 1px solid #E2E8F0; padding-top: 15px;">
                    <span class="field-label mb-2" style="color: #00B4D8;"><i class="bi bi-chat-left-text-fill"></i> Nouvelle interaction</span>
                    <form id="addInteractionForm" class="row g-2">
                        <div class="col-md-5">
                            <select name="type_canal" id="interaction_canal" class="form-select bg-light border-light py-1.5 fs-8" required>
                                <option value="" disabled selected>Canal...</option>
                                <option value="Appel">Appel téléphonique</option>
                                <option value="WhatsApp">WhatsApp</option>
                                <option value="Email">Email</option>
                                <option value="Rendez-vous">Rendez-vous</option>
                                <option value="Visite_terrain">Visite terrain</option>
                            </select>
                        </div>
                        <div class="col-md-7">
                            <textarea name="note" id="interaction_note" class="form-control bg-light border-light py-1.5 fs-8" rows="1" placeholder="Note d'interaction..." required></textarea>
                        </div>
                        <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                            <button type="button" class="btn btn-light btn-sm rounded-2 fs-9" id="btnCancelInteraction">Annuler</button>
                            <button type="submit" class="btn text-white btn-sm rounded-2 fs-9" id="btnSubmitInteraction" style="background:#0D1B4B; border:none;">Enregistrer</button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Liste d'historique -->
                <div class="mb-2">
                    <span class="field-label" id="detail-interactions-count-header" style="color:#64748B;">Historique (0)</span>
                    <div class="d-flex flex-column gap-2 mt-2 overflow-y-auto" id="detailInteractionsContainer" style="max-height: 220px;"></div>
                </div>
            </div>
            
            <!-- Actions de pied de page adaptatives -->
            <div class="modal-footer border-0 px-4 pb-4 pt-0 d-flex gap-2">
                @if(Auth::user()->role !== 'Lecture')
                <a href="#" id="btnCreateDevisLink" class="btn text-white fw-bold px-4 py-2.5 flex-grow-1" style="background:#0D1B4B; border-radius: 8px; font-size:0.8rem; text-decoration: none; display: flex; align-items: center; justify-content: center;">Créer un devis</a>
                <button type="button" class="btn btn-outline-secondary fw-semibold px-4 py-2.5" id="btnToggleInteractionForm" style="border-radius: 8px; font-size:0.8rem;">Ajouter interaction</button>
                @else
                <button type="button" class="btn btn-light w-100 fw-bold py-2.5" data-bs-dismiss="modal" style="border-radius: 8px; font-size:0.8rem;">Fermer</button>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.kanban-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}
@media (max-width: 992px) {
    .kanban-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .kanban-grid { grid-template-columns: 1fr; }
}

.kanban-card {
    transition: box-shadow 0.2s, transform 0.15s;
}
.kanban-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.10) !important;
    transform: translateY(-1px);
}
.kanban-card.dragging { opacity: 0.35; }
.kanban-col-body.drag-over { outline: 2px dashed #00D2F4; border-radius: 10px; }

.badge-prio, .badge-src {
    display: inline-flex;
    align-items: center;
    font-size: 0.72rem;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 6px;
    white-space: nowrap;
}

.btn-view-lead:hover {
    color: #00D2F4 !important;
}

.btn-view-toggle { transition: all 0.15s; border-radius: 6px !important; }
.btn-view-toggle.active {
    background: #ffffff !important;
    color: #0D1B4B !important;
    box-shadow: 0 1px 5px rgba(0,0,0,0.12);
}

/* Animations de transition */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Toast de notification */
.toast-custom-success {
    background-color: #ECFDF5 !important;
    border: 1px solid #10B981 !important;
    color: #064E3B !important;
}
.toast-custom-info {
    background-color: #EFF6FF !important;
    border: 1px solid #3B82F6 !important;
    color: #1E3A8A !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {

    let activeLeadId = null;

    /* ── Bascule Vues Kanban / Liste ── */
    const btnKanban = document.getElementById('btnShowKanban');
    const btnList   = document.getElementById('btnShowList');
    const viewKanban = document.getElementById('kanbanView');
    const viewList   = document.getElementById('listView');

    if (btnKanban && btnList) {
        btnKanban.addEventListener('click', () => {
            btnKanban.classList.add('active');
            btnList.classList.remove('active');
            viewKanban.classList.remove('d-none');
            viewList.classList.add('d-none');
        });
        btnList.addEventListener('click', () => {
            btnList.classList.add('active');
            btnKanban.classList.remove('active');
            viewList.classList.remove('d-none');
            viewKanban.classList.add('d-none');
        });
    }

    /* ── Drag & Drop Kanban ── */
    document.querySelectorAll('.kanban-card').forEach(card => {
        card.addEventListener('dragstart', () => card.classList.add('dragging'));
        card.addEventListener('dragend',   () => card.classList.remove('dragging'));
    });

    document.querySelectorAll('.kanban-col-body').forEach(col => {
        col.addEventListener('dragover',  e => { e.preventDefault(); col.classList.add('drag-over'); });
        col.addEventListener('dragleave', () => col.classList.remove('drag-over'));
        col.addEventListener('drop', e => {
            e.preventDefault();
            col.classList.remove('drag-over');
            const card = document.querySelector('.kanban-card.dragging');
            if (!card) return;
            col.appendChild(card);
            fetch(`/admin/leads/${card.dataset.id}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ statut: col.dataset.status })
            }).catch(err => console.error('Drag&Drop error:', err));
        });
    });

    /* ── Toast de notification local ── */
    window.showToast = function(message, title = 'Notification', duration = 4000) {
        const container = document.querySelector('.toast-container');
        if (!container) return;
        const id = 'toast-' + Date.now();
        
        let customClass = 'toast-custom-success';
        let iconHtml = '<i class="bi bi-check-circle-fill me-1"></i>';

        const toastHtml = `
            <div id="${id}" class="toast align-items-center border-0 mb-2 shadow ${customClass}" role="alert" aria-live="assertive" aria-atomic="true" style="opacity: 1; min-width: 250px;">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong class="d-block" style="font-size: 0.85rem;">${iconHtml} ${title}</strong>
                        <span style="font-size: 0.8rem;">${message}</span>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', toastHtml);
        const toastElement = document.getElementById(id);
        const bs = window.bootstrap;
        if (bs) {
            const bsToast = new bs.Toast(toastElement, { delay: duration });
            bsToast.show();
            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }
    };

    /* ── Ouverture Dynamique du Modal Details (AJAX) ── */
    const detailsModalElement = document.getElementById('leadDetailsModal');
    
    if (detailsModalElement) {
        detailsModalElement.addEventListener('show.bs.modal', (event) => {
            const triggerElement = event.relatedTarget;
            if (!triggerElement) return;

            const id = triggerElement.getAttribute('data-id');
            activeLeadId = id; // Sauvegarde de l'ID courant pour l'interaction

            // Réinitialiser le formulaire d'interaction au cas où
            const formContainer = document.getElementById('interactionFormContainer');
            if (formContainer) formContainer.classList.add('d-none');
            
            const addInteractionForm = document.getElementById('addInteractionForm');
            if (addInteractionForm) addInteractionForm.reset();

            // Configurer le lien de redirection de création de devis
            const btnCreateDevis = document.getElementById('btnCreateDevisLink');
            if (btnCreateDevis) {
                btnCreateDevis.setAttribute('href', `/admin/devis?lead_id=${id}`);
            }

            // Réinitialiser les affichages
            document.getElementById('detailClientName').innerText = "Chargement...";
            document.getElementById('detailClientMeta').innerText = "";
            document.getElementById('detailMessage').innerText = "Chargement des données du prospect en cours...";
            document.getElementById('detailServicesContainer').innerHTML = "";
            document.getElementById('detailInteractionsContainer').innerHTML = "";

            // Appel asynchrone (M3)
            fetch(`/admin/leads/${id}/details`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('detailClientName').innerText = data.client_prenom + ' ' + data.client_nom;
                    document.getElementById('detailClientMeta').innerText = data.client_telephone + ' · ' + data.client_email;
                    document.getElementById('detailMessage').innerText = data.message_origine;
                    document.getElementById('detailStatut').innerText = data.statut;
                    document.getElementById('detailPriorite').innerText = data.priorite;
                    document.getElementById('detailSource').innerText = data.source;
                    document.getElementById('detailCreeLe').innerText = data.cree_le;

                    // Ajustement de la classe priorité
                    const prioText = document.getElementById('detailPriorite');
                    if (data.priorite === 'Haute') {
                        prioText.className = 'fw-bold d-block text-danger mt-1';
                    } else if (data.priorite === 'Normale') {
                        prioText.className = 'fw-bold d-block text-warning mt-1';
                    } else {
                        prioText.className = 'fw-bold d-block text-muted mt-1';
                    }

                    // Injection des badges de services
                    const servicesContainer = document.getElementById('detailServicesContainer');
                    data.services.forEach(svc => {
                        const span = document.createElement('span');
                        span.className = 'badge bg-cyan-soft text-cyan px-2 py-1.5 rounded-3 fs-9 fw-bold';
                        span.innerText = svc;
                        servicesContainer.appendChild(span);
                    });

                    // Mise à jour de l'historique d'interactions
                    const countHeader = document.getElementById('detail-interactions-count-header');
                    if (countHeader) {
                        countHeader.innerText = `Historique (${data.interactions.length})`;
                    }

                    const interactionsContainer = document.getElementById('detailInteractionsContainer');
                    if (data.interactions.length > 0) {
                        data.interactions.forEach(inter => {
                            const div = document.createElement('div');
                            div.className = 'p-3 bg-light rounded-3 d-flex gap-3 align-items-start border border-light mb-2';
                            div.innerHTML = `
                                <div class="avatar-circle rounded-circle p-2 text-white bg-navy text-center" style="width: 28px; height: 28px; font-size: 0.72rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background-color:#0D1B4B;">
                                    <i class="bi bi-chat-left-text"></i>
                                </div>
                                <div>
                                    <span class="fw-bold d-block fs-8 text-navy" style="line-height:1.2;">${inter.type_canal} <small class="text-muted fw-normal ms-1">${inter.date}</small></span>
                                    <p class="fs-9 text-muted mb-0 mt-1 leading-relaxed">${inter.note}</p>
                                </div>
                            `;
                            interactionsContainer.appendChild(div);
                        });
                    } else {
                        interactionsContainer.innerHTML = '<span class="text-muted fs-8">Aucune interaction consignée pour le moment.</span>';
                    }
                })
                .catch(err => {
                    console.error('AJAX Error:', err);
                    document.getElementById('detailMessage').innerText = 'Erreur lors du chargement des données.';
                });
        });
    }

    /* ── Logique interactive du Formulaire d'Interaction Inline ── */
    const btnToggleForm = document.getElementById('btnToggleInteractionForm');
    const formContainer = document.getElementById('interactionFormContainer');
    const addInteractionForm = document.getElementById('addInteractionForm');

    if (btnToggleForm && formContainer) {
        btnToggleForm.addEventListener('click', () => {
            formContainer.classList.toggle('d-none');
            if (!formContainer.classList.contains('d-none')) {
                document.getElementById('interaction_canal').focus();
            }
        });
    }

    const btnCancel = document.getElementById('btnCancelInteraction');
    if (btnCancel && formContainer && addInteractionForm) {
        btnCancel.addEventListener('click', () => {
            formContainer.classList.add('d-none');
            addInteractionForm.reset();
        });
    }

    if (addInteractionForm) {
        addInteractionForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const leadId = activeLeadId;
            const canal = document.getElementById('interaction_canal').value;
            const note = document.getElementById('interaction_note').value;
            const btnSubmit = document.getElementById('btnSubmitInteraction');

            if (!leadId) return;

            btnSubmit.disabled = true;
            btnSubmit.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;

            fetch(`/admin/leads/${leadId}/interaction`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ type_canal: canal, note: note })
            })
            .then(res => res.json())
            .then(data => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = 'Enregistrer';

                if (data.success) {
                    // Masquer et vider le formulaire
                    formContainer.classList.add('d-none');
                    addInteractionForm.reset();

                    // Mettre à jour la vue de l'historique sans rechargement
                    const listContainer = document.getElementById('detailInteractionsContainer');
                    if (listContainer) {
                        if (listContainer.innerHTML.includes('Aucune')) {
                            listContainer.innerHTML = '';
                        }
                        
                        const itemHtml = `
                            <div class="p-3 bg-light rounded-3 d-flex gap-3 align-items-start border border-light mb-2" style="animation: fadeIn 0.4s ease-out;">
                                <div class="avatar-circle rounded-circle p-2 text-white bg-navy text-center" style="width: 28px; height: 28px; font-size: 0.72rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background-color:#0D1B4B;">
                                    <i class="bi bi-chat-left-text"></i>
                                </div>
                                <div>
                                    <span class="fw-bold d-block text-navy fs-8" style="line-height:1.2;">${data.interaction.type_canal} <small class="text-muted fw-normal ms-1">${data.interaction.date}</small></span>
                                    <p class="fs-9 text-muted mb-0 mt-1 leading-relaxed">${data.interaction.note}</p>
                                </div>
                            </div>
                        `;
                        listContainer.insertAdjacentHTML('afterbegin', itemHtml);
                        
                        // Incrémenter le compteur d'historique
                        const countHeader = document.getElementById('detail-interactions-count-header');
                        if (countHeader) {
                            const currentCount = parseInt(countHeader.innerText.replace(/[^0-9]/g, '')) || 0;
                            countHeader.innerText = `Historique (${currentCount + 1})`;
                        }
                    }

                    // Déclencher le Toast de succès
                    window.showToast(data.message, 'Interaction ajoutée');
                }
            })
            .catch(err => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = 'Enregistrer';
                console.error(err);
                alert("Erreur réseau lors de l'enregistrement.");
            });
        });
    }

});
</script>

@endsection