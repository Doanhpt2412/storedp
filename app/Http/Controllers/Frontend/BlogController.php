<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $categories = PostCategory::where('is_active', true)->withCount(['posts' => function($q) {
            $q->where('is_published', true);
        }])->get();

        $posts = Post::with(['category', 'author'])
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $popularPosts = Post::where('is_published', true)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        $featuredPost = $posts->first();

        return view('frontend.blog.index', compact('categories', 'posts', 'popularPosts', 'featuredPost'));
    }

    public function category($category_slug)
    {
        $category = PostCategory::where('slug', $category_slug)->firstOrFail();

        $categories = PostCategory::where('is_active', true)->withCount(['posts' => function($q) {
            $q->where('is_published', true);
        }])->get();

        $posts = Post::with(['category', 'author'])
            ->where('post_category_id', $category->id)
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $popularPosts = Post::where('is_published', true)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        return view('frontend.blog.index', compact('categories', 'posts', 'popularPosts', 'category'));
    }

    public function show($category_slug, $post_slug)
    {
        $post = Post::with(['category', 'author'])
            ->where('slug', $post_slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment views
        $post->increment('views');

        $categories = PostCategory::where('is_active', true)->get();

        $relatedPosts = Post::with('category')
            ->where('post_category_id', $post->post_category_id)
            ->where('id', '!=', $post->id)
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('frontend.blog.show', compact('post', 'categories', 'relatedPosts'));
    }
}
