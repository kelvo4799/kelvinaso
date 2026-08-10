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
        $projects = Project::all();

        $page = Page::where('slug', 'projects')->first();

        return view('project', compact('projects', 'page'));

    }

    public function show(Request $request, string $slug){

        $project = Project::where('slug', $slug)->first();

        $page = Page::where('slug', 'projects')->first();

        $next = Project::find($project->id +1);

        if (!$next){
            $next = Project::find(1);
        }

        $nextProject = [
            'slug' => $next->slug,
            'title' => $next->title,
            'short_description' => Str::limit($next->description, 100)
        ];

        return view('project_detail', compact('project', 'page', 'nextProject'));

    }
    
}
