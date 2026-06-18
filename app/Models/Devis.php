<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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