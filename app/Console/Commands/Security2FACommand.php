<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class Security2FACommand extends Command
{
    /**
     * Signature d'appel d'Artisan (Signature unique)
     *
     * @var string
     */
    protected $signature = 'flycom:rescue-2fa {email : L\'adresse e-mail de l\'utilisateur à débloquer}';

    /**
     * Description d'aide dans la console
     *
     * @var string
     */
    protected $description = 'Génère un code OTP d\'urgence pour la double authentification et l\'affiche directement dans la console';

    /**
     * Exécute l'action de déblocage d'urgence
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        // Recherche de l'utilisateur d'origine (MLD)
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Erreur : Aucun utilisateur du CRM n'a été trouvé avec l'adresse e-mail : {$email}");
            return Command::FAILURE;
        }

        // Génération d'un code OTP d'urgence unique à 6 chiffres
        $rescueOtp = rand(100000, 999999);

        // Insertion du code d'urgence dans le cache de Laravel (expire après 10 minutes)
        // en ciblant la clé d'identification exacte utilisée par l'AuthController
        Cache::put('2fa_otp_' . $user->id, $rescueOtp, now()->addMinutes(10));

        // Affichage du panneau d'aide d'urgence
        $this->info(" ");
        $this->info("====================================================");
        $this->info("   L'ISSUE DE SECOURS DE DOUBLE AUTHENTIFICATION   ");
        $this->info("====================================================");
        $this->line(" Utilisateur ciblé : " . $user->prenom_user . " " . $user->nom_user);
        $this->line(" Rôle du compte    : " . $user->role);
        $this->info("----------------------------------------------------");
        $this->warn(" CODE OTP GÉNÉRÉ    : " . $rescueOtp);
        $this->line(" Durée de validité : 10 minutes");
        $this->info("====================================================");
        $this->comment(" Copiez-collez ce code directement sur votre navigateur");
        $this->comment(" pour débloquer votre accès au CRM Flycom Services.");
        $this->info(" ");

        return Command::SUCCESS;
    }
}