<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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