<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'author'])->orderBy('created_at', 'desc');

        if ($request->has('q') && $request->q !== '') {
            $searchTerm = $request->q;
            $query->where('title', 'like', "%{$searchTerm}%");
        }

        if ($request->has('category_id') && $request->category_id !== '') {
            $query->where('post_category_id', $request->category_id);
        }

        $posts = $query->paginate(15)->withQueryString();
        $categories = PostCategory::all();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = PostCategory::where('is_active', true)->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'post_category_id' => 'required|exists:post_categories,id',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_published' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('posts', 'public');
            $validated['thumbnail'] = '/storage/' . $path;
        }

        $validated['author_id'] = Auth::id();
        $validated['is_published'] = $request->has('is_published');
        if ($validated['is_published']) {
            $validated['published_at'] = now();
        }

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Đã thêm bài viết thành công.');
    }

    public function edit(Post $post)
    {
        $categories = PostCategory::where('is_active', true)->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $post->id,
            'post_category_id' => 'required|exists:post_categories,id',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            // Delete old if exists
            if ($post->thumbnail) {
                $oldPath = str_replace('/storage/', '', $post->thumbnail);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('thumbnail')->store('posts', 'public');
            $validated['thumbnail'] = '/storage/' . $path;
        }

        $validated['is_published'] = $request->has('is_published');
        if ($validated['is_published'] && !$post->published_at) {
            $validated['published_at'] = now();
        } elseif (!$validated['is_published']) {
            $validated['published_at'] = null;
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Đã cập nhật bài viết thành công.');
    }

    public function destroy(Post $post)
    {
        if ($post->thumbnail) {
            $oldPath = str_replace('/storage/', '', $post->thumbnail);
            Storage::disk('public')->delete($oldPath);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Đã xóa bài viết thành công.');
    }
}
