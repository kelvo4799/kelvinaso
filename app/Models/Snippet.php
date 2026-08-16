<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Snippet extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'language',
        'description',
        'code_content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
