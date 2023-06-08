<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __invoke()
    {
        $order = Order::all();

        return view('orders', compact('order'));
    }
}
