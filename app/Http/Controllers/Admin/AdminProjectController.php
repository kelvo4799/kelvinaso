<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminProjectRequest;
use App\Models\Page;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminProjectController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        $profile = Auth::user()->profile;
        $projects = Project::latest()->paginate(10);

        $projects->each(function ($project) {
            $project->short_description = Str::limit($project->description ?? '', 40);

            $words = array_values(array_filter(explode(' ', trim($project->title ?? ''))));
            if (count($words) >= 2) {
                $project->initials = strtoupper(substr($words[0], 0, 1).substr(end($words), 0, 1));
            } elseif (count($words) === 1) {
                $project->initials = strtoupper(substr($words[0], 0, 2));
            } else {
                $project->initials = 'PR';
            }
        });

        // Counts
        $pageCount = [
            'countAll' => Project::count(),
            'countInactive' => Project::where('is_active', false)->count(),
            'countActive' => Project::where('is_active', true)->count(),
        ];

        return view('admin.projects', compact(
            'pages',
            'profile',
            'projects',
            'pageCount'
        ));
    }

    public function show(string $slug)
    {
        $page = Page::all();
        $profile = Auth::user()->profile;
        $project = Project::where('slug', $slug)->first();

        if (! $project) {
            abort(404);
        }

        $tech = is_array($project->tech_stack)
            ? implode(', ', $project->tech_stack)
            : ($project->tech_stack ?? '');

        $project->formatted_tech_stack = $tech;

        return view('admin.project_detail', compact(
            'page',
            'profile',
            'project'
        ));
    }

    public function create() {}

    public function store(AdminProjectRequest $request)
    {
        $validated = $request->validated();

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Project::where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$count++;
        }

        $techArray = ! empty($validated['tech'])
            ? array_values(array_filter(array_map('trim', explode(',', $validated['tech']))))
            : [];

        $project = Project::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'project_type' => $validated['category'] ?? 'web',
            'year' => $validated['year'] ?? now()->year,
            'description' => $validated['description'] ?? '',
            'tech_stack' => $techArray,
            'is_active' => true,
        ]);

        return redirect()->route('projects.show.admin', $project->slug)->with('success', 'New project created successfully.');
    }

    public function update(string $slug, AdminProjectRequest $request)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        $validated = $request->validated();

        // dd($validated);

        $techArray = ! empty($validated['tech'])
            ? array_map('trim', explode(',', $validated['tech']))
            : [];

        $cName = $validated['comment_name'] ?? ($validated['name'] ?? '');
        $cPos = $validated['comment_position'] ?? ($validated['position'] ?? '');
        $cText = $validated['comment_text'] ?? ($validated['comment'] ?? '');

        $comment = [];
        if (! empty($cName) || ! empty($cText)) {
            $comment = [
                'name' => $cName,
                'position' => $cPos,
                'comment' => $cText,
            ];
        }

        if (isset($validated['sections']) && ! empty($validated['sections'])) {

            $otherText = [];
            $metrics = [];

            foreach ($validated['sections'] as $section) {
                if ($section['type'] === 'text') {
                    $otherText[] = [
                        'header' => $section['title'] ?? '',
                        'paragraph' => $section['body'] ?? '',
                    ];
                }
                if ($section['type'] === 'testimonial') {
                    $comment = [
                        'name' => $section['name'] ?? '',
                        'position' => $section['position'] ?? '',
                        'comment' => $section['comment'] ?? '',
                    ];
                }
                if ($section['type'] === 'stats') {
                    foreach ($section['metrics'] as $metric) {
                        $metrics[] = [
                            $metric['key'] => $metric['value'],
                        ];
                    }
                }

            }

        }

        if ($request->hasFile('image')) {
            $imagePath = $project->uploadImage(
                $request->file('image'),
                'projects'
            );
        }

        if ($request->hasFile('icon')) {
            $iconPath = $project->uploadImage(
                $request->file('icon'),
                'projects/icons'
            );
        }

        $data = [
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?? Str::slug($validated['title']),
            'description' => $validated['description'] ?? '',
            'image' => $imagePath ?? $project->image,
            'icon' => $iconPath ?? $project->icon,
            'tech_stack' => $techArray,
            'role' => $validated['role'] ?? '',
            'year' => $validated['year'] ?? now()->year,
            'industry' => $validated['industry'] ?? '',
            'client' => $validated['client'] ?? 'Self',
            'client_url' => $validated['client_url'] ?? '',
            'client_comment' => $comment ?? [],
            'github_url' => $validated['github_url'] ?? '',
            'project_type' => $validated['category'] ?? 'web',
            'view_type' => $validated['view_type'] ?? 'preview',
            'live_url' => $validated['live_url'] ?? '',
            'featured' => ! empty($validated['featured']),
            'metrics' => $metrics ?? [],
            'other_details' => $otherText ?? [],
            'is_active' => isset($validated['status']) ? in_array((string) $validated['status'], ['1', 'published', 'active', 'true'], true) : $project->is_active,
        ];

        $project->update($data);

        return redirect()->route('projects.show.admin', $project->slug)->with('success', 'Project updated successfully.');
    }

    public function destroy(string $slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        $project->delete();

        return redirect()->route('projects.admin')->with('success', 'Project deleted successfully.');
    }
}
