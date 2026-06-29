<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>@yield('title', 'Flycom Services | Solutions Technologiques au Congo')</title>
    
    <!-- SEO Technique -->
    <meta name="description" content="@yield('meta_description', 'Flycom Services par Groupe DigiZone. Experts à Brazzaville : Réseaux, Vidéosurveillance, Solaire, Climatisation et Location.')">
    <link class="canonical" href="{{ url()->current() }}">
    
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

    <style>
        /* Styles de positionnement et d'animations du Chatbot M7 */
        .fs-8 { font-size: 0.85rem !important; }
        .fs-9 { font-size: 0.75rem !important; }
        .text-white-70 { color: rgba(255, 255, 255, 0.7) !important; }
        .bg-cyan-soft { background-color: #00B4D8 !important; color: #fff !important; }
        
        /* Personnalisation de la fenêtre de discussion du chatbot (Bypass de sécurité des styles en ligne) */
        #chatbot-container {
            position: fixed !important;
            bottom: 0 !important;
            right: 0 !important;
            width: 380px !important;
            height: 500px !important;
            z-index: 1085 !important;
            margin: 0 24px 95px 0 !important; /* Décale la boîte au-dessus du bouton flottant */
            border: 1px solid #E2E8F0 !important;
            background-color: #ffffff;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
            display: none; /* Masqué par défaut */
        }

        /* S'affiche en flexbox vertical quand il est ouvert (sans .d-none) */
        #chatbot-container:not(.d-none) {
            display: flex !important;
        }

        /* CORRECTIF DYNAMIQUE : Le corps de messages s'ajuste de façon fluide */
        #chatbot-messages-box {
            flex-grow: 1 !important; /* Prend tout l'espace vertical libre */
            overflow-y: auto !important; /* Autorise le défilement */
            height: auto !important; /* Supprime le blocage d'origine */
            min-height: 80px !important; /* Permet de se rétrécir proprement lors du pop du clavier */
        }

        /* Empêcher la zone d'écriture d'être écrasée */
        #chatbot-container .card-footer {
            flex-shrink: 0 !important;
        }

        /* ── REFONTE DE CENTRAGE MOBILE-FIRST (Image 1, 2 et 3) ── */
        @media (max-width: 576px) {
            #chatbot-container {
                /* Positionnement absolu centré (S'adapte dynamiquement à la fermeture/ouverture du clavier !) */
                position: fixed !important;
                top: 50% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) !important;
                bottom: auto !important;
                right: auto !important;
                margin: 0 !important; /* Annule la marge de bureau */
                
                /* Dimensions proportionnées aérées (Laisse 5% de marge sur les côtés - Image 1) */
                width: 90vw !important; 
                max-width: 360px !important;
                height: 78dvh !important; /* Occupe 78% de la hauteur utile restante de l'écran */
                max-height: 80dvh !important;
                border-radius: 16px !important; /* Conserve les bords arrondis */
                box-shadow: 0 15px 45px rgba(5, 14, 45, 0.25) !important;
            }

            #chatbot-messages-box {
                max-height: 100% !important;
            }
        }

        /* Styles du preloader pour éviter le blocage de l'écran */
        .loading-lock {
            overflow: hidden !important;
        }
    </style>
</head>
<body class="loading-lock">

    <!-- PRELOADER UNIQUE -->
    <div id="preloader" class="preloader-overlay" style="opacity: 1; transition: opacity 0.5s ease;">
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
                <div class="preloader-progress-fill" id="preloaderProgress" style="width: 0%; transition: width 0.1s ease;"></div>
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
        <!-- Bouton flottant du Chatbot IA -->
        <button id="chatbot-toggle-btn" class="widget-btn bg-navy text-cyan shadow" aria-label="Support AI">
            <i id="chatbot-icon" class="bi bi-robot"></i>
        </button>
        <!-- Bouton flottant WhatsApp -->
        <a href="https://wa.me/242066285741" target="_blank" class="widget-btn bg-success text-white shadow" aria-label="WhatsApp">
            <i class="bi bi-whatsapp"></i>
        </a>
    </div>

    <!-- Interface Graphique épurée de la Fenêtre de Discussion du Chatbot M7 (Bypass de sécurité appliqué & Hauteur dynamique activée !) -->
    <div id="chatbot-container" class="card border-0 shadow-lg rounded-4 d-none">
        <!-- En-tête (Navy Blue #0D1B4B) -->
        <div class="card-header text-white d-flex justify-content-between align-items-center py-3 chatbot-header" style="background-color: #0D1B4B; border-top-left-radius: 16px; border-top-right-radius: 16px;">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-cyan rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px; background-color: #00B4D8;">
                    <i class="bi bi-robot"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">Assistant Flycom</h6>
                    <small class="text-success" style="font-size: 0.75rem;"><span class="d-inline-block rounded-circle bg-success me-1" style="width: 8px; height: 8px;"></span> En ligne</small>
                </div>
            </div>
            <button id="chatbot-close-btn" class="btn-close btn-close-white btn-sm shadow-none" aria-label="Fermer"></button>
        </div>

        <!-- Zone d'affichage des messages (height fixe supprimée pour permettre le rétrécissement élastique) -->
        <div class="card-body d-flex flex-column gap-3 p-3 chatbot-messages-body" id="chatbot-messages-box" style="background-color: #F8FAFC;">
            <!-- Message de bienvenue initial -->
            <div class="d-flex gap-2 align-items-start">
                <div class="bg-cyan rounded-circle p-1 text-white text-center" style="width: 24px; height: 24px; background-color: #00B4D8; font-size: 0.7rem;">
                    <i class="bi bi-robot"></i>
                </div>
                <div class="p-2.5 rounded-3 text-dark small" style="background-color: #E2E8F0; max-width: 80%; white-space: pre-line;">
                    Bonjour ! Je suis l'assistant virtuel de Flycom Services. Comment puis-je vous aider aujourd'hui ?
                </div>
            </div>
        </div>

        <!-- Zone de saisie utilisateur (Sécurisée contre le rétrécissement du clavier) -->
        <div class="card-footer bg-white border-top p-2 chatbot-input-footer" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
            <form id="chatbot-input-form" class="input-group">
                <input type="text" id="chatbot-user-text" class="form-control border-0 shadow-none fs-8" placeholder="Écrivez votre message..." autocomplete="off" required>
                <button class="btn btn-cyan rounded-3 text-white px-3 d-flex align-items-center justify-content-center" type="submit" style="background-color: #00B4D8; border: none;">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Chargement de Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SCRIPT SYSTÈME : EXTINCTION DU PRELOADER ET ANIMATIONS DU CHATBOT (Image M7) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // ========================================================
            // 1. EXTINCTION ET SIMULATION DU PRELOADER (Libère le body-lock)
            // ========================================================
            const preloader = document.getElementById('preloader');
            const preloaderProgress = document.getElementById('preloaderProgress');
            
            if (preloader) {
                let progress = 0;
                const interval = setInterval(() => {
                    progress += 20;
                    if (preloaderProgress) {
                        preloaderProgress.style.width = progress + '%';
                    }
                    if (progress >= 100) {
                        clearInterval(interval);
                        
                        // Transition en fondu vers le haut
                        preloader.style.opacity = '0';
                        preloader.style.transition = 'opacity 0.4s ease';
                        
                        setTimeout(() => {
                            preloader.style.display = 'none';
                            document.body.classList.remove('loading-lock');
                        }, 400);
                    }
                }, 80);
            }

            // ========================================================
            // 2. ANIMATION ET APPELS D'API GEMINI DU CHATBOT (Image M7)
            // ========================================================
            const toggleBtn = document.getElementById('chatbot-toggle-btn');
            const closeBtn = document.getElementById('chatbot-close-btn');
            const container = document.getElementById('chatbot-container');
            const form = document.getElementById('chatbot-input-form');
            const userInput = document.getElementById('chatbot-user-text');
            const messagesBox = document.getElementById('chatbot-messages-box');
            const chatbotIcon = document.getElementById('chatbot-icon');

            // Ouvrir/Fermer la fenêtre au clic sur le bouton flottant
            if (toggleBtn && container) {
                toggleBtn.addEventListener('click', () => {
                    container.classList.toggle('d-none');
                    if (container.classList.contains('d-none')) {
                        chatbotIcon.className = 'bi bi-robot';
                    } else {
                        chatbotIcon.className = 'bi bi-chevron-down';
                        userInput.focus();
                        scrollToBottom();
                    }
                });
            }

            if (closeBtn && container) {
                closeBtn.addEventListener('click', () => {
                    container.classList.add('d-none');
                    chatbotIcon.className = 'bi bi-robot';
                });
            }

            // Gestion de l'envoi du message en AJAX vers le contrôleur Laravel
            if (form) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const text = userInput.value.trim();
                    if (!text) return;

                    // Afficher le message de l'utilisateur à l'écran
                    appendUserMessage(text);
                    userInput.value = '';

                    // Afficher l'indicateur de chargement de l'IA (clignotant)
                    const loadingId = appendLoadingIndicator();
                    scrollToBottom();

                    // Récupérer l'ID de conversation s'il est déjà stocké localement dans la session
                    const conversationId = localStorage.getItem('chatbot_conversation_id');

                    const payload = {
                        message: text,
                        conversation_id: conversationId
                    };

                    const url = `{{ url('api/chatbot/message') }}`;

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => {
                        if (!res.ok) throw new Error("Erreur réseau");
                        return res.json();
                    })
                    .then(data => {
                        // Supprimer l'indicateur de chargement
                        removeLoadingIndicator(loadingId);

                        // Enregistrer l'ID de conversation pour maintenir le contexte
                        if (data.id_conversation) {
                            localStorage.setItem('chatbot_conversation_id', data.id_conversation);
                        }

                        // Afficher la réponse de Gemini
                        appendAiMessage(data.reply);
                        scrollToBottom();
                    })
                    .catch(err => {
                        removeLoadingIndicator(loadingId);
                        appendAiMessage("Désolé, je rencontre des difficultés pour joindre nos serveurs à Brazzaville.");
                        scrollToBottom();
                    });
                });
            }

            function appendUserMessage(text) {
                const html = `
                    <div class="d-flex justify-content-end mb-2">
                        <!-- Ajout de white-space: pre-line; pour gérer proprement les retours à la ligne -->
                        <div class="p-2.5 rounded-3 bg-cyan-soft text-white small" style="max-width: 80%; white-space: pre-line;">
                            ${text}
                        </div>
                    </div>
                `;
                messagesBox.insertAdjacentHTML('beforeend', html);
            }

            function appendAiMessage(text) {
                const html = `
                    <div class="d-flex gap-2 align-items-start mb-2">
                        <div class="bg-cyan rounded-circle p-1 text-white text-center" style="width: 24px; height: 24px; background-color: #00B4D8; font-size: 0.7rem;">
                            <i class="bi bi-robot"></i>
                        </div>
                        <!-- Ajout de white-space: pre-line; pour forcer l'affichage propre des paragraphes -->
                        <div class="p-2.5 rounded-3 text-dark small" style="background-color: #E2E8F0; max-width: 80%; white-space: pre-line;">
                            ${text}
                        </div>
                    </div>
                `;
                messagesBox.insertAdjacentHTML('beforeend', html);
            }

            function appendLoadingIndicator() {
                const id = 'loading-' + Date.now();
                const html = `
                    <div id="${id}" class="d-flex gap-2 align-items-start mb-2">
                        <div class="bg-cyan rounded-circle p-1 text-white text-center" style="width: 24px; height: 24px; background-color: #00B4D8; font-size: 0.7rem;">
                            <i class="bi bi-robot"></i>
                        </div>
                        <div class="p-2.5 rounded-3 text-muted small" style="background-color: #E2E8F0;">
                            <span class="spinner-grow spinner-grow-sm text-cyan" role="status" aria-hidden="true" style="color: #00B4D8;"></span>
                            <span class="spinner-border-sm ms-1">L'assistant réfléchit...</span>
                        </div>
                    </div>
                `;
                messagesBox.insertAdjacentHTML('beforeend', html); // Corrigé : utilise la variable messagesBox existante
                return id;
            }

            function removeLoadingIndicator(id) {
                const el = document.getElementById(id);
                if (el) el.remove();
            }

            // Expose l'indicateur pour qu'il soit nettoyable hors du scope local
            window.removeLoadingIndicator = removeLoadingIndicator;

            function scrollToBottom() {
                messagesBox.scrollTop = messagesBox.scrollHeight;
            }
        });
    </script>
</body>
</html>