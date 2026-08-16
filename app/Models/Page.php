<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    
    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'content' => 'json',
        ];
    }

    public function sections()
    {
        return $this->hasMany(PageSection::class)->orderBy('order');
    }
    
}
