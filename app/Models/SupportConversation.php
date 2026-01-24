<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportConversation extends Model
{
    protected $fillable = [
        'user_id',
        // 'subject',
        'status',
    ];

    public function messages()
    {
        return $this->hasMany(SupportMessage::class, 'conversation_id');
    }

    public function latestMessage()
    {
        return $this->hasOne(SupportMessage::class, 'conversation_id')
            ->latestOfMany();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
