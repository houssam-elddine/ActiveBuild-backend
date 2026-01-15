<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'categorie_id',
        'nom',
        'description',
        'reference',
        'type',
        'designation',
        'prixUnitaire',
        'stockDisponible'
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function accessoire()
    {
        return $this->hasOne(Accessoire::class);
    }
}

