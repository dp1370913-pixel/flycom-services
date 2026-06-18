<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    // Les champs que le CRM est autorisé à insérer ou modifier en SQL
    protected $fillable = [
        'nom_user',
        'prenom_user',
        'email',
        'password',
        'role',
        'derniere_connexion',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Gère automatiquement le hachage sécurisé BCrypt du mot de passe
        'derniere_connexion' => 'datetime',
    ];

    // Relation : Un utilisateur (commercial) du CRM peut rédiger plusieurs interactions
    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class, 'id_user');
    }
}