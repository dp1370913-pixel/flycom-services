<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Compte Administrateur 
        User::create([
            'nom_user' => 'PETER',
            'prenom_user' => 'Daniel',
            'email' => 'dp1370913@gmail.com',
            'password' => Hash::make('Adminflycom@2026'), // Mot de passe par défaut sécurisé
            'role' => 'Admin'
        ]);

        // Compte Commercial 
        User::create([
            'nom_user' => 'TSOUMBOU',
            'prenom_user' => 'Claunelle',
            'email' => 'tclaunellebhrayam@gmail.com',
            'password' => Hash::make('Comflycom@2026'),
            'role' => 'Commercial'
        ]);
    }
}