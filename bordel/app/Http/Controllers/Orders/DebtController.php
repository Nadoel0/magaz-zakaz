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

class DebtController extends Controller
{
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $users = $order->orderUser()->get();

        return view('order.debt', compact('order', 'users'));
    }

    public function completedOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $totalAmount = $order->basket()->sum('price');
        $paidUsers = $request->input('paidUsers', []);
        $allUsers = $order->orderUser;
        $debt = 0;

        foreach ($allUsers as $orderUser) {
            $user = $orderUser->user;
            $userPaid = in_array($user->id, $paidUsers);
            if (!$userPaid) {
                $userBasketTotal = $order->basket()->where('user_id', $user->id)->sum('price');
                $debt = $totalAmount - $userBasketTotal;
            }
            User::where('id', $user->id)->update(['debt' => $debt]);
        }

        return redirect()->route('order.index');
    }
}
