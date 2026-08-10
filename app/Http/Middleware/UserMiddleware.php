<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {


       

        $role = Auth::user()->role;
        
        if ($role !='user' ) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}