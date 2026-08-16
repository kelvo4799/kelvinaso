<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatConversation extends Model
{
    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'client_name',
        'client_email',
        'client_phone',
        'project_summary',
        'estimated_budget',
        'lead_score',
        'intent',
        'extracted_data',
        'status',
    ];

    protected $casts = [
        'extracted_data' => 'array',
    ];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id');
    }
}
