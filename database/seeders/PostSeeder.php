<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $authorId = User::query()->where('email', 'admin@gmail.com')->value('id');

        foreach ($this->posts() as $post) {
            Post::query()->updateOrCreate(
                ['slug' => $post['slug']],
                [
                    'post_category_id' => PostCategory::query()->where('slug', $post['category_slug'])->value('id'),
                    'author_id' => $authorId,
                    'title' => $post['title'],
                    'thumbnail' => $post['thumbnail'] ?? null,
                    'excerpt' => $post['excerpt'],
                    'content' => $post['content'],
                    'views' => $post['views'] ?? 0,
                    'is_published' => true,
                    'published_at' => Carbon::parse($post['published_at'] ?? now()),
                ]
            );
        }
    }

    private function posts(): array
    {
        return [
            [
                'category_slug' => 'chinh-sach',
                'slug' => 'huong-dan-mua-hang',
                'title' => 'Hướng dẫn mua hàng tại Tech One',
                'excerpt' => 'Quy trình đặt hàng, xác nhận đơn và nhận hàng khi mua sản phẩm tại Tech One.',
                'content' => <<<'HTML'
<h2>1. Cách đặt hàng</h2>
<p>Khách hàng có thể đặt hàng trực tiếp trên website, qua hotline hoặc đến cửa hàng để được tư vấn sản phẩm phù hợp.</p>
<h2>2. Xác nhận đơn hàng</h2>
<p>Sau khi đặt hàng, đội ngũ Tech One sẽ liên hệ xác nhận thông tin sản phẩm, phiên bản, giá bán, quà tặng và thời gian giao hàng.</p>
<h2>3. Thanh toán</h2>
<p>Tech One hỗ trợ thanh toán chuyển khoản, thanh toán khi nhận hàng và các chương trình trả góp tùy theo từng sản phẩm.</p>
<h2>4. Giao nhận</h2>
<p>Đơn hàng nội thành được ưu tiên giao nhanh. Với đơn tỉnh, sản phẩm sẽ được đóng gói kỹ và gửi qua đơn vị vận chuyển phù hợp.</p>
HTML,
            ],
            [
                'category_slug' => 'chinh-sach',
                'slug' => 'chinh-sach-bao-hanh',
                'title' => 'Chính sách bảo hành tại Tech One',
                'excerpt' => 'Thông tin về bảo hành chính hãng, điều kiện tiếp nhận và thời gian xử lý bảo hành.',
                'content' => <<<'HTML'
<h2>1. Phạm vi bảo hành</h2>
<p>Tất cả sản phẩm chính hãng tại Tech One được áp dụng chính sách bảo hành theo tiêu chuẩn của nhà sản xuất hoặc nhà phân phối.</p>
<h2>2. Điều kiện bảo hành</h2>
<p>Sản phẩm còn thời hạn bảo hành, lỗi phát sinh từ nhà sản xuất và không thuộc nhóm hư hỏng do va đập, vào nước hoặc can thiệp sửa chữa trái phép.</p>
<h2>3. Thời gian xử lý</h2>
<p>Thời gian xử lý phụ thuộc từng hãng. Tech One sẽ hỗ trợ tiếp nhận, kiểm tra và cập nhật tiến độ thường xuyên cho khách hàng.</p>
HTML,
            ],
            [
                'category_slug' => 'chinh-sach',
                'slug' => 'chinh-sach-bao-mat',
                'title' => 'Chính sách bảo mật thông tin',
                'excerpt' => 'Cam kết của Tech One trong việc thu thập, lưu trữ và sử dụng dữ liệu khách hàng an toàn.',
                'content' => <<<'HTML'
<h2>1. Thu thập thông tin</h2>
<p>Tech One chỉ thu thập các thông tin cần thiết để xử lý đơn hàng, chăm sóc khách hàng và cải thiện trải nghiệm mua sắm.</p>
<h2>2. Mục đích sử dụng</h2>
<p>Dữ liệu được dùng để xác nhận đơn hàng, hỗ trợ giao hàng, bảo hành và gửi thông báo liên quan đến dịch vụ nếu khách hàng đồng ý.</p>
<h2>3. Bảo mật dữ liệu</h2>
<p>Chúng tôi không chia sẻ dữ liệu cá nhân cho bên thứ ba ngoài phạm vi phục vụ đơn hàng và luôn áp dụng biện pháp bảo mật phù hợp.</p>
HTML,
            ],
            [
                'category_slug' => 'ho-tro',
                'slug' => 'cau-hoi-thuong-gap',
                'title' => 'Câu hỏi thường gặp',
                'excerpt' => 'Giải đáp nhanh các câu hỏi phổ biến về đặt hàng, thanh toán, giao hàng và bảo hành tại Tech One.',
                'content' => <<<'HTML'
<h2>1. Tech One có hỗ trợ trả góp không?</h2>
<p>Có. Nhiều sản phẩm hỗ trợ trả góp qua thẻ tín dụng hoặc công ty tài chính tùy chương trình tại thời điểm mua.</p>
<h2>2. Tôi có được kiểm tra hàng trước khi nhận không?</h2>
<p>Có thể kiểm tra ngoại quan, tem niêm phong và phụ kiện cơ bản theo quy định giao nhận của từng khu vực.</p>
<h2>3. Mua online có được hỗ trợ bảo hành như mua tại cửa hàng không?</h2>
<p>Có. Mọi sản phẩm chính hãng mua tại Tech One đều được hỗ trợ tiếp nhận bảo hành theo chính sách hiện hành.</p>
HTML,
            ],
        ];
    }
}
