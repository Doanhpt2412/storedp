<?php

namespace App\Support;

use Illuminate\Contracts\Cookie\QueueingFactory as CookieFactory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

class CartManager
{
    private const COOKIE_NAME = 'storedp_cart';
    private const COOKIE_MINUTES = 43200;
    private ?array $itemsCache = null;

    public function __construct(
        private readonly Request $request,
        private readonly CookieFactory $cookies,
    ) {
    }

    public function items(): array
    {
        if ($this->itemsCache !== null) {
            return $this->itemsCache;
        }

        $payload = $this->request->cookie(self::COOKIE_NAME, '[]');
        $items = json_decode($payload, true);

        if (! is_array($items)) {
            return $this->itemsCache = [];
        }

        return $this->itemsCache = array_values(array_map(function (array $item): array {
            if ((int) ($item['price_value'] ?? 0) <= 0 && ! empty($item['price'])) {
                $item['price_value'] = $this->parsePriceValue($item['price']);
            }

            return $item;
        }, array_filter($items, fn ($item) => is_array($item) && isset($item['line_id']))));
    }

    public function count(): int
    {
        return array_sum(array_map(
            fn (array $item) => (int) ($item['quantity'] ?? 0),
            $this->items()
        ));
    }

    public function subtotal(): int
    {
        return array_sum(array_map(
            fn (array $item) => ((int) ($item['price_value'] ?? 0)) * ((int) ($item['quantity'] ?? 0)),
            $this->items()
        ));
    }

    public function add(array $product, int $quantity = 1, array $selection = []): Cookie
    {
        $items = $this->items();
        $item = $this->buildItem($product, max(1, $quantity), $selection);
        $existingIndex = $this->findIndex($items, $item['line_id']);

        if ($existingIndex !== null) {
            $items[$existingIndex]['quantity'] += $item['quantity'];
        } else {
            $items[] = $item;
        }

        $this->itemsCache = array_values($items);

        return $this->cookie($items);
    }

    public function update(string $lineId, int $quantity): Cookie
    {
        $items = $this->items();
        $index = $this->findIndex($items, $lineId);

        if ($index === null) {
            return $this->cookie($items);
        }

        if ($quantity <= 0) {
            unset($items[$index]);

            $items = array_values($items);
            $this->itemsCache = $items;

            return $this->cookie($items);
        }

        $items[$index]['quantity'] = $quantity;
        $this->itemsCache = array_values($items);

        return $this->cookie($items);
    }

    public function remove(string $lineId): Cookie
    {
        $items = array_values(array_filter(
            $this->items(),
            fn (array $item) => $item['line_id'] !== $lineId
        ));

        $this->itemsCache = $items;

        return $this->cookie($items);
    }

    public function clear(): Cookie
    {
        $this->itemsCache = [];

        return $this->cookie([]);
    }

    public function formatPrice(int $amount): string
    {
        return number_format($amount, 0, ',', '.') . 'đ';
    }

    private function buildItem(array $product, int $quantity, array $selection): array
    {
        $storage = $selection['storage'] ?: ($product['storage'] ?? '');
        $color = $selection['color'] ?: ($product['color'] ?? '');
        $sku = $selection['sku'] ?: ($product['sku'] ?? $product['slug']);
        $priceValue = (int) ($selection['price_value'] ?? $product['price_value'] ?? 0);
        $price = $selection['price'] ?: ($product['price'] ?? $this->formatPrice($priceValue));
        $oldPrice = $selection['old_price'] ?: ($product['old_price'] ?? '');
        $discount = $selection['discount'] ?: ($product['discount'] ?? '');
        $lineId = md5(implode('|', [$product['slug'], $sku, $storage, $color]));

        return [
            'line_id' => $lineId,
            'slug' => $product['slug'],
            'name' => $product['name'],
            'image' => $product['image'] ?? '',
            'sku' => $sku,
            'brand' => $product['brand'] ?? '',
            'storage' => $storage,
            'color' => $color,
            'price' => $price,
            'old_price' => $oldPrice,
            'discount' => $discount,
            'price_value' => $priceValue,
            'quantity' => $quantity,
        ];
    }

    private function findIndex(array $items, string $lineId): ?int
    {
        foreach ($items as $index => $item) {
            if (($item['line_id'] ?? null) === $lineId) {
                return $index;
            }
        }

        return null;
    }

    private function cookie(array $items): Cookie
    {
        return $this->cookies->make(
            self::COOKIE_NAME,
            json_encode(array_values($items), JSON_UNESCAPED_UNICODE),
            self::COOKIE_MINUTES
        );
    }

    private function parsePriceValue(?string $formattedPrice): int
    {
        if (! $formattedPrice) {
            return 0;
        }

        return (int) preg_replace('/[^\d]/', '', $formattedPrice);
    }
}
