<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stack extends Model
{
    protected $fillable = [
        'name',
        'image',
        'icon',
        'color',
        'type',
        'level',
        'is_lang',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
