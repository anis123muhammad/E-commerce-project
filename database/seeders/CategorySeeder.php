<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            "Electronics",
            "Fashion",
            "Sports",
            "Books",
            "Home Appliances",
            "Beauty & Personal Care",
            "Toys & Games",
            "Automotive",
            "Groceries",
            "Furniture"
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name'     => $cat,
                'slug'     => Str::slug($cat),
                'image'    => null,
                'status'   => 1,
                'showHome' => 'Yes',  // ✅ show on homepage
            ]);
        }
    }
}
