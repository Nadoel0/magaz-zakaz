<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonStoreRequest;
use App\Models\Order;
use App\Models\Person;
use App\Models\Shop;
use Illuminate\Http\Request;

class PersonStoreController extends Controller
{
    public function __invoke(PersonStoreRequest $request)
    {
        $data = $request->validated();
        Person::create($data);

        $customers = Person::all();
        $shops = Shop::all();


        return view('order', compact('customers', 'shops'));
    }
}
