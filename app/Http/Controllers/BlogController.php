<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $enabled = setting('enable_blog', '1');
        if ($enabled === '0') {
            return redirect()->route('home');
        }

        $page = Page::where('slug', 'blog')->first() ?? Page::where('slug', 'home')->first();

        $query = Post::where('is_published', true)->orderBy('published_at', 'desc')->orderBy('created_at', 'desc');

        if ($request->filled('category') && $request->input('category') !== 'All') {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(9)->withQueryString();

        $categories = Post::where('is_published', true)->distinct()->pluck('category')->filter()->values()->all();

        return view('blog', compact('page', 'posts', 'categories'));
    }

    public function show($slug)
    {
        $page = Page::where('slug', 'blog')->first() ?? Page::where('slug', 'home')->first();

        $post = Post::where('slug', $slug)->firstOrFail();

        // Increment view counter
        $post->increment('views_count');

        $relatedPosts = Post::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->take(3)
            ->get();

        if ($relatedPosts->isEmpty()) {
            $relatedPosts = Post::where('is_published', true)
                ->where('id', '!=', $post->id)
                ->take(3)
                ->get();
        }

        return view('blog_detail', compact('page', 'post', 'relatedPosts'));
    }
}
