<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Produit;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::all();
        return response()->json($produits);
    }

    public function ajtProduit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'small_desc' => 'required|string',
            'prix' => 'required|numeric',
            'image' => 'nullable|file|mimes:jpeg,png,jpg',
            'qte' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $produit = new Produit();
        $produit->name = $request->name;
        $produit->small_desc = $request->small_desc;
        $produit->prix = $request->prix;
        $produit->qte = $request->qte;

        if ($request->hasFile('image')) {
            $imagePath = $request->image->store('images', 'public');
            $produit->image = $imagePath;
        }

        $produit->save();

        return response()->json($produit, 201);
    }

    public function show(Produit $produit)
    {
        return response()->json($produit);
    }

    public function updateProduit(Request $request, Produit $produit)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'small_desc' => 'required|string',
            'prix' => 'required|numeric',
            'image' => 'nullable|file|mimes:jpeg,png,jpg',
            'qte' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $produit->update($request->all());

        if ($request->hasFile('image')) {
            if ($produit->image) {
                Storage::delete('public/' . $produit->image);
            }
            $imagePath = $request->image->store('images', 'public');
            $produit->image = $imagePath;
        }

        $produit->save();

        return response()->json($produit, 200);
    }

    public function suprProduit(Produit $produit)
    {
        if ($produit->image) {
            Storage::delete('public/' . $produit->image);
        }

        $produit->delete();
        return response()->json(null, 204);
    }
}
