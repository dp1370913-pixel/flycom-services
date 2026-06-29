<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id_service
 * @property string $nom_service
 * @property string $description
 * @property numeric $prix_indicatif
 * @property string $unite
 * @property string $categorie
 * @property int $actif
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Devis> $devis
 * @property-read int|null $devis_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Lead> $leads
 * @property-read int|null $leads_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereActif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereIdService($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereNomService($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service wherePrixIndicatif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereUnite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Service extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id_service';

    protected $fillable = [
        'nom_service',
        'description',
        'prix_indicatif',
        'unite',
        'categorie',
        'actif',
        'image'
    ];

    // Relation N-N : Un service peut concerner plusieurs opportunités de vente (Leads)
    public function leads(): BelongsToMany
    {
        return $this->belongsToMany(Lead::class, 'lead_services', 'id_service', 'id_lead');
    }

    // Relation N-N : Un service figure sur les lignes de plusieurs devis avec gestion des Snapshots
    public function devis(): BelongsToMany
    {
        return $this->belongsToMany(Devis::class, 'devis_lignes', 'id_service', 'id_devis')
                    ->withPivot('quantite', 'prix_unitaire', 'nom_service_snapshot', 'description_snapshot');
    }
}