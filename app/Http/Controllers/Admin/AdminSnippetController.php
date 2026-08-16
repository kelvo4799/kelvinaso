<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Snippet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminSnippetController extends Controller
{
    public function index()
    {
        $page = Page::all();
        $profile = Auth::user()->profile;
        $snippets = Snippet::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.snippets', compact('page', 'profile', 'snippets'));
    }

    public function create()
    {
        $page = Page::all();
        $profile = Auth::user()->profile;

        return view('admin.snippet_detail', [
            'page' => $page,
            'profile' => $profile,
            'snippet' => new Snippet(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:snippets,slug',
            'category' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'code_content' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');

        Snippet::create($validated);

        return redirect()->route('snippets.admin')->with('success', 'Code Snippet created successfully.');
    }

    public function edit($id)
    {
        $page = Page::all();
        $profile = Auth::user()->profile;
        $snippet = Snippet::findOrFail($id);

        return view('admin.snippet_detail', [
            'page' => $page,
            'profile' => $profile,
            'snippet' => $snippet,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $snippet = Snippet::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:snippets,slug,' . $snippet->id,
            'category' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'code_content' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');

        $snippet->update($validated);

        return redirect()->route('snippets.admin')->with('success', 'Code Snippet updated successfully.');
    }

    public function destroy($id)
    {
        $snippet = Snippet::findOrFail($id);
        $snippet->delete();

        return redirect()->route('snippets.admin')->with('success', 'Code Snippet deleted successfully.');
    }
}
