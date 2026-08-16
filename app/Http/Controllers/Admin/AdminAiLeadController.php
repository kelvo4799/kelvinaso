<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAiLeadController extends Controller
{
    public function index()
    {
        $page = Page::all();
        $profile = Auth::user()->profile;
        $conversations = ChatConversation::with('messages')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('admin.ai_leads', compact('page', 'profile', 'conversations'));
    }

    public function show($id)
    {
        $page = Page::all();
        $profile = Auth::user()->profile;
        $conversation = ChatConversation::with('messages')->findOrFail($id);

        return view('admin.ai_lead_detail', compact('page', 'profile', 'conversation'));
    }
}
