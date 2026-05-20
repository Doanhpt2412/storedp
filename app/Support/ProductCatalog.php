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
        return [
            [
                'eyebrow' => 'Apple Flagship',
                'title' => 'iPhone 16 Series giam sau, tra gop 0% tai cua hang.',
                'description' => 'Tap trung vao nhom may cao cap, uu dai thu cu doi moi va qua tang phu kien cho nhu cau len doi nhanh.',
                'primary_cta' => 'Mua iPhone ngay',
                'secondary_cta' => 'Xem thu cu doi moi',
                'highlight' => 'Giao nhanh 2h noi thanh',
            ],
            [
                'eyebrow' => 'Macbook M4',
                'title' => 'Laptop cho cong viec sang tao, pin ben, mau dep, ton kho san.',
                'description' => 'Danh cho sinh vien, dan van phong va creator voi cau hinh M4, RAM 16GB va SSD toc do cao.',
                'primary_cta' => 'Chon Macbook',
                'secondary_cta' => 'So sanh cac phien ban',
                'highlight' => 'Tang goi Office va tui chong soc',
            ],
            [
                'eyebrow' => 'Smart Living',
                'title' => 'Robot hut bui, camera AI va thiet bi nha thong minh dang giam manh.',
                'description' => 'Mo rong trang chu theo dung nhom san pham hot cua chuoi ban le cong nghe hien dai.',
                'primary_cta' => 'Kham pha nha thong minh',
                'secondary_cta' => 'Xem deal hom nay',
                'highlight' => 'Bao hanh chinh hang toan quoc',
            ],
        ];
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
            ['name' => 'iPhone', 'slug' => 'iphone', 'icon' => 'IP', 'note' => '17, 16, 15 Series'],
            ['name' => 'Macbook', 'slug' => 'mac', 'icon' => 'MB', 'note' => 'Air va Pro M4'],
            ['name' => 'iPad', 'slug' => 'ipad', 'icon' => 'PD', 'note' => 'Pro, Air, Mini'],
            ['name' => 'Watch', 'slug' => 'watch', 'icon' => 'WT', 'note' => 'Ultra, Series, SE'],
            ['name' => 'Am thanh', 'slug' => 'am-thanh', 'icon' => 'AU', 'note' => 'AirPods, Loa, Tai nghe'],
            ['name' => 'Nha thong minh', 'slug' => 'nha-thong-minh', 'icon' => 'SM', 'note' => 'Robot, Camera, TV'],
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
            'Dien thoai',
            'May cu',
            'May tinh bang',
            'Mac',
            'Dong ho thong minh',
            'Nha thong minh',
            'Phu kien',
            'Am thanh',
            'Khuyen mai',
        ]);
    }

    public function serviceHighlights(): array
    {
        return [
            'Thu cu doi moi tro gia toi 3.000.000d',
            'Tra gop 0% cho san pham gia tri cao',
            'Bao hanh minh bach, ho tro ky thuat nhanh',
            'Giao hang noi thanh trong ngay',
        ];
    }

    public function promotions(): array
    {
        return [
            [
                'title' => 'Thu cu doi moi len doi MacBook',
                'subtitle' => 'Tro gia den 3.000.000d cho dong M4 moi',
                'date' => '01/05/2026 - 30/06/2026',
            ],
            [
                'title' => 'Tra gop 0% cho iPhone va iPad',
                'subtitle' => 'Duyet nhanh, thu tuc gon, uu dai phu kien di kem',
                'date' => 'Ap dung moi ngay',
            ],
            [
                'title' => 'Mua combo nha thong minh',
                'subtitle' => 'Tiet kiem them den 15% cho robot + camera AI',
                'date' => 'So luong co han',
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
                    'subtitle' => 'Dữ liệu đang được lấy trực tiếp từ module quản lý sản phẩm.',
                    'badge' => 'Database',
                    'products' => $products->map(fn (Product $product) => $this->dbProductCard($product))->all(),
                ],
            ];
        }

        return [
            [
                'title' => 'Dien thoai noi bat',
                'subtitle' => 'Cac model dang duoc tim kiem va dat mua nhieu nhat.',
                'badge' => 'Hot trend',
                'products' => [
                    $this->productCard('iphone-16-pro-max-256gb'),
                    $this->productCard('samsung-galaxy-s25-ultra-512gb'),
                    $this->productCard('xiaomi-15-ultra-512gb'),
                    $this->productCard('iphone-15-128gb'),
                ],
            ],
            [
                'title' => 'Macbook ban chay',
                'subtitle' => 'Danh cho hoc tap, van phong va san xuat noi dung.',
                'badge' => 'Best seller',
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
                'category' => 'Dien thoai',
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
                'status' => 'Con hang tai 7 cua hang',
                'image' => 'https://via.placeholder.com/640x640/f8fafc/0f172a?text=iPhone+16+Pro+Max',
                'gallery' => [
                    'https://via.placeholder.com/960x960/f8fafc/0f172a?text=iPhone+16+Pro+Max+Front',
                    'https://via.placeholder.com/960x960/e2e8f0/0f172a?text=iPhone+16+Pro+Max+Back',
                    'https://via.placeholder.com/960x960/dbeafe/0f172a?text=iPhone+16+Pro+Max+Camera',
                    'https://via.placeholder.com/960x960/fae8ff/0f172a?text=iPhone+16+Pro+Max+In+Hand',
                ],
                'benefits' => ['Tra gop 0%', 'Thu cu doi moi tro gia 2.500.000d', 'Tang op lung cao cap'],
                'highlights' => [
                    'Chip A18 Pro cho hieu nang manh va tiet kiem pin.',
                    'Man hinh 6.9 inch Super Retina XDR, do sang cao, hien thi ngoai troi tot.',
                    'Cum camera zoom quang hoc linh hoat, quay video 4K ProRes.',
                    'Khung titanium, do ben cao, trong luong can doi.',
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
                    ['label' => 'Man hinh', 'value' => '6.9 inch Super Retina XDR OLED, 120Hz'],
                    ['label' => 'Chip', 'value' => 'Apple A18 Pro'],
                    ['label' => 'RAM', 'value' => '8GB'],
                    ['label' => 'Bo nho', 'value' => '256GB NVMe'],
                    ['label' => 'Camera sau', 'value' => '48MP + 48MP + 12MP, zoom quang 5x'],
                    ['label' => 'Camera truoc', 'value' => '12MP TrueDepth'],
                    ['label' => 'Pin', 'value' => '4676mAh, sac nhanh USB-C 45W'],
                    ['label' => 'Ket noi', 'value' => '5G, Wi-Fi 7, Bluetooth 5.4, NFC'],
                    ['label' => 'He dieu hanh', 'value' => 'iOS 26'],
                    ['label' => 'Chong nuoc', 'value' => 'IP68'],
                ],
                'in_the_box' => ['Than may iPhone 16 Pro Max', 'Cap USB-C', 'Tai lieu huong dan', 'Que lay SIM'],
                'description_sections' => [
                    [
                        'title' => 'Ngoai hinh cao cap va cam giac cam nam chac tay',
                        'content' => [
                            'Khung titanium giup may nhe hon nhung van giu duoc do cung cap can thiet cho dong flagship.',
                            'Canh vien duoc bo tron nhe, bo cuc camera sau lon nhung can doi, phu hop voi nhom nguoi dung muon mot mau may sang va ben.',
                        ],
                    ],
                    [
                        'title' => 'Man hinh lon, do sang cao, toi uu cho giai tri',
                        'content' => [
                            'Tam nen OLED 120Hz mang lai chuyen dong muot, kha nang hien thi HDR tot va mau sac no nhung khong gay.',
                            'Kich thuoc lon phu hop cho xem phim, choi game va xu ly cong viec tren mot thiet bi di dong.',
                        ],
                    ],
                    [
                        'title' => 'Cum camera da dung cho ca chup nhanh va quay video',
                        'content' => [
                            'Camera chinh 48MP ket hop xu ly hinh anh tot giup anh trong, sac net va xu ly da toc do cao.',
                            'Ong kinh zoom 5x dac biet huu ich cho chup san khau, du lich va quay video o khoang cach xa.',
                        ],
                    ],
                ],
            ],
            'samsung-galaxy-s25-ultra-512gb' => [
                'slug' => 'samsung-galaxy-s25-ultra-512gb',
                'name' => 'Samsung Galaxy S25 Ultra 512GB',
                'category' => 'Dien thoai',
                'brand' => 'Samsung',
                'sku' => 'SMS-S25U-512-TI',
                'storage' => '512GB',
                'price' => '27.490.000d',
                'old_price' => '31.490.000d',
                'discount' => '-13%',
                'rating' => 4,
                'reviews_count' => 76,
                'tag' => 'Bao hanh 12 thang',
                'color' => 'Titan Gray',
                'status' => 'Con hang tai 5 cua hang',
                'image' => 'https://via.placeholder.com/640x640/f5f3ff/1f2937?text=Galaxy+S25+Ultra',
                'gallery' => [
                    'https://via.placeholder.com/960x960/f5f3ff/1f2937?text=Galaxy+S25+Ultra+Front',
                    'https://via.placeholder.com/960x960/e9d5ff/1f2937?text=Galaxy+S25+Ultra+Back',
                    'https://via.placeholder.com/960x960/ede9fe/1f2937?text=Galaxy+S25+Ultra+Camera',
                ],
                'benefits' => ['Qua tang sac nhanh', 'Goi roi vo man hinh', 'Ho tro doi may trong 7 ngay'],
                'highlights' => [
                    'But S Pen tich hop cho ghi chu va thao tac nhanh.',
                    'Man hinh AMOLED lon, phu hop xu ly cong viec va giai tri.',
                    'Camera zoom xa linh hoat, chat luong anh on dinh.',
                ],
                'variants' => [
                    ['label' => '256GB', 'active' => false],
                    ['label' => '512GB', 'active' => true],
                    ['label' => '1TB', 'active' => false],
                ],
                'colors' => [
                    ['label' => 'Titan Gray', 'hex' => '#6b7280', 'active' => true],
                    ['label' => 'Titan Black', 'hex' => '#1f2937', 'active' => false],
                    ['label' => 'Titan Silver', 'hex' => '#d1d5db', 'active' => false],
                ],
                'technical_specs' => [
                    ['label' => 'Man hinh', 'value' => '6.8 inch Dynamic AMOLED 2X, 120Hz'],
                    ['label' => 'Chip', 'value' => 'Snapdragon 8 Elite for Galaxy'],
                    ['label' => 'RAM', 'value' => '12GB'],
                    ['label' => 'Bo nho', 'value' => '512GB UFS 4.0'],
                    ['label' => 'Camera sau', 'value' => '200MP + 50MP + 50MP + 12MP'],
                    ['label' => 'Pin', 'value' => '5000mAh, sac nhanh 45W'],
                    ['label' => 'He dieu hanh', 'value' => 'One UI 8'],
                    ['label' => 'Tinh nang dac biet', 'value' => 'S Pen, Samsung DeX'],
                ],
                'in_the_box' => ['Than may Galaxy S25 Ultra', 'Cap USB-C', 'But S Pen tich hop', 'Tai lieu huong dan'],
                'description_sections' => [
                    [
                        'title' => 'Flagship Android huong den nhom nguoi dung nang',
                        'content' => [
                            'Galaxy S25 Ultra phu hop cho nguoi can mot chiec may co camera da dung, pin tot va bo cong cu phan mem phuc vu cong viec.',
                            'But S Pen tiep tuc la diem khac biet ro nhat cho nhu cau ghi chu, ve phac thao va ky tai lieu nhanh.',
                        ],
                    ],
                ],
            ],
            'xiaomi-15-ultra-512gb' => [
                'slug' => 'xiaomi-15-ultra-512gb',
                'name' => 'Xiaomi 15 Ultra 16GB 512GB',
                'category' => 'Dien thoai',
                'brand' => 'Xiaomi',
                'sku' => 'XMI-15U-512-BLK',
                'storage' => '512GB',
                'price' => '22.790.000d',
                'old_price' => '25.790.000d',
                'discount' => '-12%',
                'rating' => 4,
                'reviews_count' => 43,
                'tag' => 'Camera flagship',
                'color' => 'Black',
                'status' => 'Con hang online',
                'image' => 'https://via.placeholder.com/640x640/ecfeff/0f172a?text=Xiaomi+15+Ultra',
                'gallery' => [
                    'https://via.placeholder.com/960x960/ecfeff/0f172a?text=Xiaomi+15+Ultra+Front',
                    'https://via.placeholder.com/960x960/cffafe/0f172a?text=Xiaomi+15+Ultra+Back',
                    'https://via.placeholder.com/960x960/e0f2fe/0f172a?text=Xiaomi+15+Ultra+Camera',
                ],
                'benefits' => ['Tang tai nghe bluetooth', 'Ho tro giao nhanh', 'Giam them khi thanh toan online'],
                'highlights' => [
                    'He thong camera dong thuong hieu Leica cho muc do chi tiet cao.',
                    'RAM 16GB phu hop da nhiem nang va quay phim 4K.',
                ],
                'variants' => [
                    ['label' => '256GB', 'active' => false],
                    ['label' => '512GB', 'active' => true],
                ],
                'colors' => [
                    ['label' => 'Black', 'hex' => '#111827', 'active' => true],
                    ['label' => 'Silver', 'hex' => '#94a3b8', 'active' => false],
                ],
                'technical_specs' => [
                    ['label' => 'Man hinh', 'value' => '6.73 inch AMOLED 120Hz'],
                    ['label' => 'Chip', 'value' => 'Snapdragon 8 Elite'],
                    ['label' => 'RAM', 'value' => '16GB'],
                    ['label' => 'Bo nho', 'value' => '512GB UFS 4.0'],
                ],
                'in_the_box' => ['Than may Xiaomi 15 Ultra', 'Cap USB-C', 'Op lung', 'Tai lieu huong dan'],
                'description_sections' => [
                    [
                        'title' => 'Chon lua cho nguoi me chup anh bang dien thoai',
                        'content' => [
                            'Cum camera lon la diem nhan manh ve nhan dien va cung tao gia tri su dung ro rang cho nhu cau chup du lich, street life va quay video.',
                        ],
                    ],
                ],
            ],
            'iphone-15-128gb' => [
                'slug' => 'iphone-15-128gb',
                'name' => 'iPhone 15 128GB',
                'category' => 'Dien thoai',
                'brand' => 'Apple',
                'sku' => 'APL-IP15-128-BLU',
                'storage' => '128GB',
                'price' => '17.390.000d',
                'old_price' => '19.990.000d',
                'discount' => '-13%',
                'rating' => 5,
                'reviews_count' => 204,
                'tag' => 'Gia tot',
                'color' => 'Blue',
                'status' => 'Con hang tai 8 cua hang',
                'image' => 'https://via.placeholder.com/640x640/eff6ff/0f172a?text=iPhone+15',
                'gallery' => [
                    'https://via.placeholder.com/960x960/eff6ff/0f172a?text=iPhone+15+Front',
                    'https://via.placeholder.com/960x960/dbeafe/0f172a?text=iPhone+15+Back',
                ],
                'benefits' => ['Tang cap sac nhanh', 'Bao hanh 1 doi 1', 'Ho tro setup may moi'],
                'highlights' => [
                    'Mau de tiep can cho nguoi can iPhone on dinh, de dung va dep.',
                ],
                'variants' => [
                    ['label' => '128GB', 'active' => true],
                    ['label' => '256GB', 'active' => false],
                ],
                'colors' => [
                    ['label' => 'Blue', 'hex' => '#60a5fa', 'active' => true],
                    ['label' => 'Pink', 'hex' => '#f9a8d4', 'active' => false],
                    ['label' => 'Black', 'hex' => '#111827', 'active' => false],
                ],
                'technical_specs' => [
                    ['label' => 'Man hinh', 'value' => '6.1 inch Super Retina XDR'],
                    ['label' => 'Chip', 'value' => 'Apple A16 Bionic'],
                    ['label' => 'RAM', 'value' => '6GB'],
                    ['label' => 'Bo nho', 'value' => '128GB'],
                ],
                'in_the_box' => ['Than may iPhone 15', 'Cap USB-C', 'Tai lieu huong dan'],
                'description_sections' => [
                    [
                        'title' => 'iPhone de mua nhat trong nhom gia tam trung cao',
                        'content' => [
                            'May phu hop cho nguoi chuyen tu Android sang iPhone hoac can mot thiet bi nho gon, giao dien on dinh va chup anh tot.',
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
                'status' => 'Con hang tai 4 cua hang',
                'image' => 'https://via.placeholder.com/640x640/fef3c7/0f172a?text=MacBook+Air+M4',
                'gallery' => [
                    'https://via.placeholder.com/960x960/fef3c7/0f172a?text=MacBook+Air+Open',
                    'https://via.placeholder.com/960x960/fde68a/0f172a?text=MacBook+Air+Side',
                    'https://via.placeholder.com/960x960/fff7ed/0f172a?text=MacBook+Air+Keyboard',
                ],
                'benefits' => ['Tang tui va chuot', 'Bao hanh pin 12 thang', 'Ho tro tra gop 0%'],
                'highlights' => [
                    'Thiet ke mong nhe, phu hop hoc tap va cong viec di dong.',
                    'Chip M4 cho hieu nang/nhiet do rat can doi trong tam gia.',
                ],
                'variants' => [
                    ['label' => '16GB / 256GB', 'active' => true],
                    ['label' => '16GB / 512GB', 'active' => false],
                    ['label' => '24GB / 512GB', 'active' => false],
                ],
                'colors' => [
                    ['label' => 'Midnight', 'hex' => '#1e293b', 'active' => true],
                    ['label' => 'Silver', 'hex' => '#cbd5e1', 'active' => false],
                    ['label' => 'Starlight', 'hex' => '#e7e5d4', 'active' => false],
                ],
                'technical_specs' => [
                    ['label' => 'Man hinh', 'value' => '13.6 inch Liquid Retina'],
                    ['label' => 'Chip', 'value' => 'Apple M4 10-core CPU / 10-core GPU'],
                    ['label' => 'RAM', 'value' => '16GB Unified Memory'],
                    ['label' => 'SSD', 'value' => '256GB'],
                    ['label' => 'Pin', 'value' => 'Len den 18 gio xem video'],
                    ['label' => 'Cong ket noi', 'value' => 'MagSafe 3, 2 x Thunderbolt / USB 4'],
                    ['label' => 'Can nang', 'value' => '1.24kg'],
                ],
                'in_the_box' => ['MacBook Air M4', 'Cap MagSafe 3', 'Cu sac USB-C', 'Tai lieu huong dan'],
                'description_sections' => [
                    [
                        'title' => 'Cau hinh can doi cho hoc tap, van phong va creator co ban',
                        'content' => [
                            'MacBook Air M4 la lua chon hop ly cho nguoi can may dep, pin dai va he dieu hanh on dinh de lam viec hang ngay.',
                            'Ban RAM 16GB giup giai quyet tot hon nhu cau mo nhieu tab, dung Photoshop co ban va xu ly video ngan.',
                        ],
                    ],
                    [
                        'title' => 'Trai nghiem nhap lieu va hien thi de chiu trong thoi gian dai',
                        'content' => [
                            'Ban phim va trackpad van la nhung diem manh de giup nhom nguoi dung hoc tap, viet tai lieu va thao tac chinh xac.',
                            'Man hinh Liquid Retina sac net, mau sac de chiu, phu hop cho xem noi dung va lam viec van phong.',
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
                'tag' => 'Pro choice',
                'color' => 'Space Black',
                'status' => 'Con hang dat truoc',
                'image' => 'https://via.placeholder.com/640x640/fae8ff/0f172a?text=MacBook+Pro+M4',
                'gallery' => [
                    'https://via.placeholder.com/960x960/fae8ff/0f172a?text=MacBook+Pro+Open',
                    'https://via.placeholder.com/960x960/f5d0fe/0f172a?text=MacBook+Pro+Display',
                ],
                'benefits' => ['Goi Office 365', 'Tang hub chuyen doi', 'Ho tro dong bo du lieu'],
                'highlights' => ['Man hinh XDR dep, do sang cao.', 'Phu hop editor, designer va developer can may ben bi.'],
                'variants' => [
                    ['label' => '16GB / 512GB', 'active' => true],
                    ['label' => '24GB / 1TB', 'active' => false],
                ],
                'colors' => [
                    ['label' => 'Space Black', 'hex' => '#111827', 'active' => true],
                    ['label' => 'Silver', 'hex' => '#d1d5db', 'active' => false],
                ],
                'technical_specs' => [
                    ['label' => 'Man hinh', 'value' => '14.2 inch Liquid Retina XDR, ProMotion'],
                    ['label' => 'Chip', 'value' => 'Apple M4 Pro'],
                    ['label' => 'RAM', 'value' => '16GB Unified Memory'],
                    ['label' => 'SSD', 'value' => '512GB'],
                ],
                'in_the_box' => ['MacBook Pro M4', 'Cap MagSafe 3', 'Cu sac USB-C 70W'],
                'description_sections' => [
                    [
                        'title' => 'Lua chon hop ly cho nhom chuyen nghiep can hieu nang cao hon',
                        'content' => [
                            'Dong Pro phu hop nguoi can render nhanh, code project lon hoac lam viec voi file anh/video dung luong lon hon so voi dong Air.',
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
                'color' => 'Silver',
                'status' => 'Con hang online',
                'image' => 'https://via.placeholder.com/640x640/e0f2fe/0f172a?text=Mac+mini+M4',
                'gallery' => [
                    'https://via.placeholder.com/960x960/e0f2fe/0f172a?text=Mac+mini+Front',
                    'https://via.placeholder.com/960x960/bae6fd/0f172a?text=Mac+mini+Back',
                ],
                'benefits' => ['Tang bo phim khong day', 'Luu kho va giao nhanh', 'Ho tro lap dat tai nha'],
                'highlights' => ['Giai phap desktop macOS chi phi hop ly.', 'Phu hop setup ban lam viec gon gang.'],
                'variants' => [
                    ['label' => '16GB / 256GB', 'active' => true],
                    ['label' => '16GB / 512GB', 'active' => false],
                ],
                'colors' => [
                    ['label' => 'Silver', 'hex' => '#cbd5e1', 'active' => true],
                ],
                'technical_specs' => [
                    ['label' => 'Chip', 'value' => 'Apple M4'],
                    ['label' => 'RAM', 'value' => '16GB Unified Memory'],
                    ['label' => 'SSD', 'value' => '256GB'],
                    ['label' => 'Cong ket noi', 'value' => 'Thunderbolt, HDMI, Ethernet'],
                ],
                'in_the_box' => ['Mac mini M4', 'Day nguon'],
                'description_sections' => [
                    [
                        'title' => 'Desktop nho gon de nang cap tu Windows van phong',
                        'content' => [
                            'Neu da co san man hinh, Mac mini la cach vao he sinh thai Apple voi chi phi hop ly nhat trong nhom may Mac moi.',
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
                'tag' => 'All in one',
                'color' => 'Blue',
                'status' => 'Con hang tai 2 cua hang',
                'image' => 'https://via.placeholder.com/640x640/ede9fe/0f172a?text=iMac+M4',
                'gallery' => [
                    'https://via.placeholder.com/960x960/ede9fe/0f172a?text=iMac+Front',
                    'https://via.placeholder.com/960x960/e9d5ff/0f172a?text=iMac+Desk+Setup',
                ],
                'benefits' => ['Tang Magic Mouse', 'Bao hanh chinh hang', 'Ho tro giao va setup'],
                'highlights' => ['May all-in-one gon dep cho van phong cao cap.', 'Man hinh lon, am thanh tot, setup nhanh.'],
                'variants' => [
                    ['label' => '16GB / 512GB', 'active' => true],
                ],
                'colors' => [
                    ['label' => 'Blue', 'hex' => '#60a5fa', 'active' => true],
                    ['label' => 'Green', 'hex' => '#4ade80', 'active' => false],
                ],
                'technical_specs' => [
                    ['label' => 'Man hinh', 'value' => '24 inch 4.5K Retina'],
                    ['label' => 'Chip', 'value' => 'Apple M4'],
                    ['label' => 'RAM', 'value' => '16GB'],
                    ['label' => 'SSD', 'value' => '512GB'],
                ],
                'in_the_box' => ['iMac M4', 'Magic Keyboard', 'Magic Mouse', 'Day nguon'],
                'description_sections' => [
                    [
                        'title' => 'May tinh ban lam viec dep, gon va de van hanh',
                        'content' => [
                            'iMac phu hop showroom, van phong sang tao va nhom nguoi dung uu tien mot setup gon gang nhung van dep mat.',
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
                                'label' => 'iPhone 16 Series',
                                'children' => [
                                    ['slug' => 'iphone-16-pro-max', 'label' => 'iPhone 16 Pro Max'],
                                ],
                            ],
                            [
                                'slug' => 'iphone-15-series',
                                'label' => 'iPhone 15 Series',
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
                                'label' => 'MacBook Air Series',
                                'children' => [
                                    ['slug' => 'macbook-air-m4', 'label' => 'MacBook Air M4'],
                                ],
                            ],
                            [
                                'slug' => 'macbook-pro-series',
                                'label' => 'MacBook Pro Series',
                                'children' => [
                                    ['slug' => 'macbook-pro-m4', 'label' => 'MacBook Pro M4'],
                                ],
                            ],
                            [
                                'slug' => 'desktop-mac',
                                'label' => 'Desktop Mac',
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
                                'label' => 'Galaxy S25 Series',
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
                        'label' => 'Xiaomi Phone',
                        'children' => [
                            [
                                'slug' => 'xiaomi-15-series',
                                'label' => 'Xiaomi 15 Series',
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
            return Product::with(['brand', 'category.parent.parent', 'variants'])
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
            'status' => $product->is_preorder ? 'Đang nhận đặt trước' : ($variant && $variant->stock > 0 ? 'Còn hàng' : 'Liên hệ'),
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
                'status' => $variant->stock > 0 ? 'Còn hàng' : 'Liên hệ',
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
