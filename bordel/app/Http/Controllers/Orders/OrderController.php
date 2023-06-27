<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\OrderUser;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::user(Auth::user()->id)->get();

        return view('order.index', compact('orders'));
    }

    public function create()
    {
        $shops = Shop::all();
        $owners = User::all();

        return view('order.create', compact('shops', 'owners'));
    }

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

    public function show($id)
    {
        $order = Order::find($id);
        $products = $order->shop->products;
        $users_id = $order->orderUser;
        $users = [];
        foreach ($users_id as $user) {
            $users['name'] = User::where('id', $user->user_id)->get('name');
            $users['email'] = User::where('id', $user->user_id)->get('email');
        }
        $basket = $order->basket;

        $isOwner = $order->owner_id == Auth::user()->id;

        return view('order.show', compact('products', 'order', 'users', 'products', 'basket', 'isOwner'));
    }
}
