<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        
        $stacks = $this->users->stacks()->where('is_active', true)->where('is_lang', true)->get();

        $page = Page::where('slug', 'home')->first();

        $profile = $this->users->profile()->first();

        return view('home', compact('page', 'stacks', 'profile'));
    }
}
