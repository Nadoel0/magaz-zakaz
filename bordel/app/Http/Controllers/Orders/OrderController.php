<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderUser;
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
        $owner = Auth::user();
        $users = User::all();

        return view('order.create', compact('users', 'owner'));
    }

    public function store(Request $request)
    {
        $order = Order::create([
            'name' => $request->input('name'),
            'owner_id' => $request->input('owner_id'),
            'status' => $request->input('status')
        ]);
        $userIDs = $request->input('user_id');
        foreach ($userIDs as $userID) {
            OrderUser::create([
               'order_id' => $order->id,
               'user_id' => $userID,
            ]);
        }

        return redirect()->route('order.index');
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $currentUser = Auth::user();
        $basket = $order->basket()->where('user_id', $currentUser->id)->get();
        $users = $order->orderUser()->get();
        $orderUserID = $users->where('order_id', $id)->where('user_id', $currentUser->id)->first();
        $allUsers = User::all();
        $isOwner = $order->owner_id == Auth::user()->id;
        $paid = $currentUser->orderUsers()->where('order_id', $id)->pluck('paid')->first();

        return view('order.show', compact('order', 'basket', 'currentUser', 'users', 'orderUserID', 'allUsers', 'isOwner', 'paid'));
    }

    public function update(Request $request, $id) {
        $order = Order::findOrFail($id);
        $updatedFields = [];

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
