<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>@yield('title', 'Flycom Services | Solutions Technologiques au Congo')</title>
    
    <!-- SEO Technique -->
    <meta name="description" content="@yield('meta_description', 'Flycom Services par Groupe DigiZone. Experts à Brazzaville : Réseaux, Vidéosurveillance, Solaire, Climatisation et Location.')">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <meta name="geo.region" content="CG-12" />
    <meta name="geo.placename" content="Brazzaville" />
    <meta name="geo.position" content="-4.2634;15.2832" />
    <meta name="ICBM" content="-4.2634, 15.2832" />

    <!-- Polices & CDNs -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Zone pour l'injection des Schémas JSON-LD spécifiques à chaque page -->
    @yield('json_ld')
</head>
<body class="loading-lock">

    <!-- PRELOADER UNIQUE -->
    <div id="preloader" class="preloader-overlay">
        <div class="network-particles"></div> 
        <div class="preloader-content text-center">
            <div class="preloader-icon-container mb-4">
                <div class="preloader-ring ring-1"></div>
                <div class="preloader-ring ring-2"></div>
                <div class="preloader-ring ring-3"></div>
                <div class="preloader-shield-badge">
                    <i class="bi bi-shield-fill-check"></i>
                </div>
            </div>
            <h2 class="preloader-title fw-extrabold text-white mb-2">FLYCOM <span class="text-cyan">SERVICES</span></h2>
            <p class="preloader-subtitle mb-3">Chargement de l'expérience...</p>
            <div class="preloader-progress-bar">
                <div class="preloader-progress-fill" id="preloaderProgress"></div>
            </div>
        </div>
    </div>

    <!-- NAVBAR COMMUNE -->
    <header class="navbar-sticky fixed-top">
        <nav class="navbar navbar-expand-lg navbar-dark container py-3" aria-label="Menu Principal">
            <div class="container-fluid px-0">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                    <div class="brand-logo bg-cyan-gradient rounded-3 p-2 text-white d-flex align-items-center justify-content-center">
                        <i class="bi bi-shield-fill-check fs-4"></i>
                    </div>
                    <span class="fw-extrabold text-white tracking-tight">FLYCOM <span class="text-cyan">SERVICES</span></span>
                </a>
                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-3 text-start">
                        <li class="nav-item"><a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Accueil</a></li>
                        <li class="nav-item"><a class="nav-link {{ Route::is('about') ? 'active' : '' }}" href="{{ route('about') }}">À propos</a></li>
                        <li class="nav-item"><a class="nav-link {{ Route::is('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a></li>
                        <li class="nav-item"><a class="nav-link {{ Route::is('portfolio') ? 'active' : '' }}" href="{{ route('portfolio') }}">Portfolio</a></li>
                        <li class="nav-item"><a class="nav-link {{ Route::is('faq') ? 'active' : '' }}" href="{{ route('faq') }}">FAQ</a></li>
                        <li class="nav-item"><a class="nav-link {{ Route::is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                    <div class="d-flex align-items-center mt-3 mt-lg-0">
                        <a href="{{ route('contact') }}" class="btn btn-cyan rounded-pill px-4 py-2 fw-bold shadow-cyan-btn w-100 w-lg-auto text-center">
                            Devis gratuit 
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- CONTENU DYNAMIQUE DES PAGES -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER COMMUN -->
    <footer class="bg-navy-dark text-white pt-5 pb-4 position-relative overflow-hidden">
        <div class="network-particles"></div>
        <div class="container position-relative z-2">
            <div class="row g-4 justify-content-between mb-5">
                <div class="col-12 col-lg-5">
                    <a class="d-flex align-items-center gap-2 text-decoration-none mb-3" href="{{ route('home') }}">
                        <div class="brand-logo bg-cyan-gradient rounded-3 p-2 text-white d-flex align-items-center justify-content-center">
                            <i class="bi bi-shield-fill-check fs-4"></i>
                        </div>
                        <span class="fw-extrabold text-white tracking-tight lh-1 footer-brand-text">FLYCOM <span class="text-cyan">SERVICES</span></span>
                    </a>
                    <p class="text-light-muted fs-8 mb-4 pe-lg-5">
                        Solutions technologiques complètes pour sécuriser, connecter et optimiser votre monde. Basés à Brazzaville, au service du Congo.
                    </p>
                    <div class="newsletter-wrapper">
                        <h4 class="newsletter-title fs-8 text-cyan fw-bold mb-3 text-uppercase">Newsletter</h4>
                        <form class="newsletter-underline-form">
                            <input type="email" id="newsletterEmail" class="form-control-underline" placeholder="exemple@email.com" required>
                            <button type="submit" class="btn-cyan-circle" aria-label="S'abonner"><i class="bi bi-arrow-right"></i></button>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-lg-7 mt-5 mt-lg-0">
                    <div class="row g-4 text-start">
                        <div class="col-12 col-sm-4">
                            <h4 class="h8 text-cyan fw-bold text-uppercase mb-3 fs-8">Services</h4>
                            <ul class="list-unstyled d-flex flex-column gap-2 fs-8 text-light-muted mb-0">
                                <li><a href="{{ route('services') }}" class="hover-cyan text-decoration-none text-light-muted">Nos Services</a></li>
                                <li><a href="{{ route('services') }}" class="hover-cyan text-decoration-none text-light-muted">Vidéosurveillance</a></li>
                                <li><a href="{{ route('services') }}" class="hover-cyan text-decoration-none text-light-muted">Énergie Solaire</a></li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-4">
                            <h4 class="h8 text-cyan fw-bold text-uppercase mb-3 fs-8">Solutions</h4>
                            <ul class="list-unstyled d-flex flex-column gap-2 fs-8 text-light-muted mb-0">
                                <li><a href="{{ route('services') }}" class="hover-cyan text-decoration-none text-light-muted">Réseaux Informatiques</a></li>
                                <li><a href="{{ route('services') }}" class="hover-cyan text-decoration-none text-light-muted">Climatisation</a></li>
                                <li><a href="{{ route('about') }}" class="hover-cyan text-decoration-none text-light-muted">À propos</a></li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-4">
                            <h4 class="h8 text-cyan fw-bold text-uppercase mb-3 fs-8">Entreprise</h4>
                            <ul class="list-unstyled d-flex flex-column gap-2 fs-8 text-light-muted mb-0">
                                <li><a href="{{ route('contact') }}" class="hover-cyan text-decoration-none text-light-muted">Contact</a></li>
                                <li><a href="{{ route('contact') }}" class="hover-cyan text-decoration-none text-light-muted">Demander un devis</a></li>
                                <li><a href="{{ route('contact') }}" class="hover-cyan text-decoration-none text-light-muted">Support technique</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="border-navy-light my-4 opacity-10">
            <div class="row justify-content-end mb-4">
                <div class="col-12 col-lg-7">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6 d-flex align-items-center gap-3">
                            <div class="footer-meta-icon"><i class="bi bi-geo-alt-fill"></i></div>
                            <span class="fs-8 text-light-muted">22, Avenue de Brazza — La Glacière, Brazzaville</span>
                        </div>
                        <div class="col-12 col-sm-6 d-flex align-items-center gap-3">
                            <div class="footer-meta-icon"><i class="bi bi-telephone-fill"></i></div>
                            <span class="fs-8 text-light-muted">06 628 57 41 / 04 411 80 78</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-top border-navy-light pt-3 mt-4 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <p class="mb-0 fs-9 text-light-muted">&copy; 2026 Flycom Services. Réalisé par Groupe DigiZone — Programme D-clic (OIF) 2026</p>
                <div class="d-flex gap-2">
                    <a href="#" class="social-circle-btn" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-circle-btn" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- WIDGETS FLOTTANTS -->
    <div class="floating-widgets">
        <button class="widget-btn bg-navy text-cyan shadow" aria-label="Support AI"><i class="bi bi-robot"></i></button>
        <a href="https://wa.me/242066285741" target="_blank" class="widget-btn bg-success text-white shadow" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>