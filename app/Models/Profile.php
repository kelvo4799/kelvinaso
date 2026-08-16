<?php

namespace App\Models;

use App\Traits\HasImageUpload;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasImageUpload;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'bio_title',
        'bio_header',
        'bio',
        'bio_extra',
        'avatar',
        'cover_image',
        'cv',
        'location',
        'direct_email',
        'direct_phone',
        'social_links',
        'others',
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
