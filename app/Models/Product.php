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
        'short_description',      // Add this
        'shipping_returns',        // Add this
        'price',
        'compare_price',
        'category_id',
        'sub_category_id',
        'brand_id',
        'sku',
        'barcode',
        'barcode_image',
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
    public function firstImage()
    {
    return $this->hasOne(ProductImage::class)->latest();
    }

    // ✅ Many-to-Many Related Products
public function relatedProducts()
{
    return $this->belongsToMany(
        Product::class,
        'product_related',
        'product_id',
        'related_product_id'
    );
}
    

}
