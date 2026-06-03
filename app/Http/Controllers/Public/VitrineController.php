<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VitrineController extends Controller
{
    public function index() { return view('public.home'); }
    public function about() { return view('public.about'); }
    public function services() { return view('public.services'); }
    public function portfolio() { return view('public.portfolio'); }
    public function faq() { return view('public.faq'); }
    public function contact() { return view('public.contact'); }

    // Fiche Technique dynamique pour l'exhaustivité des 8 Services
    public function serviceDetail($slug)
    {
        $services = [
            'reseaux-informatiques' => [
                'title' => 'Réseaux Informatiques',
                'badge_category' => 'RÉSEAU',
                'icon' => 'bi-wifi',
                'image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=800&q=80',
                'short_desc' => 'Conception, installation et maintenance de réseaux filaires et WiFi performants.',
                'price_badge' => 'Sur devis',
                'contact_param' => 'reseau',
                'long_desc' => 'Nous déployons des infrastructures réseau de pointe : câblage structuré Cat6/Cat6A, switches managés, points d\'accès WiFi 6/6E, VLAN segmentation, firewall et monitoring 24/7. De l\'audit à la maintenance, nous garantissons une connectivité fiable et sécurisée pour les entreprises et les particuliers à Brazzaville et au-delà.',
                'brands' => ['Cisco', 'Ubiquiti', 'TP-Link', 'Fortinet'],
                'strengths' => ['Câblage structuré Cat6/Cat6A', 'Points d\'accès WiFi 6/6E', 'Switches managés & VLAN', 'Firewall & sécurité périmètre', 'Monitoring 24/7', 'Support technique dédié'],
                'methodology' => [
                    '1' => ['title' => 'Audit sur site', 'desc' => 'Analyse complète de vos besoins et de l\'existant.'],
                    '2' => ['title' => 'Conception', 'desc' => 'Plan d\'architecture réseau et choix des équipements.'],
                    '3' => ['title' => 'Installation', 'desc' => 'Câblage, configuration et tests de performance.'],
                    '4' => ['title' => 'Maintenance', 'desc' => 'Suivi proactif et intervention sous 4h en cas de panne.']
                ]
            ],
            'videosurveillance' => [
                'title' => 'Vidéosurveillance',
                'badge_category' => 'SÉCURITÉ',
                'icon' => 'bi-camera-video',
                'image' => 'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=800&q=80',
                'short_desc' => 'Systèmes de surveillance IP intelligents avec vision nocturne et détection humaine.',
                'price_badge' => 'À partir de 150 000 FCFA',
                'contact_param' => 'videosurveillance',
                'long_desc' => 'Protégez vos biens avec des technologies d\'enregistrement haute définition. Caméras dômes et tubes avec algorithmes de détection d\'intrusion et alertes en temps réel sur smartphone.',
                'brands' => ['Hikvision', 'Dahua', 'Uniview'],
                'strengths' => ['Caméras 4K/8MP', 'Vision nocturne IR 50m', 'Détection IA d\'humains', 'Alertes push instantanées', 'Stockage local NVR', 'Connexion réseau à distance'],
                'methodology' => [
                    '1' => ['title' => 'Diagnostic', 'desc' => 'Étude de couverture des angles morts.'],
                    '2' => ['title' => 'Plan de pose', 'desc' => 'Câblage et positionnement stratégique des caméras.'],
                    '3' => ['title' => 'Configuration', 'desc' => 'Réglage des alertes IA et de l\'application mobile.'],
                    '4' => ['title' => 'Suivi', 'desc' => 'Contrat de maintenance et vérification des disques durs.']
                ]
            ],
            'controle-dacces' => [
                'title' => 'Contrôle d\'Accès',
                'badge_category' => 'SÉCURITÉ',
                'icon' => 'bi-fingerprint',
                'image' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=800&q=80',
                'short_desc' => 'Verrouillage intelligent et gestion biométrique des flux de personnes.',
                'price_badge' => 'À partir de 200 000 FCFA',
                'contact_param' => 'acces',
                'long_desc' => 'Sécurisez l\'accès à vos locaux avec nos solutions avancées : lecteurs biométriques d\'empreintes et faciaux, badges RFID/Mifare, portes automatiques avec détecteurs de présence, interphones vidéo avec enregistrement, gestion centralisée des accès par badge.',
                'brands' => ['ZKTeco', 'Anviz', 'Suprema'],
                'strengths' => ['Biométrie empreinte & visage', 'RFID/Mifare 13.56 MHz', 'Portes & ventouses 300/500kg', 'Interphone vidéo IP', 'Historique des passages', 'Boutons de sortie d\'urgence'],
                'methodology' => [
                    '1' => ['title' => 'Audit flux', 'desc' => 'Analyse des accès sensibles et des issues de secours.'],
                    '2' => ['title' => 'Câblage', 'desc' => 'Installation des ventouses et contrôleurs d\'accès.'],
                    '3' => ['title' => 'Enregistrement', 'desc' => 'Enregistrement des empreintes/badges et formation admin.'],
                    '4' => ['title' => 'Maintenance', 'desc' => 'Tests de déverrouillage de sécurité incendie.']
                ]
            ],
            'barbele-electrique' => [
                'title' => 'Barbelé Électrique',
                'badge_category' => 'SÉCURITÉ',
                'icon' => 'bi-lightning',
                'image' => 'https://images.unsplash.com/photo-1508873535684-277a3cbcc4e8?auto=format&fit=crop&w=800&q=80',
                'short_desc' => 'Sécurisation périmétrique dissuasive active avec détection d\'intrusion.',
                'price_badge' => 'Sur devis',
                'contact_param' => 'barbele',
                'long_desc' => 'Mettez en place une barrière infranchissable autour de vos résidences ou entrepôts. Impulsions haute tension non létales reliées à des alarmes sonores et des transmetteurs d\'alerte.',
                'brands' => ['Gallagher', 'Nemtek', 'JVA'],
                'strengths' => ['Impulsion 10 000V non létale', 'Centrale d\'alarme autonome', 'Sirène extérieure puissante', 'Batterie de secours 24h', 'Détection de coupe de fil', 'Installation réglementaire'],
                'methodology' => [
                    '1' => ['title' => 'Métrage', 'desc' => 'Calcul linéaire de la clôture périmétrique.'],
                    '2' => ['title' => 'Pose isolateurs', 'desc' => 'Installation des potelets et passage des fils.'],
                    '3' => ['title' => 'Raccordement', 'desc' => 'Liaison à l\'énergiseur et tests de tension.'],
                    '4' => ['title' => 'Sécurité', 'desc' => 'Pose des panneaux de signalisation obligatoires.']
                ]
            ],
            'panneaux-solaires' => [
                'title' => 'Panneaux Solaires',
                'badge_category' => 'ÉNERGIE',
                'icon' => 'bi-sun',
                'image' => 'https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=800&q=80',
                'short_desc' => 'Ingénierie photovoltaïque autonome et hybride pour une continuité électrique.',
                'price_badge' => 'À partir de 950 000 FCFA',
                'contact_param' => 'solaire',
                'long_desc' => 'Dites adieu aux coupures de courant. Nous dimensionnons des installations solaires sur mesure avec des panneaux PERC monocristallins, des onduleurs hybrides intelligents et du stockage lithium.',
                'brands' => ['Victron Energy', 'Huawei Solar', 'Fronius'],
                'strengths' => ['Panneaux PERC monocristallins', 'Onduleurs hybrides intelligents', 'Stockage batteries lithium', 'Bypass réseau automatique', 'Monitoring de production Wi-Fi', '25 ans de garantie rendement'],
                'methodology' => [
                    '1' => ['title' => 'Bilan puissance', 'desc' => 'Calcul de la consommation de vos appareils électriques.'],
                    '2' => ['title' => 'Pose toiture', 'desc' => 'Fixation des structures et câblage des panneaux.'],
                    '3' => ['title' => 'Raccordement', 'desc' => 'Câblage de l\'onduleur et du banc de batteries.'],
                    '4' => ['title' => 'Mise en route', 'desc' => 'Tests de basculement réseau/batteries automatique.']
                ]
            ],
            'climatisation' => [
                'title' => 'Climatisation',
                'badge_category' => 'CONFORT',
                'icon' => 'bi-wind',
                'image' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&w=800&q=80',
                'short_desc' => 'Régulation thermique, pose de splits muraux et cassettes de plafond.',
                'price_badge' => 'À partir de 80 000 FCFA',
                'contact_param' => 'climatisation',
                'long_desc' => 'Garantissez un air frais et pur dans vos locaux. Installation de climatiseurs inverter basse consommation, entretien périodique des filtres et recharge en gaz frigorifique.',
                'brands' => ['Daikin', 'Carrier', 'LG'],
                'strengths' => ['Technologie Inverter A+++', 'splits, cassettes & gainables', 'Gaz écologique R32', 'Filtres purificateurs d\'air', 'Régulation WiFi à distance', 'Maintenance curative/préventive'],
                'methodology' => [
                    '1' => ['title' => 'Bilan thermique', 'desc' => 'Calcul des BTU nécessaires selon le volume.'],
                    '2' => ['title' => 'Pose unités', 'desc' => 'Installation des blocs internes et externes.'],
                    '3' => ['title' => 'Raccordement', 'desc' => 'Tirage au vide des liaisons cuivre et charge gaz.'],
                    '4' => ['title' => 'Entretien', 'desc' => 'Contrat annuel de nettoyage des filtres.']
                ]
            ],
            'location-de-vehicules' => [
                'title' => 'Location de Véhicules',
                'badge_category' => 'LOGISTIQUE',
                'icon' => 'bi-car-front',
                'image' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=80',
                'short_desc' => 'Location de SUV et 4x4 robustes pour déplacements privés ou professionnels.',
                'price_badge' => 'À partir de 35 000 FCFA/jour',
                'contact_param' => 'location',
                'long_desc' => 'Déplacez-vous en toute sérénité à Brazzaville et dans le reste de la République du Congo. Flotte de SUV 4x4 robustes récents, louables à la journée ou au mois avec ou sans chauffeur.',
                'brands' => ['Toyota Land Cruiser', 'Mitsubishi Pajero', 'Suzuki Jimny'],
                'strengths' => ['Boîte manuelle ou automatique', 'Motorisation Turbo Diesel 4x4', 'Climatisation renforcée', 'Véhicules révisés & assurés', 'Chauffeur bilingue optionnel', 'Assistance panne 24/7'],
                'methodology' => [
                    '1' => ['title' => 'Réservation', 'desc' => 'Sélection des dates et du modèle requis.'],
                    '2' => ['title' => 'Contrat', 'desc' => 'Vérification du permis de conduire et caution.'],
                    '3' => ['title' => 'État des lieux', 'desc' => 'Check-up complet du véhicule au départ.'],
                    '4' => ['title' => 'Restitution', 'desc' => 'Vérification finale au retour du véhicule.']
                ]
            ],
            'location-sonorisation' => [
                'title' => 'Location Sonorisation',
                'badge_category' => 'LOGISTIQUE',
                'icon' => 'bi-volume-up',
                'image' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=800&q=80',
                'short_desc' => 'Régies sonores professionnelles pour manifestations et événements.',
                'price_badge' => 'À partir de 50 000 FCFA/jour',
                'contact_param' => 'sonorisation',
                'long_desc' => 'Pour vos conférences, réceptions, mariages ou concerts à Brazzaville. Location de packs de sonorisation professionnels (enceintes actives, consoles de mixage, micros HF) avec ingénieur du son inclus.',
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

        if (!array_key_exists($slug, $services)) {
            abort(404);
        }

        $service = $services[$slug];

        return view('public.service-detail', compact('service'));
    }
}