<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderUser;
use App\Models\Shop;
use App\Models\User;

class OrderController extends Controller
{
    public function index()
    {
        $orders = OrderUser::all();

        return view('order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('order.show', compact('order'));
    }

    public function create()
    {
        $shops = Shop::all();
//        $product
    }
}
