@extends('layouts.public')

@section('title', 'À propos de Flycom | Notre Histoire et nos Équipes au Congo')

@section('content')
<!-- ========================================== -->
<!-- SECTION HERO DE LA PAGE À PROPOS           -->
<!-- ========================================== -->
<section id="about-hero" class="hero-section d-flex align-items-center position-relative overflow-hidden">
    <div class="network-particles"></div>
    <div class="container py-4 py-md-5 z-2 position-relative text-center text-lg-start">
        <div class="row align-items-center g-5">
            <div class="col-12 col-lg-6">
                <!-- Badge de gauche corrigé par emboîtement -->
                <div class="hero-load-animate" style="animation-delay: 0.1s;">
                    <div class="custom-badge-pill mb-3 float-element">
                        <span class="badge-dot"></span>
                        <span>Notre histoire</span>
                    </div>
                </div>
                
                <h1 class="display-main-heading fw-extrabold text-white mb-3 hero-load-animate" style="animation-delay: 0.3s; line-height: 1.15;">À propos de <span class="text-cyan">Flycom</span></h1>
                <p class="lead text-light-muted fs-7 mb-4 hero-load-animate" style="animation-delay: 0.5s;">
                    Née d'une volonté de moderniser les infrastructures technologiques au Congo, Flycom Services réunit rigueur, expertise certifiée et accompagnement de proximité.
                </p>
                <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3 hero-load-animate" style="animation-delay: 0.7s;">
                    <a href="#history" class="btn btn-cyan rounded-pill px-4 py-3 fw-bold fs-7 text-decoration-none hover-glow" style="background-color:#00D2F4; border:none; color:#050E2D;">Découvrir notre histoire</a>
                    <a href="#team" class="btn btn-outline-light-custom rounded-pill px-4 py-3 fw-bold fs-7 text-decoration-none hover-lift">Rencontrer l'équipe</a>
                </div>
            </div>
            
            <!-- Image principale corrigée par emboîtement -->
            <div class="col-12 col-lg-6 hero-load-animate" style="animation-delay: 0.5s;">
                <div class="about-image-wrapper position-relative float-element" style="animation-delay: 0.5s;">
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

<!-- ========================================== -->
<!-- SECTION INNOVATION (Glissement croisé)     -->
<!-- ========================================== -->
<section class="py-5 bg-white text-navy text-center text-md-start overflow-hidden">
    <div class="container py-4">
        <div class="row g-5 align-items-center">
            <div class="col-12 col-md-6 animate-scroll-fade slide-left">
                <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?auto=format&fit=crop&w=800&q=80" alt="Innovation" class="img-fluid rounded-4 shadow-sm hover-lift">
            </div>
            <div class="col-12 col-md-6 animate-scroll-fade slide-right">
                <span class="text-cyan fw-bold tracking-widest fs-8 text-uppercase">L'Innovation</span>
                <h2 class="fw-extrabold text-navy mt-1">Une expertise née de <span class="text-cyan">l'innovation</span></h2>
                <p class="text-muted fs-7 leading-relaxed mt-3">
                    Chez Flycom Services, nous étudions chaque projet avec minutie pour y intégrer les solutions logicielles et matérielles les plus innovantes du marché mondial. Nos techniciens formés aux protocoles de sécurité les plus avancés garantissent des déploiements fiables et parfaitement conformes.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- SECTION STATS (Compteurs animés au scroll) -->
<!-- ========================================== -->
<section class="py-5 bg-navy-dark text-white position-relative overflow-hidden scroll-trigger-counters" style="background-color: #030a21;">
    <div class="network-particles"></div>
    
    <div class="wave-container" style="top: -1px;">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,32L60,42.7C120,53,240,75,360,80C480,85,600,75,720,64C840,53,960,43,1080,48C1200,53,1320,75,1380,85.3L1440,96L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z" fill="#ffffff"></path>
        </svg>
    </div>

    <div class="container py-5 text-center position-relative z-2">
        <div class="row g-4 justify-content-center">
            <div class="col-6 col-md-3 animate-scroll-fade stagger-item">
                <div class="stat-card p-4 rounded-4">
                    <div class="stat-number text-cyan mb-2"><span class="counter-value" data-target="500">0</span>+</div>
                    <p class="fs-8 text-white-50 fw-bold mb-0">Clients satisfaits</p>
                </div>
            </div>
            <div class="col-6 col-md-3 animate-scroll-fade stagger-item">
                <div class="stat-card p-4 rounded-4">
                    <div class="stat-number text-cyan mb-2"><span class="counter-value" data-target="50">0</span>+</div>
                    <p class="fs-8 text-white-50 fw-bold mb-0">Projets d'envergure</p>
                </div>
            </div>
            <div class="col-6 col-md-3 animate-scroll-fade stagger-item">
                <div class="stat-card p-4 rounded-4">
                    <div class="stat-number text-cyan mb-2"><span class="counter-value" data-target="8">0</span></div>
                    <p class="fs-8 text-white-50 fw-bold mb-0">Domaines d'expertise</p>
                </div>
            </div>
            <div class="col-6 col-md-3 animate-scroll-fade stagger-item">
                <div class="stat-card p-4 rounded-4">
                    <div class="stat-number text-cyan mb-2"><span class="counter-value" data-target="24">0</span>h/7</div>
                    <p class="fs-8 text-white-50 fw-bold mb-0">Support technique</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- SECTION TIMELINE (Jalons défilants)       -->
<!-- ========================================== -->
<section id="history" class="py-5 bg-navy text-white position-relative overflow-hidden">
    <div class="container py-lg-5">
        <div class="text-center mb-5 animate-scroll-fade">
            <span class="text-cyan fw-bold text-uppercase tracking-wider fs-8">Une histoire de croissance</span>
            <h2 class="h2 fw-extrabold mt-2">Notre parcours vers <span class="text-cyan">l'excellence</span></h2>
        </div>
        
        <div class="timeline-vertical position-relative py-4">
            <div class="timeline-v-line"></div>
            
            <!-- Étape 1 (Gauche) -->
            <div class="timeline-v-item left-item animate-scroll-fade slide-left">
                <div class="timeline-v-badge"><i class="bi bi-rocket-takeoff"></i></div>
                <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                    <span class="v-card-watermark">01</span>
                    <h3 class="h6 fw-bold text-white mb-2">Création de Flycom</h3>
                    <p class="fs-8 text-light-muted mb-0">Implantation au cœur de Brazzaville de nos premiers ateliers de vidéosurveillance et réseaux d'entreprise.</p>
                </div>
            </div>
            
            <!-- Étape 2 (Droite) -->
            <div class="timeline-v-item right-item animate-scroll-fade slide-right">
                <div class="timeline-v-badge"><i class="bi bi-briefcase"></i></div>
                <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                    <span class="v-card-watermark">02</span>
                    <h3 class="h6 fw-bold text-white mb-2">Premiers grands projets</h3>
                    <p class="fs-8 text-light-muted mb-0">Signature de nos premiers contrats d'envergure pour la sécurisation active de résidences d'affaires.</p>
                </div>
            </div>
            
            <!-- Étape 3 (Gauche) -->
            <div class="timeline-v-item left-item animate-scroll-fade slide-left">
                <div class="timeline-v-badge"><i class="bi bi-cpu"></i></div>
                <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                    <span class="v-card-watermark">03</span>
                    <h3 class="h6 fw-bold text-white mb-2">Expansion des services</h3>
                    <p class="fs-8 text-light-muted mb-0">Intégration de l'ingénierie énergétique (panneaux solaires) et de la sonorisation professionnelle à notre catalogue.</p>
                </div>
            </div>
            
            <!-- Étape 4 (Droite) -->
            <div class="timeline-v-item right-item animate-scroll-fade slide-right">
                <div class="timeline-v-badge"><i class="bi bi-award"></i></div>
                <div class="timeline-v-card rounded-4 p-4 border border-navy-light shadow-sm">
                    <span class="v-card-watermark">04</span>
                    <h3 class="h6 fw-bold text-white mb-2">Certification &amp; Partenariats</h3>
                    <p class="fs-8 text-light-muted mb-0">Homologation auprès des équipementiers mondiaux pour distribuer uniquement du matériel certifié.</p>
                </div>
            </div>
            
            <!-- Étape 5 (Gauche) -->
            <div class="timeline-v-item left-item animate-scroll-fade slide-left">
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

<!-- ========================================== -->
<!-- SECTION VALEURS (Effets de lévitation)     -->
<!-- ========================================== -->
<section class="py-5 bg-white text-navy text-center text-md-start">
    <div class="container py-4">
        <div class="text-center mb-5 animate-scroll-fade">
            <span class="text-cyan fw-bold text-uppercase tracking-wider fs-8">NOS VALEURS</span>
            <h2 class="fw-extrabold text-navy mt-1">Ce qui nous <span class="text-cyan">guide</span> chaque jour</h2>
        </div>
        <div class="row g-4">
            <div class="col-12 col-md-3 animate-scroll-fade stagger-item">
                <div class="p-4 bg-light rounded-4 h-100 value-card">
                    <i class="bi bi-heart-fill text-cyan fs-3 mb-3 d-block"></i>
                    <h3 class="h6 fw-bold text-navy">Intégrité</h3>
                    <p class="fs-8 text-muted mb-0">Honnêteté totale dans l'établissement de nos diagnostics de sécurité et de nos estimations financières.</p>
                </div>
            </div>
            <div class="col-12 col-md-3 animate-scroll-fade stagger-item">
                <div class="p-4 bg-light rounded-4 h-100 value-card">
                    <i class="bi bi-eye-fill text-cyan fs-3 mb-3 d-block"></i>
                    <h3 class="h6 fw-bold text-navy">Transparence</h3>
                    <p class="fs-8 text-muted mb-0">Aucun frais caché ou imprévu : le client suit en temps réel l'avancement des déploiements techniques.</p>
                </div>
            </div>
            <div class="col-12 col-md-3 animate-scroll-fade stagger-item">
                <div class="p-4 bg-light rounded-4 h-100 value-card">
                    <i class="bi bi-wrench-adjustable text-cyan fs-3 mb-3 d-block"></i>
                    <h3 class="h6 fw-bold text-navy">Suivi &amp; Maintenance</h3>
                    <p class="fs-8 text-muted mb-0">Contrats de maintenance de garde pour maintenir vos équipements performants sur le long terme.</p>
                </div>
            </div>
            <div class="col-12 col-md-3 animate-scroll-fade stagger-item">
                <div class="p-4 bg-light rounded-4 h-100 value-card">
                    <i class="bi bi-geo-alt-fill text-cyan fs-3 mb-3 d-block"></i>
                    <h3 class="h6 fw-bold text-navy">Proximité</h3>
                    <p class="fs-8 text-muted mb-0">Interventions d'urgence garanties dans l'ensemble de Brazzaville grâce à nos équipes mobiles.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- SECTION ÉQUIPE (Effet zoom sur portraits)  -->
<!-- ========================================== -->
<section id="team" class="py-5 bg-light text-navy position-relative overflow-hidden">
    <div class="container text-center py-4">
        <div class="animate-scroll-fade mb-5">
            <span class="text-cyan fw-bold text-uppercase tracking-wider fs-8">Notre équipe</span>
            <h2 class="fw-extrabold text-navy mt-1">Les <span class="text-cyan">experts</span> derrière Flycom</h2>
        </div>
        
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-sm-6 col-md-3 animate-scroll-fade stagger-item">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden team-card">
                    <div class="team-img-wrapper overflow-hidden" style="height:250px;">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&h=350&q=80" alt="Jean-Marc" class="w-100 h-100 object-fit-cover">
                    </div>
                    <div class="card-body bg-white py-3">
                        <h3 class="h6 fw-bold text-navy mb-1">Jean-Marc N.</h3>
                        <p class="fs-9 text-muted mb-0 text-uppercase tracking-wider">Directeur Technique</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 animate-scroll-fade stagger-item">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden team-card">
                    <div class="team-img-wrapper overflow-hidden" style="height:250px;">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&h=350&q=80" alt="Sarah" class="w-100 h-100 object-fit-cover">
                    </div>
                    <div class="card-body bg-white py-3">
                        <h3 class="h6 fw-bold text-navy mb-1">Sarah M.</h3>
                        <p class="fs-9 text-muted mb-0 text-uppercase tracking-wider">Lead Ingénieur Solaire</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 animate-scroll-fade stagger-item">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden team-card">
                    <div class="team-img-wrapper overflow-hidden" style="height:250px;">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&h=350&q=80" alt="Patrice" class="w-100 h-100 object-fit-cover">
                    </div>
                    <div class="card-body bg-white py-3">
                        <h3 class="h6 fw-bold text-navy mb-1">Patrice K.</h3>
                        <p class="fs-9 text-muted mb-0 text-uppercase tracking-wider">Expert Réseaux LAN/WAN</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 animate-scroll-fade stagger-item">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden team-card">
                    <div class="team-img-wrapper overflow-hidden" style="height:250px;">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&h=350&q=80" alt="Amine" class="w-100 h-100 object-fit-cover">
                    </div>
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

<!-- ========================================== -->
<!-- STYLES DE CENTRALISATION DES ANIMATIONS    -->
<!-- ========================================== -->
<style>
/* 1. Moteur d'animations d'apparitions au Scroll */
.animate-scroll-fade {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.animate-scroll-fade.slide-left {
    transform: translateX(-45px);
}
.animate-scroll-fade.slide-right {
    transform: translateX(45px);
}
.animate-scroll-fade.show {
    opacity: 1 !important;
    transform: translate(0) !important;
}

/* Staggered Delay */
.stagger-item:nth-child(1) { transition-delay: 0.05s; }
.stagger-item:nth-child(2) { transition-delay: 0.12s; }
.stagger-item:nth-child(3) { transition-delay: 0.19s; }
.stagger-item:nth-child(4) { transition-delay: 0.26s; }
.stagger-item:nth-child(5) { transition-delay: 0.33s; }

/* 2. Micro-interactions au survol des cartes */
/* Cartes Valeurs (Pivotement de perspective léger) */
.value-card {
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease !important;
    border: 1px solid transparent;
}
.value-card:hover {
    transform: translateY(-8px) rotateX(1.5deg) rotateY(1deg) !important;
    box-shadow: 0 20px 40px rgba(0, 210, 244, 0.08) !important;
    border-color: rgba(0, 210, 244, 0.2) !important;
}

/* Cartes Équipes (Zoom sur image) */
.team-card {
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
.team-img-wrapper img {
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}
.team-card:hover {
    transform: translateY(-8px) !important;
    box-shadow: 0 25px 45px rgba(0, 210, 244, 0.1) !important;
}
.team-card:hover .team-img-wrapper img {
    transform: scale(1.07);
}

/* Timeline Cards */
.timeline-v-card {
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease !important;
}
.timeline-v-card:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 15px 30px rgba(0, 210, 244, 0.08) !important;
    border-color: rgba(0, 210, 244, 0.25) !important;
}

/* Statistiques */
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

/* 3. Animations instantanées au chargement (Hero) */
.hero-load-animate {
    opacity: 0;
    transform: translateY(22px);
    animation: heroEntrance 1.1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes heroEntrance {
    to { opacity: 1; transform: translateY(0); }
}

.float-element {
    animation: floatingContinuous 5s ease-in-out infinite;
}
@keyframes floatingContinuous {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-12px); }
    100% { transform: translateY(0px); }
}

.hover-lift {
    transition: transform 0.25s ease, box-shadow 0.25s ease !important;
}
.hover-lift:hover {
    transform: translateY(-3px) !important;
    box-shadow: 0 10px 25px rgba(0, 210, 244, 0.2) !important;
}
</style>

<!-- ========================================== -->
<!-- CODE MOTEUR DE SCROLL ET COMPTEUR JS       -->
<!-- ========================================== -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    // 1. MOTEUR INTERSECTION OBSERVER POUR APPARITION AU SCROLL
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

    // 2. COMPTEURS DE STATISTIQUES INTERACTIFS (Ease-Out)
    function startStatisticsCounters(section) {
        const counters = section.querySelectorAll('.counter-value');
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'), 10);
            const duration = 2000; // 2 secondes
            const frameDuration = 1000 / 60; // 60 FPS
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

});
</script>
@endsection