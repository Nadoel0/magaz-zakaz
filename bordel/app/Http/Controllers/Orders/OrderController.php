<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\OrderUser;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
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
        $owner = Auth::user();

        return view('order.create', compact('shops', 'owner'));
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

        return redirect()->route('order.index');
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $user = Auth::user();
        $basket = $order->basket()->where('user_id', $user->id)->with('product')->get();
        $users = $order->orderUser()->get();
        $products = $order->shop->products;
        $allUsers = User::all();
        $isOwner = $order->owner_id == Auth::user()->id;

        return view('order.show', compact('order', 'basket', 'users', 'products', 'allUsers', 'isOwner'));
    }

    public function update(Request $request, $id) {
        $order = Order::findOrFail($id);
        $updatedFields = [
            'owner_id' => $order->owner_id,
            'shop_id' => $order->shop_id,
        ];

        if ($request->has('name')) $updatedFields['name'] = $request->input('name');
        if ($request->has('status')) $updatedFields['status'] = $request->input('status');

        $order->update($updatedFields);

        $response = [
            'order' => [
                'name' => $order->name,
                'status' => $order->status,
            ]
        ];

        return response()->json($response);
    }
}
