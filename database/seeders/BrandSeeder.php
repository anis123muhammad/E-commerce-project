<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Apple', 'status' => 1],
            ['name' => 'Samsung', 'status' => 1],
            ['name' => 'Nike', 'status' => 1],
            ['name' => 'Adidas', 'status' => 1],
            ['name' => 'Dell', 'status' => 1],
            ['name' => 'Logitech', 'status' => 1],
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name'   => $brand['name'],
                'slug'   => Str::slug($brand['name']),
                'status' => $brand['status'],
            ]);
        }
    }
}
