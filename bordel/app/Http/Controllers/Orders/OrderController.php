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
        $order = Order::findOrFail($id);
        $basket = $order->basket()->with('product')->get();
        $users = $order->orderUser()->get();
        $products = $order->shop->products;
//        dd($order);
//        dump($order->with(['basket.product'])->first()->toArray());
//        dd($order->basketByUser(Auth::user()->id)->get());
//        foreach($order->basket as $basket_) {
//            dump($basket_->product);
//        }

        $isOwner = $order->owner_id == Auth::user()->id;

        return view('order.show', compact('order', 'basket', 'users', 'products', 'isOwner'));
    }
}
