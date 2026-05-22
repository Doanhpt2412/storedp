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
            'hero_slides' => [
                [
                    'eyebrow' => 'Apple Flagship',
                    'title' => 'iPhone 16 Series giá tốt, lên đời nhanh tại Tech One.',
                    'description' => 'Tập trung vào nhóm máy cao cấp, trợ giá thu cũ đổi mới và quà tặng phụ kiện cho nhu cầu nâng cấp mỗi ngày.',
                    'primary_label' => 'Mua iPhone ngay',
                    'primary_url' => '/search?s=iphone+16',
                    'secondary_label' => 'Xem điện thoại',
                    'secondary_url' => '/catalog/dien-thoai',
                    'highlight_label' => 'Ưu đãi nổi bật',
                    'highlight_text' => 'Giao nhanh 2 giờ nội thành',
                    'card_title' => 'Bộ sưu tập iPhone chính hãng',
                    'card_text' => 'Nhiều phiên bản màu, hỗ trợ trả góp linh hoạt và giao máy nhanh trong ngày.',
                    'image_url' => 'https://placehold.co/1600x900/111827/FFFFFF/png?text=iPhone+16+Series',
                ],
                [
                    'eyebrow' => 'MacBook M4',
                    'title' => 'Laptop cho học tập và sáng tạo với hiệu năng ổn định.',
                    'description' => 'Phù hợp cho sinh viên, dân văn phòng và creator với cấu hình M4, RAM 16GB, SSD tốc độ cao và sẵn hàng.',
                    'primary_label' => 'Chọn MacBook',
                    'primary_url' => '/search?s=macbook+m4',
                    'secondary_label' => 'Xem laptop',
                    'secondary_url' => '/catalog/laptop',
                    'highlight_label' => 'Quà tặng thêm',
                    'highlight_text' => 'Tặng túi chống sốc và phần mềm văn phòng',
                    'card_title' => 'MacBook Air và Pro thế hệ mới',
                    'card_text' => 'Thiết kế mỏng nhẹ, pin bền và phù hợp cho cả công việc lẫn giải trí dài giờ.',
                    'image_url' => 'https://placehold.co/1600x900/0F766E/FFFFFF/png?text=MacBook+M4',
                ],
                [
                    'eyebrow' => 'Smart Living',
                    'title' => 'Đồng hồ, tai nghe và phụ kiện thông minh đang có nhiều quà tặng.',
                    'description' => 'Danh cho nhóm khách muốn đồng bộ hệ sinh thái công nghệ với những sản phẩm dễ dùng, đẹp và dễ tư vấn.',
                    'primary_label' => 'Xem phụ kiện',
                    'primary_url' => '/catalog/phu-kien',
                    'secondary_label' => 'Xem âm thanh',
                    'secondary_url' => '/catalog/am-thanh',
                    'highlight_label' => 'Combo hot',
                    'highlight_text' => 'Tai nghe, đồng hồ và phụ kiện giao nhanh trong ngày',
                    'card_title' => 'Gói mua sắm thông minh dễ chốt đơn',
                    'card_text' => 'Nội dung được thiết lập sẵn để support giao diện trang chủ và tư vấn combo sản phẩm.',
                    'image_url' => 'https://placehold.co/1600x900/7C2D12/FFFFFF/png?text=Smart+Accessories',
                ],
            ],
            'home_banners' => [
                [
                    'eyebrow' => 'Trả góp 0%',
                    'title' => 'Mua trước, thanh toán linh hoạt',
                    'url' => '/checkout',
                    'image_url' => 'https://placehold.co/1200x600/F97316/FFFFFF/png?text=Tra+gop+0%25',
                ],
                [
                    'eyebrow' => 'Thu cũ đổi mới',
                    'title' => 'Lên đời nhanh, trợ giá minh bạch',
                    'url' => '/search?s=thu+cu+doi+moi',
                    'image_url' => 'https://placehold.co/1200x600/1D4ED8/FFFFFF/png?text=Thu+cu+doi+moi',
                ],
            ],
            'category_banners' => [
                [
                    'eyebrow' => 'Pre-order now',
                    'title' => 'Flagship mới và nhiều ưu đãi đặt trước',
                    'url' => '/search?s=flagship',
                    'image_url' => 'https://placehold.co/1200x600/111827/FFFFFF/png?text=Flagship+Pre-order',
                ],
                [
                    'eyebrow' => 'Store Offer',
                    'title' => 'Mua iPhone, MacBook và phụ kiện với trả góp 0%',
                    'url' => '/checkout',
                    'image_url' => 'https://placehold.co/1200x600/EA580C/FFFFFF/png?text=Tra+gop+0%25',
                ],
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
