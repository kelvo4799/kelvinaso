<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Settings;
use Illuminate\Http\Request;

class BookCallController extends Controller
{
    public function index()
    {
        $enabled = setting('enable_scheduler', '1');
        if ($enabled === '0') {
            return redirect()->route('home');
        }

        $page = Page::where('slug', 'home')->first();
        $calendlyUrl = setting('calendly_url', 'https://calendly.com');

        return view('book_call', compact('page', 'calendlyUrl'));
    }
}
