<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use App\Models\Contact;
use App\Models\Page;
use App\Models\PageView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $page = Page::all();
        $profile = Auth::user()->profile;

        $range = $request->input('range', '30'); // 7, 30, 90, all
        $startDate = match ($range) {
            '7' => Carbon::now()->subDays(7),
            '90' => Carbon::now()->subDays(90),
            'all' => Carbon::createFromTimestamp(0),
            default => Carbon::now()->subDays(30),
        };

        // Base Query
        $baseQuery = PageView::where('created_at', '>=', $startDate);

        $totalViews = (clone $baseQuery)->count();
        $uniqueVisitors = (clone $baseQuery)->distinct('visitor_id')->count('visitor_id');
        $totalContacts = Contact::where('created_at', '>=', $startDate)->count();
        $totalAiLeads = ChatConversation::where('created_at', '>=', $startDate)->where('lead_score', '!=', 'COLD')->count();

        // Daily Traffic Chart Data (Last N Days)
        $daysCount = $range === 'all' ? 30 : (int)$range;
        $dailyLabels = [];
        $dailyViewsData = [];
        $dailyVisitorsData = [];

        for ($i = $daysCount - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dailyLabels[] = Carbon::now()->subDays($i)->format('M d');

            $views = PageView::whereDate('created_at', $date)->count();
            $visitors = PageView::whereDate('created_at', $date)->distinct('visitor_id')->count('visitor_id');

            $dailyViewsData[] = $views;
            $dailyVisitorsData[] = $visitors;
        }

        // Top Visited Pages
        $topPages = PageView::where('created_at', '>=', $startDate)
            ->select('path', DB::raw('count(*) as count'))
            ->groupBy('path')
            ->orderBy('count', 'desc')
            ->take(8)
            ->get();

        // Top Referrers
        $topReferrers = PageView::where('created_at', '>=', $startDate)
            ->whereNotNull('referer')
            ->where('referer', '!=', '')
            ->select('referer', DB::raw('count(*) as count'))
            ->groupBy('referer')
            ->orderBy('count', 'desc')
            ->take(6)
            ->get();

        // Live Recent Page Views
        $recentViews = PageView::orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.analytics', compact(
            'page',
            'profile',
            'range',
            'totalViews',
            'uniqueVisitors',
            'totalContacts',
            'totalAiLeads',
            'dailyLabels',
            'dailyViewsData',
            'dailyVisitorsData',
            'topPages',
            'topReferrers',
            'recentViews'
        ));
    }
}
