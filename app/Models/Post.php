<?php

namespace App\Models;

use App\Traits\HasImageUpload;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasImageUpload;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'category',
        'tags',
        'read_time',
        'is_published',
        'published_at',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'json',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'views_count' => 'integer',
        ];
    }
}
