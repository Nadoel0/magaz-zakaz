<?php

namespace App\Http\Controllers\Shops;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;

class ShopController extends Controller
{
    public function __invoke()
    {
        $owners = User::all();
        $shops = Shop::all();

        return view('order', compact('owners', 'shops'));
    }
}
