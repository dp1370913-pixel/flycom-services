@extends('layouts.admin')

@section('title', 'Gestion des Devis & Factures | Flycom Services')

@section('content')
<style>
    /* Empêche le curseur de sélection de s'afficher sur les textes statiques (Caret Browsing protection) */
    h1, h2, h3, h4, h5, h6, th, td, span, p, label {
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
    
    /* Style interactif pour le survol des lignes de devis */
    .devis-row {
        cursor: pointer;
        transition: background-color 0.2s ease-in-out, opacity 0.4s ease-out;
    }
    .devis-row:hover {
        background-color: #F8FAFC !important;
    }

    /* Style du bouton d'envoi d'e-mail personnalisé (Image 2) */
    .btn-outline-cyan {
        border: 1px solid #00B4D8 !important;
        color: #00B4D8 !important;
        background-color: transparent !important;
        transition: all 0.2s ease-in-out;
    }
    .btn-outline-cyan:hover {
        background-color: #00B4D8 !important;
        color: #fff !important;
    }

    /* Styles des toasts de notification (Fidèle à vos captures d'écran) */
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

    /* Nettoyage du modal pour supprimer la double scrollbar verticale */
    #detailsDevisModal .modal-body {
        max-height: none !important;
        overflow-y: visible !important;
    }
    
    /* Force l'affichage du menu de statut au-dessus du bouton (Dropup strict) */
    #detail-status-menu {
        top: auto !important;
        bottom: 100% !important;
        margin-top: 0 !important;
        margin-bottom: 8px !important;
    }
    
    /* Styles pour conformer le menu déroulant à l'image du prototype */
    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
    }

    /* 
       RÉSOLUTION DE LA COUPURE DU MENU CONTEXTUEL (Image 1 - Actions) :
       Permet au menu déroulant de déborder proprement en dehors du tableau sans être rogné.
    */
    .card, .table-responsive {
        overflow: visible !important;
    }

    /* Aligne parfaitement le menu déroulant des trois points sur la bordure droite */
    .dropdown-menu-end {
        right: 0 !important;
        left: auto !important;
    }
</style>

<div class="container-fluid py-4">
    
    <!-- Zone de notification Toast flottante (Vidéo) -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1090;"></div>

    <!-- En-tête de la page avec indicateurs KPI Dynamiques (Image 1) -->
    @php
        $totalAcceptes = $devisList->where('statut', 'Accepte')->sum('montant_ttc');
        $totalEnAttente = $devisList->where('statut', 'En_attente')->sum('montant_ttc');
        $countDocuments = $devisList->count();
    @endphp
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-navy mb-1" style="color: #0D1B4B; font-family: 'Segoe UI', sans-serif;">Devis &amp; Factures</h1>
            <p class="text-muted small mb-0 fw-semibold">
                <span id="kpi-count">{{ $countDocuments }}</span> documents · 
                <span id="kpi-acceptes" class="text-success">{{ number_format($totalAcceptes, 0, ',', ' ') }} FCFA</span> acceptés · 
                <span id="kpi-attente" class="text-warning">{{ number_format($totalEnAttente, 0, ',', ' ') }} FCFA</span> en attente
            </p>
        </div>
        <button class="btn btn-cyan rounded-3 px-4 py-2 fw-bold text-white shadow-sm" style="background-color: #00B4D8; border: none;" data-bs-toggle="modal" data-bs-target="#createDevisModal">
            <i class="bi bi-file-earmark-plus-fill me-2"></i> Nouveau devis
        </button>
    </div>

    <!-- Barre de recherche et filtres de l'Image 1 -->
    <div class="card border-0 shadow-sm rounded-4 mb-3" style="background-color: #fff;">
        <div class="card-body py-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-6 position-relative">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" id="devis-search-input" class="form-control bg-light border-0" placeholder="Rechercher un devis...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select id="devis-status-filter" class="form-select bg-light border-0">
                        <option value="all">Tous statuts</option>
                        <option value="En_attente">En attente</option>
                        <option value="Accepte">Accepté</option>
                        <option value="Refuse">Refusé</option>
                        <option value="Expire">Expiré</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau principal des documents (Image 1 - Proportions recalibrées à 100% pour supprimer le scroll gris) -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0" style="background-color: #fff;">
                <thead class="table-light">
                    <tr class="text-muted" style="font-size: 0.85rem; font-weight: 700;">
                        <th class="ps-4" style="width: 12%;">Numéro</th>
                        <th style="width: 20%;">Client</th>
                        <th style="width: 10%;">Type</th>
                        <th style="width: 11%;">Émission</th>
                        <th style="width: 11%;">Expiration</th>
                        <th style="width: 14%;">Montant TTC</th>
                        <th style="width: 10%;">Statut</th>
                        <th style="width: 10%;">Paiement</th>
                        <th class="text-end pe-4" style="width: 2%;">Actions</th>
                    </tr>
                </thead>
                <tbody id="devis-tbody" style="font-size: 0.9rem;">
                    @forelse($devisList as $devis)
                    <tr class="devis-row" id="row-devis-{{ $devis->id_devis }}" data-id="{{ $devis->id_devis }}" data-client="{{ strtolower($devis->client->prenom . ' ' . $devis->client->nom) }}" data-numero="{{ strtolower($devis->numero) }}" data-statut="{{ $devis->statut }}">
                        <td class="ps-4 fw-bold text-navy">
                            <i class="bi bi-file-earmark-text text-muted me-2"></i>{{ $devis->numero }}
                        </td>
                        <td class="fw-semibold text-dark">{{ $devis->client->prenom }} {{ $devis->client->nom }}</td>
                        <td>
                            @if($devis->type === 'Devis')
                                <span class="badge rounded-pill px-3 py-1" style="background-color: #E0F2FE; color: #0284C7; font-size: 0.75rem;">Devis</span>
                            @else
                                <span class="badge rounded-pill px-3 py-1" style="background-color: #ECFDF5; color: #059669; font-size: 0.75rem;">Facture proforma</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ \Carbon\Carbon::parse($devis->date_emission)->format('d/m/Y') }}</td>
                        <td class="text-muted">{{ \Carbon\Carbon::parse($devis->date_expiration)->format('d/m/Y') }}</td>
                        <td class="fw-bold text-navy">{{ number_format($devis->montant_ttc, 0, ',', ' ') }} FCFA</td>
                        <td>
                            @if($devis->statut === 'En_attente')
                                <span class="badge rounded-pill bg-warning-subtle text-warning px-2.5 py-1">En attente</span>
                            @elseif($devis->statut === 'Accepte')
                                <span class="badge rounded-pill bg-success-subtle text-success px-2.5 py-1">Accepté</span>
                            @elseif($devis->statut === 'Refuse')
                                <span class="badge rounded-pill bg-danger-subtle text-danger px-2.5 py-1">Refusé</span>
                            @else
                                <span class="badge rounded-pill bg-secondary-subtle text-secondary px-2.5 py-1">Expiré</span>
                            @endif
                        </td>
                        <td>
                            @if($devis->statut_paiement === 'Non_paye')
                                <span class="text-danger fw-semibold" style="font-size: 0.8rem;">Non payé</span>
                            @elseif($devis->statut_paiement === 'Acompte_recu')
                                <span class="text-warning fw-semibold" style="font-size: 0.8rem;">Acompte reçu</span>
                            @else
                                <span class="text-success fw-semibold" style="font-size: 0.8rem;">Solde</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm rounded-circle shadow-none dropdown-toggle-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3 py-2" style="font-size: 0.85rem; z-index: 1050;">
                                    <li>
                                        <button class="dropdown-item py-2 btn-action-view" data-id="{{ $devis->id_devis }}">
                                            <i class="bi bi-eye text-muted me-2"></i> Voir le détail
                                        </button>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2" href="{{ route('admin.devis.download', $devis->id_devis) }}">
                                            <i class="bi bi-download text-muted me-2"></i> Télécharger PDF
                                        </a>
                                    </li>
                                    <li>
                                        <button class="dropdown-item py-2 text-primary btn-action-convert" data-id="{{ $devis->id_devis }}" data-type="{{ $devis->type }}">
                                            <i class="bi bi-arrow-left-right me-2"></i> Convertir en facture proforma
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item py-2 text-warning btn-action-status" data-id="{{ $devis->id_devis }}">
                                            <i class="bi bi-pencil-square me-2"></i> Modifier le statut
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item py-2 btn-action-duplicate" data-id="{{ $devis->id_devis }}">
                                            <i class="bi bi-copy me-2"></i> Dupliquer
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider opacity-50"></li>
                                    <li>
                                        <button class="dropdown-item py-2 text-danger btn-action-delete" data-id="{{ $devis->id_devis }}" data-numero="{{ $devis->numero }}">
                                            <i class="bi bi-trash3 me-2"></i> Supprimer
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-folder-x fs-2 d-block mb-2"></i> Aucun document commercial enregistré.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL : CRÉATION DE DEVIS (Image 3)        -->
<!-- ========================================== -->
<div class="modal fade" id="createDevisModal" tabindex="-1" aria-labelledby="createDevisModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-navy" id="createDevisModalLabel">Nouveau devis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.devis.store') }}" method="POST" id="createDevisForm">
                @csrf
                <div class="modal-body">
                    <p class="text-muted small mb-4">Prochain n° automatique estimé : <strong class="text-navy">{{ $nextNumber }}</strong></p>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">Client *</label>
                            <select name="id_client" id="client-select" class="form-select border-light-subtle rounded-3 py-2.5" required>
                                <option value="" disabled selected>Sélectionner un client</option>
                                @foreach($clients as $client)
                                <option value="{{ $client->id_client }}">{{ $client->prenom }} {{ $client->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">Type de document *</label>
                            <select name="type" class="form-select border-light-subtle rounded-3 py-2.5" required>
                                <option value="Devis" selected>Devis</option>
                                <option value="Facture_proforma">Facture proforma</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Lead lié (Optionnel)</label>
                        <select name="id_lead" id="lead-select" class="form-select border-light-subtle rounded-3 py-2.5">
                            <option value="" data-client-id="">Aucun lead lié</option>
                            @foreach($leads as $lead)
                            <option value="{{ $lead->id_lead }}" data-client-id="{{ $lead->id_client }}">Lead #{{ $lead->id_lead }} - {{ $lead->client->prenom }} {{ $lead->client->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-navy mb-0" style="font-size: 0.85rem;">LIGNES DE DEVIS</h6>
                        <button type="button" id="btn-add-line" class="btn btn-outline-cyan btn-sm rounded-pill px-3 fw-bold">
                            <i class="bi bi-plus-lg me-1"></i> Ajouter une ligne
                        </button>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-borderless align-middle" id="lignes-table">
                            <thead>
                                <tr class="text-muted small text-uppercase" style="font-size: 0.75rem;">
                                    <th style="width: 50%;">Sélectionner un service</th>
                                    <th style="width: 15%;">Quantité</th>
                                    <th style="width: 25%;">Prix unitaire (FCFA)</th>
                                    <th style="width: 10%;" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="lignes-container">
                                <tr class="ligne-article">
                                    <td>
                                        <select name="lignes[0][id_service]" class="form-select service-select border-light-subtle rounded-3 py-2" required>
                                            <option value="" disabled selected>Choisir un service</option>
                                            @foreach($services as $service)
                                            <option value="{{ $service->id_service }}" data-price="{{ $service->prix_indicatif }}">{{ $service->nom_service }} - {{ number_format($service->prix_indicatif, 0, ',', ' ') }} FCFA</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="lignes[0][quantite]" class="form-control qty-input border-light-subtle rounded-3 py-2 text-center" min="1" value="1" required>
                                    </td>
                                    <td>
                                        <input type="number" name="lignes[0][prix]" class="form-control price-input border-light-subtle rounded-3 py-2 text-end" min="0" value="0" required>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-light text-danger btn-sm rounded-circle btn-remove-line" disabled>
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end text-end border-top pt-4">
                        <div class="col-md-5" style="font-size: 0.9rem;">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total HT :</span>
                                <span class="fw-bold text-navy" id="label-total-ht">0 FCFA</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">TVA (%) :</span>
                                <input type="number" name="tva_percentage" id="input-tva" class="form-control border-light-subtle rounded-3 text-center py-1" style="width: 80px;" min="0" max="100" value="18">
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <span class="h6 fw-bold text-navy mb-0">Total TTC :</span>
                                <span class="h5 fw-extrabold text-cyan mb-0" id="label-total-ttc" style="color: #00B4D8;">0 FCFA</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-navy rounded-pill px-4 text-white" style="background-color: #0D1B4B;">Générer le devis</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL : DÉTAILS D'UN DOCUMENT (Image 2)    -->
<!-- ========================================== -->
<div class="modal fade" id="detailsDevisModal" tabindex="-1" aria-labelledby="detailsDevisModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <div class="w-100">
                    <h5 class="modal-title fw-bold text-navy mb-1" id="detail-numero">DEV-2026-0042</h5>
                    <p class="text-muted small mb-0" id="detail-client-meta">Sylvie MALONGA · Devis</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row g-3 mb-4 mt-1">
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded-3">
                            <span class="d-block small text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Émission</span>
                            <strong class="d-block mt-1" id="detail-emission">24/05/2026</strong>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded-3">
                            <span class="d-block small text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Expiration</span>
                            <strong class="d-block mt-1" id="detail-expiration">23/06/2026</strong>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded-3">
                            <span class="d-block small text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Statut</span>
                            <strong class="d-block mt-1" id="detail-statut">En attente</strong>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded-3">
                            <span class="d-block small text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Paiement</span>
                            <strong class="d-block mt-1" id="detail-paiement">Non payé</strong>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold text-navy mb-3">Détail des lignes</h6>
                <div class="table-responsive mb-4 border rounded-3">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Service</th>
                                <th class="text-center" style="width: 10%;">Qté</th>
                                <th class="text-end" style="width: 25%;">Prix unit.</th>
                                <th class="text-end pe-3" style="width: 25%;">Total</th>
                            </tr>
                        </thead>
                        <tbody id="detail-lignes-tbody"></tbody>
                    </table>
                </div>

                <div class="row justify-content-end text-end mb-1">
                    <div class="col-md-5" style="font-size: 0.9rem;">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total HT :</span>
                            <span class="fw-bold text-navy" id="detail-total-ht">0 FCFA</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-2">
                            <span class="h6 fw-bold text-navy mb-0">Total TTC :</span>
                            <span class="h5 fw-extrabold text-navy mb-0" id="detail-total-ttc">0 FCFA</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions de l'Image 2 (Intègre désormais le menu de statut Dropup exact à votre image de prototype) -->
            <div class="modal-footer border-top-0 pt-0 d-flex flex-wrap gap-2 justify-content-between">
                <div class="d-flex gap-2">
                    <a href="#" id="btn-download-pdf" class="btn btn-navy rounded-pill px-3 py-2 fw-bold text-white fs-8" style="background-color: #0D1B4B; text-decoration: none;">
                        <i class="bi bi-download me-1"></i> Télécharger PDF
                    </a>
                    <button type="button" id="btn-trigger-email" class="btn btn-outline-cyan rounded-pill px-3 py-2 fw-bold fs-8">
                        <i class="bi bi-envelope me-1"></i> Envoyer par email
                    </button>
                </div>
                <div class="d-flex gap-2">
                    <!-- Menu déroulant Dropup à pastilles de couleur fidèlement modélisé (Image de votre prototype et data-bs-display static anti-clipping) -->
                    <div class="dropdown dropup" id="status-dropdown-wrapper">
                        <button class="btn btn-light rounded-pill px-3 py-2 fw-bold fs-8 dropdown-toggle" type="button" id="btn-status-dropdown" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" style="border: 2px solid #000; color: #4F5E7B; background-color: #F8FAFC;">
                            Modifier le statut
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3 p-2" aria-labelledby="btn-status-dropdown" id="detail-status-menu" style="min-width: 180px; margin-bottom: 8px !important;">
                            <!-- Les options statiques sont définies ici pour éviter les bugs de liaison dynamique du clic -->
                            <li>
                                <button type="button" class="dropdown-item py-2.5 d-flex align-items-center gap-2 fw-semibold" style="font-size: 0.85rem;" onclick="updateDocumentStatus(activeDevisId, 'En_attente')">
                                    <span class="rounded-circle d-inline-block" style="width: 10px; height: 10px; background-color: #F59E0B;"></span>
                                    En attente
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item py-2.5 d-flex align-items-center gap-2 fw-semibold" style="font-size: 0.85rem;" onclick="updateDocumentStatus(activeDevisId, 'Accepte')">
                                    <span class="rounded-circle d-inline-block" style="width: 10px; height: 10px; background-color: #10B981;"></span>
                                    Accepté
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item py-2.5 d-flex align-items-center gap-2 fw-semibold" style="font-size: 0.85rem;" onclick="updateDocumentStatus(activeDevisId, 'Refuse')">
                                    <span class="rounded-circle d-inline-block" style="width: 10px; height: 10px; background-color: #EF4444;"></span>
                                    Refusé
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item py-2.5 d-flex align-items-center gap-2 fw-semibold" style="font-size: 0.85rem;" onclick="updateDocumentStatus(activeDevisId, 'Expire')">
                                    <span class="rounded-circle d-inline-block" style="width: 10px; height: 10px; background-color: #9CA3AF;"></span>
                                    Expiré
                                </button>
                            </li>
                        </ul>
                    </div>
                    <button type="button" id="btn-delete-devis" class="btn btn-outline-danger rounded-pill px-3 py-2 fw-bold fs-8">
                        <i class="bi bi-trash3-fill me-1"></i> Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL : ENVOI DE MAIL                      -->
<!-- ========================================== -->
<div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-navy" id="sendEmailModalLabel">Envoyer par email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="sendEmailForm">
                <div class="modal-body">
                    <input type="hidden" id="email-devis-id">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Destinataire</label>
                        <input type="email" id="email-destinataire" class="form-control border-light-subtle rounded-3 py-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Objet</label>
                        <input type="text" id="email-objet" class="form-control border-light-subtle rounded-3 py-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Message</label>
                        <textarea id="email-message" class="form-control border-light-subtle rounded-3 py-2 text-muted" rows="6" style="font-size: 0.85rem;" required></textarea>
                    </div>
                    <p class="text-muted" style="font-size: 0.75rem; border-top: 1px solid #F1F5F9; padding-top: 10px;">
                        <i class="bi bi-paperclip me-1"></i> Le PDF de votre document sera joint automatiquement à votre envoi.
                    </p>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" id="btn-submit-email" class="btn btn-cyan text-white rounded-pill px-4" style="background-color: #00B4D8; border: none;">
                        <i class="bi bi-send-fill me-1"></i> Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL : CONFIRMATION DE SUPPRESSION        -->
<!-- ========================================== -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content border-0 shadow rounded-4 text-center p-4">
            <div class="text-danger mb-3">
                <i class="bi bi-exclamation-triangle-fill" style="font-size: 3rem;"></i>
            </div>
            <h5 class="fw-bold text-navy mb-2" id="delete-confirm-title">Supprimer ce document ?</h5>
            <p class="text-muted small px-3" id="delete-confirm-body">Êtes-vous sûr de vouloir supprimer ce document commercial ? Cette action est définitive et irréversible.</p>
            <div class="d-flex gap-2 justify-content-center mt-3">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Annuler</button>
                <button type="button" id="btn-confirm-delete-action" class="btn btn-danger rounded-pill px-4">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- CHARGEMENT DE BOOTSTRAP JS ET LOGIQUE      -->
<!-- ========================================== -->

<!-- CDN de secours pour exposer globalement l'objet 'bootstrap' (Résout l'erreur ReferenceError) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    const servicesList = @json($services);
    let ligneIndex = 1;

    // Instances globales des Modals
    let detailsModal = null;
    let emailModal = null;
    let deleteModal = null;
    
    // État applicatif de transaction
    let activeDevisId = null;
    let activeDevisNumero = '';
    let activeClientEmail = '';
    let activeClientName = '';

    document.addEventListener('DOMContentLoaded', () => {
        // Sélection sécurisée de l'objet Bootstrap global
        const bs = window.bootstrap;
        
        if (!bs) {
            console.error("Flycom Error : Le fichier Bootstrap JS n'est toujours pas détecté.");
            return;
        }

        // Initialisation des modals d'action
        try {
            const detailsEl = document.getElementById('detailsDevisModal');
            const emailEl = document.getElementById('sendEmailModal');
            const deleteEl = document.getElementById('deleteConfirmModal');

            if (detailsEl) detailsModal = new bs.Modal(detailsEl);
            if (emailEl) emailModal = new bs.Modal(emailEl);
            if (deleteEl) deleteModal = new bs.Modal(deleteEl);
        } catch (e) {
            console.error("Flycom Error : Échec de l'initialisation des modals Bootstrap :", e);
            return;
        }

        // ========================================================
        // 1. RECHERCHE ET FILTRES DYNAMIQUES (Image 1 & Vidéo)
        // ========================================================
        const searchInput = document.getElementById('devis-search-input');
        const statusFilter = document.getElementById('devis-status-filter');
        const rows = document.querySelectorAll('.devis-row');

        function filterRows() {
            const query = (searchInput?.value || '').toLowerCase().trim();
            const statusVal = statusFilter?.value || 'all';

            rows.forEach(row => {
                const rowNumero = row.getAttribute('data-numero') || '';
                const rowClient = row.getAttribute('data-client') || '';
                const rowStatut = row.getAttribute('data-statut') || '';

                const matchesSearch = rowNumero.includes(query) || rowClient.includes(query);
                const matchesStatus = (statusVal === 'all' || rowStatut === statusVal);

                row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });
        }

        if (searchInput) searchInput.addEventListener('input', filterRows);
        if (statusFilter) statusFilter.addEventListener('change', filterRows);

        // ========================================================
        // 2. CLIC INTERACTIF SUR CHAQUE LIGNE (Ouverture détails)
        // ========================================================
        rows.forEach(row => {
            row.addEventListener('click', (e) => {
                if (e.target.closest('.dropdown') || e.target.closest('.dropdown-menu')) {
                    return;
                }
                const devisId = row.getAttribute('data-id');
                if (devisId) {
                    openDetailsModal(devisId);
                }
            });
        });

        // ========================================================
        // 3. ACTION MENU DÉLÉGUÉE (Menu contextuel de la ligne & Ouverture manuelle robuste)
        // ========================================================
        const tbody = document.getElementById('devis-tbody');
        if (tbody) {
            tbody.addEventListener('click', (e) => {
                const viewBtn = e.target.closest('.btn-action-view');
                const convertBtn = e.target.closest('.btn-action-convert');
                const duplicateBtn = e.target.closest('.btn-action-duplicate');
                const deleteBtn = e.target.closest('.btn-action-delete');
                const statusBtn = e.target.closest('.btn-action-status');
                const toggleBtn = e.target.closest('.dropdown-toggle-btn');

                // Traiter l'ouverture manuelle des trois points (Résout le blocage de clic)
                if (toggleBtn) {
                    e.preventDefault();
                    e.stopPropagation();
                    const menu = toggleBtn.nextElementSibling;
                    if (menu) {
                        document.querySelectorAll('.dropdown-menu.show').forEach(openMenu => {
                            if (openMenu !== menu) openMenu.classList.remove('show');
                        });
                        menu.classList.toggle('show');
                    }
                    return;
                }

                if (viewBtn) {
                    openDetailsModal(viewBtn.getAttribute('data-id'));
                }
                if (convertBtn) {
                    convertDocument(convertBtn.getAttribute('data-id'), convertBtn.getAttribute('data-type'));
                }
                if (duplicateBtn) {
                    duplicateDocument(duplicateBtn.getAttribute('data-id'));
                }
                if (deleteBtn) {
                    triggerDeleteModal(deleteBtn.getAttribute('data-id'), deleteBtn.getAttribute('data-numero'));
                }
                if (statusBtn) {
                    const id = statusBtn.getAttribute('data-id');
                    openDetailsModal(id);
                    setTimeout(() => {
                        const menuStatus = document.getElementById('detail-status-menu');
                        if (menuStatus) menuStatus.classList.add('show');
                    }, 500);
                }
            });
        }

        // ========================================================
        // 4. LIAISON UNIQUE DES BOUTONS DE DETAILS (Image 2)
        // ========================================================
        const btnDownloadPdf = document.getElementById('btn-download-pdf');
        if (btnDownloadPdf) {
            btnDownloadPdf.addEventListener('click', (e) => {
                if (!activeDevisId) {
                    e.preventDefault();
                    return;
                }
                btnDownloadPdf.setAttribute('href', `{{ url('admin/devis') }}/${activeDevisId}/download`);
            });
        }

        const btnTriggerEmail = document.getElementById('btn-trigger-email');
        if (btnTriggerEmail) {
            btnTriggerEmail.addEventListener('click', () => {
                if (detailsModal) detailsModal.hide();
                setTimeout(() => {
                    openEmailModal(activeDevisId, activeClientEmail, activeDevisNumero, activeClientName);
                }, 400);
            });
        }

        const btnDeleteDevis = document.getElementById('btn-delete-devis');
        if (btnDeleteDevis) {
            btnDeleteDevis.addEventListener('click', () => {
                if (detailsModal) detailsModal.hide();
                setTimeout(() => {
                    triggerDeleteModal(activeDevisId, activeDevisNumero);
                }, 400);
            });
        }

        // ========================================================
        // 4.1 OUVERTURE MANUELLE ROBUSTE DU STATUT DANS LE MODAL (Résout définitivement le problème de masquage)
        // ========================================================
        const btnStatusDropdown = document.getElementById('btn-status-dropdown');
        const detailStatusMenu = document.getElementById('detail-status-menu');

        if (btnStatusDropdown && detailStatusMenu) {
            btnStatusDropdown.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                detailStatusMenu.classList.toggle('show');
            });
        }

        // Fermer tous les menus déroulants ouverts si l'utilisateur clique en dehors de l'écran
        document.addEventListener('click', (e) => {
            if (detailStatusMenu && !detailStatusMenu.contains(e.target) && e.target !== btnStatusDropdown) {
                detailStatusMenu.classList.remove('show');
            }
            if (!e.target.closest('.dropdown-menu') && !e.target.closest('.dropdown-toggle-btn') && !e.target.closest('#btn-status-dropdown')) {
                document.querySelectorAll('.dropdown-menu.show').forEach(openMenu => {
                    openMenu.classList.remove('show');
                });
            }
        });

        // ========================================================
        // 5. CRÉATION DU DOCUMENT ET AUTOCOMPLÉTION (Image 3)
        // ========================================================
        const btnAddLine = document.getElementById('btn-add-line');
        const lignesContainer = document.getElementById('lignes-container');
        const inputTva = document.getElementById('input-tva');
        const leadSelect = document.getElementById('lead-select');
        const clientSelect = document.getElementById('client-select');

        // Liaison Automatique Client / Opportunité
        if (leadSelect && clientSelect) {
            leadSelect.addEventListener('change', () => {
                const selectedOption = leadSelect.options[leadSelect.selectedIndex];
                const clientId = selectedOption.getAttribute('data-client-id');
                if (clientId) {
                    clientSelect.value = clientId;
                }
            });
        }

        if (btnAddLine) {
            btnAddLine.addEventListener('click', () => {
                const tr = document.createElement('tr');
                tr.classList.add('ligne-article');
                
                let options = '<option value="" disabled selected>Choisir un service</option>';
                servicesList.forEach(service => {
                    options += `<option value="${service.id_service}" data-price="${service.prix_indicatif}">${service.nom_service} - ${new Intl.NumberFormat('fr-FR').format(service.prix_indicatif)} FCFA</option>`;
                });

                tr.innerHTML = `
                    <td>
                        <select name="lignes[${ligneIndex}][id_service]" class="form-select service-select border-light-subtle rounded-3 py-2" required>
                            ${options}
                        </select>
                    </td>
                    <td>
                        <input type="number" name="lignes[${ligneIndex}][quantite]" class="form-control qty-input border-light-subtle rounded-3 py-2 text-center" min="1" value="1" required>
                    </td>
                    <td>
                        <input type="number" name="lignes[${ligneIndex}][prix]" class="form-control price-input border-light-subtle rounded-3 py-2 text-end" min="0" value="0" required>
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-light text-danger btn-sm rounded-circle btn-remove-line">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </td>
                `;

                lignesContainer.appendChild(tr);
                ligneIndex++;
                toggleRemoveButtons();
                setupLineListeners(tr);
                calculateFormTotals();
            });
        }

        const firstLine = document.querySelector('.ligne-article');
        if (firstLine) {
            setupLineListeners(firstLine);
        }

        if (inputTva) {
            inputTva.addEventListener('input', calculateFormTotals);
        }

        function setupLineListeners(row) {
            const select = row.querySelector('.service-select');
            const qtyInput = row.querySelector('.qty-input');
            const priceInput = row.querySelector('.price-input');
            const removeBtn = row.querySelector('.btn-remove-line');

            select.addEventListener('change', () => {
                const selectedOption = select.options[select.selectedIndex];
                const basePrice = selectedOption.getAttribute('data-price') || 0;
                priceInput.value = basePrice;
                calculateFormTotals();
            });

            qtyInput.addEventListener('input', calculateFormTotals);
            priceInput.addEventListener('input', calculateFormTotals);

            if (removeBtn) {
                removeBtn.addEventListener('click', () => {
                    row.remove();
                    toggleRemoveButtons();
                    calculateFormTotals();
                });
            }
        }

        function toggleRemoveButtons() {
            const allRows = document.querySelectorAll('.ligne-article');
            allRows.forEach(row => {
                const btn = row.querySelector('.btn-remove-line');
                if (btn) {
                    btn.disabled = allRows.length === 1;
                }
            });
        }

        function calculateFormTotals() {
            let totalHt = 0;
            const allRows = document.querySelectorAll('.ligne-article');
            
            allRows.forEach(row => {
                const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                totalHt += qty * price;
            });

            const tvaPercent = parseFloat(inputTva.value) || 0;
            const totalTva = totalHt * (tvaPercent / 100);
            const totalTtc = totalHt + totalTva;

            document.getElementById('label-total-ht').innerText = formatCurrency(totalHt);
            document.getElementById('label-total-ttc').innerText = formatCurrency(totalTtc);
        }

        function formatCurrency(value) {
            return new Intl.NumberFormat('fr-FR').format(value) + ' FCFA';
        }

        // ========================================================
        // 6. FORMULAIRE ENVOI E-MAIL
        // ========================================================
        const emailForm = document.getElementById('sendEmailForm');
        if (emailForm) {
            emailForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const devisId = document.getElementById('email-devis-id').value;
                const btnSubmit = document.getElementById('btn-submit-email');

                btnSubmit.disabled = true;
                btnSubmit.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Envoi...`;

                const payload = {
                    destinataire: document.getElementById('email-destinataire').value,
                    objet: document.getElementById('email-objet').value,
                    message: document.getElementById('email-message').value
                };

                const url = `{{ url('admin/devis') }}/${devisId}/send-email`;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    btnSubmit.disabled = false;
                    btnSubmit.innerHTML = `<i class="bi bi-send-fill me-1"></i> Envoyer`;
                    if (data.success) {
                        showToast(data.message, 'E-mail envoyé');
                        if (emailModal) emailModal.hide();
                    } else {
                        showToast("Une erreur s'est produite lors de l'envoi de l'e-mail.", 'Erreur', 5000);
                    }
                })
                .catch(err => {
                    btnSubmit.disabled = false;
                    btnSubmit.innerHTML = `<i class="bi bi-send-fill me-1"></i> Envoyer`;
                    showToast("Impossible de joindre le serveur de messagerie.", 'Erreur', 5000);
                });
            });
        }
    });

    // ========================================================
    // 7. TOASTS D'ACTIONS CONSOLE DE NOTIFICATION (Fidèle à vos captures d'écran)
    // ========================================================
    window.showToast = function(message, title = 'Notification', duration = 4000) {
        const container = document.querySelector('.toast-container');
        if (!container) return;
        const id = 'toast-' + Date.now();
        
        let customClass = 'toast-custom-info';
        let iconHtml = '<i class="bi bi-info-circle-fill me-1"></i>';
        
        if (message.includes('Gagné') || message.includes('supprimé') || message.includes('créé') || message.includes('converti')) {
            customClass = 'toast-custom-success';
            iconHtml = '<i class="bi bi-check-circle-fill me-1"></i>';
        }

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
        const bsToast = new bs.Toast(toastElement, { delay: duration });
        bsToast.show();
        toastElement.addEventListener('hidden.bs.toast', () => {
            toastElement.remove();
        });
    };

    // ========================================================
    // 8. APPEL DE DÉTAILS AJAX (Image 2)
    // ========================================================
    window.openDetailsModal = function(devisId) {
        const url = `{{ url('admin/devis') }}/${devisId}/details`;

        fetch(url)
            .then(res => {
                if (!res.ok) throw new Error("Erreur de communication avec le serveur");
                return res.json();
            })
            .then(data => {
                activeDevisId = data.id_devis;
                activeDevisNumero = data.numero;
                activeClientEmail = data.client_email;
                activeClientName = data.client_name;

                document.getElementById('detail-numero').innerText = data.numero;
                document.getElementById('detail-client-meta').innerText = `${data.client_name} · ${data.type}`;
                document.getElementById('detail-emission').innerText = data.date_emission;
                document.getElementById('detail-expiration').innerText = data.date_expiration;
                
                const statutEl = document.getElementById('detail-statut');
                if (data.statut === 'En_attente') {
                    statutEl.innerHTML = '<span class="badge rounded-pill bg-warning-subtle text-warning">En attente</span>';
                } else if (data.statut === 'Accepte') {
                    statutEl.innerHTML = '<span class="badge rounded-pill bg-success-subtle text-success">Accepté</span>';
                } else if (data.statut === 'Refuse') {
                    statutEl.innerHTML = '<span class="badge rounded-pill bg-danger-subtle text-danger">Refusé</span>';
                } else {
                    statutEl.innerHTML = '<span class="badge rounded-pill bg-secondary-subtle text-secondary">Expiré</span>';
                }

                const paiementEl = document.getElementById('detail-paiement');
                if (data.statut_paiement === 'Non_paye') {
                    paiementEl.innerHTML = '<span class="text-danger fw-semibold">Non payé</span>';
                } else if (data.statut_paiement === 'Acompte_recu') {
                    paiementEl.innerHTML = '<span class="text-warning fw-semibold">Acompte reçu</span>';
                } else {
                    paiementEl.innerHTML = '<span class="text-success fw-semibold">Solde</span>';
                }

                document.getElementById('detail-total-ht').innerText = `${data.montant_ht} FCFA`;
                document.getElementById('detail-total-ttc').innerText = `${data.montant_ttc} FCFA`;

                const tbody = document.getElementById('detail-lignes-tbody');
                tbody.innerHTML = '';
                data.lignes.forEach(ligne => {
                    tbody.innerHTML += `
                        <tr>
                            <td class="ps-3">
                                <strong>${ligne.nom_service}</strong><br>
                                <small class="text-muted" style="font-size: 0.75rem;">${ligne.description}</small>
                            </td>
                            <td class="text-center">${ligne.quantite}</td>
                            <td class="text-end">${ligne.prix} F</td>
                            <td class="text-end pe-3 fw-bold text-navy">${ligne.total} F</td>
                        </tr>
                    `;
                });

                if (detailsModal) detailsModal.show();
            })
            .catch(err => {
                showToast("Erreur de récupération des détails du document.", 'Erreur');
            });
    };

    // ========================================================
    // 9. CONVERSION DU DOCUMENT (Image 1)
    // ========================================================
    window.convertDocument = function(id, currentType) {
        const checkType = (currentType || '').toLowerCase();
        if (checkType !== 'devis') {
            showToast("Seuls les devis peuvent être convertis en Facture Proforma.", 'Action impossible');
            return;
        }

        const url = `{{ url('admin/devis') }}/${id}/convert`;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'Conversion réussie');
                setTimeout(() => location.reload(), 1200);
            } else {
                showToast(data.message, 'Erreur de conversion');
            }
        });
    };

    // ========================================================
    // 10. DUPLICATION DE DOCUMENT (Image 1)
    // ========================================================
    window.duplicateDocument = function(id) {
        const url = `{{ url('admin/devis') }}/${id}/duplicate`;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'Document dupliqué');
                setTimeout(() => location.reload(), 1200);
            } else {
                showToast("Erreur lors de la duplication.", 'Erreur');
            }
        });
    };

    // ========================================================
    // 11. SÉCURISATION DU STATUT ET PROCESSUS CRM (Image 2)
    // ========================================================
    window.updateDocumentStatus = function(id, statut) {
        const url = `{{ url('admin/devis') }}/${id}/update-status`;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ statut: statut })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (statut === 'Accepte' && data.crm_action) {
                    showToast('Statut changé : Accepté', 'Statut document', 4000);
                    setTimeout(() => {
                        showToast('Lead lié passé à "Gagné" et client passé à "Client"', 'Processus CRM', 5000);
                    }, 400);
                } else {
                    showToast(data.message, 'Statut document');
                }
                setTimeout(() => location.reload(), 2000);
            }
        });
    };

    // ========================================================
    // 12. SUPPRESSION FLUIDE DU DOCUMENT (Image 1, 2 & Vidéo)
    // ========================================================
    window.triggerDeleteModal = function(id, numero) {
        activeDevisId = id;
        document.getElementById('delete-confirm-title').innerText = `Supprimer le document ${numero} ?`;
        if (deleteModal) deleteModal.show();
    };

    const confirmDeleteBtn = document.getElementById('btn-confirm-delete-action');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', () => {
            if (activeDevisId) {
                const url = `{{ url('admin/devis') }}/${activeDevisId}/delete`;

                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (deleteModal) deleteModal.hide();
                    if (data.success) {
                        const targetRow = document.getElementById(`row-devis-${activeDevisId}`);
                        if (targetRow) {
                            targetRow.style.opacity = '0';
                            targetRow.style.transition = 'opacity 0.6s ease-out';
                            showToast(`Le document commercial a été supprimé du CRM.`, 'Document supprimé');
                            setTimeout(() => {
                                targetRow.remove();
                                location.reload();
                            }, 600);
                        } else {
                            location.reload();
                        }
                    } else {
                        showToast("Erreur lors de la suppression.", 'Erreur');
                    }
                })
                .catch(err => {
                    if (deleteModal) deleteModal.hide();
                    showToast("Erreur réseau.", 'Erreur');
                });
            }
        });
    }

    // ========================================================
    // 13. CONFIGURATION INITIALE DE L'EMAIL
    // ========================================================
    window.openEmailModal = function(devisId, email, docNumero, clientNom) {
        document.getElementById('email-devis-id').value = devisId;
        document.getElementById('email-destinataire').value = email || '';
        document.getElementById('email-objet').value = `Devis ${docNumero} — Flycom Services`;
        
        document.getElementById('email-message').value = `Bonjour ${clientNom || ''},\n\n` +
            `Veuillez trouver ci-joint notre devis ${docNumero}.\n\n` +
            `Cordialement,\n` +
            `L'équipe Flycom Services`;

        if (emailModal) emailModal.show();
    };
</script>
@endsection