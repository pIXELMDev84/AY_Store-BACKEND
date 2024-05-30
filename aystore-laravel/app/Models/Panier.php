<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'produit_id',
        'quantity',
    ];

    // Relation avec le modèle Produit
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
