<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'nom_service' => 'Réseaux Informatiques',
                'description' => 'Câblage structuré cat6/7, déploiement de commutateurs, routeurs et solutions Wi-Fi professionnelles pour entreprise et domicile.',
                'prix_indicatif' => 0.00,
                'unite' => 'Sur devis',
                'categorie' => 'Réseau',
                'actif' => true,
                'image' => 'assets/images/reseaux.jpg'
            ],
            [
                'nom_service' => 'Vidéosurveillance',
                'description' => 'Systèmes de caméras IP haute définition, supervision à distance sur smartphone, et enregistreurs NVR sécurisés.',
                'prix_indicatif' => 150000.00,
                'unite' => 'Kit de base',
                'categorie' => 'Sécurité',
                'actif' => true,
                'image' => 'assets/images/videosurveillance.jpg'
            ],
            [
                'nom_service' => 'Contrôle d\'accès',
                'description' => 'Lecteurs biométriques, digicodes, badges et serrures électromagnétiques pour la sécurisation de bureaux et entrepôts.',
                'prix_indicatif' => 200000.00,
                'unite' => 'Kit d\'accès',
                'categorie' => 'Sécurité',
                'actif' => true,
                'image' => 'assets/images/controle_dacces.jpg'
            ],
            [
                'nom_service' => 'Barbelé Électrique',
                'description' => 'Clôtures électrifiées dissuasives avec de détection d\'intrusion et sirène extérieure de sécurité active.',
                'prix_indicatif' => 0.00,
                'unite' => 'Mètre linéaire',
                'categorie' => 'Sécurité',
                'actif' => true,
                'image' => 'assets/images/barbele.jpg'
            ],
            [
                'nom_service' => 'Panneaux Solaires',
                'description' => 'Ingénierie solaire autonome, onduleurs hybrides intelligents et stockage d\'autonomie sur batteries lithium.',
                'prix_indicatif' => 950000.00,
                'unite' => 'Kit autonome',
                'categorie' => 'Énergie',
                'actif' => true,
                'image' => 'assets/images/solaire.jpg'
            ],
            [
                'nom_service' => 'Climatisation',
                'description' => 'Pose de splits muraux de régulation thermique inverter basse consommation, entretien périodique des filtres et charge gaz.',
                'prix_indicatif' => 800000.00,
                'unite' => 'Unité posée',
                'categorie' => 'Confort',
                'actif' => true,
                'image' => 'assets/images/climatisation.jpg'
            ],
            [
                'nom_service' => 'Location de Véhicules',
                'description' => 'Location à la journée ou au mois de SUV 4x4 robustes et révisés pour l\'ensemble de vos déplacements en province ou sur Brazzaville.',
                'prix_indicatif' => 35000.00,
                'unite' => 'Jour',
                'categorie' => 'Logistique',
                'actif' => true,
                'image' => 'assets/images/vehicules.jpg'
            ],
            [
                'nom_service' => 'Location Sonorisation',
                'description' => 'Location de packs de sonorisation d\'envergure (enceintes actives, consoles de mixage, micros HF) pour manifestations d\'entreprise.',
                'prix_indicatif' => 50000.00,
                'unite' => 'Jour',
                'categorie' => 'Logistique',
                'actif' => true,
                'image' => 'assets/images/sonorisation.jpg'
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}