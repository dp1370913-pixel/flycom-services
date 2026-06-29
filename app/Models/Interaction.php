<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id_interaction
 * @property int $id_client
 * @property int $id_user
 * @property int|null $id_lead
 * @property string $type_canal
 * @property \Illuminate\Support\Carbon $date
 * @property string $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client $client
 * @property-read \App\Models\Lead|null $lead
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interaction whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interaction whereIdClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interaction whereIdInteraction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interaction whereIdLead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interaction whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interaction whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interaction whereTypeCanal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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