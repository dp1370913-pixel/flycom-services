<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id_client';

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email',
        'entreprise',
        'adresse',
        'type_contact',
        'notes'
    ];

    // Relation : Un client peut avoir plusieurs opportunités d'affaires (Leads)
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'id_client');
    }

    // Relation : Un client peut recevoir plusieurs propositions de tarifs (Devis)
    public function devis(): HasMany
    {
        return $this->hasMany(Devis::class, 'id_client');
    }

    // Relation : Un client regroupe tout l'historique de ses interactions
    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class, 'id_client');
    }

    // Relation : Un client peut initier plusieurs sessions de discussion de Chatbot/WhatsApp
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'id_client');
    }
}