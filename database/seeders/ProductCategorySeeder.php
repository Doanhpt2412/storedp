<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate table to prevent duplicate slugs
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        ProductCategory::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 1. Tạo các danh mục Gốc hiển thị trên Navigation Bar (show_in_nav = true)
        $navCategories = [
            ['name' => 'Điện thoại', 'icon' => 'phone-icon', 'order' => 1],
            ['name' => 'Laptop', 'icon' => 'laptop-icon', 'order' => 2],
            ['name' => 'Máy cũ', 'icon' => 'old-icon', 'order' => 3],
            ['name' => 'Máy tính bảng', 'icon' => 'tablet-icon', 'order' => 4],
            ['name' => 'Đồng hồ thông minh', 'icon' => 'watch-icon', 'order' => 5],
            ['name' => 'Nhà thông minh', 'icon' => 'smart-home-icon', 'order' => 6],
            ['name' => 'Phụ kiện', 'icon' => 'accessory-icon', 'order' => 7],
            ['name' => 'Âm thanh', 'icon' => 'audio-icon', 'order' => 8],
            ['name' => 'Khuyến mãi', 'icon' => 'promo-icon', 'order' => 9],
        ];

        $roots = [];
        foreach ($navCategories as $cat) {
            $roots[$cat['name']] = ProductCategory::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'parent_id' => null,
                'icon' => $cat['icon'],
                'order' => $cat['order'],
                'show_in_nav' => true,
                'is_active' => true,
            ]);
        }

        // 2. Nhánh Điện thoại
        $dienThoai = $roots['Điện thoại'];

        // Điện thoại > iPhone Series
        $iphoneSeries = ProductCategory::create([
            'name' => 'iPhone Series',
            'slug' => 'iphone-series',
            'parent_id' => $dienThoai->id,
            'order' => 1,
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'iPhone 16 Pro Max',
            'slug' => 'iphone-16-pro-max',
            'parent_id' => $iphoneSeries->id,
            'order' => 1,
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'iPhone 15',
            'slug' => 'iphone-15',
            'parent_id' => $iphoneSeries->id,
            'order' => 2,
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'iPhone 15 Pro',
            'slug' => 'iphone-15-pro',
            'parent_id' => $iphoneSeries->id,
            'order' => 3,
            'is_active' => true,
        ]);

        // Điện thoại > Galaxy S Series
        $galaxyS = ProductCategory::create([
            'name' => 'Galaxy S Series',
            'slug' => 'galaxy-s-series',
            'parent_id' => $dienThoai->id,
            'order' => 2,
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'Galaxy S25 Ultra',
            'slug' => 'galaxy-s25-ultra',
            'parent_id' => $galaxyS->id,
            'order' => 1,
            'is_active' => true,
        ]);

        // Điện thoại > Xiaomi Series
        $xiaomiSeries = ProductCategory::create([
            'name' => 'Xiaomi Series',
            'slug' => 'xiaomi-series',
            'parent_id' => $dienThoai->id,
            'order' => 3,
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'Xiaomi 15 Ultra',
            'slug' => 'xiaomi-15-ultra',
            'parent_id' => $xiaomiSeries->id,
            'order' => 1,
            'is_active' => true,
        ]);

        // 3. Nhánh Laptop
        $laptopRoot = $roots['Laptop'];

        // Laptop > MacBook Air Series
        $macAir = ProductCategory::create([
            'name' => 'MacBook Air Series',
            'slug' => 'macbook-air-series',
            'parent_id' => $laptopRoot->id,
            'order' => 1,
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'MacBook Air M4',
            'slug' => 'macbook-air-m4',
            'parent_id' => $macAir->id,
            'order' => 1,
            'is_active' => true,
        ]);

        // Laptop > MacBook Pro Series
        $macPro = ProductCategory::create([
            'name' => 'MacBook Pro Series',
            'slug' => 'macbook-pro-series',
            'parent_id' => $laptopRoot->id,
            'order' => 2,
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'MacBook Pro M4',
            'slug' => 'macbook-pro-m4',
            'parent_id' => $macPro->id,
            'order' => 1,
            'is_active' => true,
        ]);

        // Laptop > Desktop Mac
        $desktopMac = ProductCategory::create([
            'name' => 'Desktop Mac',
            'slug' => 'desktop-mac',
            'parent_id' => $laptopRoot->id,
            'order' => 3,
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'Mac mini',
            'slug' => 'mac-mini',
            'parent_id' => $desktopMac->id,
            'order' => 1,
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'iMac',
            'slug' => 'imac',
            'parent_id' => $desktopMac->id,
            'order' => 2,
            'is_active' => true,
        ]);
    }
}
