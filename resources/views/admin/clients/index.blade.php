@extends('layouts.admin')

@section('title', 'Gestion des Clients | Flycom Services CRM')

@section('content')

<!-- HEADER DE LA PAGE -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
    <div>
        <h1 class="fw-extrabold text-navy mb-1" style="font-size: 1.6rem;">Clients</h1>
        <p class="text-muted mb-0" style="font-size: 0.8rem;">{{ $clients->count() }} contacts dans le CRM</p>
    </div>
    
    <!-- Actions groupées à droite (Conformes à l'image 11) -->
    <div class="d-flex gap-2 mt-3 mt-md-0 w-100 w-md-auto">
        <button class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-3 py-2" data-bs-toggle="modal" data-bs-target="#importCsvModal">
            <i class="bi bi-box-arrow-in-down me-1"></i> Importer CSV
        </button>
        <a href="{{ route('admin.clients.export') }}" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-3 py-2" style="text-decoration: none;">
            <i class="bi bi-download me-1"></i> Export
        </a>
        <button class="btn rounded-3 px-3 py-2 text-white fw-bold" 
            style="font-size: 0.8rem; background: #0D1B4B; border: none;"
            data-bs-toggle="modal" data-bs-target="#newClientModal">
            <i class="bi bi-plus-lg me-1"></i> Nouveau client
        </button>
    </div>
</div>

<!-- BARRE DE RECHERCHE & FILTRE TYPE (Image 12) -->
<div class="card border-0 shadow-sm p-3 bg-white rounded-4 mb-4">
    <form action="{{ route('admin.clients.index') }}" method="GET" class="d-flex flex-column flex-md-row gap-2 mb-0">
        <div class="position-relative flex-grow-1" style="max-width: 420px;">
            <span class="position-absolute start-0 top-50 translate-middle-y ms-3 text-muted" style="font-size: 0.85rem;">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" name="search" 
                class="form-control border rounded-3 py-2 ps-5" 
                style="font-size: 0.82rem; background: #F8FAFC; border-color: #E2E8F0 !important;"
                placeholder="Rechercher un client..." 
                value="{{ $search }}">
        </div>
        
        <div style="min-width: 180px;">
            <select name="type" class="form-select rounded-3 py-2" 
                style="font-size: 0.82rem; background: #F8FAFC; border-color: #E2E8F0; max-width: 200px;"
                onchange="this.form.submit()">
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
        <table class="table table-hover align-middle mb-0" style="font-size: 0.82rem;">
            <thead class="table-light">
                <tr>
                    <th scope="col">NOM</th>
                    <th scope="col">TÉLÉPHONE</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">ENTREPRISE</th>
                    <th scope="col">TYPE</th>
                    <th scope="col">DEPUIS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr class="table-row-hover">
                    <td class="fw-bold text-navy d-flex align-items-center gap-3">
                        <!-- Cercle d'initiales restauré -->
                        <div class="avatar-circle" style="width: 32px; height: 32px; font-size: 0.72rem; box-shadow: none;">
                            {{ substr($client->prenom, 0, 1) }}{{ substr($client->nom, 0, 1) }}
                        </div>
                        <span>{{ $client->prenom }} {{ $client->nom }}</span>
                    </td>
                    <td class="text-muted fw-semibold">{{ $client->telephone }}</td>
                    <td class="text-muted">{{ $client->email ?? '—' }}</td>
                    <td class="text-muted">{{ $client->entreprise ?? '—' }}</td>
                    <td>
                        @if($client->type_contact === 'Client')
                            <span class="badge badge-source-whatsapp">Client</span>
                        @elseif($client->type_contact === 'Prospect')
                            <span class="badge badge-source-appel">Prospect</span>
                        @else
                            <span class="badge badge-source-recom">Partenaire</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $client->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">Aucun contact enregistré pour le moment.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL : IMPORTER CSV (Image 13 - Drag & Drop) -->
<!-- ========================================== -->
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
                    
                    <!-- Zone de Drag and Drop interactive -->
                    <div class="drag-drop-zone rounded-4 p-5 text-center d-flex flex-column align-items-center justify-content-center gap-3" id="dragDropZone">
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

<!-- ========================================== -->
<!-- MODAL : NOUVEAU CLIENT (Image 14)          -->
<!-- ========================================== -->
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
                        <input type="text" name="prenom" id="prenom" class="form-control bg-light border-light py-2" style="font-size: 0.82rem;" placeholder="Prénom" required>
                    </div>

                    <div class="col-md-6">
                        <label for="nom" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Nom *</label>
                        <input type="text" name="nom" id="nom" class="form-control bg-light border-light py-2" style="font-size: 0.82rem;" placeholder="Nom" required>
                    </div>

                    <div class="col-12">
                        <label for="telephone" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Téléphone *</label>
                        <input type="tel" name="telephone" id="telephone" class="form-control bg-light border-light py-2" style="font-size: 0.82rem;" placeholder="Ex: 06 628 57 41" required>
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Email</label>
                        <input type="email" name="email" id="email" class="form-control bg-light border-light py-2" style="font-size: 0.82rem;" placeholder="votre@email.com">
                    </div>

                    <div class="col-12">
                        <label for="entreprise" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Entreprise</label>
                        <input type="text" name="entreprise" id="entreprise" class="form-control bg-light border-light py-2" style="font-size: 0.82rem;" placeholder="Nom de la société">
                    </div>

                    <div class="col-12">
                        <label for="adresse" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Adresse</label>
                        <textarea name="adresse" id="adresse" class="form-control bg-light border-light py-2" style="font-size: 0.82rem;" rows="2" placeholder="Adresse physique d'intervention..."></textarea>
                    </div>

                    <div class="col-12">
                        <label for="type_contact" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Type *</label>
                        <select name="type_contact" id="type_contact" class="form-select bg-light border-light py-2" style="font-size: 0.82rem;" required>
                            <option value="Prospect" selected>Prospect</option>
                            <option value="Client">Client</option>
                            <option value="Partenaire">Partenaire</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="notes" class="form-label fw-bold text-navy text-uppercase" style="font-size: 0.72rem;">Notes</label>
                        <textarea name="notes" id="notes" class="form-control bg-light border-light py-2" style="font-size: 0.82rem;" rows="3" placeholder="Informations complémentaires, observations..."></textarea>
                    </div>

                </div>
                <div class="modal-footer border-top border-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-4 py-2" style="font-size: 0.82rem;" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn rounded-3 fw-bold px-4 py-2 text-white" style="font-size: 0.82rem; background: #0D1B4B;">Créer le client</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- STYLES INTERACTIFS DRAG & DROP CSV -->
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

<!-- SCRIPTS SANS RECHARGEMENT ZONE DRAG & DROP -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    
    // GESTION DRAG AND DROP DU FICHIER CSV (M3)
    const dropZone = document.getElementById('dragDropZone');
    const fileInput = document.getElementById('csvFileInput');
    const browseBtn = document.getElementById('browseBtn');
    const uploadIcon = document.getElementById('uploadIcon');
    const uploadTitle = document.getElementById('uploadTitle');

    if (dropZone && fileInput) {
        
        // Ouvrir l'explorateur au clic sur "Parcourir" ou sur la zone entière
        browseBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            fileInput.click();
        });
        dropZone.addEventListener('click', () => {
            fileInput.click();
        });

        // Changement de fichier manuel
        fileInput.addEventListener('change', () => {
            handleFileSelect(fileInput.files[0]);
        });

        // Événements d'interactivité du Drag & Drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('drag-over');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('drag-over');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('drag-over');
            
            if (e.dataTransfer.files.length > 0) {
                const file = e.dataTransfer.files[0];
                fileInput.files = e.dataTransfer.files; // Assigne le fichier au champ caché
                handleFileSelect(file);
            }
        });

        // Traiter l'aspect visuel du fichier sélectionné
        const handleFileSelect = (file) => {
            if (file && (file.name.endsWith('.csv') || file.type === 'text/csv' || file.type === 'text/plain')) {
                dropZone.classList.remove('drag-over');
                dropZone.classList.add('file-selected');
                uploadIcon.className = 'bi bi-file-earmark-check-fill text-success display-4';
                uploadTitle.innerText = `Fichier sélectionné : ${file.name}`;
            } else {
                alert('Veuillez sélectionner un fichier au format .csv valide.');
                fileInput.value = ''; // Réinitialisation
                dropZone.classList.className = 'drag-drop-zone rounded-4 p-5 text-center d-flex flex-column align-items-center justify-content-center gap-3';
                uploadIcon.className = 'bi bi-cloud-arrow-up text-muted display-4';
                uploadTitle.innerText = 'Glissez-déposez votre fichier CSV ici';
            }
        };
    }
});
</script>
@endsection