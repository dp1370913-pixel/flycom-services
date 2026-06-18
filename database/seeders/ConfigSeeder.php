<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Config;

class ConfigSeeder extends Seeder
{
    public function run(): void
    {
        $configs = [
            [
                'cle' => 'whatsapp_ia_active',
                'valeur' => 'true',
                'description' => 'Active ou désactive l\'agent conversationnel WhatsApp de garde.'
            ],
            [
                'cle' => 'heure_ouverture',
                'valeur' => '08:00',
                'description' => 'Heure d\'ouverture officielle de l\'entreprise.'
            ],
            [
                'cle' => 'heure_fermeture',
                'valeur' => '18:00',
                'description' => 'Heure de fermeture officielle de l\'entreprise.'
            ],
            [
                'cle' => 'jours_ouvrables',
                'valeur' => 'Lun-Sam',
                'description' => 'Jours ouvrables de fonctionnement de la structure.'
            ],
            [
                'cle' => 'nom_entreprise',
                'valeur' => 'Flycom Services',
                'description' => 'Raison sociale ou nom de la marque commerciale.'
            ],
            [
                'cle' => 'telephone_responsable',
                'valeur' => '+242066285741',
                'description' => 'Numéro de téléphone du responsable technique pour cas d\'escalade urgente.'
            ]
        ];

        foreach ($configs as $config) {
            Config::create($config);
        }
    }
}