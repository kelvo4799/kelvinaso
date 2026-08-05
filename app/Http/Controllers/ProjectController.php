<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Page;

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

        return view('project_detail', compact('project', 'page'));

    }
    
}
