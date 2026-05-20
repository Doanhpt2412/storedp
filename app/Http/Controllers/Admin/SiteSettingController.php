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

class SiteSettingController extends Controller
{
    public function edit(SiteSettings $settings): View
    {
        Gate::authorize('manage-users');

        return view('admin.settings.general', [
            'settings' => [
                'site' => array_merge($this->defaultSiteSettings(), $settings->group('site')),
                'seo' => array_merge($this->defaultSeoSettings(), $settings->group('seo')),
                'contact' => array_merge($this->defaultContactSettings(), $settings->group('contact')),
                'header_menu' => $settings->group('header_menu', $this->defaultHeaderMenu()),
                'footer' => array_merge($this->defaultFooterSettings(), $settings->group('footer')),
            ],
        ]);
    }

    public function update(Request $request, SiteSettings $settings): RedirectResponse
    {
        Gate::authorize('manage-users');

        $data = $request->validate([
            'site.site_name' => ['required', 'string', 'max:255'],
            'site.site_tagline' => ['nullable', 'string', 'max:255'],
            'site.logo_alt' => ['nullable', 'string', 'max:255'],
            'site.logo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'site.favicon_file' => ['nullable', 'image', 'mimes:png,ico,webp', 'max:2048'],
            'seo.meta_title' => ['nullable', 'string', 'max:255'],
            'seo.meta_description' => ['nullable', 'string', 'max:1000'],
            'seo.meta_keywords' => ['nullable', 'string', 'max:1000'],
            'seo.og_image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'contact.hotline' => ['nullable', 'string', 'max:100'],
            'contact.email' => ['nullable', 'email', 'max:255'],
            'contact.address' => ['nullable', 'string', 'max:255'],
            'contact.working_hours' => ['nullable', 'string', 'max:255'],
            'header_menu' => ['nullable', 'string'],
            'footer.about_title' => ['nullable', 'string', 'max:255'],
            'footer.about_links' => ['nullable', 'array'],
            'footer.about_links.*.label' => ['nullable', 'string', 'max:255'],
            'footer.about_links.*.url' => ['nullable', 'string', 'max:255'],
            'footer.policy_title' => ['nullable', 'string', 'max:255'],
            'footer.policy_links' => ['nullable', 'array'],
            'footer.policy_links.*.label' => ['nullable', 'string', 'max:255'],
            'footer.policy_links.*.url' => ['nullable', 'string', 'max:255'],
            'footer.support_title' => ['nullable', 'string', 'max:255'],
            'footer.support_links' => ['nullable', 'array'],
            'footer.support_links.*.label' => ['nullable', 'string', 'max:255'],
            'footer.support_links.*.url' => ['nullable', 'string', 'max:255'],
            'footer.copyright_text' => ['nullable', 'string', 'max:255'],
        ]);

        $existingSite = array_merge($this->defaultSiteSettings(), $settings->group('site'));
        $existingSeo = array_merge($this->defaultSeoSettings(), $settings->group('seo'));

        $site = [
            'site_name' => $data['site']['site_name'],
            'site_tagline' => $data['site']['site_tagline'] ?? null,
            'logo_alt' => $data['site']['logo_alt'] ?? null,
            'logo_url' => $existingSite['logo_url'] ?? null,
            'favicon_url' => $existingSite['favicon_url'] ?? null,
        ];

        $seo = [
            'meta_title' => $data['seo']['meta_title'] ?? null,
            'meta_description' => $data['seo']['meta_description'] ?? null,
            'meta_keywords' => $data['seo']['meta_keywords'] ?? null,
            'og_image_url' => $existingSeo['og_image_url'] ?? null,
        ];

        if ($request->hasFile('site.logo_file')) {
            $site['logo_url'] = $this->replaceAsset($existingSite['logo_url'] ?? null, $request->file('site.logo_file'));
        }

        if ($request->hasFile('site.favicon_file')) {
            $site['favicon_url'] = $this->replaceAsset($existingSite['favicon_url'] ?? null, $request->file('site.favicon_file'));
        }

        if ($request->hasFile('seo.og_image_file')) {
            $seo['og_image_url'] = $this->replaceAsset($existingSeo['og_image_url'] ?? null, $request->file('seo.og_image_file'));
        }

        $settings->putMany([
            'site' => $site,
            'seo' => $seo,
            'contact' => [
                'hotline' => $data['contact']['hotline'] ?? null,
                'email' => $data['contact']['email'] ?? null,
                'address' => $data['contact']['address'] ?? null,
                'working_hours' => $data['contact']['working_hours'] ?? null,
            ],
            'header_menu' => $this->parseMenuLines($data['header_menu'] ?? ''),
            'footer' => [
                'about_title' => $data['footer']['about_title'] ?? 'Tech One',
                'about_links' => $this->normalizeLinkItems($data['footer']['about_links'] ?? []),
                'policy_title' => $data['footer']['policy_title'] ?? 'Chinh sach',
                'policy_links' => $this->normalizeLinkItems($data['footer']['policy_links'] ?? []),
                'support_title' => $data['footer']['support_title'] ?? 'Ho tro',
                'support_links' => $this->normalizeLinkItems($data['footer']['support_links'] ?? []),
                'copyright_text' => $data['footer']['copyright_text'] ?? null,
            ],
        ]);

        return back()->with('success', 'Da cap nhat cau hinh website.');
    }

    private function parseMenuLines(string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $value))
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->map(function (string $line): array {
                [$label, $url] = array_pad(explode('|', $line, 2), 2, '');

                return [
                    'label' => trim($label),
                    'url' => trim($url),
                ];
            })
            ->filter(fn (array $item) => filled($item['label']) && filled($item['url']))
            ->values()
            ->all();
    }

    private function normalizeLinkItems(array $items): array
    {
        return collect($items)
            ->map(fn ($item) => [
                'label' => trim((string) ($item['label'] ?? '')),
                'url' => trim((string) ($item['url'] ?? '')),
            ])
            ->filter(fn (array $item) => filled($item['label']) && filled($item['url']))
            ->values()
            ->all();
    }

    private function replaceAsset(?string $oldUrl, $file): string
    {
        $this->deleteStoredAsset($oldUrl);

        return Storage::url($file->store('settings', 'public'));
    }

    private function deleteStoredAsset(?string $url): void
    {
        if (! $url || ! str_starts_with($url, '/storage/')) {
            return;
        }

        Storage::disk('public')->delete(Str::after($url, '/storage/'));
    }

    private function defaultSiteSettings(): array
    {
        return [
            'site_name' => 'Tech One',
            'site_tagline' => 'Tech One',
            'logo_alt' => 'Tech One',
            'logo_url' => null,
            'favicon_url' => null,
        ];
    }

    private function defaultSeoSettings(): array
    {
        return [
            'meta_title' => 'Tech One',
            'meta_description' => 'Tech One - cua hang cong nghe, dien thoai, laptop va phu kien chinh hang.',
            'meta_keywords' => 'tech one, dien thoai, laptop, phu kien, cong nghe',
            'og_image_url' => null,
        ];
    }

    private function defaultContactSettings(): array
    {
        return [
            'hotline' => '0246 6819 779',
            'email' => null,
            'address' => '388 Cau Giay - P. Dich Vong - Q. Cau Giay - TP. Ha Noi',
            'working_hours' => '08:00 - 22:00 moi ngay',
        ];
    }

    private function defaultHeaderMenu(): array
    {
        return [
            ['label' => 'Tin tuc cong nghe', 'url' => route('blog.index')],
        ];
    }

    private function defaultFooterSettings(): array
    {
        return [
            'about_title' => 'Tech One',
            'about_links' => [],
            'policy_title' => 'Chinh sach',
            'policy_links' => [],
            'support_title' => 'Ho tro',
            'support_links' => [],
            'copyright_text' => '© 2026 Tech One. Tat ca cac quyen duoc bao luu.',
        ];
    }
}
