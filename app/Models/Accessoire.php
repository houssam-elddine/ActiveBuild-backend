<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessoire extends Model
{
    protected $fillable = [
        'categorie',
        'compatibilite',
        'produit_id'
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
