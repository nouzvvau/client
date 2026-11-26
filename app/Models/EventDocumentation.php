<?php

namespace App\Models;

use Database\Factories\EventDocumentationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventDocumentation extends Model
{
    /** @use HasFactory<EventDocumentationFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'program_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_date' => 'date',
        ];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(EventDocumentationPhoto::class)->orderBy('id');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function getCoverUrlAttribute(): ?string
    {
        $photo = $this->relationLoaded('photos')
            ? $this->photos->first()
            : $this->photos()->first();

        return $photo?->url;
    }
}
