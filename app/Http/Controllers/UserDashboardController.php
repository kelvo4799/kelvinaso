<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\Contact;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Redirect admins to Admin Dashboard if they navigate to /dashboard
        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        $page = Page::where('slug', 'home')->first();

        // User's Contact Messages
        $userMessages = Contact::where('email', $user->email)
            ->orderBy('created_at', 'desc')
            ->get();

        // User's AI Chatbot Conversations
        $userChats = ChatConversation::where('client_email', $user->email)
            ->orWhere('ip_address', request()->ip())
            ->orderBy('created_at', 'desc')
            ->get();

        // Affiliate & Referral Stats
        $referralLink = $user->referral_link;
        $totalClicks = $user->referrals()->count();
        $convertedLeads = $user->referrals()->whereIn('status', ['converted', 'paid'])->count();
        $totalEarnings = $user->referrals()->sum('commission_amount');
        $referrals = $user->referrals()->latest()->take(10)->get();

        return view('dashboard', compact(
            'user',
            'page',
            'userMessages',
            'userChats',
            'referralLink',
            'totalClicks',
            'convertedLeads',
            'totalEarnings',
            'referrals'
        ));
    }
}
