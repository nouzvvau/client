<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    protected $fillable = ['title', 'description', 'date'];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ActivityPhoto::class);
    }
}
