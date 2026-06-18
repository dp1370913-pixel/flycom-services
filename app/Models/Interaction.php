<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interaction extends Model
{
    protected $table = 'interactions';
    protected $primaryKey = 'id_interaction';

    protected $fillable = [
        'id_client',
        'id_user',
        'id_lead',
        'type_canal',
        'date',
        'note'
    ];

    // Convertit automatiquement le champ date en un objet de date Carbon en PHP
    protected $casts = [
        'date' => 'datetime',
    ];

    // Relation : L'interaction est liée à un prospect/client unique
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    // Relation : L'interaction est consignée par un utilisateur (humain ou bot) unique du CRM
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relation : L'interaction peut facultativement concerner un projet ou une opportunité spécifique
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'id_lead');
    }
}