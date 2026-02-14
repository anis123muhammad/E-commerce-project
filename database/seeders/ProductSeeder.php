<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Electronics
            [
                'category_id' => 1, 'sub_category_id' => 1, 'brand_id' => 1,
                'title' => 'iPhone 17 Pro', 'slug' => Str::slug('iPhone 17 Pro'),
                'price' => 350000, 'compare_price' => 370000,
                'description' => 'Latest Apple smartphone with powerful features.',
                'sku' => 'IP15PRO', 'barcode' => '123456789012',
                'track_qty' => 'Yes', 'qty' => 50, 'is_featured' => 'Yes', 'status' => 1,
                'images' => ['iphone17.jpg']
            ],
            [
                'category_id' => 1, 'sub_category_id' => 2, 'brand_id' => 2,
                'title' => 'Samsung Galaxy Book', 'slug' => Str::slug('Samsung Galaxy Book'),
                'price' => 250000, 'compare_price' => 270000,
                'description' => 'High performance laptop for professionals.',
                'sku' => 'SGB2026', 'barcode' => '123456789013',
                'track_qty' => 'Yes', 'qty' => 30, 'is_featured' => 'No', 'status' => 1,
                'images' => ['samsung_galaxy_book.jpg']
            ],
            [
                'category_id' => 1, 'sub_category_id' => 1, 'brand_id' => 1,
                'title' => 'MacBook Air M2', 'slug' => Str::slug('MacBook Air M2'),
                'price' => 280000, 'compare_price' => 300000,
                'description' => 'Lightweight and powerful Apple laptop.',
                'sku' => 'MBAIRM2', 'barcode' => '123456789015',
                'track_qty' => 'Yes', 'qty' => 25, 'is_featured' => 'Yes', 'status' => 1,
                'images' => ['macbook_air.jpg']
            ],
            [
                'category_id' => 2, 'sub_category_id' => 3, 'brand_id' => 2,
                'title' => 'Samsung Galaxy S23', 'slug' => Str::slug('Samsung Galaxy S23'),
                'price' => 220000, 'compare_price' => 240000,
                'description' => 'Latest Samsung smartphone with AMOLED display.',
                'sku' => 'SGS23', 'barcode' => '123456789016',
                'track_qty' => 'Yes', 'qty' => 40, 'is_featured' => 'No', 'status' => 1,
                'images' => ['samsung_s23.jpg']
            ],
            [
                'category_id' => 2, 'sub_category_id' => 3, 'brand_id' => 3,
                'title' => 'Dell XPS 13', 'slug' => Str::slug('Dell XPS 13'),
                'price' => 260000, 'compare_price' => 280000,
                'description' => 'High-end Windows laptop with sleek design.',
                'sku' => 'DXPS13', 'barcode' => '123456789017',
                'track_qty' => 'Yes', 'qty' => 15, 'is_featured' => 'No', 'status' => 1,
                'images' => ['dell_xps13.jpg']
            ],
            [
                'category_id' => 1, 'sub_category_id' => 1, 'brand_id' => 5,
                'title' => 'Apple Watch Series 9', 'slug' => Str::slug('Apple Watch Series 9'),
                'price' => 95000, 'compare_price' => 105000,
                'description' => 'Latest smartwatch from Apple.',
                'sku' => 'AWS9', 'barcode' => '123456789020',
                'track_qty' => 'Yes', 'qty' => 30, 'is_featured' => 'Yes', 'status' => 1,
                'images' => ['apple_watch.jpg']
            ],

            // Sports & Fitness
            [
                'category_id' => 3, 'sub_category_id' => 5, 'brand_id' => 3,
                'title' => 'Nike Dumbbell Set', 'slug' => Str::slug('Nike Dumbbell Set'),
                'price' => 12000, 'compare_price' => null,
                'description' => 'Perfect gym equipment for home workouts.',
                'sku' => 'NDS100', 'barcode' => '123456789014',
                'track_qty' => 'Yes', 'qty' => 20, 'is_featured' => 'No', 'status' => 1,
                'images' => ['nike_dumbbell.jpg']
            ],
            [
                'category_id' => 3, 'sub_category_id' => 6, 'brand_id' => 4,
                'title' => 'Adidas Ultraboost', 'slug' => Str::slug('Adidas Ultraboost'),
                'price' => 18000, 'compare_price' => 20000,
                'description' => 'Comfortable running shoes from Adidas.',
                'sku' => 'ADULTRA', 'barcode' => '123456789018',
                'track_qty' => 'Yes', 'qty' => 60, 'is_featured' => 'Yes', 'status' => 1,
                'images' => ['adidas_ultraboost.jpg']
            ],
            [
                'category_id' => 3, 'sub_category_id' => 6, 'brand_id' => 4,
                'title' => 'Nike Air Max 2026', 'slug' => Str::slug('Nike Air Max 2026'),
                'price' => 17000, 'compare_price' => 19000,
                'description' => 'Stylish sneakers for daily wear.',
                'sku' => 'NIKEAM26', 'barcode' => '123456789019',
                'track_qty' => 'Yes', 'qty' => 45, 'is_featured' => 'No', 'status' => 1,
                'images' => ['nike_airmax.jpg']
            ],
            [
                'category_id' => 3, 'sub_category_id' => 5, 'brand_id' => 3,
                'title' => 'Gym Mat Pro', 'slug' => Str::slug('Gym Mat Pro'),
                'price' => 5000, 'compare_price' => 6000,
                'description' => 'Durable mat for home workouts.',
                'sku' => 'GMPRO', 'barcode' => '123456789021',
                'track_qty' => 'Yes', 'qty' => 70, 'is_featured' => 'No', 'status' => 1,
                'images' => ['gym_mat.jpg']
            ],

            // Accessories
            [
                'category_id' => 1, 'sub_category_id' => 1, 'brand_id' => 6,
                'title' => 'AirPods Pro', 'slug' => Str::slug('AirPods Pro'),
                'price' => 55000, 'compare_price' => 60000,
                'description' => 'Wireless noise-cancelling earbuds from Apple.',
                'sku' => 'APPRO', 'barcode' => '123456789022',
                'track_qty' => 'Yes', 'qty' => 40, 'is_featured' => 'Yes', 'status' => 1,
                'images' => ['airpods_pro.jpg']
            ],
            [
                'category_id' => 1, 'sub_category_id' => 1, 'brand_id' => 6,
                'title' => 'Logitech MX Mouse', 'slug' => Str::slug('Logitech MX Mouse'),
                'price' => 15000, 'compare_price' => 17000,
                'description' => 'Ergonomic wireless mouse for productivity.',
                'sku' => 'LGMX1', 'barcode' => '123456789023',
                'track_qty' => 'Yes', 'qty' => 35, 'is_featured' => 'No', 'status' => 1,
                'images' => ['logitech_mx.jpg']
            ],

            // Gadgets
            [
                'category_id' => 1, 'sub_category_id' => 2, 'brand_id' => 2,
                'title' => 'Samsung Tablet S8', 'slug' => Str::slug('Samsung Tablet S8'),
                'price' => 120000, 'compare_price' => 130000,
                'description' => 'High-performance Samsung tablet.',
                'sku' => 'SGTS8', 'barcode' => '123456789024',
                'track_qty' => 'Yes', 'qty' => 20, 'is_featured' => 'No', 'status' => 1,
                'images' => ['samsung_tablet.jpg']
            ],
            [
                'category_id' => 1, 'sub_category_id' => 2, 'brand_id' => 3,
                'title' => 'Dell Inspiron 16', 'slug' => Str::slug('Dell Inspiron 16'),
                'price' => 220000, 'compare_price' => 240000,
                'description' => 'Reliable Windows laptop for home and office.',
                'sku' => 'DI16', 'barcode' => '123456789025',
                'track_qty' => 'Yes', 'qty' => 18, 'is_featured' => 'No', 'status' => 1,
                'images' => ['dell_inspiron.jpg']
            ],

            [
                'category_id' => 3, 'sub_category_id' => 5, 'brand_id' => 3,
                'title' => 'Yoga Mat Deluxe', 'slug' => Str::slug('Yoga Mat Deluxe'),
                'price' => 8000, 'compare_price' => 9000,
                'description' => 'Premium mat for yoga enthusiasts.',
                'sku' => 'YMDX', 'barcode' => '123456789026',
                'track_qty' => 'Yes', 'qty' => 60, 'is_featured' => 'No', 'status' => 1,
                'images' => ['yoga_mat.jpg']
            ],

            [
                'category_id' => 3, 'sub_category_id' => 6, 'brand_id' => 4,
                'title' => 'Puma Running Shoes', 'slug' => Str::slug('Puma Running Shoes'),
                'price' => 15000, 'compare_price' => 17000,
                'description' => 'Lightweight running shoes for daily use.',
                'sku' => 'PRS2026', 'barcode' => '123456789027',
                'track_qty' => 'Yes', 'qty' => 55, 'is_featured' => 'No', 'status' => 1,
                'images' => ['puma_running.jpg']
            ],

            [
                'category_id' => 3, 'sub_category_id' => 6, 'brand_id' => 3,
                'title' => 'Resistance Bands Set', 'slug' => Str::slug('Resistance Bands Set'),
                'price' => 5000, 'compare_price' => null,
                'description' => 'Essential workout accessory for strength training.',
                'sku' => 'RBS100', 'barcode' => '123456789028',
                'track_qty' => 'Yes', 'qty' => 80, 'is_featured' => 'No', 'status' => 1,
                'images' => ['resistance_bands.jpg']
            ],

            [
                'category_id' => 1, 'sub_category_id' => 1, 'brand_id' => 1,
                'title' => 'Apple iPad Pro', 'slug' => Str::slug('Apple iPad Pro'),
                'price' => 210000, 'compare_price' => 230000,
                'description' => 'Powerful tablet for work and entertainment.',
                'sku' => 'IPADPRO', 'barcode' => '123456789029',
                'track_qty' => 'Yes', 'qty' => 25, 'is_featured' => 'Yes', 'status' => 1,
                'images' => ['ipad_pro.jpg']
            ],
        ];

        foreach ($products as $p) {
            $product = Product::create([
                'category_id'     => $p['category_id'],
                'sub_category_id' => $p['sub_category_id'],
                'brand_id'        => $p['brand_id'],
                'title'           => $p['title'],
                'slug'            => $p['slug'],
                'price'           => $p['price'],
                'compare_price'   => $p['compare_price'],
                'description'     => $p['description'],
                'sku'             => $p['sku'],
                'barcode'         => $p['barcode'],
                'track_qty'       => $p['track_qty'],
                'qty'             => $p['qty'],
                'is_featured'     => $p['is_featured'],
                'status'          => $p['status'],
            ]);

            // Save images
            if (!empty($p['images'])) {
                foreach ($p['images'] as $index => $image) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $image,
                        'sort_order' => $index + 1,
                    ]);
                }
            }
        }
    }
}
