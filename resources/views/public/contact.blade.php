@extends('layouts.public')

@section('title', 'Contactez-nous | Formulaire Devis Gratuit Flycom Services')

@section('content')
<!-- SECTION HERO DE CONTACT -->
<section id="contact-hero" class="hero-section d-flex align-items-center position-relative overflow-hidden">
    <div class="network-particles"></div>
    <div class="container py-4 py-md-5 z-2 position-relative text-center">
    <div class="custom-badge-pill mb-3">
            <span class="badge-dot"></span>
            <span>Réponse sous 2h</span>
    </div>
        <h1 class="display-main-heading fw-extrabold text-white mb-3">Contactez-<span class="text-cyan">nous</span></h1>
        <p class="lead text-light-muted max-w-md mx-auto fs-7 mb-4 px-2">
            Une question, un projet ou besoin d'un devis ? Notre équipe vous répond en moins de 2 heures ouvrées.
        </p>
    </div>
    
    <!-- Séparateur de vague créatif de transition Hero (Sombre) -> Contenu (Clair) -->
    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,32L60,42.7C120,53,240,75,360,80C480,85,600,75,720,64C840,53,960,43,1080,48C1200,53,1320,75,1380,85.3L1440,96L1440,120L1380,120C1320,120,1200,120,1080,120C960,120,840,120,720,120C600,120,480,120,360,120C240,120,120,120,60,120L0,120Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- SECTION PRINCIPALE DES COORDONNÉES ET FORMULAIRE -->
<section class="contact-main-section bg-white text-navy position-relative">
    <div class="container py-2">
        
        <!-- Zone d'affichage de la notification de succès verte de Laravel (M2 - UX) -->
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 p-3.5 mb-4 text-start d-flex align-items-center gap-2" style="background-color: #ECFDF5; border: 1px solid #10B981 !important; color: #064E3B;">
                <i class="bi bi-check-circle-fill fs-5 text-success" style="color: #10B981 !important;"></i>
                <span class="fs-8 fw-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="row g-5 align-items-stretch">
            
            <!-- BLOC DE GAUCHE : COORDONNÉES (STYLÉ EXACTEMENT COMME DEMANDÉ) -->
            <div class="col-12 col-lg-5">
                <h2 class="h3 fw-extrabold mb-2 text-navy">Nos coordonnées</h2>
                <p class="text-muted fs-8 mb-4">Visitez-nous à notre bureau de La Glacière ou contactez-nous directement.</p>
                
                <div class="d-flex flex-column gap-3">
                    
                    <!-- Carte Adresse -->
                    <div class="contact-info-card">
                        <div class="icon-box-navy">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <span class="d-block fs-9 text-cyan fw-bold text-uppercase tracking-wider mb-1">Adresse</span>
                            <span class="fs-8 fw-semibold text-navy leading-relaxed">22, Avenue de Brazza — La Glacière, Brazzaville, Congo</span>
                        </div>
                    </div>
                    
                    <!-- Carte Téléphone -->
                    <div class="contact-info-card">
                        <div class="icon-box-navy">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div>
                            <span class="d-block fs-9 text-cyan fw-bold text-uppercase tracking-wider mb-1">Téléphone</span>
                            <span class="fs-8 fw-semibold text-navy d-block mb-1">06 628 57 41</span>
                            <span class="fs-8 fw-semibold text-navy d-block">04 411 80 78</span>
                        </div>
                    </div>
                    
                    <!-- Carte Email -->
                    <div class="contact-info-card">
                        <div class="icon-box-navy">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div>
                            <span class="d-block fs-9 text-cyan fw-bold text-uppercase tracking-wider mb-1">Email</span>
                            <span class="fs-8 fw-semibold text-navy">contact@flycomservices.cg</span>
                        </div>
                    </div>
                    
                    <!-- Carte Horaires -->
                    <div class="contact-info-card">
                        <div class="icon-box-navy">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <div>
                            <span class="d-block fs-9 text-cyan fw-bold text-uppercase tracking-wider mb-1">Horaires</span>
                            <span class="fs-8 fw-semibold text-navy d-block mb-1">Lun - Ven : 8h00 - 18h00</span>
                            <span class="fs-8 text-muted d-block">Sam : 9h00 - 14h00</span>
                        </div>
                    </div>
                    
                    <!-- Carte WhatsApp Direct -->
                    <a href="https://wa.me/242066285741" target="_blank" class="contact-info-card whatsapp-card text-decoration-none transition-all">
                        <div class="icon-box-green">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <div class="flex-grow-1">
                            <span class="d-block fs-9 text-success fw-bold text-uppercase tracking-wider mb-1">WhatsApp Direct</span>
                            <span class="fs-8 fw-semibold text-navy">Discuter maintenant avec notre équipe</span>
                        </div>

                    </a>

                </div>
            </div>

            <!-- BLOC DE DROITE : FORMULAIRE GLACÉ (Image demandée) -->
            <div class="col-12 col-lg-7">
                <div class="contact-form-card rounded-4 p-4 p-md-5">
                    <!-- Liaison d'action sécurisée de l'API (M2 - CRM) -->
                    <form action="{{ route('contact.store') }}" method="POST" class="row g-3">
                        @csrf
                        
                        <!-- Ligne Nom & Prénom -->
                        <div class="col-md-6">
                            <label for="inputName" class="form-label fs-8 fw-bold text-navy text-uppercase">Nom</label>
                            <input type="text" name="nom" class="form-control" id="inputName" placeholder="Votre nom" required>
                        </div>
                        <div class="col-md-6">
                            <label for="inputPrename" class="form-label fs-8 fw-bold text-navy text-uppercase">Prénom</label>
                            <input type="text" name="prenom" class="form-control" id="inputPrename" placeholder="Votre prénom" required>
                        </div>
                        
                        <!-- Email -->
                        <div class="col-12">
                            <label for="inputEmail" class="form-label fs-8 fw-bold text-navy text-uppercase">Email</label>
                            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="votre@email.com">
                        </div>
                        
                        <!-- Téléphone -->
                        <div class="col-12">
                            <label for="inputPhone" class="form-label fs-8 fw-bold text-navy text-uppercase">Téléphone</label>
                            <input type="tel" name="telephone" class="form-control" id="inputPhone" placeholder="+242 06 XXX XX XX" required>
                        </div>
                        
                        <!-- Service Concerné (Mapped avec id_service pour le contrôleur) -->
                        <div class="col-12">
                            <label for="inputService" class="form-label fs-8 fw-bold text-navy text-uppercase">Service concerné</label>
                            <select name="id_service" id="inputService" class="form-select" required>
                                <option value="" selected disabled>Choisir un service...</option>
                                <option value="reseau" {{ request('service') == 'reseau' ? 'selected' : '' }}>Réseaux Informatiques</option>
                                <option value="videosurveillance" {{ request('service') == 'videosurveillance' ? 'selected' : '' }}>Vidéosurveillance</option>
                                <option value="acces" {{ request('service') == 'acces' ? 'selected' : '' }}>Contrôle d'Accès</option>
                                <option value="barbele" {{ request('service') == 'barbele' ? 'selected' : '' }}>Barbelé Électrique</option>
                                <option value="solaire" {{ request('service') == 'solaire' ? 'selected' : '' }}>Panneaux Solaires</option>
                                <option value="climatisation" {{ request('service') == 'climatisation' ? 'selected' : '' }}>Climatisation</option>
                                <option value="location" {{ request('service') == 'location' ? 'selected' : '' }}>Location de Véhicules</option>
                                <option value="sonorisation" {{ request('service') == 'sonorisation' ? 'selected' : '' }}>Sonorisation</option>
                            </select>
                        </div>
                        
                        <!-- Message -->
                        <div class="col-12">
                            <label for="inputMessage" class="form-label fs-8 fw-bold text-navy text-uppercase">Message</label>
                            <textarea name="message" class="form-control" id="inputMessage" rows="4" placeholder="Décrivez votre projet ou besoin..." required></textarea>
                        </div>
                        
                        <!-- Bouton d'action Bleu Royal -->
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn-royal-blue">
                                Envoyer ma demande 
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- CARTE INTERACTIVE GOOGLE MAPS -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="map-wrapper rounded-4 overflow-hidden shadow-sm border border-light p-1 bg-white">
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

    <!-- Séparateur de vague créatif de transition Contenu (Clair) -> Footer (Sombre) -->
    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,80C1120,85,1280,75,1360,69.3L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z" fill="#050E2D"></path>
        </svg>
    </div>
</section>
@endsection