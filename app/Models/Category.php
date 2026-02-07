<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'status',
        'showHome',

    ];

    protected $casts = [
        'status' => 'integer',
    ];


        public function sub_categories()
    {
        return $this->hasMany(SubCategory::class);
    }

}
