<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderUser;
use App\Models\User;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function update(Request $request, $id)
    {
        $orderUserDebt = OrderUser::where('order_id', $id)->where('user_id', $request->input('user_id'))->firstOrFail();
        $updatedFields = [];

        if ($request->has('debt')) $updatedFields['debt'] = $request->input('debt');
        if ($request->has('paid')) $updatedFields['paid'] = $request->input('paid');

        $orderUserDebt->update($updatedFields);

        return response()->json(['message' => 'Долг обновлен']);
    }
}
