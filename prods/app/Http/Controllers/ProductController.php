<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __invoke()
    {
        $orders = Order::all();

        return view('crud.index', compact('orders'));
    }
}
