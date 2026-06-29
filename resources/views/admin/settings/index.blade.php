@extends('layouts.admin')

@section('title', 'Configuration du Système | Flycom Services CRM')

@section('content')
<div class="mb-4">
    <h1 class="h3 fw-extrabold text-navy mb-1">Paramètres</h1>
    <p class="text-muted small mb-0">Configuration globale du système Flycom CRM.</p>
</div>

<!-- Zone de notification de succès -->
@if(session('success'))
    <div class="alert alert-success fs-8 py-2.5 rounded-3 mb-4 border-0">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
@endif

<!-- Zone de notification d'erreur (Nouveau : Indispensable pour l'échec de lecture PDF) -->
@if(session('error'))
    <div class="alert alert-danger fs-8 py-2.5 rounded-3 mb-4 border-0">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
    </div>
@endif

<!-- BARRE DE COMMUTATION DES 6 SOUS-ONGLETS -->
<div class="d-flex flex-wrap gap-2 mb-4">
    <button class="btn btn-sub-tab active" data-tab="entreprise"><i class="bi bi-building me-1"></i> Entreprise</button>
    <button class="btn btn-sub-tab" data-tab="fiscal"><i class="bi bi-percent me-1"></i> Fiscal &amp; TVA</button>
    <button class="btn btn-sub-tab" data-tab="ia"><i class="bi bi-whatsapp me-1"></i> IA WhatsApp</button>
    <button class="btn btn-sub-tab" data-tab="ia-web"><i class="bi bi-robot me-1"></i> IA Site Web</button>
    <button class="btn btn-sub-tab" data-tab="journal"><i class="bi bi-journal-activity me-1"></i> Journal activité</button>
    <button class="btn btn-sub-tab" data-tab="utilisateurs"><i class="bi bi-people me-1"></i> Utilisateurs</button>
</div>

<!-- ========================================== -->
<!-- SOUS-ONGLET 1 : ENTREPRISE                 -->
<!-- ========================================== -->
<div class="settings-tab-pane active" id="tab-entreprise">
    <div class="card border-0 shadow-sm p-4 bg-white rounded-4 mb-4">
        <h2 class="h6 fw-extrabold text-navy mb-4"><i class="bi bi-info-circle-fill text-cyan me-2"></i> Informations entreprise</h2>
        
        <form action="{{ route('admin.settings.updateEntreprise') }}" method="POST" class="row g-3 fs-8 text-start">
            @csrf
            <div class="col-md-6">
                <label class="form-label fw-bold text-navy text-uppercase">Nom de l'entreprise</label>
                <input type="text" name="nom_entreprise" class="form-control bg-light border-light py-2 fs-8" value="{{ $configs['nom_entreprise'] ?? 'Flycom Services' }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold text-navy text-uppercase">Téléphone</label>
                <input type="text" name="telephone" class="form-control bg-light border-light py-2 fs-8" value="{{ $configs['telephone_entreprise'] ?? '+242066285741' }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold text-navy text-uppercase">Email de contact</label>
                <input type="email" name="email_contact" class="form-control bg-light border-light py-2 fs-8" value="{{ $configs['email_entreprise'] ?? 'contact@flycomservices.cg' }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold text-navy text-uppercase">Adresse</label>
                <input type="text" name="adresse" class="form-control bg-light border-light py-2 fs-8" value="{{ $configs['adresse_entreprise'] ?? '22, Avenue de Brazza — La Glacière, Brazzaville' }}" required>
            </div>
            <div class="col-12 mt-4 text-end">
                <button type="submit" class="btn btn-navy rounded-3 fs-8 fw-bold px-4 py-2 text-white" style="background:#0D1B4B; border:none;"><i class="bi bi-save me-1"></i> Enregistrer</button>
            </div>
        </form>
    </div>

    <!-- Carte Profil Connecté -->
    <div class="card border-0 shadow-sm p-4 bg-white rounded-4">
        <h2 class="h6 fw-extrabold text-navy mb-3"><i class="bi bi-person-badge-fill text-cyan me-2"></i> Profil connecté</h2>
        <div class="p-3 rounded-4 d-flex align-items-center gap-3 border border-light bg-light max-w-sm text-start">
            <div class="avatar-circle">
                {{ substr(Auth::user()->prenom_user, 0, 1) }}{{ substr(Auth::user()->nom_user, 0, 1) }}
            </div>
            <div>
                <span class="d-block fw-bold text-navy fs-8">{{ Auth::user()->prenom_user }} {{ Auth::user()->nom_user }}</span>
                <small class="text-muted d-block mb-1">Email : {{ Auth::user()->email }}</small>
                <span class="badge bg-navy-dark text-white fs-10 fw-bold">{{ Auth::user()->role }}</span>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- SOUS-ONGLET 2 : FISCAL & TVA               -->
<!-- ========================================== -->
<div class="settings-tab-pane" id="tab-fiscal">
    <div class="card border-0 shadow-sm p-4 bg-white rounded-4 mb-4">
        <h2 class="h6 fw-extrabold text-navy mb-4"><i class="bi bi-percent text-cyan me-2"></i> Paramètres fiscaux</h2>
        
        <form action="{{ route('admin.settings.updateFiscal') }}" method="POST" class="row g-3 fs-8 text-start">
            @csrf
            <div class="col-md-6">
                <label for="tva_taux" class="form-label fw-bold text-navy text-uppercase">Taux TVA (%)</label>
                <input type="number" name="tva_taux" id="tva_taux" class="form-control bg-light border-light py-2 fs-8" value="{{ $configs['tva_taux_defaut'] ?? '0' }}" min="0" max="100" required>
                <small class="text-muted fs-10 mt-1 d-block">0% = exonération de la TVA (régime spécial franchise de base).</small>
            </div>
            <div class="col-md-6">
                <label for="devise" class="form-label fw-bold text-navy text-uppercase">Devise</label>
                <select name="devise" id="devise" class="form-select bg-light border-light py-2 fs-8" required>
                    <option value="FCFA" selected>FCFA - Franc CFA</option>
                    <option value="EUR">EUR - Euro</option>
                    <option value="USD">USD - Dollar US</option>
                </select>
            </div>
            <div class="col-12 mt-4 text-end">
                <button type="submit" class="btn btn-navy rounded-3 fs-8 fw-bold px-4 py-2 text-white" style="background:#0D1B4B; border:none;"><i class="bi bi-save me-1"></i> Enregistrer</button>
            </div>
        </form>
    </div>

    <!-- Message fiscal informatif de la DGID Congo -->
    <div class="card border-0 shadow-sm p-4 bg-warning-transparent rounded-4 border border-warning-subtle text-start">
        <div class="d-flex gap-3 align-items-start fs-8">
            <i class="bi bi-info-circle-fill text-warning fs-4"></i>
            <div>
                <strong class="text-warning d-block mb-1">Configuration fiscale Congo</strong>
                <p class="mb-0 text-muted leading-relaxed">
                    Le régime de la TVA au Congo-Brazzaville est fixé à un taux standard de 18%. Flycom Services peut bénéficier d'un régime de franchise en base de TVA selon le chiffre d'affaires annuel. Consultez votre expert-comptable pour confirmer l'admissibilité de votre structure.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- SOUS-ONGLET 3 : IA WHATSAPP                -->
<!-- ========================================== -->
<div class="settings-tab-pane" id="tab-ia">
    <div class="card border-0 shadow-sm p-4 bg-white rounded-4 mb-4">
        <h2 class="h6 fw-extrabold text-navy mb-4"><i class="bi bi-robot text-cyan me-2"></i> Agent IA WhatsApp</h2>
        
        <form action="{{ route('admin.settings.updateIA') }}" method="POST" class="row g-3 fs-8 text-start">
            @csrf
            
            <!-- Commutateur IA On/Off -->
            <div class="col-12">
                <div class="form-check form-switch p-3 rounded-4 border border-light bg-light d-flex align-items-center justify-content-between">
                    <div>
                        <strong class="text-navy d-block fs-8 mb-1">Activer l'agent IA</strong>
                        <span class="text-muted fs-10 d-block">Réponse automatique aux messages WhatsApp entrants</span>
                    </div>
                    <input class="form-check-input me-1" type="checkbox" name="whatsapp_ia_active" id="iaActive" value="true" {{ ($configs['whatsapp_ia_active'] ?? 'true') === 'true' ? 'checked' : '' }} style="width: 38px; height: 18px; cursor:pointer;">
                </div>
            </div>

            <!-- Horaires -->
            <div class="col-md-6 mt-4">
                <label for="heure_ouverture" class="form-label fw-bold text-navy text-uppercase">Heure début</label>
                <input type="time" name="heure_ouverture" id="heure_ouverture" class="form-control bg-light border-light py-2 fs-8" value="{{ $configs['heure_ouverture'] ?? '08:00' }}" required>
            </div>
            <div class="col-md-6 mt-4">
                <label for="heure_fermeture" class="form-label fw-bold text-navy text-uppercase">Heure fin</label>
                <input type="time" name="heure_fermeture" id="heure_fermeture" class="form-control bg-light border-light py-2 fs-8" value="{{ $configs['heure_fermeture'] ?? '18:00' }}" required>
            </div>

            <!-- Jours ouvrables -->
            <div class="col-12 mt-4">
                <label for="jours_ouvrables" class="form-label fw-bold text-navy text-uppercase">Jours ouvrables</label>
                <select name="jours_ouvrables" id="jours_ouvrables" class="form-select bg-light border-light py-2 fs-8" required>
                    <option value="Lun-Sam" {{ ($configs['jours_ouvrables'] ?? '') === 'Lun-Sam' ? 'selected' : '' }}>Lundi - Samedi</option>
                    <option value="Lun-Ven" {{ ($configs['jours_ouvrables'] ?? '') === 'Lun-Ven' ? 'selected' : '' }}>Lundi - Vendredi</option>
                    <option value="Tous" {{ ($configs['jours_ouvrables'] ?? '') === 'Tous' ? 'selected' : '' }}>Tous les jours</option>
                </select>
            </div>

            <div class="col-12 mt-4 text-end">
                <button type="submit" class="btn btn-navy rounded-3 fs-8 fw-bold px-4 py-2 text-white" style="background:#0D1B4B; border:none;"><i class="bi bi-save me-1"></i> Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- SOUS-ONGLET 3.5 : IA SITE WEB (Avec Upload PDF et multipart/form-data) -->
<!-- ========================================== -->
<div class="settings-tab-pane" id="tab-ia-web">
    <div class="card border-0 shadow-sm p-4 bg-white rounded-4 mb-4">
        <h2 class="h6 fw-extrabold text-navy mb-4"><i class="bi bi-robot text-cyan me-2"></i> Assistant IA Site Web (Vitrine)</h2>
        
        <!-- Ajout de l'enctype multipart/form-data indispensable pour téléverser un fichier PDF (Image 21) -->
        <form action="{{ route('admin.settings.updateWebIA') }}" method="POST" enctype="multipart/form-data" class="row g-3 fs-8 text-start">
            @csrf
            
            <!-- Commutateur IA On/Off -->
            <div class="col-12">
                <div class="form-check form-switch p-3 rounded-4 border border-light bg-light d-flex align-items-center justify-content-between">
                    <div>
                        <strong class="text-navy d-block fs-8 mb-1">Activer l'assistant virtuel</strong>
                        <span class="text-muted fs-10 d-block">Réponse automatique aux internautes du site vitrine</span>
                    </div>
                    <input class="form-check-input me-1" type="checkbox" name="chatbot_active" id="webIaActive" value="true" {{ ($configs['chatbot_active'] ?? 'true') === 'true' ? 'checked' : '' }} style="width: 38px; height: 18px; cursor:pointer;">
                </div>
            </div>

            <!-- Choix du modèle d'IA -->
            <div class="col-12 mt-4">
                <label for="gemini_model" class="form-label fw-bold text-navy text-uppercase">Modèle d'Intelligence Artificielle</label>
                <select name="gemini_model" id="gemini_model" class="form-select bg-light border-light py-2 fs-8" required>
                    <option value="gemini-1.5-flash" {{ ($configs['gemini_model'] ?? '') === 'gemini-1.5-flash' ? 'selected' : '' }}>Gemini 1.5 Flash (Ancienne génération)</option>
                    <option value="gemini-2.5-flash" {{ ($configs['gemini_model'] ?? '') === 'gemini-2.5-flash' ? 'selected' : '' }}>Gemini 2.5 Flash (Recommandé - Stable)</option>
                    <option value="gemini-3.5-flash" {{ ($configs['gemini_model'] ?? 'gemini-3.5-flash') === 'gemini-3.5-flash' ? 'selected' : '' }}>Gemini 3.5 Flash (Dernière génération - Ultra-rapide)</option>
                </select>
            </div>

            <!-- Consignes système (System Prompt) -->
            <div class="col-12 mt-4">
                <label for="chatbot_system_prompt" class="form-label fw-bold text-navy text-uppercase">Consignes de comportement (Prompt)</label>
                <textarea name="chatbot_system_prompt" id="chatbot_system_prompt" class="form-control bg-light border-light py-2 fs-8 text-muted" rows="5" required>{{ $configs['chatbot_system_prompt'] ?? "Tu es l'assistant virtuel de Flycom Services à Brazzaville. Reste courtois, professionnel et très concis (2-3 phrases maximum)." }}</textarea>
                <small class="text-muted fs-10 mt-1 d-block">Détermine l'identité, le ton et les limites de comportement de votre IA d'accueil.</small>
            </div>

            <!-- Base de connaissances textuelle (Knowledge Base) -->
            <div class="col-12 mt-4">
                <label for="chatbot_knowledge_base" class="form-label fw-bold text-navy text-uppercase">Base de connaissances complémentaire</label>
                <textarea name="chatbot_knowledge_base" id="chatbot_knowledge_base" class="form-control bg-light border-light py-2 fs-8 text-muted" rows="6" placeholder="Exemple :
- Nos bureaux sont situés à La Glacière, Brazzaville, en face de la pharmacie.
- Nous acceptons les règlements par Airtel Money et MTN Mobile Money.
- Le gérant est M. Budry Nakouzebi, joignable directement au +242 06 628 57 41.">{{ $configs['chatbot_knowledge_base'] ?? '' }}</textarea>
                <small class="text-muted fs-10 mt-1 d-block">Ajoutez ici toutes les informations spécifiques à votre entreprise (horaires, coordonnées, politiques de prix, détails de contact) dont l'IA aura besoin pour répondre.</small>
            </div>

            <!-- NOUVEAU : Téléchargement de document PDF de connaissances (Image 21) -->
            <div class="col-12 mt-4">
                <label for="chatbot_knowledge_pdf" class="form-label fw-bold text-navy text-uppercase">Document PDF de connaissances (Complémentaire)</label>
                <input type="file" name="chatbot_knowledge_pdf" id="chatbot_knowledge_pdf" class="form-control bg-light border-light py-2 fs-8" accept=".pdf" style="box-shadow: none !important;">
                <small class="text-muted fs-10 mt-1 d-block">Téléversez un fichier PDF (tarifs détaillés, catalogue de produits, conditions générales, etc.) pour alimenter automatiquement la base de connaissances.</small>
                
                <!-- Badge d'affichage du fichier actif si déjà enregistré -->
                @if(isset($configs['chatbot_knowledge_pdf_filename']))
                    <div class="alert alert-info py-2 px-3 rounded-3 mt-3 d-flex align-items-center gap-2 border-0 fs-10 fw-semibold text-info" style="background-color: #EFF6FF; width: fit-content;">
                        <i class="bi bi-file-earmark-pdf-fill fs-5"></i> 
                        <span>Fichier actif analysé : <strong>{{ $configs['chatbot_knowledge_pdf_filename'] }}</strong></span>
                    </div>
                @endif
            </div>

            <div class="col-12 mt-4 text-end">
                <button type="submit" class="btn btn-navy rounded-3 fs-8 fw-bold px-4 py-2 text-white" style="background:#0D1B4B; border:none;"><i class="bi bi-save me-1"></i> Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- SOUS-ONGLET 4 : JOURNAL D'ACTIVITÉ         -->
<!-- ========================================== -->
<div class="settings-tab-pane" id="tab-journal">
    <div class="card border-0 shadow-sm p-4 bg-white rounded-4">
        <div class="mb-4">
            <h2 class="h6 fw-extrabold text-navy mb-1"><i class="bi bi-journal-text text-cyan me-2"></i> Journal d'activité IA &amp; Système</h2>
            <p class="text-muted fs-9 mb-0">Dernières interactions automatisées (Chatbot, WhatsApp IA)</p>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 fs-8 text-start">
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 20%;">Date</th>
                        <th scope="col" style="width: 15%;">Canal</th>
                        <th scope="col" style="width: 25%;">Client</th>
                        <th scope="col" style="width: 40%;">Détail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($iaLogs as $log)
                    <tr class="table-row-hover">
                        <td class="text-muted">{{ $log->date->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($log->type_canal === 'WhatsApp')
                                <span class="badge bg-success-soft text-success px-2 py-1 rounded-3 fs-10 fw-bold">WhatsApp</span>
                            @else
                                <span class="badge bg-primary-soft text-primary px-2 py-1 rounded-3 fs-10 fw-bold">Chatbot</span>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $log->client->prenom }} {{ $log->client->nom }}</td>
                        <td class="text-muted text-truncate" style="max-width: 300px;">{{ $log->note }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">Aucun journal d'activité enregistré pour l'instant.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- SOUS-ONGLET 5 : UTILISATEURS               -->
<!-- ========================================== -->
<div class="settings-tab-pane" id="tab-utilisateurs">
    <div class="card border-0 shadow-sm p-4 bg-white rounded-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h6 fw-extrabold text-navy mb-1"><i class="bi bi-people-fill text-cyan me-2"></i> Gestion des utilisateurs</h2>
                <p class="text-muted fs-9 mb-0">Déclarez les accès et comptes de garde de vos collaborateurs.</p>
            </div>
            <button class="btn rounded-3 px-3 py-2 text-white fw-bold fs-8" style="background:#0D1B4B; border:none;" data-bs-toggle="modal" data-bs-target="#newUserModal">
                <i class="bi bi-plus-lg me-1"></i> Ajouter un utilisateur
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 fs-8 text-start">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Utilisateur</th>
                        <th scope="col">Email</th>
                        <th scope="col">Rôle</th>
                        <th scope="col">Dernière connexion</th>
                        <th scope="col">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="table-row-hover">
                        <td class="fw-bold text-navy d-flex align-items-center gap-3">
                            <div class="avatar-circle" style="width: 32px; height: 32px; font-size: 0.72rem; box-shadow: none;">
                                {{ substr($user->prenom_user, 0, 1) }}{{ substr($user->nom_user, 0, 1) }}
                            </div>
                            <span>{{ $user->prenom_user }} {{ $user->nom_user }}</span>
                        </td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            <span class="badge @if($user->role === 'Admin') bg-primary-soft text-primary @elseif($user->role === 'System_Bot') bg-info-soft text-info @else bg-warning-soft text-warning @endif px-2 py-1 rounded-3 fw-bold fs-10">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="text-muted">
                            {{ $user->derniere_connexion ? $user->derniere_connexion->translatedFormat('d/m/Y H:i') : 'Jamais' }}
                        </td>
                        <td>
                            <span class="badge bg-success-soft text-success px-2 py-1 rounded-3 fs-10 fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Actif</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL : AJOUTER UN UTILISATEUR             -->
<!-- ========================================== -->
<div class="modal fade" id="newUserModal" tabindex="-1" aria-labelledby="newUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg bg-white text-navy">
            <div class="modal-header border-bottom border-light px-4 py-3">
                <h5 class="modal-title fw-extrabold text-navy" id="newUserModalLabel" style="font-size: 1.15rem;">Ajouter un utilisateur</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.settings.storeUser') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-4 row g-3 fs-8 text-start">
                    
                    <div class="col-md-6">
                        <label for="prenom_user" class="form-label fw-bold text-muted text-uppercase mb-2" style="font-size: 0.72rem;">Prénom *</label>
                        <input type="text" name="prenom_user" id="prenom_user" class="form-control bg-light border-light py-2 fs-8" placeholder="Votre prénom" required style="box-shadow:none !important;">
                    </div>

                    <div class="col-md-6">
                        <label for="nom_user" class="form-label fw-bold text-muted text-uppercase mb-2" style="font-size: 0.72rem;">Nom *</label>
                        <input type="text" name="nom_user" id="nom_user" class="form-control bg-light border-light py-2 fs-8" placeholder="Votre nom" required style="box-shadow:none !important;">
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label fw-bold text-muted text-uppercase mb-2" style="font-size: 0.72rem;">Email *</label>
                        <input type="email" name="email" id="email" class="form-control bg-light border-light py-2 fs-8" placeholder="collaborateur@flycom.cg" required style="box-shadow:none !important;">
                    </div>

                    <div class="col-12">
                        <label for="role" class="form-label fw-bold text-muted text-uppercase mb-2" style="font-size: 0.72rem;">Rôle *</label>
                        <select name="role" id="role" class="form-select bg-light border-light py-2 fs-8" required style="box-shadow:none !important;">
                            <option value="Commercial" selected>Commercial</option>
                            <option value="Admin">Admin</option>
                            <option value="Lecture">Lecture seule</option>
                            <option value="System_Bot">System Bot (IA)</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="password" class="form-label fw-bold text-muted text-uppercase mb-2" style="font-size: 0.72rem;">Mot de passe temporaire *</label>
                        <input type="password" name="password" id="password" class="form-control bg-light border-light py-2 fs-8" placeholder="••••••••" required style="box-shadow:none !important;">
                    </div>

                </div>
                <div class="modal-footer border-top border-light px-4 py-3 d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-3 fs-8 fw-semibold px-4 py-2" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn rounded-3 fs-8 fw-bold px-4 py-2 text-white" style="background:#0D1B4B; border:none; width: auto !important;">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- STYLE DE SÉCURITÉ POUR MASQUER LES ONGLETS NON-ACTIFS AVEC TRANSITIONS FLUIDES -->
<style>
    .settings-tab-pane {
        display: none;
    }
    .settings-tab-pane.active {
        display: block;
        animation: fadeInTab 0.35s ease-out forwards;
    }

    /* Bouton d'onglet inactif */
    .btn-sub-tab {
        background-color: #ffffff;
        border: 1px solid #E2E8F0;
        color: #4A5B73;
        font-size: 0.78rem;
        font-weight: 700;
        border-radius: 50px;
        padding: 8px 18px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .btn-sub-tab:hover {
        background-color: #F8F9FA;
        color: #00D2F4;
        border-color: rgba(0, 210, 244, 0.25);
    }

    /* Bouton d'onglet actif (Conforme à l'image 19) */
    .btn-sub-tab.active {
        background-color: #0D1B4B !important;
        color: #ffffff !important;
        border-color: #0D1B4B !important;
        box-shadow: 0 4px 10px rgba(13, 27, 75, 0.15);
    }

    @keyframes fadeInTab {
        from {
            opacity: 0;
            transform: translateY(6px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<!-- SCRIPTS DE COMMUTATION INTERACTIVE DES 6 SOUS-ONGLETS SANS RECHARGEMENT DE PAGE (UX) -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabButtons = document.querySelectorAll('.btn-sub-tab');
    const tabPanes = document.querySelectorAll('.settings-tab-pane');

    if (tabButtons.length > 0) {
        tabButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                // Éteindre tous les boutons et masquer tous les sous-onglets
                tabButtons.forEach(b => b.classList.remove('active'));
                tabPanes.forEach(pane => pane.classList.remove('active'));

                // Activer le bouton cliqué
                btn.classList.add('active');

                // Afficher le sous-onglet correspondant dynamique
                const targetTabId = 'tab-' + btn.getAttribute('data-tab');
                const targetPane = document.getElementById(targetTabId);
                if (targetPane) {
                    targetPane.classList.add('active');
                }
            });
        });
    }
});
</script>
@endsection