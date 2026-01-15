<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'materiaux',
        'dimensions',
        'couleur',
        'finition',
        'produit_id'
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}

