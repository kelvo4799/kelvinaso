<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Stack;
use App\Models\User;
use Illuminate\Http\Request;

class ResumePdfController extends Controller
{
    public function download()
    {
        $adminUser = User::where('role', 'admin')->first();
        $profile = $adminUser ? $adminUser->profile : new Profile();
        $user = $adminUser ?? new User(['name' => 'Asonta Kelvin', 'email' => 'contact@keviloq.com']);
        $experiences = Experience::where('is_active', true)->get();
        $stacks = Stack::where('is_active', true)->get();
        $projects = Project::where('is_active', true)->take(6)->get();

        return view('resume_pdf', compact('user', 'profile', 'experiences', 'stacks', 'projects'));
    }
}
