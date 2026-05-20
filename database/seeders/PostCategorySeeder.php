<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class PostCategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->categories() as $category) {
            PostCategory::query()->updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }

    private function categories(): array
    {
        return [
            [
                'name' => 'Chính sách',
                'slug' => 'chinh-sach',
                'description' => 'Tổng hợp chính sách mua hàng, bảo hành và bảo mật tại Tech One.',
                'is_active' => true,
            ],
            [
                'name' => 'Hỗ trợ khách hàng',
                'slug' => 'ho-tro',
                'description' => 'Các bài viết hỗ trợ khách hàng và giải đáp câu hỏi thường gặp.',
                'is_active' => true,
            ],
        ];
    }
}
