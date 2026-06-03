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
    
    <!-- Séparateur de vague : Hero (Sombre) -> Contenu (Clair) -->
    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,32L60,42.7C120,53,240,75,360,80C480,85,600,75,720,64C840,53,960,43,1080,48C1200,53,1320,75,1380,85.3L1440,96L1440,120L1380,120C1320,120,1200,120,1080,120C960,120,840,120,720,120C600,120,480,120,360,120C240,120,120,120,60,120L0,120Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- GRILLE EXHAUSTIVE DES 8 SERVICES (Fidèle à l'image) -->
<section class="services-main-section bg-white text-navy position-relative">
    <div class="container py-2">
        <div class="row g-4 justify-content-center">
            
            <!-- Service 1 : Réseaux Informatiques -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card service-card-v2 border-light shadow-sm rounded-4 h-100">
                    <div class="service-img-wrapper">
                        <div class="service-icon-absolute"><i class="bi bi-wifi"></i></div>
                        <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=500&q=80" class="img-fluid" alt="Réseaux">
                        <span class="service-badge-v2">Sur devis</span>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold text-navy mb-2">Réseaux Informatiques</h3>
                        <p class="fs-8 text-muted mb-3 leading-relaxed">
                            Nous déployons des infrastructures réseau de pointe : câblage structuré Cat6/Cat6A, switches managés, points d'accès WiFi 6/6E, VLAN segmentation, firewall et monitoring 24/7. De l'audit à la maintenance, nous garantissons une connectivité fiable et sécurisée.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="service-tag-pill">Câblage structuré</span>
                            <span class="service-tag-pill">WiFi 6 entreprise</span>
                            <span class="service-tag-pill">Firewall &amp; sécurité</span>
                            <span class="service-tag-pill">Monitoring 24/7</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('service.detail', 'reseaux-informatiques') }}" class="btn-fiche-technique">Fiche technique </a>
                            <a href="{{ route('contact', ['service' => 'reseau']) }}" class="btn-devis-link">Devis </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 2 : Vidéosurveillance -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card service-card-v2 border-light shadow-sm rounded-4 h-100">
                    <div class="service-img-wrapper">
                        <div class="service-icon-absolute"><i class="bi bi-camera-video"></i></div>
                        <img src="https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=500&q=80" class="img-fluid" alt="Vidéosurveillance">
                        <span class="service-badge-v2">À partir de 150 000 FCFA</span>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold text-navy mb-2">Vidéosurveillance</h3>
                        <p class="fs-8 text-muted mb-3 leading-relaxed">
                            Systèmes de vidéosurveillance intelligents : caméras 4K/8MP, vision nocturne infrarouge jusqu'à 50m, détection IA (humain/véhicule), alertes temps réel sur smartphone, stockage cloud ou NVR local. Installation discrète et professionnelle.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="service-tag-pill">Caméras 4K/8MP</span>
                            <span class="service-tag-pill">Vision nocturne IR</span>
                            <span class="service-tag-pill">Détection IA</span>
                            <span class="service-tag-pill">Alertes temps réel</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('service.detail', 'videosurveillance') }}" class="btn-fiche-technique">Fiche technique </a>
                            <a href="{{ route('contact', ['service' => 'videosurveillance']) }}" class="btn-devis-link">Devis </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 3 : Contrôle d'Accès -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card service-card-v2 border-light shadow-sm rounded-4 h-100">
                    <div class="service-img-wrapper">
                        <div class="service-icon-absolute"><i class="bi bi-fingerprint"></i></div>
                        <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=500&q=80" class="img-fluid" alt="Accès">
                        <span class="service-badge-v2">À partir de 200 000 FCFA</span>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold text-navy mb-2">Contrôle d'Accès</h3>
                        <p class="fs-8 text-muted mb-3 leading-relaxed">
                            Sécurisez l'accès à vos locaux avec nos solutions avancées : lecteurs biométriques d'empreintes et faciaux, badges RFID/Mifare, portes automatiques avec détecteurs de présence, interphones vidéo avec enregistrement, gestion centralisée des accès par badge.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="service-tag-pill">Biométrie empreinte</span>
                            <span class="service-tag-pill">RFID/Mifare</span>
                            <span class="service-tag-pill">Portes automatiques</span>
                            <span class="service-tag-pill">Interphone vidéo</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('service.detail', 'controle-dacces') }}" class="btn-fiche-technique">Fiche technique</a>
                            <a href="{{ route('contact', ['service' => 'acces']) }}" class="btn-devis-link">Devis </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 4 : Barbelé Électrique -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card service-card-v2 border-light shadow-sm rounded-4 h-100">
                    <div class="service-img-wrapper">
                        <div class="service-icon-absolute"><i class="bi bi-lightning-fill"></i></div>
                        <img src="https://images.unsplash.com/photo-1508873535684-277a3cbcc4e8?auto=format&fit=crop&w=500&q=80" class="img-fluid" alt="Barbelé">
                        <span class="service-badge-v2">Sur devis</span>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold text-navy mb-2">Barbelé Électrique</h3>
                        <p class="fs-8 text-muted mb-3 leading-relaxed">
                            Mettez en place une barrière de protection périmétrique infranchissable. Pose d'un câblage sous haute tension non létale reliée à un système d'alarme sonore de sécurité.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="service-tag-pill">Impulsion 10 000V</span>
                            <span class="service-tag-pill">Détection de coupe</span>
                            <span class="service-tag-pill">Alarme sonore</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('service.detail', 'barbele-electrique') }}" class="btn-fiche-technique">Fiche technique</a>
                            <a href="{{ route('contact', ['service' => 'barbele']) }}" class="btn-devis-link">Devis </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 5 : Panneaux Solaires -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card service-card-v2 border-light shadow-sm rounded-4 h-100">
                    <div class="service-img-wrapper">
                        <div class="service-icon-absolute"><i class="bi bi-sun-fill"></i></div>
                        <img src="https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=500&q=80" class="img-fluid" alt="Solaire">
                        <span class="service-badge-v2">À partir de 950 000 FCFA</span>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold text-navy mb-2">Panneaux Solaires</h3>
                        <p class="fs-8 text-muted mb-3 leading-relaxed">
                            Solutions de transition et de secours énergétique. Systèmes solaires photovoltaïques autonomes ou hybrides avec batteries intelligentes pour assurer une autonomie totale.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="service-tag-pill">Panneaux PERC</span>
                            <span class="service-tag-pill">Onduleurs hybrides</span>
                            <span class="service-tag-pill">Stockage lithium</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('service.detail', 'panneaux-solaires') }}" class="btn-fiche-technique">Fiche technique </a>
                            <a href="{{ route('contact', ['service' => 'solaire']) }}" class="btn-devis-link">Devis</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 6 : Climatisation -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card service-card-v2 border-light shadow-sm rounded-4 h-100">
                    <div class="service-img-wrapper">
                        <div class="service-icon-absolute"><i class="bi bi-wind"></i></div>
                        <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&w=500&q=80" class="img-fluid" alt="Climatisation">
                        <span class="service-badge-v2">À partir de 80 000 FCFA</span>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold text-navy mb-2">Climatisation</h3>
                        <p class="fs-8 text-muted mb-3 leading-relaxed">
                            Installation de splits, de cassettes et de gainables de régulation thermique. Nos techniciens gèrent la pose, la recharge en gaz et le nettoyage périodique.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="service-tag-pill">Inverter A+++</span>
                            <span class="service-tag-pill">Gaz R32</span>
                            <span class="service-tag-pill">SAV &amp; Entretien</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('service.detail', 'climatisation') }}" class="btn-fiche-technique">Fiche technique </a>
                            <a href="{{ route('contact', ['service' => 'climatisation']) }}" class="btn-devis-link">Devis</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 7 : Location de Véhicules -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card service-card-v2 border-light shadow-sm rounded-4 h-100">
                    <div class="service-img-wrapper">
                        <div class="service-icon-absolute"><i class="bi bi-car-front-fill"></i></div>
                        <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=500&q=80" class="img-fluid" alt="Véhicules">
                        <span class="service-badge-v2">À partir de 35 000 FCFA/j</span>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold text-navy mb-2">Location de Véhicules</h3>
                        <p class="fs-8 text-muted mb-3 leading-relaxed">
                            Mise à disposition de SUV et 4x4 robustes d'intervention tout-terrain récents, louables à la journée ou au mois avec ou sans chauffeur.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="service-tag-pill">Toyota 4x4</span>
                            <span class="service-tag-pill">Chauffeur inclus</span>
                            <span class="service-tag-pill">Assurance intégrale</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('service.detail', 'location-de-vehicules') }}" class="btn-fiche-technique">Fiche technique</a>
                            <a href="{{ route('contact', ['service' => 'location']) }}" class="btn-devis-link">Devis </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 8 : Location Sonorisation -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card service-card-v2 border-light shadow-sm rounded-4 h-100">
                    <div class="service-img-wrapper">
                        <div class="service-icon-absolute"><i class="bi bi-volume-up-fill"></i></div>
                        <img src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=500&q=80" class="img-fluid" alt="Sonorisation">
                        <span class="service-badge-v2">À partir de 50 000 FCFA/j</span>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold text-navy mb-2">Location Sonorisation</h3>
                        <p class="fs-8 text-muted mb-3 leading-relaxed">
                            Mise à disposition de packs de sonorisation professionnels pour événements d'envergure, conférences d'entreprise ou réceptions de mariage.
                        </p>
                        <div class="d-flex flex-wrap gap-1 mb-4">
                            <span class="service-tag-pill">Enceintes JBL</span>
                            <span class="service-tag-pill">Micros HF Shure</span>
                            <span class="service-tag-pill">Technicien inclus</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('service.detail', 'location-sonorisation') }}" class="btn-fiche-technique">Fiche technique </a>
                            <a href="{{ route('contact', ['service' => 'sonorisation']) }}" class="btn-devis-link">Devis </a>
                        </div>
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