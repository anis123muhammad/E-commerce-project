<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = 'shipping_charges';

    protected $fillable = [
        'country_id',
        'amount'
    ];

    // Relationship with Country
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
