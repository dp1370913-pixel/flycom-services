<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $table = 'conversations';
    protected $primaryKey = 'id_conversation';

    protected $fillable = [
        'id_client',
        'canal',
        'statut',
        'date_debut',
        'date_fin'
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    // Relation : La conversation appartient à un client ou à un prospect identifié
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    // Relation : Une conversation regroupe de nombreux messages unitaire
    public function messages(): HasMany
    {
        return $this->hasMany(MessageConversation::class, 'id_conversation');
    }

    // Relation : Une conversation qualifiée peut être rattachée à un lead
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'id_conversation');
    }
}