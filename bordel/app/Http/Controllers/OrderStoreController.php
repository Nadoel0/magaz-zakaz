<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\Person;
use App\Models\Product;

class OrderStoreController extends Controller
{
    public function __invoke(OrderStoreRequest $request)
    {
        $data = $request->validated();
        $order = Order::create($data);

        $products = Product::all()->where('shop_id', $order->shop_id);

        return view('product', compact('products', 'order'));
    }
}
