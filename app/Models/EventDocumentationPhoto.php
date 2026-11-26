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
        'thumbnail',
        'caption',
        'is_thumbnail',
    ];

    protected function casts(): array
    {
        return [
            'is_thumbnail' => 'boolean',
        ];
    }

    public function eventDocumentation(): BelongsTo
    {
        return $this->belongsTo(EventDocumentation::class);
    }

    // URL foto asli
    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->photo);
    }

    // URL thumbnail hasil optimasi
    public function getThumbnailUrlAttribute(): ?string
    {
        if (!$this->thumbnail) {
            return null;
        }

        return Storage::disk('public')->url($this->thumbnail);
    }
}