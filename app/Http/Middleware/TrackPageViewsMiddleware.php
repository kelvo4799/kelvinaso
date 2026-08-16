<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PageView;
use App\Services\VisitorService;

class TrackPageViewsMiddleware
{


    public function __construct(
        private VisitorService $visitorService
    ){}
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $response = $next($request);

        if ($request->isMethod('GET') && $response->isSuccessful()) {
            PageView::create([
                'path' => $request->path(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'visitor_id' => $this->visitorService->getVisitorIdCookie($request),
                'referer' => $request->header('referer') ?? 'Direct Access',
                'user_id' => auth()->id() ?? null,
            ]);
        }

        return $response;
    }
}
