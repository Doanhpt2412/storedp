<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Support\ProductCatalog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function __invoke(Request $request, ProductCatalog $catalog): View
    {
        $query = trim((string) ($request->query('s') ?? $request->query('q') ?? ''));
        $normalizedQuery = Str::lower(Str::ascii($query));

        $products = collect($catalog->listingProducts())
            ->filter(function (array $product) use ($normalizedQuery): bool {
                if ($normalizedQuery === '') {
                    return false;
                }

                $haystack = Str::lower(Str::ascii(implode(' ', [
                    $product['name'] ?? '',
                    $product['brand'] ?? '',
                    $product['brand_label'] ?? '',
                    $product['category'] ?? '',
                    $product['line_label'] ?? '',
                    $product['series_label'] ?? '',
                    $product['model_label'] ?? '',
                    $product['storage'] ?? '',
                    $product['color'] ?? '',
                ])));

                return str_contains($haystack, $normalizedQuery);
            })
            ->values();

        $categories = $this->matchedCategories($normalizedQuery, $catalog);

        return view('frontend.search.index', [
            'navCategories' => $catalog->navCategories(),
            'query' => $query,
            'products' => $products->all(),
            'categories' => $categories,
            'totalResults' => $products->count() + count($categories),
        ]);
    }

    private function matchedCategories(string $normalizedQuery, ProductCatalog $catalog): array
    {
        if ($normalizedQuery === '') {
            return [];
        }

        $taxonomy = collect($catalog->taxonomyIndex());

        return ProductCategory::where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get()
            ->filter(function (ProductCategory $category) use ($normalizedQuery): bool {
                $haystack = Str::lower(Str::ascii($category->name . ' ' . $category->slug . ' ' . $category->description));

                return str_contains($haystack, $normalizedQuery);
            })
            ->map(function (ProductCategory $category) use ($taxonomy): array {
                $node = $taxonomy->firstWhere('slug', $category->slug);

                return [
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'path' => $node['path'] ?? $category->slug,
                    'description' => $category->description,
                    'level' => $node['level'] ?? 1,
                ];
            })
            ->values()
            ->all();
    }
}
