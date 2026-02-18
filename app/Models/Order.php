<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'subtotal',
        'shipping',
        'coupon_code',
        'discount',
        'grand_total',
        'first_name',
        'last_name',
        'email',           // Add this
        'mobile',
        'country_id',
        'address',
        'apartment',
        'city',
        'state',
        'zip',
        'notes',
        'payment_method',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
