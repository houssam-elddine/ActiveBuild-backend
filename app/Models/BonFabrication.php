<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonFabrication extends Model
{
    use HasFactory;

    protected $fillable = [
        'numeroBF',
        'dateFabrication',
        'etat',
        'etapes',
        'commande_id',
    ];

    protected $casts = [
        'etapes' => 'array',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    /**
     * genererNomenclature()
     */
    public function genererNomenclature()
    {
        return $this->commande
                    ->devis
                    ->lignes
                    ->map(function ($ligne) {
                        return [
                            'produit' => $ligne->produit->designation,
                            'quantite' => $ligne->quantite,
                        ];
                    });
    }
}
