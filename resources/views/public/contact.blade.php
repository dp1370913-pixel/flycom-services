@extends('layouts.public')

@section('title', 'Contactez-nous | Formulaire Devis Gratuit Flycom Services')

@section('content')
<!-- ========================================== -->
<!-- SECTION HERO DE CONTACT                    -->
<!-- ========================================== -->
<section id="contact-hero" class="hero-section d-flex align-items-center position-relative overflow-hidden">
    <div class="network-particles"></div>
    <div class="container py-4 py-md-5 z-2 position-relative text-center">
        <!-- Badge d'entrée cinématique -->
        <div class="hero-load-animate" style="animation-delay: 0.1s;">
            <div class="custom-badge-pill mb-3">
                <span class="badge-dot"></span>
                <span>Réponse sous 2h</span>
            </div>
        </div>
        
        <h1 class="display-main-heading fw-extrabold text-white mb-3 hero-load-animate" style="animation-delay: 0.3s; line-height: 1.15;">Contactez-<span class="text-cyan">nous</span></h1>
        <p class="lead text-light-muted max-w-md mx-auto fs-7 mb-4 px-2 hero-load-animate" style="animation-delay: 0.5s;">
            Une question, un projet d'ingénierie ou besoin d'un devis ? Notre équipe vous répond en moins de 2 heures ouvrées.
        </p>
    </div>
    
    <!-- Séparateur de vague cinématique -->
    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,32L60,42.7C120,53,240,75,360,80C480,85,600,75,720,64C840,53,960,43,1080,48C1200,53,1320,75,1380,85.3L1440,96L1440,120L1380,120C1320,120,1200,120,1080,120C960,120,840,120,720,120C600,120,480,120,360,120C240,120,120,120,60,120L0,120Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- ========================================== -->
<!-- SECTION PRINCIPALE DES COORDONNÉES ET FORMULAIRE -->
<!-- ========================================== -->
<section class="contact-main-section bg-white text-navy position-relative">
    <div class="container py-2">
        
        <!-- Alerte de succès de Laravel (M2 - UX) -->
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 p-3.5 mb-5 text-start d-flex align-items-center gap-2 animate-scroll-fade show" style="background-color: #ECFDF5; border: 1px solid #10B981 !important; color: #064E3B;">
                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                <span class="fs-8 fw-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="row g-5 align-items-stretch">
            
            <!-- BLOC DE GAUCHE : COORDONNÉES (Glisse depuis la gauche) -->
            <div class="col-12 col-lg-5 animate-scroll-fade slide-left">
                <h2 class="h3 fw-extrabold mb-2 text-navy">Nos coordonnées</h2>
                <p class="text-muted fs-8 mb-4">Visitez-nous à notre bureau de La Glacière ou contactez-nous directement.</p>
                
                <div class="d-flex flex-column gap-3">
                    
                    <!-- Carte Adresse -->
                    <div class="contact-info-card d-flex align-items-start gap-3 p-3 rounded-4 bg-white shadow-sm border border-light">
                        <div class="icon-box-navy">
                            <i class="bi bi-geo-alt-fill text-white"></i>
                        </div>
                        <div>
                            <span class="d-block fs-9 text-cyan fw-bold text-uppercase tracking-wider mb-1">Adresse</span>
                            <span class="fs-8 fw-semibold text-navy leading-relaxed">22, Avenue de Brazza — La Glacière, Brazzaville, Congo</span>
                        </div>
                    </div>
                    
                    <!-- Carte Téléphone -->
                    <div class="contact-info-card d-flex align-items-start gap-3 p-3 rounded-4 bg-white shadow-sm border border-light">
                        <div class="icon-box-navy">
                            <i class="bi bi-telephone-fill text-white"></i>
                        </div>
                        <div>
                            <span class="d-block fs-9 text-cyan fw-bold text-uppercase tracking-wider mb-1">Téléphone</span>
                            <span class="fs-8 fw-semibold text-navy d-block mb-1">06 628 57 41</span>
                            <span class="fs-8 fw-semibold text-navy d-block">04 411 80 78</span>
                        </div>
                    </div>
                    
                    <!-- Carte Email -->
                    <div class="contact-info-card d-flex align-items-start gap-3 p-3 rounded-4 bg-white shadow-sm border border-light">
                        <div class="icon-box-navy">
                            <i class="bi bi-envelope-fill text-white"></i>
                        </div>
                        <div>
                            <span class="d-block fs-9 text-cyan fw-bold text-uppercase tracking-wider mb-1">Email</span>
                            <span class="fs-8 fw-semibold text-navy">contact@flycomservices.cg</span>
                        </div>
                    </div>
                    
                    <!-- Carte Horaires -->
                    <div class="contact-info-card d-flex align-items-start gap-3 p-3 rounded-4 bg-white shadow-sm border border-light">
                        <div class="icon-box-navy">
                            <i class="bi bi-clock-fill text-white"></i>
                        </div>
                        <div>
                            <span class="d-block fs-9 text-cyan fw-bold text-uppercase tracking-wider mb-1">Horaires</span>
                            <span class="fs-8 fw-semibold text-navy d-block mb-1">Lun - Ven : 8h00 - 18h00</span>
                            <span class="fs-8 text-muted d-block">Sam : 9h00 - 14h00</span>
                        </div>
                    </div>
                    
                    <!-- Carte WhatsApp Direct -->
                    <a href="https://wa.me/242066285741" target="_blank" class="contact-info-card whatsapp-card d-flex align-items-center gap-3 p-3 rounded-4 bg-white shadow-sm border border-light text-decoration-none transition-all">
                        <div class="icon-box-green">
                            <i class="bi bi-whatsapp text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <span class="d-block fs-9 text-success fw-bold text-uppercase tracking-wider mb-1">WhatsApp Direct</span>
                            <span class="fs-8 fw-semibold text-navy">Discuter maintenant avec un conseiller</span>
                        </div>
                    </a>

                </div>
            </div>

            <!-- BLOC DE DROITE : FORMULAIRE GLACÉ (Glisse depuis la droite) -->
            <div class="col-12 col-lg-7 animate-scroll-fade slide-right">
                <div class="contact-form-card rounded-4 p-4 p-md-5">
                    <form action="{{ route('contact.store') }}" method="POST" class="row g-3" id="publicContactForm">
                        @csrf
                        
                        <div class="col-md-6">
                            <label for="inputName" class="form-label fs-8 fw-bold text-navy text-uppercase">Nom *</label>
                            <input type="text" name="nom" class="form-control" id="inputName" placeholder="Votre nom" required style="box-shadow: none !important;">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPrename" class="form-label fs-8 fw-bold text-navy text-uppercase">Prénom *</label>
                            <input type="text" name="prenom" class="form-control" id="inputPrename" placeholder="Votre prénom" required style="box-shadow: none !important;">
                        </div>
                        
                        <div class="col-12">
                            <label for="inputEmail" class="form-label fs-8 fw-bold text-navy text-uppercase">Email</label>
                            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="votre@email.com" style="box-shadow: none !important;">
                        </div>
                        
                        <div class="col-12">
                            <label for="inputPhone" class="form-label fs-8 fw-bold text-navy text-uppercase">Téléphone *</label>
                            <input type="tel" name="telephone" class="form-control" id="inputPhone" placeholder="+242 06 XXX XX XX" required style="box-shadow: none !important;">
                        </div>
                        
                        <!-- MULTI-SÉLECTION DE SERVICES TECHNIQUE (Checkboxes de type boutons - Nouveau) -->
                        <div class="col-12">
                            <label class="form-label fs-8 fw-bold text-navy text-uppercase mb-2">Services souhaités * <span class="text-muted fw-normal text-lowercase">(Sélectionnez une ou plusieurs prestations)</span></label>
                            
                            <div class="row g-2">
                                @php
                                    // Requête autonome pour récupérer les services actifs en base (MLD)
                                    $availableServices = \App\Models\Service::where('actif', true)->orderBy('nom_service')->get();
                                    $requestedServiceSlug = request('service');
                                @endphp

                                @foreach($availableServices as $service)
                                    @php
                                        // Vérifier si ce service doit être coché d'office (ex : redirection depuis "Devis" sur fiche technique)
                                        $isPrechecked = $requestedServiceSlug === \Illuminate\Support\Str::slug($service->nom_service);
                                    @endphp
                                    <div class="col-12 col-sm-6">
                                        <div class="form-check p-2.5 rounded-3 border border-light-subtle bg-light d-flex align-items-center gap-2 hover-lift-subtle" style="transition: all 0.2s ease;">
                                            <input class="form-check-input ms-1 public-service-cb" type="checkbox" name="services_concernes[]" value="{{ $service->id_service }}" id="publicSvc{{ $service->id_service }}" style="width:18px; height:18px; accent-color: #1A3A8F;" {{ $isPrechecked ? 'checked' : '' }}>
                                            <label class="form-check-label text-truncate text-navy fw-semibold" style="font-size: 0.8rem; cursor: pointer; user-select: none;" for="publicSvc{{ $service->id_service }}">
                                                {{ $service->nom_service }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <span class="text-danger fs-9 d-none mt-1.5" id="servicesRequiredAlert"><i class="bi bi-exclamation-circle-fill"></i> Veuillez sélectionner au moins une prestation d'ingénierie.</span>
                        </div>
                        
                        <div class="col-12">
                            <label for="inputMessage" class="form-label fs-8 fw-bold text-navy text-uppercase">Message *</label>
                            <textarea name="message" class="form-control" id="inputMessage" rows="4" placeholder="Décrivez brièvement votre projet ou votre besoin..." required style="box-shadow: none !important;"></textarea>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn-royal-blue w-100 py-3 text-white fw-bold border-0 hover-lift shadow-sm" id="btnSubmitContact">
                                Envoyer ma demande <i class="bi bi-send-fill ms-1"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- CARTE INTERACTIVE GOOGLE MAPS -->
        <div class="row mt-5">
            <div class="col-12 animate-scroll-fade">
                <div class="map-wrapper rounded-4 overflow-hidden shadow-sm border border-light p-1 bg-white hover-lift-subtle" style="transition: all 0.4s ease;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15914.341147573673!2d15.2647716183951!3d-4.263435422453676!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a6a3b2b8006bf2b%3A0xe54e66285741e54e!2sAvenue%20Savorgnan%20de%20Brazza%2C%20Brazzaville!5e0!3m2!1sfr!2scg!4v1716574300000!5m2!1sfr!2scg" 
                        width="100%" 
                        height="450" 
                        style="border:0; display: block;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Localisation de Flycom Services à Brazzaville">
                    </iframe>
                </div>
            </div>
        </div>

    </div>

    <!-- Wave Divider : Contenu (Clair) -> Footer (Sombre) -->
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
    transform: translateX(-40px);
}
.animate-scroll-fade.slide-right {
    transform: translateX(40px);
}
.animate-scroll-fade.show {
    opacity: 1 !important;
    transform: translate(0) !important;
}

/* 2. Éléments du Hero au chargement de page */
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

/* 3. Micro-interactions et élévations au survol */
.contact-info-card {
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.2s ease !important;
    border: 1px solid rgba(226, 232, 240, 0.5) !important;
}
.contact-info-card:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 10px 25px rgba(13, 27, 75, 0.04) !important;
    border-color: rgba(0, 210, 244, 0.25) !important;
}

.whatsapp-card {
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
.whatsapp-card:hover {
    transform: translateY(-5px) scale(1.02) !important;
    box-shadow: 0 15px 30px rgba(25, 135, 84, 0.15) !important;
    border-color: rgba(25, 135, 84, 0.3) !important;
}

.contact-form-card {
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(226, 232, 240, 0.8);
}
.contact-form-card:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 25px 50px rgba(13, 27, 75, 0.08) !important;
}

.btn-royal-blue {
    background-color: #1A3A8F !important;
    transition: transform 0.25s ease, box-shadow 0.25s ease, opacity 0.2s ease !important;
}
.btn-royal-blue:hover {
    transform: translateY(-3px) !important;
    box-shadow: 0 10px 25px rgba(26, 58, 143, 0.35) !important;
}

.hover-lift-subtle:hover {
    transform: translateY(-3px) !important;
    border-color: rgba(0, 210, 244, 0.3) !important;
    box-shadow: 0 5px 15px rgba(0, 210, 244, 0.04);
}

/* Éléments de structure d'icônes */
.icon-box-navy {
    background-color: #0D1B4B;
    border-radius: 12px;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.icon-box-green {
    background-color: #198754;
    border-radius: 12px;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
</style>

<!-- ========================================== -->
<!-- CODE MOTEUR JAVASCRIPT                     -->
<!-- ========================================== -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    // 1. MOTEUR DE DÉFILEMENT (INTERSECTION OBSERVER)
    const scrollObserverOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.08
    };

    const scrollObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target);
            }
        });
    }, scrollObserverOptions);

    document.querySelectorAll('.animate-scroll-fade').forEach(element => {
        scrollObserver.observe(element);
    });

    // 2. SÉCURITÉ DE VALIDATION DU FORMULAIRE (S'assure qu'au moins un service est coché)
    const contactForm = document.getElementById('publicContactForm');
    const serviceAlert = document.getElementById('servicesRequiredAlert');

    if (contactForm && serviceAlert) {
        contactForm.addEventListener('submit', (e) => {
            const checkedBoxes = document.querySelectorAll('.public-service-cb:checked');
            
            if (checkedBoxes.length === 0) {
                e.preventDefault(); // Bloque la soumission
                serviceAlert.classList.remove('d-none'); // Affiche l'alerte
                serviceAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                serviceAlert.classList.add('d-none');
            }
        });

        // Masquer l'alerte dès qu'un service est coché
        document.querySelectorAll('.public-service-cb').forEach(cb => {
            cb.addEventListener('change', () => {
                const checkedBoxes = document.querySelectorAll('.public-service-cb:checked');
                if (checkedBoxes.length > 0) {
                    serviceAlert.classList.add('d-none');
                }
            });
        });
    }

});
</script>
@endsection