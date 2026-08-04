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
        'tech_stack',
        'github_url',
        'project_type',
        'view_type',
        'live_url',
        'featured',
        'order',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'tech_stack' => 'json',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
