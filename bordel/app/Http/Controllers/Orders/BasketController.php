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
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required',
            'user_id' => 'required',
            'product_id' => 'required',
            'comment' => 'required',
            'price' => 'required'
        ]);
        $basket = Basket::create($data);
        dd($basket);

        return view('order.show', compact('order', 'users'));
    }

    public function destroy()
    {
        dd('destroy basket');
    }
}
