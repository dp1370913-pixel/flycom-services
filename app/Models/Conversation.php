<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id_conversation
 * @property int|null $id_client
 * @property string $canal
 * @property string $statut
 * @property \Illuminate\Support\Carbon $date_debut
 * @property \Illuminate\Support\Carbon|null $date_fin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client|null $client
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Lead> $leads
 * @property-read int|null $leads_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MessageConversation> $messages
 * @property-read int|null $messages_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereCanal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereDateDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereDateFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereIdClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereIdConversation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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