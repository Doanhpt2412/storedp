<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('manage-products');

        // Lấy tất cả danh mục gốc (parent_id = null) kèm theo các con đệ quy để hiển thị cây danh mục
        $categories = ProductCategory::with('allChildren')
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        return view('admin.product_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('manage-products');

        // Lấy danh sách để chọn Danh mục cha (Chỉ lấy phẳng để đưa vào select box)
        $parentCategories = ProductCategory::orderBy('name')->get();

        return view('admin.product_categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('manage-products');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:product_categories,slug'],
            'parent_id' => ['nullable', 'exists:product_categories,id'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'show_in_nav' => ['nullable', 'boolean'],
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);

        ProductCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'parent_id' => $request->parent_id,
            'description' => $request->description,
            'icon' => $request->icon,
            'image' => $request->image,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
            'show_in_nav' => $request->has('show_in_nav'),
        ]);

        return redirect()->route('admin.product-categories.index')->with('success', 'Thêm danh mục sản phẩm thành công!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        Gate::authorize('manage-products');

        $category = ProductCategory::findOrFail($id);
        
        // Lấy tất cả danh mục ngoại trừ chính nó và các con của nó để làm danh mục cha (tránh vòng lặp vô tận)
        $excludeIds = $this->getDescendantIds($category);
        $excludeIds[] = $category->id;

        $parentCategories = ProductCategory::whereNotIn('id', $excludeIds)
            ->orderBy('name')
            ->get();

        return view('admin.product_categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('manage-products');

        $category = ProductCategory::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('product_categories', 'slug')->ignore($category->id)],
            'parent_id' => [
                'nullable', 
                'exists:product_categories,id',
                function ($attribute, $value, $fail) use ($category) {
                    if ($value == $category->id) {
                        $fail('Danh mục cha không thể là chính danh mục hiện tại.');
                    }
                    if (in_array($value, $this->getDescendantIds($category))) {
                        $fail('Danh mục cha không thể là danh mục con của danh mục hiện tại.');
                    }
                }
            ],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'show_in_nav' => ['nullable', 'boolean'],
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'parent_id' => $request->parent_id,
            'description' => $request->description,
            'icon' => $request->icon,
            'image' => $request->image,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
            'show_in_nav' => $request->has('show_in_nav'),
        ]);

        return redirect()->route('admin.product-categories.index')->with('success', 'Cập nhật danh mục sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Gate::authorize('manage-products');

        $category = ProductCategory::findOrFail($id);

        // Đưa các danh mục con trực tiếp lên làm danh mục gốc khi cha bị xóa
        ProductCategory::where('parent_id', $category->id)->update(['parent_id' => null]);

        $category->delete();

        return redirect()->route('admin.product-categories.index')->with('success', 'Xóa danh mục sản phẩm thành công!');
    }

    /**
     * Get IDs of all descendant categories recursively.
     */
    private function getDescendantIds(ProductCategory $category): array
    {
        $ids = [];
        foreach ($category->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->getDescendantIds($child));
        }
        return $ids;
    }
}
