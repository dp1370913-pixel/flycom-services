@extends('layouts.public')

@section('title', 'Nos Services | Solutions Technologiques Professionnelles à Brazzaville')

@section('content')
<!-- ========================================== -->
<!-- SECTION HERO SERVICES                      -->
<!-- ========================================== -->
<section id="services-hero" class="hero-section d-flex align-items-center position-relative overflow-hidden">
    <div class="network-particles"></div>
    <div class="container py-4 py-md-5 z-2 position-relative text-center">
        <!-- Badge cinématique de démarrage -->
        <div class="hero-load-animate" style="animation-delay: 0.1s;">
            <div class="custom-badge-pill mb-3">
                <span class="badge-dot"></span>
                <span>INGÉNIERIE &amp; LOGISTIQUE</span>
            </div>
        </div>
        
        <h1 class="display-main-heading fw-extrabold text-white mb-3 hero-load-animate" style="animation-delay: 0.3s; line-height: 1.15;">Nos <span class="text-cyan">Services</span></h1>
        <p class="lead text-light-muted max-w-md mx-auto fs-7 mb-4 px-2 hero-load-animate" style="animation-delay: 0.5s;">
            Des solutions complètes pour sécuriser, connecter et optimiser votre environnement professionnel et personnel.
        </p>
    </div>
    
    <!-- Séparateur créatif de vagues -->
    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,32L60,42.7C120,53,240,75,360,80C480,85,600,75,720,64C840,53,960,43,1080,48C1200,53,1320,75,1380,85.3L1440,96L1440,120L1380,120C1320,120,1200,120,1080,120C960,120,840,120,720,120C600,120,480,120,360,120C240,120,120,120,60,120L0,120Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- ========================================== -->
<!-- GRILLE DES SERVICES DYNAMIQUE              -->
<!-- ========================================== -->
<section class="services-main-section bg-white text-navy position-relative">
    <div class="container py-2">
        <div class="row g-4 justify-content-center">
            
            @forelse($services as $service)
                @php
                    // Mappeur d'icônes de haute précision basé sur le nom du service
                    $icon = 'bi-shield-fill-check';
                    if ($service->nom_service === 'Réseaux Informatiques') {
                        $icon = 'bi-wifi';
                    } elseif ($service->nom_service === 'Vidéosurveillance') {
                        $icon = 'bi-camera-video';
                    } elseif ($service->nom_service === 'Contrôle d\'accès' || $service->nom_service === 'Contrôle d\'accès') {
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

                    // Mots-clés / Mappings de tags d'intégrité
                    $serviceTags = [
                        'Réseaux Informatiques' => ['Câblage structuré', 'WiFi 6 d\'entreprise', 'Firewall & sécurité', 'Monitoring 24h/7'],
                        'Vidéosurveillance'     => ['Caméras 4K / 8MP', 'Vision nocturne active', 'Détection par IA', 'Alertes en temps réel'],
                        'Contrôle d\'accès'     => ['Biométrie & empreinte', 'RFID / Mifare', 'Portes automatiques', 'Interphones vidéos'],
                        'Barbelé Électrique'    => ['Clôture périmétrique active', 'Énergiseur', 'Sirène d\'alarme de garde', 'Secours batterie'],
                        'Panneaux Solaires'     => ['Panneaux PERC', 'Onduleurs hybrides', 'Stockage lithium de marque', 'Garantie d\'alimentation'],
                        'Climatisation'         => ['Inverter A+++', 'Splits & cassettes', 'Entretien de garde annuel', 'Recharge gaz rapide'],
                        'Location de Véhicules' => ['Flotte Toyota 4x4', 'Chauffeurs inclus', 'Assurance intégrale', 'SUV de luxe de direction'],
                        'Location Sonorisation' => ['Enceintes JBL', 'Micros HF Shure', 'Régie numérique complète', 'Techniciens de garde']
                    ];
                    
                    $tags = $serviceTags[$service->nom_service] ?? ['Prestation technique certifiée', 'Ingénierie de pointe'];
                @endphp

                <!-- Chaque colonne est animée avec décalage chronologique (Staggered Entrance) -->
                <div class="col-12 col-md-6 col-lg-4 animate-scroll-fade stagger-item">
                    <div class="card service-card-v2 border-light shadow-sm rounded-4 h-100 overflow-hidden">
                        
                        <div class="service-img-wrapper position-relative overflow-hidden">
                            <!-- Icône dynamique précise en glassmorphism -->
                            <div class="service-icon-absolute">
                                <i class="bi {{ $icon }}"></i>
                            </div>
                            
                            <!-- Image d'illustration -->
                            <img src="{{ asset($service->image) }}" class="img-fluid w-100 object-fit-cover transition-all duration-500" style="height: 200px;" alt="{{ $service->nom_service }}">
                            
                            <!-- Tarif indicatif dynamique -->
                            <span class="service-badge-v2">
                                @if($service->prix_indicatif > 0)
                                    À partir de {{ number_format($service->prix_indicatif, 0, ',', ' ') }} FCFA
                                @else
                                    {{ $service->unite }}
                                @endif
                            </span>
                        </div>
                        
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <h3 class="h5 fw-bold text-navy mb-2">{{ $service->nom_service }}</h3>
                                <p class="fs-8 text-muted mb-3 leading-relaxed">
                                    {{ $service->description }}
                                </p>
                                
                                <!-- Tags à pastilles -->
                                <div class="d-flex flex-wrap gap-1 mb-4">
                                    @foreach($tags as $tag)
                                        <span class="service-tag-pill">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center gap-3 border-top border-light pt-3 mt-auto">
                                <a href="{{ route('service.detail', \Illuminate\Support\Str::slug($service->nom_service)) }}" class="btn-fiche-technique">Fiche technique <i class="bi bi-arrow-right-short"></i></a>
                                <a href="{{ route('contact', ['service' => \Illuminate\Support\Str::slug($service->nom_service)]) }}" class="btn-devis-link">Devis <i class="bi bi-arrow-right-short"></i></a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5 animate-scroll-fade">
                    <i class="bi bi-folder-x fs-2 d-block mb-2"></i> Aucun service actif n'est présent dans le catalogue d'entreprise.
                </div>
            @endforelse

        </div>
    </div>

    <!-- Wave Divider : Services (Clair) -> Footer (Sombre) -->
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
.animate-scroll-fade.show {
    opacity: 1 !important;
    transform: translateY(0) !important;
}

/* Staggered Entrance Delay */
.stagger-item:nth-child(1) { transition-delay: 0.05s; }
.stagger-item:nth-child(2) { transition-delay: 0.12s; }
.stagger-item:nth-child(3) { transition-delay: 0.19s; }
.stagger-item:nth-child(4) { transition-delay: 0.26s; }
.stagger-item:nth-child(5) { transition-delay: 0.33s; }
.stagger-item:nth-child(6) { transition-delay: 0.40s; }
.stagger-item:nth-child(7) { transition-delay: 0.47s; }
.stagger-item:nth-child(8) { transition-delay: 0.54s; }

/* 2. Éléments du Hero au chargement de page */
.hero-load-animate {
    opacity: 0;
    transform: translateY(22px);
    animation: heroEntrance 1.1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes heroEntrance {
    to { opacity: 1; transform: translateY(0); }
}

/* 3. Micro-interactions au survol */
.service-card-v2 {
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
    border: 1px solid rgba(226, 232, 240, 0.6) !important;
}
.service-card-v2:hover {
    transform: translateY(-8px) !important;
    box-shadow: 0 25px 45px rgba(0, 210, 244, 0.12) !important;
    border-color: rgba(0, 210, 244, 0.2) !important;
}

/* Zoom de l'image (Ken Burns rapide) */
.service-img-wrapper img {
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
.service-card-v2:hover .service-img-wrapper img {
    transform: scale(1.06) !important;
}

/* Liaison icône absolue */
.service-icon-absolute {
    transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.3s ease;
}
.service-card-v2:hover .service-icon-absolute {
    transform: scale(1.1) rotate(6deg);
    background-color: #00D2F4 !important;
    color: #050E2D !important;
}

/* Boutons réactifs */
.btn-fiche-technique {
    transition: color 0.2s ease, transform 0.2s ease !important;
}
.btn-fiche-technique:hover {
    color: #00D2F4 !important;
    transform: translateX(2px) !important;
}

.btn-devis-link {
    transition: color 0.2s ease, transform 0.2s ease !important;
}
.btn-devis-link:hover {
    color: #1A3A8F !important;
    transform: translateX(2px) !important;
}
</style>

<!-- ========================================== -->
<!-- CODE MOTEUR DE DÉFILEMENT (INTERSECTION OBSERVER) -->
<!-- ========================================== -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    const scrollObserverOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.08
    };

    const scrollObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target); // Libère l'écouteur après affichage pour de meilleures performances
            }
        });
    }, scrollObserverOptions);

    document.querySelectorAll('.animate-scroll-fade').forEach(element => {
        scrollObserver.observe(element);
    });

});
</script>
@endsection