<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class AboutController extends Controller
{
    public function index()
    {
        $users = $this->users;

        $stacks = $this->users ? $this->users->stacks()->where('is_active', true)->get()->groupBy('type')->toArray() : [];

        $page = Page::where('slug', 'about')->first() ?? Page::where('slug', 'home')->first();

        $profile = $this->users ? $this->users->profile()->first() : null;

        return view('about', compact('users', 'page', 'profile', 'stacks'));
    }
}
