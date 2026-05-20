<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class SiteSettings
{
    private const CACHE_KEY = 'site_settings.payload';

    public function all(): array
    {
        if (! Schema::hasTable('site_settings')) {
            return [];
        }

        return Cache::rememberForever(self::CACHE_KEY, function (): array {
            return SiteSetting::query()
                ->get(['key', 'value'])
                ->mapWithKeys(fn (SiteSetting $setting) => [
                    $setting->key => is_array($setting->value) ? $setting->value : [],
                ])
                ->all();
        });
    }

    public function group(string $key, array $default = []): array
    {
        return $this->all()[$key] ?? $default;
    }

    public function putMany(array $groups): void
    {
        foreach ($groups as $key => $value) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        Cache::forget(self::CACHE_KEY);
    }
}
