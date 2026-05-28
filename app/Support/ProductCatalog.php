<?php

namespace App\Support;

use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\ProductVariant;
use Illuminate\Support\Collection;
use Throwable;

class ProductCatalog
{
    public function heroSlides(): array
    {
        return app(SiteSettings::class)->group('hero_slides', [
            [
                'eyebrow' => 'Apple cao cấp',
                'title' => 'iPhone 16 Series giá tốt, lên đời nhanh tại Tech One.',
                'description' => 'Tập trung vào nhóm máy cao cấp, trợ giá thu cũ đổi mới và quà tặng phụ kiện cho nhu cầu nâng cấp mỗi ngày.',
                'primary_label' => 'Mua iPhone ngay',
                'primary_url' => route('search', ['q' => 'iphone 16']),
                'secondary_label' => 'Xem điện thoại',
                'secondary_url' => route('categories.show', ['path' => 'dien-thoai']),
                'highlight_label' => 'Ưu đãi nổi bật',
                'highlight_text' => 'Giao nhanh 2 giờ nội thành',
                'card_title' => 'Bộ sưu tập iPhone chính hãng',
                'card_text' => 'Nhiều phiên bản màu, hỗ trợ trả góp linh hoạt và giao máy nhanh trong ngày.',
                'image_url' => null,
            ],
            [
                'eyebrow' => 'Macbook M4',
                'title' => 'Laptop cho học tập và sáng tạo với hiệu năng ổn định.',
                'description' => 'Phù hợp cho sinh viên, dân văn phòng và creator với cấu hình M4, RAM 16GB, SSD tốc độ cao và sẵn hàng.',
                'primary_label' => 'Chọn MacBook',
                'primary_url' => route('search', ['q' => 'macbook m4']),
                'secondary_label' => 'Xem laptop',
                'secondary_url' => route('categories.show', ['path' => 'laptop']),
                'highlight_label' => 'Quà tặng thêm',
                'highlight_text' => 'Tặng túi chống sốc và phần mềm văn phòng',
                'card_title' => 'MacBook Air và Pro thế hệ mới',
                'card_text' => 'Thiết kế mỏng nhẹ, pin bền và phù hợp cho cả công việc lẫn giải trí dài giờ.',
                'image_url' => null,
            ],
            [
                'eyebrow' => 'Nhà thông minh',
                'title' => 'Thiết bị nhà thông minh đang có nhiều ưu đãi để chọn.',
                'description' => 'Robot hút bụi, camera AI và hệ sinh thái smarthome được gom thành nhóm sản phẩm nổi bật ngay trên trang chủ.',
                'primary_label' => 'Khám phá smarthome',
                'primary_url' => route('categories.show', ['path' => 'nha-thong-minh']),
                'secondary_label' => 'Xem khuyến mãi',
                'secondary_url' => route('home').'#khuyen-mai',
                'highlight_label' => 'An tâm sử dụng',
                'highlight_text' => 'Bảo hành chính hãng toàn quốc',
                'card_title' => 'Giải pháp gọn cho căn hộ hiện đại',
                'card_text' => 'Tự vệ sinh, an ninh đến tự động hóa cơ bản, mọi thứ được gom trong một cụm hiển thị dễ hiểu.',
                'image_url' => null,
            ],
        ]);
    }

    public function homeBanners(): array
    {
        return app(SiteSettings::class)->group('home_banners', [
            [
                'eyebrow' => 'Trả góp 0%',
                'title' => 'Mua trước, thanh toán linh hoạt',
                'url' => route('checkout.index'),
                'image_url' => null,
            ],
            [
                'eyebrow' => 'Thu cũ đổi mới',
                'title' => 'Lên đời nhanh, trợ giá minh bạch',
                'url' => route('search', ['q' => 'thu cu doi moi']),
                'image_url' => null,
            ],
        ]);
    }

    public function categoryBanners(): array
    {
        return app(SiteSettings::class)->group('category_banners', [
            [
                'eyebrow' => 'Pre-order now',
                'title' => 'Flagship moi va nhieu uu dai dat truoc',
                'url' => route('search', ['q' => 'flagship']),
                'image_url' => null,
            ],
            [
                'eyebrow' => 'TechOne Special Offer',
                'title' => 'Mua iPhone, MacBook va phu kien voi tra gop 0%',
                'url' => route('checkout.index'),
                'image_url' => null,
            ],
        ]);
    }

    public function featuredCategories(): array
    {
        try {
            if (class_exists(\App\Models\ProductCategory::class)) {
                $categories = \App\Models\ProductCategory::where('is_active', true)
                    ->whereNotNull('icon')
                    ->orderBy('order')
                    ->take(6)
                    ->get();
                if ($categories->count() > 0) {
                    return $categories->map(fn($cat) => [
                        'name' => $cat->name,
                        'slug' => $cat->slug,
                        'icon' => strtoupper(substr($cat->icon, 0, 2)),
                        'note' => $cat->description ?? 'Đầy đủ phiên bản chính hãng',
                    ])->all();
                }
            }
        } catch (\Exception $e) {
            // Fallback
        }

        return [
            ['name' => 'iPhone', 'slug' => 'iphone', 'icon' => 'IP', 'note' => 'Các phiên bản 17, 16, 15'],
            ['name' => 'Macbook', 'slug' => 'mac', 'icon' => 'MB', 'note' => 'Air và Pro M4'],
            ['name' => 'iPad', 'slug' => 'ipad', 'icon' => 'PD', 'note' => 'Pro, Air, Mini'],
            ['name' => 'Watch', 'slug' => 'watch', 'icon' => 'WT', 'note' => 'Ultra, Series, SE'],
            ['name' => 'Âm thanh', 'slug' => 'am-thanh', 'icon' => 'AU', 'note' => 'AirPods, Loa, Tai nghe'],
            ['name' => 'Nhà thông minh', 'slug' => 'nha-thong-minh', 'icon' => 'SM', 'note' => 'Robot, Camera, TV'],
        ];
    }

    public function navCategories(): array
    {
        try {
            if (class_exists(\App\Models\ProductCategory::class)) {
                $categories = \App\Models\ProductCategory::where('show_in_nav', true)
                    ->where('is_active', true)
                    ->orderBy('order')
                    ->get();
                if ($categories->count() > 0) {
                    return $categories->all();
                }
            }
        } catch (\Exception $e) {
            // Fallback
        }

        return array_map(fn($name) => (object)[
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
        ], [
            'Apple',
            'Điện thoại',
            'Máy cũ',
            'Máy tính bảng',
            'Mac',
            'Đồng hồ thông minh',
            'Nhà thông minh',
            'Phụ kiện',
            'Âm thanh',
            'Khuyến mãi',
        ]);
    }

    public function serviceHighlights(): array
    {
        return [
            'Thu cũ đổi mới trợ giá tới 3.000.000đ',
            'Trả góp 0% cho sản phẩm giá trị cao',
            'Bảo hành minh bạch, hỗ trợ kỹ thuật nhanh',
            'Giao hàng nội thành trong ngày',
        ];
    }

    public function promotions(): array
    {
        return [
            [
                'title' => 'Thu cũ đổi mới lên đời MacBook',
                'subtitle' => 'Trợ giá đến 3.000.000đ cho dòng M4 mới',
                'date' => '01/05/2026 - 30/06/2026',
            ],
            [
                'title' => 'Trả góp 0% cho iPhone và iPad',
                'subtitle' => 'Duyệt nhanh, thủ tục gọn, ưu đãi phụ kiện đi kèm',
                'date' => 'Áp dụng mỗi ngày',
            ],
            [
                'title' => 'Mua combo nhà thông minh',
                'subtitle' => 'Tiết kiệm thêm đến 15% cho robot + camera AI',
                'date' => 'Số lượng có hạn',
            ],
        ];
    }

    public function productSections(): array
    {
        if ($this->hasDatabaseProducts()) {
            $products = Product::with(['brand', 'category.parent.parent', 'variants'])
                ->where('status', Product::STATUS_ACTIVE)
                ->latest()
                ->take(12)
                ->get();

            return [
                [
                    'title' => 'Sản phẩm mới cập nhật',
                    'subtitle' => '',
                    'badge' => 'Sản phẩm',
                    'products' => $products->map(fn (Product $product) => $this->dbProductCard($product))->all(),
                ],
            ];
        }

        return [
            [
                'title' => 'Nhóm sản phẩm được quan tâm nhiều nhất',
                'subtitle' => 'Các model đang được tìm kiếm và đặt mua nhiều nhất.',
                'badge' => 'Xu hướng',
                'products' => [
                    $this->productCard('iphone-16-pro-max-256gb'),
                    $this->productCard('samsung-galaxy-s25-ultra-512gb'),
                    $this->productCard('xiaomi-15-ultra-512gb'),
                    $this->productCard('iphone-15-128gb'),
                ],
            ],
            [
                'title' => 'Macbook bán chạy',
                'subtitle' => 'Dành cho học tập, văn phòng và sản xuất nội dung.',
                'badge' => 'Bán chạy',
                'products' => [
                    $this->productCard('macbook-air-m4-13-16gb-256gb'),
                    $this->productCard('macbook-pro-m4-14-16gb-512gb'),
                    $this->productCard('mac-mini-m4-16gb-256gb'),
                    $this->productCard('imac-m4-24-16gb-512gb'),
                ],
            ],
        ];
    }

    public function allProducts(): array
    {
        return [
            'iphone-16-pro-max-256gb' => [
                'slug' => 'iphone-16-pro-max-256gb',
                'name' => 'iPhone 16 Pro Max 256GB',
                'category' => 'Điện thoại',
                'brand' => 'Apple',
                'sku' => 'APL-IP16PM-256-NAT',
                'storage' => '256GB',
                'price' => '30.990.000d',
                'old_price' => '34.990.000d',
                'discount' => '-11%',
                'rating' => 5,
                'reviews_count' => 128,
                'tag' => 'Moi 100%',
                'color' => 'Titan Tu Nhien',
                'status' => 'Còn hàng tại 7 cửa hàng',
                'image' => 'https://via.placeholder.com/640x640/f8fafc/0f172a?text=iPhone+16+Pro+Max',
                'gallery' => [
                    'https://via.placeholder.com/960x960/f8fafc/0f172a?text=iPhone+16+Pro+Max+Front',
                    'https://via.placeholder.com/960x960/e2e8f0/0f172a?text=iPhone+16+Pro+Max+Back',
                    'https://via.placeholder.com/960x960/dbeafe/0f172a?text=iPhone+16+Pro+Max+Camera',
                    'https://via.placeholder.com/960x960/fae8ff/0f172a?text=iPhone+16+Pro+Max+In+Hand',
                ],
                'benefits' => ['Trả góp 0%', 'Thu cũ đổi mới trợ giá 2.500.000đ', 'Tặng ốp lưng cao cấp'],
                'highlights' => [
                    'Chip A18 Pro cho hiệu năng mạnh và tiết kiệm pin.',
                    'Màn hình 6.9 inch Super Retina XDR, độ sáng cao, hiển thị ngoài trời tốt.',
                    'Cụm camera zoom quang học linh hoạt, quay video 4K ProRes.',
                    'Khung titanium, độ bền cao, trọng lượng cân đối.',
                ],
                'variants' => [
                    ['label' => '256GB', 'active' => true],
                    ['label' => '512GB', 'active' => false],
                    ['label' => '1TB', 'active' => false],
                ],
                'colors' => [
                    ['label' => 'Titan Tu Nhien', 'hex' => '#9b9488', 'active' => true],
                    ['label' => 'Titan Den', 'hex' => '#3f4348', 'active' => false],
                    ['label' => 'Titan Trang', 'hex' => '#d6d3d1', 'active' => false],
                    ['label' => 'Titan Sa Mac', 'hex' => '#bba38c', 'active' => false],
                ],
                'technical_specs' => [
                    ['label' => 'Màn hình', 'value' => '6.9 inch Super Retina XDR OLED, 120Hz'],
                    ['label' => 'Chip', 'value' => 'Apple A18 Pro'],
                    ['label' => 'RAM', 'value' => '8GB'],
                    ['label' => 'Bộ nhớ', 'value' => '256GB NVMe'],
                    ['label' => 'Camera sau', 'value' => '48MP + 48MP + 12MP, zoom quang 5x'],
                    ['label' => 'Camera trước', 'value' => '12MP TrueDepth'],
                    ['label' => 'Pin', 'value' => '4676mAh, sạc nhanh USB-C 45W'],
                    ['label' => 'Kết nối', 'value' => '5G, Wi-Fi 7, Bluetooth 5.4, NFC'],
                    ['label' => 'Hệ điều hành', 'value' => 'iOS 26'],
                    ['label' => 'Chống nước', 'value' => 'IP68'],
                ],
                'in_the_box' => ['Thân máy iPhone 16 Pro Max', 'Cáp USB-C', 'Tài liệu hướng dẫn', 'Que lấy SIM'],
                'description_sections' => [
                    [
                        'title' => 'Ngoại hình cao cấp và cảm giác cầm nắm chắc tay',
                        'content' => [
                            'Khung titanium giúp máy nhẹ hơn nhưng vẫn giữ được độ cứng cấp cần thiết cho dòng flagship.',
                            'Cạnh viền được bo tròn nhẹ, bố cục camera sau lớn nhưng cân đối, phù hợp với nhóm người dùng muốn một mẫu máy sáng và bền.',
                        ],
                    ],
                    [
                        'title' => 'Màn hình lớn, độ sáng cao, tối ưu cho giải trí',
                        'content' => [
                            'Tấm nền OLED 120Hz mang lại chuyển động mượt, khả năng hiển thị HDR tốt và màu sắc nở nhưng không gắt.',
                            'Kích thước lớn phù hợp cho xem phim, chơi game và xử lý công việc trên một thiết bị di động.',
                        ],
                    ],
                    [
                        'title' => 'Cụm camera đa dụng cho cả chụp nhanh và quay video',
                        'content' => [
                            'Camera chính 48MP kết hợp xử lý hình ảnh tốt giúp ảnh trong, sắc nét và xử lý đa tốc độ cao.',
                            'Ống kính zoom 5x đặc biệt hữu ích cho chụp sân khấu, du lịch và quay video ở khoảng cách xa.',
                        ],
                    ],
                ],
            ],
            'samsung-galaxy-s25-ultra-512gb' => [
                'slug' => 'samsung-galaxy-s25-ultra-512gb',
                'name' => 'Samsung Galaxy S25 Ultra 512GB',
                'category' => 'Điện thoại',
                'brand' => 'Samsung',
                'sku' => 'SMS-S25U-512-TI',
                'storage' => '512GB',
                'price' => '27.490.000d',
                'old_price' => '31.490.000d',
                'discount' => '-13%',
                'rating' => 4,
                'reviews_count' => 76,
                'tag' => 'Bảo hành 12 tháng',
                'color' => 'Titan Xam',
                'status' => 'Còn hàng tại 5 cửa hàng',
                'image' => 'https://via.placeholder.com/640x640/f5f3ff/1f2937?text=Galaxy+S25+Ultra',
                'gallery' => [
                    'https://via.placeholder.com/960x960/f5f3ff/1f2937?text=Galaxy+S25+Ultra+Front',
                    'https://via.placeholder.com/960x960/e9d5ff/1f2937?text=Galaxy+S25+Ultra+Back',
                    'https://via.placeholder.com/960x960/ede9fe/1f2937?text=Galaxy+S25+Ultra+Camera',
                ],
                'benefits' => ['Quà tặng sạc nhanh', 'Gói rời vỏ màn hình', 'Hỗ trợ đổi máy trong 7 ngày'],
                'highlights' => [
                    'Bút S Pen tích hợp cho ghi chú và thao tác nhanh.',
                    'Màn hình AMOLED lớn, phù hợp xử lý công việc và giải trí.',
                    'Camera zoom xa linh hoạt, chất lượng ảnh ổn định.',
                ],
                'variants' => [
                    ['label' => '256GB', 'active' => false],
                    ['label' => '512GB', 'active' => true],
                    ['label' => '1TB', 'active' => false],
                ],
                'colors' => [
                    ['label' => 'Titan Xam', 'hex' => '#6b7280', 'active' => true],
                    ['label' => 'Titan Den', 'hex' => '#1f2937', 'active' => false],
                    ['label' => 'Titan Bac', 'hex' => '#d1d5db', 'active' => false],
                ],
                'technical_specs' => [
                    ['label' => 'Màn hình', 'value' => '6.8 inch Dynamic AMOLED 2X, 120Hz'],
                    ['label' => 'Chip', 'value' => 'Snapdragon 8 Elite for Galaxy'],
                    ['label' => 'RAM', 'value' => '12GB'],
                    ['label' => 'Bộ nhớ', 'value' => '512GB UFS 4.0'],
                    ['label' => 'Camera sau', 'value' => '200MP + 50MP + 50MP + 12MP'],
                    ['label' => 'Pin', 'value' => '5000mAh, sạc nhanh 45W'],
                    ['label' => 'Hệ điều hành', 'value' => 'One UI 8'],
                    ['label' => 'Tính năng đặc biệt', 'value' => 'S Pen, Samsung DeX'],
                ],
                'in_the_box' => ['Thân máy Galaxy S25 Ultra', 'Cáp USB-C', 'Bút S Pen tích hợp', 'Tài liệu hướng dẫn'],
                'description_sections' => [
                    [
                        'title' => 'Flagship Android hướng đến nhóm người dùng nặng',
                        'content' => [
                            'Galaxy S25 Ultra phù hợp cho người cần một chiếc máy có camera đã dùng, pin tốt và bộ công cụ phần mềm phục vụ công việc.',
                            'Bút S Pen tiếp tục là điểm khác biệt rõ nhất cho nhu cầu ghi chú, vẽ phác thảo và ký tài liệu nhanh.',
                        ],
                    ],
                ],
            ],
            'xiaomi-15-ultra-512gb' => [
                'slug' => 'xiaomi-15-ultra-512gb',
                'name' => 'Xiaomi 15 Ultra 16GB 512GB',
                'category' => 'Điện thoại',
                'brand' => 'Xiaomi',
                'sku' => 'XMI-15U-512-BLK',
                'storage' => '512GB',
                'price' => '22.790.000d',
                'old_price' => '25.790.000d',
                'discount' => '-12%',
                'rating' => 4,
                'reviews_count' => 43,
                'tag' => 'Camera dinh',
                'color' => 'Den',
                'status' => 'Còn hàng online',
                'image' => 'https://via.placeholder.com/640x640/ecfeff/0f172a?text=Xiaomi+15+Ultra',
                'gallery' => [
                    'https://via.placeholder.com/960x960/ecfeff/0f172a?text=Xiaomi+15+Ultra+Front',
                    'https://via.placeholder.com/960x960/cffafe/0f172a?text=Xiaomi+15+Ultra+Back',
                    'https://via.placeholder.com/960x960/e0f2fe/0f172a?text=Xiaomi+15+Ultra+Camera',
                ],
                'benefits' => ['Tặng tai nghe bluetooth', 'Hỗ trợ giao nhanh', 'Giảm thêm khi thanh toán online'],
                'highlights' => [
                    'Hệ thống camera dòng thương hiệu Leica cho mức độ chi tiết cao.',
                    'RAM 16GB phù hợp đa nhiệm nặng và quay phim 4K.',
                ],
                'variants' => [
                    ['label' => '256GB', 'active' => false],
                    ['label' => '512GB', 'active' => true],
                ],
                'colors' => [
                    ['label' => 'Den', 'hex' => '#111827', 'active' => true],
                    ['label' => 'Bac', 'hex' => '#94a3b8', 'active' => false],
                ],
                'technical_specs' => [
                    ['label' => 'Màn hình', 'value' => '6.73 inch AMOLED 120Hz'],
                    ['label' => 'Chip', 'value' => 'Snapdragon 8 Elite'],
                    ['label' => 'RAM', 'value' => '16GB'],
                    ['label' => 'Bộ nhớ', 'value' => '512GB UFS 4.0'],
                ],
                'in_the_box' => ['Thân máy Xiaomi 15 Ultra', 'Cáp USB-C', 'Ốp lưng', 'Tài liệu hướng dẫn'],
                'description_sections' => [
                    [
                        'title' => 'Chọn lựa cho người mê chụp ảnh bằng điện thoại',
                        'content' => [
                            'Cụm camera lớn là điểm nhấn mạnh về nhận diện và cũng tạo giá trị sử dụng rõ ràng cho nhu cầu chụp du lịch, street life và quay video.',
                        ],
                    ],
                ],
            ],
            'iphone-15-128gb' => [
                'slug' => 'iphone-15-128gb',
                'name' => 'iPhone 15 128GB',
                'category' => 'Điện thoại',
                'brand' => 'Apple',
                'sku' => 'APL-IP15-128-BLU',
                'storage' => '128GB',
                'price' => '17.390.000d',
                'old_price' => '19.990.000d',
                'discount' => '-13%',
                'rating' => 5,
                'reviews_count' => 204,
                'tag' => 'Gia tot',
                'color' => 'Xanh',
                'status' => 'Còn hàng tại 8 cửa hàng',
                'image' => 'https://via.placeholder.com/640x640/eff6ff/0f172a?text=iPhone+15',
                'gallery' => [
                    'https://via.placeholder.com/960x960/eff6ff/0f172a?text=iPhone+15+Front',
                    'https://via.placeholder.com/960x960/dbeafe/0f172a?text=iPhone+15+Back',
                ],
                'benefits' => ['Tặng cáp sạc nhanh', 'Bảo hành 1 đổi 1', 'Hỗ trợ setup máy mới'],
                'highlights' => [
                    'Mẫu dễ tiếp cận cho người cần iPhone ổn định, dễ dùng và đẹp.',
                ],
                'variants' => [
                    ['label' => '128GB', 'active' => true],
                    ['label' => '256GB', 'active' => false],
                ],
                'colors' => [
                    ['label' => 'Xanh', 'hex' => '#60a5fa', 'active' => true],
                    ['label' => 'Hong', 'hex' => '#f9a8d4', 'active' => false],
                    ['label' => 'Den', 'hex' => '#111827', 'active' => false],
                ],
                'technical_specs' => [
                    ['label' => 'Màn hình', 'value' => '6.1 inch Super Retina XDR'],
                    ['label' => 'Chip', 'value' => 'Apple A16 Bionic'],
                    ['label' => 'RAM', 'value' => '6GB'],
                    ['label' => 'Bộ nhớ', 'value' => '128GB'],
                ],
                'in_the_box' => ['Thân máy iPhone 15', 'Cáp USB-C', 'Tài liệu hướng dẫn'],
                'description_sections' => [
                    [
                        'title' => 'iPhone dễ mua nhất trong nhóm giá tầm trung cao',
                        'content' => [
                            'Máy phù hợp cho người chuyển từ Android sang iPhone hoặc cần một thiết bị nhỏ gọn, giao diện ổn định và chụp ảnh tốt.',
                        ],
                    ],
                ],
            ],
            'macbook-air-m4-13-16gb-256gb' => [
                'slug' => 'macbook-air-m4-13-16gb-256gb',
                'name' => 'MacBook Air M4 13 inch 16GB 256GB',
                'category' => 'Mac',
                'brand' => 'Apple',
                'sku' => 'APL-MBA-M4-13-16-256',
                'storage' => '16GB / 256GB',
                'price' => '26.990.000d',
                'old_price' => '28.990.000d',
                'discount' => '-7%',
                'rating' => 5,
                'reviews_count' => 31,
                'tag' => 'Mong nhe',
                'color' => 'Midnight',
                'status' => 'Còn hàng tại 4 cửa hàng',
                'image' => 'https://via.placeholder.com/640x640/fef3c7/0f172a?text=MacBook+Air+M4',
                'gallery' => [
                    'https://via.placeholder.com/960x960/fef3c7/0f172a?text=MacBook+Air+Open',
                    'https://via.placeholder.com/960x960/fde68a/0f172a?text=MacBook+Air+Side',
                    'https://via.placeholder.com/960x960/fff7ed/0f172a?text=MacBook+Air+Keyboard',
                ],
                'benefits' => ['Tặng túi và chuột', 'Bảo hành pin 12 tháng', 'Hỗ trợ trả góp 0%'],
                'highlights' => [
                    'Thiết kế mỏng nhẹ, phù hợp học tập và công việc di động.',
                    'Chip M4 cho hiệu năng / nhiệt độ rất cân đối trong tầm giá.',
                ],
                'variants' => [
                    ['label' => '16GB / 256GB', 'active' => true],
                    ['label' => '16GB / 512GB', 'active' => false],
                    ['label' => '24GB / 512GB', 'active' => false],
                ],
                'colors' => [
                    ['label' => 'Midnight', 'hex' => '#1e293b', 'active' => true],
                    ['label' => 'Bac', 'hex' => '#cbd5e1', 'active' => false],
                    ['label' => 'Starlight', 'hex' => '#e7e5d4', 'active' => false],
                ],
                'technical_specs' => [
                    ['label' => 'Màn hình', 'value' => '13.6 inch Liquid Retina'],
                    ['label' => 'Chip', 'value' => 'Apple M4 10-core CPU / 10-core GPU'],
                    ['label' => 'RAM', 'value' => '16GB Unified Memory'],
                    ['label' => 'SSD', 'value' => '256GB'],
                    ['label' => 'Pin', 'value' => 'Lên đến 18 giờ xem video'],
                    ['label' => 'Kết nối', 'value' => 'MagSafe 3, 2 x Thunderbolt / USB 4'],
                    ['label' => 'Cân nặng', 'value' => '1.24kg'],
                ],
                'in_the_box' => ['MacBook Air M4', 'Cáp MagSafe 3', 'Củ sạc USB-C', 'Tài liệu hướng dẫn'],
                'description_sections' => [
                    [
                        'title' => 'Cấu hình cân đối cho học tập, văn phòng và creator cơ bản',
                        'content' => [
                            'MacBook Air M4 là lựa chọn hợp lý cho người cần máy đẹp, pin dài và hệ điều hành ổn định để làm việc hàng ngày.',
                            'Bản RAM 16GB giúp giải quyết tốt hơn nhu cầu mở nhiều tab, dùng Photoshop cơ bản và xử lý video ngắn.',
                        ],
                    ],
                    [
                        'title' => 'Trải nghiệm nhập liệu và hiển thị dễ chịu trong thời gian dài',
                        'content' => [
                            'Bàn phím và trackpad vẫn là những điểm mạnh để giúp nhóm người dùng học tập, viết tài liệu và thao tác chính xác.',
                            'Màn hình Liquid Retina sắc nét, màu sắc dễ chịu, phù hợp cho xem nội dung và làm việc văn phòng.',
                        ],
                    ],
                ],
            ],
            'macbook-pro-m4-14-16gb-512gb' => [
                'slug' => 'macbook-pro-m4-14-16gb-512gb',
                'name' => 'MacBook Pro M4 14 inch 16GB 512GB',
                'category' => 'Mac',
                'brand' => 'Apple',
                'sku' => 'APL-MBP-M4-14-16-512',
                'storage' => '16GB / 512GB',
                'price' => '39.490.000d',
                'old_price' => '42.990.000d',
                'discount' => '-8%',
                'rating' => 5,
                'reviews_count' => 22,
                'tag' => 'Lua chon Pro',
                'color' => 'Den Space',
                'status' => 'Còn hàng đặt trước',
                'image' => 'https://via.placeholder.com/640x640/fae8ff/0f172a?text=MacBook+Pro+M4',
                'gallery' => [
                    'https://via.placeholder.com/960x960/fae8ff/0f172a?text=MacBook+Pro+Open',
                    'https://via.placeholder.com/960x960/f5d0fe/0f172a?text=MacBook+Pro+Display',
                ],
                'benefits' => ['Gói Office 365', 'Tặng hub chuyển đổi', 'Hỗ trợ đồng bộ dữ liệu'],
                'highlights' => ['Màn hình XDR đẹp, độ sáng cao.', 'Phù hợp editor, designer và developer cần máy bền bỉ.'],
                'variants' => [
                    ['label' => '16GB / 512GB', 'active' => true],
                    ['label' => '24GB / 1TB', 'active' => false],
                ],
                'colors' => [
                    ['label' => 'Den Space', 'hex' => '#111827', 'active' => true],
                    ['label' => 'Bac', 'hex' => '#d1d5db', 'active' => false],
                ],
                'technical_specs' => [
                    ['label' => 'Màn hình', 'value' => '14.2 inch Liquid Retina XDR, ProMotion'],
                    ['label' => 'Chip', 'value' => 'Apple M4 Pro'],
                    ['label' => 'RAM', 'value' => '16GB Unified Memory'],
                    ['label' => 'SSD', 'value' => '512GB'],
                ],
                'in_the_box' => ['MacBook Pro M4', 'Cáp MagSafe 3', 'Củ sạc USB-C 70W'],
                'description_sections' => [
                    [
                        'title' => 'Lựa chọn hợp lý cho nhóm chuyên nghiệp cần hiệu năng cao hơn',
                        'content' => [
                            'Dòng Pro phù hợp người cần render nhanh, code project lớn hoặc làm việc với file ảnh/video dung lượng lớn hơn so với dòng Air.',
                        ],
                    ],
                ],
            ],
            'mac-mini-m4-16gb-256gb' => [
                'slug' => 'mac-mini-m4-16gb-256gb',
                'name' => 'Mac mini M4 16GB 256GB',
                'category' => 'Mac',
                'brand' => 'Apple',
                'sku' => 'APL-MMINI-M4-16-256',
                'storage' => '16GB / 256GB',
                'price' => '15.690.000d',
                'old_price' => '17.490.000d',
                'discount' => '-10%',
                'rating' => 4,
                'reviews_count' => 17,
                'tag' => 'Desktop nho gon',
                'color' => 'Bac',
                'status' => 'Còn hàng online',
                'image' => 'https://via.placeholder.com/640x640/e0f2fe/0f172a?text=Mac+mini+M4',
                'gallery' => [
                    'https://via.placeholder.com/960x960/e0f2fe/0f172a?text=Mac+mini+Front',
                    'https://via.placeholder.com/960x960/bae6fd/0f172a?text=Mac+mini+Back',
                ],
                'benefits' => ['Tặng bộ phím không dây', 'Lưu kho và giao nhanh', 'Hỗ trợ lắp đặt tại nhà'],
                'highlights' => ['Giải pháp desktop macOS chi phí hợp lý.', 'Phù hợp setup bàn làm việc gọn gàng.'],
                'variants' => [
                    ['label' => '16GB / 256GB', 'active' => true],
                    ['label' => '16GB / 512GB', 'active' => false],
                ],
                'colors' => [
                    ['label' => 'Bac', 'hex' => '#cbd5e1', 'active' => true],
                ],
                'technical_specs' => [
                    ['label' => 'Chip', 'value' => 'Apple M4'],
                    ['label' => 'RAM', 'value' => '16GB Unified Memory'],
                    ['label' => 'SSD', 'value' => '256GB'],
                    ['label' => 'Kết nối', 'value' => 'Thunderbolt, HDMI, Ethernet'],
                ],
                'in_the_box' => ['Mac mini M4', 'Dây nguồn'],
                'description_sections' => [
                    [
                        'title' => 'Desktop nhỏ gọn để nâng cấp từ Windows văn phòng',
                        'content' => [
                            'Nếu đã có sẵn màn hình, Mac mini là cách vào hệ sinh thái Apple với chi phí hợp lý nhất trong nhóm máy Mac mới.',
                        ],
                    ],
                ],
            ],
            'imac-m4-24-16gb-512gb' => [
                'slug' => 'imac-m4-24-16gb-512gb',
                'name' => 'iMac M4 24 inch 16GB 512GB',
                'category' => 'Mac',
                'brand' => 'Apple',
                'sku' => 'APL-IMAC-M4-24-16-512',
                'storage' => '16GB / 512GB',
                'price' => '36.990.000d',
                'old_price' => '39.990.000d',
                'discount' => '-7%',
                'rating' => 4,
                'reviews_count' => 11,
                'tag' => 'Tất cả trong một',
                'color' => 'Xanh',
                'status' => 'Còn hàng tại 2 cửa hàng',
                'image' => 'https://via.placeholder.com/640x640/ede9fe/0f172a?text=iMac+M4',
                'gallery' => [
                    'https://via.placeholder.com/960x960/ede9fe/0f172a?text=iMac+Front',
                    'https://via.placeholder.com/960x960/e9d5ff/0f172a?text=iMac+Desk+Setup',
                ],
                'benefits' => ['Tặng Magic Mouse', 'Bảo hành chính hãng', 'Hỗ trợ giao và setup'],
                'highlights' => ['Máy all-in-one gọn đẹp cho văn phòng cao cấp.', 'Màn hình lớn, âm thanh tốt, setup nhanh.'],
                'variants' => [
                    ['label' => '16GB / 512GB', 'active' => true],
                ],
                'colors' => [
                    ['label' => 'Xanh', 'hex' => '#60a5fa', 'active' => true],
                    ['label' => 'Xanh la', 'hex' => '#4ade80', 'active' => false],
                ],
                'technical_specs' => [
                    ['label' => 'Màn hình', 'value' => '24 inch 4.5K Retina'],
                    ['label' => 'Chip', 'value' => 'Apple M4'],
                    ['label' => 'RAM', 'value' => '16GB'],
                    ['label' => 'SSD', 'value' => '512GB'],
                ],
                'in_the_box' => ['iMac M4', 'Magic Keyboard', 'Magic Mouse', 'Dây nguồn'],
                'description_sections' => [
                    [
                        'title' => 'Máy tính bàn làm việc đẹp, gọn và dễ vận hành',
                        'content' => [
                            'iMac phù hợp showroom, văn phòng sáng tạo và nhóm người dùng ưu tiên một setup gọn gàng nhưng vẫn đẹp mắt.',
                        ],
                    ],
                ],
            ],
        ];
    }

    public function find(string $slug): ?array
    {
        try {
            $dbProduct = Product::with(['brand', 'category.parent.parent', 'variants', 'specifications'])
                ->where('slug', $slug)
                ->where('status', '!=', Product::STATUS_DRAFT)
                ->first();

            if ($dbProduct) {
                return $this->dbProductDetail($dbProduct);
            }
        } catch (Throwable $exception) {
            // Fallback to mock catalog when product tables are unavailable, e.g. in lightweight tests.
        }

        $product = $this->allProducts()[$slug] ?? null;

        if (! $product) {
            return null;
        }

        return [
            ...$product,
            'image' => $this->sampleImage(),
            'gallery' => $this->sampleGallery(),
        ];
    }

    public function related(string $slug, int $limit = 4): array
    {
        try {
            $dbProduct = Product::with('category')
                ->where('slug', $slug)
                ->where('status', '!=', Product::STATUS_DRAFT)
                ->first();

            if ($dbProduct) {
                return Product::with(['brand', 'category.parent.parent', 'variants'])
                    ->where('status', Product::STATUS_ACTIVE)
                    ->where('id', '!=', $dbProduct->id)
                    ->when($dbProduct->product_category_id, fn ($query) => $query->where('product_category_id', $dbProduct->product_category_id))
                    ->take($limit)
                    ->get()
                    ->map(fn (Product $product) => $this->dbProductCard($product))
                    ->all();
            }
        } catch (Throwable $exception) {
            // Ignore and continue with mock catalog fallback.
        }

        $currentProduct = $this->find($slug);

        if (! $currentProduct) {
            return [];
        }

        return collect($this->allProducts())
            ->reject(fn (array $product) => $product['slug'] === $slug)
            ->filter(fn (array $product) => $product['category'] === $currentProduct['category'])
            ->take($limit)
            ->map(fn (array $product) => $this->productCard($product['slug']))
            ->values()
            ->all();
    }

    public function taxonomyTree(): array
    {
        try {
            if (class_exists(\App\Models\ProductCategory::class)) {
                $roots = \App\Models\ProductCategory::with('allChildren')
                    ->whereNull('parent_id')
                    ->where('is_active', true)
                    ->orderBy('order')
                    ->get();

                if ($roots->count() > 0) {
                    $buildTree = function ($categories) use (&$buildTree) {
                        $tree = [];
                        foreach ($categories as $cat) {
                            if (!$cat->is_active) continue;
                            $node = [
                                'slug' => $cat->slug,
                                'label' => $cat->name,
                            ];
                            if ($cat->allChildren && $cat->allChildren->count() > 0) {
                                $node['children'] = $buildTree($cat->allChildren);
                            }
                            $tree[] = $node;
                        }
                        return $tree;
                    };

                    return $buildTree($roots);
                }
            }
        } catch (\Exception $e) {
            // Fallback
        }

        return [
            [
                'slug' => 'apple',
                'label' => 'Apple',
                'children' => [
                    [
                        'slug' => 'iphone',
                        'label' => 'iPhone',
                        'children' => [
                            [
                                'slug' => 'iphone-16-series',
                                'label' => 'Dòng iPhone 16',
                                'children' => [
                                    ['slug' => 'iphone-16-pro-max', 'label' => 'iPhone 16 Pro Max'],
                                ],
                            ],
                            [
                                'slug' => 'iphone-15-series',
                                'label' => 'Dòng iPhone 15',
                                'children' => [
                                    ['slug' => 'iphone-15', 'label' => 'iPhone 15'],
                                    ['slug' => 'iphone-15-pro', 'label' => 'iPhone 15 Pro'],
                                ],
                            ],
                        ],
                    ],
                    [
                        'slug' => 'laptop',
                        'label' => 'Laptop',
                        'children' => [
                            [
                                'slug' => 'macbook-air-series',
                                'label' => 'Dòng MacBook Air',
                                'children' => [
                                    ['slug' => 'macbook-air-m4', 'label' => 'MacBook Air M4'],
                                ],
                            ],
                            [
                                'slug' => 'macbook-pro-series',
                                'label' => 'Dòng MacBook Pro',
                                'children' => [
                                    ['slug' => 'macbook-pro-m4', 'label' => 'MacBook Pro M4'],
                                ],
                            ],
                            [
                                'slug' => 'desktop-mac',
                                'label' => 'Máy để bàn',
                                'children' => [
                                    ['slug' => 'mac-mini', 'label' => 'Mac mini'],
                                    ['slug' => 'imac', 'label' => 'iMac'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'samsung',
                'label' => 'Samsung',
                'children' => [
                    [
                        'slug' => 'galaxy-s',
                        'label' => 'Galaxy S',
                        'children' => [
                            [
                                'slug' => 'galaxy-s25-series',
                                'label' => 'Dòng Galaxy S25',
                                'children' => [
                                    ['slug' => 'galaxy-s25-ultra', 'label' => 'Galaxy S25 Ultra'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'xiaomi',
                'label' => 'Xiaomi',
                'children' => [
                    [
                        'slug' => 'xiaomi-phone',
                        'label' => 'Dien thoai Xiaomi',
                        'children' => [
                            [
                                'slug' => 'xiaomi-15-series',
                                'label' => 'Dòng Xiaomi 15',
                                'children' => [
                                    ['slug' => 'xiaomi-15-ultra', 'label' => 'Xiaomi 15 Ultra'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function taxonomyIndex(): array
    {
        $index = [];

        $walk = function (array $nodes, array $trail = []) use (&$walk, &$index): void {
            foreach ($nodes as $node) {
                $currentTrail = [...$trail, ['slug' => $node['slug'], 'label' => $node['label']]];
                $path = implode('/', array_column($currentTrail, 'slug'));

                $index[$path] = [
                    'path' => $path,
                    'slug' => $node['slug'],
                    'label' => $node['label'],
                    'level' => count($currentTrail),
                    'breadcrumbs' => $currentTrail,
                ];

                if (! empty($node['children'])) {
                    $walk($node['children'], $currentTrail);
                }
            }
        };

        $walk($this->taxonomyTree());

        return $index;
    }

    public function listingProducts(): array
    {
        if ($this->hasDatabaseProducts()) {
            return Product::with(['brand', 'category.parent.parent', 'variants', 'specifications'])
                ->where('status', Product::STATUS_ACTIVE)
                ->latest()
                ->get()
                ->map(fn (Product $product) => $this->dbListingProduct($product))
                ->all();
        }

        return [
            $this->listingProduct('iphone-16-pro-max-256gb', 'dien-thoai/iphone-series/iphone-16-pro-max', 30990000),
            $this->listingProduct('iphone-15-128gb', 'dien-thoai/iphone-series/iphone-15', 17390000),
            $this->listingProduct('samsung-galaxy-s25-ultra-512gb', 'dien-thoai/galaxy-s-series/galaxy-s25-ultra', 27490000),
            $this->listingProduct('xiaomi-15-ultra-512gb', 'dien-thoai/xiaomi-series/xiaomi-15-ultra', 22790000),
            $this->listingProduct('macbook-air-m4-13-16gb-256gb', 'laptop/macbook-air-series/macbook-air-m4', 26990000),
            $this->listingProduct('macbook-pro-m4-14-16gb-512gb', 'laptop/macbook-pro-series/macbook-pro-m4', 39490000),
            $this->listingProduct('mac-mini-m4-16gb-256gb', 'laptop/desktop-mac/mac-mini', 15690000),
            $this->listingProduct('imac-m4-24-16gb-512gb', 'laptop/desktop-mac/imac', 36990000),
        ];
    }

    public function findTaxonomyPath(string $path): ?array
    {
        if ($path === '') {
            return [
                'path' => '',
                'slug' => '',
                'label' => 'Tất cả sản phẩm',
                'level' => 0,
                'breadcrumbs' => [],
            ];
        }

        $lastSegment = basename($path);

        // 1. Check if the path is a top-level brand slug first dynamically from Database
        try {
            if (class_exists(\App\Models\ProductBrand::class)) {
                $brand = \App\Models\ProductBrand::where('slug', $lastSegment)->first();
                if ($brand) {
                    return [
                        'path' => $brand->slug,
                        'slug' => $brand->slug,
                        'label' => 'Thương hiệu ' . $brand->name,
                        'level' => 1,
                        'breadcrumbs' => [
                            ['slug' => $brand->slug, 'label' => $brand->name]
                        ],
                        'is_brand' => true,
                    ];
                }
            }
        } catch (\Exception $e) {}

        // 2. Try standard taxonomy index first
        $node = $this->taxonomyIndex()[$path] ?? null;
        if ($node) {
            return $node;
        }

        // 3. Try to match by slug in taxonomyIndex (for flat URLs of categories)
        foreach ($this->taxonomyIndex() as $nodePath => $n) {
            if ($n['slug'] === $lastSegment) {
                return $n;
            }
        }

        return null;
    }

    public function childTaxonomyPaths(string $path = ''): array
    {
        $all = $this->taxonomyIndex();

        if ($path === '') {
            return array_values(array_filter($all, fn (array $node) => $node['level'] === 1));
        }

        $baseNode = $this->findTaxonomyPath($path);

        if (! $baseNode) {
            return [];
        }

        // If it is a brand page, there are no physical sub-taxonomy paths under it
        if (! empty($baseNode['is_brand'])) {
            return [];
        }

        return array_values(array_filter($all, function (array $node) use ($path, $baseNode): bool {
            if ($node['level'] !== $baseNode['level'] + 1) {
                return false;
            }

            return str_starts_with($node['path'], $path . '/');
        }));
    }

    public function productBreadcrumbs(string $slug): array
    {
        $dbProduct = Product::with('category.parent.parent')
            ->where('slug', $slug)
            ->where('status', '!=', Product::STATUS_DRAFT)
            ->first();

        if ($dbProduct) {
            return $this->categoryTrail($dbProduct->category)
                ->map(fn ($category) => [
                    'slug' => $category->slug,
                    'label' => $category->name,
                ])
                ->all();
        }

        $product = collect($this->listingProducts())->firstWhere('slug', $slug);

        if (! $product) {
            return [];
        }

        return $this->findTaxonomyPath($product['taxonomy_path'])['breadcrumbs'] ?? [];
    }

    private function productCard(string $slug): array
    {
        $product = $this->find($slug);

        return [
            'slug' => $product['slug'],
            'name' => $product['name'],
            'brand' => $product['brand'],
            'category' => $product['category'],
            'color' => $product['color'],
            'storage' => $product['storage'],
            'price' => $product['price'],
            'old_price' => $product['old_price'],
            'price_value' => (int) ($product['price_value'] ?? $this->parsePriceValue($product['price'] ?? null)),
            'discount' => $product['discount'],
            'rating' => $product['rating'],
            'reviews_count' => $product['reviews_count'],
            'tag' => $product['tag'],
            'release_label' => $this->releaseLabel($slug),
            'image' => $product['image'],
            'benefits' => $product['benefits'],
            'search_text' => implode(' ', array_map(fn($s) => ($s['label'] ?? '') . ' ' . ($s['value'] ?? ''), $product['technical_specs'] ?? [])) . ' ' . implode(' ', $product['highlights'] ?? []),
        ];
    }

    private function listingProduct(string $slug, string $taxonomyPath, int $priceValue): array
    {
        $product = $this->find($slug);
        $taxonomy = $this->findTaxonomyPath($taxonomyPath);
        $breadcrumbs = $taxonomy['breadcrumbs'] ?? [];

        return [
            ...$this->productCard($slug),
            'price_value' => $priceValue,
            'taxonomy_path' => $taxonomyPath,
            'brand_slug' => strtolower($product['brand'] ?? ''),
            'brand_label' => $product['brand'] ?? '',
            'line_slug' => $breadcrumbs[0]['slug'] ?? null, // dien-thoai / laptop
            'line_label' => $breadcrumbs[0]['label'] ?? null,
            'series_slug' => $breadcrumbs[1]['slug'] ?? null, // iphone-series / macbook-air-series
            'series_label' => $breadcrumbs[1]['label'] ?? null,
            'model_slug' => $breadcrumbs[2]['slug'] ?? null,
            'model_label' => $breadcrumbs[2]['label'] ?? $product['name'],
        ];
    }

    private function hasDatabaseProducts(): bool
    {
        try {
            return Product::where('status', Product::STATUS_ACTIVE)->exists();
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function dbProductCard(Product $product): array
    {
        $variant = $this->primaryVariant($product);
        $price = $this->variantPrice($variant);
        $oldPrice = $variant?->price_original ? (float) $variant->price_original : null;

        return [
            'slug' => $product->slug,
            'name' => $product->name,
            'brand' => $product->brand?->name ?? '',
            'category' => $product->category?->name ?? '',
            'color' => $variant?->color_name ?? '',
            'storage' => $variant?->storage ?? '',
            'price' => $this->formatPrice($price),
            'old_price' => $oldPrice && $oldPrice > $price ? $this->formatPrice($oldPrice) : null,
            'discount' => $this->discountLabel($oldPrice, $price),
            'rating' => 5,
            'reviews_count' => 0,
            'tag' => $product->is_preorder ? 'Đặt trước' : 'Mới 100%',
            'release_label' => optional($product->created_at)->format('m/Y') ?? '2026',
            'image' => $product->thumbnail ?: $this->sampleImage(),
            'benefits' => $product->highlights ?: ['Trả góp 0%', 'Bảo hành chính hãng', 'Hỗ trợ thu cũ đổi mới'],
            'stock' => $variant?->stock ?? 0,
        ];
    }

    private function dbProductDetail(Product $product): array
    {
        $card = $this->dbProductCard($product);
        $variant = $this->primaryVariant($product);
        $gallery = array_values(array_filter([
            ...($product->images ?: []),
            $product->thumbnail,
        ]));

        if (empty($gallery)) {
            $gallery = $this->sampleGallery();
        }

        $specs = $product->specifications
            ->map(fn (ProductSpecification $spec) => [
                'label' => $spec->name,
                'value' => $spec->value,
                'group' => $spec->group_name,
            ])
            ->filter(fn (array $spec) => filled($spec['label']) && filled($spec['value']))
            ->values()
            ->all();

        return [
            ...$card,
            'sku' => $variant?->sku ?? 'N/A',
            'status' => $product->is_preorder ? 'Đang nhận đặt trước' : ($variant && $variant->stock > 0 ? 'Còn hàng' : 'Hết hàng'),
            'gallery' => $gallery,
            'highlights' => $product->highlights ?: [$product->summary ?: 'Sản phẩm chính hãng, đầy đủ chính sách bảo hành.'],
            'variants' => $this->variantOptions($product),
            'colors' => $this->colorOptions($product),
            'variant_matrix' => $this->variantMatrix($product),
            'technical_specs' => ! empty($specs) ? $specs : [
                ['label' => 'Danh mục', 'value' => $product->category?->name ?? 'Đang cập nhật'],
                ['label' => 'Hãng sản xuất', 'value' => $product->brand?->name ?? 'Đang cập nhật'],
            ],
            'benefits' => $product->highlights ?: ['Trả góp 0%', 'Thu cũ đổi mới trợ giá', $product->warranty_policy ?: 'Bảo hành chính hãng'],
            'in_the_box' => ['Sản phẩm', 'Phụ kiện tiêu chuẩn', 'Phiếu bảo hành'],
            'description_html' => $product->description,
            'description_sections' => $this->descriptionSections($product),
        ];
    }

    private function dbListingProduct(Product $product): array
    {
        $trail = $this->categoryTrail($product->category);
        $breadcrumbs = $trail->map(fn ($category) => [
            'slug' => $category->slug,
            'label' => $category->name,
        ])->values();
        $variant = $this->primaryVariant($product);

        return [
            ...$this->dbProductCard($product),
            'price_value' => (int) $this->variantPrice($variant),
            'taxonomy_path' => $trail->pluck('slug')->implode('/'),
            'brand_slug' => $product->brand?->slug ?? '',
            'brand_label' => $product->brand?->name ?? '',
            'line_slug' => $breadcrumbs[0]['slug'] ?? null,
            'line_label' => $breadcrumbs[0]['label'] ?? null,
            'series_slug' => $breadcrumbs[1]['slug'] ?? null,
            'series_label' => $breadcrumbs[1]['label'] ?? null,
            'model_slug' => $breadcrumbs[2]['slug'] ?? null,
            'model_label' => $breadcrumbs[2]['label'] ?? $product->name,
            'search_text' => ($product->specifications ? $product->specifications->map(fn($s) => $s->name . ' ' . $s->value)->implode(' ') : '') . ' ' . ($product->highlights ? implode(' ', $product->highlights) : ''),
        ];
    }

    private function primaryVariant(Product $product): ?ProductVariant
    {
        $variants = $product->relationLoaded('variants') ? $product->variants : $product->variants()->get();

        return $variants
            ->sortBy(fn (ProductVariant $variant) => $variant->price_sale ?? $variant->price_original)
            ->first();
    }

    private function variantPrice(?ProductVariant $variant): float
    {
        if (! $variant) {
            return 0;
        }

        return (float) ($variant->price_sale ?: $variant->price_original);
    }

    private function variantOptions(Product $product): array
    {
        $primary = $this->primaryVariant($product);

        return $product->variants
            ->groupBy('storage')
            ->filter()
            ->map(function (Collection $variants, string $storage) use ($primary) {
                $cheapest = $variants->sortBy(fn (ProductVariant $variant) => $this->variantPrice($variant))->first();

                return [
                'label' => $storage,
                'active' => $storage === $primary?->storage,
                    'price' => $this->formatPrice($this->variantPrice($cheapest)),
                ];
            })
            ->values()
            ->all();
    }

    private function colorOptions(Product $product): array
    {
        $primary = $this->primaryVariant($product);

        return $product->variants
            ->filter(fn (ProductVariant $variant) => filled($variant->color_name))
            ->unique('color_name')
            ->values()
            ->map(fn (ProductVariant $variant) => [
                'label' => $variant->color_name,
                'hex' => $variant->color_code ?: '#e5e7eb',
                'active' => $variant->color_name === $primary?->color_name,
                'price' => $this->formatPrice($this->variantPrice($variant)),
            ])
            ->all();
    }

    private function variantMatrix(Product $product): array
    {
        $primary = $this->primaryVariant($product);

        return $product->variants
            ->values()
            ->map(fn (ProductVariant $variant) => [
                'sku' => $variant->sku,
                'storage' => $variant->storage,
                'color' => $variant->color_name,
                'color_hex' => $variant->color_code ?: '#e5e7eb',
                'price' => $this->formatPrice($this->variantPrice($variant)),
                'old_price' => (float) $variant->price_original > $this->variantPrice($variant) ? $this->formatPrice((float) $variant->price_original) : '',
                'discount' => $this->discountLabel((float) $variant->price_original, $this->variantPrice($variant)),
                'stock' => $variant->stock,
                'status' => $variant->stock > 0 ? 'Còn hàng' : 'Hết hàng',
                'active' => $variant->id === $primary?->id,
            ])
            ->all();
    }

    private function categoryTrail($category): Collection
    {
        $trail = collect();

        while ($category) {
            $trail->prepend($category);
            $category = $category->parent;
        }

        return $trail->values();
    }

    private function formatPrice(float|int|null $price): string
    {
        return number_format((float) $price, 0, ',', '.') . 'đ';
    }

    private function discountLabel(?float $oldPrice, float $price): string
    {
        if (! $oldPrice || $oldPrice <= $price || $price <= 0) {
            return '';
        }

        return '-' . round((($oldPrice - $price) / $oldPrice) * 100) . '%';
    }

    private function descriptionSections(Product $product): array
    {
        if (filled($product->description)) {
            return [
                [
                    'title' => 'Đánh giá chi tiết',
                    'content' => [strip_tags($product->description)],
                ],
            ];
        }

        return [
            [
                'title' => 'Tổng quan sản phẩm',
                'content' => [$product->summary ?: 'Thông tin chi tiết đang được cập nhật từ hệ thống quản trị.'],
            ],
        ];
    }

    private function releaseLabel(string $slug): string
    {
        return match ($slug) {
            'iphone-16-pro-max-256gb' => 'Sep 2025',
            'iphone-15-128gb' => 'Jan 2023',
            'samsung-galaxy-s25-ultra-512gb' => 'Jan 2026',
            'xiaomi-15-ultra-512gb' => 'Feb 2026',
            'macbook-air-m4-13-16gb-256gb' => 'Mar 2026',
            'macbook-pro-m4-14-16gb-512gb' => 'Nov 2025',
            'mac-mini-m4-16gb-256gb' => 'Oct 2025',
            'imac-m4-24-16gb-512gb' => 'Oct 2025',
            default => '2026',
        };
    }

    private function sampleImage(): string
    {
        return 'https://picsum.photos/seed/storedp-tech/960/720';
    }

    private function sampleGallery(): array
    {
        return [
            'https://picsum.photos/seed/storedp-tech-1/1200/900',
            'https://picsum.photos/seed/storedp-tech-2/1200/900',
            'https://picsum.photos/seed/storedp-tech-3/1200/900',
            'https://picsum.photos/seed/storedp-tech-4/1200/900',
        ];
    }

    private function parsePriceValue(?string $formattedPrice): int
    {
        if (! $formattedPrice) {
            return 0;
        }

        return (int) preg_replace('/[^\d]/', '', $formattedPrice);
    }
}
