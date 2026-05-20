<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->settings() as $key => $value) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        Cache::forget('site_settings.payload');
    }

    private function settings(): array
    {
        return [
            'site' => [
                'site_name' => 'Tech One',
                'site_tagline' => 'Hệ thống bán lẻ công nghệ chính hãng',
                'logo_alt' => 'Tech One',
                'logo_url' => null,
                'favicon_url' => null,
            ],
            'seo' => [
                'meta_title' => 'Tech One',
                'meta_description' => 'Tech One - hệ thống bán lẻ điện thoại, laptop, tablet, phụ kiện và thiết bị công nghệ chính hãng.',
                'meta_keywords' => 'tech one, điện thoại, laptop, máy tính bảng, phụ kiện, công nghệ',
                'og_image_url' => null,
            ],
            'contact' => [
                'hotline' => '0246 6819 779',
                'email' => 'support@techone.vn',
                'address' => '388 Cầu Giấy - P. Dịch Vọng - Q. Cầu Giấy - TP. Hà Nội',
                'working_hours' => '08:00 - 22:00 mỗi ngày',
            ],
            'header_menu' => [
                ['label' => 'Tin tức', 'url' => '/tin-tuc'],
                ['label' => 'Chính sách', 'url' => '/tin-tuc/chinh-sach'],
                ['label' => 'Hỗ trợ', 'url' => '/tin-tuc/ho-tro'],
            ],
            'footer' => [
                'about_title' => 'Sản phẩm',
                'about_links' => [
                    ['label' => 'Điện thoại', 'url' => '/catalog/dien-thoai'],
                    ['label' => 'Laptop', 'url' => '/catalog/laptop'],
                    ['label' => 'Máy tính bảng', 'url' => '/catalog/may-tinh-bang'],
                    ['label' => 'Đồng hồ thông minh', 'url' => '/catalog/dong-ho-thong-minh'],
                    ['label' => 'Phụ kiện', 'url' => '/catalog/phu-kien'],
                ],
                'policy_title' => 'Chính sách',
                'policy_links' => [
                    ['label' => 'Mua hàng', 'url' => '/tin-tuc/chinh-sach/huong-dan-mua-hang'],
                    ['label' => 'Bảo hành', 'url' => '/tin-tuc/chinh-sach/chinh-sach-bao-hanh'],
                    ['label' => 'Bảo mật', 'url' => '/tin-tuc/chinh-sach/chinh-sach-bao-mat'],
                ],
                'support_title' => 'Hỗ trợ',
                'support_links' => [
                    ['label' => 'Câu hỏi thường gặp', 'url' => '/tin-tuc/ho-tro/cau-hoi-thuong-gap'],
                ],
                'copyright_text' => '© 2026 Tech One. Tất cả các quyền được bảo lưu.',
            ],
        ];
    }
}
