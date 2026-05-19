<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\ProductCatalog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    public function show(Request $request, ProductCatalog $catalog, ?string $path = null): View
    {
        $currentPath = trim((string) $path, '/');
        $currentNode = $catalog->findTaxonomyPath($currentPath);

        if (! $currentNode) {
            throw new NotFoundHttpException();
        }

        $baseProducts = collect($catalog->listingProducts())
            ->filter(function (array $product) use ($currentPath): bool {
                if ($currentPath === '') {
                    return true;
                }

                return str_starts_with($product['taxonomy_path'], $currentPath);
            })
            ->values();

        $products = $this->applyFilters($baseProducts, $request);
        $filters = $this->buildFilters($baseProducts);
        $childPaths = $catalog->childTaxonomyPaths($currentPath);

        return view('frontend.categories.show', [
            'navCategories' => $catalog->navCategories(),
            'currentNode' => $currentNode,
            'childPaths' => $childPaths,
            'filters' => $filters,
            'products' => $products->values()->all(),
            'query' => (string) $request->string('q'),
            'selectedFilters' => [
                'brand' => $request->string('brand')->toString(),
                'line' => $request->string('line')->toString(),
                'series' => $request->string('series')->toString(),
                'price' => $request->string('price')->toString(),
                'sort' => $request->string('sort')->toString(),
            ],
        ]);
    }

    private function applyFilters(Collection $products, Request $request): Collection
    {
        $search = mb_strtolower(trim((string) $request->string('q')));
        $brand = $request->string('brand')->toString();
        $line = $request->string('line')->toString();
        $series = $request->string('series')->toString();
        $price = $request->string('price')->toString();
        $sort = $request->string('sort')->toString();

        $filtered = $products->filter(function (array $product) use ($search, $brand, $line, $series, $price): bool {
            if ($search !== '' && ! str_contains(mb_strtolower($product['name']), $search)) {
                return false;
            }

            if ($brand !== '' && $product['brand_slug'] !== $brand) {
                return false;
            }

            if ($line !== '' && $product['line_slug'] !== $line) {
                return false;
            }

            if ($series !== '' && $product['series_slug'] !== $series) {
                return false;
            }

            return match ($price) {
                'under-20' => $product['price_value'] < 20000000,
                '20-30' => $product['price_value'] >= 20000000 && $product['price_value'] <= 30000000,
                'over-30' => $product['price_value'] > 30000000,
                default => true,
            };
        });

        return match ($sort) {
            'price-asc' => $filtered->sortBy('price_value'),
            'price-desc' => $filtered->sortByDesc('price_value'),
            'name-asc' => $filtered->sortBy('name'),
            default => $filtered,
        };
    }

    private function buildFilters(Collection $products): array
    {
        $uniqueOptions = function (string $slugField, string $labelField) use ($products): array {
            return $products
                ->map(fn (array $product) => [
                    'slug' => $product[$slugField],
                    'label' => $product[$labelField],
                ])
                ->filter(fn (array $item) => filled($item['slug']) && filled($item['label']))
                ->unique('slug')
                ->values()
                ->all();
        };

        return [
            'brands' => $uniqueOptions('brand_slug', 'brand_label'),
            'lines' => $uniqueOptions('line_slug', 'line_label'),
            'series' => $uniqueOptions('series_slug', 'series_label'),
            'prices' => [
                ['slug' => 'under-20', 'label' => 'Duoi 20 trieu'],
                ['slug' => '20-30', 'label' => 'Tu 20 den 30 trieu'],
                ['slug' => 'over-30', 'label' => 'Tren 30 trieu'],
            ],
        ];
    }
}
