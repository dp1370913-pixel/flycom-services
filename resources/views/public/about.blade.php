@extends('layouts.public')

@section('title', 'À propos de Flycom | Notre Histoire et nos Équipes au Congo')

@section('content')
<!-- SECTION HERO DE LA PAGE À PROPOS -->
<section id="about-hero" class="hero-section d-flex align-items-center position-relative overflow-hidden">
    <div class="network-particles"></div>
    <div class="container py-4 py-md-5 z-2 position-relative text-center text-lg-start">
        <div class="row align-items-center g-5">
            <div class="col-12 col-lg-6">
                <div class="custom-badge-pill mb-3">
                        <span class="badge-dot"></span>
                        <span>Notre histoire</span>
                </div>
                <h1 class="display-main-heading fw-extrabold text-white mb-3">À propos de <span class="text-cyan">Flycom</span></h1>
                <p class="lead text-light-muted fs-7 mb-4">
                    Née d'une volonté de moderniser les infrastructures technologiques au Congo, Flycom Services réunit rigueur, expertise certifiée et accompagnement de proximité.
                </p>
                <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3">
                    <a href="#history" class="btn btn-cyan rounded-pill px-4 py-3 fw-bold fs-7 text-decoration-none">Découvrir notre histoire</a>
                    <a href="#team" class="btn btn-outline-light-custom rounded-pill px-4 py-3 fw-bold fs-7 text-decoration-none">Renconter l'équipe</a>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="about-image-wrapper position-relative">
                    <img src="https://images.unsplash.com/photo-1600132806370-bf17e65e942f?auto=format&fit=crop&w=800&q=80" alt="Équipe Flycom" class="img-fluid rounded-4 shadow-sm w-100">
                    <div class="badge-experience bg-navy text-white rounded-3 p-3 position-absolute bottom-0 start-0 m-3 border border-navy-light shadow-lg">
                        <span class="d-block fw-extrabold fs-4 lh-1 text-cyan">+10 ans</span>
                        <span class="fs-9 text-light-muted">d'Expertise Cumulée</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wave Divider : Hero (Sombre) -> Innovation (Clair) -->
    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,32L60,42.7C120,53,240,75,360,80C480,85,600,75,720,64C840,53,960,43,1080,48C1200,53,1320,75,1380,85.3L1440,96L1440,120L1380,120C1320,120,1200,120,1080,120C960,120,840,120,720,120C600,120,480,120,360,120C240,120,120,120,60,120L0,120Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- SECTION INNOVATION -->
<section class="py-5 bg-white text-navy text-center text-md-start">
    <div class="container py-4">
        <div class="row g-5 align-items-center">
            <div class="col-12 col-md-6">
                <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?auto=format&fit=crop&w=800&q=80" alt="Innovation" class="img-fluid rounded-4 shadow-sm">
            </div>
            <div class="col-12 col-md-6">
                <span class="text-cyan fw-bold tracking-widest fs-8 text-uppercase">L'Innovation</span>
                <h2 class="fw-extrabold text-navy mt-1">Une expertise née de <span class="text-cyan">l'innovation</span></h2>
                <p class="text-muted fs-7 leading-relaxed mt-3">
                    Chez Flycom Services, nous étudions chaque projet avec minutie pour y intégrer les solutions logicielles et matérielles les plus innovantes du marché mondial. Nos techniciens formés aux protocoles de sécurité les plus avancés garantissent des déploiements fiables et parfaitement conformes.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- SECTION STATS (Devient sombre pour permettre un double effet de vagues créatives) -->
<section class="py-5 bg-navy-dark text-white position-relative overflow-hidden">
    <div class="network-particles"></div>
    
    <!-- Wave Divider : Innovation (Clair) -> Stats (Sombre) -->
    <div class="wave-container" style="top: -1px;">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,32L60,42.7C120,53,240,75,360,80C480,85,600,75,720,64C840,53,960,43,1080,48C1200,53,1320,75,1380,85.3L1440,96L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z" fill="#ffffff"></path>
        </svg>
    </div>

    <div class="container py-5 text-center position-relative z-2">
        <div class="row g-4 justify-content-center">
            <div class="col-6 col-md-3">
                <!-- Ajout de la classe "counter" pour l'effet dynamique de défilement -->
                <div class="stat-number text-white mb-2"><span class="counter" data-target="500">0</span>+</div>
                <p class="fs-8 text-cyan fw-bold mb-0">Clients satisfaits</p>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number text-white mb-2"><span class="counter" data-target="50">0</span>+</div>
                <p class="fs-8 text-cyan fw-bold mb-0">Projets d'envergure</p>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number text-white mb-2"><span class="counter" data-target="8">0</span></div>
                <p class="fs-8 text-cyan fw-bold mb-0">Domaines d'expertise</p>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number text-white mb-2"><span class="counter" data-target="24">0</span>/7</div>
                <p class="fs-8 text-cyan fw-bold mb-0">Support technique</p>
            </div>
        </div>
    </div>

    <!-- Wave Divider : Stats (Sombre) -> Timeline (Sombre et continu) -->
</section>

<!-- SECTION TIMELINE HISTORIQUE -->
<section id="history" class="py-5 bg-navy text-white position-relative">
    <div class="container py-lg-5">
        <div class="text-center mb-5">
            <span class="text-cyan fw-bold text-uppercase tracking-wider fs-8">Une histoire de croissance</span>
            <h2 class="h2 fw-extrabold mt-2">Notre parcours vers <span class="text-cyan">l'excellence</span></h2>
        </div>
        <div class="timeline-vertical position-relative py-4">
            <div class="timeline-v-line"></div>
            <!-- Étape 1 -->
            <div class="timeline-v-item left-item">
                <div class="timeline-v-badge"><i class="bi bi-rocket-takeoff"></i></div>
                <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                    <span class="v-card-watermark">01</span>
                    <h3 class="h6 fw-bold text-white mb-2">Création de Flycom</h3>
                    <p class="fs-8 text-light-muted mb-0">Implantation au cœur de Brazzaville de nos premiers ateliers de vidéosurveillance et réseaux d'entreprise.</p>
                </div>
            </div>
            <!-- Étape 2 -->
            <div class="timeline-v-item right-item">
                <div class="timeline-v-badge"><i class="bi bi-briefcase"></i></div>
                <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                    <span class="v-card-watermark">02</span>
                    <h3 class="h6 fw-bold text-white mb-2">Premiers grands projets</h3>
                    <p class="fs-8 text-light-muted mb-0">Signature de nos premiers contrats d'envergure pour la sécurisation active de résidences diplomatiques.</p>
                </div>
            </div>
            <!-- Étape 3 -->
            <div class="timeline-v-item left-item">
                <div class="timeline-v-badge"><i class="bi bi-cpu"></i></div>
                <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                    <span class="v-card-watermark">03</span>
                    <h3 class="h6 fw-bold text-white mb-2">Expansion des services</h3>
                    <p class="fs-8 text-light-muted mb-0">Intégration de l'ingénierie énergétique (panneaux solaires) et de la sonorisation professionnelle à notre catalogue.</p>
                </div>
            </div>
            <!-- Étape 4 -->
            <div class="timeline-v-item right-item">
                <div class="timeline-v-badge"><i class="bi bi-award"></i></div>
                <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                    <span class="v-card-watermark">04</span>
                    <h3 class="h6 fw-bold text-white mb-2">Certification &amp; Partenariats</h3>
                    <p class="fs-8 text-light-muted mb-0">Homologation auprès des équipementiers mondiaux pour distribuer uniquement du matériel de marque officiel.</p>
                </div>
            </div>
            <!-- Étape 5 -->
            <div class="timeline-v-item left-item">
                <div class="timeline-v-badge"><i class="bi bi-shield-check"></i></div>
                <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                    <span class="v-card-watermark">05</span>
                    <h3 class="h6 fw-bold text-white mb-2">DigiZone &amp; Programme D-clic</h3>
                    <p class="fs-8 text-light-muted mb-0">Développement de notre plateforme d'entreprise grâce au mentorat précieux de DigiZone et de l'OIF.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Wave Divider : Timeline (Sombre) -> Valeurs (Clair) -->
    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- SECTION VALEURS -->
<section class="py-5 bg-white text-navy text-center text-md-start">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="text-cyan fw-bold text-uppercase tracking-wider fs-8">NOS VALEURS</span>
            <h2 class="fw-extrabold text-navy mt-1">Ce qui nous <span class="text-cyan">guide</span> chaque jour</h2>
        </div>
        <div class="row g-4">
            <div class="col-12 col-md-3">
                <div class="p-4 bg-light rounded-4 h-100 value-card">
                    <i class="bi bi-heart-fill text-cyan fs-3 mb-3 d-block"></i>
                    <h3 class="h6 fw-bold text-navy">Intégrité</h3>
                    <p class="fs-8 text-muted mb-0">Honnêteté totale dans l'établissement de nos rapports de diagnostics et de nos devis.</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="p-4 bg-light rounded-4 h-100 value-card">
                    <i class="bi bi-eye-fill text-cyan fs-3 mb-3 d-block"></i>
                    <h3 class="h6 fw-bold text-navy">Transparence</h3>
                    <p class="fs-8 text-muted mb-0">Aucun frais caché ou imprévu : le client suit pas à pas l'avancement de nos travaux d'installation.</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="p-4 bg-light rounded-4 h-100 value-card">
                    <i class="bi bi-wrench-adjustable text-cyan fs-3 mb-3 d-block"></i>
                    <h3 class="h6 fw-bold text-navy">Suivi &amp; Maintenance</h3>
                    <p class="fs-8 text-muted mb-0">Contrats d'accompagnement annuels pour maintenir vos équipements performants sur la durée.</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="p-4 bg-light rounded-4 h-100 value-card">
                    <i class="bi bi-geo-alt-fill text-cyan fs-3 mb-3 d-block"></i>
                    <h3 class="h6 fw-bold text-navy">Proximité</h3>
                    <p class="fs-8 text-muted mb-0">Interventions rapides garanties dans l'ensemble de Brazzaville grâce à nos équipes mobiles de garde.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION ÉQUIPE -->
<section id="team" class="py-5 bg-light text-navy position-relative">
    <div class="container text-center py-4">
        <span class="text-cyan fw-bold text-uppercase tracking-wider fs-8">Notre équipe</span>
        <h2 class="fw-extrabold text-navy mt-1 mb-5">Les <span class="text-cyan">experts</span> derrière Flycom</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden team-card">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&h=350&q=80" alt="Jean-Marc" class="card-img-top object-fit-cover" style="height:250px;">
                    <div class="card-body bg-white py-3">
                        <h3 class="h6 fw-bold text-navy mb-1">Jean-Marc N.</h3>
                        <p class="fs-9 text-muted mb-0 text-uppercase tracking-wider">Directeur Technique</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden team-card">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&h=350&q=80" alt="Sarah" class="card-img-top object-fit-cover" style="height:250px;">
                    <div class="card-body bg-white py-3">
                        <h3 class="h6 fw-bold text-navy mb-1">Sarah M.</h3>
                        <p class="fs-9 text-muted mb-0 text-uppercase tracking-wider">Lead Ingénieur Solaire</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden team-card">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&h=350&q=80" alt="Patrice" class="card-img-top object-fit-cover" style="height:250px;">
                    <div class="card-body bg-white py-3">
                        <h3 class="h6 fw-bold text-navy mb-1">Patrice K.</h3>
                        <p class="fs-9 text-muted mb-0 text-uppercase tracking-wider">Expert Réseaux LAN/WAN</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden team-card">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&h=350&q=80" alt="Amine" class="card-img-top object-fit-cover" style="height:250px;">
                    <div class="card-body bg-white py-3">
                        <h3 class="h6 fw-bold text-navy mb-1">Amine D.</h3>
                        <p class="fs-9 text-muted mb-0 text-uppercase tracking-wider">Support Client</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wave Divider : Team (Clair) -> Footer (Sombre) -->
    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" fill="#050E2D"></path>
        </svg>
    </div>
</section>
@endsection