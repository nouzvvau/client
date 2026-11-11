<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'phone',
        'institution_name',
        'service_type',
        'event_name',
        'event_date',
        'start_time',
        'event_location',
        'estimated_audience',
        'additional_notes',
        'status',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'created_at' => 'datetime',
        ];
    }
}
