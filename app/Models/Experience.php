<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'title',
        'company',
        'location',
        'employment_type',
        'start_year',
        'end_year',
        'is_current',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'is_active' => 'boolean',
    ];
}
