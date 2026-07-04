<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CRM Flycom Services | Centre de Contrôle')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link class="canonical" href="{{ url()->current() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

    <div class="d-flex min-vh-100">
        
        <!-- BARRE LATÉRALE GAUCHE -->
        <aside class="flex-shrink-0 py-4 position-relative" style="width: 260px; min-height: 100vh; background-color: #050E2D !important; border-right: 1px solid rgba(255, 255, 255, 0.05); z-index: 100; overflow: hidden;">
            <div class="network-particles"></div>

            <div class="position-relative z-3 d-flex flex-column justify-content-between h-100 w-100">
                <div>
                    <!-- En-tête de marque -->
                    <div class="px-4 mb-4">
                        <a class="d-flex align-items-center gap-2 text-decoration-none" href="{{ route('admin.dashboard') }}">
                            <div class="brand-logo bg-cyan-gradient rounded-3 p-2 text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 32px;">
                                <i class="bi bi-shield-fill-check fs-5"></i>
                            </div>
                            <div>
                                <span class="fw-extrabold text-white tracking-tight d-block fs-8 lh-1">FLYCOM <span class="text-cyan">SERVICES</span></span>
                                <small class="text-light-muted fs-10 tracking-widest text-uppercase">Back-office CRM</small>
                            </div>
                        </a>
                    </div>

                    <!-- Profil connecté de la Sidebar -->
                    <div class="px-4 py-3 mb-4 border-top border-bottom border-navy-light d-flex align-items-center gap-3" style="border-color: rgba(255,255,255,0.08) !important;">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset(Auth::user()->avatar) }}" class="rounded-circle object-fit-cover" style="width: 38px; height: 38px; border: 2px solid #00D2F4; box-shadow: 0 2px 8px rgba(0, 210, 244, 0.25); flex-shrink: 0;" alt="Avatar">
                        @else
                            <div class="d-flex align-items-center justify-content-center fw-bold text-uppercase" style="width: 38px; height: 38px; border-radius: 50% !important; background-color: #00D2F4 !important; color: #050E2D !important; font-weight: 800; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0, 210, 244, 0.25);">
                                {{ substr(Auth::user()->prenom_user, 0, 1) }}{{ substr(Auth::user()->nom_user, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <span class="d-block fw-bold text-white fs-8">{{ Auth::user()->prenom_user }} {{ Auth::user()->nom_user }}</span>
                            <small class="text-cyan fs-10 text-uppercase tracking-wider">{{ Auth::user()->role }}</small>
                        </div>
                    </div>

                    <!-- Menu de navigation -->
                    <nav class="px-2" aria-label="Navigation CRM">
                        <ul class="list-unstyled d-flex flex-column gap-1">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="nav-crm-link {{ Route::is('admin.dashboard') ? 'active' : '' }}" 
                                   style="{{ Route::is('admin.dashboard') ? 'color: #ffffff !important; background-color: rgba(0, 210, 244, 0.08) !important; border-left: 3px solid #00D2F4; font-weight: 600;' : 'color: rgba(255, 255, 255, 0.6) !important;' }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            
                            <!-- ONGLET LEADS / KANBAN : Chiffre dynamisé par requête directe (M3 - 100% opérationnel) -->
                            <li>
                                <a href="{{ route('admin.leads.index') }}" class="nav-crm-link d-flex justify-content-between align-items-center {{ Route::is('admin.leads.index') ? 'active' : '' }}"
                                   style="{{ Route::is('admin.leads.index') ? 'color: #ffffff !important; background-color: rgba(0, 210, 244, 0.08) !important; border-left: 3px solid #00D2F4; font-weight: 600;' : 'color: rgba(255, 255, 255, 0.6) !important;' }}">
                                    <span><i class="bi bi-kanban"></i> Leads / Kanban</span>
                                    @php
                                        // Requête SQL d'agrégation d'intégrité : Compte tous les leads qui ne sont ni Gagnés ni Perdus
                                        $dynamicLeadsCount = \App\Models\Lead::whereNotIn('statut', ['Gagne', 'Perdu'])->count();
                                    @endphp
                                    @if($dynamicLeadsCount > 0)
                                        <span class="badge bg-danger rounded-circle fs-10" style="padding: 4px 6px;">{{ $dynamicLeadsCount }}</span>
                                    @endif
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('admin.clients.index') }}" class="nav-crm-link {{ Route::is('admin.clients.index') ? 'active' : '' }}"
                                   style="{{ Route::is('admin.clients.index') ? 'color: #ffffff !important; background-color: rgba(0, 210, 244, 0.08) !important; border-left: 3px solid #00D2F4; font-weight: 600;' : 'color: rgba(255, 255, 255, 0.6) !important;' }}">
                                    <i class="bi bi-people"></i> Clients
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.devis.index') }}" class="nav-crm-link {{ Route::is('admin.devis.index') ? 'active' : '' }}"
                                style="{{ Route::is('admin.devis.index') ? 'color: #ffffff !important; background-color: rgba(0, 210, 244, 0.08) !important; border-left: 3px solid #00D2F4; font-weight: 600;' : 'color: rgba(255, 255, 255, 0.6) !important;' }}">
                                    <i class="bi bi-file-earmark-pdf"></i> Devis &amp; Factures
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.agenda.index') }}" class="nav-crm-link {{ Route::is('admin.agenda.index') ? 'active' : '' }}"
                                style="{{ Route::is('admin.agenda.index') ? 'color: #ffffff !important; background-color: rgba(0, 210, 244, 0.08) !important; border-left: 3px solid #00D2F4; font-weight: 600;' : 'color: rgba(255, 255, 255, 0.6) !important;' }}">
                                    <i class="bi bi-calendar3"></i> Agenda &amp; Relances
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.services.index') }}" class="nav-crm-link {{ Route::is('admin.services.index') ? 'active' : '' }}"
                                style="{{ Route::is('admin.services.index') ? 'color: #ffffff !important; background-color: rgba(0, 210, 244, 0.08) !important; border-left: 3px solid #00D2F4; font-weight: 600;' : 'color: rgba(255, 255, 255, 0.6) !important;' }}">
                                    <i class="bi bi-grid-3x3-gap"></i> Catalogue Services
                                </a>
                            </li>
                            
                            @if(Auth::user()->role === 'Admin')
                            <li>
                                <a href="{{ route('admin.settings.index') }}" class="nav-crm-link {{ Route::is('admin.settings.index') ? 'active' : '' }}"
                                style="{{ Route::is('admin.settings.index') ? 'color: #ffffff !important; background-color: rgba(0, 210, 244, 0.08) !important; border-left: 3px solid #00D2F4; font-weight: 600;' : 'color: rgba(255, 255, 255, 0.6) !important;' }}">
                                    <i class="bi bi-sliders"></i> Paramètres
                                </a>
                            </li>
                            @endif

                            <li>
                                <a href="{{ route('admin.documentation.index') }}" class="nav-crm-link {{ Route::is('admin.documentation.index') ? 'active' : '' }}"
                                style="{{ Route::is('admin.documentation.index') ? 'color: #ffffff !important; background-color: rgba(0, 210, 244, 0.08) !important; border-left: 3px solid #00D2F4; font-weight: 600;' : 'color: rgba(255, 255, 255, 0.6) !important;' }}">
                                    <i class="bi bi-journal-text"></i> Documentation
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Bouton Déconnexion -->
                <div class="px-3">
                    <form action="{{ route('logout') }}" method="POST" class="d-block">
                        @csrf
                        <button type="submit" class="btn btn-transparent nav-crm-link w-100 text-start border-0" style="color: rgba(255, 255, 255, 0.6) !important;">
                            <i class="bi bi-box-arrow-right text-danger"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- ZONE DE CONTENU À DROITE -->
        <div class="flex-grow-1 d-flex flex-column">
            
            <!-- HEADER SUPÉRIEUR -->
            <header class="bg-white border-bottom border-light py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <span class="fs-8 text-muted"><i class="bi bi-calendar-event me-2"></i> {{ \Carbon\Carbon::now()->translatedFormat('l d F Y') }}</span>
                    <span class="text-muted fs-8">|</span>
                    <span class="fs-8 text-muted"><i class="bi bi-clock me-2"></i> <span id="crmTime">--:--</span></span>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <!-- RECHERCHE GLOBALE INTERACTIVE (Unifiée et 100% opérationnelle) -->
                    <div class="position-relative d-none d-md-block" style="width: 260px; z-index: 1050;">
                        <span class="position-absolute start-0 top-50 translate-middle-y ms-3 text-muted fs-8"><i class="bi bi-search"></i></span>
                        <input type="text" id="globalSearchInput" class="form-control bg-light border-0 py-2 ps-5 fs-8 shadow-none" placeholder="Rechercher... (Ctrl+K)" autocomplete="off" style="border-radius: 8px !important;">
                        
                        <!-- Menu flottant de résultats de recherche rapide -->
                        <ul class="position-absolute dropdown-menu border-0 shadow-lg rounded-4 p-2 mt-2" id="globalSearchResults" style="width: 100%; max-height: 320px; overflow-y: auto; font-size: 0.8rem; top: 100%; left: 0; margin-top: 10px !important;">
                            <li class="dropdown-header fw-bold text-navy border-bottom pb-1.5 mb-1.5 d-flex justify-content-between align-items-center">
                                <span class="fs-8 text-navy"><i class="bi bi-lightning-charge-fill text-cyan"></i> Résultats rapides</span>
                            </li>
                            <div id="globalSearchResultsContainer" class="d-flex flex-column gap-1"></div>
                        </ul>
                    </div>

                    <!-- Bouton public -->
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-light bg-light border-0 rounded-3 py-2 px-3 fs-8 text-navy fw-semibold d-flex align-items-center gap-2 hover-cyan transition-all">
                        <i class="bi bi-box-arrow-up-right"></i> Voir le site
                    </a>
                    
                    <!-- CLOCHE DE NOTIFICATION DYNAMIQUE -->
                    <div class="dropdown">
                        <button class="btn btn-light bg-light border-0 rounded-circle p-2 position-relative shadow-none" type="button" id="notificationBellBtn" data-bs-toggle="dropdown" aria-expanded="false" style="width:34px; height:34px;">
                            <i class="bi bi-bell fs-7 text-navy"></i>
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle d-none" id="notificationBadge" style="width:10px; height:10px; top: 5px !important; left: 90% !important;"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-3" aria-labelledby="notificationBellBtn" id="notificationDropdownMenu" style="width: 340px; max-height: 400px; overflow-y: auto; font-size: 0.8rem; z-index: 1060; margin-top: 10px !important;">
                            <li class="dropdown-header fw-bold text-navy border-bottom pb-2 mb-2 d-flex justify-content-between align-items-center">
                                <span class="fs-7"><i class="bi bi-bell-fill text-cyan me-1"></i> Notifications</span>
                                <span class="badge bg-danger rounded-pill" id="notificationCountBadge" style="font-size:0.7rem;">0</span>
                            </li>
                            <div id="notificationListContainer" class="d-flex flex-column gap-1">
                                <li class="text-center py-4 text-muted" id="noNotificationsItem">
                                    <i class="bi bi-bell-slash fs-4 d-block mb-1"></i> Aucune alerte urgente.
                                </li>
                            </div>
                        </ul>
                    </div>

                    <!-- DROPDOWN DU PROFIL UTILISATEUR CONNECTÉ -->
                    <div class="dropdown">
                        <button class="btn btn-transparent p-0 border-0 d-flex align-items-center gap-2 shadow-none" type="button" id="profileDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false" style="outline: none !important;">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset(Auth::user()->avatar) }}" class="rounded-circle object-fit-cover" style="width: 34px; height: 34px; border: 2px solid #00D2F4; box-shadow: 0 2px 8px rgba(0, 210, 244, 0.25); flex-shrink: 0;" alt="Avatar">
                            @else
                                <div class="d-flex align-items-center justify-content-center fw-bold text-uppercase text-navy" style="width: 34px; height: 34px; border-radius: 50% !important; background-color: #00D2F4 !important; font-weight: 800; flex-shrink: 0; font-size: 0.78rem; box-shadow: 0 2px 8px rgba(0, 210, 244, 0.25);">
                                    {{ substr(Auth::user()->prenom_user, 0, 1) }}{{ substr(Auth::user()->nom_user, 0, 1) }}
                                </div>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2 text-start" aria-labelledby="profileDropdownBtn" style="width: 240px; margin-top: 10px !important;">
                            <li class="dropdown-header border-bottom pb-2 mb-2 text-start">
                                <strong class="d-block text-navy fs-8">{{ Auth::user()->prenom_user }} {{ Auth::user()->nom_user }}</strong>
                                <small class="text-muted fs-9 d-block mt-0.5" style="text-transform: none;">{{ Auth::user()->email }}</small>
                                <span class="badge bg-cyan-soft text-cyan fs-10 mt-1.5 fw-bold">{{ Auth::user()->role }}</span>
                            </li>
                            <li>
                                <button class="dropdown-item py-2 d-flex align-items-center gap-2 fw-semibold fs-8" type="button" data-bs-toggle="modal" data-bs-target="#userProfileModal">
                                    <i class="bi bi-person-fill text-muted"></i> Mon Profil
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item py-2 d-flex align-items-center gap-2 fw-semibold fs-8" type="button" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    <i class="bi bi-shield-lock-fill text-muted"></i> Securité &amp; Accès
                                </button>
                            </li>
                            <li><hr class="dropdown-divider opacity-50"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-block w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger d-flex align-items-center gap-2 fw-semibold fs-8" style="background: none; border: none; width: 100%;">
                                        <i class="bi bi-box-arrow-right"></i> Se déconnecter
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- CONTENU INJECTÉ -->
            <div class="p-4 flex-grow-1" style="overflow-y: auto; max-height: calc(100vh - 70px);">
                @yield('content')
            </div>

        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL : ÉDITION ET APERÇU DU PROFIL PERSONNEL -->
    <!-- ======================================================== -->
    <div class="modal fade" id="userProfileModal" tabindex="-1" aria-labelledby="userProfileModalLabel" aria-hidden="true" style="z-index: 1070;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow bg-white text-navy">
                <div class="modal-header border-bottom border-light px-4 py-3">
                    <h5 class="modal-title fw-bold text-navy fs-6" id="userProfileModalLabel">Mon profil personnel</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body px-4 py-4 row g-3 text-start fs-8">
                        <!-- Visualisation et Téléversement de l'avatar -->
                        <div class="col-12 d-flex align-items-center gap-3 bg-light p-3 rounded-4 mb-2">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset(Auth::user()->avatar) }}" class="rounded-circle object-fit-cover" style="width: 58px; height: 58px; border: 2px solid #00D2F4; box-shadow: 0 2px 8px rgba(0, 210, 244, 0.25); flex-shrink: 0;" alt="Avatar">
                            @else
                                <div class="d-flex align-items-center justify-content-center fw-bold text-uppercase text-navy" style="width: 58px; height: 58px; border-radius: 50% !important; background-color: #00D2F4 !important; font-weight: 800; flex-shrink: 0; font-size: 1.15rem; box-shadow: 0 2px 8px rgba(0, 210, 244, 0.25);">
                                    {{ substr(Auth::user()->prenom_user, 0, 1) }}{{ substr(Auth::user()->nom_user, 0, 1) }}
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <label for="avatar_file_profile" class="form-label fw-bold text-muted text-uppercase mb-1" style="font-size: 0.72rem;">Changer ma photo de profil</label>
                                <input type="file" name="avatar_file" id="avatar_file_profile" class="form-control bg-white border-light-subtle py-1.5 fs-8" accept="image/*" style="box-shadow: none !important;">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="profile_prenom" class="form-label fw-bold text-muted text-uppercase" style="font-size: 0.72rem;">Prénom *</label>
                            <input type="text" name="prenom_user" id="profile_prenom" class="form-control bg-light border-light py-2 fs-8" value="{{ Auth::user()->prenom_user }}" required style="box-shadow: none !important;">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="profile_nom" class="form-label fw-bold text-muted text-uppercase" style="font-size: 0.72rem;">Nom *</label>
                            <input type="text" name="nom_user" id="profile_nom" class="form-control bg-light border-light py-2 fs-8" value="{{ Auth::user()->nom_user }}" required style="box-shadow: none !important;">
                        </div>

                        <div class="col-12">
                            <label for="profile_email" class="form-label fw-bold text-muted text-uppercase" style="font-size: 0.72rem;">Email professionnel *</label>
                            <input type="email" name="email" id="profile_email" class="form-control bg-light border-light py-2 fs-8" value="{{ Auth::user()->email }}" required style="box-shadow: none !important;">
                        </div>

                        <div class="col-12 text-start text-muted mt-3" style="font-size: 0.75rem;">
                            <span>Dernière connexion : <strong>{{ Auth::user()->derniere_connexion ? Auth::user()->derniere_connexion->format('d/m/Y H:i') : 'Première connexion' }}</strong></span>
                        </div>
                    </div>
                    <div class="modal-footer border-top border-light px-4 py-3">
                        <button type="button" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-4 py-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-navy rounded-3 fs-8 fw-bold px-4 py-2 text-white" style="background:#0D1B4B; border:none; width: auto !important;">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL : SÉCURITÉ ET CHANGEMENT DE MOT DE PASSE -->
    <!-- ======================================================== -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true" style="z-index: 1070;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow bg-white text-navy">
                <div class="modal-header border-bottom border-light px-4 py-3">
                    <h5 class="modal-title fw-bold text-navy fs-6" id="changePasswordModalLabel">Modifier mon mot de passe</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf
                    <div class="modal-body px-4 py-4 row g-3 text-start fs-8">
                        <div class="col-12">
                            <label for="current_password" class="form-label fw-bold text-muted text-uppercase mb-2" style="font-size: 0.72rem;">Mot de passe actuel *</label>
                            <input type="password" name="current_password" id="current_password" class="form-control bg-light border-light py-2 fs-8" placeholder="••••••••" required style="box-shadow: none !important;">
                        </div>

                        <div class="col-md-6">
                            <label for="new_password" class="form-label fw-bold text-muted text-uppercase mb-2" style="font-size: 0.72rem;">Nouveau mot de passe *</label>
                            <input type="password" name="new_password" id="new_password" class="form-control bg-light border-light py-2 fs-8" placeholder="••••••••" required style="box-shadow: none !important;">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="new_password_confirmation" class="form-label fw-bold text-muted text-uppercase mb-2" style="font-size: 0.72rem;">Confirmer le mot de passe *</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control bg-light border-light py-2 fs-8" placeholder="••••••••" required style="box-shadow: none !important;">
                        </div>

                        <div class="col-12 mt-3 text-muted" style="font-size: 0.75rem; border-top: 1px solid #F1F5F9; padding-top: 10px;">
                            <i class="bi bi-shield-check text-cyan me-1"></i> Règles de complexité : minimum 8 caractères, une lettre, un chiffre et un caractère spécial obligatoires.
                        </div>
                    </div>
                    <div class="modal-footer border-top border-light px-4 py-3">
                        <button type="button" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-4 py-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-navy rounded-3 fs-8 fw-bold px-4 py-2 text-white" style="background:#0D1B4B; border:none; width: auto !important;">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script de mise à jour de l'heure et des requêtes asynchrones -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Horloge temps réel
            const timeSpan = document.getElementById('crmTime');
            const updateTime = () => {
                const now = new Date();
                timeSpan.textContent = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
            };
            setInterval(updateTime, 1000);
            updateTime();

            // 2. Récupération asynchrone des notifications (M5)
            const badge = document.getElementById('notificationBadge');
            const countBadge = document.getElementById('notificationCountBadge');
            const listContainer = document.getElementById('notificationListContainer');
            const noNotifItem = document.getElementById('noNotificationsItem');

            const fetchNotifications = () => {
                fetch('{{ route("admin.notifications") }}')
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if (data.count > 0) {
                                badge.classList.remove('d-none');
                                countBadge.innerText = data.count;
                                if (noNotifItem) noNotifItem.classList.add('d-none');
                                
                                listContainer.innerHTML = '';
                                data.notifications.forEach(notif => {
                                    const li = document.createElement('li');
                                    li.innerHTML = `
                                        <a class="dropdown-item p-2.5 rounded-3 d-flex gap-3 align-items-start text-wrap border border-light-subtle bg-light mb-1 hover-cyan" href="${notif.link}" style="transition: background 0.2s; border-radius: 8px !important;">
                                            <div class="avatar-circle rounded-circle p-2 text-center d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; flex-shrink: 0; background: #F1F5F9; border-radius: 50%;">
                                                <i class="bi ${notif.icon}"></i>
                                            </div>
                                            <div class="flex-grow-1 text-start">
                                                <strong class="d-block text-navy fs-9 mb-1" style="font-size:0.75rem; line-height:1.2;">${notif.title}</strong>
                                                <p class="text-muted mb-1 fs-10" style="font-size:0.7rem; line-height:1.3; margin-bottom: 2px;">${notif.message}</p>
                                                <small class="text-muted d-block" style="font-size:0.65rem;">${notif.time}</small>
                                            </div>
                                        </a>
                                    `;
                                    listContainer.appendChild(li);
                                });
                            } else {
                                badge.classList.add('d-none');
                                countBadge.innerText = '0';
                                listContainer.innerHTML = `
                                    <li class="text-center py-4 text-muted" id="noNotificationsItem">
                                        <i class="bi bi-bell-slash fs-4 d-block mb-1"></i> Aucune alerte urgente.
                                    </li>
                                `;
                            }
                        }
                    })
                    .catch(err => console.error("Flycom notification error:", err));
            };

            // Charger les alertes
            fetchNotifications();

            // Interrogation cyclique toutes les 30 secondes
            setInterval(fetchNotifications, 30000);

            // 3. Recherche globale unifiée (Clients, Leads, Devis - Nouveau)
            const globalSearchInput = document.getElementById('globalSearchInput');
            const globalSearchResults = document.getElementById('globalSearchResults');
            const globalResultsContainer = document.getElementById('globalSearchResultsContainer');

            if (globalSearchInput && globalSearchResults && globalResultsContainer) {
                globalSearchInput.addEventListener('input', () => {
                    const query = globalSearchInput.value.trim();
                    if (query.length < 2) {
                        // CORRIGÉ : Utiliser la classe "show" de Bootstrap pour masquer de façon étanche le dropdown-menu (MLD)
                        globalSearchResults.classList.remove('show');
                        return;
                    }

                    fetch(`{{ route('admin.globalSearch') }}?query=${encodeURIComponent(query)}`)
                        .then(res => {
                            if (!res.ok) throw new Error("Erreur de communication API");
                            return res.json();
                        })
                        .then(data => {
                            if (data.success) {
                                globalResultsContainer.innerHTML = '';
                                if (data.results.length > 0) {
                                    // CORRIGÉ : Utiliser la classe "show" de Bootstrap pour forcer l'affichage du dropdown-menu (MLD)
                                    globalSearchResults.classList.add('show');
                                    data.results.forEach(res => {
                                        const li = document.createElement('li');
                                        li.innerHTML = `
                                            <a class="dropdown-item p-2.5 rounded-3 d-flex gap-2.5 align-items-center text-wrap border border-light-subtle bg-light mb-1 hover-cyan" href="${res.link}" style="transition: background 0.2s; border-radius: 8px !important;">
                                                <div class="avatar-circle rounded-circle p-2 text-center d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; flex-shrink: 0; background: #F1F5F9; border-radius: 50%;">
                                                    <i class="bi ${res.icon}"></i>
                                                </div>
                                                <div class="flex-grow-1 text-start">
                                                    <strong class="d-block text-navy fs-9 mb-1" style="font-size:0.75rem; line-height:1.2;">${res.title}</strong>
                                                    <small class="text-muted d-block" style="font-size:0.65rem;">${res.category} · ${res.meta}</small>
                                                </div>
                                            </a>
                                        `;
                                        globalResultsContainer.appendChild(li);
                                    });
                                } else {
                                    // CORRIGÉ : Utiliser la classe "show" de Bootstrap pour afficher la mention "Aucun résultat" (MLD)
                                    globalSearchResults.classList.add('show');
                                    globalResultsContainer.innerHTML = `
                                        <li class="text-center py-3 text-muted">
                                            <i class="bi bi-search fs-5 d-block mb-1"></i> Aucun résultat trouvé.
                                        </li>
                                    `;
                                }
                            }
                        })
                        .catch(err => console.error("Global search error:", err));
                });

                // Fermer la boîte si on clique ailleurs
                document.addEventListener('click', (e) => {
                    if (!globalSearchInput.contains(e.target) && !globalSearchResults.contains(e.target)) {
                        // CORRIGÉ : Utiliser la classe "show" de Bootstrap pour masquer proprement (MLD)
                        globalSearchResults.classList.remove('show');
                    }
                });

                // Raccourci clavier Ctrl+K (ou Cmd+K) pour focaliser la recherche globale (Nouveau)
                document.addEventListener('keydown', (e) => {
                    if ((e.ctrlKey || e.metaKey) && e.key && e.key.toLowerCase() === 'k') {
                        e.preventDefault();
                        globalSearchInput.focus();
                    }
                });
            }
        });
    </script>
</body>
</html>