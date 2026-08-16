<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        $stacks = $this->users ? $this->users->stacks()->where('is_active', true)->where('is_lang', true)->get() : collect();

        $page = Page::where('slug', 'home')->first();

        $profile = $this->users ? $this->users->profile()->first() : null;

        return view('home', compact('page', 'stacks', 'profile'));
    }
}
