<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id_lead
 * @property int $id_client
 * @property int|null $id_conversation
 * @property string|null $message_origine
 * @property string $statut
 * @property string $priorite
 * @property string $source
 * @property \Illuminate\Support\Carbon|null $prochaine_relance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client $client
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Devis> $devis
 * @property-read int|null $devis_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Interaction> $interactions
 * @property-read int|null $interactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Service> $services
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereIdClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereIdConversation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereIdLead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereMessageOrigine($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead wherePriorite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereProchaineRelance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lead whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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