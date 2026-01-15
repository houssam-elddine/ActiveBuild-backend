<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;

    protected $fillable = [
        'numeroDevis',
        'dateCreation',
        'statut',
        'montantHT',
        'client_id',
    ];

    // Devis appartient à un client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Devis contient plusieurs lignes
    public function lignes()
    {
        return $this->hasMany(LigneDevis::class);
    }
}
