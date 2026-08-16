<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    public function index(Request $request)
    {
        $page = Page::all();
        $profile = Auth::user()->profile;

        $query = Post::query()->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'published') {
                $query->where('is_published', true);
            } elseif ($request->input('status') === 'draft') {
                $query->where('is_published', false);
            }
        }

        $posts = $query->paginate(12)->withQueryString();

        $stats = [
            'countAll' => Post::count(),
            'countPublished' => Post::where('is_published', true)->count(),
            'countDraft' => Post::where('is_published', false)->count(),
        ];

        return view('admin.blog', compact('page', 'profile', 'posts', 'stats'));
    }

    public function create()
    {
        $page = Page::all();
        $profile = Auth::user()->profile;
        $post = new Post;

        return view('admin.blog_detail', compact('page', 'profile', 'post'));
    }

    public function store(PostRequest $request)
    {
        $validated = $request->validated();

        $slug = $request->filled('slug') ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$count++;
        }

        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $postTemp = new Post;
            $coverImagePath = $postTemp->uploadImage($request->file('cover_image'), 'blog');
        }

        $tagsArray = ! empty($validated['tags'])
            ? array_values(array_filter(array_map('trim', explode(',', $validated['tags']))))
            : [];

        $isPublished = isset($validated['status']) ? in_array($validated['status'], ['published', '1', 'true'], true) : true;

        $post = Post::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?? '',
            'content' => $validated['content'],
            'cover_image' => $coverImagePath,
            'category' => $validated['category'] ?? 'General',
            'tags' => $tagsArray,
            'read_time' => $validated['read_time'] ?? '5 min read',
            'is_published' => $isPublished,
            'published_at' => $isPublished ? now() : null,
        ]);

        return redirect()->route('blog.admin')->with('success', 'Blog post created successfully.');
    }

    public function show(string $slug)
    {
        $page = Page::all();
        $profile = Auth::user()->profile;
        $post = Post::where('slug', $slug)->firstOrFail();

        $tagsString = is_array($post->tags) ? implode(', ', $post->tags) : ($post->tags ?? '');
        $post->formatted_tags = $tagsString;

        return view('admin.blog_detail', compact('page', 'profile', 'post'));
    }

    public function update(string $slug, PostRequest $request)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $validated = $request->validated();

        if ($request->hasFile('cover_image')) {
            $coverImagePath = $post->uploadImage($request->file('cover_image'), 'blog');
        }

        $tagsArray = ! empty($validated['tags'])
            ? array_values(array_filter(array_map('trim', explode(',', $validated['tags']))))
            : [];

        $isPublished = isset($validated['status']) ? in_array((string) $validated['status'], ['published', '1', 'true'], true) : $post->is_published;

        $newSlug = $post->slug;
        if ($request->filled('slug')) {
            $tempSlug = Str::slug($validated['slug']);
            if ($tempSlug !== $post->slug) {
                $orig = $tempSlug;
                $c = 1;
                while (Post::where('slug', $tempSlug)->where('id', '!=', $post->id)->exists()) {
                    $tempSlug = $orig.'-'.$c++;
                }
                $newSlug = $tempSlug;
            }
        }

        $post->update([
            'title' => $validated['title'],
            'slug' => $newSlug,
            'excerpt' => $validated['excerpt'] ?? '',
            'content' => $validated['content'],
            'cover_image' => $coverImagePath ?? $post->cover_image,
            'category' => $validated['category'] ?? 'General',
            'tags' => $tagsArray,
            'read_time' => $validated['read_time'] ?? '5 min read',
            'is_published' => $isPublished,
            'published_at' => ($isPublished && ! $post->published_at) ? now() : $post->published_at,
        ]);

        return redirect()->route('blog.admin')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $post->delete();

        return redirect()->route('blog.admin')->with('success', 'Blog post deleted successfully.');
    }
}
