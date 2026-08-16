<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    protected $fillable = [
        'header_html',
        'footer_html',
    ];
}
