<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\PersonStoreRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderStoreController extends Controller
{
    public function __invoke(OrderStoreRequest $request)
    {
        $data = $request->validated();
        $order = Order::create($data);

        $products = Product::all();

        return view('product', compact('products', 'order'));
    }
}
