<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id_client
 * @property string $nom
 * @property string $prenom
 * @property string $telephone
 * @property string|null $email
 * @property string|null $entreprise
 * @property string|null $adresse
 * @property string $type_contact
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Conversation> $conversations
 * @property-read int|null $conversations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Devis> $devis
 * @property-read int|null $devis_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Interaction> $interactions
 * @property-read int|null $interactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Lead> $leads
 * @property-read int|null $leads_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereEntreprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereIdClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereTypeContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Client extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id_client';

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email',
        'entreprise',
        'adresse',
        'type_contact',
        'notes'
    ];

    // Relation : Un client peut avoir plusieurs opportunités d'affaires (Leads)
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'id_client');
    }

    // Relation : Un client peut recevoir plusieurs propositions de tarifs (Devis)
    public function devis(): HasMany
    {
        return $this->hasMany(Devis::class, 'id_client');
    }

    // Relation : Un client regroupe tout l'historique de ses interactions
    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class, 'id_client');
    }

    // Relation : Un client peut initier plusieurs sessions de discussion de Chatbot/WhatsApp
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'id_client');
    }
}