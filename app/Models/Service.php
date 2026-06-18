<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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