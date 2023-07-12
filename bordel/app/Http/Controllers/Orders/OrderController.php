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
        $owner = Auth::user();
        $users = User::all();

        foreach ($orders as $key => $order) {
            $isOwner = $order->owner_id == Auth::user()->id;
            $isPaid = $order->orderUser()->pluck('paid');

            if ($isOwner && $isPaid);
            elseif ($isOwner && !$isPaid);
            elseif (!$isOwner && $isPaid);
            else unset($orders[$key]);
        }

        return view('order.index', compact('orders', 'owner', 'users'));
    }

    public function store(Request $request)
    {
        $message = [
            'name.required' => 'Введите имя заказа',
            'user_id.required' => 'Выберите пользователей',
        ];

        $validatedData = $request->validate([
            'name' => 'required',
            'user_id' => 'required|array',
        ], $message);

        $ownerID = $request->input('owner_id');
        $userIDs = $request->input('user_id');

        $order = Order::create([
            'name' => $request->input('name'),
            'owner_id' => $ownerID,
            'status' => $request->input('status')
        ]);

        array_push($userIDs, $ownerID);

        foreach ($userIDs as $userID) {
            OrderUser::create([
               'order_id' => $order->id,
               'user_id' => $userID,
            ]);
        }

        $response = [
            'id' => $order->id,
            'name' => $order->name,
            'date' => $order->created_at,
        ];

        return response()->json($response);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $currentUser = Auth::user();
        $basket = $order->basket()->where('user_id', $currentUser->id)->get();
        $users = $order->orderUser()->get();
        $orderUserID = $users->where('order_id', $id)->where('user_id', $currentUser->id)->first();
        $isOwner = $order->owner_id == Auth::user()->id;
        $paid = $currentUser->orderUsers()->where('order_id', $id)->pluck('paid')->first();
        $usersInOrder = $order->orderUser()->pluck('user_id')->toArray();
        $usersNotInOrder = User::whereNotIn('id', $usersInOrder)->get();

        return view('order.show', compact('order', 'basket', 'currentUser', 'users', 'orderUserID', 'usersNotInOrder', 'isOwner', 'paid'));
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
