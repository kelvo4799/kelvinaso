<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
        'replied_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function replies()
    {
        return $this->hasMany(ContactReply::class)->orderBy('created_at', 'asc');
    }
}
