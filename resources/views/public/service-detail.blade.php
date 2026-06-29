@extends('layouts.public')

@section('title', 'Fiche Technique — ' . $service['title'] . ' | Flycom Services')

@section('content')
<!-- SECTION HERO DE LA FICHE TECHNIQUE -->
<section class="hero-section d-flex align-items-center position-relative overflow-hidden">
    <div class="network-particles"></div>
    <div class="container py-4 py-md-5 z-2 position-relative text-center text-lg-start">
        <div class="row align-items-center g-5">
            <div class="col-12 col-lg-7">
                <!-- Badge unifié conforme -->
                <div class="custom-badge-pill mb-3">
                    <span class="badge-dot"></span>
                    <span>{{ $service['badge_category'] }}</span>
                </div>
                
                <h1 class="display-main-heading fw-extrabold text-white mb-3">{{ $service['title'] }}</h1>
                <p class="lead text-light-muted fs-7 mb-4">
                    {{ $service['short_desc'] }}
                </p>
                
                <!-- Double Badge sous la description (Image 1 - Espacement pixel-perfect) -->
                <div class="badge-container-v2">
                    <span class="service-badge-v2 position-relative" style="text-decoration: none;">{{ $service['price_badge'] }}</span>
                </div>
            </div>
            <div class="col-12 col-lg-5 d-none d-lg-block">
                <div class="hero-image-overlay rounded-4 shadow-lg overflow-hidden border border-navy-light">
                    <img src="{{ $service['image'] }}" alt="{{ $service['title'] }}" class="img-fluid hero-img">
                    <div class="overlay-dark-blue"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wave Divider : Hero (Sombre) -> Contenu (Clair) -->
    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,32L60,42.7C120,53,240,75,360,80C480,85,600,75,720,64C840,53,960,43,1080,48C1200,53,1320,75,1380,85.3L1440,96L1440,120L1380,120C1320,120,1200,120,1080,120C960,120,840,120,720,120C600,120,480,120,360,120C240,120,120,120,60,120L0,120Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- SECTION INFOS ET FORMULAIRE LATÉRAL GLACÉ -->
<section class="py-5 bg-white text-navy position-relative">
    <div class="container py-4">
        
        <!-- Zone d'affichage de la notification de succès verte de Laravel (M2 - UX) -->
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 p-3.5 mb-4 text-start d-flex align-items-center gap-2" style="background-color: #ECFDF5; border: 1px solid #10B981 !important; color: #064E3B;">
                <i class="bi bi-check-circle-fill fs-5 text-success" style="color: #10B981 !important;"></i>
                <span class="fs-8 fw-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="row g-5">
            
            <!-- CONTENU DE GAUCHE : INFOS PRATIQUES (Marques retirées conformément) -->
            <div class="col-12 col-lg-7">
                <h2 class="h3 fw-extrabold text-navy mb-3">Description détaillée</h2>
                <p class="text-muted fs-7 leading-relaxed mb-5">{{ $service['long_desc'] }}</p>
                
                <!-- Notre Méthodologie (4 Blocs) -->
                <h3 class="h5 fw-bold text-navy mb-4">Notre méthodologie</h3>
                <div class="row g-3 mb-5">
                    @foreach($service['methodology'] as $num => $step)
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-4 border border-light h-100 d-flex gap-3 align-items-start">
                            <span class="step-badge-number">{{ $num }}</span>
                            <div>
                                <h4 class="h7 fw-bold text-navy mb-1">{{ $step['title'] }}</h4>
                                <p class="fs-8 text-muted mb-0 leading-relaxed">{{ $step['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Points Forts (Pills avec checkmark) -->
                <h3 class="h5 fw-bold text-navy mb-3">Points forts</h3>
                <div class="d-flex gap-2 flex-wrap mb-0">
                    @foreach($service['strengths'] as $strength)
                        <span class="badge rounded-pill bg-light text-navy border border-light-subtle px-3 py-2 fw-semibold fs-9 mb-2"><i class="bi bi-patch-check-fill text-cyan me-1"></i> {{ $strength }}</span>
                    @endforeach
                </div>
            </div>

            <!-- BLOC DE DROITE : FORMULAIRE GLACÉ (Image demandée et raccordement CRM) -->
            <div class="col-12 col-lg-5">
                <div class="contact-form-card rounded-4 p-4">
                    <!-- Raccordement à la route POST de réception (Flux Métier 1) -->
                    <form action="{{ route('contact.store') }}" method="POST" class="row g-3 text-start">
                        @csrf
                        
                        <!-- Injection dynamique du service d'intérêt pour la liaison lead_services (MLD) -->
                        <input type="hidden" name="id_service" value="{{ $service['contact_param'] }}">
                        
                        <!-- Champs Nom & Prénom dissociés pour être conformes au CRM -->
                        <div class="col-12">
                            <label class="form-label fs-8 fw-bold text-navy text-uppercase">Nom *</label>
                            <input type="text" name="nom" class="form-control" placeholder="Votre nom de famille" required style="box-shadow: none !important;">
                        </div>
                        <div class="col-12">
                            <label class="form-label fs-8 fw-bold text-navy text-uppercase">Prénom *</label>
                            <input type="text" name="prenom" class="form-control" placeholder="Votre prénom" required style="box-shadow: none !important;">
                        </div>
                        <div class="col-12">
                            <label class="form-label fs-8 fw-bold text-navy text-uppercase">Téléphone *</label>
                            <input type="tel" name="telephone" class="form-control" placeholder="06 XX XX XX" required style="box-shadow: none !important;">
                        </div>
                        <div class="col-12">
                            <label class="form-label fs-8 fw-bold text-navy text-uppercase">Email</label>
                            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="votre@email.com">
                        </div>
                        
                        <!-- Message -->
                        <div class="col-12">
                            <label class="form-label fs-8 fw-bold text-navy text-uppercase">Message</label>
                            <textarea name="message" class="form-control" rows="4" placeholder="Décrivez votre besoin..." required style="box-shadow: none !important;"></textarea>
                        </div>
                        <div class="col-12">
                            <!-- Bouton en bleu royal complet avec icône -->
                            <button type="submit" class="btn-royal-blue rounded-3 py-3 w-100 fs-8 fw-bold">
                                Envoyer la demande <i class="bi bi-send-fill ms-1"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION RECOMMANDATION -->
<section class="py-5 bg-navy-dark text-white position-relative overflow-hidden" style="padding-bottom: 120px !important;">
    <div class="network-particles"></div>
    <div class="container position-relative z-2">
        <div class="row g-4 justify-content-between mb-5">
            <div class="col-12 text-center">
                <h2 class="display-main-heading fw-extrabold text-white mb-3">Découvrez nos <span class="text-cyan">autres services</span></h2>
                <p class="max-w-md mx-auto fs-7 mb-4 text-light-muted px-2">
                    Flycom Services couvre 8 domaines d'expertise pour répondre à tous vos besoins technologiques.
                </p>

                <!-- Boutons d'action -->
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                    <a href="{{ route('services') }}" class="btn btn-cyan btn-lg rounded-pill px-5 py-3 fw-bold fs-7 text-decoration-none">
                        Voir tous les services
                    </a>
                    <a href="https://wa.me/242066285741" target="_blank" class="btn btn-outline-light-custom btn-lg rounded-pill px-5 py-3 fw-bold fs-7 text-decoration-none">
                        <i class="bi bi-whatsapp text-success me-2"></i> Contacter sur WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection