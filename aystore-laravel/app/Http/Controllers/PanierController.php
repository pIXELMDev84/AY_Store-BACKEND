<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Panier;

class PanierController extends Controller
{
    public function addToPanier(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'produit_id' => 'required|exists:produits,id',
        ]);


        $existingPanier = Panier::where('user_id', $request->user_id)
                                ->where('produit_id', $request->produit_id)
                                ->first();

        if ($existingPanier) {
            return response()->json(['message' => 'Produit déjà dans le panier'], 400);
        }

        $panier = Panier::create([
            'user_id' => $request->user_id,
            'produit_id' => $request->produit_id,
            'quantity' => $request->quantity ?? 1,
        ]);

        return response()->json($panier, 201);
    }

    public function getPanier($userId)
    {
        $panier = Panier::where('user_id', $userId)->with('produit')->get();
        return response()->json($panier);
    }

    public function removeFromPanier($id)
    {
        $panier = Panier::findOrFail($id);
        $panier->delete();
        return response()->json(null, 204);
    }
}
