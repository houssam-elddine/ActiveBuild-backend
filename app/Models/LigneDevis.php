<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneDevis extends Model
{
    use HasFactory;

    protected $table = 'ligne_devis';

    protected $fillable = [
        'quantite',
        'prixUnitaire',
        'devis_id',
        'produit_id',
    ];

    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function calculerSousTotal()
    {
        return $this->quantite * $this->prixUnitaire;
    }
}
