<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Settings;
use App\Models\Snippet;
use Illuminate\Http\Request;

class SnippetController extends Controller
{
    public function index()
    {
        $enabled = setting('enable_snippets', '1');
        if ($enabled === '0') {
            return redirect()->route('home');
        }

        $page = Page::where('slug', 'home')->first();
        $snippets = Snippet::where('is_active', true)->orderBy('created_at', 'desc')->paginate(9);

        return view('snippets', compact('page', 'snippets'));
    }

    public function show($slug)
    {
        $enabled = setting('enable_snippets', '1');
        if ($enabled === '0') {
            return redirect()->route('home');
        }

        $page = Page::where('slug', 'home')->first();
        $snippet = Snippet::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('snippet_detail', compact('page', 'snippet'));
    }
}
