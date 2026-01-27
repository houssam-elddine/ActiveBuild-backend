<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'category_id',
        'img',
        'name',
        'description',
        'price',
    ];
}
