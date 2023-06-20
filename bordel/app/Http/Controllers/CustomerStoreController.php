<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderPerson;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerStoreController extends Controller
{
    public function __invoke(CustomerStoreRequest $request)
    {
        $data = $request->validated();
        $orderid = OrderPerson::create($data);

        $order = Order::find($orderid->order_id);
        $products = Product::all()->where('shop_id', $order->shop_id);

        return view('product', compact('products', 'order'));
    }
}
