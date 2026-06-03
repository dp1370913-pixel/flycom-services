@extends('layouts.public')

@section('title', 'Nos Projets Réalisés | Portfolio Chantiers Flycom Services')

@section('content')
<!-- SECTION HERO PORTFOLIO -->
<section id="portfolio-hero" class="hero-section d-flex align-items-center position-relative overflow-hidden">
    <div class="network-particles"></div>
    <div class="container py-4 py-md-5 z-2 position-relative text-center">
        
        <!-- Badge unifié (Identique à celui de vos captures d'écran) -->
        <div class="custom-badge-pill mb-3">
            <span class="badge-dot"></span>
            <span>NOTRE SAVOIR-FAIRE</span>
        </div>
        
        <h1 class="display-main-heading fw-extrabold text-white mb-3">Projets <span class="text-cyan text-decor-slash">réalisés</span></h1>
        <p class="lead text-light-muted max-w-md mx-auto fs-7 mb-4 px-2">
            Découvrez nos chantiers les plus récents à travers le Congo. Chaque réalisation témoigne de notre rigueur et de notre expertise technique de pointe.
        </p>
    </div>
    
    <!-- Wave Divider : Hero (Sombre) -> Contenu (Clair) -->
    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,32L60,42.7C120,53,240,75,360,80C480,85,600,75,720,64C840,53,960,43,1080,48C1200,53,1320,75,1380,85.3L1440,96L1440,120L1380,120C1320,120,1200,120,1080,120C960,120,840,120,720,120C600,120,480,120,360,120C240,120,120,120,60,120L0,120Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- SECTION PRINCIPALE PORTFOLIO (Dégagement augmenté anti-tassement) -->
<section class="portfolio-main-section bg-white text-navy position-relative">
    <div class="container py-2">
        
        <!-- Filtres Thématiques / Catégories -->
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
            <button class="btn portfolio-filter-btn active" data-filter="all">Tous</button>
            <button class="btn portfolio-filter-btn" data-filter="securite">Sécurité</button>
            <button class="btn portfolio-filter-btn" data-filter="reseau">Réseau</button>
            <button class="btn portfolio-filter-btn" data-filter="energie">Énergie</button>
            <button class="btn portfolio-filter-btn" data-filter="climatisation">Climatisation</button>
            <button class="btn portfolio-filter-btn" data-filter="location">Location &amp; Événements</button>
        </div>

        <!-- Compteur de résultats dynamique -->
        <div class="text-center mb-4">
            <span class="fs-8 text-muted fw-semibold" id="portfolioResultsCount">10 projets affichés</span>
        </div>

        <!-- Grille de Galerie de 10 Projets -->
        <div class="row g-4">
            
            <!-- Projet 1 : Vidéosurveillance -->
            <div class="col-12 col-md-6 col-lg-4 portfolio-item" data-category="securite">
                <div class="card portfolio-card border-light shadow-sm rounded-4 h-100">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=600&q=80" class="card-img-top object-fit-cover" style="height:220px;" alt="Vidéosurveillance">
                    </div>
                    <div class="card-body p-4">
                        <span class="text-cyan fw-bold fs-9 text-uppercase tracking-wider">Sécurité active</span>
                        <h3 class="h6 fw-bold text-navy mt-1 mb-2">Système de vidéosurveillance — Complexe immobilier Mfinda</h3>
                        <p class="fs-8 text-muted mb-0">Déploiement de 32 caméras dômes IP intelligentes avec supervision centralisée pour une résidence fermée de Brazzaville.</p>
                    </div>
                </div>
            </div>

            <!-- Projet 2 : Réseau Banque -->
            <div class="col-12 col-md-6 col-lg-4 portfolio-item" data-category="reseau">
                <div class="card portfolio-card border-light shadow-sm rounded-4 h-100">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=600&q=80" class="card-img-top object-fit-cover" style="height:220px;" alt="Réseau">
                    </div>
                    <div class="card-body p-4">
                        <span class="text-cyan fw-bold fs-9 text-uppercase tracking-wider">Réseau d'Entreprise</span>
                        <h3 class="h6 fw-bold text-navy mt-1 mb-2">Infrastructure réseau — Banque commerciale</h3>
                        <p class="fs-8 text-muted mb-0">Baies de brassage structurées, pose de câbles blindés de catégorie 7 et mise en service de switchs de cœur de réseau.</p>
                    </div>
                </div>
            </div>

            <!-- Projet 3 : Solaire Clinique -->
            <div class="col-12 col-md-6 col-lg-4 portfolio-item" data-category="energie">
                <div class="card portfolio-card border-light shadow-sm rounded-4 h-100">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=600&q=80" class="card-img-top object-fit-cover" style="height:220px;" alt="Solaire">
                    </div>
                    <div class="card-body p-4">
                        <span class="text-cyan fw-bold fs-9 text-uppercase tracking-wider">Énergie</span>
                        <h3 class="h6 fw-bold text-navy mt-1 mb-2">Installation solaire — Clinique médicale</h3>
                        <p class="fs-8 text-muted mb-0">Garantie d'alimentation ininterrompue de blocs opératoires grâce à un kit photovoltaïque hybride avec batteries lithium.</p>
                    </div>
                </div>
            </div>

            <!-- Projet 4 : Contrôle d'Accès -->
            <div class="col-12 col-md-6 col-lg-4 portfolio-item" data-category="securite">
                <div class="card portfolio-card border-light shadow-sm rounded-4 h-100">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=600&q=80" class="card-img-top object-fit-cover" style="height:220px;" alt="Accès">
                    </div>
                    <div class="card-body p-4">
                        <span class="text-cyan fw-bold fs-9 text-uppercase tracking-wider">Sécurité active</span>
                        <h3 class="h6 fw-bold text-navy mt-1 mb-2">Contrôle d'accès — Siège social pétrolier</h3>
                        <p class="fs-8 text-muted mb-0">Sécurisation des zones sensibles par lecteurs biométriques d'empreintes, digicodes et portillons de passage rapides.</p>
                    </div>
                </div>
            </div>

            <!-- Projet 5 : Climatisation VRV -->
            <div class="col-12 col-md-6 col-lg-4 portfolio-item" data-category="climatisation">
                <div class="card portfolio-card border-light shadow-sm rounded-4 h-100">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&w=600&q=80" class="card-img-top object-fit-cover" style="height:220px;" alt="Climatisation">
                    </div>
                    <div class="card-body p-4">
                        <span class="text-cyan fw-bold fs-9 text-uppercase tracking-wider">Climatisation</span>
                        <h3 class="h6 fw-bold text-navy mt-1 mb-2">Climatisation VRV — Centre commercial</h3>
                        <p class="fs-8 text-muted mb-0">Implantation de blocs de climatisation à débit de réfrigérant variable pour assurer une régulation thermique optimisée.</p>
                    </div>
                </div>
            </div>

            <!-- Projet 6 : Barbelé Électrique -->
            <div class="col-12 col-md-6 col-lg-4 portfolio-item" data-category="securite">
                <div class="card portfolio-card border-light shadow-sm rounded-4 h-100">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1508873535684-277a3cbcc4e8?auto=format&fit=crop&w=600&q=80" class="card-img-top object-fit-cover" style="height:220px;" alt="Barbelé">
                    </div>
                    <div class="card-body p-4">
                        <span class="text-cyan fw-bold fs-9 text-uppercase tracking-wider">Sécurité active</span>
                        <h3 class="h6 fw-bold text-navy mt-1 mb-2">Barbelé électrique — Usine textile</h3>
                        <p class="fs-8 text-muted mb-0">Installation périmétrique haute tension homologuée avec avertisseurs et intégration d'une alarme sur sirène d'usine.</p>
                    </div>
                </div>
            </div>

            <!-- Projet 7 : Sonorisation Événement -->
            <div class="col-12 col-md-6 col-lg-4 portfolio-item" data-category="location">
                <div class="card portfolio-card border-light shadow-sm rounded-4 h-100">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=600&q=80" class="card-img-top object-fit-cover" style="height:220px;" alt="Sonorisation">
                    </div>
                    <div class="card-body p-4">
                        <span class="text-cyan fw-bold fs-9 text-uppercase tracking-wider">Location &amp; Événements</span>
                        <h3 class="h6 fw-bold text-navy mt-1 mb-2">Sonorisation — Festival Musique du Congo</h3>
                        <p class="fs-8 text-muted mb-0">Mise à disposition et exploitation de ponts de sonorisation suspendus et régie numérique complète.</p>
                    </div>
                </div>
            </div>

            <!-- Projet 8 : Flotte Véhicules -->
            <div class="col-12 col-md-6 col-lg-4 portfolio-item" data-category="location">
                <div class="card portfolio-card border-light shadow-sm rounded-4 h-100">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=600&q=80" class="card-img-top object-fit-cover" style="height:220px;" alt="Véhicules">
                    </div>
                    <div class="card-body p-4">
                        <span class="text-cyan fw-bold fs-9 text-uppercase tracking-wider">Location &amp; Événements</span>
                        <h3 class="h6 fw-bold text-navy mt-1 mb-2">Flotte véhicules — Mission diplomatique</h3>
                        <p class="fs-8 text-muted mb-0">Mise à disposition d'une escorte de SUV 4x4 robustes d'intervention tout-terrain à Oyo pour visites d'État.</p>
                    </div>
                </div>
            </div>

            <!-- Projet 9 : Solaire Résidentiel -->
            <div class="col-12 col-md-6 col-lg-4 portfolio-item" data-category="energie">
                <div class="card portfolio-card border-light shadow-sm rounded-4 h-100">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1508514177221-188b1cf16e9d?auto=format&fit=crop&w=600&q=80" class="card-img-top object-fit-cover" style="height:220px;" alt="Solaire Maison">
                    </div>
                    <div class="card-body p-4">
                        <span class="text-cyan fw-bold fs-9 text-uppercase tracking-wider">Énergie</span>
                        <h3 class="h6 fw-bold text-navy mt-1 mb-2">Système solaire — Villa résidentielle</h3>
                        <p class="fs-8 text-muted mb-0">Ingénierie photovoltaïque complète pour rendre autonome en électricité une grande villa de La Glacière.</p>
                    </div>
                </div>
            </div>

            <!-- Projet 10 : Wi-Fi Universitaire -->
            <div class="col-12 col-md-6 col-lg-4 portfolio-item" data-category="reseau">
                <div class="card portfolio-card border-light shadow-sm rounded-4 h-100">
                    <div class="card-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1616401784845-180882ba9ba8?auto=format&fit=crop&w=600&q=80" class="card-img-top object-fit-cover" style="height:220px;" alt="Wi-Fi">
                    </div>
                    <div class="card-body p-4">
                        <span class="text-cyan fw-bold fs-9 text-uppercase tracking-wider">Réseau d'Entreprise</span>
                        <h3 class="h6 fw-bold text-navy mt-1 mb-2">Wi-Fi entreprise — Université privée</h3>
                        <p class="fs-8 text-muted mb-0">Implantation de bornes Wi-Fi d'extérieur à haute densité d'accès pour couvrir l'ensemble du campus.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Séparateur de vague créatif de transition Contenu (Clair) -> Footer (Sombre) -->
    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" fill="#050E2D"></path>
        </svg>
    </div>
</section>
@endsection