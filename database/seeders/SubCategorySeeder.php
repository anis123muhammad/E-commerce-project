<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Str;

class SubCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Get only categories set to show on home
        $categories = Category::where('showHome', 'Yes')->pluck('id', 'name')->toArray();

        $subcategories = [
            ['category' => 'Electronics', 'name' => 'Mobiles'],
            ['category' => 'Electronics', 'name' => 'Laptops'],
            ['category' => 'Electronics', 'name' => 'Cameras'],
            ['category' => 'Fashion', 'name' => 'Men Clothing'],
            ['category' => 'Fashion', 'name' => 'Women Clothing'],
            ['category' => 'Fashion', 'name' => 'Accessories'],
            ['category' => 'Sports', 'name' => 'Gym Items'],
            ['category' => 'Sports', 'name' => 'Football Kits'],
            ['category' => 'Sports', 'name' => 'Sports Shoes'],
            ['category' => 'Books', 'name' => 'Fiction'],
            ['category' => 'Books', 'name' => 'Non-Fiction'],
            ['category' => 'Books', 'name' => 'Educational'],
            ['category' => 'Home Appliances', 'name' => 'Kitchen Appliances'],
            ['category' => 'Home Appliances', 'name' => 'Home Decor'],
            ['category' => 'Home Appliances', 'name' => 'Furniture'],
        ];

        foreach ($subcategories as $sub) {
            $categoryId = $categories[$sub['category']] ?? null;

            // Only create subcategory if parent category is set to show on home
            if ($categoryId) {
                SubCategory::create([
                    'category_id' => $categoryId,
                    'name'        => $sub['name'],
                    'slug'        => Str::slug($sub['name']),
                    'status'      => 1
                ]);
            }
        }
    }
}
