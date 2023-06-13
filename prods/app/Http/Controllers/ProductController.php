<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __invoke()
    {
        $persons = Person::all();

        return view('crud.index', compact('persons'));
    }
}
