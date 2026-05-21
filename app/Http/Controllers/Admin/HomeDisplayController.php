<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteSettings;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HomeDisplayController extends Controller
{
    public function edit(SiteSettings $settings): View
    {
        Gate::authorize('manage-users');

        return view('admin.home-display.edit', [
            'slides' => $settings->group('hero_slides', $this->defaultHeroSlides()),
            'banners' => $settings->group('home_banners', $this->defaultHomeBanners()),
        ]);
    }

    public function update(Request $request, SiteSettings $settings): RedirectResponse
    {
        Gate::authorize('manage-users');

        $data = $request->validate([
            'hero_slides' => ['nullable', 'array'],
            'hero_slides.*.eyebrow' => ['nullable', 'string', 'max:120'],
            'hero_slides.*.title' => ['nullable', 'string', 'max:255'],
            'hero_slides.*.description' => ['nullable', 'string', 'max:1000'],
            'hero_slides.*.primary_label' => ['nullable', 'string', 'max:120'],
            'hero_slides.*.primary_url' => ['nullable', 'string', 'max:255'],
            'hero_slides.*.secondary_label' => ['nullable', 'string', 'max:120'],
            'hero_slides.*.secondary_url' => ['nullable', 'string', 'max:255'],
            'hero_slides.*.highlight_label' => ['nullable', 'string', 'max:120'],
            'hero_slides.*.highlight_text' => ['nullable', 'string', 'max:255'],
            'hero_slides.*.card_title' => ['nullable', 'string', 'max:255'],
            'hero_slides.*.card_text' => ['nullable', 'string', 'max:500'],
            'hero_slides.*.image_url' => ['nullable', 'string', 'max:255'],
            'hero_slides.*.image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'home_banners' => ['nullable', 'array'],
            'home_banners.*.eyebrow' => ['nullable', 'string', 'max:120'],
            'home_banners.*.title' => ['nullable', 'string', 'max:255'],
            'home_banners.*.url' => ['nullable', 'string', 'max:255'],
            'home_banners.*.image_url' => ['nullable', 'string', 'max:255'],
            'home_banners.*.image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $existingSlides = $settings->group('hero_slides', $this->defaultHeroSlides());
        $existingBanners = $settings->group('home_banners', $this->defaultHomeBanners());

        $slides = $this->normalizeHeroSlides(
            $data['hero_slides'] ?? [],
            $request->file('hero_slides', []),
            $existingSlides,
        );

        $banners = $this->normalizeHomeBanners(
            $data['home_banners'] ?? [],
            $request->file('home_banners', []),
            $existingBanners,
        );

        $settings->putMany([
            'hero_slides' => $slides,
            'home_banners' => $banners,
        ]);

        return back()->with('success', 'Đã cập nhật slide và banner trang chủ.');
    }

    private function normalizeHeroSlides(array $items, array $uploadedFiles, array $existingSlides): array
    {
        $usedImages = [];

        $slides = collect($items)
            ->map(function ($item, $index) use ($uploadedFiles, $existingSlides, &$usedImages) {
                $imageUrl = trim((string) ($item['image_url'] ?? ($existingSlides[$index]['image_url'] ?? '')));
                $uploadedImage = $uploadedFiles[$index]['image_file'] ?? null;

                if ($uploadedImage) {
                    $imageUrl = $this->replaceAsset($imageUrl, $uploadedImage);
                }

                if (filled($imageUrl)) {
                    $usedImages[] = $imageUrl;
                }

                return [
                    'eyebrow' => trim((string) ($item['eyebrow'] ?? '')),
                    'title' => trim((string) ($item['title'] ?? '')),
                    'description' => trim((string) ($item['description'] ?? '')),
                    'primary_label' => trim((string) ($item['primary_label'] ?? '')),
                    'primary_url' => trim((string) ($item['primary_url'] ?? '')),
                    'secondary_label' => trim((string) ($item['secondary_label'] ?? '')),
                    'secondary_url' => trim((string) ($item['secondary_url'] ?? '')),
                    'highlight_label' => trim((string) ($item['highlight_label'] ?? '')),
                    'highlight_text' => trim((string) ($item['highlight_text'] ?? '')),
                    'card_title' => trim((string) ($item['card_title'] ?? '')),
                    'card_text' => trim((string) ($item['card_text'] ?? '')),
                    'image_url' => $imageUrl,
                ];
            })
            ->filter(fn (array $item) => filled($item['title']) && filled($item['description']))
            ->values()
            ->all();

        $this->deleteRemovedAssets($existingSlides, $usedImages);

        return $slides !== [] ? $slides : $this->defaultHeroSlides();
    }

    private function normalizeHomeBanners(array $items, array $uploadedFiles, array $existingBanners): array
    {
        $usedImages = [];

        $banners = collect($items)
            ->map(function ($item, $index) use ($uploadedFiles, $existingBanners, &$usedImages) {
                $imageUrl = trim((string) ($item['image_url'] ?? ($existingBanners[$index]['image_url'] ?? '')));
                $uploadedImage = $uploadedFiles[$index]['image_file'] ?? null;

                if ($uploadedImage) {
                    $imageUrl = $this->replaceAsset($imageUrl, $uploadedImage);
                }

                if (filled($imageUrl)) {
                    $usedImages[] = $imageUrl;
                }

                return [
                    'eyebrow' => trim((string) ($item['eyebrow'] ?? '')),
                    'title' => trim((string) ($item['title'] ?? '')),
                    'url' => trim((string) ($item['url'] ?? '')),
                    'image_url' => $imageUrl,
                ];
            })
            ->filter(fn (array $item) => filled($item['title']))
            ->values()
            ->all();

        $this->deleteRemovedAssets($existingBanners, $usedImages);

        return $banners !== [] ? $banners : $this->defaultHomeBanners();
    }

    private function deleteRemovedAssets(array $existingItems, array $usedImages): void
    {
        collect($existingItems)
            ->pluck('image_url')
            ->filter()
            ->reject(fn (string $url) => in_array($url, $usedImages, true))
            ->each(fn (string $url) => $this->deleteStoredAsset($url));
    }

    private function replaceAsset(?string $oldUrl, $file): string
    {
        $this->deleteStoredAsset($oldUrl);

        return Storage::url($file->store('settings/home', 'public'));
    }

    private function deleteStoredAsset(?string $url): void
    {
        if (! $url || ! str_starts_with($url, '/storage/')) {
            return;
        }

        Storage::disk('public')->delete(Str::after($url, '/storage/'));
    }

    private function defaultHeroSlides(): array
    {
        return [
            [
                'eyebrow' => 'Apple Flagship',
                'title' => 'iPhone 16 Series gia tot, len doi nhanh tai Tech One.',
                'description' => 'Tap trung vao nhom may cao cap, tro gia thu cu doi moi va qua tang phu kien cho nhu cau nang cap moi ngay.',
                'primary_label' => 'Mua iPhone ngay',
                'primary_url' => route('search', ['q' => 'iphone 16']),
                'secondary_label' => 'Xem dien thoai',
                'secondary_url' => route('categories.show', ['path' => 'dien-thoai']),
                'highlight_label' => 'Uu dai noi bat',
                'highlight_text' => 'Giao nhanh 2 gio noi thanh',
                'card_title' => 'Bo suu tap iPhone chinh hang',
                'card_text' => 'Nhieu phien ban mau, ho tro tra gop linh hoat va giao may nhanh trong ngay.',
                'image_url' => null,
            ],
            [
                'eyebrow' => 'MacBook M4',
                'title' => 'Laptop cho hoc tap va sang tao voi hieu nang on dinh.',
                'description' => 'Phu hop cho sinh vien, dan van phong va creator voi cau hinh M4, RAM 16GB, SSD toc do cao va san hang.',
                'primary_label' => 'Chon MacBook',
                'primary_url' => route('search', ['q' => 'macbook m4']),
                'secondary_label' => 'Xem laptop',
                'secondary_url' => route('categories.show', ['path' => 'laptop']),
                'highlight_label' => 'Qua tang them',
                'highlight_text' => 'Tang tui chong soc va phan mem van phong',
                'card_title' => 'MacBook Air va Pro the he moi',
                'card_text' => 'Thiet ke mong nhe, pin ben va phu hop cho ca cong viec lan giai tri dai gio.',
                'image_url' => null,
            ],
        ];
    }

    private function defaultHomeBanners(): array
    {
        return [
            [
                'eyebrow' => 'Tra gop 0%',
                'title' => 'Mua truoc, thanh toan linh hoat',
                'url' => route('checkout.index'),
                'image_url' => null,
            ],
            [
                'eyebrow' => 'Thu cu doi moi',
                'title' => 'Len doi nhanh, tro gia minh bach',
                'url' => route('search', ['q' => 'thu cu doi moi']),
                'image_url' => null,
            ],
        ];
    }
}
