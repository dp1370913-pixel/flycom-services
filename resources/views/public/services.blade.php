@extends('layouts.public')

@section('title', 'Nos Services | Solutions Technologiques Professionnelles à Brazzaville')

@section('content')
<!-- SECTION HERO SERVICES -->
<section id="services-hero" class="hero-section d-flex align-items-center position-relative overflow-hidden">
    <div class="network-particles"></div>
    <div class="container py-4 py-md-5 z-2 position-relative text-center">
        
        <!-- Badge unifié -->
        <div class="custom-badge-pill mb-3">
            <span class="badge-dot"></span>
            <span>INGÉNIERIE &amp; LOGISTIQUE</span>
        </div>
        
        <h1 class="display-main-heading fw-extrabold text-white mb-3">Nos <span class="text-cyan text-decor-slash">Services</span></h1>
        <p class="lead text-light-muted max-w-md mx-auto fs-7 mb-4 px-2">
            Des solutions complètes pour sécuriser, connecter et optimiser votre environnement professionnel et personnel.
        </p>
    </div>
    
    <!-- Séparateur de vague -->
    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,32L60,42.7C120,53,240,75,360,80C480,85,600,75,720,64C840,53,960,43,1080,48C1200,53,1320,75,1380,85.3L1440,96L1440,120L1380,120C1320,120,1200,120,1080,120C960,120,840,120,720,120C600,120,480,120,360,120C240,120,120,120,60,120L0,120Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- GRILLE DES SERVICES DYNAMIQUE -->
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

                    // Mots-clés / Tags spécifiques
                    $serviceTags = [
                        'Réseaux Informatiques' => ['Câblage structuré', 'WiFi 6 entreprise', 'Firewall & sécurité', 'Monitoring 24/7'],
                        'Vidéosurveillance'     => ['Caméras 4K/8MP', 'Vision nocturne IR', 'Détection IA', 'Alertes temps réel'],
                        'Contrôle d\'accès'     => ['Biométrie empreinte', 'RFID/Mifare', 'Portes automatiques', 'Interphone vidéo'],
                        'Barbelé Électrique'    => ['Clôture active', 'Énergiseur', 'Sirène d\'alarme', 'Secours batterie'],
                        'Panneaux Solaires'     => ['Panneaux PERC', 'Onduleurs hybrides', 'Stockage lithium', 'Continuité 24h'],
                        'Climatisation'         => ['Inverter A+++', 'splits & cassettes', 'Entretien annuel', 'Recharge gaz'],
                        'Location de Véhicules' => ['Toyota 4x4', 'Chauffeur inclus', 'Assurance intégrale', 'SUV de luxe'],
                        'Location Sonorisation' => ['Enceintes JBL', 'Micros HF Shure', 'Régie numérique', 'Technicien inclus']
                    ];
                    
                    $tags = $serviceTags[$service->nom_service] ?? ['Service expert', 'Garantie Flycom'];
                @endphp

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card service-card-v2 border-light shadow-sm rounded-4 h-100">
                        <div class="service-img-wrapper">
                            <!-- Icône dynamique précise en glassmorphism -->
                            <div class="service-icon-absolute"><i class="bi {{ $icon }}"></i></div>
                            <img src="{{ asset($service->image) }}" class="img-fluid" alt="{{ $service->nom_service }}">
                            
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
                                
                                <!-- Tags -->
                                <div class="d-flex flex-wrap gap-1 mb-4">
                                    @foreach($tags as $tag)
                                        <span class="service-tag-pill">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center gap-3">
                                <a href="{{ route('service.detail', \Illuminate\Support\Str::slug($service->nom_service)) }}" class="btn-fiche-technique">Fiche technique <i class="bi bi-arrow-right-short"></i></a>
                                <a href="{{ route('contact', ['service' => \Illuminate\Support\Str::slug($service->nom_service)]) }}" class="btn-devis-link">Devis <i class="bi bi-arrow-right-short"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    Aucun service actif trouvé pour le moment.
                </div>
            @endforelse

        </div>
    </div>

    <!-- Séparateur de vague -->
    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" fill="#050E2D"></path>
        </svg>
    </div>
</section>
@endsection