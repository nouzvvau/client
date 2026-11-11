<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    protected $fillable = [
        'full_name',
        'birth_date',
        'guardian_name',
        'contact_phone',
        'address',
        'joined_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'joined_at' => 'date',
        ];
    }

    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'program_student')
            ->withPivot('status', 'joined_at')
            ->withTimestamps();
    }
}
