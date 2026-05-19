<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->products() as $item) {
            $product = Product::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'name' => $item['name'],
                    'product_brand_id' => ProductBrand::where('slug', $item['brand'])->value('id'),
                    'product_category_id' => ProductCategory::where('slug', $item['category'])->value('id'),
                    'thumbnail' => $item['thumbnail'],
                    'images' => $item['images'],
                    'warranty_policy' => 'Bảo hành 12 tháng chính hãng',
                    'return_policy' => 'Đổi trả trong 30 ngày nếu có lỗi phần cứng từ nhà sản xuất',
                    'highlights' => $item['highlights'],
                    'summary' => $item['summary'],
                    'description' => $item['description'],
                    'status' => Product::STATUS_ACTIVE,
                    'is_preorder' => false,
                ]
            );

            $product->variants()->delete();
            foreach ($item['variants'] as $variant) {
                $product->variants()->create($variant);
            }

            $product->specifications()->delete();
            foreach ($item['specifications'] as $index => $specification) {
                $product->specifications()->create([
                    ...$specification,
                    'sort_order' => $index * 10,
                ]);
            }
        }
    }

    private function products(): array
    {
        return [
            [
                'name' => 'iPhone 16 Pro Max 256GB VN/A',
                'slug' => 'iphone-16-pro-max-256gb-vna',
                'brand' => 'apple',
                'category' => 'iphone-16-series',
                'thumbnail' => 'https://picsum.photos/seed/iphone-16-pro-max/800/800',
                'images' => [
                    'https://picsum.photos/seed/iphone-16-pro-max-1/1000/1000',
                    'https://picsum.photos/seed/iphone-16-pro-max-2/1000/1000',
                    'https://picsum.photos/seed/iphone-16-pro-max-3/1000/1000',
                ],
                'summary' => 'Flagship màn hình lớn, khung titanium, camera zoom linh hoạt và hiệu năng cao.',
                'description' => '<p>iPhone 16 Pro Max phù hợp người dùng cần màn hình lớn, pin tốt và camera mạnh cho cả chụp ảnh lẫn quay video.</p>',
                'highlights' => ['Trả góp 0% lãi suất', 'Thu cũ đổi mới trợ giá 2.500.000đ', 'Tặng ốp lưng cao cấp'],
                'variants' => [
                    ['sku' => 'IP16PM-256-NAT', 'storage' => '256GB', 'color_name' => 'Titan Tự Nhiên', 'color_code' => '#a8a29e', 'price_original' => 34990000, 'price_sale' => 30990000, 'stock' => 25],
                    ['sku' => 'IP16PM-512-BLK', 'storage' => '512GB', 'color_name' => 'Titan Đen', 'color_code' => '#27272a', 'price_original' => 39990000, 'price_sale' => 35990000, 'stock' => 12],
                ],
                'specifications' => $this->phoneSpecs('6.9 inch Super Retina XDR OLED, 120Hz', 'Apple A18 Pro', '8GB', '48MP + 48MP + 12MP', 'USB-C, MagSafe'),
            ],
            [
                'name' => 'iPhone 15 128GB VN/A',
                'slug' => 'iphone-15-128gb-vna',
                'brand' => 'apple',
                'category' => 'iphone-15-series',
                'thumbnail' => 'https://picsum.photos/seed/iphone-15/800/800',
                'images' => ['https://picsum.photos/seed/iphone-15-1/1000/1000', 'https://picsum.photos/seed/iphone-15-2/1000/1000'],
                'summary' => 'Mẫu iPhone dễ tiếp cận, thiết kế gọn, camera tốt và dùng cổng USB-C.',
                'description' => '<p>iPhone 15 là lựa chọn hợp lý cho người cần một chiếc iPhone mới, ổn định và giữ giá tốt.</p>',
                'highlights' => ['Giảm thêm khi thanh toán chuyển khoản', 'Hỗ trợ setup máy mới', 'Bảo hành chính hãng Apple'],
                'variants' => [
                    ['sku' => 'IP15-128-BLU', 'storage' => '128GB', 'color_name' => 'Blue', 'color_code' => '#93c5fd', 'price_original' => 19990000, 'price_sale' => 17390000, 'stock' => 40],
                    ['sku' => 'IP15-256-PNK', 'storage' => '256GB', 'color_name' => 'Pink', 'color_code' => '#f9a8d4', 'price_original' => 22990000, 'price_sale' => 20490000, 'stock' => 18],
                ],
                'specifications' => $this->phoneSpecs('6.1 inch Super Retina XDR', 'Apple A16 Bionic', '6GB', '48MP + 12MP', 'USB-C'),
            ],
            [
                'name' => 'Samsung Galaxy S25 Ultra 512GB',
                'slug' => 'samsung-galaxy-s25-ultra-512gb',
                'brand' => 'samsung',
                'category' => 'galaxy-s25-ultra',
                'thumbnail' => 'https://picsum.photos/seed/galaxy-s25-ultra/800/800',
                'images' => ['https://picsum.photos/seed/galaxy-s25-1/1000/1000', 'https://picsum.photos/seed/galaxy-s25-2/1000/1000'],
                'summary' => 'Flagship Android với S Pen, Galaxy AI, màn hình lớn và camera zoom xa.',
                'description' => '<p>Galaxy S25 Ultra hướng đến người dùng cần hiệu năng mạnh, camera đa dụng và công cụ ghi chú S Pen.</p>',
                'highlights' => ['Tặng củ sạc nhanh', 'Gói bảo vệ màn hình', 'Hỗ trợ chuyển dữ liệu tại cửa hàng'],
                'variants' => [
                    ['sku' => 'S25U-512-TGR', 'storage' => '512GB', 'color_name' => 'Titan Gray', 'color_code' => '#71717a', 'price_original' => 31490000, 'price_sale' => 27490000, 'stock' => 30],
                    ['sku' => 'S25U-1TB-TBK', 'storage' => '1TB', 'color_name' => 'Titan Black', 'color_code' => '#18181b', 'price_original' => 37990000, 'price_sale' => 33990000, 'stock' => 8],
                ],
                'specifications' => $this->phoneSpecs('6.8 inch Dynamic AMOLED 2X, 120Hz', 'Snapdragon 8 Elite for Galaxy', '12GB', '200MP + 50MP + 50MP + 12MP', '45W, Wireless Charging'),
            ],
            [
                'name' => 'Xiaomi 15 Ultra 16GB 512GB',
                'slug' => 'xiaomi-15-ultra-16gb-512gb',
                'brand' => 'xiaomi',
                'category' => 'xiaomi-15-ultra',
                'thumbnail' => 'https://picsum.photos/seed/xiaomi-15-ultra/800/800',
                'images' => ['https://picsum.photos/seed/xiaomi-15-1/1000/1000', 'https://picsum.photos/seed/xiaomi-15-2/1000/1000'],
                'summary' => 'Điện thoại camera flagship, RAM lớn, màn hình AMOLED sáng và sạc nhanh.',
                'description' => '<p>Xiaomi 15 Ultra phù hợp người dùng thích chụp ảnh, quay video và muốn cấu hình cao trong tầm giá cạnh tranh.</p>',
                'highlights' => ['Tặng tai nghe Bluetooth', 'Giảm thêm qua ví điện tử', 'Giao nhanh nội thành'],
                'variants' => [
                    ['sku' => 'XMI15U-512-BLK', 'storage' => '512GB', 'color_name' => 'Black', 'color_code' => '#111827', 'price_original' => 25790000, 'price_sale' => 22790000, 'stock' => 22],
                    ['sku' => 'XMI15U-512-SLV', 'storage' => '512GB', 'color_name' => 'Silver', 'color_code' => '#cbd5e1', 'price_original' => 25790000, 'price_sale' => 22990000, 'stock' => 14],
                ],
                'specifications' => $this->phoneSpecs('6.73 inch AMOLED 120Hz', 'Snapdragon 8 Elite', '16GB', 'Leica 50MP quad camera', '90W HyperCharge'),
            ],
            [
                'name' => 'MacBook Air M4 13 inch 16GB 256GB',
                'slug' => 'macbook-air-m4-13-16gb-256gb',
                'brand' => 'apple',
                'category' => 'macbook-air-m4',
                'thumbnail' => 'https://picsum.photos/seed/macbook-air-m4/900/700',
                'images' => ['https://picsum.photos/seed/macbook-air-m4-1/1000/800', 'https://picsum.photos/seed/macbook-air-m4-2/1000/800'],
                'summary' => 'Laptop mỏng nhẹ cho học tập, văn phòng và làm việc di động với chip Apple M4.',
                'description' => '<p>MacBook Air M4 cân bằng tốt giữa hiệu năng, pin và trọng lượng, phù hợp làm việc mỗi ngày.</p>',
                'highlights' => ['Tặng túi chống sốc', 'Cài đặt phần mềm cơ bản', 'Bảo hành Apple 12 tháng'],
                'variants' => [
                    ['sku' => 'MBA-M4-13-16-256-MID', 'storage' => '16GB / 256GB', 'color_name' => 'Midnight', 'color_code' => '#1f2937', 'price_original' => 29990000, 'price_sale' => 26990000, 'stock' => 20],
                    ['sku' => 'MBA-M4-13-16-512-SLV', 'storage' => '16GB / 512GB', 'color_name' => 'Silver', 'color_code' => '#d1d5db', 'price_original' => 34990000, 'price_sale' => 31990000, 'stock' => 10],
                ],
                'specifications' => $this->laptopSpecs('13.6 inch Liquid Retina', 'Apple M4', '16GB Unified Memory', '256GB SSD', 'macOS'),
            ],
            [
                'name' => 'MacBook Pro M4 14 inch 16GB 512GB',
                'slug' => 'macbook-pro-m4-14-16gb-512gb',
                'brand' => 'apple',
                'category' => 'macbook-pro-m4',
                'thumbnail' => 'https://picsum.photos/seed/macbook-pro-m4/900/700',
                'images' => ['https://picsum.photos/seed/macbook-pro-m4-1/1000/800', 'https://picsum.photos/seed/macbook-pro-m4-2/1000/800'],
                'summary' => 'MacBook Pro cho người cần màn hình XDR, hiệu năng ổn định và nhiều cổng kết nối.',
                'description' => '<p>MacBook Pro M4 phù hợp lập trình, sáng tạo nội dung và xử lý công việc nặng hơn MacBook Air.</p>',
                'highlights' => ['Tặng hub USB-C', 'Hỗ trợ trả góp 0%', 'Bảo hành chính hãng'],
                'variants' => [
                    ['sku' => 'MBP-M4-14-16-512-BLK', 'storage' => '16GB / 512GB', 'color_name' => 'Space Black', 'color_code' => '#111827', 'price_original' => 43990000, 'price_sale' => 39490000, 'stock' => 16],
                    ['sku' => 'MBP-M4-14-24-1TB-SLV', 'storage' => '24GB / 1TB', 'color_name' => 'Silver', 'color_code' => '#d1d5db', 'price_original' => 56990000, 'price_sale' => 52990000, 'stock' => 6],
                ],
                'specifications' => $this->laptopSpecs('14.2 inch Liquid Retina XDR, ProMotion', 'Apple M4', '16GB Unified Memory', '512GB SSD', 'macOS'),
            ],
            [
                'name' => 'Mac mini M4 16GB 256GB',
                'slug' => 'mac-mini-m4-16gb-256gb',
                'brand' => 'apple',
                'category' => 'mac-mini',
                'thumbnail' => 'https://picsum.photos/seed/mac-mini-m4/800/700',
                'images' => ['https://picsum.photos/seed/mac-mini-m4-1/1000/800', 'https://picsum.photos/seed/mac-mini-m4-2/1000/800'],
                'summary' => 'Desktop macOS nhỏ gọn, chi phí hợp lý cho bàn làm việc hiện đại.',
                'description' => '<p>Mac mini M4 là lựa chọn tốt nếu bạn đã có màn hình, bàn phím và muốn nâng cấp sang macOS.</p>',
                'highlights' => ['Tặng bàn phím không dây', 'Hỗ trợ lắp đặt tại nhà', 'Giao nhanh trong ngày'],
                'variants' => [
                    ['sku' => 'MMINI-M4-16-256', 'storage' => '16GB / 256GB', 'color_name' => 'Silver', 'color_code' => '#cbd5e1', 'price_original' => 17490000, 'price_sale' => 15690000, 'stock' => 18],
                    ['sku' => 'MMINI-M4-16-512', 'storage' => '16GB / 512GB', 'color_name' => 'Silver', 'color_code' => '#cbd5e1', 'price_original' => 22490000, 'price_sale' => 20490000, 'stock' => 9],
                ],
                'specifications' => $this->laptopSpecs('Xuất tối đa 3 màn hình', 'Apple M4', '16GB Unified Memory', '256GB SSD', 'macOS'),
            ],
            [
                'name' => 'iMac M4 24 inch 16GB 512GB',
                'slug' => 'imac-m4-24-16gb-512gb',
                'brand' => 'apple',
                'category' => 'imac',
                'thumbnail' => 'https://picsum.photos/seed/imac-m4/900/800',
                'images' => ['https://picsum.photos/seed/imac-m4-1/1000/900', 'https://picsum.photos/seed/imac-m4-2/1000/900'],
                'summary' => 'Máy tính all-in-one gọn đẹp cho văn phòng, showroom và góc làm việc tại nhà.',
                'description' => '<p>iMac M4 mang đến trải nghiệm máy bàn gọn gàng với màn hình 4.5K, loa tốt và thiết kế nhiều màu.</p>',
                'highlights' => ['Tặng Magic Mouse', 'Hỗ trợ giao lắp tận nơi', 'Bảo hành chính hãng Apple'],
                'variants' => [
                    ['sku' => 'IMAC-M4-24-16-512-BLU', 'storage' => '16GB / 512GB', 'color_name' => 'Blue', 'color_code' => '#60a5fa', 'price_original' => 39990000, 'price_sale' => 36990000, 'stock' => 7],
                    ['sku' => 'IMAC-M4-24-16-512-GRN', 'storage' => '16GB / 512GB', 'color_name' => 'Green', 'color_code' => '#86efac', 'price_original' => 39990000, 'price_sale' => 36990000, 'stock' => 5],
                ],
                'specifications' => $this->laptopSpecs('24 inch 4.5K Retina', 'Apple M4', '16GB Unified Memory', '512GB SSD', 'macOS'),
            ],
            [
                'name' => 'Apple Watch Ultra 2 GPS + Cellular',
                'slug' => 'apple-watch-ultra-2-gps-cellular',
                'brand' => 'apple',
                'category' => 'dong-ho-thong-minh',
                'thumbnail' => 'https://picsum.photos/seed/apple-watch-ultra-2/800/800',
                'images' => ['https://picsum.photos/seed/watch-ultra-2-1/1000/1000', 'https://picsum.photos/seed/watch-ultra-2-2/1000/1000'],
                'summary' => 'Đồng hồ thể thao cao cấp, vỏ titanium, pin dài và hỗ trợ eSIM.',
                'description' => '<p>Apple Watch Ultra 2 dành cho người dùng cần đồng hồ bền, màn hình sáng và nhiều tính năng sức khỏe.</p>',
                'highlights' => ['Tặng dây đeo thể thao', 'Hỗ trợ kích hoạt eSIM', 'Bảo hành chính hãng'],
                'variants' => [
                    ['sku' => 'AWU2-49-TIT-ORG', 'storage' => '49mm', 'color_name' => 'Titanium', 'color_code' => '#a8a29e', 'price_original' => 21990000, 'price_sale' => 18990000, 'stock' => 13],
                ],
                'specifications' => [
                    ['group_name' => 'Màn hình', 'name' => 'Kích thước', 'value' => '49mm Always-On Retina'],
                    ['group_name' => 'Hiệu năng', 'name' => 'Chip', 'value' => 'Apple S9 SiP'],
                    ['group_name' => 'Kết nối', 'name' => 'Kết nối', 'value' => 'GPS + Cellular, eSIM'],
                    ['group_name' => 'Pin & Sạc', 'name' => 'Thời lượng pin', 'value' => 'Lên tới 36 giờ'],
                ],
            ],
            [
                'name' => 'AirPods Pro 2 USB-C',
                'slug' => 'airpods-pro-2-usb-c',
                'brand' => 'apple',
                'category' => 'am-thanh',
                'thumbnail' => 'https://picsum.photos/seed/airpods-pro-2/800/800',
                'images' => ['https://picsum.photos/seed/airpods-pro-2-1/1000/1000', 'https://picsum.photos/seed/airpods-pro-2-2/1000/1000'],
                'summary' => 'Tai nghe chống ồn chủ động, âm thanh không gian và hộp sạc USB-C.',
                'description' => '<p>AirPods Pro 2 là lựa chọn gọn nhẹ cho iPhone, MacBook và iPad với khả năng chuyển thiết bị mượt.</p>',
                'highlights' => ['Tặng case bảo vệ', 'Hỗ trợ kiểm tra serial', 'Bảo hành chính hãng Apple'],
                'variants' => [
                    ['sku' => 'APP2-USBC-WHT', 'storage' => 'USB-C', 'color_name' => 'White', 'color_code' => '#f8fafc', 'price_original' => 6490000, 'price_sale' => 5490000, 'stock' => 35],
                ],
                'specifications' => [
                    ['group_name' => 'Âm thanh', 'name' => 'Chống ồn', 'value' => 'Active Noise Cancellation'],
                    ['group_name' => 'Âm thanh', 'name' => 'Tính năng', 'value' => 'Adaptive Audio, Spatial Audio'],
                    ['group_name' => 'Pin & Sạc', 'name' => 'Hộp sạc', 'value' => 'USB-C, MagSafe'],
                    ['group_name' => 'Kết nối', 'name' => 'Bluetooth', 'value' => 'Bluetooth 5.3'],
                ],
            ],
        ];
    }

    private function phoneSpecs(string $screen, string $chip, string $ram, string $camera, string $charging): array
    {
        return [
            ['group_name' => 'Màn hình', 'name' => 'Màn hình', 'value' => $screen],
            ['group_name' => 'Hiệu năng', 'name' => 'Vi xử lý', 'value' => $chip],
            ['group_name' => 'Hiệu năng', 'name' => 'RAM', 'value' => $ram],
            ['group_name' => 'Camera', 'name' => 'Camera sau', 'value' => $camera],
            ['group_name' => 'Pin & Sạc', 'name' => 'Sạc', 'value' => $charging],
        ];
    }

    private function laptopSpecs(string $screen, string $chip, string $ram, string $storage, string $os): array
    {
        return [
            ['group_name' => 'Màn hình', 'name' => 'Màn hình', 'value' => $screen],
            ['group_name' => 'Hiệu năng', 'name' => 'Vi xử lý', 'value' => $chip],
            ['group_name' => 'Hiệu năng', 'name' => 'RAM', 'value' => $ram],
            ['group_name' => 'Lưu trữ', 'name' => 'SSD', 'value' => $storage],
            ['group_name' => 'Phần mềm', 'name' => 'Hệ điều hành', 'value' => $os],
        ];
    }
}
