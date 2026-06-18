@extends('layouts.admin')

@section('title', 'Guide de Référence CRM | Manuel Utilisateur Flycom Services')

@section('content')
<div class="mb-4">
    <h1 class="h3 fw-extrabold text-navy mb-1">Documentation CRM</h1>
    <p class="text-muted fs-8">Guide d'administration et de référence technique du CRM Flycom Services.</p>
</div>

<!-- CONTAINER PRINCIPAL : STRUCTURE SPLIT (Image 2) -->
<div class="row g-4 align-items-stretch text-start">
    
    <!-- COLONNE DE GAUCHE : MENU DE NAVIGATION DU MANUEL UTILISATEUR (30% de largeur) -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm p-3 bg-white rounded-4 h-100" style="min-height: 650px;">
            <div class="position-relative mb-3">
                <span class="position-absolute start-0 top-50 translate-middle-y ms-3 text-muted fs-8"><i class="bi bi-search"></i></span>
                <input type="text" id="docSearch" class="form-control bg-light border-0 py-2 ps-5 fs-8" placeholder="Rechercher une section...">
            </div>
            
            <nav aria-label="Menu de la documentation">
                <ul class="list-unstyled d-flex flex-column gap-1 mb-0" id="docMenu">
                    <li><button class="btn btn-doc-menu active text-start w-100" data-target="pres"><i class="bi bi-book-half me-2"></i> 1. Présentation générale</button></li>
                    <li><button class="btn btn-doc-menu text-start w-100" data-target="dash"><i class="bi bi-speedometer2 me-2"></i> 2. Tableau de bord (Dashboard)</button></li>
                    <li><button class="btn btn-doc-menu text-start w-100" data-target="kanban"><i class="bi bi-kanban me-2"></i> 3. Pipeline &amp; Kanban</button></li>
                    <li><button class="btn btn-doc-menu text-start w-100" data-target="clients"><i class="bi bi-people me-2"></i> 4. Base de données Clients</button></li>
                    <li><button class="btn btn-doc-menu text-start w-100" data-target="devis"><i class="bi bi-file-earmark-pdf me-2"></i> 5. Devis &amp; Facturation</button></li>
                    <li><button class="btn btn-doc-menu text-start w-100" data-target="agenda"><i class="bi bi-calendar3 me-2"></i> 6. Agenda &amp; Relances</button></li>
                    <li><button class="btn btn-doc-menu text-start w-100" data-target="catalogue"><i class="bi bi-grid-3x3-gap"></i> 7. Catalogue de Services</button></li>
                    <li><button class="btn btn-doc-menu text-start w-100" data-target="settings"><i class="bi bi-sliders me-2"></i> 8. Paramètres de l'IA &amp; Système</button></li>
                    <li><button class="btn btn-doc-menu text-start w-100" data-target="roles"><i class="bi bi-shield-lock me-2"></i> 9. Rôles, Permissions &amp; Sécurité</button></li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- COLONNE DE DROITE : CONTENU EXPLICATIF DYNAMIQUE ÉTENDU (AÉRÉ ET SPACIEUX - Image 2 corrigée) -->
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm p-4 p-md-5 bg-white rounded-4 h-100 doc-content-card">
            
            <!-- 1. Présentation du CRM (Actif par défaut) -->
            <article class="doc-pane active" id="pane-pres">
                <h2 class="h4 fw-extrabold text-navy mb-4"><i class="bi bi-book-half text-cyan me-2"></i> 1. Présentation générale du CRM</h2>
                
                <h3 class="h6 fw-bold text-navy mb-2">Contexte du Projet</h3>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    Le CRM de <strong>Flycom Services</strong> (Firme technologique basée au 22, Avenue de Brazza — La Glacière, Brazzaville, République du Congo) a été conçu dans le cadre du projet fil-rouge du programme d'accompagnement académique **D-clic** de l'**Organisation Internationale de la Francophonie (OIF)** avec le mentorat du **Groupe DigiZone**. Ce système répond de manière directe aux lacunes numériques initiales de la structure, notamment l'absence de traçabilité des prospects et la complexité d'édition manuelle des devis commerciaux.
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">Périmètre Technique d'Intégration</h3>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    Le CRM est une application web monopage (*Single Page Application*) codée sous le framework **Laravel 12**, s'appuyant sur une base de données relationnelle **MySQL** (XAMPP locale) et un moteur de rendu frontal compilé en temps réel par **Vite** (Vite + Bootstrap 5 + Vanilla JS) [1, 3, 16].
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">Mécanismes d'Automatisation de l'IA</h3>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    Ce CRM est nativement couplé avec deux agents conversationnels basés sur l'API de traitement de langage naturel de GPT (OpenAI) :
                </p>
                <ul class="list-unstyled d-flex flex-column gap-2 fs-8 text-muted mb-0">
                    <li><i class="bi bi-check-circle-fill text-cyan me-2"></i> <strong>Le Chatbot Web :</strong> Intégré directement sur l'interface publique du site vitrine pour répondre aux questions des visiteurs 24h/24.</li>
                    <li><i class="bi bi-check-circle-fill text-cyan me-2"></i> <strong>L'Agent WhatsApp :</strong> Connecté au numéro de téléphone officiel de Flycom pour qualifier automatiquement les prospects entrants, évaluer leurs besoins en fiches techniques et consigner les échanges directement dans le journal d'activité du CRM [13, 21, 22].</li>
                </ul>
            </article>

            <!-- 2. Dashboard -->
            <article class="doc-pane" id="pane-dash">
                <h2 class="h4 fw-extrabold text-navy mb-4"><i class="bi bi-speedometer2 text-cyan me-2"></i> 2. Tableau de bord (Dashboard)</h2>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    Le Dashboard (Module **M5**) est le centre d'observation macro-économique de Flycom Services [10]. Il synthétise l'ensemble de l'activité en temps réel grâce à des requêtes SQL d'agrégation directes sur votre base locale [10].
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">A. Les 4 Cartes d'Indicateurs (KPIs)</h3>
                <ul class="list-unstyled d-flex flex-column gap-3 fs-8 text-muted mb-4">
                    <li><i class="bi bi-graph-up-arrow text-cyan me-2"></i> <strong>Leads du jour :</strong> Calcule le nombre d'opportunités de vente enregistrées durant la journée en cours [10]. Sa pastille inférieure indique la tendance positive ou neutre de croissance par rapport à la veille.</li>
                    <li><i class="bi bi-person-badge-fill text-primary me-2"></i> <strong>Leads actifs :</strong> Indique le volume total de prospects actuellement en cours de négociation (ceux dont l'état n'est ni "Gagné" ni "Perdu") [10].</li>
                    <li><i class="bi bi-check-circle-fill text-success me-2"></i> <strong>Clients actifs :</strong> Extrait dynamiquement de la table `clients` le nombre total de personnes possédant le statut de contact "Client" [10].</li>
                    <li><i class="bi bi-cash-stack text-navy me-2"></i> <strong>CA Estimé Mois :</strong> Somme en temps réel des montants TTC de toutes vos factures proforma ou devis marqués comme "Acceptés" pour le mois en cours [10].</li>
                </ul>

                <h3 class="h6 fw-bold text-navy mb-2">B. Filtres de Périodes Interactifs (Image 2)</h3>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    En cliquant sur les boutons de périodes (**7 jours**, **30 jours**, **3 mois**), les deux graphiques s'adaptent instantanément avec une transition animée en JavaScript (Chart.js), sans aucun rechargement de page [10] :
                    <br>&bull; <strong>Le graphique circulaire (Donut Chart) :</strong> Analyse la répartition en pourcentage de vos prospects selon leur canal d'acquisition (Site web, WhatsApp, Appel direct, Recommandation).
                    <br>&bull; <strong>Le graphique linéaire (Line Chart) :</strong> Superpose la courbe d'acquisition des nouveaux prospects à celle des ventes conclues (Leads gagnés) sur la période choisie.
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">C. Alertes &amp; Relances Commerciales</h3>
                <p class="text-muted fs-8 leading-relaxed mb-0">
                    Le panneau de droite affiche de manière prioritaire deux alertes opérationnelles :
                    <br>&bull; <strong>Relances du jour :</strong> Les rendez-vous d'appels planifiés pour aujourd'hui avec un bouton d'appel téléphonique rapide.
                    <br>&bull; <strong>Devis en attente (+7j) :</strong> Liste les propositions de devis envoyées aux clients depuis plus de 7 jours et toujours sans réponse de leur part. Un bouton rapide "Relancer" vous permet de relancer immédiatement la négociation.
                </p>
            </article>

            <!-- 3. Pipeline Kanban -->
            <article class="doc-pane" id="pane-kanban">
                <h2 class="h4 fw-extrabold text-navy mb-4"><i class="bi bi-kanban text-cyan me-2"></i> 3. Pipeline Commercial (Kanban &amp; Liste)</h2>
                
                <h3 class="h6 fw-bold text-navy mb-2">A. Fonctionnement du Kanban (Glisser-Déposer)</h3>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    Le tableau Kanban est découpé en 6 colonnes de statuts (*Nouveau, Contacté, Devis envoyé, Négociation, Gagné, Perdu*) [6.2]. 
                    <br><strong>Pour modifier le statut d'un prospect :</strong> Cliquez sur sa carte, maintenez le clic, glissez-la vers la colonne de votre choix et relâchez le bouton de la souris (Drag &amp; Drop). Le script effectue une mise à jour silencieuse en base de données en arrière-plan et affiche un message Toast de confirmation sans recharger l'écran [1, 8] !
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">B. Consultation des Fiches de Détails</h3>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    Pour ouvrir l'aperçu détaillé d'une opportunité, **cliquez simplement n'importe où sur le rectangle d'une carte**. Une requête AJAX est émise, pré-remplit instantanément le modal de détails avec l'historique complet des échanges, et vous donne accès aux actions rapides (Édition de devis, envoi d'e-mail, suppression) [1].
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">C. Formulaire de Création d'un Lead</h3>
                <p class="text-muted fs-8 leading-relaxed mb-0">
                    Cliquez sur le bouton **"+ Nouveau lead"** pour ouvrir le formulaire.
                    <br>1. Sélectionnez le client d'origine (ou créez sa fiche au préalable dans l'onglet *Clients* si c'est un nouveau contact) [14].
                    <br>2. Choose la source du contact (ex: WhatsApp) et le degré d'urgence (Priorité) [7].
                    <br>3. Planifiez une date et heure de relance dans le calendrier [7].
                    <br>4. <strong>Liaison relationnelle N-N :</strong> Cochez les bases des services concernés par la demande (ex: *Panneaux Solaires* et *Vidéosurveillance*). À la soumission, ces lignes alimenteront automatiquement la table associative `lead_services` [8].
                </p>
            </article>

            <!-- 4. Base de données Clients -->
            <article class="doc-pane" id="pane-clients">
                <h2 class="h4 fw-extrabold text-navy mb-4"><i class="bi bi-people text-cyan me-2"></i> 4. Base de données Clients</h2>
                
                <h3 class="h6 fw-bold text-navy mb-2">A. Manipulation du tableau</h3>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    La base de données clients regroupe l'ensemble de vos fiches de contacts. Vous pouvez y effectuer des recherches textuelles rapides par nom de famille ou prénom, ou filtrer l'affichage par types de relations (*Prospect, Client actif, Partenaire*) [10].
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">B. Création manuelle d'un contact</h3>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    Cliquez sur **"+ Nouveau client"** pour ouvrir le formulaire d'ajout rapide.
                    <br>⚠️ **Règle de sécurité d'indexation :** Le numéro de téléphone est un index unique en base de données pour empêcher la duplication accidentelle des fiches clients [4]. Tenter d'enregistrer un client possédant un numéro déjà existant en base de données provoquera un message d'alerte bloquant [4].
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">C. Importation en lot par fichier CSV</h3>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    Pour intégrer en une seconde un grand annuaire de contacts provenant de votre ancien tableur Excel :
                    <br>1. Cliquez sur **"Importer CSV"** pour ouvrir la boîte de dialogue [10].
                    <br>2. Glissez-déposez votre fichier de données à l'intérieur du rectangle en pointillés (il s'allume en vert et affiche le nom du fichier) ou cliquez sur "Parcourir" [1].
                    <br>3. Cliquez sur **"Lancer l'importation"** [10].
                    <br><strong>Logique anti-doublon d'importation (UPSERT) :</strong> Notre contrôleur lit le fichier ligne par ligne. Si un numéro de téléphone existe déjà en base, il met à jour la fiche existante avec les nouvelles coordonnées au lieu de créer un doublon inesthétique en base de données [4, 10].
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">D. Exportation instantanée</h3>
                <p class="text-muted fs-8 leading-relaxed mb-0">
                    Cliquer sur le bouton **Export** télécharge instantanément l'intégralité de vos fiches de contacts au format CSV codé en UTF-8 (séparateur point-virgule), garantissant une ouverture propre et lisible avec toutes vos lettres accentuées sous Excel !
                </p>
            </article>

            <!-- 5. Devis -->
            <article class="doc-pane" id="pane-devis">
                <h2 class="h4 fw-extrabold text-navy mb-4"><i class="bi bi-file-earmark-pdf text-cyan me-2"></i> 5. Module Devis &amp; Facturation</h2>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    C'est le module de gestion comptable et d'engagement de votre CRM (Module **M4**) [10]. Il sépare les propositions financières (*Devis*) des factures proforma [6.1].
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">Édition d'un Devis dynamique</h3>
                <p class="text-muted fs-8 leading-relaxed mb-3">
                    Cliquez sur **"+ Nouveau devis"** pour ouvrir le panneau de configuration financière :
                </p>
                <ul class="list-unstyled d-flex flex-column gap-2 fs-8 text-muted mb-4">
                    <li><i class="bi bi-plus-lg text-cyan me-2"></i> <strong>Liaisons Client/Lead :</strong> Sélectionner une opportunité lie automatiquement le client associé pour vous faire gagner du temps.</li>
                    <li><i class="bi bi-plus-lg text-cyan me-2"></i> <strong>Ajouter une ligne :</strong> Cliquez pour ajouter une ligne d'article. Sélectionner un service de la base MySQL pré-remplit instantanément son tarif unitaire catalogue [10].</li>
                    <li><i class="bi bi-plus-lg text-cyan me-2"></i> <strong>Calculateur dynamique :</strong> Modifier une quantité ou appliquer un pourcentage de TVA recalcule instantanément le Total HT et le Total TTC en temps réel à l'écran, avant l'enregistrement en base de données !</li>
                </ul>

                <h3 class="h6 fw-bold text-navy mb-2">Exploration des détails et Actions rapides</h3>
                <p class="text-muted fs-8 leading-relaxed mb-3">
                    Cliquez n'importe où sur une ligne du tableau pour ouvrir sa fiche d'aperçu glacée :
                </p>
                <ul class="list-unstyled d-flex flex-column gap-2 fs-8 text-muted mb-0">
                    <li><i class="bi bi-printer-fill text-cyan me-2"></i> <strong>Télécharger PDF :</strong> Ouvre votre facture au format A4 d'impression réglementaire et déclenche directement la boîte de dialogue d'enregistrement PDF de votre système d'exploitation [1].</li>
                    <li><i class="bi bi-envelope-fill text-cyan me-2"></i> <strong>Envoyer par email :</strong> Ouvre le second sous-modal pré-rempli avec l'e-mail du client, l'objet de facturation et le message d'audit de garde. Cliquez sur "Envoyer" pour acheminer l'e-mail [1].</li>
                    <li><i class="bi bi-sliders text-cyan me-2"></i> <strong>Modifier le statut :</strong> Permet de passer le devis à l'état "Accepté" ou "Refuse". <strong>Règle d'intégrité (MLD) :</strong> Passer un devis en "Accepté" passe automatiquement l'opportunité associée à "Gagné" et le prospect à "Client actif" de manière transparente [7].</li>
                    <li><i class="bi bi-trash-fill text-danger me-2"></i> <strong>Supprimer :</strong> Supprime proprement le document en base locale et applique un estompement de ligne fluide [1].</li>
                </ul>
            </article>

            <!-- 6. Agenda -->
            <article class="doc-pane" id="pane-agenda">
                <h2 class="h4 fw-extrabold text-navy mb-4"><i class="bi bi-calendar3 text-cyan me-2"></i> 6. Agenda &amp; Suivi des Relances</h2>
                
                <h3 class="h6 fw-bold text-navy mb-2">A. Consultation du Calendrier Mensuel</h3>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    L'agenda est une grille mensuelle calculée dynamiquement par Laravel. Chaque jour du mois affiche de petites pastilles d'événements jaunes au nom des prospects à recontacter pour la journée (ex: `Jocelyn B.`). Passer d'un mois à l'autre s'exécute à l'aide des flèches directionnelles gauches et droites.
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">B. Traitement des Retards de Relance</h3>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    Le compartiment latéral de droite extrait de la base de données toutes les relances dont l'horaire de rendez-vous est dépassé et dont l'affaire n'est pas encore conclue. Vous disposez de deux actions rapides :
                    <br>&bull; <strong>Bouton "Fait" :</strong> Marque la relance comme traitée.
                    <br>&bull; <strong>Bouton "Demain" :</strong> Repousse automatiquement le rendez-vous d'appel à demain à la même heure.
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">C. Programmation d'un rappel</h3>
                <p class="text-muted fs-8 leading-relaxed mb-0">
                    Cliquez sur **"Nouvelle relance"** pour ouvrir le formulaire. Sélectionnez l'opportunité commerciale (Lead), déterminez le jour, l'heure exacte (DATETIME de précision pour l'IA WhatsApp) et rédigé une note de rappel qui s'ajoutera à la fiche client [7, 17].
                </p>
            </article>

            <!-- 7. Catalogue Services -->
            <article class="doc-pane" id="pane-catalogue">
                <h2 class="h4 fw-extrabold text-navy mb-4"><i class="bi bi-grid-3x3-gap text-cyan me-2"></i> 7. Catalogue de Services</h2>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    Ce module permet d'administrer les 8 prestations techniques de Flycom de manière dynamique.
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">A. Gestion de l'état d'activation</h3>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    Chaque service possède un commutateur d'état d'activation (**Actif / Inactif**). Désactiver un service dans votre CRM (le badge passe au rouge) le masque instantanément du site vitrine public pour les visiteurs, et l'exclut des options de création de devis !
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">B. Création et Modification</h3>
                <p class="text-muted fs-8 leading-relaxed mb-0">
                    Cliquez sur **"Modifier"** sur la carte d'un service pour ouvrir sa fiche. L'interface charge en AJAX l'intitulé, la description, l'unité et la vignette de l'image actuelle [1]. Vous pouvez modifier les tarifs indicatifs ou sélectionner un nouveau fichier d'image (formats `.jpg`, `.png`, `.webp` supportés) qui sera stocké de manière sécurisée dans le répertoire local `public/assets/images/` de l'application [1].
                </p>
            </article>

            <!-- 8. Paramètres -->
            <article class="doc-pane" id="pane-settings">
                <h2 class="h4 fw-extrabold text-navy mb-4"><i class="bi bi-sliders text-cyan me-2"></i> 8. Paramètres de l'IA et du Système</h2>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    Ce panneau est divisé en 5 sous-onglets pour administrer le CRM et les agents conversationnels [13] :
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">A. Paramètres fiscaux et d'IA WhatsApp</h3>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    *   **Fiscalité :** Permet d'ajuster le taux de TVA général appliqué par défaut lors de l'édition de chaque nouveau devis [13].
                    *   **IA WhatsApp :** Contient le commutateur global d'activation de votre agent d'Intelligence Artificielle. Vous pouvez configurer l'heure de début et l'heure de fin d'activité de l'IA [13, 21].
                    *   <strong>Règle d'or de l'IA :</strong> Si l'agent IA est désactivé, ou si l'utilisateur envoie un message en dehors de la plage horaire ouvrée que vous avez configurée (ex: la nuit à 23h), l'IA ne répondra pas automatiquement et l'opportunité sera directement escaladée dans votre colonne "Nouveau" du CRM avec une notification d'urgence pour vos commerciaux [13, 21].
                </p>

                <h3 class="h6 fw-bold text-navy mb-2">B. Journal d'activité IA</h3>
                <p class="text-muted fs-8 leading-relaxed mb-0">
                    Il répertorie toutes les conversations menées en direct par votre Chatbot ou votre agent WhatsApp, affichant l'horaire de l'échange, l'identité du contact et le résumé de qualification rédigé par l'IA pour vous permettre de suivre son efficacité [22].
                </p>
            </article>

            <!-- 9. Rôles & Permissions -->
            <article class="doc-pane" id="pane-roles">
                <h2 class="h4 fw-extrabold text-navy mb-4"><i class="bi bi-shield-lock text-cyan me-2"></i> 9. Rôles, Permissions et Sécurité</h2>
                <p class="text-muted fs-8 leading-relaxed mb-4">
                    Le CRM protège et cloisonne les données en fonction du niveau d'habilitation de l'utilisateur connecté dans la session [11.1] :
                </p>
                <ul class="list-unstyled d-flex flex-column gap-3 fs-8 text-muted mb-0">
                    <li><i class="bi bi-person-fill-lock text-cyan me-2"></i> <strong>1. Administrateur (Budry) :</strong> Détient un contrôle d'accès total [11.1]. C'est le seul rôle autorisé à accéder à l'onglet "Paramètres", à ajouter de nouveaux collaborateurs en base, ou à modifier les taux de TVA d'entreprise [6, 11.1].</li>
                    <li><i class="bi bi-person-fill-gear text-cyan me-2"></i> <strong>2. Commercial (Claunelle) :</strong> Habilités à modifier le pipeline Kanban, à créer et mettre à jour des fiches clients, à planifier des relances d'agenda et à générer des devis d'intégration [11.1]. L'accès aux configurations d'IA et à la gestion de la TVA leur est bloqué.</li>
                    <li><i class="bi bi-person-fill-exclamation text-cyan me-2"></i> <strong>3. Lecture Seule (Direction) :</strong> Destiné à la consultation d'audit [11.1]. Les utilisateurs de ce rôle peuvent observer l'activité du Dashboard et du Kanban, mais tous les boutons de suppressions, d'éditions et de créations leur sont désactivés ou masqués à l'écran.</li>
                </ul>
            </article>

        </div>
    </div>

</div>

<!-- STYLE DE SÉCURITÉ POUR LA COMMUTATION FLUIDE AVEC HAUTEUR CONFORME DE GAUCHE ET DE DROITE (UX) -->
<style>
    .doc-pane {
        display: none;
    }
    .doc-pane.active {
        display: block;
        animation: fadeInDoc 0.3s ease-out forwards;
    }

    /* Boîte de contenu de droite aérée à grande hauteur alignée sur la gauche */
    .doc-content-card {
        min-height: 650px; /* Aligne la hauteur de lecture sur la colonne de gauche */
        overflow-y: auto;
        max-height: calc(100vh - 200px); /* Dégage proprement le bas de l'écran */
    }

    /* Style des boutons de navigation de la doc */
    .btn-doc-menu {
        background: transparent;
        border: none;
        color: #4A5B73;
        font-size: 0.8rem;
        font-weight: 700;
        padding: 10px 15px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .btn-doc-menu:hover {
        background-color: #F8F9FA;
        color: #00D2F4;
    }

    /* État actif conforme (Image 2) */
    .btn-doc-menu.active {
        background-color: rgba(0, 210, 244, 0.08) !important;
        color: #00D2F4 !important;
        font-weight: 700;
    }

    @keyframes fadeInDoc {
        from {
            opacity: 0;
            transform: translateY(4px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<!-- SCRIPT DE COMMUTATION INTERACTIVE ET DE RECHERCHE DANS LA DOCUMENTATION -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const docButtons = document.querySelectorAll('.btn-doc-menu');
    const docPanes = document.querySelectorAll('.doc-pane');
    const searchInput = document.getElementById('docSearch');

    // 1. Commutation des thèmes sans rechargement de page
    if (docButtons.length > 0) {
        docButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                docButtons.forEach(b => b.classList.remove('active'));
                docPanes.forEach(pane => pane.classList.remove('active'));

                btn.classList.add('active');

                const targetPaneId = 'pane-' + btn.getAttribute('data-target');
                const targetPane = document.getElementById(targetPaneId);
                if (targetPane) {
                    targetPane.classList.add('active');
                }
            });
        });
    }

    // 2. Recherche textuelle rapide dans le menu de gauche
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            docButtons.forEach(btn => {
                const text = btn.innerText.toLowerCase();
                if (text.includes(query)) {
                    btn.style.display = 'block';
                } else {
                    btn.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endsection