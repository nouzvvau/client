<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    /**
     * @var list<string>
     */
    public const SENDER_TYPES = [
        'murid',
        'wali',
        'penyelenggara',
        'umum',
    ];

    /**
     * @var list<string>
     */
    public const MESSAGE_TYPES = [
        'kritik',
        'saran',
        'pertanyaan',
        'lainnya',
    ];

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
