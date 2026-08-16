<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Contact;
use App\Models\PageView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class DashboardController extends Controller
{
    public function index()
    {
        $projectsCount = Project::count();
        $recentProjects = Project::latest()->limit(5)->get();

        $recentProjects->each(function ($project) {
            $project->description = Str::limit($project->description ?? '', 50);

            $words = array_values(array_filter(explode(' ', trim($project->title ?? ''))));
            if (count($words) >= 2) {
                $project->initials = strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
            } elseif (count($words) === 1) {
                $project->initials = strtoupper(substr($words[0], 0, 2));
            } else {
                $project->initials = 'PR';
            }
        });

        $msgsCount = Contact::count();
        $unreadMsgsCount = Contact::where('status', 'unread')->count();
        $profile = Auth::user()?->profile;

        $contacts = Contact::latest()->limit(3)->get();

        $pageViewsCountRusult = PageView::count();

        $pageViewsCount = $this->number_normalize($pageViewsCountRusult);

        $current = PageView::where('created_at', '>=', now()->subDays(30))
            ->count();

        $previous = PageView::whereBetween('created_at', [
            now()->subDays(60),
            now()->subDays(30),
        ])->count();

        $percentageChange = $previous > 0
            ? (($current - $previous) / $previous) * 100
            : 0;

        $pageViewsByMonth = [];
        try {
            $views = PageView::query()
                ->selectRaw("
            DATE_FORMAT(created_at, '%b') as month,
            COUNT(*) as views
        ")
                ->groupByRaw("YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')")
                ->orderByRaw("YEAR(created_at), MONTH(created_at)")
                ->get();

            foreach ($views as $view) {
                $pageViewsByMonth[$view->month] = $view->views;
            }
        } catch (\Throwable $e) {
            // Fallback for non-MySQL databases (e.g., SQLite in tests)
            $views = PageView::all()->groupBy(function ($item) {
                return $item->created_at ? $item->created_at->format('M') : 'Jan';
            });
            foreach ($views as $month => $items) {
                $pageViewsByMonth[$month] = $items->count();
            }
        }





        return view('admin.dashbaord', compact(
            'projectsCount',
            'msgsCount',
            'unreadMsgsCount',
            'profile',
            'pageViewsCount',
            'percentageChange',
            'pageViewsByMonth',
            'recentProjects',
            'contacts'
        ));
    }

    private function number_normalize($number)
    {
        if ($number >= 1000000) {
            return number_format($number / 1000000, 2) . 'M';
        } elseif ($number >= 1000) {
            return number_format($number / 1000, 2) . 'k';
        } else {
            return (string) $number;
        }
    }
}
