<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Devis;
use App\Models\Service;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Récupération des services de la base de données
        $services = Service::all()->keyBy('nom_service');

        // 2. Création des 8 Clients de vos maquettes (Image 11)
        $clients = [
            'stephane' => Client::create([
                'nom' => 'MOUTOU', 'prenom' => 'Stéphane', 'telephone' => '066112233',
                'email' => 'stephane.moutou@gmail.com', 'entreprise' => 'Congo Business Center',
                'adresse' => 'Brazzaville, Centre-ville', 'type_contact' => 'Client',
                'created_at' => Carbon::parse('2026-03-15')
            ]),
            'jocelyn' => Client::create([
                'nom' => 'BANDZOU', 'prenom' => 'Jocelyn', 'telephone' => '055445566',
                'email' => 'jocelyn.bandzou@yahoo.fr', 'entreprise' => '-',
                'adresse' => 'Brazzaville, Bacongo', 'type_contact' => 'Prospect',
                'created_at' => Carbon::parse('2026-05-20')
            ]),
            'patricia' => Client::create([
                'nom' => 'NGOMA', 'prenom' => 'Patricia', 'telephone' => '077889900',
                'email' => 'patricia.ngoma@entreprise.cg', 'entreprise' => 'Hôtel Résidence LaBaie',
                'adresse' => 'Pointe-Noire, Côte Sauvage', 'type_contact' => 'Client',
                'created_at' => Carbon::parse('2026-01-10')
            ]),
            'brice' => Client::create([
                'nom' => 'MOUKOKO', 'prenom' => 'Brice', 'telephone' => '044556677',
                'email' => 'brice.moukoko@construction.cg', 'entreprise' => 'Moukoko Construction SARL',
                'adresse' => 'Brazzaville, Talangaï', 'type_contact' => 'Prospect',
                'created_at' => Carbon::parse('2026-05-25')
            ]),
            'dolores' => Client::create([
                'nom' => 'LOUBAKI', 'prenom' => 'Dolores', 'telephone' => '066778899',
                'email' => 'dolores.loubaki@ecole.cg', 'entreprise' => 'École Privée Saint-Joseph',
                'adresse' => 'Brazzaville, Moungali', 'type_contact' => 'Partenaire',
                'created_at' => Carbon::parse('2025-11-05')
            ]),
            'gervais' => Client::create([
                'nom' => 'ITOUA', 'prenom' => 'Gervais', 'telephone' => '055223344',
                'email' => 'gervais.itoua@gmail.com', 'entreprise' => '-',
                'adresse' => 'Brazzaville, Ouenze', 'type_contact' => 'Prospect',
                'created_at' => Carbon::parse('2026-05-28')
            ]),
            'sylvie' => Client::create([
                'nom' => 'MALONGA', 'prenom' => 'Sylvie', 'telephone' => '077334455',
                'email' => 'sylvie.malonga@event.cg', 'entreprise' => 'Sylvie Events & Co',
                'adresse' => 'Brazzaville, La Glacière', 'type_contact' => 'Client',
                'created_at' => Carbon::parse('2026-02-18')
            ]),
            'alain' => Client::create([
                'nom' => 'KOULA', 'prenom' => 'Alain', 'telephone' => '044990011',
                'email' => 'alain.koula@banque.cg', 'entreprise' => 'Banque Africaine du Congo',
                'adresse' => 'Brazzaville, Poto-Poto', 'type_contact' => 'Prospect',
                'created_at' => Carbon::parse('2026-05-27')
            ]),
        ];

        // 3. Création des 8 Leads et raccordement relationnel aux services concernés (lead_services)
        $lead1 = Lead::create([
            'id_client' => $clients['jocelyn']->id_client, 'message_origine' => 'Bonjour, je souhaite installer un système de vidéosurveillance avec 4 caméras pour ma résidence à Mpila. Pouvez-vous me faire un devis ?',
            'statut' => 'Nouveau', 'priorite' => 'Haute', 'source' => 'Site_web',
            'prochaine_relance' => Carbon::now()->addDays(2), 'created_at' => Carbon::parse('2026-05-20')
        ]);
        $lead1->services()->sync([$services['Vidéosurveillance']->id_service]);

        $lead2 = Lead::create([
            'id_client' => $clients['gervais']->id_client, 'message_origine' => 'Intérêt pour kits solaires',
            'statut' => 'Nouveau', 'priorite' => 'Normale', 'source' => 'WhatsApp',
            'prochaine_relance' => Carbon::now()->addDays(1), 'created_at' => Carbon::parse('2026-05-28')
        ]);
        $lead2->services()->sync([$services['Panneaux Solaires']->id_service]);

        $lead3 = Lead::create([
            'id_client' => $clients['brice']->id_client, 'message_origine' => 'Besoin barbelé usine',
            'statut' => 'Contacte', 'priorite' => 'Haute', 'source' => 'WhatsApp',
            'prochaine_relance' => Carbon::now()->addDays(3), 'created_at' => Carbon::parse('2026-05-25')
        ]);
        $lead3->services()->sync([
            $services['Vidéosurveillance']->id_service,
            $services['Barbelé Électrique']->id_service
        ]);

        $lead4 = Lead::create([
            'id_client' => $clients['stephane']->id_client, 'message_origine' => 'Réseau bureaux d\'entreprise',
            'statut' => 'Devis_envoye', 'priorite' => 'Normale', 'source' => 'Appel_direct',
            'prochaine_relance' => Carbon::now()->subDays(2),
            'created_at' => Carbon::parse('2026-05-22')
        ]);
        $lead4->services()->sync([$services['Réseaux Informatiques']->id_service]);

        $lead5 = Lead::create([
            'id_client' => $clients['sylvie']->id_client, 'message_origine' => 'Sono pour conférence',
            'statut' => 'Devis_envoye', 'priorite' => 'Normale', 'source' => 'Recommandation',
            'prochaine_relance' => Carbon::now()->subDays(3),
            'created_at' => Carbon::parse('2026-05-18')
        ]);
        $lead5->services()->sync([$services['Location Sonorisation']->id_service]);

        $lead6 = Lead::create([
            'id_client' => $clients['alain']->id_client, 'message_origine' => 'Contrôle d\'accès agences',
            'statut' => 'Negociation', 'priorite' => 'Haute', 'source' => 'Site_web',
            'prochaine_relance' => Carbon::now()->subDays(1),
            'created_at' => Carbon::parse('2026-05-20')
        ]);
        $lead6->services()->sync([$services['Contrôle d\'accès']->id_service]);

        $lead7 = Lead::create([
            'id_client' => $clients['patricia']->id_client, 'message_origine' => 'Clim hôtelière',
            'statut' => 'Gagne', 'priorite' => 'Haute', 'source' => 'Appel_direct',
            'prochaine_relance' => null, 'created_at' => Carbon::parse('2026-05-15')
        ]);
        $lead7->services()->sync([$services['Climatisation']->id_service]);

        $lead8 = Lead::create([
            'id_client' => $clients['dolores']->id_client, 'message_origine' => 'Réseau informatique école',
            'statut' => 'Perdu', 'priorite' => 'Basse', 'source' => 'Email',
            'prochaine_relance' => null, 'created_at' => Carbon::parse('2026-04-10')
        ]);
        $lead8->services()->sync([$services['Réseaux Informatiques']->id_service]);

        // 4. Création des 5 Devis de vos maquettes (Image 16)
        $devis = [
            Devis::create([
                'id_client' => $clients['stephane']->id_client, 'id_lead' => $lead4->id_lead,
                'numero' => 'DEV-2026-0042', 'type' => 'Devis',
                'date_emission' => Carbon::parse('2026-05-24'), 'date_expiration' => Carbon::parse('2026-06-23'),
                'montant_ht' => 450000.00, 'tva' => 0.00, 'montant_ttc' => 450000.00,
                'statut' => 'En_attente', 'statut_paiement' => 'Non_paye'
            ]),
            Devis::create([
                'id_client' => $clients['patricia']->id_client, 'id_lead' => $lead7->id_lead,
                'numero' => 'FAC-2026-0015', 'type' => 'Facture_proforma',
                'date_emission' => Carbon::parse('2026-05-16'), 'date_expiration' => Carbon::parse('2026-06-15'),
                'montant_ht' => 320000.00, 'tva' => 0.00, 'montant_ttc' => 320000.00,
                'statut' => 'Accepte', 'statut_paiement' => 'Acompte_recu'
            ]),
            Devis::create([
                'id_client' => $clients['sylvie']->id_client, 'id_lead' => $lead5->id_lead,
                'numero' => 'DEV-2026-0038', 'type' => 'Devis',
                'date_emission' => Carbon::parse('2026-05-19'), 'date_expiration' => Carbon::parse('2026-06-18'),
                'montant_ht' => 280000.00, 'tva' => 0.00, 'montant_ttc' => 280000.00,
                'statut' => 'En_attente', 'statut_paiement' => 'Non_paye'
            ]),
            Devis::create([
                'id_client' => $clients['alain']->id_client, 'id_lead' => $lead6->id_lead,
                'numero' => 'DEV-2026-0045', 'type' => 'Devis',
                'date_emission' => Carbon::parse('2026-05-21'), 'date_expiration' => Carbon::parse('2026-06-20'),
                'montant_ht' => 1200000.00, 'tva' => 0.00, 'montant_ttc' => 1200000.00,
                'statut' => 'En_attente', 'statut_paiement' => 'Non_paye'
            ]),
            Devis::create([
                'id_client' => $clients['dolores']->id_client, 'id_lead' => $lead8->id_lead,
                'numero' => 'DEV-2026-0040', 'type' => 'Devis',
                'date_emission' => Carbon::parse('2026-05-27'), 'date_expiration' => Carbon::parse('2026-06-26'),
                'montant_ht' => 850000.00, 'tva' => 0.00, 'montant_ttc' => 850000.00,
                'statut' => 'En_attente', 'statut_paiement' => 'Non_paye'
            ]),
        ];
    }
}