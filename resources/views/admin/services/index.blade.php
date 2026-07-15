@extends('layouts.admin')

@section('title', 'Catalogue des Services | Flycom Services CRM')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
        <h1 class="h3 fw-extrabold text-navy mb-1">Catalogue des Services</h1>
        <p class="text-muted fs-8 mb-0">{{ $services->count() }} services actifs · {{ $services->count() }} au total</p>
    </div>
    
    <!-- ACTION D'AJOUT MASQUÉE POUR LE RÔLE LECTURE -->
    @if(Auth::user()->role !== 'Lecture')
    <div class="mt-1 mt-md-0 w-100 w-md-auto text-end">
        <button class="btn btn-cyan rounded-3 fs-8 fw-bold px-3 py-2 shadow-cyan-btn w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#newServiceModal" style="background-color: #00B4D8; border: none; color: #fff;">
            <i class="bi bi-plus-lg me-1"></i> Nouveau service
        </button>
    </div>
    @endif
</div>

<!-- Zone d'affichage des erreurs de validation ou d'intégrité de suppression (M4/MCD) -->
@if ($errors->any())
    <div class="alert alert-danger fs-8 py-2.5 rounded-3 border-0 mb-4 bg-danger-transparent text-danger">
        <h4 class="h6 fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i> Veuillez corriger les erreurs suivantes :</h4>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger fs-8 py-2.5 rounded-3 border-0 mb-4 bg-danger-transparent text-danger">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
    </div>
@endif

<!-- Zone de notification de succès -->
@if(session('success'))
    <div class="alert alert-success fs-8 py-2.5 rounded-3 mb-4 border-0">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
@endif

<!-- GRILLE DE CARTES DE SERVICES -->
<div class="row g-4 mb-4">
    @forelse($services as $service)
    
    @php
        $icon = 'bi-shield-fill-check';
        if ($service->nom_service === 'Réseaux Informatiques') {
            $icon = 'bi-wifi';
        } elseif ($service->nom_service === 'Vidéosurveillance') {
            $icon = 'bi-camera-video';
        } elseif ($service->nom_service === 'Contrôle d\'accès') {
            $icon = 'bi-fingerprint';
        } elseif ($service->nom_service === 'Barbelé Électrique') {
            $icon = 'bi-lightning-fill';
        } elseif ($service->nom_service === 'Panneaux Solaires') {
            $icon = 'bi-sun-fill';
        } elseif ($service->nom_service === 'Climatisation') {
            $icon = 'bi-wind';
        } elseif ($service->nom_service === 'Location de Véhicules') {
            $icon = 'bi-car-front-fill';
        } elseif ($service->nom_service === 'Location Sonorisation') {
            $icon = 'bi-volume-up-fill';
        }
    @endphp

    <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100 border border-light shadow-sm rounded-4 overflow-hidden position-relative">
            
            <div class="service-img-wrapper position-relative">
                <div class="service-icon-absolute">
                    <i class="bi {{ $icon }}"></i>
                </div>

                <img src="{{ asset($service->image) }}" class="card-img-top object-fit-cover" style="height: 180px;" alt="{{ $service->nom_service }}">
                
                <span class="service-badge-v2">
                    @if($service->prix_indicatif > 0)
                        {{ number_format($service->prix_indicatif, 0, ',', ' ') }} FCFA
                    @else
                        Sur devis
                    @endif
                </span>
            </div>

            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-2 gap-2">
                        <h3 class="h6 fw-extrabold text-navy mb-0 text-truncate" style="max-width: 70%;">{{ $service->nom_service }}</h3>
                        <span class="badge bg-cyan-soft text-cyan px-2 py-1 rounded-3 fs-10 fw-bold flex-shrink-0">{{ $service->categorie }}</span>
                    </div>
                    
                    <p class="fs-8 text-muted mb-3 leading-relaxed">
                        {{ $service->description }}
                    </p>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-light mt-2 fs-8 gap-2">
                    @if($service->actif)
                        <span class="badge bg-success-soft text-success px-2 py-1 rounded-3"><i class="bi bi-check-circle-fill me-1"></i> Actif</span>
                    @else
                        <span class="badge bg-danger-soft text-danger px-2 py-1 rounded-3"><i class="bi bi-x-circle-fill me-1"></i> Inactif</span>
                    @endif

                    <!-- ACTION DE MODIFICATION MASQUÉE POUR LE RÔLE LECTURE -->
                    @if(Auth::user()->role !== 'Lecture')
                    <button class="btn btn-light btn-sm rounded-pill px-3 py-1 fw-bold fs-9 text-navy border-0 btn-edit-service flex-shrink-0"
                        data-bs-toggle="modal"
                        data-bs-target="#editServiceModal"
                        data-id="{{ $service->id_service }}"
                        data-name="{{ $service->nom_service }}"
                        data-desc="{{ $service->description }}"
                        data-price="{{ $service->prix_indicatif }}"
                        data-unit="{{ $service->unite }}"
                        data-cat="{{ $service->categorie }}"
                        data-active="{{ $service->actif }}"
                        data-img="{{ asset($service->image) }}">
                        <i class="bi bi-pencil-square me-1"></i> Modifier
                    </button>
                    @endif
                </div>
            </div>

        </div>
    </div>
    @empty
    <div class="col-12 text-center text-muted py-5">
        Aucun service enregistré dans le catalogue.
    </div>
    @endforelse
</div>

<!-- ========================================== -->
<!-- MODAL : NOUVEAU SERVICE                     -->
<!-- ========================================== -->
@if(Auth::user()->role !== 'Lecture')
<div class="modal fade" id="newServiceModal" tabindex="-1" aria-labelledby="newServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg bg-white text-navy">
            <div class="modal-header border-bottom border-light px-4">
                <h5 class="modal-title fw-extrabold text-navy" id="newServiceModalLabel">Nouveau service</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 py-4 row g-3 fs-8 text-start">
                    
                    <div class="col-md-6">
                        <label for="nom_service" class="form-label fw-bold text-navy text-uppercase">Nom du service *</label>
                        <input type="text" name="nom_service" id="nom_service" class="form-control bg-light border-light py-2 fs-8" placeholder="Ex: Vidéosurveillance IP" required style="box-shadow: none !important;">
                    </div>

                    <div class="col-md-6">
                        <label for="categorie" class="form-label fw-bold text-navy text-uppercase">Catégorie *</label>
                        <select name="categorie" id="categorie" class="form-select bg-light border-light py-2 fs-8" required style="box-shadow: none !important;">
                            <option value="Réseau">Réseau</option>
                            <option value="Sécurité" selected>Sécurité</option>
                            <option value="Énergie">Énergie</option>
                            <option value="Confort">Confort</option>
                            <option value="Logistique">Logistique</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="prix_indicatif" class="form-label fw-bold text-navy text-uppercase">Prix indicatif (FCFA) *</label>
                        <input type="number" name="prix_indicatif" id="prix_indicatif" class="form-control bg-light border-light py-2 fs-8" value="0" min="0" required style="box-shadow: none !important;">
                    </div>

                    <div class="col-md-6">
                        <label for="unite" class="form-label fw-bold text-navy text-uppercase">Unité *</label>
                        <select name="unite" id="unite" class="form-select bg-light border-light py-2 fs-8" required style="box-shadow: none !important;">
                            <option value="Unité">Unité</option>
                            <option value="Sur devis" selected>Sur devis</option>
                            <option value="Kit de base">Kit de base</option>
                            <option value="Mètre linéaire">Mètre linéaire</option>
                            <option value="Jour">Jour</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label fw-bold text-navy text-uppercase">Description *</label>
                        <textarea name="description" id="description" class="form-control bg-light border-light py-2 fs-8" rows="4" placeholder="Description détaillée du service..." required style="box-shadow: none !important;"></textarea>
                    </div>

                    <div class="col-12 col-md-8">
                        <label for="image_file" class="form-label fw-bold text-navy text-uppercase">Image du service</label>
                        <input type="file" name="image_file" id="image_file" class="form-control bg-light border-light py-2 fs-8" accept="image/*" style="box-shadow: none !important;">
                    </div>

                    <div class="col-12 col-md-4 d-flex align-items-center pt-3 pt-md-4">
                        <div class="form-check form-switch p-2 rounded-3 border border-light bg-light d-flex align-items-center gap-2 w-100">
                            <input class="form-check-input ms-1" type="checkbox" name="actif" id="serviceActif" checked style="width: 32px; height: 16px;">
                            <label class="form-check-label fs-9 text-navy fw-semibold" for="serviceActif">Visible sur le site</label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top border-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-4 py-2" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-navy rounded-3 fs-8 fw-bold px-4 py-2 text-white" style="background-color: #0D1B4B; border: none; width: auto !important;">Créer le service</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- ========================================== -->
<!-- MODAL : MODIFIER LE SERVICE                 -->
<!-- ========================================== -->
@if(Auth::user()->role !== 'Lecture')
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg bg-white text-navy">
            <div class="modal-header border-bottom border-light px-4 py-3">
                <h5 class="modal-title fw-extrabold text-navy" id="editServiceModalLabel">Modifier le service</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="" method="POST" id="editServiceForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 py-4 row g-3 fs-8 text-start">
                    
                    <div class="col-md-6">
                        <label for="edit_nom_service" class="form-label fw-bold text-navy text-uppercase">Nom du service *</label>
                        <input type="text" name="nom_service" id="edit_nom_service" class="form-control bg-light border-light py-2 fs-8" required style="box-shadow: none !important;">
                    </div>

                    <div class="col-md-6">
                        <label for="edit_categorie" class="form-label fw-bold text-navy text-uppercase">Catégorie *</label>
                        <select name="categorie" id="edit_categorie" class="form-select bg-light border-light py-2 fs-8" required style="box-shadow: none !important;">
                            <option value="Réseau">Réseau</option>
                            <option value="Sécurité">Sécurité</option>
                            <option value="Énergie">Énergie</option>
                            <option value="Confort">Confort</option>
                            <option value="Logistique">Logistique</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="edit_prix_indicatif" class="form-label fw-bold text-navy text-uppercase">Prix indicatif (FCFA) *</label>
                        <input type="number" name="prix_indicatif" id="edit_prix_indicatif" class="form-control bg-light border-light py-2 fs-8" min="0" required style="box-shadow: none !important;">
                    </div>

                    <div class="col-md-6">
                        <label for="edit_unite" class="form-label fw-bold text-navy text-uppercase">Unité *</label>
                        <select name="unite" id="edit_unite" class="form-select bg-light border-light py-2 fs-8" required style="box-shadow: none !important;">
                            <option value="Unité">Unité</option>
                            <option value="Sur devis">Sur devis</option>
                            <option value="Kit de base">Kit de base</option>
                            <option value="Mètre linéaire">Mètre linéaire</option>
                            <option value="Jour">Jour</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="edit_description" class="form-label fw-bold text-navy text-uppercase">Description *</label>
                        <textarea name="description" id="edit_description" class="form-control bg-light border-light py-2 fs-8" rows="4" required style="box-shadow: none !important;"></textarea>
                    </div>

                    <div class="col-12 col-md-8">
                        <label for="edit_image_file" class="form-label fw-bold text-navy text-uppercase">Remplacer l'image</label>
                        <input type="file" name="image_file" id="edit_image_file" class="form-control bg-light border-light py-2 fs-8" accept="image/*" style="box-shadow: none !important;">
                        
                        <div class="mt-3 d-flex align-items-center gap-3">
                            <span class="text-muted fs-10 d-block">Image actuelle :</span>
                            <img src="" id="editImagePreview" alt="Aperçu" class="rounded border border-light" style="width: 80px; height: 50px; object-fit: cover;">
                        </div>
                    </div>

                    <div class="col-12 col-md-4 d-flex align-items-center pt-3 pt-md-4">
                        <div class="form-check form-switch p-2 rounded-3 border border-light bg-light d-flex align-items-center gap-2 w-100">
                            <input class="form-check-input ms-1" type="checkbox" name="actif" id="edit_actif" style="width: 32px; height: 16px;">
                            <label class="form-check-label fs-9 text-navy fw-semibold" for="edit_actif">Visible sur le site</label>
                        </div>
                    </div>

                </div>
                
                <!-- FOOTER MODAL : Intègre le bouton de suppression pour l'Admin (Image 25) -->
                <div class="modal-footer border-top border-light px-4 py-3 d-flex justify-content-between gap-2 flex-wrap">
                    <div>
                        @if(Auth::user()->role === 'Admin')
                        <button type="button" class="btn btn-outline-danger rounded-3 fs-8 fw-semibold px-3 py-2 w-100 w-sm-auto" id="btnDeleteService" style="border-radius: 8px !important;">
                            <i class="bi bi-trash3-fill"></i> Supprimer
                        </button>
                        @endif
                    </div>
                    <div class="d-flex gap-2 w-100 w-sm-auto justify-content-end">
                        <button type="button" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-4 py-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-navy rounded-3 fs-8 fw-bold px-4 py-2 text-white" style="background:#0D1B4B; border:none; width: auto !important;">Enregistrer les modifications</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- FORMULAIRE MASQUÉ DE SUPPRESSION PHYSIQUE -->
@if(Auth::user()->role === 'Admin')
<form action="" method="POST" id="deleteServiceForm" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endif

@endif

<!-- SCRIPTS DE PRÉ-REMPLISSAGE ET GESTION DES REQUÊTES -->
@if(Auth::user()->role !== 'Lecture')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const editForm = document.getElementById('editServiceForm');
    const editModalElement = document.getElementById('editServiceModal');
    const deleteForm = document.getElementById('deleteServiceForm');
    const btnDelete = document.getElementById('btnDeleteService');

    if (editModalElement) {
        document.querySelectorAll('.btn-edit-service').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                const name = btn.getAttribute('data-name');
                const desc = btn.getAttribute('data-desc');
                const price = btn.getAttribute('data-price');
                const unit = btn.getAttribute('data-unit');
                const cat = btn.getAttribute('data-cat');
                const active = btn.getAttribute('data-active');
                const img = btn.getAttribute('data-img');

                editForm.action = `/admin/services-catalogue/${id}/update`;
                
                // Assigner la route de suppression dynamique (M3)
                if (deleteForm) {
                    deleteForm.action = `/admin/services-catalogue/${id}/delete`;
                }

                document.getElementById('edit_nom_service').value = name;
                document.getElementById('edit_description').value = desc;
                document.getElementById('edit_prix_indicatif').value = parseFloat(price);
                document.getElementById('edit_unite').value = unit;
                document.getElementById('edit_categorie').value = cat;
                
                document.getElementById('editImagePreview').src = img;
                document.getElementById('edit_actif').checked = (active == 1);
            });
        });
    }

    // Gestion du clic de suppression définitive
    if (btnDelete && deleteForm) {
        btnDelete.addEventListener('click', (e) => {
            e.preventDefault();
            if (confirm("Êtes-vous sûr de vouloir supprimer définitivement ce service de votre catalogue d'entreprise ? Cette action est irréversible et retirera le service du site vitrine.")) {
                deleteForm.submit();
            }
        });
    }
});
</script>
@endif
@endsection