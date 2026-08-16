<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Page;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::where('is_active', true)->orderBy('created_at', 'desc')->get();

        $page = Page::where('slug', 'projects')->first();

        return view('project', compact('projects', 'page'));
    }

    public function show(Request $request, string $slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        $page = Page::where('slug', 'projects')->first();

        $next = Project::where('id', '>', $project->id)->where('is_active', true)->first()
            ?? Project::where('id', '!=', $project->id)->where('is_active', true)->first()
            ?? Project::where('id', '!=', $project->id)->first();

        $nextProject = [
            'slug' => $next->slug ?? $project->slug,
            'title' => $next->title ?? $project->title,
            'short_description' => Str::limit($next->description ?? $project->description ?? '', 100)
        ];

        return view('project_detail', compact('project', 'page', 'nextProject'));
    }
    
}
