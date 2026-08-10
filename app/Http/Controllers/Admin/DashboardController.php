<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        $projectsCount = Project::all()->count();
        $msgsCount = Contact::all()->count();
        $unreadMsgsCount = Contact::where('status', 'unread')->count();

        $profile = Auth::user()->profile;

        

        return view('admin.dashbaord', compact('projectsCount', 'msgsCount', 'unreadMsgsCount', 'profile'));
    }
}
