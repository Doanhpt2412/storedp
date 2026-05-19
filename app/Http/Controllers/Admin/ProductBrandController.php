<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('manage-products');

        $brands = ProductBrand::orderBy('order')->orderBy('name')->get();

        return view('admin.product_brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('manage-products');

        return view('admin.product_brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('manage-products');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:product_brands,slug'],
            'logo' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);

        ProductBrand::create([
            'name' => $request->name,
            'slug' => $slug,
            'logo' => $request->logo,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.product-brands.index')->with('success', 'Thêm hãng sản xuất thành công!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        Gate::authorize('manage-products');

        $brand = ProductBrand::findOrFail($id);

        return view('admin.product_brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('manage-products');

        $brand = ProductBrand::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('product_brands', 'slug')->ignore($brand->id)],
            'logo' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);

        $brand->update([
            'name' => $request->name,
            'slug' => $slug,
            'logo' => $request->logo,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.product-brands.index')->with('success', 'Cập nhật hãng sản xuất thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Gate::authorize('manage-products');

        $brand = ProductBrand::findOrFail($id);
        $brand->delete();

        return redirect()->route('admin.product-brands.index')->with('success', 'Xóa hãng sản xuất thành công!');
    }
}
