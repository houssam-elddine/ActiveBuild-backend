<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = ['devis_id', 'status'];

    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }

    public function bonFabrication()
    {
        return $this->hasOne(BonFabrication::class);
    }
}
