<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCoupon extends Model
{
    protected $table = 'discount_coupons';

    protected $fillable = [
        'code',
        'name',
        'description',
        'max_uses',
        'max_uses_per_user',
        'type',
        'discount_amount',
        'min_amount',
        'status',
        'starts_at',
        'expires_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'status' => 'boolean',
    ];
}
