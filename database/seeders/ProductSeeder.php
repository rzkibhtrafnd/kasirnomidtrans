<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $makanan = Category::where('name', 'Makanan')->first();
        $minuman = Category::where('name', 'Minuman')->first();

        Product::insert([
            // =======================
            // MAKANAN
            // =======================
            [
                'category_id' => $makanan->id,
                'name' => 'Nasi Goreng',
                'price' => 25000,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $makanan->id,
                'name' => 'Mie Goreng',
                'price' => 22000,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $makanan->id,
                'name' => 'Kentang Goreng',
                'price' => 18000,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $makanan->id,
                'name' => 'Roti Bakar',
                'price' => 20000,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // =======================
            // MINUMAN
            // =======================
            [
                'category_id' => $minuman->id,
                'name' => 'Kopi Hitam',
                'price' => 15000,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $minuman->id,
                'name' => 'Cappuccino',
                'price' => 22000,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $minuman->id,
                'name' => 'Es Teh',
                'price' => 10000,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => $minuman->id,
                'name' => 'Es Coklat',
                'price' => 18000,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
