<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $table = 'produits';
    protected $fillable = [
        'name',
        'small_desc',
        'prix',
        'image',
        'qte',
    ];

    protected $casts = [
        'prix' => 'decimal:2', ];
}
