<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_config
 * @property string $cle
 * @property string $valeur
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Config query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Config whereCle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Config whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Config whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Config whereIdConfig($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Config whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Config whereValeur($value)
 * @mixin \Eloquent
 */
class Config extends Model
{
    protected $table = 'config';
    protected $primaryKey = 'id_config';

    // Les champs que le CRM est autorisé à insérer ou modifier
    protected $fillable = [
        'cle',
        'valeur',
        'description'
    ];
}