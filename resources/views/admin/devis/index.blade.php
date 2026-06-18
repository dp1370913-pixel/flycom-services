@extends('layouts.admin')

@section('title', 'Gestion de la Facturation | Flycom Services CRM')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
    <div>
        <h1 class="h3 fw-extrabold text-navy mb-1">Devis &amp; Factures</h1>
        <p class="text-muted fs-8 mb-0">{{ $devisList->count() }} documents enregistrés</p>
    </div>
    <div class="mt-3 mt-md-0">
        <button class="btn btn-cyan rounded-3 fs-8 fw-bold px-3 py-2 shadow-cyan-btn" data-bs-toggle="modal" data-bs-target="#newDevisModal"><i class="bi bi-file-earmark-plus me-1"></i> Nouveau devis</button>
    </div>
</div>

<!-- Zone de notification de succès temporaire -->
<div id="actionAlert" class="alert alert-success fs-8 py-2.5 rounded-3 d-none mb-4 border-0">
    <!-- Injecté par JS -->
</div>

<!-- VUE TABLEAU DE FACTURATION (Image 1 - Avec support d'unstacking responsive mobile) -->
<div class="card border-0 shadow-sm p-4 bg-white rounded-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 fs-8 responsive-table-to-cards">
            <thead class="table-light">
                <tr>
                    <th scope="col">Numéro</th>
                    <th scope="col">Client</th>
                    <th scope="col">Type</th>
                    <th scope="col">Émission</th>
                    <th scope="col">Expiration</th>
                    <th scope="col">Montant TTC</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Paiement</th>
                    <th scope="col" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($devisList as $doc)
                <tr id="devisRow{{ $doc->id_devis }}">
                    <!-- Chaque cellule de données possède des attributs de liaison pour l'AJAX -->
                    <td data-label="Numéro" class="fw-bold text-navy btn-view-devis" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#devisDetailsModal" data-id="{{ $doc->id_devis }}"><i class="bi bi-file-earmark-text text-muted me-2"></i>{{ $doc->numero }}</td>
                    <td data-label="Client" class="fw-bold btn-view-devis" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#devisDetailsModal" data-id="{{ $doc->id_devis }}">{{ $doc->client->prenom }} {{ $doc->client->nom }}</td>
                    <td data-label="Type" class="btn-view-devis" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#devisDetailsModal" data-id="{{ $doc->id_devis }}">
                        <span class="badge {{ $doc->type === 'Devis' ? 'bg-primary-soft text-primary' : 'bg-info-soft text-info' }} px-2 py-1 rounded-3">
                            {{ str_replace('_', ' ', $doc->type) }}
                        </span>
                    </td>
                    <td data-label="Émission" class="text-muted btn-view-devis" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#devisDetailsModal" data-id="{{ $doc->id_devis }}">{{ \Carbon\Carbon::parse($doc->date_emission)->format('d/m/Y') }}</td>
                    <td data-label="Expiration" class="text-muted btn-view-devis" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#devisDetailsModal" data-id="{{ $doc->id_devis }}">{{ \Carbon\Carbon::parse($doc->date_expiration)->format('d/m/Y') }}</td>
                    <td data-label="Montant TTC" class="fw-bold text-navy btn-view-devis" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#devisDetailsModal" data-id="{{ $doc->id_devis }}">{{ number_format($doc->montant_ttc, 0, ',', ' ') }} FCFA</td>
                    <td data-label="Statut" class="btn-view-devis" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#devisDetailsModal" data-id="{{ $doc->id_devis }}">
                        <span class="badge @if($doc->statut === 'Accepte') bg-success-soft text-success @elseif($doc->statut === 'En_attente') bg-warning-soft text-warning @else bg-danger-soft text-danger @endif px-2 py-1 rounded-3">
                            {{ str_replace('_', ' ', $doc->statut) }}
                        </span>
                    </td>
                    <td data-label="Paiement" class="btn-view-devis" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#devisDetailsModal" data-id="{{ $doc->id_devis }}">
                        <span class="badge @if($doc->statut_paiement === 'Solde') bg-success-soft text-success @elseif($doc->statut_paiement === 'Acompte_recu') bg-info-soft text-info @else bg-danger-soft text-danger @endif px-2 py-1 rounded-3">
                            {{ str_replace('_', ' ', $doc->statut_paiement) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm border-0 rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end fs-8">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#devisDetailsModal" data-id="{{ $doc->id_devis }}"><i class="bi bi-eye me-2"></i> Voir le détail</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.devis.print', $doc->id_devis) }}" target="_blank"><i class="bi bi-printer me-2"></i> Télécharger PDF</a></li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#"><i class="bi bi-arrow-left-right me-2"></i> Changer le statut</a>
                                    <ul class="dropdown-menu fs-8 shadow-sm">
                                        <li><button type="button" class="dropdown-item btn-quick-status" data-id="{{ $doc->id_devis }}" data-status="En_attente"><i class="bi bi-circle-fill me-2 status-dot-orange"></i> En attente</button></li>
                                        <li><button type="button" class="dropdown-item btn-quick-status" data-id="{{ $doc->id_devis }}" data-status="Accepte"><i class="bi bi-circle-fill me-2 status-dot-green"></i> Accepté</button></li>
                                        <li><button type="button" class="dropdown-item btn-quick-status" data-id="{{ $doc->id_devis }}" data-status="Refuse"><i class="bi bi-circle-fill me-2 status-dot-red"></i> Refusé</button></li>
                                    </ul>
                                </li>
                                @if($doc->type === 'Devis')
                                <li>
                                    <form action="{{ route('admin.devis.convert', $doc->id_devis) }}" method="POST" class="mb-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-success"><i class="bi bi-arrow-left-right me-2"></i> Convertir en facture proforma</button>
                                    </form>
                                </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li><button type="button" class="dropdown-item text-danger btn-delete-devis" data-id="{{ $doc->id_devis }}"><i class="bi bi-trash me-2"></i> Supprimer</button></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-5">Aucun document comptable émis pour le moment.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL 1 : VOIR LE DÉTAIL D'UN DEVIS (Image 2) -->
<!-- ========================================== -->
<div class="modal fade" id="devisDetailsModal" tabindex="-1" aria-labelledby="devisDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg bg-white text-navy">
            <div class="modal-header border-0 px-4 pt-4 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="modal-title fw-extrabold text-navy fs-5" id="detailDevisNum">DEV-2026-0042</h5>
                    <!-- Badge de statut en haut conforme (Image 2) -->
                    <span class="badge" id="detailHeaderStatus" style="font-size: 0.72rem; padding: 4px 10px; border-radius: 50px;">En attente</span>
                </div>
                <button type="button" class="btn-close shadow-none align-self-start" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="px-4"><small class="text-muted fs-8" id="detailDevisClientMeta">Stéphane MOUTOU · Devis</small></div>
            
            <div class="modal-body px-4 py-3 fs-8">
                
                <!-- Grille bicolore des métadonnées -->
                <div class="row g-2 mb-4 text-start">
                    <div class="col-6 col-md-3">
                        <div class="p-3 rounded-3" style="background:#F8FAFC;">
                            <span class="field-label" style="color:#94A3B8;">Émission</span>
                            <span class="fw-bold d-block text-navy mt-1" id="detailEmission">24/05/2026</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 rounded-3" style="background:#F8FAFC;">
                            <span class="field-label" style="color:#94A3B8;">Expiration</span>
                            <span class="fw-bold d-block text-navy mt-1" id="detailExpiration">23/06/2026</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 rounded-3" style="background:#F8FAFC;">
                            <span class="field-label" style="color:#94A3B8;">Statut</span>
                            <span class="fw-bold d-block mt-1" id="detailStatut">En attente</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 rounded-3" style="background:#F8FAFC;">
                            <span class="field-label" style="color:#94A3B8;">Paiement</span>
                            <span class="fw-bold d-block text-navy mt-1" id="detailPaiement">Non payé</span>
                        </div>
                    </div>
                </div>

                <!-- Lignes d'articles facturées -->
                <h3 class="h6 fw-extrabold text-navy mb-3">Détail des lignes</h3>
                <div class="table-responsive rounded-3 border border-light bg-white mb-4">
                    <table class="table align-middle mb-0 fs-8" id="detailLinesTable">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 50%;">Service</th>
                                <th scope="col" class="text-center" style="width: 10%;">Qté</th>
                                <th scope="col" class="text-end" style="width: 20%;">Prix unit.</th>
                                <th scope="col" class="text-end" style="width: 20%;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Injecté par AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- Récapitulatif financier -->
                <div class="row justify-content-end text-end mb-2">
                    <div class="col-md-5">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-semibold">Total HT</span>
                            <span class="fw-bold text-navy" id="detailTotalHt">0 FCFA</span>
                        </div>
                        <div class="d-flex justify-content-between border-top border-light pt-2" style="font-size: 1.1rem;">
                            <span class="fw-bold text-navy">Total TTC</span>
                            <span class="fw-extrabold text-navy" id="detailTotalTtc">0 FCFA</span>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="modal-footer border-0 px-4 pb-4 pt-0 d-flex gap-2">
                <!-- Actions de Fiches -->
                <a href="#" id="btnPrintLink" target="_blank" class="btn text-white fw-bold px-4 py-2.5" style="background:#0D1B4B; border-radius: 8px; font-size:0.8rem;"><i class="bi bi-file-earmark-pdf-fill me-1"></i> Télécharger PDF</a>
                <button type="button" id="btnOpenEmailModal" class="btn btn-outline-cyan fw-bold px-4 py-2.5" style="border-radius: 8px; font-size:0.8rem; border-color: #00D2F4; color: #00D2F4;" data-bs-toggle="modal" data-bs-target="#sendEmailModal" data-bs-dismiss="modal"><i class="bi bi-envelope-fill me-1"></i> Envoyer par email</button>
                <div class="flex-grow-1"></div>
                <!-- Sélecteur rapide de statut -->
                <div class="dropup">
                    <button class="btn btn-outline-secondary fw-semibold px-4 py-2.5 dropdown-toggle" type="button" data-bs-toggle="dropdown" style="border-radius: 8px; font-size:0.8rem;">Modifier le statut</button>
                    <ul class="dropdown-menu fs-8">
                        <li><button type="button" class="dropdown-item text-warning btn-modal-status-update" data-status="En_attente"><i class="bi bi-circle-fill me-2 fs-10 status-dot-orange"></i> En attente</button></li>
                        <li><button type="button" class="dropdown-item text-success btn-modal-status-update" data-status="Accepte"><i class="bi bi-circle-fill me-2 fs-10 status-dot-green"></i> Accepté</button></li>
                        <li><button type="button" class="dropdown-item text-danger btn-modal-status-update" data-status="Refuse"><i class="bi bi-circle-fill me-2 fs-10 status-dot-red"></i> Refusé</button></li>
                    </ul>
                </div>
                <button type="button" id="btnDeleteModal" class="btn btn-outline-danger fw-semibold px-4 py-2.5" style="border-radius: 8px; font-size:0.8rem;"><i class="bi bi-trash me-1"></i> Supprimer</button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL 2 : ENVOYER PAR EMAIL (Image 3)      -->
<!-- ========================================== -->
<div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg bg-white text-navy">
            <div class="modal-header border-bottom border-light px-4 py-3">
                <h5 class="modal-title fw-bold text-navy" id="sendEmailModalLabel" style="font-size: 1.15rem;">Envoyer par email</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-4 fs-8">
                <form id="emailForm">
                    <!-- Destinataire -->
                    <div class="mb-3">
                        <label for="emailDestinataire" class="form-label fw-bold text-muted text-uppercase mb-2" style="font-size: 0.72rem;">Destinataire</label>
                        <input type="email" id="emailDestinataire" class="form-control bg-light border-light py-2 fs-8" placeholder="destinataire@email.com" required style="box-shadow:none !important;">
                    </div>
                    <!-- Objet -->
                    <div class="mb-3">
                        <label for="emailObjet" class="form-label fw-bold text-muted text-uppercase mb-2" style="font-size: 0.72rem;">Objet</label>
                        <input type="text" id="emailObjet" class="form-control bg-light border-light py-2 fs-8" placeholder="Objet de l'email" required style="box-shadow:none !important;">
                    </div>
                    <!-- Message -->
                    <div class="mb-3">
                        <label for="emailMessage" class="form-label fw-bold text-muted text-uppercase mb-2" style="font-size: 0.72rem;">Message</label>
                        <textarea id="emailMessage" class="form-control bg-light border-light py-2 fs-8" rows="6" required style="box-shadow:none !important; resize: none;"></textarea>
                    </div>
                    <small class="text-muted d-block fs-10 mb-3" style="font-style: italic;">Le PDF du devis sera joint automatiquement en pièce jointe.</small>
                    
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-4 py-2" data-bs-toggle="modal" data-bs-target="#devisDetailsModal" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" id="btnSubmitEmailForm" class="btn rounded-3 fs-8 fw-bold px-4 py-2 text-white" style="background:#0D1B4B; border:none;"><i class="bi bi-send-fill me-1"></i> Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL 3 : CRÉER UN NOUVEAU DEVIS           -->
<!-- ========================================== -->
<div class="modal fade" id="newDevisModal" tabindex="-1" aria-labelledby="newDevisModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg bg-white text-navy">
            <div class="modal-header border-bottom border-light px-4">
                <h5 class="modal-title fw-extrabold text-navy" id="newDevisModalLabel">Nouveau devis <small class="text-muted fs-8 ms-2">Prochain n° : {{ $nextNumber }}</small></h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.devis.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-4 row g-3 fs-8">
                    
                    <!-- Client -->
                    <div class="col-md-6">
                        <label for="id_client" class="form-label fw-bold text-navy text-uppercase">Client *</label>
                        <select name="id_client" id="id_client" class="form-select bg-light border-light py-2 fs-8" required>
                            <option value="" selected disabled>Sélectionner un client</option>
                            @foreach($clients as $client)
                            <option value="{{ $client->id_client }}">{{ $client->prenom }} {{ $client->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type de document -->
                    <div class="col-md-6">
                        <label for="type" class="form-label fw-bold text-navy text-uppercase">Type de document *</label>
                        <select name="type" id="type" class="form-select bg-light border-light py-2 fs-8" required>
                            <option value="Devis" selected>Devis</option>
                            <option value="Facture_proforma">Facture proforma</option>
                        </select>
                    </div>

                    <!-- Opportunité liée -->
                    <div class="col-12">
                        <label for="id_lead" class="form-label fw-bold text-navy text-uppercase">Lead lié (optionnel)</label>
                        <select name="id_lead" id="id_lead" class="form-select bg-light border-light py-2 fs-8">
                            <option value="" selected>Aucun lead</option>
                            @foreach($leads as $lead)
                            <option value="{{ $lead->id_lead }}" data-client="{{ $lead->id_client }}">{{ $lead->client->prenom }} {{ $lead->client->nom }} - {{ $lead->message_origine }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- TABLEAU DYNAMIQUE DE LIGNES DE DEVIS -->
                    <div class="col-12 mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-navy text-uppercase">Lignes de devis</span>
                            <button type="button" class="btn btn-link p-0 text-cyan text-decoration-none fw-bold fs-8" id="btnAddLine"><i class="bi bi-plus-lg"></i> Ajouter une ligne</button>
                        </div>
                        
                        <div class="table-responsive rounded-3 border border-light bg-white">
                            <table class="table align-middle mb-0 fs-8" id="devisLinesTable">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 50%;">Sélectionner un service</th>
                                        <th scope="col" style="width: 15%;">Quantité</th>
                                        <th scope="col" class="text-end" style="width: 25%;">Prix unitaire (FCFA)</th>
                                        <th scope="col" class="text-end" style="width: 10%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="devis-line-row">
                                        <td>
                                            <select name="lignes[0][id_service]" class="form-select border-0 fs-8 service-select" required>
                                                <option value="" selected disabled>Choisir un service...</option>
                                                @foreach($services as $svc)
                                                <option value="{{ $svc->id_service }}" data-price="{{ $svc->prix_indicatif }}">{{ $svc->nom_service }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="lignes[0][quantite]" class="form-control border-0 fs-8 qty-input" value="1" min="1" required style="background: transparent !important;">
                                        </td>
                                        <td>
                                            <input type="number" name="lignes[0][prix]" class="form-control border-0 fs-8 price-input" value="0" min="0" required style="background: transparent !important;">
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-link text-danger p-0 border-0 btn-delete-line" style="display:none;"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TOTAUX COMPTABLES -->
                    <div class="col-12 mt-4 pt-3 border-top border-light">
                        <div class="row justify-content-end text-end">
                            <div class="col-md-5 fs-8">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted fw-semibold">Total HT :</span>
                                    <span class="fw-bold text-navy" id="totalHtSpan">0 FCFA</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted fw-semibold">TVA (%) :</span>
                                    <input type="number" name="tva_percentage" id="tvaInput" class="form-control text-end border-0 p-0 fs-8 fw-bold text-navy" value="0" min="0" max="100" style="width: 50px; background: transparent !important; box-shadow:none !important;">
                                </div>
                                <div class="d-flex justify-content-between border-top border-light pt-2" style="font-size: 1.15rem;">
                                    <span class="fw-bold text-navy">Total TTC :</span>
                                    <span class="fw-extrabold text-cyan" id="totalTtcSpan">0 FCFA</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top border-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-4 py-2" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-navy rounded-3 fs-8 fw-bold px-4 py-2 text-white" style="background: #0D1B4B; border:none;">Générer le devis</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- STYLE DE SÉCURITÉ POUR SUPPRIMER LE CLIPPING ET POSITIONNER LE SOUS-MENU À GAUCHE (IMAGE 1) -->
<style>
    .table-responsive {
        overflow: visible !important;
    }

    /* GESTION ET POSITIONNEMENT DU SOUS-MENU DE STATUT À GAUCHE (IMAGE 1) */
    .dropdown-submenu {
        position: relative !important;
    }
    .dropdown-submenu .dropdown-menu {
        position: absolute !important;
        top: 0 !important;
        left: -160px !important; /* Décale le menu de 160px exactement vers la gauche pour éviter d'entraver le clic */
        margin-top: -6px !important;
        display: none !important; /* Masqué par défaut */
        background-color: #ffffff !important;
        border: 1px solid #E2E8F0 !important;
        border-radius: 8px !important;
        box-shadow: 0 10px 30px rgba(13, 27, 75, 0.1) !important;
        padding: 6px 0 !important;
        min-width: 150px !important;
        z-index: 1050 !important;
    }
    /* Ouvrir proprement au survol et bloquer les interférences */
    .dropdown-submenu:hover .dropdown-menu {
        display: block !important;
    }

    /* Couleur des puces de statut conformes */
    .status-dot-orange { color: #fd7e14 !important; }
    .status-dot-green { color: #198754 !important; }
    .status-dot-red { color: #dc3545 !important; }
    .status-dot-gray { color: #6c757d !important; }

    /* TOASTS DE NOTIFICATIONS FLOTTANTS PERSONNALISÉS (CONFORMES À L'IMAGE) */
    .toast-custom {
        background-color: #0D1B4B !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 12px !important;
        padding: 12px 20px !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3) !important;
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        min-width: 300px;
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    .toast-success { border-color: rgba(25, 135, 84, 0.35) !important; }
    .toast-success i { color: #198754 !important; } /* Icône verte */
    
    .toast-danger { border-color: rgba(220, 53, 69, 0.35) !important; }
    .toast-danger i { color: #dc3545 !important; } /* Icône rouge */

    .toast-info { border-color: rgba(0, 210, 244, 0.35) !important; }
    .toast-info i { color: #00D2F4 !important; } /* Icône cyan */

    .toast-email { border-color: rgba(253, 126, 20, 0.35) !important; }
    .toast-email i { color: #fd7e14 !important; } /* Icône enveloppe orange */

    /* UNSTACKING RESPONSIVE DES CARTES COMPTABLES SUR MOBILE (IMAGE 2) */
    @media (max-width: 767px) {
        .responsive-table-to-cards thead {
            display: none !important;
        }
        .responsive-table-to-cards tbody tr {
            display: block !important;
            background-color: #ffffff !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 12px !important;
            margin-bottom: 15px !important;
            padding: 15px !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02) !important;
            position: relative !important;
        }
        .responsive-table-to-cards tbody td {
            display: block !important;
            text-align: right !important;
            padding: 8px 0 !important;
            border: none !important;
            position: relative !important;
        }
        .responsive-table-to-cards tbody td::before {
            content: attr(data-label) !important;
            position: absolute !important;
            left: 0 !important;
            font-weight: 700 !important;
            color: #4A5B73 !important;
            text-transform: uppercase !important;
            font-size: 0.72rem !important;
        }
        .responsive-table-to-cards tbody td.text-end {
            text-align: right !important;
        }
    }
</style>

<!-- SCRIPTS COMPTABLES ET D'ACTIONS AJAX SÉCURISÉES -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    const tableBody = document.querySelector('#devisLinesTable tbody');
    const btnAddLine = document.getElementById('btnAddLine');
    const totalHtSpan = document.getElementById('totalHtSpan');
    const totalTtcSpan = document.getElementById('totalTtcSpan');
    const tvaInput = document.getElementById('tvaInput');
    const leadSelect = document.getElementById('id_lead');
    const clientSelect = document.getElementById('id_client');

    let lineIndex = 1;
    let activeDevisId = null;

    // Instance des modaux Bootstrap
    const detailsModal = new bootstrap.Modal(document.getElementById('devisDetailsModal'));
    const sendEmailModal = new bootstrap.Modal(document.getElementById('sendEmailModal'));

    if (leadSelect && clientSelect) {
        leadSelect.addEventListener('change', () => {
            const selectedOption = leadSelect.options[leadSelect.selectedIndex];
            const clientId = selectedOption.getAttribute('data-client');
            if (clientId) {
                clientSelect.value = clientId;
            }
        });
    }

    const calculateTotals = () => {
        let totalHt = 0;
        const rows = document.querySelectorAll('.devis-line-row');

        rows.forEach(row => {
            const qty = +row.querySelector('.qty-input').value || 0;
            const price = +row.querySelector('.price-input').value || 0;
            totalHt += qty * price;
        });

        const tvaPercent = +tvaInput.value || 0;
        const totalTtc = totalHt + (totalHt * (tvaPercent / 100));

        totalHtSpan.innerText = totalHt.toLocaleString('fr-FR') + ' FCFA';
        totalTtcSpan.innerText = totalTtc.toLocaleString('fr-FR') + ' FCFA';
    };

    const bindLineEvents = (row) => {
        const select = row.querySelector('.service-select');
        const priceInput = row.querySelector('.price-input');
        const qtyInput = row.querySelector('.qty-input');
        const btnDelete = row.querySelector('.btn-delete-line');

        select.addEventListener('change', () => {
            const selectedOption = select.options[select.selectedIndex];
            const catalogPrice = selectedOption.getAttribute('data-price');
            if (catalogPrice) {
                priceInput.value = parseFloat(catalogPrice);
                calculateTotals();
            }
        });

        priceInput.addEventListener('input', calculateTotals);
        qtyInput.addEventListener('input', calculateTotals);

        if (btnDelete) {
            btnDelete.addEventListener('click', () => {
                row.remove();
                calculateTotals();
                toggleDeleteButtons();
            });
        }
    };

    const toggleDeleteButtons = () => {
        const rows = document.querySelectorAll('.devis-line-row');
        rows.forEach(row => {
            const btn = row.querySelector('.btn-delete-line');
            if (btn) {
                btn.style.display = rows.length > 1 ? 'inline-block' : 'none';
            }
        });
    };

    if (btnAddLine) {
        btnAddLine.addEventListener('click', () => {
            const firstRow = document.querySelector('.devis-line-row');
            const newRow = firstRow.cloneNode(true);

            newRow.querySelector('.qty-input').value = 1;
            newRow.querySelector('.price-input').value = 0;
            newRow.querySelector('.service-select').selectedIndex = 0;

            newRow.querySelector('.service-select').name = `lignes[${lineIndex}][id_service]`;
            newRow.querySelector('.qty-input').name = `lignes[${lineIndex}][quantite]`;
            newRow.querySelector('.price-input').name = `lignes[${lineIndex}][prix]`;

            tableBody.appendChild(newRow);
            bindLineEvents(newRow);
            toggleDeleteButtons();
            
            lineIndex++;
        });
    }

    const initialRow = document.querySelector('.devis-line-row');
    if (initialRow) {
        bindLineEvents(initialRow);
    }
    
    if (tvaInput) {
        tvaInput.addEventListener('input', calculateTotals);
    }

    /* ── 2. TOASTS DYNAMIQUES DU CRM ── */
    const showToast = (message, type = 'success') => {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast-custom toast-${type} mb-2 d-flex align-items-center justify-content-between`;
        
        let icon = 'bi-check-circle-fill';
        if (type === 'danger') icon = 'bi-trash-fill';
        if (type === 'info') icon = 'bi-info-circle-fill';
        if (type === 'email') icon = 'bi-envelope-fill';

        toast.innerHTML = `
            <div class="d-flex align-items-center gap-2">
                <i class="bi ${icon}"></i>
                <span>${message}</span>
            </div>
        `;
        container.appendChild(toast);

        // Disparition et suppression automatique après 4 secondes
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            setTimeout(() => { toast.remove(); }, 300);
        }, 4000);
    };

    /* ── 3. CHARGEMENT DYNAMIQUE DU MODAL DÉTAILS DEVIS ── */
    const detailModalElement = document.getElementById('devisDetailsModal');
    
    // Gérer l'affectation de l'ID du devis actif lors du clic (S'applique à la ligne entière ou au bouton d'option)
    const bindViewDevisClick = () => {
        document.querySelectorAll('.btn-view-devis').forEach(el => {
            el.addEventListener('click', (e) => {
                // Analyse par élément de proximité pour gérer le clic sur l'icône imbriquée (Finition M4)
                const target = e.target.closest('[data-id]');
                if (target) {
                    activeDevisId = target.getAttribute('data-id');
                    loadDevisDetails(activeDevisId);
                }
            });
        });
    };

    const loadDevisDetails = (id) => {
        if (!id) return;

        // Initialisation visuelle
        document.getElementById('detailDevisNum').innerText = "Chargement...";
        document.getElementById('detailDevisClientMeta').innerText = "";
        document.getElementById('detailTotalHt').innerText = "0 FCFA";
        document.getElementById('detailTotalTtc').innerText = "0 FCFA";
        
        const tbody = document.querySelector('#detailLinesTable tbody');
        tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Chargement des articles...</td></tr>';

        // Requête dynamique AJAX (M4)
        fetch(`/admin/devis/${id}/details`)
            .then(res => {
                if (!res.ok) {
                    throw new Error('HTTP error ' + res.status);
                }
                return res.json();
            })
            .then(data => {
                document.getElementById('detailDevisNum').innerText = data.numero;
                
                // Badge de statut d'en-tête dynamique
                const headerStatus = document.getElementById('detailHeaderStatus');
                if (headerStatus) {
                    headerStatus.innerText = data.statut;
                    headerStatus.className = `badge ms-2 ${data.statut === 'Accepte' ? 'bg-success' : (data.statut === 'En attente' ? 'bg-warning' : 'bg-danger')}`;
                }

                document.getElementById('detailDevisClientMeta').innerText = data.client_name + ' · ' + data.type;
                document.getElementById('detailEmission').innerText = data.date_emission;
                document.getElementById('detailExpiration').innerText = data.date_expiration;
                document.getElementById('detailStatut').innerText = data.statut;
                document.getElementById('detailPaiement').innerText = data.statut_paiement;
                document.getElementById('detailTotalHt').innerText = data.montant_ht + ' FCFA';
                document.getElementById('detailTotalTtc').innerText = data.montant_ttc + ' FCFA';

                // Lier le bouton d'impression (M4)
                document.getElementById('btnPrintLink').href = `/admin/devis/${id}/print`;

                // Remplir le bouton d'envoi d'e-mail avec l'ID pour le chaînage natif
                document.getElementById('btnOpenEmailModal').setAttribute('data-id', id);

                // Remplir dynamiquement les champs du second modal d'envoi d'e-mail (Dernière image)
                document.getElementById('emailDestinataire').value = data.client_email;
                document.getElementById('emailObjet').value = `Devis ${data.numero} — Flycom Services`;
                document.getElementById('emailMessage').value = `Bonjour ${data.client_prenom},\n\nVeuillez trouver ci-joint notre devis ${data.numero}.\n\nCordialement,\nL'équipe Flycom Services`;

                const statusText = document.getElementById('detailStatut');
                if (data.statut === 'Accepte') {
                    statusText.className = 'fw-bold d-block text-success mt-1';
                } else if (data.statut === 'En attente') {
                    statusText.className = 'fw-bold d-block text-warning mt-1';
                } else {
                    statusText.className = 'fw-bold d-block text-danger mt-1';
                }

                tbody.innerHTML = '';
                data.lignes.forEach(line => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>
                            <strong class="text-navy d-block">${line.nom_service}</strong>
                            <small class="text-muted d-block fs-10" style="line-height:1.2;">${line.description}</small>
                        </td>
                        <td class="text-center fw-semibold">${line.quantite}</td>
                        <td class="text-end text-muted">${line.prix}</td>
                        <td class="text-end fw-bold text-navy">${line.total}</td>
                    `;
                    tbody.appendChild(tr);
                });
            })
            .catch(err => {
                console.error('Error:', err);
                tbody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Erreur de chargement.</td></tr>';
            });
    };

    // Liaison initiale des événements de clic
    bindViewDevisClick();

    /* ── 3. CHARGEMENT DYNAMIQUE DU MODAL D'EMAIL ── */
    const sendEmailModalElement = document.getElementById('sendEmailModal');
    if (sendEmailModalElement) {
        sendEmailModalElement.addEventListener('show.bs.modal', (event) => {
            const triggerBtn = event.relatedTarget;
            const targetId = triggerBtn ? triggerBtn.getAttribute('data-id') : activeDevisId;

            if (targetId) {
                // Requête AJAX pour charger les données réelles et pré-remplir tous les champs
                fetch(`/admin/devis/${targetId}/details`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('emailDestinataire').value = data.client_email;
                        document.getElementById('emailObjet').value = `Devis ${data.numero} — Flycom Services`;
                        document.getElementById('emailMessage').value = `Bonjour ${data.client_prenom},\n\nVeuillez trouver ci-joint notre devis ${data.numero}.\n\nCordialement,\nL'équipe Flycom Services`;
                    })
                    .catch(err => console.error('Error pre-filling email:', err));
            }
        });
    }

    // Ouvrir le modal d'envoi d'e-mail
    const btnOpenEmailModal = document.getElementById('btnOpenEmailModal');
    if (btnOpenEmailModal) {
        btnOpenEmailModal.addEventListener('click', () => {
            detailsModal.hide();
            setTimeout(() => {
                sendEmailModal.show();
            }, 400); // Transition fluide
        });
    }

    /* ── 4. ACTIONS OPÉRATIONNELLES SÉCURISÉES AJAX (M4 - COMPATIBILITÉ FORM-DATA) ── */
    const actionAlert = document.getElementById('actionAlert');

    const showAlert = (message, type = 'success') => {
        actionAlert.className = `alert alert-${type} fs-8 py-2.5 rounded-3 mb-4 border-0`;
        actionAlert.innerText = message;
        actionAlert.classList.remove('d-none');
        window.scrollTo({ top: 0, behavior: 'smooth' });

        setTimeout(() => {
            actionAlert.classList.add('d-none');
        }, 5000);
    };

    // Traitement de l'envoi de mail
    const emailForm = document.getElementById('emailForm');
    if (emailForm) {
        emailForm.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!activeDevisId) return;

            const btnSubmit = document.getElementById('btnSubmitEmailForm');
            const previousText = btnSubmit.innerHTML;
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Envoi...';

            const formData = new URLSearchParams({
                destinataire: document.getElementById('emailDestinataire').value,
                objet: document.getElementById('emailObjet').value,
                message: document.getElementById('emailMessage').value
            });

            fetch(`/admin/devis/${activeDevisId}/send-email`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = previousText;
                
                sendEmailModal.hide();
                showToast(`Email envoyé sur ${document.getElementById('emailDestinataire').value}`, 'email');
            })
            .catch(err => {
                console.error('Error:', err);
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = previousText;
            });
        });
    }

    // Traitement de la mise à jour du statut (AJAX sécurisé par URLSearchParams - M4)
    const triggerStatusUpdate = (id, newStatus) => {
        const formData = new URLSearchParams({
            statut: newStatus
        });

        fetch(`/admin/devis/${id}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(res => {
            if (!res.ok) {
                return res.text().then(text => { throw new Error(text) });
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                // Mise à jour de l'UI en temps réel (Image 2)
                const statusBadge = document.getElementById('detailStatut');
                if (statusBadge) {
                    statusBadge.innerText = newStatus.replace('_', ' ');
                }
                
                const headerStatus = document.getElementById('detailHeaderStatus');
                if (headerStatus) {
                    headerStatus.innerText = newStatus.replace('_', ' ');
                    headerStatus.className = `badge ms-2 ${newStatus === 'Accepte' ? 'bg-success' : (newStatus === 'En_attente' ? 'bg-warning' : 'bg-danger')}`;
                }

                // Ajuster la couleur de la priorité
                const statusText = document.getElementById('detailStatut');
                if (statusText) {
                    if (newStatus === 'Accepte') {
                        statusText.className = 'fw-bold d-block text-success mt-1';
                    } else if (newStatus === 'En_attente') {
                        statusText.className = 'fw-bold d-block text-warning mt-1';
                    } else {
                        statusText.className = 'fw-bold d-block text-danger mt-1';
                    }
                }

                // Mettre à jour l'index
                const row = document.getElementById(`devisRow${id}`);
                if (row) {
                    const badge = row.querySelector('[data-label="Statut"] span');
                    if (badge) {
                        badge.innerText = newStatus.replace('_', ' ');
                        badge.className = `badge ${newStatus === 'Accepte' ? 'bg-success-soft text-success' : (newStatus === 'En_attente' ? 'bg-warning-soft text-warning' : 'bg-danger-soft text-danger')} px-2 py-1 rounded-3`;
                    }
                }

                showToast(`Statut changé : ${newStatus.replace('_', ' ')}`, 'info');
            } else {
                alert("Erreur de traitement : " + data.message);
            }
        })
        .catch(err => {
            console.error('Error updating status:', err);
            alert("Erreur réseau lors de la mise à jour du statut : " + err.message);
        });
    };

    // Statut depuis le tableau d'index
    document.querySelectorAll('.btn-quick-status').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation(); // Évite d'ouvrir le modal de détails en même temps !
            const id = btn.getAttribute('data-id');
            const status = btn.getAttribute('data-status');
            triggerStatusUpdate(id, status);
        });
    });

    // Statut depuis le modal de détails
    document.querySelectorAll('.btn-modal-status-update').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const status = btn.getAttribute('data-status');
            if (activeDevisId) {
                detailsModal.hide();
                triggerStatusUpdate(activeDevisId, status);
            }
        });
    });

    // Action Supprimer (Sécurisée en POST URLSearchParams - M4)
    const triggerDelete = (id, numero) => {
        if (confirm('Êtes-vous sûr de vouloir supprimer définitivement ce document comptable de la base de données ?')) {
            fetch(`/admin/devis/${id}/delete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => {
                if (!res.ok) {
                    return res.text().then(text => { throw new Error(text) });
                }
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    // Fermer le modal
                    detailsModal.hide();

                    // Supprimer la ligne du tableau avec un fondu lisse (Image 3)
                    const row = document.getElementById(`devisRow${id}`);
                    if (row) {
                        row.style.transition = 'all 0.4s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(20px)';
                        setTimeout(() => { row.remove(); }, 400);
                    }
                    showToast(`Devis ${numero} supprimé`, 'danger');
                } else {
                    alert("Erreur de suppression : " + data.message);
                }
            })
            .catch(err => {
                console.error('Error deleting devis:', err);
                alert("Erreur réseau lors de la suppression : " + err.message);
            });
        }
    };

    // Suppression rapide depuis le tableau d'index
    document.querySelectorAll('.btn-delete-devis').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation(); // Évite d'ouvrir le modal
            const id = btn.getAttribute('data-id');
            const numero = btn.closest('tr').querySelector('td').innerText;
            triggerDelete(id, numero);
        });
    });

    // Suppression depuis le bouton d'action du modal de détails
    const btnDeleteModal = document.getElementById('btnDeleteModal');
    if (btnDeleteModal) {
        btnDeleteModal.addEventListener('click', () => {
            if (activeDevisId) {
                const numero = document.getElementById('detailDevisNum').innerText;
                triggerDelete(activeDevisId, numero);
            }
        });
    }

    // Gestion de l'affichage du sous-menu dropdown
    document.querySelectorAll('.dropdown-submenu a.dropdown-toggle').forEach(element => {
        element.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            element.nextElementSibling.classList.toggle('show');
        });
    });
});
</script>
@endsection