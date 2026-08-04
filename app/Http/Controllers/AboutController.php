<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class AboutController extends Controller
{
    public function index()
    {
        $users = $this->users;

        $stacks = $this->users->stacks()->where('is_active', true)->get()->groupBy('type')->toArray();

        $page = Page::where('slug', 'home')->first();

        $profile = $this->users->profile()->first();

        return view('about', compact('users', 'page', 'profile', 'stacks'));
    }
}
