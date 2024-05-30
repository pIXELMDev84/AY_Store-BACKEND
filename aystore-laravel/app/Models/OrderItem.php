<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    use HasFactory;
    protected $fillable = ['order_id', 'produit_id', 'quantity', 'price'];
}
