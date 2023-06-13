<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Person;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(ProductRequest $request)
    {
        $data = $request -> validated();
        Person::create($data);

        return redirect() -> route('order.index');
    }
}
