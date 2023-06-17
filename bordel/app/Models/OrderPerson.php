<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPerson extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
