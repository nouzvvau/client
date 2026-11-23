<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventDocumentation extends Model
{
    /** @use HasFactory<\Database\Factories\EventDocumentationFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
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

    public function getCoverUrlAttribute(): ?string
    {
        $photo = $this->relationLoaded('photos')
            ? $this->photos->first()
            : $this->photos()->first();

        return $photo?->url;
    }
}
