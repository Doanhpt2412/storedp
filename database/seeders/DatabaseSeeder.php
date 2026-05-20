<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tài khoản Admin
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Tài khoản Customer
        User::firstOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'Customer User',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        // Tài khoản User thường
        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Standard User',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // Danh mục sản phẩm
        $this->call(ProductCategorySeeder::class);
        $this->call(ProductBrandSeeder::class);
        $this->call(PostCategorySeeder::class);
        $this->call(PostSeeder::class);
        $this->call(SiteSettingsSeeder::class);
    }
}
