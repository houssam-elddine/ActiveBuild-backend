<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonFabrication extends Model
{
    protected $fillable = ['commande_id', 'etat', 'etapes'];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}

