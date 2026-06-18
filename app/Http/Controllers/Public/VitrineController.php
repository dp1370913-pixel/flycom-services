<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Str;

class VitrineController extends Controller
{
    // 1. Page d'accueil publique
    public function index()
    {
        return view('public.home'); 
    }

    // 2. Page À propos
    public function about()
    {
        return view('public.about');
    }

    // 3. Page d'exposition des Services 
    public function services()
    {
        // Récupère uniquement les services dont la colonne 'actif' est égale à true (1)
        $services = Service::where('actif', true)->orderBy('nom_service')->get();
        
        return view('public.services', compact('services'));
    }

    // 4. Page Portfolio / Réalisations
    public function portfolio()
    {
        return view('public.portfolio');
    }

    // 5. Page FAQ
    public function faq()
    {
        return view('public.faq');
    }

    // 6. Page Contact
    public function contact()
    {
        return view('public.contact');
    }

    // 7. Fiche Technique dynamique d'un service (Image 2 - Fusion MySQL & Métadonnées)
    public function serviceDetail($slug)
    {
        // Extraction dynamique du service de la base de données selon son nom converti en slug (M1)
        $dbService = Service::where('actif', true)->get()->first(function ($value) use ($slug) {
            return Str::slug($value->nom_service) === $slug;
        });

        // Sécurité si l'URL est erronée
        if (!$dbService) {
            abort(404);
        }

        // Dictionnaire des métadonnées visuelles d'expert (icônes, marques, forces et étapes de pose)
        $extraDetails = [
            'Réseaux Informatiques' => [
                'badge_category' => 'RÉSEAU',
                'icon' => 'bi-wifi',
                'short_desc' => 'Conception, installation et maintenance de réseaux filaires et WiFi performants.',
                'price_badge' => 'Sur devis',
                'contact_param' => 'reseau',
                'brands' => ['Cisco', 'Ubiquiti', 'TP-Link', 'Fortinet'],
                'strengths' => ['Câblage structuré Cat6/Cat6A', 'Points d\'accès WiFi 6/6E', 'Switches managés & VLAN', 'Firewall & sécurité périmètre', 'Monitoring 24/7', 'Support technique dédié'],
                'methodology' => [
                    '1' => ['title' => 'Audit sur site', 'desc' => 'Analyse complète de vos besoins et de l\'existant.'],
                    '2' => ['title' => 'Conception', 'desc' => 'Plan d\'architecture réseau et choix des équipements.'],
                    '3' => ['title' => 'Installation', 'desc' => 'Câblage, configuration et tests de performance.'],
                    '4' => ['title' => 'Maintenance', 'desc' => 'Suivi proactif et intervention sous 4h en cas de panne.']
                ]
            ],
            'Vidéosurveillance' => [
                'badge_category' => 'SÉCURITÉ',
                'icon' => 'bi-camera-video',
                'short_desc' => 'Systèmes de surveillance IP de sécurité avec vision nocturne et détection humaine.',
                'price_badge' => 'À partir de 150 000 FCFA',
                'contact_param' => 'videosurveillance',
                'brands' => ['Hikvision', 'Dahua', 'Uniview'],
                'strengths' => ['Caméras 4K/8MP', 'Vision nocturne IR 50m', 'Détection IA d\'humains', 'Alertes push instantanées', 'Stockage local NVR', 'Connexion réseau à distance'],
                'methodology' => [
                    '1' => ['title' => 'Diagnostic', 'desc' => 'Étude de couverture des angles morts.'],
                    '2' => ['title' => 'Plan de pose', 'desc' => 'Câblage et positionnement stratégique des caméras.'],
                    '3' => ['title' => 'Configuration', 'desc' => 'Réglage des alertes IA et de l\'application mobile.'],
                    '4' => ['title' => 'Suivi', 'desc' => 'Contrat de maintenance et vérification des disques durs.']
                ]
            ],
            'Contrôle d\'accès' => [
                'badge_category' => 'SÉCURITÉ',
                'icon' => 'bi-fingerprint',
                'short_desc' => 'Verrouillage de sécurité intelligent et gestion biométrique des flux de personnes.',
                'price_badge' => 'À partir de 200 000 FCFA',
                'contact_param' => 'acces',
                'brands' => ['ZKTeco', 'Anviz', 'Suprema'],
                'strengths' => ['Biométrie empreinte & visage', 'RFID/Mifare 13.56 MHz', 'Portes & ventouses 300/500kg', 'Interphone vidéo IP', 'Historique des passages', 'Boutons de sortie d\'urgence'],
                'methodology' => [
                    '1' => ['title' => 'Audit flux', 'desc' => 'Analyse des accès sensibles et des issues de secours.'],
                    '2' => ['title' => 'Câblage', 'desc' => 'Installation des ventouses et contrôleurs d\'accès.'],
                    '3' => ['title' => 'Enregistrement', 'desc' => 'Enregistrement des empreintes/badges et formation admin.'],
                    '4' => ['title' => 'Maintenance', 'desc' => 'Tests de déverrouillage de sécurité incendie.']
                ]
            ],
            'Barbelé Électrique' => [
                'badge_category' => 'SÉCURITÉ',
                'icon' => 'bi-lightning-fill',
                'short_desc' => 'Sécurisation périmétrique dissuasive active avec détection d\'intrusion.',
                'price_badge' => 'Sur devis',
                'contact_param' => 'barbele',
                'brands' => ['Gallagher', 'Nemtek', 'JVA'],
                'strengths' => ['Impulsion 10 000V non létale', 'Centrale d\'alarme autonome', 'Sirène extérieure puissante', 'Batterie de secours 24h', 'Détection de coupe de fil', 'Installation réglementaire'],
                'methodology' => [
                    '1' => ['title' => 'Métrage', 'desc' => 'Calcul linéaire de la clôture périmétrique.'],
                    '2' => ['title' => 'Pose isolateurs', 'desc' => 'Installation des potelets et passage des fils.'],
                    '3' => ['title' => 'Raccordement', 'desc' => 'Liaison à l\'énergiseur et tests de tension.'],
                    '4' => ['title' => 'Sécurité', 'desc' => 'Pose des panneaux de signalisation obligatoires.']
                ]
            ],
            'Panneaux Solaires' => [
                'badge_category' => 'ÉNERGIE',
                'icon' => 'bi-sun-fill',
                'short_desc' => 'Ingénierie photovoltaïque autonome et hybride pour une continuité électrique.',
                'price_badge' => 'À partir de 950 000 FCFA',
                'contact_param' => 'solaire',
                'brands' => ['Victron Energy', 'Huawei Solar', 'Fronius'],
                'strengths' => ['Panneaux PERC monocristallins', 'Onduleurs hybrides intelligents', 'Stockage batteries lithium', 'Bypass réseau automatique', 'Monitoring de production Wi-Fi', '25 ans de garantie rendement'],
                'methodology' => [
                    '1' => ['title' => 'Bilan puissance', 'desc' => 'Calcul de la consommation de vos appareils.'],
                    '2' => ['title' => 'Pose toiture', 'desc' => 'Fixation des structures et câblage des panneaux.'],
                    '3' => ['title' => 'Raccordement', 'desc' => 'Câblage de l\'onduleur et du banc de batteries.'],
                    '4' => ['title' => 'Mise en route', 'desc' => 'Tests de basculement réseau/batteries automatique.']
                ]
            ],
            'Climatisation' => [
                'badge_category' => 'CONFORT',
                'icon' => 'bi-wind',
                'short_desc' => 'Régulation thermique, pose de splits muraux et cassettes de plafond.',
                'price_badge' => 'À partir de 800 000 FCFA',
                'contact_param' => 'climatisation',
                'brands' => ['Daikin', 'Carrier', 'LG'],
                'strengths' => ['Technologie Inverter A+++', 'splits, cassettes & gainables', 'Gaz écologique R32', 'Filtres purificateurs d\'air', 'Régulation WiFi à distance', 'Maintenance curative/préventive'],
                'methodology' => [
                    '1' => ['title' => 'Bilan thermique', 'desc' => 'Calcul des BTU nécessaires selon le volume.'],
                    '2' => ['title' => 'Pose unités', 'desc' => 'Installation des blocs internes et externes.'],
                    '3' => ['title' => 'Raccordement', 'desc' => 'Tirage au vide des liaisons cuivre et charge gaz.'],
                    '4' => ['title' => 'Entretien', 'desc' => 'Contrat de nettoyage annuel des filtres.']
                ]
            ],
            'Location de Véhicules' => [
                'badge_category' => 'LOGISTIQUE',
                'icon' => 'bi-car-front-fill',
                'short_desc' => 'Location de SUV et 4x4 robustes pour déplacements privés ou professionnels.',
                'price_badge' => 'À partir de 35 000 FCFA/j',
                'contact_param' => 'location',
                'brands' => ['Toyota Land Cruiser', 'Mitsubishi Pajero', 'Suzuki Jimny'],
                'strengths' => ['Boîte manuelle ou automatique', 'Motorisation Turbo Diesel 4x4', 'Climatisation renforcée', 'Véhicules révisés & assurés', 'Chauffeur bilingue optionnel', 'Assistance panne 24/7'],
                'methodology' => [
                    '1' => ['title' => 'Réservation', 'desc' => 'Sélection des dates et du modèle requis.'],
                    '2' => ['title' => 'Contrat', 'desc' => 'Vérification du permis de conduire et caution.'],
                    '3' => ['title' => 'État des lieux', 'desc' => 'Check-up complet du véhicule au départ.'],
                    '4' => ['title' => 'Restitution', 'desc' => 'Vérification finale au retour du véhicule.']
                ]
            ],
            'Location Sonorisation' => [
                'badge_category' => 'LOGISTIQUE',
                'icon' => 'bi-volume-up-fill',
                'short_desc' => 'Régies sonores professionnelles pour manifestations et événements.',
                'price_badge' => 'À partir de 50 000 FCFA/j',
                'contact_param' => 'sonorisation',
                'brands' => ['JBL Professional', 'Yamaha Pro', 'Shure'],
                'strengths' => ['Enceintes actives de 1000W à 5000W', 'Microphones HF Shure SM58', 'Consoles de mixage numériques', 'Câblage & pieds inclus', 'Transport & montage inclus', 'Technicien son de garde'],
                'methodology' => [
                    '1' => ['title' => 'Besoins', 'desc' => 'Évaluation du volume de la salle et invités.'],
                    '2' => ['title' => 'Livraison', 'desc' => 'Acheminement et montage sur les lieux.'],
                    '3' => ['title' => 'Balance son', 'desc' => 'Réglages acoustiques de la salle.'],
                    '4' => ['title' => 'Démontage', 'desc' => 'Rangement et reprise du matériel en fin d\'événement.']
                ]
            ]
        ];

        // Fusion des données de la base MySQL avec les attributs de présentation d'expert (M1)
        $extra = $extraDetails[$dbService->nom_service] ?? null;

        if (!$extra) {
            abort(404);
        }

        $service = [
            'title'          => $dbService->nom_service,
            'image'          => asset($dbService->image), // Charge l'image locale que vous venez de stocker !
            'short_desc'     => $extra['short_desc'],
            'long_desc'      => $dbService->description,
            'price_badge'    => $extra['price_badge'],
            'badge_category' => $extra['badge_category'],
            'icon'           => $extra['icon'],
            'contact_param'  => $extra['contact_param'],
            'brands'         => $extra['brands'],
            'strengths'      => $extra['strengths'],
            'methodology'    => $extra['methodology']
        ];

        return view('public.service-detail', compact('service'));
    }
}