<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CRM Flycom Services | Centre de Contrôle')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

    <div class="d-flex min-vh-100">
        
        <!-- BARRE LATÉRALE GAUCHE (SIDEBAR AVEC COULEUR FORCÉE EN INLINE CSS) -->
        <aside class="flex-shrink-0 py-4 position-relative" style="width: 260px; min-height: 100vh; background-color: #050E2D !important; border-right: 1px solid rgba(255, 255, 255, 0.05); z-index: 100; overflow: hidden;">
            <!-- Réseau de neurones interactif en arrière-plan -->
            <div class="network-particles"></div>

            <!-- Conteneur de contenu surélevé pour garantir la clarté et l'interactivité des clics -->
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

                    <!-- Profil connecté (Avatar forcé en Inline) -->
                    <div class="px-4 py-3 mb-4 border-top border-bottom border-navy-light d-flex align-items-center gap-3" style="border-color: rgba(255,255,255,0.08) !important;">
                        <div class="d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; border-radius: 50% !important; background-color: #00D2F4 !important; color: #050E2D !important; font-weight: 800; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0, 210, 244, 0.25);">
                            {{ substr(Auth::user()->prenom_user, 0, 1) }}{{ substr(Auth::user()->nom_user, 0, 1) }}
                        </div>
                        <div>
                            <span class="d-block fw-bold text-white fs-8">{{ Auth::user()->prenom_user }} {{ Auth::user()->nom_user }}</span>
                            <small class="text-cyan fs-10 text-uppercase tracking-wider">{{ Auth::user()->role }}</small>
                        </div>
                    </div>

                    <!-- Menu de navigation (Liaisons, détection et couleurs actives forcées) -->
                    <nav class="px-2" aria-label="Navigation CRM">
                        <ul class="list-unstyled d-flex flex-column gap-1">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="nav-crm-link {{ Route::is('admin.dashboard') ? 'active' : '' }}" 
                                   style="{{ Route::is('admin.dashboard') ? 'color: #ffffff !important; background-color: rgba(0, 210, 244, 0.08) !important; border-left: 3px solid #00D2F4; font-weight: 600;' : 'color: rgba(255, 255, 255, 0.6) !important;' }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.leads.index') }}" class="nav-crm-link d-flex justify-content-between align-items-center {{ Route::is('admin.leads.index') ? 'active' : '' }}"
                                   style="{{ Route::is('admin.leads.index') ? 'color: #ffffff !important; background-color: rgba(0, 210, 244, 0.08) !important; border-left: 3px solid #00D2F4; font-weight: 600;' : 'color: rgba(255, 255, 255, 0.6) !important;' }}">
                                    <span><i class="bi bi-kanban"></i> Leads / Kanban</span>
                                    <span class="badge bg-danger rounded-circle fs-10" style="padding: 4px 6px;">2</span>
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
                            <!-- Remplacement de la ligne "Catalogue Services" par : -->
                            <li>
                                <a href="{{ route('admin.services.index') }}" class="nav-crm-link {{ Route::is('admin.services.index') ? 'active' : '' }}"
                                style="{{ Route::is('admin.services.index') ? 'color: #ffffff !important; background-color: rgba(0, 210, 244, 0.08) !important; border-left: 3px solid #00D2F4; font-weight: 600;' : 'color: rgba(255, 255, 255, 0.6) !important;' }}">
                                    <i class="bi bi-grid-3x3-gap"></i> Catalogue Services
                                </a>
                            </li>
                            <!-- Remplacement de la ligne "Paramètres" par : -->
                            <li>
                                <a href="{{ route('admin.settings.index') }}" class="nav-crm-link {{ Route::is('admin.settings.index') ? 'active' : '' }}"
                                style="{{ Route::is('admin.settings.index') ? 'color: #ffffff !important; background-color: rgba(0, 210, 244, 0.08) !important; border-left: 3px solid #00D2F4; font-weight: 600;' : 'color: rgba(255, 255, 255, 0.6) !important;' }}">
                                    <i class="bi bi-sliders"></i> Paramètres
                                </a>
                            </li>
                            <!-- Remplacement de la ligne "Documentation" par : -->
                            <li>
                                <a href="{{ route('admin.documentation.index') }}" class="nav-crm-link {{ Route::is('admin.documentation.index') ? 'active' : '' }}"
                                style="{{ Route::is('admin.documentation.index') ? 'color: #ffffff !important; background-color: rgba(0, 210, 244, 0.08) !important; border-left: 3px solid #00D2F4; font-weight: 600;' : 'color: rgba(255, 255, 255, 0.6) !important;' }}">
                                    <i class="bi bi-journal-text"></i> Documentation
                                </a>
                            </li>
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
                    <!-- Recherche globale -->
                    <div class="position-relative d-none d-md-block" style="width: 200px;">
                        <span class="position-absolute start-0 top-50 translate-middle-y ms-3 text-muted fs-8"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control bg-light border-0 py-2 ps-5 fs-8" placeholder="Rechercher... (Ctrl+K)">
                    </div>

                    <!-- Bouton public "Voir le site" -->
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-light bg-light border-0 rounded-3 py-2 px-3 fs-8 text-navy fw-semibold d-flex align-items-center gap-2 hover-cyan transition-all">
                        <i class="bi bi-box-arrow-up-right"></i> Voir le site
                    </a>
                    
                    <!-- Notification Bell -->
                    <button class="btn btn-light bg-light border-0 rounded-circle p-2 position-relative" aria-label="Notifications">
                        <i class="bi bi-bell fs-7 text-navy"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    </button>

                    <!-- Avatar de profil en haut à droite (Forcé en circulaire) -->
                    <div class="d-flex align-items-center justify-content-center fw-bold" style="width: 34px; height: 34px; border-radius: 50% !important; background-color: #00D2F4 !important; color: #050E2D !important; font-weight: 800; flex-shrink: 0; font-size: 0.78rem; box-shadow: 0 2px 8px rgba(0, 210, 244, 0.25);">
                        {{ substr(Auth::user()->prenom_user, 0, 1) }}{{ substr(Auth::user()->nom_user, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- CONTENU INJECTÉ -->
            <div class="p-4 flex-grow-1" style="overflow-y: auto; max-height: calc(100vh - 70px);">
                @yield('content')
            </div>

        </div>
    </div>

    <!-- Script de mise à jour de l'heure en temps réel -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const timeSpan = document.getElementById('crmTime');
            const updateTime = () => {
                const now = new Date();
                timeSpan.textContent = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
            };
            setInterval(updateTime, 1000);
            updateTime();
        });
    </script>
</body>
</html>