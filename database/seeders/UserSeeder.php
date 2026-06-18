<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Compte Administrateur de test (Pour Budry)
        User::create([
            'nom_user' => 'NAKOUZEBI',
            'prenom_user' => 'Budry',
            'email' => 'admin@flycomservices.cg',
            'password' => Hash::make('password123'), // Mot de passe par défaut sécurisé
            'role' => 'Admin'
        ]);

        // Compte Commercial de test (Pour Claunelle)
        User::create([
            'nom_user' => 'TSOUMBOU',
            'prenom_user' => 'Claunelle',
            'email' => 'commercial@flycomservices.cg',
            'password' => Hash::make('password123'),
            'role' => 'Commercial'
        ]);
    }
}