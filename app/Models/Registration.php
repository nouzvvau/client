<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'full_name',
        'birth_date',
        'guardian_name',
        'contact_phone',
        'address',
        'program_id',
        'music_experience',
        'notes',
        'status',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'created_at' => 'datetime',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
