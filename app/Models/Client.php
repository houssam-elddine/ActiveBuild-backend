<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'codeClient',
        'type',
        'nom',
        'adresse',
    ];

    // Client établit plusieurs devis
    public function devis()
    {
        return $this->hasMany(Devis::class);
    }
}
