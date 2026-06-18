<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    protected $table = 'leads';
    protected $primaryKey = 'id_lead';

    protected $fillable = [
        'id_client',
        'id_conversation',
        'message_origine',
        'statut',
        'priorite',
        'source',
        'prochaine_relance'
    ];

    // Convertit automatiquement le champ prochaine_relance en un objet de date Carbon en PHP
    protected $casts = [
        'prochaine_relance' => 'datetime',
    ];

    // Relation : L'opportunité d'affaire appartient à un prospect/client unique
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    // Relation N-N : Une opportunité peut concerner plusieurs services d'intégration
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'lead_services', 'id_lead', 'id_service');
    }

    // Relation : Une opportunité peut donner lieu à plusieurs propositions de devis
    public function devis(): HasMany
    {
        return $this->hasMany(Devis::class, 'id_lead');
    }

    // Relation : Une opportunité regroupe plusieurs comptes rendus d'interactions
    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class, 'id_lead');
    }
}