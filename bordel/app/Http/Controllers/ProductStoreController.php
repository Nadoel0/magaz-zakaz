<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Basket;
use Illuminate\Http\Request;

class ProductStoreController extends Controller
{
    public function __invoke(ProductStoreRequest $request)
    {
        $data = $request->validated();

        Basket::create($data);

        return view('main');
    }
}
