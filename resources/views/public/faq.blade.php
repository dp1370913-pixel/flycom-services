@extends('layouts.public')

@section('title', 'Questions Fréquentes | Support & FAQ Flycom Services')

<!-- Injection dynamique du Schéma FAQPage au format JSON-LD (M6) -->
@section('json_ld')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    {
      "@@type": "Question",
      "name": "Sous quel délai le devis proforma est-il délivré ?",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "Flycom Services s'engage à vous fournir un devis proforma détaillé sous 24h ouvrées après notre audit gratuit de faisabilité technique."
      }
    },
    {
      "@@type": "Question",
      "name": "Quels modes de paiement acceptez-vous ?",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "Nous acceptons les règlements par virement bancaire, chèque d'entreprise, ainsi que par les solutions de Mobile Money locales (MTN MoMo, Airtel Money)."
      }
    },
    {
      "@@type": "Question",
      "name": "Les caméras de vidéosurveillance fonctionnent-elles sans électricité ?",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "Oui, à condition d'être associées à l'un de nos systèmes de secours électrique, tels que nos kits photovoltaïques autonomes ou nos onduleurs professionnels."
      }
    }
  ]
}
</script>
@endsection

@section('content')
<!-- SECTION HERO FAQ -->
<section id="faq-hero" class="hero-section d-flex align-items-center position-relative overflow-hidden">
    <div class="network-particles"></div>
    <div class="container py-4 py-md-5 z-2 position-relative text-center">
        
        <!-- Badge unifié (Identique à celui de la page contact) -->
        <div class="custom-badge-pill mb-3">
            <span class="badge-dot"></span>
            <span>Centre d'aide</span>
        </div>
        
        <h1 class="display-main-heading fw-extrabold text-white mb-3">Questions <span class="text-cyan text-decor-slash">fréquentes</span></h1>
        <p class="lead text-light-muted max-w-md mx-auto fs-7 mb-4">
            Retrouvez les réponses aux questions les plus courantes. Vous ne trouvez pas votre réponse ? Contactez-nous directement.
        </p>
        
        <!-- Barre de recherche interactive de la FAQ (Image 1) -->
        <div class="faq-search-wrapper mx-auto max-w-md position-relative">
            <i class="bi bi-search search-icon"></i>
            <input type="text" id="faqSearchInput" class="form-control faq-search-input py-3 ps-5 pe-3 border-0" placeholder="Rechercher une question (ex: garantie, solaire, prix...)">
        </div>
    </div>
    
    <!-- Séparateur de vague : Hero (Sombre) -> Contenu (Clair) -->
    <div class="wave-container bottom">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,32L60,42.7C120,53,240,75,360,80C480,85,600,75,720,64C840,53,960,43,1080,48C1200,53,1320,75,1380,85.3L1440,96L1440,120L1380,120C1320,120,1200,120,1080,120C960,120,840,120,720,120C600,120,480,120,360,120C240,120,120,120,60,120L0,120Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- SECTION PRINCIPALE ACCORDÉONS FAQ (Dégagement augmenté) -->
<section class="faq-main-section bg-white text-navy position-relative">
    <div class="container py-2">
        
        <!-- Filtres Thématiques / Catégories (Image 1) -->
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
            <button class="btn btn-filter active" data-filter="all">Toutes</button>
            <button class="btn btn-filter" data-filter="tarifs">Devis &amp; Tarifs</button>
            <button class="btn btn-filter" data-filter="garantie">Installation &amp; Garantie</button>
            <button class="btn btn-filter" data-filter="securite">Sécurité &amp; Énergie</button>
            <button class="btn btn-filter" data-filter="location">Location &amp; Événements</button>
        </div>

        <!-- Compteur de résultats dynamique -->
        <div class="text-center mb-4">
            <span class="fs-8 text-muted fw-semibold" id="resultsCount">13 résultats trouvés</span>
        </div>

        <!-- Liste des 13 Accordéons FAQ -->
        <div class="faq-list-container mx-auto max-w-md">
            <div class="accordion accordion-flush d-flex flex-column gap-3" id="faqAccordion">
                
                <!-- Question 1 -->
                <div class="accordion-item faq-item border border-light rounded-4 overflow-hidden shadow-sm" data-category="tarifs">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed fw-bold text-navy fs-7 d-flex gap-3 align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <span class="faq-icon-holder"><i class="bi bi-question-circle"></i></span>
                            <div class="flex-grow-1">
                                <span class="d-block fs-9 text-cyan text-uppercase mb-1 tracking-wider">Devis &amp; Tarifs</span>
                                Sous quel délai le devis proforma est-il délivré ?
                            </div>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body fs-8 text-muted leading-relaxed">
                            Flycom Services s'engage à vous fournir un devis proforma détaillé sous 24h ouvrées après notre audit gratuit de faisabilité technique.
                        </div>
                    </div>
                </div>

                <!-- Question 2 -->
                <div class="accordion-item faq-item border border-light rounded-4 overflow-hidden shadow-sm" data-category="tarifs">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed fw-bold text-navy fs-7 d-flex gap-3 align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <span class="faq-icon-holder"><i class="bi bi-question-circle"></i></span>
                            <div class="flex-grow-1">
                                <span class="d-block fs-9 text-cyan text-uppercase mb-1 tracking-wider">Devis &amp; Tarifs</span>
                                Quels modes de paiement acceptez-vous ?
                            </div>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body fs-8 text-muted leading-relaxed">
                            Nous acceptons les règlements par virement bancaire, chèque d'entreprise, ainsi que par les solutions de Mobile Money locales (MTN MoMo et Airtel Money) pour s'adapter à la réalité locale du Congo.
                        </div>
                    </div>
                </div>

                <!-- Question 3 -->
                <div class="accordion-item faq-item border border-light rounded-4 overflow-hidden shadow-sm" data-category="tarifs">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed fw-bold text-navy fs-7 d-flex gap-3 align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <span class="faq-icon-holder"><i class="bi bi-question-circle"></i></span>
                            <div class="flex-grow-1">
                                <span class="d-block fs-9 text-cyan text-uppercase mb-1 tracking-wider">Devis &amp; Tarifs</span>
                                Y a-t-il des frais de déplacement ?
                            </div>
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body fs-8 text-muted leading-relaxed">
                            L'audit technique et les déplacements associés sont gratuits sur l'ensemble de la zone urbaine de Brazzaville. Pour les autres départements, un forfait de déplacement transparent est proposé sur devis.
                        </div>
                    </div>
                </div>

                <!-- Question 4 -->
                <div class="accordion-item faq-item border border-light rounded-4 overflow-hidden shadow-sm" data-category="garantie">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed fw-bold text-navy fs-7 d-flex gap-3 align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <span class="faq-icon-holder"><i class="bi bi-question-circle"></i></span>
                            <div class="flex-grow-1">
                                <span class="d-block fs-9 text-cyan text-uppercase mb-1 tracking-wider">Installation &amp; Garantie</span>
                                Quelle est la durée de garantie de vos installations ?
                            </div>
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                        <div class="accordion-body fs-8 text-muted leading-relaxed">
                            Toutes nos installations physiques (vidéosurveillance, contrôle d'accès, kits solaires) bénéficient d'une garantie pièces et main-d'œuvre minimale de 12 mois.
                        </div>
                    </div>
                </div>

                <!-- Question 5 -->
                <div class="accordion-item faq-item border border-light rounded-4 overflow-hidden shadow-sm" data-category="garantie">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed fw-bold text-navy fs-7 d-flex gap-3 align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            <span class="faq-icon-holder"><i class="bi bi-question-circle"></i></span>
                            <div class="flex-grow-1">
                                <span class="d-block fs-9 text-cyan text-uppercase mb-1 tracking-wider">Installation &amp; Garantie</span>
                                Quel délai faut-il prévoir pour une installation ?
                            </div>
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                        <div class="accordion-body fs-8 text-muted leading-relaxed">
                            Pour une installation standard (type kit de vidéosurveillance de 4 à 8 caméras ou kit solaire classique), les travaux sont généralement réalisés sous 48h à 72h après validation du devis.
                        </div>
                    </div>
                </div>

                <!-- Question 6 -->
                <div class="accordion-item faq-item border border-light rounded-4 overflow-hidden shadow-sm" data-category="garantie">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed fw-bold text-navy fs-7 d-flex gap-3 align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            <span class="faq-icon-holder"><i class="bi bi-question-circle"></i></span>
                            <div class="flex-grow-1">
                                <span class="d-block fs-9 text-cyan text-uppercase mb-1 tracking-wider">Installation &amp; Garantie</span>
                                Proposez-vous un service de maintenance ?
                            </div>
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                        <div class="accordion-body fs-8 text-muted leading-relaxed">
                            Oui. Nous proposons des contrats de maintenance préventive (visite périodique de nettoyage, réglages, tests de batteries) et corrective (dépannage sous 2h à 4h en cas d'urgence).
                        </div>
                    </div>
                </div>

                <!-- Question 7 -->
                <div class="accordion-item faq-item border border-light rounded-4 overflow-hidden shadow-sm" data-category="garantie">
                    <h2 class="accordion-header" id="headingSeven">
                        <button class="accordion-button collapsed fw-bold text-navy fs-7 d-flex gap-3 align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                            <span class="faq-icon-holder"><i class="bi bi-question-circle"></i></span>
                            <div class="flex-grow-1">
                                <span class="d-block fs-9 text-cyan text-uppercase mb-1 tracking-wider">Installation &amp; Garantie</span>
                                Intervenez-vous en dehors de Brazzaville ?
                            </div>
                        </button>
                    </h2>
                    <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                        <div class="accordion-body fs-8 text-muted leading-relaxed">
                            Absolument. Bien que notre siège social soit à Brazzaville (La Glacière), nos équipes mobiles se déplacent sur l'ensemble du territoire de la République du Congo (Pointe-Noire, Dolisie, Oyo, etc.).
                        </div>
                    </div>
                </div>

                <!-- Question 8 -->
                <div class="accordion-item faq-item border border-light rounded-4 overflow-hidden shadow-sm" data-category="securite">
                    <h2 class="accordion-header" id="headingEight">
                        <button class="accordion-button collapsed fw-bold text-navy fs-7 d-flex gap-3 align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                            <span class="faq-icon-holder"><i class="bi bi-question-circle"></i></span>
                            <div class="flex-grow-1">
                                <span class="d-block fs-9 text-cyan text-uppercase mb-1 tracking-wider">Sécurité &amp; Énergie</span>
                                Les caméras de vidéosurveillance fonctionnent-elles sans électricité ?
                            </div>
                        </button>
                    </h2>
                    <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                        <div class="accordion-body fs-8 text-muted leading-relaxed">
                            Oui, à condition d'être associées à l'un de nos systèmes de secours électrique, tels que nos kits photovoltaïques autonomes ou nos onduleurs professionnels avec batteries de stockage.
                        </div>
                    </div>
                </div>

                <!-- Question 9 -->
                <div class="accordion-item faq-item border border-light rounded-4 overflow-hidden shadow-sm" data-category="securite">
                    <h2 class="accordion-header" id="headingNine">
                        <button class="accordion-button collapsed fw-bold text-navy fs-7 d-flex gap-3 align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                            <span class="faq-icon-holder"><i class="bi bi-question-circle"></i></span>
                            <div class="flex-grow-1">
                                <span class="d-block fs-9 text-cyan text-uppercase mb-1 tracking-wider">Sécurité &amp; Énergie</span>
                                Quelle autonomie offrent vos installations solaires ?
                            </div>
                        </button>
                    </h2>
                    <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#faqAccordion">
                        <div class="accordion-body fs-8 text-muted leading-relaxed">
                            Nos installations sont calculées sur mesure selon vos équipements. En moyenne, nos kits offrent une autonomie de 12 à 24 heures de stockage continu sur batteries lithium de marque Victron ou Huawei.
                        </div>
                    </div>
                </div>

                <!-- Question 10 -->
                <div class="accordion-item faq-item border border-light rounded-4 overflow-hidden shadow-sm" data-category="securite">
                    <h2 class="accordion-header" id="headingTen">
                        <button class="accordion-button collapsed fw-bold text-navy fs-7 d-flex gap-3 align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                            <span class="faq-icon-holder"><i class="bi bi-question-circle"></i></span>
                            <div class="flex-grow-1">
                                <span class="d-block fs-9 text-cyan text-uppercase mb-1 tracking-wider">Sécurité &amp; Énergie</span>
                                Le barbelé électrique présente-t-il un danger mortel ?
                            </div>
                        </button>
                    </h2>
                    <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#faqAccordion">
                        <div class="accordion-body fs-8 text-muted leading-relaxed">
                            Le système utilise un électrificateur homologué qui délivre des impulsions de haute tension extrêmement dissuasives mais non mortelles, conformément aux normes internationales de sécurité périmétrique.
                        </div>
                    </div>
                </div>

                <!-- Question 11 -->
                <div class="accordion-item faq-item border border-light rounded-4 overflow-hidden shadow-sm" data-category="location">
                    <h2 class="accordion-header" id="headingEleven">
                        <button class="accordion-button collapsed fw-bold text-navy fs-7 d-flex gap-3 align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                            <span class="faq-icon-holder"><i class="bi bi-question-circle"></i></span>
                            <div class="flex-grow-1">
                                <span class="d-block fs-9 text-cyan text-uppercase mb-1 tracking-wider">Location &amp; Événements</span>
                                Quels types de véhicules proposez-vous à la location ?
                            </div>
                        </button>
                    </h2>
                    <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven" data-bs-parent="#faqAccordion">
                        <div class="accordion-body fs-8 text-muted leading-relaxed">
                            Notre flotte comprend des SUV 4x4 robustes pour vos déplacements professionnels en province, des berlines de tourisme confortables et des véhicules utilitaires de transport.
                        </div>
                    </div>
                </div>

                <!-- Question 12 -->
                <div class="accordion-item faq-item border border-light rounded-4 overflow-hidden shadow-sm" data-category="location">
                    <h2 class="accordion-header" id="headingTwelve">
                        <button class="accordion-button collapsed fw-bold text-navy fs-7 d-flex gap-3 align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                            <span class="faq-icon-holder"><i class="bi bi-question-circle"></i></span>
                            <div class="flex-grow-1">
                                <span class="d-block fs-9 text-cyan text-uppercase mb-1 tracking-wider">Location &amp; Événements</span>
                                Le matériel de sonorisation de location inclut-il un technicien ?
                            </div>
                        </button>
                    </h2>
                    <div id="collapseTwelve" class="accordion-collapse collapse" aria-labelledby="headingTwelve" data-bs-parent="#faqAccordion">
                        <div class="accordion-body fs-8 text-muted leading-relaxed">
                            Oui, toutes nos formules de location de sonorisation d'envergure incluent obligatoirement la présence et l'assistance technique d'un ingénieur du son qualifié de notre équipe.
                        </div>
                    </div>
                </div>

                <!-- Question 13 -->
                <div class="accordion-item faq-item border border-light rounded-4 overflow-hidden shadow-sm" data-category="location">
                    <h2 class="accordion-header" id="headingThirteen">
                        <button class="accordion-button collapsed fw-bold text-navy fs-7 d-flex gap-3 align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">
                            <span class="faq-icon-holder"><i class="bi bi-question-circle"></i></span>
                            <div class="flex-grow-1">
                                <span class="d-block fs-9 text-cyan text-uppercase mb-1 tracking-wider">Location &amp; Événements</span>
                                Peut-on louer un véhicule avec chauffeur pour plusieurs jours ?
                            </div>
                        </button>
                    </h2>
                    <div id="collapseThirteen" class="accordion-collapse collapse" aria-labelledby="headingThirteen" data-bs-parent="#faqAccordion">
                        <div class="accordion-body fs-8 text-muted leading-relaxed">
                            Oui, nous proposons des formules de location à la journée, à la semaine ou au mois avec des chauffeurs professionnels bilingues connaissant parfaitement le réseau routier.
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