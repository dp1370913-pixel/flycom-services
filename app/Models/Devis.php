<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id_devis
 * @property int $id_client
 * @property int|null $id_lead
 * @property string $numero
 * @property string $type
 * @property string $date_emission
 * @property string $date_expiration
 * @property numeric $montant_ht
 * @property numeric $tva
 * @property numeric $montant_ttc
 * @property string $statut
 * @property string $statut_paiement
 * @property string|null $fichier_pdf
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client $client
 * @property-read \App\Models\Lead|null $lead
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Service> $services
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis whereDateEmission($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis whereDateExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis whereFichierPdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis whereIdClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis whereIdDevis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis whereIdLead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis whereMontantHt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis whereMontantTtc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis whereStatutPaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis whereTva($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devis whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Devis extends Model
{
    protected $table = 'devis';
    protected $primaryKey = 'id_devis';

    protected $fillable = [
        'id_client',
        'id_lead',
        'numero',
        'type',
        'date_emission',
        'date_expiration',
        'montant_ht',
        'tva',
        'montant_ttc',
        'statut',
        'statut_paiement',
        'fichier_pdf'
    ];

    // Relation : Le devis est adressé à un client unique
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    // Relation : Le devis est issu d'une opportunité commerciale spécifique (Lead)
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'id_lead');
    }

    // Relation N-N : Le devis regroupe plusieurs lignes de services avec intégration des Snapshots
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'devis_lignes', 'id_devis', 'id_service')
                    ->withPivot('quantite', 'prix_unitaire', 'nom_service_snapshot', 'description_snapshot');
    }
}