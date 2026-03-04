<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Country;
use App\Models\DiscountCoupon;

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
        'email',
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

    // Order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Order has many items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Order belongs to a country
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // Order belongs to a coupon (if you use coupon_id instead of coupon_code)
    public function coupon()
    {
        return $this->belongsTo(DiscountCoupon::class, 'coupon_id');
    }


}
