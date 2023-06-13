<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = false;
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function basket()
    {
        return $this->belongsTo(Basket::class);
    }
}
