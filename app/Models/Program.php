<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    protected $fillable = ['name', 'description', 'image', 'is_active'];

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'program_student')
            ->withPivot('status', 'joined_at')
            ->withTimestamps();
    }
}
