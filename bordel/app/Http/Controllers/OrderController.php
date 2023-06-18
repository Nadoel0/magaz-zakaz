<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Shop;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __invoke()
    {
        $owners = Person::all();
        $shops = Shop::all();

        return view('order', compact('owners', 'shops'));
    }
}
