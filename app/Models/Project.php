<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'role',
        'year',
        'industry',
        'client',
        'client_url',
        'client_comment',
        'tech_stack',
        'github_url',
        'project_type',
        'view_type',
        'live_url',
        'featured',
        'order',
        'is_active',
        'metrics',
        'other_details',
        'meta'
    ];

    protected function casts(): array
    {
        return [
            'tech_stack' => 'json',
            'metrics' => 'json',
            'other_details' => 'json',
            'client_comment' => 'json',
            'meta' => 'json'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
