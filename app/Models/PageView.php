<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = [
        'path',
        'ip_address',
        'user_agent',
        'user_id',
        'visitor_id',
        'referer',
    ];
}
