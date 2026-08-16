<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Stack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminStackController extends Controller
{
    public function index()
    {
        $page = Page::all();
        $profile = Auth::user()->profile;
        $stacks = Stack::orderBy('type')->orderBy('name')->paginate(12);

        return view('admin.stacks', compact('page', 'profile', 'stacks'));
    }

    public function create()
    {
        $page = Page::all();
        $profile = Auth::user()->profile;

        return view('admin.stack_detail', [
            'page' => $page,
            'profile' => $profile,
            'stack' => new Stack(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'color' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:255',
            'is_lang' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['user_id'] = $user->id;
        $validated['color'] = $validated['color'] ?? '#6366f1';
        $validated['is_lang'] = $request->has('is_lang');
        $validated['is_active'] = $request->has('is_active');

        Stack::create($validated);

        return redirect()->route('stacks.admin')->with('success', 'Skill / Tech Stack added successfully.');
    }

    public function edit($id)
    {
        $page = Page::all();
        $profile = Auth::user()->profile;
        $stack = Stack::findOrFail($id);

        return view('admin.stack_detail', [
            'page' => $page,
            'profile' => $profile,
            'stack' => $stack,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $stack = Stack::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'color' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:255',
            'is_lang' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_lang'] = $request->has('is_lang');
        $validated['is_active'] = $request->has('is_active');

        $stack->update($validated);

        return redirect()->route('stacks.admin')->with('success', 'Skill / Tech Stack updated successfully.');
    }

    public function destroy($id)
    {
        $stack = Stack::findOrFail($id);
        $stack->delete();

        return redirect()->route('stacks.admin')->with('success', 'Skill / Tech Stack deleted successfully.');
    }
}
