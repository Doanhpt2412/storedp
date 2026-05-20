<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    public function index()
    {
        $categories = PostCategory::withCount('posts')->orderBy('name')->paginate(15);
        return view('admin.post_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.post_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:post_categories,slug',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->has('is_active');

        PostCategory::create($validated);

        return redirect()->route('admin.post-categories.index')->with('success', 'Đã thêm chuyên mục thành công.');
    }

    public function edit(PostCategory $postCategory)
    {
        return view('admin.post_categories.edit', compact('postCategory'));
    }

    public function update(Request $request, PostCategory $postCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:post_categories,slug,' . $postCategory->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $postCategory->update($validated);

        return redirect()->route('admin.post-categories.index')->with('success', 'Đã cập nhật chuyên mục thành công.');
    }

    public function destroy(PostCategory $postCategory)
    {
        if ($postCategory->posts()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa chuyên mục đang có bài viết.');
        }

        $postCategory->delete();

        return redirect()->route('admin.post-categories.index')->with('success', 'Đã xóa chuyên mục thành công.');
    }
}
