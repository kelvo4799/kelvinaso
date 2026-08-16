<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class VisitorService
{

    public function getVisitorIdCookie(Request $request): string
    {
        
        $visitorId = $request->cookie('visitor_id');

        if (! $visitorId) {
            $visitorId = (string) Str::uuid();
            Cookie::queue('visitor_id', $visitorId, 60 * 24 * 365);
        }

        return $visitorId;

    }

}