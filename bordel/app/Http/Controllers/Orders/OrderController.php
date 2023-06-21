<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\OrderUser;
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

    public function show(Order $order)
    {
        return view('order.show', compact('order'));
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

        return view('order.users', compact('order', 'users'));
    }

    public function users(CustomerStoreRequest $request)
    {
        $data = $request->validated();
        $order = $data['order_id'];
        foreach ($data['user_id'] as $user)
            OrderUser::create([
                'order_id' => $order,
                'user_id' => $user
            ]);

        return redirect()->route('order.index');
    }
}
