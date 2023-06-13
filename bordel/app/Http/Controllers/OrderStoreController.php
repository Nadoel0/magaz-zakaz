<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\PersonStoreRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderStoreController extends Controller
{
    public function __invoke(OrderStoreRequest $request)
    {
        $data = $request->validated();
        Order::create($data);

        return view('order');
    }
}
