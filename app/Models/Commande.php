<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'numeroCommande',
        'dateCommande',
        'statut',
        'devis_id',
    ];

    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }

    public function bonFabrication()
    {
        return $this->hasOne(BonFabrication::class);
    }
}
