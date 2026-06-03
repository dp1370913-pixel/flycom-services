@extends('layouts.public')

@section('title', 'Accueil | Flycom Services - Solutions Technologiques au Congo')

<!-- Injection du Schéma LocalBusiness spécifique à la page d'accueil (Exigence technique M6) -->
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
        <!-- SECTION HERO                               -->
        <!-- ========================================== -->
        <section id="hero" class="hero-section d-flex align-items-center position-relative overflow-hidden">
            <div class="network-particles"></div>
            <div class="container py-4 py-md-5 z-2 position-relative">
                <div class="row align-items-center g-4 g-lg-5">
                    <div class="col-12 col-lg-7 text-center text-lg-start">
                        <div class="badge-accent mb-4 d-inline-flex align-items-center gap-2">
                            <span class="dot-blink"></span>
                            <span>Solutions technologiques au Congo</span>
                        </div>
                        <h1 class="display-main-heading fw-extrabold text-white mb-3">
                            Des solutions pour <br>
                            <span class="text-cyan text-decor-slash">sécuriser</span> / 
                            <span class="text-cyan-muted text-decor-slash">connecter</span> / <br>
                            <span class="text-white-80">optimiser</span> votre monde
                        </h1>
                        <p class="lead text-light-muted mb-4 fs-7">
                            Flycom Services accompagne particuliers et entreprises à Brazzaville avec des solutions sur mesure en sécurité, énergie et technologies.
                        </p>
                        <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3">
                            <a href="{{ route('services') }}" class="btn btn-cyan btn-lg rounded-pill px-4 py-3 fw-bold fs-7 text-decoration-none">
                                Découvrir nos services 
                            </a>
                            <a href="{{ route('contact') }}" class="btn btn-outline-light-custom btn-lg rounded-pill px-4 py-3 fw-bold fs-7 text-decoration-none">
                                Demander un devis
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 d-none d-lg-block">
                        <div class="hero-image-overlay rounded-4 shadow-lg overflow-hidden border border-navy-light">
                            <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=800&q=80" alt="Supervision technologique" class="img-fluid hero-img">
                            <div class="overlay-dark-blue"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- BANDEAU D'ICÔNES SERVICES                  -->
        <!-- ========================================== -->
        <section class="icon-ribbon py-4 border-top border-bottom border-navy-light position-relative z-3">
            <div class="ribbon-scroll-container">
                <div class="d-flex justify-content-between align-items-center gap-4 py-2 px-3">
                    <div class="ribbon-item"><i class="bi bi-camera-video"></i> Surveillance</div>
                    <div class="ribbon-item"><i class="bi bi-sun"></i> Solaire</div>
                    <div class="ribbon-item"><i class="bi bi-wind"></i> Climatisation</div>
                    <div class="ribbon-item"><i class="bi bi-car-front"></i> Location</div>
                    <div class="ribbon-item"><i class="bi bi-volume-up"></i> Sonorisation</div>
                    <div class="ribbon-item"><i class="bi bi-fingerprint"></i> Accès</div>
                    <div class="ribbon-item"><i class="bi bi-lightning-charge"></i> Électrique</div>
                    <div class="ribbon-item"><i class="bi bi-tools"></i> Maintenance</div>
                    <div class="ribbon-item"><i class="bi bi-shield-lock"></i> Sécurité</div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION CHIFFRES                           -->
        <!-- ========================================== -->
        <section class="stats-section py-5 text-white position-relative">
            <div class="network-particles"></div>
            <div class="container py-lg-5 text-center position-relative z-2">
                <span class="text-cyan fw-bold text-uppercase tracking-wider fs-8 d-block mb-2">Nos chiffres</span>
                <h2 class="h2 fw-extrabold mb-5">Des résultats qui <span class="text-cyan">parlent</span></h2>
                
                <div class="row g-4 justify-content-center">
                    <div class="col-6 col-md-3">
                        <div class="stat-number">10+</div>
                        <h3 class="h6 fw-bold text-white mb-2 fs-7">Années d'expérience</h3>
                        <p class="fs-8 text-light-muted mb-0">Au service des entreprises et particuliers du Congo</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-number">500+</div>
                        <h3 class="h6 fw-bold text-white mb-2 fs-7">Clients satisfaits</h3>
                        <p class="fs-8 text-light-muted mb-0">Particuliers, entreprises et institutions</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-number">8</div>
                        <h3 class="h6 fw-bold text-white mb-2 fs-7">Domaines experts</h3>
                        <p class="fs-8 text-light-muted mb-0">De la sécurité à l'énergie en passant par les réseaux</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-number">50+</div>
                        <h3 class="h6 fw-bold text-white mb-2 fs-7">Projets réalisés</h3>
                        <p class="fs-8 text-light-muted mb-0">Installations, audits et maintenances</p>
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
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <span class="text-muted tracking-widest fs-8 text-uppercase">Flycom / Services</span>
                        <h2 class="h3 fw-extrabold text-navy mt-1">Une gamme complète de <br>solutions <span class="text-cyan">technologiques</span></h2>
                    </div>
                    <a href="{{ route('services') }}" class="text-navy fw-semibold text-decoration-none fs-7 hover-cyan d-none d-md-block">
                        Voir tous les services <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="bento-grid">
                    <!-- Bento 1: Réseaux Informatiques -->
                    <div class="bento-card bento-1" style="background-image: url('https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=800&q=80');">
                        <div class="bento-overlay"></div>
                        <div class="bento-content">
                            <span class="badge-bento-price">Sur devis</span>
                            <h3 class="h5 fw-bold text-white mb-2">Réseaux Informatiques</h3>
                            <p class="fs-8 text-light-muted mb-0">Installation et maintenance de réseaux LAN/WAN pour entreprises et particuliers.</p>
                        </div>
                    </div>

                    <!-- Bento 2: Vidéosurveillance -->
                    <div class="bento-card bento-2" style="background-image: url('https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=800&q=80');">
                        <div class="bento-overlay"></div>
                        <div class="bento-content">
                            <span class="badge-bento-price">À partir de 150 000 FCFA</span>
                            <h3 class="h6 fw-bold text-white mb-2">Vidéosurveillance</h3>
                            <p class="fs-8 text-light-muted mb-0">Systèmes de caméras HD et IP pour surveillance intérieure et extérieure.</p>
                        </div>
                    </div>

                    <!-- Bento 3: Contrôle d'accès -->
                    <div class="bento-card bento-3" style="background-image: url('https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=800&q=80');">
                        <div class="bento-overlay"></div>
                        <div class="bento-content">
                            <span class="badge-bento-price">À partir de 250 000 FCFA</span>
                            <h3 class="h6 fw-bold text-white mb-2">Contrôle d'accès</h3>
                            <p class="fs-8 text-light-muted mb-0">Solutions biométriques, badges et digicodes pour sécuriser vos locaux.</p>
                        </div>
                    </div>

                    <!-- Bento 4: Barbelé Électrique -->
                    <div class="bento-card bento-4" style="background-image: url('https://images.unsplash.com/photo-1508873535684-277a3cbcc4e8?auto=format&fit=crop&w=800&q=80');">
                        <div class="bento-overlay"></div>
                        <div class="bento-content">
                            <span class="badge-bento-price">Sur devis</span>
                            <h3 class="h6 fw-bold text-white mb-2">Barbelé Électrique</h3>
                            <p class="fs-8 text-light-muted mb-0">Clôtures électrifiées de haute sécurité pour résidences et industries.</p>
                        </div>
                    </div>

                    <!-- Bento 5: Panneaux Solaires -->
                    <div class="bento-card bento-5" style="background-image: url('https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=800&q=80');">
                        <div class="bento-overlay"></div>
                        <div class="bento-content">
                            <span class="badge-bento-price">À partir de 950 000 FCFA</span>
                            <h3 class="h6 fw-bold text-white mb-2">Panneaux Solaires</h3>
                            <p class="fs-8 text-light-muted mb-0">Installation photovoltaïque pour maisons et entreprises au Congo.</p>
                        </div>
                    </div>

                    <!-- Bento 6: Climatisation -->
                    <div class="bento-card bento-6" style="background-image: url('https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&w=800&q=80');">
                        <div class="bento-overlay"></div>
                        <div class="bento-content">
                            <span class="badge-bento-price">À partir de 80 000 FCFA</span>
                            <h3 class="h6 fw-bold text-white mb-2">Climatisation</h3>
                            <p class="fs-8 text-light-muted mb-0">Installation, maintenance et réparation de climatisation.</p>
                        </div>
                    </div>

                    <!-- Bento 7: Location de Véhicules -->
                    <div class="bento-card bento-7" style="background-image: url('https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=80');">
                        <div class="bento-overlay"></div>
                        <div class="bento-content">
                            <span class="badge-bento-price">À partir de 35 000 FCFA/jour</span>
                            <h3 class="h6 fw-bold text-white mb-2">Location de Véhicules</h3>
                            <p class="fs-8 text-light-muted mb-0">Flotte de véhicules disponibles à la location courte et longue durée.</p>
                        </div>
                    </div>

                    <!-- Bento 8: Location de Sonorisation -->
                    <div class="bento-card bento-8" style="background-image: url('https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=800&q=80');">
                        <div class="bento-overlay"></div>
                        <div class="bento-content">
                            <span class="badge-bento-price">À partir de 50 000 FCFA/jour</span>
                            <h3 class="h6 fw-bold text-white mb-2">Location Sonorisation</h3>
                            <p class="fs-8 text-light-muted mb-0">Équipements audio professionnels pour événements et manifestations.</p>
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
                    <div class="col-12 col-lg-6">
                        <div class="about-image-wrapper position-relative">
                            <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=800&q=80" alt="Technicien qualifié" class="img-fluid rounded-4 shadow-sm w-100">
                            <div class="badge-experience bg-navy text-white rounded-3 p-3 position-absolute bottom-0 start-0 m-3 border border-navy-light shadow-lg">
                                <span class="d-block fw-extrabold fs-4 lh-1 text-cyan">+10 ans</span>
                                <span class="fs-9 text-light-muted">d'Expertise au Congo</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <span class="text-cyan fw-bold text-uppercase tracking-wider fs-8 d-block mb-2">À PROPOS</span>
                        <h2 class="h2 fw-extrabold text-navy mb-4">Votre Partenaire <span class="text-cyan">Technologique</span> de Confiance</h2>
                        <p class="text-muted mb-3 fs-7">
                            Flycom Services est une entreprise multiservices établie au cœur de <strong>Brazzaville, au 22, Avenue de Brazza — La Glacière</strong>. Fondée sur des valeurs de rigueur, de compétence et de proximité client, elle accompagne particuliers, entreprises et institutions dans leur transformation technologique.
                        </p>
                        <p class="text-muted mb-4 fs-7">
                            Notre équipe d'experts intervient sur l'ensemble du territoire avec des solutions sur mesure, du devis à la maintenance, en passant par l'installation et la formation.
                        </p>
                        
                        <div class="row g-2 mb-4">
                            <div class="col-6"><span class="pill-badge w-100"><i class="bi bi-patch-check"></i> Expertise certifiée</span></div>
                            <div class="col-6"><span class="pill-badge w-100"><i class="bi bi-chat-text"></i> SAV réactif</span></div>
                            <div class="col-6"><span class="pill-badge w-100"><i class="bi bi-gear"></i> Solutions sur mesure</span></div>
                            <div class="col-6"><span class="pill-badge w-100"><i class="bi bi-tag"></i> Prix compétitifs</span></div>
                            <div class="col-6"><span class="pill-badge w-100"><i class="bi bi-people"></i> Équipe expérimentée</span></div>
                            <div class="col-6"><span class="pill-badge w-100"><i class="bi bi-shield-check"></i> Garantie travaux</span></div>
                        </div>

                        <a href="{{ route('about') }}" class="btn btn-navy-dark rounded-pill px-4 py-3 fw-bold text-white text-decoration-none fs-7 d-inline-block">
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
        <!-- SECTION CE QUI NOUS DISTINGUE              -->
        <!-- ========================================== -->
        <section id="distinction" class="distinction-section py-5 text-white position-relative">
            <div class="network-particles"></div>
            <div class="container py-lg-5 position-relative z-2">
                <div class="text-center mb-5">
                    <span class="text-cyan-muted fw-bold text-uppercase tracking-wider fs-8 d-block mb-1">POURQUOI NOUS</span>
                    <h2 class="h2 fw-extrabold">Ce Qui Nous <span class="text-cyan">Distingue</span></h2>
                </div>

                <div class="timeline-vertical position-relative py-4">
                    <div class="timeline-v-line"></div>

                    <!-- Étape 1 -->
                    <div class="timeline-v-item left-item">
                        <div class="timeline-v-badge">
                            <i class="bi bi-layers"></i>
                        </div>
                        <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                            <span class="v-card-watermark">01</span>
                            <h3 class="h6 fw-bold text-white mb-2">Expertise Multidisciplinaire</h3>
                            <p class="fs-8 text-light-muted mb-0">Une seule entreprise pour tous vos besoins : réseau, sécurité, énergie, climatisation et bien plus encore.</p>
                        </div>
                    </div>

                    <!-- Étape 2 -->
                    <div class="timeline-v-item right-item">
                        <div class="timeline-v-badge">
                            <i class="bi bi-stopwatch"></i>
                        </div>
                        <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                            <span class="v-card-watermark">02</span>
                            <h3 class="h6 fw-bold text-white mb-2">Intervention Rapide</h3>
                            <p class="fs-8 text-light-muted mb-0">Équipe mobile disponible sur Brazzaville et dans tout le Congo pour des interventions dans les meilleurs délais.</p>
                        </div>
                    </div>

                    <!-- Étape 3 -->
                    <div class="timeline-v-item left-item">
                        <div class="timeline-v-badge">
                            <i class="bi bi-patch-check"></i>
                        </div>
                        <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                            <span class="v-card-watermark">03</span>
                            <h3 class="h6 fw-bold text-white mb-2">Matériel de Qualité</h3>
                            <p class="fs-8 text-light-muted mb-0">Nous utilisons exclusivement des équipements de marques reconnues mondialement, avec garanties fabricant.</p>
                        </div>
                    </div>

                    <!-- Étape 4 -->
                    <div class="timeline-v-item right-item">
                        <div class="timeline-v-badge">
                            <i class="bi bi-wrench"></i>
                        </div>
                        <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                            <span class="v-card-watermark">04</span>
                            <h3 class="h6 fw-bold text-white mb-2">Suivi &amp; Maintenance</h3>
                            <p class="fs-8 text-light-muted mb-0">Contrats de maintenance préventive et corrective pour assurer la pérennité de vos installations.</p>
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
                <span class="text-cyan fw-bold text-uppercase tracking-wider fs-8 d-block mb-2">PROCESSUS</span>
                <h2 class="h2 fw-extrabold text-navy mb-5">Comment ça <span class="text-cyan">marche</span> ?</h2>

                <div class="row g-4 timeline-row position-relative justify-content-center">
                    <div class="timeline-line d-none d-md-block"></div>
                    
                    <!-- Étape 1 -->
                    <div class="col-12 col-md-4 timeline-step">
                        <div class="icon-circle mb-4 bg-navy-dark text-white mx-auto position-relative">
                            <span class="step-watermark">01</span>
                            <i class="bi bi-chat-dots fs-4"></i>
                        </div>
                        <div class="process-card p-4 rounded-4 shadow-sm bg-cyan-soft border border-cyan-light-solid">
                            <h3 class="h6 fw-bold text-navy mb-3">Contact</h3>
                            <p class="fs-8 text-muted mb-0">Appelez-nous au 06 628 57 41 ou remplissez le formulaire en ligne. Nous répondons sous 30 minutes.</p>
                        </div>
                    </div>

                    <!-- Étape 2 -->
                    <div class="col-12 col-md-4 timeline-step">
                        <div class="icon-circle mb-4 bg-navy-dark text-white mx-auto position-relative">
                            <span class="step-watermark">02</span>
                            <i class="bi bi-search fs-4"></i>
                        </div>
                        <div class="process-card p-4 rounded-4 shadow-sm bg-white border border-light">
                            <h3 class="h6 fw-bold text-navy mb-3">Audit gratuit</h3>
                            <p class="fs-8 text-muted mb-0">Nos experts se déplacent pour évaluer vos besoins et vous proposer une solution adaptée à votre budget.</p>
                        </div>
                    </div>

                    <!-- Étape 3 -->
                    <div class="col-12 col-md-4 timeline-step">
                        <div class="icon-circle mb-4 bg-navy-dark text-white mx-auto position-relative">
                            <span class="step-watermark">03</span>
                            <i class="bi bi-tools fs-4"></i>
                        </div>
                        <div class="process-card p-4 rounded-4 shadow-sm bg-white border border-light">
                            <h3 class="h6 fw-bold text-navy mb-3">Installation</h3>
                            <p class="fs-8 text-muted mb-0">Nos techniciens certifiés installent votre équipement avec soin et vous forment à son utilisation.</p>
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
                <span class="text-cyan fw-bold text-uppercase tracking-wider fs-8 d-block mb-2 text-center text-md-start">RÉALISATIONS</span>
                <h2 class="h2 fw-extrabold text-navy mb-4 text-center text-md-start">Nos Projets en <span class="text-cyan">Images</span></h2>

                <div class="portfolio-grid">
                    <div class="port-item port-1 rounded-4 overflow-hidden position-relative">
                        <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=800&q=80" alt="Serveurs réseaux" class="img-fluid w-100 h-100 object-fit-cover">
                        <div class="port-caption">Réseaux d'Entreprise</div>
                    </div>
                    <div class="port-item port-2 rounded-4 overflow-hidden position-relative">
                        <img src="https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=800&q=80" alt="Panneau Solaire" class="img-fluid w-100 h-100 object-fit-cover">
                        <div class="port-caption">Installation Énergie Solaire</div>
                    </div>
                    <div class="port-item port-3 rounded-4 overflow-hidden position-relative">
                        <img src="https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=800&q=80" alt="Caméra dôme extérieure" class="img-fluid w-100 h-100 object-fit-cover">
                        <div class="port-caption">Surveillance Périmétrique</div>
                    </div>
                    <div class="port-item port-4 rounded-4 overflow-hidden position-relative">
                        <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&w=800&q=80" alt="Maintenance Climatisation" class="img-fluid w-100 h-100 object-fit-cover">
                        <div class="port-caption">Maintenance Climatisation</div>
                    </div>
                    <div class="port-item port-5 rounded-4 overflow-hidden position-relative">
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
        <!-- SECTION TÉMOIGNAGES                        -->
        <!-- ========================================== -->
        <section class="testimonials-section py-5 text-white position-relative overflow-hidden">
            <div class="network-particles"></div>
            <div class="container py-lg-5 text-center position-relative z-2">
                <h2 class="h2 fw-extrabold mb-5">Ils nous font <span class="text-cyan">confiance</span></h2>

                <div class="testimonials-track-wrapper mx-auto">
                    <div class="testimonials-track">
                        
                        <!-- Témoignage 1 -->
                        <div class="testi-card card-faded-left p-4 rounded-4 border text-start">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="testi-rating-badge">
                                    <i class="bi bi-star-fill"></i> 5.0
                                </span>
                                <span class="text-muted fs-8">Brazzaville</span>
                            </div>
                            <p class="testimonial-quote-text fs-8 text-white-50 leading-relaxed mb-4">
                                <span class="text-cyan fs-3 d-inline-block lh-1 vertical-align-middle me-1">“</span>La mise en place de nos serveurs d'entreprise a été gérée avec brio. Nous avons maintenant une infrastructure robuste et parfaitement dimensionnée.<span class="text-cyan fs-3 d-inline-block lh-1 vertical-align-middle ms-1">”</span>
                            </p>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle rounded-circle overflow-hidden bg-cyan border-0">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&h=150&q=80" alt="Patrick Okemba" class="img-fluid w-100 h-100 object-fit-cover">
                                </div>
                                <div>
                                    <h4 class="h7 fw-bold mb-0 text-white-50">Patrick Okemba</h4>
                                    <small class="text-muted fs-9">Directeur Technique, Congo Tech</small>
                                </div>
                            </div>
                        </div>

                        <!-- Témoignage 2 -->
                        <div class="testi-card card-active p-4 p-md-5 rounded-4 border text-start">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="testi-rating-badge">
                                    <i class="bi bi-star-fill"></i> 5.0
                                </span>
                                <span class="text-muted fs-8">Brazzaville</span>
                            </div>
                            <p class="testimonial-quote-text fs-7 text-white-80 leading-relaxed mb-4">
                                <span class="text-cyan fs-2 d-inline-block lh-1 vertical-align-middle me-1">“</span>Les panneaux solaires installés par Flycom nous permettent d'économiser 60% sur notre facture d'électricité. Installation rapide, propre et conforme. Merci à toute l'équipe !<span class="text-cyan fs-2 d-inline-block lh-1 vertical-align-middle ms-1">”</span>
                            </p>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle rounded-circle overflow-hidden bg-cyan border-0">
                                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=150&h=150&q=80" alt="Aminata Diallo" class="img-fluid w-100 h-100 object-fit-cover">
                                </div>
                                <div>
                                    <h4 class="h7 fw-bold mb-0 text-white">Aminata Diallo</h4>
                                    <small class="text-cyan fs-9">Propriétaire, Résidence Les Orchidées</small>
                                </div>
                            </div>
                        </div>

                        <!-- Témoignage 3 -->
                        <div class="testi-card card-faded-right p-4 rounded-4 border text-start">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="testi-rating-badge">
                                    <i class="bi bi-star-fill"></i> 5.0
                                </span>
                                <span class="text-muted fs-8">Brazzaville</span>
                            </div>
                            <p class="testimonial-quote-text fs-8 text-white-50 leading-relaxed mb-4">
                                <span class="text-cyan fs-3 d-inline-block lh-1 vertical-align-middle me-1">“</span>Flycom Services a transformé la sécurité de nos immeubles. Leur équipe a installé un système de vidéosurveillance complet en moins d'une semaine.<span class="text-cyan fs-3 d-inline-block lh-1 vertical-align-middle ms-1">”</span>
                            </p>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle rounded-circle overflow-hidden bg-cyan border-0">
                                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&h=150&q=80" alt="Jean-Pierre Mabiala" class="img-fluid w-100 h-100 object-fit-cover">
                                </div>
                                <div>
                                    <h4 class="h7 fw-bold mb-0 text-white-50">Jean-Pierre Mabiala</h4>
                                    <small class="text-muted fs-9">Directeur, Société Immobilière Congo</small>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Contrôles -->
                    <div class="d-flex justify-content-center align-items-center gap-3 mt-4">
                        <button class="slider-btn prev-btn" aria-label="Avis Précédent">
                            <i class="bi bi-arrow-left"></i>
                        </button>
                        <div class="slider-dots d-flex gap-1 align-items-center">
                            <span class="dot"></span>
                            <span class="dot active"></span>
                            <span class="dot"></span>
                        </div>
                        <button class="slider-btn next-btn active-btn" aria-label="Avis Suivant">
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

            <div class="container text-center py-lg-4 position-relative z-2">
                <span class="badge bg-white-transparent rounded-pill px-3 py-2 fs-8 mb-4 d-inline-block">
                    • Devis gratuit sous 24h
                </span>
                <h2 class="display-5 fw-extrabold mb-3 leading-tight text-navy">
                    Prêt à sécuriser <br class="d-sm-none"> votre environnement ?
                </h2>
                <p class="max-w-md mx-auto fs-7 mb-4 text-navy opacity-80 px-2">
                    Contactez-nous dès aujourd'hui pour un devis gratuit et sans engagement. Nos experts vous répondent sous 30 minutes.
                </p>

                <a href="tel:+242066285741" class="btn btn-navy-dark btn-lg rounded-pill px-5 py-3 fw-bold text-white shadow mb-4 d-inline-block w-30 w-sm-auto">
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
@endsection