<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;


        // ✅ Add this fillable
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'status',
                'showHome',  // ← Make sure this is here!

    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
