<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $guarded = false;
    public function order()
    {
        return $this->hasMany(Order::class);
    }

//    public function basket()
//    {
//        return $this->hasMany(Basket::class);
//    }

    public function orderPerson()
    {
        return $this->hasMany(OrderPerson::class);
    }
}
