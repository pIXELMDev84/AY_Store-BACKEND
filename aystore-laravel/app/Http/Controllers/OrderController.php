<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Panier;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function getUserOrders($userId)
    {
        $orders = Order::where('user_id', $userId)->with('items.produit')->get();
        return response()->json($orders);
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:paniers,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => $request->user_id,
            'status' => 'pending', // or any other status you want to use
        ]);

        foreach ($request->items as $item) {
            $panierItem = Panier::find($item['id']);
            OrderItem::create([
                'order_id' => $order->id,
                'produit_id' => $panierItem->produit_id,
                'quantity' => $item['quantity'],
                'price' => $panierItem->produit->prix,
            ]);
            $panierItem->delete();
        }

        

        return response()->json($order, 201);
    }
}
