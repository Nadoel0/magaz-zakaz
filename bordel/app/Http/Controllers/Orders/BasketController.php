<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderUser;
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
            'product_name' => $request->input('name'),
            'amount' => $request->input('amount'),
            'comment' => $request->input('comment'),
            'price' => $request->input('price'),
        ]);

        $response = [
            'id' => $basket->id,
            'name' => $basket->product_name,
            'amount' => $basket->amount,
            'price' => $basket->price
        ];

        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        $basket = Basket::findOrFail($request->input('productID'));
        $basket->update([
            'amount' => $request->input('amount'),
            'price' => $request->input('price'),
        ]);

        $response = [
            'amount' => $basket->amount,
            'price' => $basket->price,
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
