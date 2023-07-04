<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function store(Request $request, $id)
    {
        $user = Auth::user();
        $basket = Basket::create([
            'order_id' => $id,
            'user_id' => $user->id,
            'product_id' => $request->input('product_id'),
            'comment' => $request->input('comment'),
            'price' => $request->input('price')
        ]);
        $product = $basket->product;

        $response = [
            'basketID' => $basket->id,

            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price
            ]
        ];

        return response()->json($response);
    }
    public function destroy($id)
    {
        $productID = request('product_id');
        $basket = Basket::where('id', $productID)->first();

        if ($basket) {
            $basket->delete();
        }

        return back();
    }

}
