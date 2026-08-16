<?php

namespace App\Http\Middleware;

use App\Models\Referral;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class TrackReferralCode
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $refCode = $request->query('ref') ?? $request->query('aff');

        if (!empty($refCode)) {
            $referrer = User::where('referral_code', strtoupper($refCode))->first();

            if ($referrer) {
                // Store in session and cookie for 30 days
                Session::put('referral_code', $referrer->referral_code);
                Cookie::queue('referral_code', $referrer->referral_code, 60 * 24 * 30);

                // Log referral visit if not already logged recently for this IP & referrer
                $recentVisit = Referral::where('referrer_id', $referrer->id)
                    ->where('visitor_ip', $request->ip())
                    ->where('created_at', '>=', now()->subHours(24))
                    ->exists();

                if (!$recentVisit) {
                    Referral::create([
                        'referrer_id' => $referrer->id,
                        'visitor_ip' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'status' => 'pending',
                        'commission_amount' => 0.00,
                        'notes' => 'Visitor click via referral link',
                    ]);
                }
            }
        }

        return $next($request);
    }
}
