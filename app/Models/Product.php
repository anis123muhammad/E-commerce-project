<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'compare_price',
        'category_id',
        'sub_category_id',
        'brand_id',
        'sku',
        'barcode',
        'track_qty',
        'qty',
        'is_featured',
        'status',
    ];

    // ✅ Relationship with images
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // ✅ Relationship with category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ✅ Relationship with subcategory
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    // ✅ Relationship with brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
