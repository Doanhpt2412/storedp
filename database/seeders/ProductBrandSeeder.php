<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\ProductBrand::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $brands = [
            ['name' => 'Apple', 'slug' => 'apple', 'order' => 1],
            ['name' => 'Samsung', 'slug' => 'samsung', 'order' => 2],
            ['name' => 'Xiaomi', 'slug' => 'xiaomi', 'order' => 3],
            ['name' => 'Nokia', 'slug' => 'nokia', 'order' => 4],
            ['name' => 'TCL', 'slug' => 'tcl', 'order' => 5],
            ['name' => 'Tecno', 'slug' => 'tecno', 'order' => 6],
            ['name' => 'Sony', 'slug' => 'sony', 'order' => 7],
            ['name' => 'Anker', 'slug' => 'anker', 'order' => 8],
        ];

        foreach ($brands as $brand) {
            \App\Models\ProductBrand::create([
                'name' => $brand['name'],
                'slug' => $brand['slug'],
                'logo' => null,
                'order' => $brand['order'],
                'is_active' => true,
            ]);
        }
    }
}
