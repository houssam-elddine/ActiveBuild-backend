<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'hauteur',
        'largeur',
        'quantite',
        'type',
        'status',
    ];
}
