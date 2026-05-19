<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('manage-products');

        $products = Product::with(['brand', 'category', 'variants'])
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('manage-products');

        return view('admin.products.create', [
            'product' => new Product(['status' => Product::STATUS_ACTIVE]),
            'brands' => ProductBrand::where('is_active', true)->orderBy('order')->orderBy('name')->get(),
            'categories' => ProductCategory::where('is_active', true)->orderBy('name')->get(),
            'statuses' => Product::statuses(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('manage-products');

        $data = $this->validatedData($request);

        DB::transaction(function () use ($data, $request) {
            $product = Product::create($this->productPayload($data, $request));
            $this->syncVariants($product, $request->input('variants', []));
            $this->syncSpecifications($product, $request->input('specifications', []));
        });

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        Gate::authorize('manage-products');

        $product->load(['variants', 'specifications']);

        return view('admin.products.edit', [
            'product' => $product,
            'brands' => ProductBrand::where('is_active', true)->orderBy('order')->orderBy('name')->get(),
            'categories' => ProductCategory::where('is_active', true)->orderBy('name')->get(),
            'statuses' => Product::statuses(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        Gate::authorize('manage-products');

        $data = $this->validatedData($request, $product);

        DB::transaction(function () use ($product, $data, $request) {
            $oldImages = $product->images ?? [];
            $payload = $this->productPayload($data, $request, $product);

            if ($request->hasFile('thumbnail_file') && filled($product->thumbnail)) {
                $this->deleteStoredImage($product->thumbnail);
            }

            $product->update($payload);
            $this->deleteRemovedImages($oldImages, $payload['images'] ?? []);
            $this->syncVariants($product, $request->input('variants', []));
            $this->syncSpecifications($product, $request->input('specifications', []));
        });

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Gate::authorize('manage-products');

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    private function validatedData(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product?->id),
            ],
            'product_brand_id' => ['nullable', 'exists:product_brands,id'],
            'product_category_id' => ['nullable', 'exists:product_categories,id'],
            'thumbnail_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'images_files' => ['nullable', 'array'],
            'images_files.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'existing_images' => ['nullable', 'array'],
            'existing_images.*' => ['nullable', 'string', 'max:255'],
            'album_order' => ['nullable', 'array'],
            'album_order.*' => ['nullable', 'string', 'max:255'],
            'warranty_policy' => ['nullable', 'string', 'max:255'],
            'return_policy' => ['nullable', 'string', 'max:255'],
            'highlights_text' => ['nullable', 'string'],
            'summary' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'integer', Rule::in(array_keys(Product::statuses()))],
            'is_preorder' => ['nullable', 'boolean'],
            'variants' => ['nullable', 'array'],
            'variants.*.sku' => ['nullable', 'string', 'max:255'],
            'variants.*.storage' => ['nullable', 'string', 'max:255'],
            'variants.*.color_name' => ['nullable', 'string', 'max:255'],
            'variants.*.color_code' => ['nullable', 'string', 'max:20'],
            'variants.*.price_original' => ['nullable', 'numeric', 'min:0'],
            'variants.*.price_sale' => ['nullable', 'numeric', 'min:0'],
            'variants.*.stock' => ['nullable', 'integer', 'min:0'],
            'specifications' => ['nullable', 'array'],
            'specifications.*.group_name' => ['nullable', 'string', 'max:255'],
            'specifications.*.name' => ['nullable', 'string', 'max:255'],
            'specifications.*.value' => ['nullable', 'string'],
            'specifications.*.sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function productPayload(array $data, Request $request, ?Product $product = null): array
    {
        $thumbnail = $product?->thumbnail;
        if ($request->hasFile('thumbnail_file')) {
            $thumbnail = $this->storeImage($request->file('thumbnail_file'));
        }

        $existingImages = array_values(array_filter($data['existing_images'] ?? ($product?->images ?? [])));
        $uploadedImages = [];
        foreach ($request->file('images_files', []) as $image) {
            if ($image) {
                $uploadedImages[] = $this->storeImage($image);
            }
        }
        $images = $this->orderedImages($data['album_order'] ?? [], $existingImages, $uploadedImages);

        return [
            'name' => $data['name'],
            'slug' => filled($data['slug'] ?? null) ? Str::slug($data['slug']) : Str::slug($data['name']),
            'product_brand_id' => $data['product_brand_id'] ?? null,
            'product_category_id' => $data['product_category_id'] ?? null,
            'thumbnail' => $thumbnail,
            'images' => $images,
            'warranty_policy' => $data['warranty_policy'] ?? null,
            'return_policy' => $data['return_policy'] ?? null,
            'highlights' => $this->linesToArray($data['highlights_text'] ?? null),
            'summary' => $data['summary'] ?? null,
            'description' => $data['description'] ?? null,
            'status' => $data['status'],
            'is_preorder' => ! empty($data['is_preorder']),
        ];
    }

    private function storeImage($file): string
    {
        return Storage::url($file->store('products', 'public'));
    }

    private function deleteStoredImage(string $url): void
    {
        if (! str_starts_with($url, '/storage/')) {
            return;
        }

        Storage::disk('public')->delete(Str::after($url, '/storage/'));
    }

    private function deleteRemovedImages(array $oldImages, array $newImages): void
    {
        foreach (array_diff($oldImages, $newImages) as $image) {
            $this->deleteStoredImage($image);
        }
    }

    private function orderedImages(array $order, array $existingImages, array $uploadedImages): array
    {
        if (empty($order)) {
            return [...$existingImages, ...$uploadedImages];
        }

        $images = [];
        foreach ($order as $item) {
            if (str_starts_with($item, 'existing:')) {
                $image = Str::after($item, 'existing:');
                if (in_array($image, $existingImages, true)) {
                    $images[] = $image;
                }
            }

            if (str_starts_with($item, 'new:')) {
                $index = (int) Str::after($item, 'new:');
                if (isset($uploadedImages[$index])) {
                    $images[] = $uploadedImages[$index];
                }
            }
        }

        return array_values(array_unique([...$images, ...$existingImages, ...$uploadedImages]));
    }

    private function syncVariants(Product $product, array $variants): void
    {
        $product->variants()->delete();

        foreach ($variants as $variant) {
            if (! filled($variant['sku'] ?? null)) {
                continue;
            }

            $product->variants()->create([
                'sku' => $variant['sku'],
                'storage' => $variant['storage'] ?? null,
                'color_name' => $variant['color_name'] ?? null,
                'color_code' => $variant['color_code'] ?? null,
                'price_original' => $variant['price_original'] ?? 0,
                'price_sale' => $variant['price_sale'] ?? null,
                'stock' => $variant['stock'] ?? 0,
            ]);
        }
    }

    private function syncSpecifications(Product $product, array $specifications): void
    {
        $product->specifications()->delete();

        foreach ($specifications as $specification) {
            if (! filled($specification['group_name'] ?? null) || ! filled($specification['name'] ?? null)) {
                continue;
            }

            $product->specifications()->create([
                'group_name' => $specification['group_name'],
                'name' => $specification['name'],
                'value' => $specification['value'] ?? null,
                'sort_order' => $specification['sort_order'] ?? 0,
            ]);
        }
    }

    private function linesToArray(?string $value): array
    {
        if (! filled($value)) {
            return [];
        }

        return collect(preg_split('/\r\n|\r|\n/', $value))
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
