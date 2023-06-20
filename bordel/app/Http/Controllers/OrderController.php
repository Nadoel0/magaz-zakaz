<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __invoke()
    {
        $owners = User::all();
        $shops = Shop::all();

        return view('order', compact('owners', 'shops'));
    }
}
