<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function __invoke()
    {
        return view('crud.create');
    }
}
