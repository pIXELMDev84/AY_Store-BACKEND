<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\OrderController;



Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return $request->user();
});
//enregistrement/login(login/register)
Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::post('register', 'App\Http\Controllers\AuthController@register');

//produit(suprimer/ajouter/modifier/afficher)
Route::get('/produits', 'App\Http\Controllers\ProduitController@index');
Route::get('/produits/{produit}', 'App\Http\Controllers\ProduitController@show');
Route::put('/produits/{produit}', 'App\Http\Controllers\ProduitController@updateProduit');
Route::delete('/produits/{produit}', 'App\Http\Controllers\ProduitController@suprProduit');
Route::post('/produits', 'App\Http\Controllers\ProduitController@ajtProduit');


//favoris(ajouter/suprimer/afficher)
Route::post('/favorite/add',[FavoriteController::class,'ajtFavoris']);
Route::get('/favorite/index/{userId}',[FavoriteController::class,'index']);
Route::get('/favorite/show/{produitId}',[FavoriteController::class,'show']);
Route::delete('/favorite/delete/{produitId}',[FavoriteController::class,'destroy']);

//panier(ajouter suprimer)
Route::post('/panier/add', [PanierController::class, 'addToPanier']);
Route::get('/panier/index/{userId}', [PanierController::class, 'getPanier']);
Route::delete('/panier/delete/{id}', [PanierController::class, 'removeFromPanier']);

//commande(crer la commade /afficher la commande)
Route::post('/order/create', [OrderController::class, 'createOrder']);
Route::get('/getuserorder/{userId}', [OrderController::class, 'getUserOrders']);
Route::get('/getuserorder/{userId}', [OrderController::class, 'getUserOrders']);
