<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'slug',
        'subject',
        'body_html',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}