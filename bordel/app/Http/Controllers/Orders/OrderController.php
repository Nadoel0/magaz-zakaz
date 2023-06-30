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

        redirect()->route('order.index');
    }

    public function show($id)
    {
        $order = Order::findOrFail($id)->with(['basket.product'])->first()->toArray();
        dd($order);
        dump($order);
        dump($order->basket);
//        dd($order->basketByUser(Auth::user()->id)->get());
        foreach($order->basket as $basket_) {
            dump($basket_->product);
        }

        dd('');
        $isOwner = $order->owner_id == Auth::user()->id;

        return view('order.show', compact('products', 'order', 'users', 'products', 'basket', 'isOwner'));
    }
}
