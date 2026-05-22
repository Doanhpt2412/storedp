<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->catalog() as $item) {
            $product = Product::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'name' => $item['name'],
                    'product_brand_id' => ProductBrand::where('slug', $item['brand'])->value('id'),
                    'product_category_id' => ProductCategory::where('slug', $item['category'])->value('id'),
                    'thumbnail' => $item['thumbnail'],
                    'images' => $item['images'],
                    'warranty_policy' => $item['warranty_policy'],
                    'return_policy' => $item['return_policy'],
                    'highlights' => $item['highlights'],
                    'summary' => $item['summary'],
                    'description' => $item['description'],
                    'status' => $item['status'],
                    'is_preorder' => $item['is_preorder'],
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
                    'sort_order' => $specification['sort_order'] ?? ($index * 10),
                ]);
            }
        }
    }

    private function catalog(): array
    {
        return [
            ...$this->iphone16ProMaxProducts(),
            ...$this->iphone15Products(),
            ...$this->iphone15ProProducts(),
            ...$this->galaxyS25UltraProducts(),
            ...$this->xiaomi15UltraProducts(),
            ...$this->macbookAirM4Products(),
            ...$this->macbookProM4Products(),
            ...$this->macMiniProducts(),
            ...$this->imacProducts(),
            ...$this->wearableAndAudioProducts(),
            ...$this->accessoriesProducts(),
        ];
    }

    private function iphone16ProMaxProducts(): array
    {
        return [
            $this->makePhoneProduct(
                'iPhone 16 Pro Max 256GB VN/A',
                'iphone-16-pro-max-256gb-vna',
                'apple',
                'iphone-16-pro-max',
                'Titan Tu Nhien',
                '#b0a89d',
                '256GB',
                34990000,
                30990000,
                28,
                'Flagship man hinh lon, zoom 5x va pin ben bi danh cho nguoi dung can mot mau iPhone cao cap de dung lau dai.',
                [
                    'A18 Pro van hanh muot trong game, render video va tac vu AI tren thiet bi.',
                    'Man hinh 6.9 inch Super Retina XDR cho khong gian hien thi rong, do sang cao va cuon 120Hz muot.',
                    'Cum camera 48MP linh hoat cho chup du lich, chan dung va quay 4K chi tiet.',
                ],
                $this->phoneSpecs('6.9 inch Super Retina XDR OLED 120Hz', 'Apple A18 Pro', '8GB', '256GB', '48MP + 48MP + 12MP', '4676mAh, USB-C, MagSafe')
            ),
            $this->makePhoneProduct(
                'iPhone 16 Pro Max 512GB VN/A',
                'iphone-16-pro-max-512gb-vna',
                'apple',
                'iphone-16-pro-max',
                'Titan Den',
                '#2a2a2a',
                '512GB',
                39990000,
                35990000,
                16,
                'Phien ban 512GB toi uu cho nguoi quay video 4K, chup ProRAW va can bo nho rong de lam viec di dong.',
                [
                    'Bo nho 512GB phu hop creator, sale online va nguoi hay quay video dai.',
                    'Zoom quang hoc 5x ket hop xu ly hinh anh giup tac nghiep su kien va du lich tot hon.',
                    'Khung titanium tao cam giac chac chan nhung van can doi khi su dung mot tay.',
                ],
                $this->phoneSpecs('6.9 inch Super Retina XDR OLED 120Hz', 'Apple A18 Pro', '8GB', '512GB', '48MP + 48MP + 12MP', '4676mAh, USB-C, MagSafe')
            ),
            $this->makePhoneProduct(
                'iPhone 16 Pro Max 1TB VN/A',
                'iphone-16-pro-max-1tb-vna',
                'apple',
                'iphone-16-pro-max',
                'Titan Trang',
                '#d8d4cf',
                '1TB',
                45990000,
                41990000,
                7,
                'Cau hinh 1TB danh cho nguoi dung sang tao noi dung can dung luong lon va he thong camera flagship de san xuat hinh anh ngay tren di dong.',
                [
                    'Bo nho 1TB han che phai sao luu thuong xuyen khi quay ProRes va chup RAW.',
                    'Hieu nang on dinh cho quy trinh chinh mau, cat video ngan va dang nen tang nhanh.',
                    'Thich hop cho nguoi dung muon mot may flagship Apple de su dung chuyen nghiep.',
                ],
                $this->phoneSpecs('6.9 inch Super Retina XDR OLED 120Hz', 'Apple A18 Pro', '8GB', '1TB', '48MP + 48MP + 12MP', '4676mAh, USB-C, MagSafe')
            ),
            $this->makePhoneProduct(
                'iPhone 16 Pro Max 256GB eSIM US',
                'iphone-16-pro-max-256gb-esim-us',
                'apple',
                'iphone-16-pro-max',
                'Titan Sa Mac',
                '#b29274',
                '256GB',
                33990000,
                29990000,
                9,
                'Ban eSIM phu hop khach can may dep, cau hinh flagship va uu tien gia mem hon phien ban VN/A.',
                [
                    'eSIM giup kich hoat nhanh, gon khe ket noi va phu hop nguoi dung quen he sinh thai Apple.',
                    'Camera zoom 5x va chip A18 Pro van duy tri trai nghiem cao cap tu chup anh toi game.',
                    'Phien ban duoc nhieu khach chon de len doi tu dong Pro Max cu.',
                ],
                $this->phoneSpecs('6.9 inch Super Retina XDR OLED 120Hz', 'Apple A18 Pro', '8GB', '256GB', '48MP + 48MP + 12MP', '4676mAh, USB-C, MagSafe')
            ),
            $this->makePhoneProduct(
                'iPhone 16 Pro Max 512GB Chinh Hang Active Online',
                'iphone-16-pro-max-512gb-active-online',
                'apple',
                'iphone-16-pro-max',
                'Titan Xam',
                '#8f8b85',
                '512GB',
                39490000,
                35490000,
                11,
                'May moi 100%, gia canh tranh cho khach dat online va uu tien dung luong cao de lam viec, quay dung va luu du lieu.',
                [
                    'Du hop voi nguoi dung can iPhone cao cap de dung 3-4 nam ma van thoai mai bo nho.',
                    'He thong camera va man hinh lon tao loi the khi lam noi dung va gia tri ban lai tot.',
                    'Mau titan xam trung tinh, de chon phu kien va hop nhieu doi tuong khach.',
                ],
                $this->phoneSpecs('6.9 inch Super Retina XDR OLED 120Hz', 'Apple A18 Pro', '8GB', '512GB', '48MP + 48MP + 12MP', '4676mAh, USB-C, MagSafe')
            ),
        ];
    }

    private function iphone15Products(): array
    {
        return [
            $this->makePhoneProduct(
                'iPhone 15 128GB VN/A',
                'iphone-15-128gb-vna',
                'apple',
                'iphone-15',
                'Blue',
                '#89b5ff',
                '128GB',
                19990000,
                17390000,
                36,
                'Mau iPhone de tiep can, thiet ke gon, camera 48MP va cong USB-C phu hop nhu cau su dung moi ngay.',
                [
                    'Thiet ke nhe, cam nam de chiu cho nguoi di chuyen nhieu.',
                    'Camera 48MP cho anh net hon va crop 2x thuan tien khi chup du lich.',
                    'He dieu hanh iOS toi uu tot cho nguoi dung can su on dinh va de ban lai.',
                ],
                $this->phoneSpecs('6.1 inch Super Retina XDR OLED', 'Apple A16 Bionic', '6GB', '128GB', '48MP + 12MP', '3349mAh, USB-C')
            ),
            $this->makePhoneProduct(
                'iPhone 15 256GB VN/A',
                'iphone-15-256gb-vna',
                'apple',
                'iphone-15',
                'Pink',
                '#f5b7d2',
                '256GB',
                22990000,
                20490000,
                18,
                'Bo nho 256GB la diem can bang giua gia thanh va kha nang luu video, anh, ung dung cho nhu cau su dung lau dai.',
                [
                    'Phu hop cho khach can may dep, chup dep va nho gon de dung hang ngay.',
                    '256GB thoai mai cho quay video 4K, luu tai lieu va album anh.',
                    'Pink la mau duoc nhom khach nu va nhan vien van phong chon nhieu.',
                ],
                $this->phoneSpecs('6.1 inch Super Retina XDR OLED', 'Apple A16 Bionic', '6GB', '256GB', '48MP + 12MP', '3349mAh, USB-C')
            ),
            $this->makePhoneProduct(
                'iPhone 15 Plus 128GB VN/A',
                'iphone-15-plus-128gb-vna',
                'apple',
                'iphone-15',
                'Black',
                '#23252a',
                '128GB',
                22990000,
                19990000,
                14,
                'Phien ban Plus huong den nguoi can pin tot va man hinh lon hon nhung van giu duoc trai nghiem iPhone than thien.',
                [
                    'Man hinh 6.7 inch rong rai cho xem phim, hoc online va lam viec di dong.',
                    'Pin cho thoi gian su dung tot hon ban tieu chuan, phu hop nguoi hay di cong tac.',
                    'Van giu camera 48MP de chup dep va quay video on dinh trong nhieu tinh huong.',
                ],
                $this->phoneSpecs('6.7 inch Super Retina XDR OLED', 'Apple A16 Bionic', '6GB', '128GB', '48MP + 12MP', '4383mAh, USB-C')
            ),
            $this->makePhoneProduct(
                'iPhone 15 Plus 256GB VN/A',
                'iphone-15-plus-256gb-vna',
                'apple',
                'iphone-15',
                'Green',
                '#a5c7a3',
                '256GB',
                25990000,
                22990000,
                12,
                'Su ket hop giua man hinh lon, pin ben va dung luong 256GB giup iPhone 15 Plus tro thanh lua chon hop ly cho gia dinh va dan van phong.',
                [
                    'Dung luong 256GB giup luu anh, video va tai lieu thoai mai hon.',
                    'Mau xanh nhe de phoi op lung va tao cam giac tre trung.',
                    'May phu hop voi khach muon nang cap tu iPhone 11, 12, 13 len doi mo rong.',
                ],
                $this->phoneSpecs('6.7 inch Super Retina XDR OLED', 'Apple A16 Bionic', '6GB', '256GB', '48MP + 12MP', '4383mAh, USB-C')
            ),
            $this->makePhoneProduct(
                'iPhone 15 512GB VN/A',
                'iphone-15-512gb-vna',
                'apple',
                'iphone-15',
                'Yellow',
                '#f7e58a',
                '512GB',
                28990000,
                25990000,
                6,
                'Dung luong 512GB mang lai khong gian luu tru rong cho nguoi lam noi dung nhe, ban hang online va di chuyen nhieu.',
                [
                    'Thuan tien luu video 4K, bo anh san pham va ung dung chinh sua.',
                    'Gia mem hon dong Pro nhung van du tot cho nhu cau chup quay co ban den nang.',
                    'La phien ban de chot don voi khach can may moi, dep va it lo day bo nho.',
                ],
                $this->phoneSpecs('6.1 inch Super Retina XDR OLED', 'Apple A16 Bionic', '6GB', '512GB', '48MP + 12MP', '3349mAh, USB-C')
            ),
        ];
    }

    private function iphone15ProProducts(): array
    {
        return [
            $this->makePhoneProduct(
                'iPhone 15 Pro 128GB VN/A',
                'iphone-15-pro-128gb-vna',
                'apple',
                'iphone-15-pro',
                'Titan Tu Nhien',
                '#a8a197',
                '128GB',
                28990000,
                24990000,
                10,
                'Lua chon flagship gon gon cho nguoi thich dong Pro, can camera tot va chip manh nhung khong muon than may qua lon.',
                [
                    'Chip A17 Pro van du suc cho game, quay video va xu ly tac vu nang.',
                    'Kich thuoc de cam mot tay, de vao tui va phu hop nguoi di chuyen nhieu.',
                    'Cum camera co zoom 3x giup chup chan dung va du lich linh hoat.',
                ],
                $this->phoneSpecs('6.1 inch Super Retina XDR OLED 120Hz', 'Apple A17 Pro', '8GB', '128GB', '48MP + 12MP + 12MP', '3274mAh, USB-C')
            ),
            $this->makePhoneProduct(
                'iPhone 15 Pro 256GB VN/A',
                'iphone-15-pro-256gb-vna',
                'apple',
                'iphone-15-pro',
                'Titan Xanh',
                '#5a6772',
                '256GB',
                31990000,
                27990000,
                11,
                'Phien ban 256GB duoc chon nhieu vi can bang tot giua gia, camera Pro va dung luong luu tru de quay chup hang ngay.',
                [
                    '256GB du cho su dung lau dai ma khong can day len iCloud qua som.',
                    'Hop voi nguoi can smartphone nho gon nhung van muon he camera cua dong Pro.',
                    'Mau titan xanh dem lai nhan dien khac biet va phu kien de phoi.',
                ],
                $this->phoneSpecs('6.1 inch Super Retina XDR OLED 120Hz', 'Apple A17 Pro', '8GB', '256GB', '48MP + 12MP + 12MP', '3274mAh, USB-C')
            ),
            $this->makePhoneProduct(
                'iPhone 15 Pro 512GB VN/A',
                'iphone-15-pro-512gb-vna',
                'apple',
                'iphone-15-pro',
                'Titan Den',
                '#2f3132',
                '512GB',
                37990000,
                33990000,
                5,
                'Danh cho nguoi can mau Pro nho gon nhung bo nho lon de quay dung, luu app va di chuyen trong he sinh thai Apple.',
                [
                    'Bo nho 512GB phu hop lam noi dung mang xa hoi, quay reels va luu an toan.',
                    'May gon, de dung cho sale, chu shop online hay creator nu can su linh hoat.',
                    'Khung titanium cho cam giac cao cap va ben bi hon khi dung lau dai.',
                ],
                $this->phoneSpecs('6.1 inch Super Retina XDR OLED 120Hz', 'Apple A17 Pro', '8GB', '512GB', '48MP + 12MP + 12MP', '3274mAh, USB-C')
            ),
            $this->makePhoneProduct(
                'iPhone 15 Pro Max 256GB VN/A',
                'iphone-15-pro-max-256gb-vna',
                'apple',
                'iphone-15-pro',
                'Titan Trang',
                '#d9d4cd',
                '256GB',
                34990000,
                30990000,
                9,
                'Van la mot trong nhung mau iPhone duoc san nhieu nhat nho camera zoom 5x, man hinh lon va gia de tiep can hon the he moi.',
                [
                    'Zoom 5x la diem cong lon cho nguoi chup du lich va su kien.',
                    'Gia sale tot hon the he moi nhung van giu duoc trai nghiem dong Pro Max.',
                    'Thuan tien cho khach can hang flagship ma toi uu ngan sach.',
                ],
                $this->phoneSpecs('6.7 inch Super Retina XDR OLED 120Hz', 'Apple A17 Pro', '8GB', '256GB', '48MP + 12MP + 12MP', '4441mAh, USB-C')
            ),
            $this->makePhoneProduct(
                'iPhone 15 Pro Max 512GB VN/A',
                'iphone-15-pro-max-512gb-vna',
                'apple',
                'iphone-15-pro',
                'Titan Tu Nhien',
                '#a8a197',
                '512GB',
                40990000,
                36990000,
                4,
                'Bo nho lon cung camera zoom 5x giup iPhone 15 Pro Max 512GB van rat hop voi nguoi lam video, ban hang va du lich.',
                [
                    'Luu duoc nhieu video 4K, anh RAW va du lieu cong viec hon.',
                    'Pin va than may lon tao loi the khi di quay hoac lam viec ngoai troi.',
                    'Gia tri su dung thuc te cao cho nhom khach nang cap tu 13 Pro Max, 14 Pro Max.',
                ],
                $this->phoneSpecs('6.7 inch Super Retina XDR OLED 120Hz', 'Apple A17 Pro', '8GB', '512GB', '48MP + 12MP + 12MP', '4441mAh, USB-C')
            ),
        ];
    }

    private function galaxyS25UltraProducts(): array
    {
        return [
            $this->makePhoneProduct(
                'Samsung Galaxy S25 Ultra 256GB',
                'samsung-galaxy-s25-ultra-256gb',
                'samsung',
                'galaxy-s25-ultra',
                'Titanium Gray',
                '#7b7f86',
                '256GB',
                31490000,
                27990000,
                22,
                'Flagship Android huong den nguoi dung can camera zoom xa, but S Pen va he thong AI phuc vu cong viec moi ngay.',
                [
                    'Snapdragon 8 Elite for Galaxy cho toc do phan hoi nhanh va kha nang da nhiem tot.',
                    'S Pen giup ghi chu nhanh, phe duyet tai lieu va chup anh tu xa.',
                    'Cum camera 200MP va telephoto kep danh cho nhom khach thich chup du lich va san pham.',
                ],
                $this->phoneSpecs('6.8 inch Dynamic AMOLED 2X 120Hz', 'Snapdragon 8 Elite for Galaxy', '12GB', '256GB', '200MP + 50MP + 50MP + 12MP', '5000mAh, 45W, wireless')
            ),
            $this->makePhoneProduct(
                'Samsung Galaxy S25 Ultra 512GB',
                'samsung-galaxy-s25-ultra-512gb',
                'samsung',
                'galaxy-s25-ultra',
                'Titanium Black',
                '#1c1d1f',
                '512GB',
                34990000,
                30990000,
                15,
                'Phien ban 512GB can bang giua hieu nang flagship va dung luong rong de chinh sua video, luu tai lieu va choi game.',
                [
                    'Dung luong 512GB phu hop creator Android can quay dung, chup anh va luu game.',
                    'Man hinh lon, but S Pen va Samsung DeX ho tro cong viec linh hoat.',
                    'Mau titanium black de ban lai va de phoi op lung cao cap.',
                ],
                $this->phoneSpecs('6.8 inch Dynamic AMOLED 2X 120Hz', 'Snapdragon 8 Elite for Galaxy', '12GB', '512GB', '200MP + 50MP + 50MP + 12MP', '5000mAh, 45W, wireless')
            ),
            $this->makePhoneProduct(
                'Samsung Galaxy S25 Ultra 1TB',
                'samsung-galaxy-s25-ultra-1tb',
                'samsung',
                'galaxy-s25-ultra',
                'Titanium Silverblue',
                '#bcc5d4',
                '1TB',
                40990000,
                36990000,
                6,
                'Dung luong 1TB danh cho nguoi dung muon mot may Android cao cap de quay chup, xu ly AI va luu tru khong can lo day bo nho.',
                [
                    '1TB la de bai ban hang ro rang cho nhom khach kinh doanh online, quay livestream va tao noi dung.',
                    'Camera zoom kep giup chup san khau, san pham va phong canh linh hoat.',
                    'La phien ban duoc quan tam boi nhom khach can may flagship de thay laptop nhe trong mot so tinh huong.',
                ],
                $this->phoneSpecs('6.8 inch Dynamic AMOLED 2X 120Hz', 'Snapdragon 8 Elite for Galaxy', '12GB', '1TB', '200MP + 50MP + 50MP + 12MP', '5000mAh, 45W, wireless')
            ),
            $this->makePhoneProduct(
                'Samsung Galaxy S25 Ultra 512GB Online Exclusive',
                'samsung-galaxy-s25-ultra-512gb-online-exclusive',
                'samsung',
                'galaxy-s25-ultra',
                'Titanium White Silver',
                '#d7d8dc',
                '512GB',
                34990000,
                30490000,
                8,
                'Ban mau online danh cho khach can giao nhanh, cau hinh lon va uu dai gia canh tranh trong nhom flagship Samsung.',
                [
                    'Thuan tien cho nguoi muon so huu mau S25 Ultra gia tot ma van day du bao hanh.',
                    'Cum camera va man hinh lon toi uu cho review san pham, hoc tap va giai tri.',
                    'Mau trang bac de tao cam giac sang, sach va cao cap.',
                ],
                $this->phoneSpecs('6.8 inch Dynamic AMOLED 2X 120Hz', 'Snapdragon 8 Elite for Galaxy', '12GB', '512GB', '200MP + 50MP + 50MP + 12MP', '5000mAh, 45W, wireless')
            ),
            $this->makePhoneProduct(
                'Samsung Galaxy S25 Ultra 256GB Tra Gop 0%',
                'samsung-galaxy-s25-ultra-256gb-tra-gop-0',
                'samsung',
                'galaxy-s25-ultra',
                'Titanium Jetblack',
                '#0f1012',
                '256GB',
                31490000,
                27490000,
                13,
                'Phien ban duoc day manh cho kenh tra gop 0%, phu hop khach can len doi nhanh sang Android cao cap nhat cua Samsung.',
                [
                    'Gia de tiep can hon trong nhom S25 Ultra nhung van du manh cho moi nhu cau nang.',
                    'Rat hop cho khach chuyen tu Note hoac S series doi cu len doi de lay S Pen va camera moi.',
                    'Ton kho on dinh de len don trong cac chuong trinh sale lon.',
                ],
                $this->phoneSpecs('6.8 inch Dynamic AMOLED 2X 120Hz', 'Snapdragon 8 Elite for Galaxy', '12GB', '256GB', '200MP + 50MP + 50MP + 12MP', '5000mAh, 45W, wireless')
            ),
        ];
    }

    private function xiaomi15UltraProducts(): array
    {
        return [
            $this->makePhoneProduct(
                'Xiaomi 15 Ultra 16GB 512GB',
                'xiaomi-15-ultra-16gb-512gb',
                'xiaomi',
                'xiaomi-15-ultra',
                'Black',
                '#1d1d1f',
                '16GB / 512GB',
                25990000,
                22990000,
                17,
                'Flagship camera phone huong den nhom khach uu tien Leica, hieu nang manh va gia de canh tranh trong phan khuc cao cap.',
                [
                    'Cum camera Leica la diem nhan lon cho khach thich anh mau va xoa phong canh.',
                    'RAM 16GB cho da nhiem, chinh sua hinh va game on dinh.',
                    'Gia sale tot giup Xiaomi 15 Ultra thanh lua chon de dong Android flagship.',
                ],
                $this->phoneSpecs('6.73 inch AMOLED LTPO 120Hz', 'Snapdragon 8 Elite', '16GB', '512GB', 'Leica 50MP + 50MP + 200MP + 50MP', '5410mAh, 90W')
            ),
            $this->makePhoneProduct(
                'Xiaomi 15 Ultra 16GB 1TB',
                'xiaomi-15-ultra-16gb-1tb',
                'xiaomi',
                'xiaomi-15-ultra',
                'White',
                '#f0f0f0',
                '16GB / 1TB',
                29990000,
                26990000,
                8,
                'Phien ban 1TB danh cho nguoi quay chup thuong xuyen va can bo nho lon nhung van muon toi uu chi phi so voi flagship doi thu.',
                [
                    '1TB rat phu hop cho creator mobile can luu file anh va video do phan giai cao.',
                    'Cum camera periscope 200MP tao loi the zoom xa, chup du lich va review san pham.',
                    'May duoc nhieu khach Android nang cap quan tam nho gia tri trang bi tren gia ban.',
                ],
                $this->phoneSpecs('6.73 inch AMOLED LTPO 120Hz', 'Snapdragon 8 Elite', '16GB', '1TB', 'Leica 50MP + 50MP + 200MP + 50MP', '5410mAh, 90W')
            ),
            $this->makePhoneProduct(
                'Xiaomi 15 Ultra Photography Kit Edition',
                'xiaomi-15-ultra-photography-kit-edition',
                'xiaomi',
                'xiaomi-15-ultra',
                'Silver Chrome',
                '#b4b6ba',
                '16GB / 512GB',
                27990000,
                24990000,
                6,
                'Ban kem Photography Kit danh cho nguoi dung thich chup anh cam tay, can nut chup va grip de thao tac giong may anh hon.',
                [
                    'Bo grip tang trai nghiem chup anh, quay doc va quay ngang de dang hon.',
                    'Rat phu hop cho creator di du lich, review dia diem va quay vlog.',
                    'San pham co tinh nhan dien cao va de len noi dung quang cao tren fanpage.',
                ],
                $this->phoneSpecs('6.73 inch AMOLED LTPO 120Hz', 'Snapdragon 8 Elite', '16GB', '512GB', 'Leica 50MP + 50MP + 200MP + 50MP', '5410mAh, 90W')
            ),
            $this->makePhoneProduct(
                'Xiaomi 15 Ultra 12GB 256GB',
                'xiaomi-15-ultra-12gb-256gb',
                'xiaomi',
                'xiaomi-15-ultra',
                'Black',
                '#1d1d1f',
                '12GB / 256GB',
                23990000,
                21490000,
                10,
                'Cau hinh de tiep can hon cho nguoi can camera flagship Xiaomi va hieu nang cao nhung muon toi uu ngan sach.',
                [
                    'Gia de tiep can hon ban 1TB nhung van giu bo camera Leica dac trung.',
                    'Hop voi nguoi dung Android muon len doi camera truoc khi dau tu bo nho qua lon.',
                    'Phien ban nay de len deal cho cac dip sale lon va livestream.',
                ],
                $this->phoneSpecs('6.73 inch AMOLED LTPO 120Hz', 'Snapdragon 8 Elite', '12GB', '256GB', 'Leica 50MP + 50MP + 200MP + 50MP', '5410mAh, 90W')
            ),
            $this->makePhoneProduct(
                'Xiaomi 15 Ultra 16GB 512GB Qua Tang Buds',
                'xiaomi-15-ultra-16gb-512gb-qua-tang-buds',
                'xiaomi',
                'xiaomi-15-ultra',
                'Silver',
                '#c8ccd2',
                '16GB / 512GB',
                25990000,
                22490000,
                12,
                'Ban sale kem qua tang tai nghe, phu hop kenh online khi can mot cau hinh flagship camera de chot don nhanh.',
                [
                    'Qua tang tang gia tri don hang va de truyen thong trong cac chien dich marketing.',
                    'May van day du camera Leica, man hinh dep va sac nhanh 90W.',
                    'Cau hinh 16GB / 512GB giu trai nghiem cao cap trong da so tinh huong.',
                ],
                $this->phoneSpecs('6.73 inch AMOLED LTPO 120Hz', 'Snapdragon 8 Elite', '16GB', '512GB', 'Leica 50MP + 50MP + 200MP + 50MP', '5410mAh, 90W')
            ),
        ];
    }

    private function macbookAirM4Products(): array
    {
        return [
            $this->makeLaptopProduct(
                'MacBook Air M4 13 inch 16GB 256GB',
                'macbook-air-m4-13-16gb-256gb',
                'apple',
                'macbook-air-m4',
                'Midnight',
                '#243246',
                '16GB / 256GB',
                29990000,
                26990000,
                21,
                'Mau MacBook de ban nhat cho sinh vien, dan van phong va nguoi can laptop nhe dep, pin dai voi chip M4.',
                [
                    'Than may mong, nhe va pin dai de di hoc, di hop va lam viec ngoai van phong.',
                    'M4 xu ly tot bo Office, Photoshop co ban, trinh duyet nhieu tab va hop online.',
                    'Gia ban de tiep can trong nhom MacBook moi doi M4.',
                ],
                $this->laptopSpecs('13.6 inch Liquid Retina', 'Apple M4', '16GB unified memory', '256GB SSD', 'macOS')
            ),
            $this->makeLaptopProduct(
                'MacBook Air M4 13 inch 16GB 512GB',
                'macbook-air-m4-13-16gb-512gb',
                'apple',
                'macbook-air-m4',
                'Silver',
                '#d8dbe0',
                '16GB / 512GB',
                34990000,
                31990000,
                14,
                'Bo nho 512GB hop cho nguoi lam viec giay to, thiet ke nhe, thao tac mượt va can luu them du lieu tren may.',
                [
                    'Luu duoc nhieu file hoc tap, anh san pham va du lieu cong viec hon ban 256GB.',
                    'Van giu duoc do gon nhe dac trung cua dong Air 13 inch.',
                    'Thich hop cho nhom khach can laptop Apple de dung 3-5 nam voi hieu nang on.',
                ],
                $this->laptopSpecs('13.6 inch Liquid Retina', 'Apple M4', '16GB unified memory', '512GB SSD', 'macOS')
            ),
            $this->makeLaptopProduct(
                'MacBook Air M4 15 inch 16GB 256GB',
                'macbook-air-m4-15-16gb-256gb',
                'apple',
                'macbook-air-m4',
                'Starlight',
                '#d9d0b4',
                '16GB / 256GB',
                34990000,
                31990000,
                10,
                'Phien ban 15 inch tang khong gian lam viec, phu hop nhom khach van phong can man hinh rong nhung khong muon len Pro.',
                [
                    'Man hinh lon de mo nhieu cua so va bang tinh de dang hon.',
                    'Van giu than may mong, pin ben va hoat dong em ai cua dong Air.',
                    'Rat hop cho giao vien, sale, marketer va chu shop online.',
                ],
                $this->laptopSpecs('15.3 inch Liquid Retina', 'Apple M4', '16GB unified memory', '256GB SSD', 'macOS')
            ),
            $this->makeLaptopProduct(
                'MacBook Air M4 15 inch 16GB 512GB',
                'macbook-air-m4-15-16gb-512gb',
                'apple',
                'macbook-air-m4',
                'Space Gray',
                '#5f6369',
                '16GB / 512GB',
                39990000,
                36990000,
                8,
                'Phien ban Air man hinh lon va bo nho rong huong den nguoi can may dep, pin dai va lam noi dung co ban tren macOS.',
                [
                    'Thuan tien cho designer co ban, nhan vien marketing va van phong can luu them file media.',
                    'M4 cho toc do dung app nhanh va tuong tac he sinh thai Apple rat tot.',
                    'Space Gray la mau an toan, de chon cho doanh nghiep va nhom van phong.',
                ],
                $this->laptopSpecs('15.3 inch Liquid Retina', 'Apple M4', '16GB unified memory', '512GB SSD', 'macOS')
            ),
            $this->makeLaptopProduct(
                'MacBook Air M4 13 inch 24GB 512GB',
                'macbook-air-m4-13-24gb-512gb',
                'apple',
                'macbook-air-m4',
                'Midnight',
                '#243246',
                '24GB / 512GB',
                42990000,
                39990000,
                4,
                'Cau hinh RAM 24GB nham toi nhom dung nhieu tab, may ao nhe, Photoshop, Figma va quy trinh cong viec nang hon ban tieu chuan.',
                [
                    '24GB RAM giup da nhiem va thao tac nhieu app trong thoi gian dai on dinh hon.',
                    'Van giu than hinh gon nhe cua Air de di lai moi ngay.',
                    'Lua chon nay de len cho khach la freelancer, lap trinh vien va creator nhe.',
                ],
                $this->laptopSpecs('13.6 inch Liquid Retina', 'Apple M4', '24GB unified memory', '512GB SSD', 'macOS')
            ),
        ];
    }

    private function macbookProM4Products(): array
    {
        return [
            $this->makeLaptopProduct(
                'MacBook Pro M4 14 inch 16GB 512GB',
                'macbook-pro-m4-14-16gb-512gb',
                'apple',
                'macbook-pro-m4',
                'Space Black',
                '#1e232b',
                '16GB / 512GB',
                43990000,
                39490000,
                12,
                'Mau Pro 14 inch can bang giua hieu nang, cong ket noi va tinh co dong cho lap trinh, edit co ban va cong viec chuyen mon.',
                [
                    'Man hinh Liquid Retina XDR dep, do sang cao va phu hop chinh mau co ban.',
                    'Quat tan nhiet giup du hieu nang tot hon dong Air khi render, code va xuat file dai.',
                    'Kich thuoc 14 inch de di chuyen nhung van du khong gian lam viec.',
                ],
                $this->laptopSpecs('14.2 inch Liquid Retina XDR 120Hz', 'Apple M4', '16GB unified memory', '512GB SSD', 'macOS')
            ),
            $this->makeLaptopProduct(
                'MacBook Pro M4 14 inch 24GB 1TB',
                'macbook-pro-m4-14-24gb-1tb',
                'apple',
                'macbook-pro-m4',
                'Silver',
                '#d7dade',
                '24GB / 1TB',
                56990000,
                52990000,
                6,
                'Cau hinh nang hon cho nhom lap trinh, quay dung va xu ly du an lon can RAM va SSD rong.',
                [
                    '24GB RAM + 1TB SSD giai quyet tot workflow dung Adobe, Xcode va Docker co ban.',
                    'Than may 14 inch van gon trong tui xach va phu hop cong tac.',
                    'Gia tri su dung cao cho nhom khach can dau tu may lam viec 3-5 nam.',
                ],
                $this->laptopSpecs('14.2 inch Liquid Retina XDR 120Hz', 'Apple M4', '24GB unified memory', '1TB SSD', 'macOS')
            ),
            $this->makeLaptopProduct(
                'MacBook Pro M4 Pro 14 inch 24GB 512GB',
                'macbook-pro-m4-pro-14-24gb-512gb',
                'apple',
                'macbook-pro-m4',
                'Space Black',
                '#1e232b',
                '24GB / 512GB',
                59990000,
                55990000,
                5,
                'Ban M4 Pro huong den nguoi dung can them nhan GPU/CPU cho code, AI nhe va bien tap video thuong xuyen.',
                [
                    'Hieu nang M4 Pro phu hop du an da luong va cong viec sang tao nang hon.',
                    'So huu nhieu cong ket noi hon va tan nhiet tot de duy tri xung nhip.',
                    'Rat phu hop studio nho, lap trinh vien full-stack va motion editor.',
                ],
                $this->laptopSpecs('14.2 inch Liquid Retina XDR 120Hz', 'Apple M4 Pro', '24GB unified memory', '512GB SSD', 'macOS')
            ),
            $this->makeLaptopProduct(
                'MacBook Pro M4 Pro 16 inch 24GB 512GB',
                'macbook-pro-m4-pro-16-24gb-512gb',
                'apple',
                'macbook-pro-m4',
                'Silver',
                '#d7dade',
                '24GB / 512GB',
                69990000,
                65990000,
                4,
                'Man hinh lon hon, pin dai va hieu nang ben bi cho nguoi can mot laptop thay the workstation trong nhieu tinh huong.',
                [
                    '16 inch mang lai khong gian timeline va code editor de thao tac thoai mai hon.',
                    'Pin manh va loa tot giup may hop ca di chuyen lan lam viec tai cho.',
                    'La cau hinh de tu van cho editor, nhac si va nguoi chay nhieu may ao.',
                ],
                $this->laptopSpecs('16.2 inch Liquid Retina XDR 120Hz', 'Apple M4 Pro', '24GB unified memory', '512GB SSD', 'macOS')
            ),
            $this->makeLaptopProduct(
                'MacBook Pro M4 Max 16 inch 36GB 1TB',
                'macbook-pro-m4-max-16-36gb-1tb',
                'apple',
                'macbook-pro-m4',
                'Space Black',
                '#1e232b',
                '36GB / 1TB',
                92990000,
                88990000,
                2,
                'Cau hinh dau bang danh cho studio, motion graphics, 3D nhe va quy trinh hinh anh can hieu nang cao ngay tren laptop.',
                [
                    'M4 Max va 36GB RAM phu hop du an nang, timeline phuc tap va workflow da lop.',
                    '1TB SSD giai quyet nhu cau luu source, project va cache tren mot thiet bi.',
                    'San pham mang tinh danh tien va nang tam showroom khi trinh bay.',
                ],
                $this->laptopSpecs('16.2 inch Liquid Retina XDR 120Hz', 'Apple M4 Max', '36GB unified memory', '1TB SSD', 'macOS')
            ),
        ];
    }

    private function macMiniProducts(): array
    {
        return [
            $this->makeDesktopProduct(
                'Mac mini M4 16GB 256GB',
                'mac-mini-m4-16gb-256gb',
                'apple',
                'mac-mini',
                'Silver',
                '#d0d5dc',
                '16GB / 256GB',
                17490000,
                15690000,
                20,
                'Desktop macOS gon nhe, chi phi hop ly cho van phong, quan ly ban hang va nguoi dung da co man hinh san.',
                [
                    'Gia de chot don trong nhom Mac, rat hop doanh nghiep va home office.',
                    'Chip M4 cho thao tac nhanh voi Excel, browser, POS va bo Office.',
                    'Kich thuoc gon de setup tai quay ban hang, studio nho hoac ban lam viec.',
                ],
                $this->desktopSpecs('Apple M4', '16GB unified memory', '256GB SSD', 'macOS', 'Wi-Fi 6E, Bluetooth 5.3, Gigabit Ethernet')
            ),
            $this->makeDesktopProduct(
                'Mac mini M4 16GB 512GB',
                'mac-mini-m4-16gb-512gb',
                'apple',
                'mac-mini',
                'Silver',
                '#d0d5dc',
                '16GB / 512GB',
                22490000,
                20490000,
                11,
                'Ban nang cap SSD phu hop van phong va nguoi can luu them file anh, du lieu cong viec tren may.',
                [
                    '512GB SSD thoai mai hon cho bo Office, du lieu ke toan va anh san pham.',
                    'Van giu loi the desktop gon gon, it ton dien va hoat dong em.',
                    'Hop cho nhom khach nang cap tu PC van phong sang macOS.',
                ],
                $this->desktopSpecs('Apple M4', '16GB unified memory', '512GB SSD', 'macOS', 'Wi-Fi 6E, Bluetooth 5.3, Gigabit Ethernet')
            ),
            $this->makeDesktopProduct(
                'Mac mini M4 24GB 512GB',
                'mac-mini-m4-24gb-512gb',
                'apple',
                'mac-mini',
                'Silver',
                '#d0d5dc',
                '24GB / 512GB',
                28490000,
                26490000,
                7,
                'RAM 24GB mo rong kha nang da nhiem va lap trinh, phu hop nhom can desktop nho gon nhung on dinh de lam viec lau dai.',
                [
                    '24GB RAM phu hop mo nhieu app, Docker nhe va may ao co ban.',
                    'Ket hop tot voi man hinh 4K cho lap trinh, van phong va chinh anh.',
                    'La cau hinh dang de tu van cho startup va agency nho.',
                ],
                $this->desktopSpecs('Apple M4', '24GB unified memory', '512GB SSD', 'macOS', 'Wi-Fi 6E, Bluetooth 5.3, Gigabit Ethernet')
            ),
            $this->makeDesktopProduct(
                'Mac mini M4 Pro 24GB 512GB',
                'mac-mini-m4-pro-24gb-512gb',
                'apple',
                'mac-mini',
                'Silver',
                '#d0d5dc',
                '24GB / 512GB',
                39990000,
                36990000,
                5,
                'M4 Pro tao buoc nhay lon ve CPU/GPU cho developer, editor va studio nho can desktop macOS hieu nang cao.',
                [
                    'Hieu nang du suc cho code, render nhe va mot so workflow sang tao.',
                    'Form factor gon de dat trong khong gian hep nhung van nhieu cong ket noi.',
                    'Rat hop lam may build, may lap trinh hoac may bien tap co dinh.',
                ],
                $this->desktopSpecs('Apple M4 Pro', '24GB unified memory', '512GB SSD', 'macOS', 'Wi-Fi 6E, Bluetooth 5.3, 10Gb Ethernet option')
            ),
            $this->makeDesktopProduct(
                'Mac mini M4 Pro 48GB 1TB',
                'mac-mini-m4-pro-48gb-1tb',
                'apple',
                'mac-mini',
                'Silver',
                '#d0d5dc',
                '48GB / 1TB',
                59990000,
                56990000,
                2,
                'Desktop compact cho nhom chuyen mon can hieu nang cao trong mot than may gon, de bo tri va van tiet kiem dien nang.',
                [
                    '48GB RAM + 1TB SSD phu hop build du an lon, xu ly du lieu va render dai.',
                    'Thuan tien cho phong studio, cong ty media nho va phong code.',
                    'Mau may trinh bay tot trong showroom vi hieu nang cao ma kich thuoc rat gon.',
                ],
                $this->desktopSpecs('Apple M4 Pro', '48GB unified memory', '1TB SSD', 'macOS', 'Wi-Fi 6E, Bluetooth 5.3, Thunderbolt')
            ),
        ];
    }

    private function imacProducts(): array
    {
        return [
            $this->makeDesktopProduct(
                'iMac M4 24 inch 16GB 256GB Blue',
                'imac-m4-24-16gb-256gb-blue',
                'apple',
                'imac',
                'Blue',
                '#7fa8df',
                '16GB / 256GB',
                37990000,
                34990000,
                8,
                'All-in-one dep mat, gon ban va phu hop showroom, le tan, van phong hien dai hoac goc lam viec tai nha.',
                [
                    'Man hinh 4.5K dep de xu ly van ban, hinh anh va trinh bay san pham.',
                    'May tinh all-in-one giup khong gian gon gon, de set up va de giao may.',
                    'Mau xanh tao nhan dien tre trung, rat hop cho showroom cong nghe.',
                ],
                $this->desktopSpecs('Apple M4', '16GB unified memory', '256GB SSD', 'macOS', 'Wi-Fi 6E, Bluetooth 5.3')
            ),
            $this->makeDesktopProduct(
                'iMac M4 24 inch 16GB 512GB Green',
                'imac-m4-24-16gb-512gb-green',
                'apple',
                'imac',
                'Green',
                '#87be97',
                '16GB / 512GB',
                39990000,
                36990000,
                7,
                'Cau hinh can bang cho nhom can them khong gian luu tru de xu ly tai lieu, hinh anh va bo phan marketing tai van phong.',
                [
                    '512GB SSD thoai mai hon cho data cong viec va album media.',
                    'Mau xanh tao diem nhan trang tri khong gian lam viec, quan cafe hoac studio.',
                    'Camera, loa va mic tich hop hop online va livestream co ban rat tien.',
                ],
                $this->desktopSpecs('Apple M4', '16GB unified memory', '512GB SSD', 'macOS', 'Wi-Fi 6E, Bluetooth 5.3')
            ),
            $this->makeDesktopProduct(
                'iMac M4 24 inch 24GB 512GB Silver',
                'imac-m4-24-24gb-512gb-silver',
                'apple',
                'imac',
                'Silver',
                '#d7dade',
                '24GB / 512GB',
                44990000,
                41990000,
                5,
                'RAM 24GB mo rong kha nang da nhiem cho van phong sang tao, media nhe va nguoi can all-in-one ben bi de dung lau dai.',
                [
                    '24GB RAM giup mo nhieu app, tab va xu ly noi dung on hon.',
                    'Mau bac trung tinh de dua vao moi moi truong van phong.',
                    'Rat phu hop cho ke toan, sale, media va tiep tan cao cap.',
                ],
                $this->desktopSpecs('Apple M4', '24GB unified memory', '512GB SSD', 'macOS', 'Wi-Fi 6E, Bluetooth 5.3')
            ),
            $this->makeDesktopProduct(
                'iMac M4 24 inch 16GB 256GB Pink',
                'imac-m4-24-16gb-256gb-pink',
                'apple',
                'imac',
                'Pink',
                '#e4b3c4',
                '16GB / 256GB',
                37990000,
                34990000,
                4,
                'Phien ban mau hong dep mat de trung bay trong studio, cua hang lifestyle hoac khong gian sang tao ca nhan.',
                [
                    'Ngoai hinh la diem manh de tao cam hung lam viec va trinh bay showroom.',
                    'Van day du suc cho van phong, content, design co ban va hoc tap.',
                    'San pham de tao bo suu tap mau trong danh muc iMac.',
                ],
                $this->desktopSpecs('Apple M4', '16GB unified memory', '256GB SSD', 'macOS', 'Wi-Fi 6E, Bluetooth 5.3')
            ),
            $this->makeDesktopProduct(
                'iMac M4 24 inch 24GB 1TB Yellow',
                'imac-m4-24-24gb-1tb-yellow',
                'apple',
                'imac',
                'Yellow',
                '#e1c56b',
                '24GB / 1TB',
                51990000,
                48990000,
                2,
                'Ban cao nhat trong nhom iMac de huong toi studio, chu shop online hoac doanh nghiep can mot all-in-one dep va luu tru lon.',
                [
                    '1TB SSD phu hop luu tai nguyen hinh anh, video, thiet ke va du lieu ban hang.',
                    '24GB RAM tang kha nang da nhiem va xu ly noi dung tot hon.',
                    'Mau vang tao diem nhan thi giac rat tot cho phong trung bay.',
                ],
                $this->desktopSpecs('Apple M4', '24GB unified memory', '1TB SSD', 'macOS', 'Wi-Fi 6E, Bluetooth 5.3')
            ),
        ];
    }

    private function wearableAndAudioProducts(): array
    {
        return [
            $this->makeWatchProduct(
                'Apple Watch Ultra 2 GPS + Cellular Ocean Band',
                'apple-watch-ultra-2-gps-cellular-ocean-band',
                'apple',
                'dong-ho-thong-minh',
                'Titanium',
                '#aaa295',
                '49mm',
                21990000,
                18990000,
                13,
                'Dong ho cao cap cho tap luyen, di chuyen ngoai troi va nguoi can thiet bi ben bi, pin dai trong he sinh thai Apple.',
                [
                    'Vo titanium ben bi, man hinh sang va kha nang dinh vi chinh xac.',
                    'Phu hop khach can dong ho the thao, chong nuoc va co eSIM.',
                    'Gia tri cao trong nhom Apple Watch cao cap.',
                ]
            ),
            $this->makeWatchProduct(
                'Apple Watch Series 10 GPS 42mm Sport Band',
                'apple-watch-series-10-gps-42mm-sport-band',
                'apple',
                'dong-ho-thong-minh',
                'Jet Black',
                '#232429',
                '42mm',
                10990000,
                9790000,
                18,
                'Lua chon can bang cho nguoi can dong ho thong minh dep, nhe va theo doi suc khoe hang ngay.',
                [
                    'Kich thuoc 42mm de deo va phu hop co tay nho den vua.',
                    'Theo doi tap luyen, giac ngu va thong bao tu iPhone lien tuc.',
                    'Muc gia de tiep can nhat trong nhom Apple Watch moi.',
                ]
            ),
            $this->makeWatchProduct(
                'Apple Watch Series 10 GPS 46mm Milanese Loop',
                'apple-watch-series-10-gps-46mm-milanese-loop',
                'apple',
                'dong-ho-thong-minh',
                'Gold',
                '#ceb384',
                '46mm',
                13990000,
                12490000,
                9,
                'Phien ban man hinh lon va day deo lich su nham toi nhom can dong ho thong minh ket hop thoi trang va cong nghe.',
                [
                    'Man hinh 46mm de xem thong bao, tap luyen va thao tac thoai mai hon.',
                    'Milanese Loop tao cam giac cao cap, hop nguoi di lam va gap go.',
                    'San pham de len goi combo voi iPhone moi.',
                ]
            ),
            $this->makeAudioProduct(
                'AirPods Pro 2 USB-C',
                'airpods-pro-2-usb-c',
                'apple',
                'am-thanh',
                'White',
                '#f2f4f7',
                'USB-C',
                6490000,
                5490000,
                34,
                'Tai nghe true wireless cao cap cho nguoi dung Apple can chong on, nghe goi ro va ket noi muot voi iPhone, iPad, Mac.',
                [
                    'ANC va Transparency mode tao trai nghiem dung thuc te trong van phong va khi di chuyen.',
                    'Ho tro Audio khong gian, ghep noi nhanh va tu dong chuyen thiet bi.',
                    'La san pham de chot don kem iPhone va MacBook.',
                ]
            ),
            $this->makeAudioProduct(
                'AirPods 4 Active Noise Cancellation',
                'airpods-4-active-noise-cancellation',
                'apple',
                'am-thanh',
                'White',
                '#f2f4f7',
                'USB-C',
                4990000,
                4390000,
                22,
                'Mau tai nghe moi danh cho khach thich dang earbud gon nhe nhung van can kha nang chong on de dung hang ngay.',
                [
                    'Phu hop sinh vien, dan van phong va khach can tai nghe Apple gon nhe.',
                    'Ghep noi nhanh, thao tac de va de ban them cung iPhone.',
                    'Gia de tiep can hon Pro 2 nhung van giu trai nghiem he sinh thai tot.',
                ]
            ),
        ];
    }

    private function accessoriesProducts(): array
    {
        return [
            $this->makeAccessoryProduct(
                'Sạc không dây Apple MagSafe Charger',
                'sac-khong-day-apple-magsafe-charger',
                'apple',
                'phu-kien',
                'Trắng',
                '#ffffff',
                1190000,
                990000,
                50,
                'Sạc không dây từ tính chính hãng Apple, hỗ trợ sạc nhanh 15W cho các dòng iPhone 12 trở lên.',
                [
                    'Thiết kế từ tính hít chặt vào mặt lưng iPhone.',
                    'Sạc nhanh không dây chuẩn Qi và MagSafe tới 15W.',
                    'Thiết kế nhỏ gọn, tinh tế và dễ mang theo.',
                ],
                $this->accessorySpecs('Apple', 'Sạc không dây', '15W Max', 'iPhone, AirPods'),
                [
                    'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/MHXH3?wid=1144&hei=1144&fmt=jpeg',
                    'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/MHXH3_AV1?wid=1144&hei=1144&fmt=jpeg',
                    'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/MHXH3_AV2?wid=1144&hei=1144&fmt=jpeg',
                    'https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/MHXH3_AV3?wid=1144&hei=1144&fmt=jpeg'
                ]
            ),
            $this->makeAccessoryProduct(
                'Tai nghe không dây Samsung Galaxy Buds2 Pro',
                'tai-nghe-khong-day-samsung-galaxy-buds2-pro',
                'samsung',
                'phu-kien',
                'Đen Graphite',
                '#333333',
                4990000,
                3990000,
                30,
                'Tai nghe True Wireless từ Samsung hỗ trợ âm thanh Hi-Fi 24-bit và chống ồn chủ động (ANC).',
                [
                    'Âm thanh Hi-Fi 24-bit mang lại trải nghiệm cực kỳ chi tiết.',
                    'Chống ồn chủ động thông minh giúp loại bỏ tạp âm hiệu quả.',
                    'Thiết kế nhỏ gọn hoàn hảo cho việc tập luyện.',
                ],
                $this->accessorySpecs('Samsung', 'Tai nghe True Wireless ANC', 'USB-C', 'Android, iOS'),
                [
                    'https://images.samsung.com/is/image/samsung/p6pim/vn/sm-r510nzaaxxv/gallery/vn-galaxy-buds2-pro-r510-sm-r510nzaaxxv-533192305',
                    'https://images.samsung.com/is/image/samsung/p6pim/vn/sm-r510nzaaxxv/gallery/vn-galaxy-buds2-pro-r510-sm-r510nzaaxxv-533192304',
                    'https://images.samsung.com/is/image/samsung/p6pim/vn/sm-r510nzaaxxv/gallery/vn-galaxy-buds2-pro-r510-sm-r510nzaaxxv-533192308',
                    'https://images.samsung.com/is/image/samsung/p6pim/vn/sm-r510nzaaxxv/gallery/vn-galaxy-buds2-pro-r510-sm-r510nzaaxxv-533192306'
                ]
            ),
            $this->makeAccessoryProduct(
                'Tai nghe không dây Sony WF-1000XM5',
                'tai-nghe-khong-day-sony-wf-1000xm5',
                'sony',
                'phu-kien',
                'Đen',
                '#000000',
                6990000,
                6490000,
                20,
                'Tai nghe In-ear chống ồn hàng đầu thị trường của Sony với chất âm Hi-Res tuyệt đỉnh.',
                [
                    'Công nghệ chống ồn thế hệ mới từ Sony.',
                    'Driver âm thanh độc quyền mang đến chất âm vô cùng chi tiết.',
                    'Pin dùng đến 8 giờ kèm hộp sạc lên 24 giờ.',
                ],
                $this->accessorySpecs('Sony', 'Tai nghe True Wireless ANC', 'USB-C', 'Android, iOS'),
                [
                    'https://www.sony.com.vn/image/5d02da5df552836db894cead8a68f5f3?fmt=pjpeg&wid=1014&hei=396&bgcolor=F1F5F9&bgc=F1F5F9',
                    'https://www.sony.com.vn/image/44917454bf59663ea534c038ff11e5dc?fmt=pjpeg&wid=1014&hei=396&bgcolor=F1F5F9&bgc=F1F5F9',
                    'https://www.sony.com.vn/image/ac5fa96c21e64627063fbc957dd8d0f1?fmt=pjpeg&wid=1014&hei=396&bgcolor=F1F5F9&bgc=F1F5F9',
                    'https://www.sony.com.vn/image/2242125f190e23e20bfd75574c83fcff?fmt=pjpeg&wid=1014&hei=396&bgcolor=F1F5F9&bgc=F1F5F9'
                ]
            ),
            $this->makeAccessoryProduct(
                'Tai nghe chụp tai Sony WH-1000XM5',
                'tai-nghe-chup-tai-sony-wh-1000xm5',
                'sony',
                'phu-kien',
                'Bạc',
                '#dcdcdc',
                7990000,
                6990000,
                20,
                'Tai nghe Over-ear chống ồn hàng đầu thị trường của Sony với thiết kế hiện đại và chất âm Hi-Res.',
                [
                    'Công nghệ chống ồn chủ động kép với 8 micro.',
                    'Thời lượng pin khủng lên đến 30 giờ hỗ trợ sạc nhanh.',
                    'Thiết kế mới nhẹ hơn, đeo thoải mái hơn.',
                ],
                $this->accessorySpecs('Sony', 'Tai nghe Over-ear ANC', 'USB-C', 'Mac, Windows, Android, iOS'),
                [
                    'https://www.sony.com.vn/image/6145c1d32e6ac8e63a46c912dc33c5bb?fmt=pjpeg&wid=1014&hei=396&bgcolor=F1F5F9&bgc=F1F5F9',
                    'https://www.sony.com.vn/image/5d105260dd393eb536e14713e778a48d?fmt=pjpeg&wid=1014&hei=396&bgcolor=F1F5F9&bgc=F1F5F9',
                    'https://www.sony.com.vn/image/3bfae6fdeff22a101f3cf9f14debc81c?fmt=pjpeg&wid=1014&hei=396&bgcolor=F1F5F9&bgc=F1F5F9',
                    'https://www.sony.com.vn/image/9a2ccb0ffb33907eb6b783ab60eb76ff?fmt=pjpeg&wid=1014&hei=396&bgcolor=F1F5F9&bgc=F1F5F9'
                ]
            ),
            $this->makeAccessoryProduct(
                'Sạc không dây Anker PowerWave Pad',
                'sac-khong-day-anker-powerwave-pad',
                'anker',
                'phu-kien',
                'Đen',
                '#000000',
                450000,
                350000,
                100,
                'Đế sạc không dây tiêu chuẩn Qi từ Anker, tương thích rộng rãi với nhiều thiết bị smartphone.',
                [
                    'Sạc không dây chuẩn Qi hỗ trợ công suất lên đến 10W.',
                    'Bảo vệ quá nhiệt và kiểm soát nhiệt độ thông minh.',
                    'Thiết kế mỏng nhẹ, đèn LED hiển thị trạng thái sạc.',
                ],
                $this->accessorySpecs('Anker', 'Đế sạc không dây', '10W Max', 'Thiết bị hỗ trợ chuẩn Qi'),
                [
                    'https://cdn.shopify.com/s/files/1/0493/9834/9974/products/A2503011_TD01_1024x1024.jpg',
                    'https://cdn.shopify.com/s/files/1/0493/9834/9974/products/A2503011_TD02_1024x1024.jpg',
                    'https://cdn.shopify.com/s/files/1/0493/9834/9974/products/A2503011_TD03_1024x1024.jpg',
                    'https://cdn.shopify.com/s/files/1/0493/9834/9974/products/A2503011_TD04_1024x1024.jpg'
                ]
            ),
        ];
    }

    private function makePhoneProduct(
        string $name,
        string $slug,
        string $brand,
        string $category,
        string $colorName,
        string $colorCode,
        string $storage,
        int $priceOriginal,
        int $priceSale,
        int $stock,
        string $summary,
        array $sellingPoints,
        array $specifications
    ): array {
        return $this->makeProduct(
            type: 'phone',
            name: $name,
            slug: $slug,
            brand: $brand,
            category: $category,
            storage: $storage,
            colorName: $colorName,
            colorCode: $colorCode,
            priceOriginal: $priceOriginal,
            priceSale: $priceSale,
            stock: $stock,
            summary: $summary,
            sellingPoints: $sellingPoints,
            specifications: $specifications
        );
    }

    private function makeLaptopProduct(
        string $name,
        string $slug,
        string $brand,
        string $category,
        string $colorName,
        string $colorCode,
        string $storage,
        int $priceOriginal,
        int $priceSale,
        int $stock,
        string $summary,
        array $sellingPoints,
        array $specifications
    ): array {
        return $this->makeProduct(
            type: 'laptop',
            name: $name,
            slug: $slug,
            brand: $brand,
            category: $category,
            storage: $storage,
            colorName: $colorName,
            colorCode: $colorCode,
            priceOriginal: $priceOriginal,
            priceSale: $priceSale,
            stock: $stock,
            summary: $summary,
            sellingPoints: $sellingPoints,
            specifications: $specifications
        );
    }

    private function makeDesktopProduct(
        string $name,
        string $slug,
        string $brand,
        string $category,
        string $colorName,
        string $colorCode,
        string $storage,
        int $priceOriginal,
        int $priceSale,
        int $stock,
        string $summary,
        array $sellingPoints,
        array $specifications
    ): array {
        return $this->makeProduct(
            type: 'desktop',
            name: $name,
            slug: $slug,
            brand: $brand,
            category: $category,
            storage: $storage,
            colorName: $colorName,
            colorCode: $colorCode,
            priceOriginal: $priceOriginal,
            priceSale: $priceSale,
            stock: $stock,
            summary: $summary,
            sellingPoints: $sellingPoints,
            specifications: $specifications
        );
    }

    private function makeWatchProduct(
        string $name,
        string $slug,
        string $brand,
        string $category,
        string $colorName,
        string $colorCode,
        string $storage,
        int $priceOriginal,
        int $priceSale,
        int $stock,
        string $summary,
        array $sellingPoints
    ): array {
        return $this->makeProduct(
            type: 'watch',
            name: $name,
            slug: $slug,
            brand: $brand,
            category: $category,
            storage: $storage,
            colorName: $colorName,
            colorCode: $colorCode,
            priceOriginal: $priceOriginal,
            priceSale: $priceSale,
            stock: $stock,
            summary: $summary,
            sellingPoints: $sellingPoints,
            specifications: $this->watchSpecs($storage, 'Apple S10/S9 SiP', 'watchOS', 'GPS/GPS + Cellular')
        );
    }

    private function makeAudioProduct(
        string $name,
        string $slug,
        string $brand,
        string $category,
        string $colorName,
        string $colorCode,
        string $storage,
        int $priceOriginal,
        int $priceSale,
        int $stock,
        string $summary,
        array $sellingPoints
    ): array {
        return $this->makeProduct(
            type: 'audio',
            name: $name,
            slug: $slug,
            brand: $brand,
            category: $category,
            storage: $storage,
            colorName: $colorName,
            colorCode: $colorCode,
            priceOriginal: $priceOriginal,
            priceSale: $priceSale,
            stock: $stock,
            summary: $summary,
            sellingPoints: $sellingPoints,
            specifications: $this->audioSpecs('Bluetooth 5.3', 'ANC/Adaptive Audio', 'USB-C', '6 gio + hop sac')
        );
    }

    private function makeProduct(
        string $type,
        string $name,
        string $slug,
        string $brand,
        string $category,
        string $storage,
        string $colorName,
        string $colorCode,
        int $priceOriginal,
        int $priceSale,
        int $stock,
        string $summary,
        array $sellingPoints,
        array $specifications
    ): array {
        $gallery = $this->imageSet($name, $colorCode);
        $highlights = [
            'Tra gop 0% lai suat cho don hang gia tri cao.',
            'Thu cu doi moi tro gia tuy tinh trang may.',
            'Ho tro setup may, sao luu va chuyen du lieu tai cua hang.',
        ];

        return [
            'name' => $name,
            'slug' => $slug,
            'brand' => $brand,
            'category' => $category,
            'thumbnail' => $gallery[0],
            'images' => $gallery,
            'warranty_policy' => $this->warrantyPolicy($type),
            'return_policy' => 'Doi tra trong 7 ngay neu phat sinh loi phan cung do nha san xuat va ho tro bao hanh chinh hang toan quoc.',
            'highlights' => $highlights,
            'summary' => $summary,
            'description' => $this->descriptionHtml($name, $summary, $sellingPoints, $gallery),
            'status' => Product::STATUS_ACTIVE,
            'is_preorder' => str_contains(Str::lower($slug), '1tb') && $stock < 5,
            'variants' => [
                [
                    'sku' => strtoupper(Str::slug($slug, '')),
                    'storage' => $storage,
                    'color_name' => $colorName,
                    'color_code' => $colorCode,
                    'price_original' => $priceOriginal,
                    'price_sale' => $priceSale,
                    'stock' => $stock,
                ],
            ],
            'specifications' => $specifications,
        ];
    }

    private function imageSet(string $name, string $accent): array
    {
        $query = rawurlencode($name);
        $accentHex = ltrim($accent, '#') ?: '1f2937';

        return [
            "https://placehold.co/1200x1200/{$accentHex}/FFFFFF/png?text={$query}",
            "https://placehold.co/1200x1200/F3F4F6/111827/png?text={$query}%20Front",
            "https://placehold.co/1200x1200/E5E7EB/111827/png?text={$query}%20Back",
            "https://placehold.co/1200x800/FFF7ED/111827/png?text={$query}%20Lifestyle",
        ];
    }

    private function descriptionHtml(string $name, string $summary, array $sellingPoints, array $gallery): string
    {
        $points = collect($sellingPoints)
            ->map(fn (string $point) => '<li>' . e($point) . '</li>')
            ->implode('');

        return implode('', [
            '<h2>Danh gia nhanh ' . e($name) . '</h2>',
            '<p>' . e($summary) . '</p>',
            '<p>' . e($name) . ' la san pham duoc xay dung de danh vao nhom khach can mot thiet bi thuc dung, hinh anh sang va de tu van tren san thuong mai dien tu hoac fanpage. Noi dung seed da duoc viet theo kieu thuong mai de co the dua len website ngay ma khong can bo sung khung mo ta co ban.</p>',
            '<figure><img src="' . e($gallery[1]) . '" alt="' . e($name . ' hinh anh tong quan') . '"><figcaption>Hinh anh mo ta tong quan san pham.</figcaption></figure>',
            '<h3>Diem nhan ban hang</h3>',
            '<ul>' . $points . '</ul>',
            '<p>Ve trai nghiem su dung, ' . e($name) . ' duoc dinh huong de dap ung nhom khach can su on dinh, tinh tham my va hieu nang phu hop trong tam gia. Day cung la ly do bo du lieu seed nay bo sung ca mo ta ngan, mo ta HTML, bien the gia ban va thong so ky thuat day du de shop co the demo giao dien thuc te hon.</p>',
            '<figure><img src="' . e($gallery[3]) . '" alt="' . e($name . ' hinh anh noi dung') . '"><figcaption>Hinh mo ta bo cuc quang cao de chen trong bai viet san pham.</figcaption></figure>',
            '<h3>Phu hop voi doi tuong nao</h3>',
            '<p>San pham phu hop cho khach mua moi, khach nang cap tu doi cu va nguoi can thiet bi chinh hang co cau hinh ro rang, gia ban minh bach va de so sanh giua cac phien ban. Neu dung de demo website, bo du lieu nay cung giup hien thi day du khu vuc gallery, highlights, thong so, mo ta va gia ban.</p>',
        ]);
    }

    private function warrantyPolicy(string $type): string
    {
        return match ($type) {
            'watch', 'audio' => 'Bao hanh chinh hang 12 thang, ho tro kiem tra serial va tiep nhan bao hanh tai cua hang.',
            'desktop' => 'Bao hanh chinh hang 12 thang, ho tro giao lap va kiem tra may tai cua hang.',
            'laptop' => 'Bao hanh chinh hang 12 thang, ho tro cai dat phan mem co ban va kiem tra may truoc khi giao.',
            default => 'Bao hanh chinh hang 12 thang, ho tro chuyen du lieu va kiem tra may truoc khi giao.',
        };
    }

    private function phoneSpecs(
        string $screen,
        string $chip,
        string $ram,
        string $storage,
        string $camera,
        string $battery
    ): array {
        return [
            ['group_name' => 'Man hinh', 'name' => 'Cong nghe man hinh', 'value' => $screen],
            ['group_name' => 'Hieu nang', 'name' => 'Vi xu ly', 'value' => $chip],
            ['group_name' => 'Hieu nang', 'name' => 'RAM', 'value' => $ram],
            ['group_name' => 'Luu tru', 'name' => 'Bo nho trong', 'value' => $storage],
            ['group_name' => 'Camera', 'name' => 'Camera sau', 'value' => $camera],
            ['group_name' => 'Pin & Sac', 'name' => 'Pin va sac', 'value' => $battery],
        ];
    }

    private function laptopSpecs(
        string $screen,
        string $chip,
        string $ram,
        string $storage,
        string $os
    ): array {
        return [
            ['group_name' => 'Man hinh', 'name' => 'Kich thuoc va cong nghe', 'value' => $screen],
            ['group_name' => 'Hieu nang', 'name' => 'Bo xu ly', 'value' => $chip],
            ['group_name' => 'Hieu nang', 'name' => 'RAM', 'value' => $ram],
            ['group_name' => 'Luu tru', 'name' => 'SSD', 'value' => $storage],
            ['group_name' => 'Phan mem', 'name' => 'He dieu hanh', 'value' => $os],
        ];
    }

    private function desktopSpecs(
        string $chip,
        string $ram,
        string $storage,
        string $os,
        string $connectivity
    ): array {
        return [
            ['group_name' => 'Hieu nang', 'name' => 'Bo xu ly', 'value' => $chip],
            ['group_name' => 'Hieu nang', 'name' => 'RAM', 'value' => $ram],
            ['group_name' => 'Luu tru', 'name' => 'SSD', 'value' => $storage],
            ['group_name' => 'Phan mem', 'name' => 'He dieu hanh', 'value' => $os],
            ['group_name' => 'Ket noi', 'name' => 'Ket noi khong day', 'value' => $connectivity],
        ];
    }

    private function watchSpecs(string $size, string $chip, string $os, string $connectivity): array
    {
        return [
            ['group_name' => 'Man hinh', 'name' => 'Kich thuoc', 'value' => $size],
            ['group_name' => 'Hieu nang', 'name' => 'Chip', 'value' => $chip],
            ['group_name' => 'Phan mem', 'name' => 'He dieu hanh', 'value' => $os],
            ['group_name' => 'Ket noi', 'name' => 'Ket noi', 'value' => $connectivity],
            ['group_name' => 'Suc khoe', 'name' => 'Tinh nang', 'value' => 'Theo doi nhip tim, giac ngu, bai tap, canh bao an toan'],
        ];
    }

    private function audioSpecs(string $bluetooth, string $feature, string $charging, string $battery): array
    {
        return [
            ['group_name' => 'Am thanh', 'name' => 'Tinh nang', 'value' => $feature],
            ['group_name' => 'Ket noi', 'name' => 'Bluetooth', 'value' => $bluetooth],
            ['group_name' => 'Pin & Sac', 'name' => 'Cong sac', 'value' => $charging],
            ['group_name' => 'Pin & Sac', 'name' => 'Thoi luong pin', 'value' => $battery],
            ['group_name' => 'Tuong thich', 'name' => 'He sinh thai', 'value' => 'iPhone, iPad, Mac, Apple Watch'],
        ];
    }

    private function makeAccessoryProduct(
        string $name,
        string $slug,
        string $brand,
        string $category,
        string $colorName,
        string $colorCode,
        int $priceOriginal,
        int $priceSale,
        int $stock,
        string $summary,
        array $sellingPoints,
        array $specifications,
        array $images
    ): array {
        $highlights = [
            'Bảo hành chính hãng 12 tháng.',
            'Hỗ trợ đổi trả 1-1 trong 15 ngày nếu có lỗi.',
            'Giao hàng nhanh chóng toàn quốc.',
        ];

        return [
            'name' => $name,
            'slug' => $slug,
            'brand' => $brand,
            'category' => $category,
            'thumbnail' => $images[0],
            'images' => $images,
            'warranty_policy' => 'Bảo hành chính hãng 12 tháng.',
            'return_policy' => 'Đổi trả trong 15 ngày nếu phát sinh lỗi do nhà sản xuất.',
            'highlights' => $highlights,
            'summary' => $summary,
            'description' => $this->descriptionHtml($name, $summary, $sellingPoints, $images),
            'status' => Product::STATUS_ACTIVE,
            'is_preorder' => false,
            'variants' => [
                [
                    'sku' => strtoupper(Str::slug($slug, '')),
                    'storage' => null,
                    'color_name' => $colorName,
                    'color_code' => $colorCode,
                    'price_original' => $priceOriginal,
                    'price_sale' => $priceSale,
                    'stock' => $stock,
                ],
            ],
            'specifications' => $specifications,
        ];
    }

    private function accessorySpecs(string $brand, string $type, string $power, string $compatibility): array
    {
        return [
            ['group_name' => 'Thông tin chung', 'name' => 'Thương hiệu', 'value' => $brand],
            ['group_name' => 'Thông số', 'name' => 'Loại phụ kiện', 'value' => $type],
            ['group_name' => 'Thông số', 'name' => 'Công suất/Pin', 'value' => $power],
            ['group_name' => 'Tương thích', 'name' => 'Thiết bị hỗ trợ', 'value' => $compatibility],
        ];
    }
}
