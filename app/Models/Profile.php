<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'bio_extra',
        'bio_header',
        'bio',
        'avatar',
        'cover_image',
        'location',
        'direct_email',
        'direct_phone',
        'others'
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'json',

            'others' => 'json',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
