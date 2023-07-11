<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function store(Request $request, $orderID, $userID)
    {
        $order = Order::findOrFail($orderID);
        $userOrder = OrderUser::create([
            'order_id' => $orderID,
            'user_id' => $userID,
        ]);
        $userData = $userOrder->user;

        $usersInOrder = $order->orderUser()->pluck('user_id')->toArray();
        $usersNotInOrder = User::whereNotIn('id', $usersInOrder)->get();

        $response = [
            'orderUserID' => $userOrder->id,

            'userData' => [
                'name' => $userData->name,
                'email' => $userData->email
            ],

            'usersNotInOrder' => $usersNotInOrder
        ];

        return response()->json($response);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        $peopleID = request('people_id');
        $userOrder = OrderUser::where('id', $peopleID)->first();

        if ($userOrder) {
            $userOrder->delete();
        }

        $usersInOrder = $order->orderUser()->pluck('user_id')->toArray();
        $usersNotInOrder = User::whereNotIn('id', $usersInOrder)->get();

        $response = [
            'usersNotInOrder' => $usersNotInOrder,
        ];

        return response()->json($response);
    }
}
