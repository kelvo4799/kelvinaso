<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactReply extends Model
{
    protected $fillable = [
        'contact_id',
        'sender_type',
        'sender_name',
        'sender_email',
        'message',
        'sent_via_email',
    ];

    protected function casts(): array
    {
        return [
            'sent_via_email' => 'boolean',
        ];
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
