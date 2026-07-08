@extends('layouts.public')

@section('title', 'Accueil | Flycom Services - Solutions Technologiques au Congo')

<!-- Injection du Schéma LocalBusiness (SEO - Module M6) -->
@section('json_ld')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "LocalBusiness",
  "name": "Flycom Services",
  "image": "https://flycomservices.cg/assets/images/logo.png",
  "@@id": "https://flycomservices.cg/#localbusiness",
  "url": "https://flycomservices.cg",
  "telephone": "+242066285741",
  "address": {
    "@@type": "PostalAddress",
    "streetAddress": "22, Avenue de Brazza — La Glacière",
    "addressLocality": "Brazzaville",
    "addressCountry": "CG"
  },
  "geo": {
    "@@type": "GeoCoordinates",
    "latitude": "-4.2634",
    "longitude": "15.2832"
  }
}
</script>
@endsection

@section('content')

<!-- ========================================== -->
<!-- SECTION HERO (Corrigée et isolée)         -->
<!-- ========================================== -->
<section id="hero" class="hero-section d-flex align-items-center position-relative overflow-hidden">
    <div class="network-particles"></div>
    <div class="container py-4 py-md-5 z-2 position-relative">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-12 col-lg-7 text-center text-lg-start">
                <!-- Badge de gauche corrigé par emboîtement -->
                <div class="hero-load-animate" style="animation-delay: 0.1s;">
                    <div class="badge-accent mb-4 d-inline-flex align-items-center gap-2 float-element">
                        <span class="dot-blink"></span>
                        <span>Solutions technologiques au Congo</span>
                    </div>
                </div>
                
                <h1 class="display-main-heading fw-extrabold text-white mb-3 hero-load-animate" style="animation-delay: 0.3s; line-height: 1.15;">
                    Des solutions pour <br>
                    <span class="text-cyan text-decor-slash">sécuriser</span> / 
                    <span class="text-cyan-muted text-decor-slash">connecter</span> / <br>
                    <span class="text-white-80">optimiser</span> votre monde
                </h1>
                <p class="lead text-light-muted mb-4 fs-7 hero-load-animate" style="animation-delay: 0.5s;">
                    Flycom Services accompagne particuliers et entreprises à Brazzaville avec des solutions sur mesure en sécurité, énergie et technologies.
                </p>
                <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3 hero-load-animate" style="animation-delay: 0.7s;">
                    <a href="{{ route('services') }}" class="btn btn-cyan btn-lg rounded-pill px-4 py-3 fw-bold fs-7 text-decoration-none hover-glow" style="background-color:#00D2F4; border:none; color:#050E2D;">
                        Découvrir nos services 
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light-custom btn-lg rounded-pill px-4 py-3 fw-bold fs-7 text-decoration-none hover-lift">
                        Demander un devis
                    </a>
                </div>
            </div>
            
            <!-- Image de droite corrigée par emboîtement (Résout la disparition du visuel) -->
            <div class="col-12 col-lg-5 d-none d-lg-block hero-load-animate" style="animation-delay: 0.4s;">
                <div class="hero-image-overlay rounded-4 shadow-lg overflow-hidden border border-navy-light float-element" style="animation-delay: 0.5s;">
                    <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=800&q=80" alt="Supervision technologique" class="img-fluid hero-img">
                    <div class="overlay-dark-blue"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- BANDEAU D'ICÔNES SERVICES DÉFILANT (Marquee infini) -->
<!-- ========================================== -->
<section class="icon-ribbon py-4 border-top border-bottom border-navy-light position-relative z-3" style="background: rgba(5, 14, 45, 0.8);">
    <div class="marquee-wrapper">
        <div class="marquee-content">
            <div class="ribbon-item"><i class="bi bi-camera-video text-cyan"></i> Télésurveillance</div>
            <div class="ribbon-item"><i class="bi bi-sun text-cyan"></i> Énergie Solaire</div>
            <div class="ribbon-item"><i class="bi bi-wind text-cyan"></i> Climatisation</div>
            <div class="ribbon-item"><i class="bi bi-car-front text-cyan"></i> Location Auto</div>
            <div class="ribbon-item"><i class="bi bi-volume-up text-cyan"></i> Sonorisation</div>
            <div class="ribbon-item"><i class="bi bi-fingerprint text-cyan"></i> Contrôle Accès</div>
            <div class="ribbon-item"><i class="bi bi-lightning-charge text-cyan"></i> Barbelé Électrique</div>
            <div class="ribbon-item"><i class="bi bi-tools text-cyan"></i> Maintenance</div>
            <div class="ribbon-item"><i class="bi bi-shield-lock text-cyan"></i> Securité</div>
        </div>
        <div class="marquee-content" aria-hidden="true">
            <div class="ribbon-item"><i class="bi bi-camera-video text-cyan"></i> Télésurveillance</div>
            <div class="ribbon-item"><i class="bi bi-sun text-cyan"></i> Énergie Solaire</div>
            <div class="ribbon-item"><i class="bi bi-wind text-cyan"></i> Climatisation</div>
            <div class="ribbon-item"><i class="bi bi-car-front text-cyan"></i> Location Auto</div>
            <div class="ribbon-item"><i class="bi bi-volume-up text-cyan"></i> Sonorisation</div>
            <div class="ribbon-item"><i class="bi bi-fingerprint text-cyan"></i> Contrôle Accès</div>
            <div class="ribbon-item"><i class="bi bi-lightning-charge text-cyan"></i> Barbelé Électrique</div>
            <div class="ribbon-item"><i class="bi bi-tools text-cyan"></i> Maintenance</div>
            <div class="ribbon-item"><i class="bi bi-shield-lock text-cyan"></i> Securité</div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- SECTION CHIFFRES AVEC COMPTEURS INTERACTIFS -->
<!-- ========================================== -->
<section class="stats-section py-5 text-white position-relative scroll-trigger-counters" style="background-color: #030a21;">
    <div class="network-particles"></div>
    <div class="container py-lg-5 text-center position-relative z-2">
        <span class="text-cyan fw-bold text-uppercase tracking-wider fs-8 d-block mb-2 animate-scroll-fade">Nos chiffres</span>
        <h2 class="h2 fw-extrabold mb-5 animate-scroll-fade">Des résultats qui <span class="text-cyan">parlent</span></h2>
        
        <div class="row g-4 justify-content-center">
            <div class="col-6 col-md-3 animate-scroll-fade stagger-item">
                <div class="stat-card p-4 rounded-4 h-100">
                    <div class="stat-number text-cyan"><span class="counter-value" data-target="10">0</span>+</div>
                    <h3 class="h6 fw-bold text-white mb-2 fs-7">Années d'expérience</h3>
                    <p class="fs-8 text-light-muted mb-0">Au service du Congo</p>
                </div>
            </div>
            <div class="col-6 col-md-3 animate-scroll-fade stagger-item">
                <div class="stat-card p-4 rounded-4 h-100">
                    <div class="stat-number text-cyan"><span class="counter-value" data-target="500">0</span>+</div>
                    <h3 class="h6 fw-bold text-white mb-2 fs-7">Clients satisfaits</h3>
                    <p class="fs-8 text-light-muted mb-0">Fidélisés et accompagnés</p>
                </div>
            </div>
            <div class="col-6 col-md-3 animate-scroll-fade stagger-item">
                <div class="stat-card p-4 rounded-4 h-100">
                    <div class="stat-number text-cyan"><span class="counter-value" data-target="8">0</span></div>
                    <h3 class="h6 fw-bold text-white mb-2 fs-7">Domaines experts</h3>
                    <p class="fs-8 text-light-muted mb-0">De la sécurité à l'énergie</p>
                </div>
            </div>
            <div class="col-6 col-md-3 animate-scroll-fade stagger-item">
                <div class="stat-card p-4 rounded-4 h-100">
                    <div class="stat-number text-cyan"><span class="counter-value" data-target="50">0</span>+</div>
                    <h3 class="h6 fw-bold text-white mb-2 fs-7">Projets réalisés</h3>
                    <p class="fs-8 text-light-muted mb-0">Audits et installations</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,32L60,42.7C120,53,240,75,360,80C480,85,600,75,720,64C840,53,960,43,1080,48C1200,53,1320,75,1380,85.3L1440,96L1440,120L1380,120C1320,120,1200,120,1080,120C960,120,840,120,720,120C600,120,480,120,360,120C240,120,120,120,60,120L0,120Z" fill="#f0f6fc"></path>
        </svg>
    </div>
</section>

<!-- ========================================== -->
<!-- SECTION BENTO GRID DE SERVICES             -->
<!-- ========================================== -->
<section id="services" class="services-bento py-5 bg-ice-blue position-relative">
    <div class="container py-lg-4 position-relative z-2">
        <div class="d-flex justify-content-between align-items-end mb-4 animate-scroll-fade">
            <div>
                <span class="text-muted tracking-widest fs-8 text-uppercase">Flycom / Services</span>
                <h2 class="h3 fw-extrabold text-navy mt-1">Une gamme complète de <br>solutions <span class="text-cyan">technologiques</span></h2>
            </div>
            <a href="{{ route('services') }}" class="text-navy fw-semibold text-decoration-none fs-7 hover-cyan d-none d-md-block">
                Voir tous les services <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="bento-grid">
            <!-- Bento 1 -->
            <div class="bento-card bento-1 animate-scroll-fade stagger-item" style="background-image: url('https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=800&q=80');">
                <div class="bento-overlay"></div>
                <div class="bento-content">
                    <span class="badge-bento-price">Sur devis</span>
                    <h3 class="h5 fw-bold text-white mb-2">Réseaux Informatiques</h3>
                    <p class="fs-8 text-light-muted mb-0">Câblage structuré et routeurs de performance.</p>
                </div>
            </div>

            <!-- Bento 2 -->
            <div class="bento-card bento-2 animate-scroll-fade stagger-item" style="background-image: url('https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=800&q=80');">
                <div class="bento-overlay"></div>
                <div class="bento-content">
                    <span class="badge-bento-price">À partir de 150k F</span>
                    <h3 class="h6 fw-bold text-white mb-2">Vidéosurveillance</h3>
                    <p class="fs-8 text-light-muted mb-0">Caméras HD intelligentes avec vision nocturne active.</p>
                </div>
            </div>

            <!-- Bento 3 -->
            <div class="bento-card bento-3 animate-scroll-fade stagger-item" style="background-image: url('https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=800&q=80');">
                <div class="bento-overlay"></div>
                <div class="bento-content">
                    <span class="badge-bento-price">À partir de 250k F</span>
                    <h3 class="h6 fw-bold text-white mb-2">Contrôle d'accès</h3>
                    <p class="fs-8 text-light-muted mb-0">Serrures biométriques d'accès aux locaux.</p>
                </div>
            </div>

            <!-- Bento 4 -->
            <div class="bento-card bento-4 animate-scroll-fade stagger-item" style="background-image: url('https://images.unsplash.com/photo-1508873535684-277a3cbcc4e8?auto=format&fit=crop&w=800&q=80');">
                <div class="bento-overlay"></div>
                <div class="bento-content">
                    <span class="badge-bento-price">Sur devis</span>
                    <h3 class="h6 fw-bold text-white mb-2">Barbelé Électrique</h3>
                    <p class="fs-8 text-light-muted mb-0">Dissuasion électrique périmétrique homologuée.</p>
                </div>
            </div>

            <!-- Bento 5 -->
            <div class="bento-card bento-5 animate-scroll-fade stagger-item" style="background-image: url('https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=800&q=80');">
                <div class="bento-overlay"></div>
                <div class="bento-content">
                    <span class="badge-bento-price">À partir de 950k F</span>
                    <h3 class="h6 fw-bold text-white mb-2">Panneaux Solaires</h3>
                    <p class="fs-8 text-light-muted mb-0">Autonomie électrique complète avec stockage lithium.</p>
                </div>
            </div>

            <!-- Bento 6 -->
            <div class="bento-card bento-6 animate-scroll-fade stagger-item" style="background-image: url('https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&w=800&q=80');">
                <div class="bento-overlay"></div>
                <div class="bento-content">
                    <span class="badge-bento-price">À partir de 80k F</span>
                    <h3 class="h6 fw-bold text-white mb-2">Climatisation</h3>
                    <p class="fs-8 text-light-muted mb-0">Régulation de température pour l'été congolais.</p>
                </div>
            </div>

            <!-- Bento 7 -->
            <div class="bento-card bento-7 animate-scroll-fade stagger-item" style="background-image: url('https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=80');">
                <div class="bento-overlay"></div>
                <div class="bento-content">
                    <span class="badge-bento-price">À partir de 35k F/j</span>
                    <h3 class="h6 fw-bold text-white mb-2">Location Auto</h3>
                    <p class="fs-8 text-light-muted mb-0">Flotte de berlines et SUV 4x4 de direction.</p>
                </div>
            </div>

            <!-- Bento 8 -->
            <div class="bento-card bento-8 animate-scroll-fade stagger-item" style="background-image: url('https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=800&q=80');">
                <div class="bento-overlay"></div>
                <div class="bento-content">
                    <span class="badge-bento-price">À partir de 50k F/j</span>
                    <h3 class="h6 fw-bold text-white mb-2">Location Sonorisation</h3>
                    <p class="fs-8 text-light-muted mb-0">Régie acoustique complète pour événements.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- ========================================== -->
<!-- SECTION À PROPOS                           -->
<!-- ========================================== -->
<section id="about" class="about-section py-5 bg-white position-relative">
    <div class="container py-lg-5 position-relative z-2">
        <div class="row align-items-center g-5">
            <div class="col-12 col-lg-6 animate-scroll-fade slide-left">
                <div class="about-image-wrapper position-relative float-element" style="animation-delay: 0.1s;">
                    <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=800&q=80" alt="Technicien qualifié" class="img-fluid rounded-4 shadow-sm w-100">
                    <div class="badge-experience bg-navy text-white rounded-3 p-3 position-absolute bottom-0 start-0 m-3 border border-navy-light shadow-lg">
                        <span class="d-block fw-extrabold fs-4 lh-1 text-cyan">+10 ans</span>
                        <span class="fs-9 text-light-muted">d'Expertise au Congo</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 animate-scroll-fade slide-right">
                <span class="text-cyan fw-bold text-uppercase tracking-wider fs-8 d-block mb-2">À PROPOS</span>
                <h2 class="h2 fw-extrabold text-navy mb-4">Votre Partenaire <span class="text-cyan">Technologique</span> de Confiance</h2>
                <p class="text-muted mb-3 fs-7">
                    Flycom Services est une entreprise multiservices établie au cœur de <strong>Brazzaville, au 22, Avenue de Brazza — La Glacière</strong>. Fondée sur des valeurs de rigueur, de compétence et de proximité client, elle accompagne les congolais dans leur transformation technologique.
                </p>
                <p class="text-muted mb-4 fs-7">
                    Notre équipe d'experts hautement qualifiés intervient sur l'ensemble du territoire national pour sécuriser, connecter et pérenniser vos structures.
                </p>
                
                <div class="row g-2 mb-4">
                    <div class="col-6"><span class="pill-badge w-100 hover-lift"><i class="bi bi-patch-check-fill text-cyan"></i> Expertise certifiée</span></div>
                    <div class="col-6"><span class="pill-badge w-100 hover-lift"><i class="bi bi-patch-check-fill text-cyan"></i> SAV réactif</span></div>
                    <div class="col-6"><span class="pill-badge w-100 hover-lift"><i class="bi bi-patch-check-fill text-cyan"></i> Solutions sur mesure</span></div>
                    <div class="col-6"><span class="pill-badge w-100 hover-lift"><i class="bi bi-patch-check-fill text-cyan"></i> Prix compétitifs</span></div>
                </div>

                <a href="{{ route('about') }}" class="btn btn-navy-dark rounded-pill px-4 py-3 fw-bold text-white text-decoration-none fs-7 d-inline-block hover-lift">
                    Découvrir notre histoire
                </a>
            </div>
        </div>
    </div>

    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,48L80,53.3C160,58,320,69,480,64C640,59,800,37,960,32C1120,27,1280,37,1360,42.7L1440,48L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" fill="#050E2D"></path>
        </svg>
    </div>
</section>

<!-- ========================================== -->
<!-- SECTION CE QUI NOUS DISTINGUE (Timeline)   -->
<!-- ========================================== -->
<section id="distinction" class="distinction-section py-5 text-white position-relative">
    <div class="network-particles"></div>
    <div class="container py-lg-5 position-relative z-2">
        <div class="text-center mb-5 animate-scroll-fade">
            <span class="text-cyan-muted fw-bold text-uppercase tracking-wider fs-8 d-block mb-1">POURQUOI NOUS</span>
            <h2 class="h2 fw-extrabold">Ce Qui Nous <span class="text-cyan">Distingue</span></h2>
        </div>

        <div class="timeline-vertical position-relative py-4">
            <div class="timeline-v-line"></div>

            <!-- Étape 1 -->
            <div class="timeline-v-item left-item animate-scroll-fade slide-left">
                <div class="timeline-v-badge">
                    <i class="bi bi-layers"></i>
                </div>
                <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                    <span class="v-card-watermark">01</span>
                    <h3 class="h6 fw-bold text-white mb-2">Expertise Multidisciplinaire</h3>
                    <p class="fs-8 text-light-muted mb-0">Une seule entreprise pour tous vos besoins technologiques : réseau, sécurité, climatisation et énergie solaire.</p>
                </div>
            </div>

            <!-- Étape 2 -->
            <div class="timeline-v-item right-item animate-scroll-fade slide-right">
                <div class="timeline-v-badge">
                    <i class="bi bi-stopwatch"></i>
                </div>
                <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                    <span class="v-card-watermark">02</span>
                    <h3 class="h6 fw-bold text-white mb-2">Intervention ultra-rapide</h3>
                    <p class="fs-8 text-light-muted mb-0">Équipes de techniciens mobiles de garde réactives sur l'ensemble du périmètre urbain de Brazzaville.</p>
                </div>
            </div>

            <!-- Étape 3 -->
            <div class="timeline-v-item left-item animate-scroll-fade slide-left">
                <div class="timeline-v-badge">
                    <i class="bi bi-patch-check"></i>
                </div>
                <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                    <span class="v-card-watermark">03</span>
                    <h3 class="h6 fw-bold text-white mb-2">Garantie Matériel Officiel</h3>
                    <p class="fs-8 text-light-muted mb-0">Utilisation exclusive d'équipements de marques internationales certifiées avec garanties constructeurs.</p>
                </div>
            </div>

            <!-- Étape 4 -->
            <div class="timeline-v-item right-item animate-scroll-fade slide-right">
                <div class="timeline-v-badge">
                    <i class="bi bi-wrench"></i>
                </div>
                <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                    <span class="v-card-watermark">04</span>
                    <h3 class="h6 fw-bold text-white mb-2">Suivi &amp; Contrats d'Assistance</h3>
                    <p class="fs-8 text-light-muted mb-0">Formules d'accompagnement annuelles de maintenance préventive pour éviter les pannes.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,74.7C160,85,320,107,480,101.3C640,96,800,64,960,53.3C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" fill="#f0f6fc"></path>
        </svg>
    </div>
</section>

<!-- ========================================== -->
<!-- SECTION PROCESS (Comment ça marche ?)      -->
<!-- ========================================== -->
<section class="process-section py-5 bg-ice-blue position-relative">
    <div class="container py-lg-5 text-center position-relative z-2">
        <span class="text-cyan fw-bold text-uppercase tracking-wider fs-8 d-block mb-2 animate-scroll-fade">PROCESSUS</span>
        <h2 class="h2 fw-extrabold text-navy mb-5 animate-scroll-fade">Comment ça <span class="text-cyan">marche</span> ?</h2>

        <div class="row g-4 timeline-row position-relative justify-content-center">
            <div class="timeline-line d-none d-md-block"></div>
            
            <!-- Étape 1 -->
            <div class="col-12 col-md-4 timeline-step animate-scroll-fade stagger-item">
                <div class="icon-circle mb-4 bg-navy-dark text-white mx-auto position-relative hover-spin">
                    <span class="step-watermark">01</span>
                    <i class="bi bi-chat-dots fs-4"></i>
                </div>
                <div class="process-card p-4 rounded-4 shadow-sm bg-white border border-light">
                    <h3 class="h6 fw-bold text-navy mb-3">Prise de contact</h3>
                    <p class="fs-8 text-muted mb-0">Formulez votre demande en ligne ou par téléphone. Un expert qualifié vous recontacte en moins de 30 minutes.</p>
                </div>
            </div>

            <!-- Étape 2 -->
            <div class="col-12 col-md-4 timeline-step animate-scroll-fade stagger-item">
                <div class="icon-circle mb-4 bg-navy-dark text-white mx-auto position-relative hover-spin">
                    <span class="step-watermark">02</span>
                    <i class="bi bi-search fs-4"></i>
                </div>
                <div class="process-card p-4 rounded-4 shadow-sm bg-white border border-light">
                    <h3 class="h6 fw-bold text-navy mb-3">Audit gratuit de terrain</h3>
                    <p class="fs-8 text-muted mb-0">Nos ingénieurs se déplacent chez vous pour analyser vos infrastructures et vous dresser un devis sur mesure.</p>
                </div>
            </div>

            <!-- Étape 3 -->
            <div class="col-12 col-md-4 timeline-step animate-scroll-fade stagger-item">
                <div class="icon-circle mb-4 bg-navy-dark text-white mx-auto position-relative hover-spin">
                    <span class="step-watermark">03</span>
                    <i class="bi bi-tools fs-4"></i>
                </div>
                <div class="process-card p-4 rounded-4 shadow-sm bg-white border border-light">
                    <h3 class="h6 fw-bold text-navy mb-3">Déploiement certifié</h3>
                    <p class="fs-8 text-muted mb-0">Nos techniciens installent votre équipement avec minutie, réalisent les tests et forment vos équipes à l'utilisation.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,32L60,42.7C120,53,240,75,360,80C480,85,600,75,720,64C840,53,960,43,1080,48C1200,53,1320,75,1380,85.3L1440,96L1440,120L1380,120C1320,120,1200,120,1080,120C960,120,840,120,720,120C600,120,480,120,360,120C240,120,120,120,60,120L0,120Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- ========================================== -->
<!-- SECTION PORTFOLIO                          -->
<!-- ========================================== -->
<section id="portfolio" class="portfolio-section py-5 bg-white position-relative">
    <div class="container py-lg-4 position-relative z-2">
        <span class="text-cyan fw-bold text-uppercase tracking-wider fs-8 d-block mb-2 text-center text-md-start animate-scroll-fade">RÉALISATIONS</span>
        <h2 class="h2 fw-extrabold text-navy mb-4 text-center text-md-start animate-scroll-fade">Nos Projets en <span class="text-cyan">Images</span></h2>

        <div class="portfolio-grid">
            <div class="port-item port-1 rounded-4 overflow-hidden position-relative animate-scroll-fade stagger-item">
                <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=800&q=80" alt="Serveurs réseaux" class="img-fluid w-100 h-100 object-fit-cover">
                <div class="port-caption">Réseaux d'Entreprise</div>
            </div>
            <div class="port-item port-2 rounded-4 overflow-hidden position-relative animate-scroll-fade stagger-item">
                <img src="https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=800&q=80" alt="Panneau Solaire" class="img-fluid w-100 h-100 object-fit-cover">
                <div class="port-caption">Installation Énergie Solaire</div>
            </div>
            <div class="port-item port-3 rounded-4 overflow-hidden position-relative animate-scroll-fade stagger-item">
                <img src="https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=800&q=80" alt="Caméra dôme extérieure" class="img-fluid w-100 h-100 object-fit-cover">
                <div class="port-caption">Surveillance Périmétrique</div>
            </div>
            <div class="port-item port-4 rounded-4 overflow-hidden position-relative animate-scroll-fade stagger-item">
                <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&w=800&q=80" alt="Maintenance Climatisation" class="img-fluid w-100 h-100 object-fit-cover">
                <div class="port-caption">Maintenance Climatisation</div>
            </div>
            <div class="port-item port-5 rounded-4 overflow-hidden position-relative animate-scroll-fade stagger-item">
                <img src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=800&q=80" alt="Régie de sonorisation" class="img-fluid w-100 h-100 object-fit-cover">
                <div class="port-caption">Sonorisation d'Événements</div>
            </div>
        </div>
    </div>

    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" fill="#050E2D"></path>
        </svg>
    </div>
</section>

<!-- ========================================== -->
<!-- SECTION TÉMOIGNAGES (Carrousel actif)     -->
<!-- ========================================== -->
<section class="testimonials-section py-5 text-white position-relative overflow-hidden">
    <div class="network-particles"></div>
    <div class="container py-lg-5 text-center position-relative z-2">
        <h2 class="h2 fw-extrabold mb-5 animate-scroll-fade">Ils nous font <span class="text-cyan">confiance</span></h2>

        <div class="testimonials-track-wrapper mx-auto animate-scroll-fade">
            <div class="testimonials-track d-flex gap-4">
                
                <!-- Témoignage 1 -->
                <div class="testi-card p-4 rounded-4 border text-start testimonial-slide active" style="transition: all 0.5s ease;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="testi-rating-badge">
                            <i class="bi bi-star-fill text-warning"></i> 5.0
                        </span>
                        <span class="text-muted fs-8">Brazzaville</span>
                    </div>
                    <p class="testimonial-quote-text fs-8 text-white-50 leading-relaxed mb-4">
                        <span class="text-cyan fs-3 d-inline-block lh-1 vertical-align-middle me-1">“</span>La mise en place de nos serveurs d'entreprise a été gérée avec brio. Nous avons maintenant une infrastructure robuste et parfaitement dimensionnée.<span class="text-cyan fs-3 d-inline-block lh-1 vertical-align-middle ms-1">”</span>
                    </p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-circle rounded-circle overflow-hidden bg-cyan border-0" style="width:42px; height:42px;">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&h=150&q=80" alt="Patrick Okemba" class="img-fluid w-100 h-100 object-fit-cover">
                        </div>
                        <div>
                            <h4 class="h7 fw-bold mb-0 text-white-50" style="font-size:0.85rem;">Patrick Okemba</h4>
                            <small class="text-muted fs-9">Directeur Technique, Congo Tech</small>
                        </div>
                    </div>
                </div>

                <!-- Témoignage 2 -->
                <div class="testi-card p-4 p-md-5 rounded-4 border text-start testimonial-slide" style="transition: all 0.5s ease;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="testi-rating-badge">
                            <i class="bi bi-star-fill text-warning"></i> 5.0
                        </span>
                        <span class="text-muted fs-8">Brazzaville</span>
                    </div>
                    <p class="testimonial-quote-text fs-7 text-white-80 leading-relaxed mb-4">
                        <span class="text-cyan fs-2 d-inline-block lh-1 vertical-align-middle me-1">“</span>Les panneaux solaires installés par Flycom nous permettent d'économiser 60% sur notre facture d'électricité. Installation rapide, propre et conforme. Merci à toute l'équipe !<span class="text-cyan fs-2 d-inline-block lh-1 vertical-align-middle ms-1">”</span>
                    </p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-circle rounded-circle overflow-hidden bg-cyan border-0" style="width:42px; height:42px;">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=150&h=150&q=80" alt="Aminata Diallo" class="img-fluid w-100 h-100 object-fit-cover">
                        </div>
                        <div>
                            <h4 class="h7 fw-bold mb-0 text-white" style="font-size:0.85rem;">Aminata Diallo</h4>
                            <small class="text-cyan fs-9">Propriétaire, Résidence Les Orchidées</small>
                        </div>
                    </div>
                </div>

                <!-- Témoignage 3 -->
                <div class="testi-card p-4 rounded-4 border text-start testimonial-slide" style="transition: all 0.5s ease;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="testi-rating-badge">
                            <i class="bi bi-star-fill text-warning"></i> 5.0
                        </span>
                        <span class="text-muted fs-8">Brazzaville</span>
                    </div>
                    <p class="testimonial-quote-text fs-8 text-white-50 leading-relaxed mb-4">
                        <span class="text-cyan fs-3 d-inline-block lh-1 vertical-align-middle me-1">“</span>Flycom Services a transformé la sécurité de nos immeubles. Leur équipe a installé un système de vidéosurveillance complet en moins d'une semaine.<span class="text-cyan fs-3 d-inline-block lh-1 vertical-align-middle ms-1">”</span>
                    </p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-circle rounded-circle overflow-hidden bg-cyan border-0" style="width:42px; height:42px;">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&h=150&q=80" alt="Jean-Pierre Mabiala" class="img-fluid w-100 h-100 object-fit-cover">
                        </div>
                        <div>
                            <h4 class="h7 fw-bold mb-0 text-white-50" style="font-size:0.85rem;">Jean-Pierre Mabiala</h4>
                            <small class="text-muted fs-9">Directeur, Société Immobilière Congo</small>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Contrôles -->
            <div class="d-flex justify-content-center align-items-center gap-3 mt-4">
                <button class="slider-btn prev-btn" id="btnTestiPrev" aria-label="Avis Précédent">
                    <i class="bi bi-arrow-left"></i>
                </button>
                <div class="slider-dots d-flex gap-1 align-items-center" id="testiDotsContainer"></div>
                <button class="slider-btn next-btn active-btn" id="btnTestiNext" aria-label="Avis Suivant">
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" fill="#050E2D"></path>
        </svg>
    </div>
</section>

<!-- ========================================== -->
<!-- BANNIÈRE D'APPEL À L'ACTION                -->
<!-- ========================================== -->
<section class="cta-banner-section py-5 bg-cyan text-navy position-relative overflow-hidden">
    <div class="circular-layer circle-left"></div>
    <div class="circular-layer circle-right"></div>

    <div class="container text-center py-lg-4 position-relative z-2 animate-scroll-fade">
        <span class="badge bg-white-transparent rounded-pill px-3 py-2 fs-8 mb-4 d-inline-block">
            • Devis gratuit sous 24h
        </span>
        <h2 class="display-5 fw-extrabold mb-3 leading-tight text-navy">
            Prêt à sécuriser <br class="d-sm-none"> votre environnement ?
        </h2>
        <p class="max-w-md mx-auto fs-7 mb-4 text-navy opacity-80 px-2">
            Contactez-nous dès aujourd'hui pour un diagnostic gratuit et sans engagement. Nos ingénieurs vous répondent sous 30 minutes.
        </p>

        <a href="tel:+242066285741" class="btn btn-navy-dark btn-lg rounded-pill px-5 py-3 fw-bold text-white shadow mb-4 d-inline-block hover-lift">
            Obtenir un devis gratuit 
        </a>

        <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-4 text-navy fw-semibold fs-7 mt-2">
            <span><i class="bi bi-telephone-fill me-2"></i> 06 628 57 41</span>
            <span class="d-none d-sm-inline opacity-30">|</span>
            <span><i class="bi bi-clock-fill me-2"></i> Lun — Sam : 08h00 — 18h00</span>
        </div>
    </div>

    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" fill="#050E2D"></path>
        </svg>
    </div>
</section>

<!-- ========================================== -->
<!-- CENTRALISATION DES ANIMATIONS ET DES HOVERS (MICRO-INTERACTIONS) -->
<!-- ========================================== -->
<style>
/* 1. MOTEUR INTERACTIF DU BANDEAU DÉFILANT INFINI (MARQUEE) */
.marquee-wrapper {
    display: flex;
    overflow: hidden;
    user-select: none;
    gap: 3rem;
    width: 100%;
}
.marquee-content {
    flex-shrink: 0;
    display: flex;
    justify-content: space-around;
    min-width: 100%;
    gap: 3rem;
    animation: scroll-marquee 28s linear infinite;
}
/* Pause douce au survol du bandeau défilant */
.marquee-wrapper:hover .marquee-content {
    animation-play-state: paused;
}
@keyframes scroll-marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(calc(-100% - 3rem)); }
}

/* 2. MOTEUR D'ANIMATIONS D'APPARITION AU DÉFILEMENT (SCROLL OBSERVER) */
.animate-scroll-fade {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.animate-scroll-fade.slide-left {
    transform: translateX(-40px);
}
.animate-scroll-fade.slide-right {
    transform: translateX(40px);
}
.animate-scroll-fade.show {
    opacity: 1 !important;
    transform: translate(0) !important;
}

/* Étalement chronologique des grilles (Staggered Entrance) */
.stagger-item:nth-child(1) { transition-delay: 0.05s; }
.stagger-item:nth-child(2) { transition-delay: 0.12s; }
.stagger-item:nth-child(3) { transition-delay: 0.19s; }
.stagger-item:nth-child(4) { transition-delay: 0.26s; }
.stagger-item:nth-child(5) { transition-delay: 0.33s; }
.stagger-item:nth-child(6) { transition-delay: 0.40s; }
.stagger-item:nth-child(7) { transition-delay: 0.47s; }
.stagger-item:nth-child(8) { transition-delay: 0.54s; }

/* 3. EFFETS D'ÉLÉVATION DYNAMIQUES AU SURVOL (MICRO-INTERACTIONS) */
/* Bento Cards */
.bento-card {
    position: relative;
    overflow: hidden;
    transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.45s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
.bento-card:hover {
    transform: translateY(-10px) scale(1.025) !important;
    box-shadow: 0 30px 60px rgba(0, 210, 244, 0.18) !important;
}
/* Zoom interne fluide de l'arrière-plan du Bento */
.bento-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: inherit;
    background-size: cover;
    background-position: center;
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    z-index: 1;
}
.bento-card:hover::before {
    transform: scale(1.08);
}
.bento-overlay, .bento-content {
    z-index: 2; /* S'assure de surélever les calques sur le zoom */
}

/* Stats Cards (Effet néon et lévitation) */
.stat-card {
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.04);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.3s ease, border-color 0.3s ease;
}
.stat-card:hover {
    transform: translateY(-8px) scale(1.03) !important;
    background: rgba(0, 210, 244, 0.03);
    border-color: rgba(0, 210, 244, 0.25);
    box-shadow: 0 15px 30px rgba(0, 210, 244, 0.08);
}

/* Process Cards & Timeline (Effet de pivotement 3D léger) */
.process-card, .timeline-v-card {
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease !important;
}
.process-card:hover, .timeline-v-card:hover {
    transform: translateY(-8px) rotateX(2deg) rotateY(1deg) !important;
    box-shadow: 0 20px 40px rgba(0, 210, 244, 0.1) !important;
    border-color: rgba(0, 210, 244, 0.25) !important;
}

/* Portfolio grid cards */
.port-item {
    transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.5s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
.port-item img {
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}
.port-item:hover {
    transform: translateY(-6px) !important;
    box-shadow: 0 20px 40px rgba(0, 210, 244, 0.15) !important;
}
.port-item:hover img {
    transform: scale(1.06);
}

/* Testimonials & Team Cards */
.testi-card, .team-card {
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
.testi-card:hover, .team-card:hover {
    transform: translateY(-8px) !important;
    box-shadow: 0 20px 40px rgba(0, 210, 244, 0.12) !important;
}

/* 4. ANIMATIONS DU HERO AU CHARGEMENT DE PAGE (Entrée cinématique) */
.hero-load-animate {
    opacity: 0;
    transform: translateY(22px);
    animation: heroEntrance 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes heroEntrance {
    to { opacity: 1; transform: translateY(0); }
}

/* Mouvement de lévitation flottante continue en arrière-plan */
.float-element {
    animation: floatingContinuous 5s ease-in-out infinite;
}
@keyframes floatingContinuous {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-12px); }
    100% { transform: translateY(0px); }
}

/* Lueur pulsée de l'icône de processus */
.hover-spin:hover i {
    transform: rotate(360deg);
    transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.hover-spin i {
    transition: transform 0.8s ease;
}

/* Interaction douce des boutons (Glow effect) */
.hover-lift {
    transition: transform 0.25s ease, box-shadow 0.25s ease !important;
}
.hover-lift:hover {
    transform: translateY(-3px) !important;
    box-shadow: 0 10px 25px rgba(0, 210, 244, 0.25) !important;
}

/* 5. CARROUSEL DE TÉMOIGNAGES (Slide active) */
.testimonial-slide {
    display: none;
    width: 100%;
}
.testimonial-slide.active {
    display: block;
    animation: slideFadeIn 0.65s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes slideFadeIn {
    from { opacity: 0; transform: translateX(25px); }
    to { opacity: 1; transform: translateX(0); }
}
</style>

<!-- ========================================== -->
<!-- CODE MOTEUR INTERACTIF EN JAVASCRIPT       -->
<!-- ========================================== -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    // ────────────────────────────────────────────────────────────
    // 1. MOTEUR INTERSECTION OBSERVER POUR APPARITION AU SCROLL
    // ────────────────────────────────────────────────────────────
    const scrollObserverOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.08
    };

    const scrollObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                
                if (entry.target.classList.contains('scroll-trigger-counters')) {
                    startStatisticsCounters(entry.target);
                }
                
                observer.unobserve(entry.target);
            }
        });
    }, scrollObserverOptions);

    document.querySelectorAll('.animate-scroll-fade').forEach(element => {
        scrollObserver.observe(element);
    });

    const statsSection = document.querySelector('.scroll-trigger-counters');
    if (statsSection) {
        scrollObserver.observe(statsSection);
    }

    // ────────────────────────────────────────────────────────────
    // 2. COMPTEURS DE STATISTIQUES INTERACTIFS (Ease-Out)
    // ────────────────────────────────────────────────────────────
    function startStatisticsCounters(section) {
        const counters = section.querySelectorAll('.counter-value');
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'), 10);
            const duration = 2000; // Durée totale de 2 secondes
            const frameDuration = 1000 / 60; // 60 FPS (images par seconde)
            const totalFrames = Math.round(duration / frameDuration);
            let frame = 0;

            const incrementTimer = setInterval(() => {
                frame++;
                const progress = frame / totalFrames;
                
                // Formule Ease-Out Quad pour ralentir vers la fin
                const easeProgress = progress * (2 - progress);
                const currentValue = Math.round(easeProgress * target);

                counter.textContent = currentValue;

                if (frame >= totalFrames) {
                    counter.textContent = target; // S'assure que la valeur finale est exacte
                    clearInterval(incrementTimer);
                }
            }, frameDuration);
        });
    }

    // ────────────────────────────────────────────────────────────
    // 3. MOTEUR DU CARROUSEL DE TÉMOIGNAGES (Boutons actifs)
    // ────────────────────────────────────────────────────────────
    const slides = document.querySelectorAll('.testimonial-slide');
    const btnPrev = document.getElementById('btnTestiPrev');
    const btnNext = document.getElementById('btnTestiNext');
    const dotsContainer = document.getElementById('testiDotsContainer');
    
    if (slides.length > 0 && btnPrev && btnNext && dotsContainer) {
        let currentSlideIndex = 1; // Slide centrale active par défaut

        dotsContainer.innerHTML = '';
        slides.forEach((_, idx) => {
            const dot = document.createElement('span');
            dot.className = `dot ${idx === currentSlideIndex ? 'active' : ''}`;
            dot.style.cursor = 'pointer';
            dot.addEventListener('click', () => {
                goToSlide(idx);
            });
            dotsContainer.appendChild(dot);
        });

        const dots = dotsContainer.querySelectorAll('.dot');

        function goToSlide(index) {
            if (index < 0) index = slides.length - 1;
            if (index >= slides.length) index = 0;
            
            currentSlideIndex = index;

            slides.forEach((slide, idx) => {
                if (idx === index) {
                    slide.classList.add('active');
                } else {
                    slide.classList.remove('active');
                }
            });

            dots.forEach((dot, idx) => {
                if (idx === index) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        btnPrev.addEventListener('click', (e) => {
            e.preventDefault();
            goToSlide(currentSlideIndex - 1);
        });

        btnNext.addEventListener('click', (e) => {
            e.preventDefault();
            goToSlide(currentSlideIndex + 1);
        });

        goToSlide(currentSlideIndex);
    }

});
</script>
@endsection