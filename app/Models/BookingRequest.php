<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    protected $fillable = [
        'customer_name', 'whatsapp', 'organization', 'event_type',
        'event_name', 'event_date', 'start_time', 'event_location',
        'audience_estimate', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'audience_estimate' => 'integer',
        ];
    }
}
