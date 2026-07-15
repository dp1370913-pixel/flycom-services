@extends('layouts.admin')

@section('title', 'Gestion des Clients | Flycom Services CRM')

@section('content')

<!-- HEADER DE LA PAGE -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
        <h1 class="fw-extrabold text-navy mb-1" style="font-size: 1.6rem;">Clients</h1>
        <p class="text-muted mb-0" style="font-size: 0.8rem;">{{ $clients->count() }} contacts dans le CRM</p>
    </div>
    
    <div class="d-flex flex-wrap gap-2 mt-1 mt-md-0 w-100 w-md-auto">
        @if(Auth::user()->role !== 'Lecture')
        <button class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-3 py-2 flex-grow-1 flex-sm-grow-0" data-bs-toggle="modal" data-bs-target="#importCsvModal">
            <i class="bi bi-box-arrow-in-down me-1"></i> Importer CSV
        </button>
        @endif
        
        @if(Auth::user()->role === 'Admin')
        <a href="{{ route('admin.clients.export') }}" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-3 py-2 flex-grow-1 flex-sm-grow-0" style="text-decoration: none; text-align: center;">
            <i class="bi bi-download me-1"></i> Export
        </a>
        @endif
        
        @if(Auth::user()->role !== 'Lecture')
        <button class="btn rounded-3 px-3 py-2 text-white fw-bold flex-grow-1 flex-sm-grow-0" style="font-size: 0.8rem; background: #0D1B4B; border: none;" data-bs-toggle="modal" data-bs-target="#newClientModal">
            <i class="bi bi-plus-lg me-1"></i> Nouveau client
        </button>
        @endif
    </div>
</div>

<!-- BARRE DE RECHERCHE & FILTRE TYPE -->
<div class="card border-0 shadow-sm p-3 bg-white rounded-4 mb-4">
    <form action="{{ route('admin.clients.index') }}" method="GET" class="d-flex flex-column flex-md-row gap-2 mb-0">
        <div class="position-relative flex-grow-1 w-100" style="max-width: 420px;">
            <span class="position-absolute start-0 top-50 translate-middle-y ms-3 text-muted" style="font-size: 0.85rem;">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" name="search" class="form-control border rounded-3 py-2 ps-5 w-100" style="font-size: 0.82rem; background: #F8FAFC; border-color: #E2E8F0 !important;" placeholder="Rechercher un client..." value="{{ $search }}">
        </div>
        
        <div class="w-100" style="max-width: 200px; min-width: 180px;">
            <select name="type" class="form-select rounded-3 py-2 w-100" style="font-size: 0.82rem; background: #F8FAFC; border-color: #E2E8F0;" onchange="this.form.submit()">
                <option value="all">Tous types</option>
                <option value="Client" {{ $typeFilter === 'Client' ? 'selected' : '' }}>Clients</option>
                <option value="Prospect" {{ $typeFilter === 'Prospect' ? 'selected' : '' }}>Prospects</option>
                <option value="Partenaire" {{ $typeFilter === 'Partenaire' ? 'selected' : '' }}>Partenaires</option>
            </select>
        </div>
    </form>
</div>

<!-- AFFICHAGE DU TABLEAU DES CLIENTS -->
<div class="card border-0 shadow-sm p-4 bg-white rounded-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.82rem; min-width: 750px;">
            <thead class="table-light">
                <tr>
                    <th scope="col">NOM</th>
                    <th scope="col">TÉLÉPHONE</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">ENTREPRISE</th>
                    <th scope="col">TYPE</th>
                    <th scope="col">DEPUIS</th>
                    @if(Auth::user()->role !== 'Lecture')
                    <th scope="col" class="text-end">ACTIONS</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr class="table-row-hover">
                    <td class="fw-bold text-navy d-flex align-items-center gap-3">
                        <div class="avatar-circle" style="width: 32px; height: 32px; font-size: 0.72rem; box-shadow: none; flex-shrink: 0;">
                            {{ substr($client->prenom, 0, 1) }}{{ substr($client->nom, 0, 1) }}
                        </div>
                        <span>{{ $client->prenom }} {{ $client->nom }}</span>
                    </td>
                    <td class="text-muted fw-semibold">{{ $client->telephone }}</td>
                    <td class="text-muted">{{ $client->email ?? '—' }}</td>
                    <td class="text-muted">{{ $client->entreprise ?? '—' }}</td>
                    <td>
                        @if($client->type_contact === 'Client')
                            <span class="badge bg-success-soft text-success">Client</span>
                        @elseif($client->type_contact === 'Prospect')
                            <span class="badge bg-warning-soft text-warning">Prospect</span>
                        @else
                            <span class="badge bg-primary-soft text-primary">Partenaire</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $client->created_at->format('d/m/Y') }}</td>
                    
                    @if(Auth::user()->role !== 'Lecture')
                    <td class="text-end">
                        <!-- Bouton d'édition rapide (Nouveau) -->
                        <button class="btn btn-light btn-sm rounded-circle btn-edit-client border-0" data-id="{{ $client->id_client }}" data-bs-toggle="modal" data-bs-target="#editClientModal" title="Modifier la fiche client">
                            <i class="bi bi-pencil-square text-navy"></i>
                        </button>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">Aucun contact enregistré pour le moment.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL : IMPORTER CSV (Masqué si Lecture)  -->
<!-- ========================================== -->
@if(Auth::user()->role !== 'Lecture')
<div class="modal fade" id="importCsvModal" tabindex="-1" aria-labelledby="importCsvModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg bg-white text-navy">
            <div class="modal-header border-bottom border-light px-4">
                <h5 class="modal-title fw-extrabold text-navy" id="importCsvModalLabel">Importer CSV</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.clients.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 py-4 fs-8">
                    <div class="drag-drop-zone rounded-4 p-4 p-sm-5 text-center d-flex flex-column align-items-center justify-content-center gap-3" id="dragDropZone">
                        <input type="file" name="csv_file" id="csvFileInput" class="d-none" accept=".csv,text/csv,text/plain" required>
                        <i class="bi bi-cloud-arrow-up text-muted display-4" id="uploadIcon"></i>
                        <div>
                            <span class="fw-bold d-block text-navy fs-7 mb-1" id="uploadTitle">Glissez-déposez votre fichier CSV ici</span>
                            <span class="text-muted fs-8">ou <button type="button" class="btn btn-link p-0 text-cyan text-decoration-none fw-bold fs-8 align-baseline" id="browseBtn">Parcourir</button></span>
                        </div>
                        <small class="text-muted fs-9 d-block">Colonnes attendues : Prénom, Nom, Téléphone, Email, Entreprise, Adresse, Type</small>
                    </div>
                </div>
                <div class="modal-footer border-top border-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-4 py-2" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-navy rounded-3 fs-8 fw-bold px-4 py-2 text-white" style="background:#0D1B4B; border:none;">Lancer l'importation</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- ========================================== -->
<!-- MODAL : NOUVEAU CLIENT (Masqué si Lecture) -->
<!-- ========================================== -->
@if(Auth::user()->role !== 'Lecture')
<div class="modal fade" id="newClientModal" tabindex="-1" aria-labelledby="newClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg bg-white text-navy">
            <div class="modal-header border-bottom border-light px-4">
                <h5 class="modal-title fw-extrabold text-navy" id="newClientModalLabel">Nouveau client</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.clients.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-4 row g-3" style="font-size: 0.82rem;">
                    <div class="col-md-6">
                        <label for="prenom" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Prénom *</label>
                        <input type="text" name="prenom" id="prenom" class="form-control bg-light border-light py-2" required placeholder="Prénom">
                    </div>
                    <div class="col-md-6">
                        <label for="nom" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Nom *</label>
                        <input type="text" name="nom" id="nom" class="form-control bg-light border-light py-2" required placeholder="Nom de famille">
                    </div>
                    <div class="col-md-6">
                        <label for="telephone" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Téléphone *</label>
                        <input type="tel" name="telephone" id="telephone" class="form-control bg-light border-light py-2" required placeholder="Ex: 06 628 57 41">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Email</label>
                        <input type="email" name="email" id="email" class="form-control bg-light border-light py-2" placeholder="adresse@email.com">
                    </div>
                    <div class="col-md-6">
                        <label for="entreprise" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Entreprise</label>
                        <input type="text" name="entreprise" id="entreprise" class="form-control bg-light border-light py-2" placeholder="Nom de l'établissement">
                    </div>
                    <div class="col-md-6">
                        <label for="type_contact" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Type de contact *</label>
                        <select name="type_contact" id="type_contact" class="form-select bg-light border-light py-2" required>
                            <option value="Prospect" selected>Prospect</option>
                            <option value="Client">Client</option>
                            <option value="Partenaire">Partenaire</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="adresse" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Adresse d'intervention</label>
                        <input type="text" name="adresse" id="adresse" class="form-control bg-light border-light py-2" placeholder="Adresse complète">
                    </div>
                    <div class="col-12">
                        <label for="notes" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Notes / Historique de garde</label>
                        <textarea name="notes" id="notes" class="form-control bg-light border-light py-2" rows="3" placeholder="Informations complémentaires utiles..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top border-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-4 py-2" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn rounded-3 fw-bold px-4 py-2 text-white" style="background:#0D1B4B; border-none;">Créer la fiche client</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- ========================================== -->
<!-- MODAL : MODIFIER / SUPPRIMER LE CLIENT (Nouveau) -->
<!-- ========================================== -->
@if(Auth::user()->role !== 'Lecture')
<div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg bg-white text-navy">
            <div class="modal-header border-bottom border-light px-4">
                <h5 class="modal-title fw-extrabold text-navy" id="editClientModalLabel">Modifier la fiche client</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="" method="POST" id="editClientForm">
                @csrf
                <div class="modal-body px-4 py-4 row g-3" style="font-size: 0.82rem;">
                    
                    <div class="col-md-6">
                        <label for="edit_prenom" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Prénom *</label>
                        <input type="text" name="prenom" id="edit_prenom" class="form-control bg-light border-light py-2" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_nom" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Nom *</label>
                        <input type="text" name="nom" id="edit_nom" class="form-control bg-light border-light py-2" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_telephone" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Téléphone *</label>
                        <input type="tel" name="telephone" id="edit_telephone" class="form-control bg-light border-light py-2" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_email" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control bg-light border-light py-2">
                    </div>
                    <div class="col-md-6">
                        <label for="edit_entreprise" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Entreprise</label>
                        <input type="text" name="entreprise" id="edit_entreprise" class="form-control bg-light border-light py-2">
                    </div>
                    <div class="col-md-6">
                        <label for="edit_type_contact" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Type de contact *</label>
                        <select name="type_contact" id="edit_type_contact" class="form-select bg-light border-light py-2" required>
                            <option value="Prospect">Prospect</option>
                            <option value="Client">Client</option>
                            <option value="Partenaire">Partenaire</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="edit_adresse" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Adresse d'intervention</label>
                        <input type="text" name="adresse" id="edit_adresse" class="form-control bg-light border-light py-2">
                    </div>
                    <div class="col-12">
                        <label for="edit_notes" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Notes / Observations</label>
                        <textarea name="notes" id="edit_notes" class="form-control bg-light border-light py-2" rows="3"></textarea>
                    </div>
                </div>
                
                <div class="modal-footer border-top border-light px-4 py-3 d-flex flex-wrap gap-2 justify-content-between align-items-center">
                    <div>
                        <!-- Bouton de suppression exclusivement réservé à l'Administrateur d'entreprise -->
                        @if(Auth::user()->role === 'Admin')
                        <button type="button" class="btn btn-outline-danger rounded-3 fs-8 fw-semibold px-3 py-2 w-100 w-sm-auto" id="btnDeleteClient">
                            <i class="bi bi-trash3-fill me-1"></i> Supprimer
                        </button>
                        @endif
                    </div>
                    <div class="d-flex gap-2 w-100 w-sm-auto justify-content-end">
                        <button type="button" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-4 py-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn rounded-3 fw-bold px-4 py-2 text-white" style="background:#0D1B4B; border:none;">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Formulaire masqué de traitement de la suppression sécurisée -->
@if(Auth::user()->role === 'Admin')
<form action="" method="POST" id="deleteClientForm" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endif
@endif

<style>
    .drag-drop-zone {
        border: 2px dashed #E2E8F0;
        cursor: pointer;
        transition: border-color 0.25s ease, background-color 0.25s ease;
    }
    .drag-drop-zone.drag-over {
        border-color: #00D2F4;
        background-color: rgba(0, 210, 244, 0.04);
    }
    .drag-drop-zone.file-selected {
        border-color: #198754;
        background-color: rgba(25, 135, 84, 0.04);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    
    // 1. GESTION DU DRAG AND DROP CSV
    const dropZone = document.getElementById('dragDropZone');
    const fileInput = document.getElementById('csvFileInput');
    const browseBtn = document.getElementById('browseBtn');
    const uploadIcon = document.getElementById('uploadIcon');
    const uploadTitle = document.getElementById('uploadTitle');

    if (dropZone && fileInput) {
        browseBtn.addEventListener('click', (e) => { e.stopPropagation(); fileInput.click(); });
        dropZone.addEventListener('click', () => { fileInput.click(); });
        fileInput.addEventListener('change', () => { handleFileSelect(fileInput.files[0]); });

        dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('drag-over'); });
        dropZone.addEventListener('dragleave', () => { dropZone.classList.remove('drag-over'); });
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('drag-over');
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                handleFileSelect(e.dataTransfer.files[0]);
            }
        });

        const handleFileSelect = (file) => {
            if (file && (file.name.endsWith('.csv') || file.type === 'text/csv' || file.type === 'text/plain')) {
                dropZone.classList.add('file-selected');
                uploadIcon.className = 'bi bi-file-earmark-check-fill text-success display-4';
                uploadTitle.innerText = `Fichier sélectionné : ${file.name}`;
            } else {
                alert('Veuillez sélectionner un fichier au format .csv valide.');
                fileInput.value = '';
                dropZone.classList.remove('file-selected');
                uploadIcon.className = 'bi bi-cloud-arrow-up text-muted display-4';
                uploadTitle.innerText = 'Glissez-déposez votre fichier CSV ici';
            }
        };
    }

    // 2. PRÉ-REMPLISSAGE DYNAMIQUE ET ÉDITION CLIENT (Nouveau - 100% opérationnel)
    const editForm = document.getElementById('editClientForm');
    const deleteForm = document.getElementById('deleteClientForm');
    const btnDelete = document.getElementById('btnDeleteClient');

    document.querySelectorAll('.btn-edit-client').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const clientId = btn.getAttribute('data-id');

            // Réinitialiser les champs pendant le chargement
            document.getElementById('edit_prenom').value = "Chargement...";
            document.getElementById('edit_nom').value = "Chargement...";
            document.getElementById('edit_telephone').value = "";
            document.getElementById('edit_email').value = "";
            document.getElementById('edit_entreprise').value = "";
            document.getElementById('edit_adresse').value = "";
            document.getElementById('edit_notes').value = "";

            if (editForm) {
                editForm.action = `/admin/clients/${clientId}/update`;
            }

            if (deleteForm) {
                deleteForm.action = `/admin/clients/${clientId}/delete`;
            }

            fetch(`/admin/clients/${clientId}/details`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('edit_prenom').value = data.client.prenom;
                        document.getElementById('edit_nom').value = data.client.nom;
                        document.getElementById('edit_telephone').value = data.client.telephone;
                        document.getElementById('edit_email').value = data.client.email || '';
                        document.getElementById('edit_entreprise').value = data.client.entreprise || '';
                        document.getElementById('edit_type_contact').value = data.client.type_contact;
                        document.getElementById('edit_adresse').value = data.client.adresse || '';
                        document.getElementById('edit_notes').value = data.client.notes || '';
                    }
                })
                .catch(err => console.error("Erreur de récupération AJAX :", err));
        });
    });

    // 3. LOGIQUE SÉCURISÉE DE SUPPRESSION PAR L'ADMINISTRATEUR (Nouveau)
    if (btnDelete && deleteForm) {
        btnDelete.addEventListener('click', (e) => {
            e.preventDefault();
            
            const clientPrenom = document.getElementById('edit_prenom').value;
            const clientNom = document.getElementById('edit_nom').value;

            if (confirm(`Êtes-vous sûr de vouloir supprimer définitivement le client ${clientPrenom} ${clientNom} ainsi que toutes ses opportunités de vente rattachées ? Cette action est irréversible.`)) {
                btnDelete.disabled = true;
                btnDelete.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Suppression...`;
                deleteForm.submit();
            }
        });
    }
});
</script>
@endsection