<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $nom_user
 * @property string $prenom_user
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $derniere_connexion
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Interaction> $interactions
 * @property-read int|null $interactions_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    // Ajout du champ 'avatar' pour permettre sa sauvegarde via l'ORM Eloquent (MLD)
    protected $fillable = [
        'nom_user',
        'prenom_user',
        'email',
        'password',
        'role',
        'derniere_connexion',
        'avatar', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', 
        'derniere_connexion' => 'datetime',
    ];

    // Relation : Un utilisateur du CRM peut rédiger plusieurs interactions
    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class, 'id_user');
    }
}