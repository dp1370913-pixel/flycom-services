import 'bootstrap';

/**
 * Flycom Services - Scripts applicatifs complets
 */

document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // LOGIQUE DE L'ÉCRAN DE PRELOADER AVEC JAUGE
    // ==========================================
    const progressFill = document.getElementById('preloaderProgress');
    const preloader = document.getElementById('preloader');
    
    // Déclenchement de la progression visuelle de la jauge dès le rendu initial
    setTimeout(() => {
        if (progressFill) {
            progressFill.style.width = '100%';
        }
    }, 100);

    // Une fois la page entièrement chargée, on estompe l'écran et on déverrouille le scroll
    window.addEventListener('load', () => {
        setTimeout(() => {
            if (preloader) {
                preloader.classList.add('fade-out');
                document.body.classList.remove('loading-lock');
            }
        }, 1600); // Temporisation pour laisser le temps de voir la jauge se remplir
    });


    // ==========================================
    // CLASSE CONSTELLATION NEURONALE INTERACTIVE
    // ==========================================
    class NeuralNetworkConstellation {
        constructor(container) {
            this.container = container;
            this.canvas = document.createElement('canvas');
            this.ctx = this.canvas.getContext('2d');
            this.container.appendChild(this.canvas);
            
            this.particles = [];
            this.animationId = null;
            this.isCurrentlyVisible = false;

            this.maxDistance = 110; 
            this.particleColor = 'rgba(0, 210, 244, 0.35)'; // Cyan Électrique subtil
            this.lineColor = 'rgba(0, 210, 244, 0.06)';

            this.init();
        }

        init() {
            this.resize();
            this.createParticles();
            
            window.addEventListener('resize', () => this.handleResize());

            // N'animer la constellation que si la section est visible (Optimisation Batterie)
            this.initIntersectionObserver();
        }

        handleResize() {
            this.resize();
            this.createParticles();
        }

        resize() {
            const dpr = window.devicePixelRatio || 1;
            this.width = this.container.offsetWidth;
            this.height = this.container.offsetHeight;
            
            this.canvas.width = this.width * dpr;
            this.canvas.height = this.height * dpr;
            this.ctx.scale(dpr, dpr);
        }

        createParticles() {
            this.particles = [];
            const area = this.width * this.height;
            const densityDivider = 18000; 
            const particleCount = Math.min(Math.max(Math.floor(area / densityDivider), 20), 55);

            for (let i = 0; i < particleCount; i++) {
                this.particles.push({
                    x: Math.random() * this.width,
                    y: Math.random() * this.height,
                    vx: (Math.random() - 0.5) * 0.35, // Glissement continu ultra lent
                    vy: (Math.random() - 0.5) * 0.35,
                    radius: Math.random() * 2 + 1.2
                });
            }
        }

        draw() {
            if (!this.isCurrentlyVisible) return;

            this.ctx.clearRect(0, 0, this.width, this.height);

            // 1. Mise à jour et dessin des noeuds
            for (let i = 0; i < this.particles.length; i++) {
                const p = this.particles[i];

                p.x += p.vx;
                p.y += p.vy;

                // Rebondissement adaptatif
                if (p.x < 0 || p.x > this.width) p.vx *= -1;
                if (p.y < 0 || p.y > this.height) p.vy *= -1;

                this.ctx.beginPath();
                this.ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                this.ctx.fillStyle = this.particleColor;
                this.ctx.fill();
            }

            // 2. Tracé des liaisons (synapses)
            for (let i = 0; i < this.particles.length; i++) {
                const p1 = this.particles[i];
                for (let j = i + 1; j < this.particles.length; j++) {
                    const p2 = this.particles[j];

                    const dx = p1.x - p2.x;
                    const dy = p1.y - p2.y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < this.maxDistance) {
                        const alpha = (1 - distance / this.maxDistance) * 0.25;
                        this.ctx.beginPath();
                        this.ctx.moveTo(p1.x, p1.y);
                        this.ctx.lineTo(p2.x, p2.y);
                        this.ctx.strokeStyle = `rgba(0, 210, 244, ${alpha})`;
                        this.ctx.lineWidth = 0.8;
                        this.ctx.stroke();
                    }
                }
            }

            this.animationId = requestAnimationFrame(() => this.draw());
        }

        initIntersectionObserver() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.isCurrentlyVisible = true;
                        if (!this.animationId) {
                            this.draw();
                        }
                    } else {
                        this.isCurrentlyVisible = false;
                        if (this.animationId) {
                            cancelAnimationFrame(this.animationId);
                            this.animationId = null;
                        }
                    }
                });
            }, {
                threshold: 0.05
            });

            observer.observe(this.container);
        }
    }

    // Instanciation de l'arrière-plan de neurones animés sur les fonds bleu foncé
    const darkSections = document.querySelectorAll('.network-particles');
    darkSections.forEach(container => {
        new NeuralNetworkConstellation(container);
    });

    // ==========================================
    // CAROUSEL TÉMOIGNAGES (Overlap & Mobile Support)
    // ==========================================
    const testimonialsData = [
        {
            avatar: "PO",
            name: "Patrick Okemba",
            role: "Directeur Technique, Congo Tech"
        },
        {
            avatar: "AD",
            name: "Aminata Diallo",
            role: "Propriétaire, Résidence Les Orchidées"
        },
        {
            avatar: "JM",
            name: "Jean-Pierre Mabiala",
            role: "Directeur, Société Immobilière Congo"
        }
    ];

    let activeIndex = 1; 
    const cards = document.querySelectorAll('.testimonials-track .testi-card');
    const dots = document.querySelectorAll('.slider-dots .dot');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    const updateSlider = () => {
        const total = testimonialsData.length;
        
        cards.forEach((card, index) => {
            card.className = "testi-card p-4 rounded-4 border text-start";
            
            if (index === activeIndex) {
                card.classList.add('card-active');
            } else if (index === (activeIndex - 1 + total) % total) {
                card.classList.add('card-faded-left');
            } else {
                card.classList.add('card-faded-right');
            }
        });

        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === activeIndex);
        });
    };

    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', () => {
            activeIndex = (activeIndex - 1 + testimonialsData.length) % testimonialsData.length;
            updateSlider();
        });

        nextBtn.addEventListener('click', () => {
            activeIndex = (activeIndex + 1) % testimonialsData.length;
            updateSlider();
        });

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                activeIndex = index;
                updateSlider();
            });
        });

        updateSlider();
    }

    // ==========================================
    // FORMULAIRE DE NEWSLETTER
    // ==========================================
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const emailInput = document.getElementById('newsletterEmail');
            if (emailInput.value.trim() !== "") {
                alert(`Merci pour votre inscription ! L'adresse ${emailInput.value} recevra nos actualités.`);
                emailInput.value = "";
            }
        });
    }
});

// ==========================================
    // EFFET DE COMPTEUR NUMÉRIQUE DYNAMIQUE
    // ==========================================
    const initDynamicCounters = () => {
        const counters = document.querySelectorAll('.counter');
        const duration = 1500; // Durée totale de l'effet en millisecondes

        const animateCounter = (counter) => {
            const targetValue = +counter.getAttribute('data-target');
            const startTime = performance.now();

            const updateValue = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);

                // Fonction d'accélération fluide (easeOutQuad)
                const easeProgress = progress * (2 - progress);
                const currentValue = Math.floor(easeProgress * targetValue);

                counter.innerText = currentValue;

                if (progress < 1) {
                    requestAnimationFrame(updateValue);
                } else {
                    counter.innerText = targetValue;
                }
            };

            requestAnimationFrame(updateValue);
        };

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter(entry.target);
                        observer.unobserve(entry.target); // S'exécute une seule fois
                    }
                });
            }, { 
                threshold: 0.75 // Déclenche à 75% de visibilité de l'élément
            });

            counters.forEach(counter => observer.observe(counter));
        } else {
            // Repli automatique si le navigateur est ancien
            counters.forEach(counter => {
                counter.innerText = counter.getAttribute('data-target');
            });
        }
    };

    // Lancer l'initialisation des compteurs
    initDynamicCounters();

// ==========================================
    // RECHERCHE EN TEMPS RÉEL & FILTRAGE DYNAMIQUE FAQ
    // ==========================================
    const initFaqEngine = () => {
        const searchInput = document.getElementById('faqSearchInput');
        const filterButtons = document.querySelectorAll('.btn-filter');
        const faqItems = document.querySelectorAll('.faq-item');
        const resultsCount = document.getElementById('resultsCount');

        let currentFilter = 'all';
        let searchQuery = '';

        const updateFaqList = () => {
            let matchesFound = 0;

            faqItems.forEach(item => {
                const category = item.getAttribute('data-category');
                const questionText = item.querySelector('.accordion-button').innerText.toLowerCase();
                const answerText = item.querySelector('.accordion-body').innerText.toLowerCase();

                const matchesCategory = (currentFilter === 'all' || category === currentFilter);
                const matchesSearch = (searchQuery === '' || questionText.includes(searchQuery) || answerText.includes(searchQuery));

                if (matchesCategory && matchesSearch) {
                    item.style.display = 'block';
                    matchesFound++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Mettre à jour dynamiquement le compteur de résultats
            if (resultsCount) {
                if (matchesFound === 0) {
                    resultsCount.innerText = "Aucun résultat trouvé";
                } else if (matchesFound === 1) {
                    resultsCount.innerText = "1 résultat trouvé";
                } else {
                    resultsCount.innerText = `${matchesFound} résultats trouvés`;
                }
            }
        };

        // Écouteur sur la barre de recherche
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                searchQuery = e.target.value.toLowerCase().trim();
                updateFaqList();
            });
        }

        // Écouteur sur les boutons de filtrage
        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                filterButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                currentFilter = btn.getAttribute('data-filter');
                updateFaqList();
            });
        });
    };

    // Lancement du moteur de la FAQ
    initFaqEngine();

// ==========================================
    // MOTEUR DE RECHERCHE ET FILTRAGE DYNAMIQUE PORTFOLIO
    // ==========================================
    const initPortfolioFilter = () => {
        const filterButtons = document.querySelectorAll('.portfolio-filter-btn');
        const portfolioItems = document.querySelectorAll('.portfolio-item');
        const resultsCount = document.getElementById('portfolioResultsCount');

        if (filterButtons.length > 0) {
            filterButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    filterButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    const filterValue = btn.getAttribute('data-filter');
                    let matchCount = 0;

                    portfolioItems.forEach(item => {
                        const category = item.getAttribute('data-category');
                        
                        // Forcer la réinitialisation de l'animation CSS
                        item.style.animation = 'none';
                        item.offsetHeight; // Déclencher le reflow pour redémarrer l'animation

                        if (filterValue === 'all' || category === filterValue) {
                            item.style.display = 'block';
                            item.style.animation = 'fadeInUp 0.4s ease forwards';
                            matchCount++;
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    // Réactualiser dynamiquement le compteur de projets
                    if (resultsCount) {
                        if (matchCount === 0) {
                            resultsCount.innerText = "Aucun projet trouvé";
                        } else if (matchCount === 1) {
                            resultsCount.innerText = "1 projet affiché";
                        } else {
                            resultsCount.innerText = `${matchCount} projets affichés`;
                        }
                    }
                });
            });
        }
    };

    // Lancement du moteur de tri du portfolio
    initPortfolioFilter();