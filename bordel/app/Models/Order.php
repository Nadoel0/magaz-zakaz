<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = false;
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function basket()
    {
        return $this->hasMany(Basket::class);
    }

    public function basketByUser($user_id) {
        return $this->basket()->where('user_id', '=', $user_id);
    }

    public function orderUser()
    {
        return $this->hasMany(OrderUser::class);
    }

    public function scopeUser($query, $user_id)
    {
        return $query->whereHas('orderUser', function ($query) use ($user_id) {
            $query->where('user_id', '=', $user_id);
            });
    }
}
