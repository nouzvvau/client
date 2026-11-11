<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'sender_type',
        'message_type',
        'subject',
        'message',
        'reply_contact',
        'is_read',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'created_at' => 'datetime',
        ];
    }
}
