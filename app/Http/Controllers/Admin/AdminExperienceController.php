<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminExperienceController extends Controller
{
    public function index()
    {
        $page = Page::all();
        $profile = Auth::user()->profile;
        $experiences = Experience::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.experiences', compact('page', 'profile', 'experiences'));
    }

    public function create()
    {
        $page = Page::all();
        $profile = Auth::user()->profile;

        return view('admin.experience_detail', [
            'page' => $page,
            'profile' => $profile,
            'experience' => new Experience(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:255',
            'start_year' => 'required|string|max:255',
            'end_year' => 'nullable|string|max:255',
            'is_current' => 'nullable|boolean',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_current'] = $request->has('is_current');
        $validated['is_active'] = $request->has('is_active');

        Experience::create($validated);

        return redirect()->route('experiences.admin')->with('success', 'Work Experience added successfully.');
    }

    public function edit($id)
    {
        $page = Page::all();
        $profile = Auth::user()->profile;
        $experience = Experience::findOrFail($id);

        return view('admin.experience_detail', [
            'page' => $page,
            'profile' => $profile,
            'experience' => $experience,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $experience = Experience::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:255',
            'start_year' => 'required|string|max:255',
            'end_year' => 'nullable|string|max:255',
            'is_current' => 'nullable|boolean',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_current'] = $request->has('is_current');
        $validated['is_active'] = $request->has('is_active');

        $experience->update($validated);

        return redirect()->route('experiences.admin')->with('success', 'Work Experience updated successfully.');
    }

    public function destroy($id)
    {
        $experience = Experience::findOrFail($id);
        $experience->delete();

        return redirect()->route('experiences.admin')->with('success', 'Work Experience deleted successfully.');
    }
}
