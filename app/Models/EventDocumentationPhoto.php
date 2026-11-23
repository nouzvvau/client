<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class EventDocumentationPhoto extends Model
{
    protected $fillable = [
        'event_documentation_id',
        'photo',
        'caption',
    ];

    public function eventDocumentation(): BelongsTo
    {
        return $this->belongsTo(EventDocumentation::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->photo);
    }
}
