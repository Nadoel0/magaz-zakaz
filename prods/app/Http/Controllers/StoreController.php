<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(ProductRequest $request)
    {
        $data = $request -> validated();
        Order::create($data);

        return redirect() -> route('order');
    }
}
