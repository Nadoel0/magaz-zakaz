<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderUser;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function store(OrderStoreRequest $request)
    {
        $data = $request->validated();
        $order = Order::create($data);
        $users = User::all();
        OrderUser::create([
            'order_id' => $order->id,
            'user_id' => Auth::user()->id
        ]);

        return view('order.users', compact('order', 'users'));
    }

    public function destroy()
    {
        dd('destroy basket');
    }
}
