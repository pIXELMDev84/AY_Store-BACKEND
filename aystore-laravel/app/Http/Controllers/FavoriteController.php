<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Favorite;

class FavoriteController extends Controller
{

    public function index(Request $request)
    {
        $idValue = $request->route('userId');
        $favoriteProductIds = Favorite::where('user_id', $idValue)->pluck('produit_id')->toArray();
        $favoriteProducts = [];
        foreach ($favoriteProductIds as $productId) {
            // Retrieve product details for the current product ID
            $product = Produit::find($productId);

            // If product exists, add it to the list
            if ($product) {
                $favoriteProducts[] = $product;
            }
        }

        // Return the list of favorite products
        return response()->json(['produit' => $favoriteProducts]);
    }

    public function show(Request $request)
    {
        $idValue = $request->route('produitId');
        $produits = Produit::where('id', $idValue)->get();
        return response()->json($produits);
    }
    public function ajtFavoris(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'produit_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $userId = $request->input('user_id');
        $produitId = $request->input('produit_id');

        // Check if the favorite already exists
        $exists = Favorite::where('user_id', $userId)
                          ->where('produit_id', $produitId)
                          ->exists();

        if ($exists) {
            return response()->json(['message' => 'ce produit et deja dans vos favoris.'], 400);
        }

        

        // If not, create a new favorite entry
        $favorite = Favorite::create([
            'user_id' => $userId,
            'produit_id' => $produitId,
        ]);

        return response()->json($favorite, 201);
    }
    public function destroy($foreign_id)
    {
        // Find the record by foreign_id
        $record = Favorite::where('produit_id', $foreign_id)->first();

        if (!$record) {
            return response()->json(['message' => 'Record not found'], 400);
        }

        // Delete the record
        $record->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }
}
