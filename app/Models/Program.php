<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;

class Program extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'year',
        'schedule',
        'schedule_en',
        'description',
        'description_en',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function documentations(): HasMany
    {
        return $this->hasMany(EventDocumentation::class)
            ->orderByDesc('event_date')
            ->orderByDesc('id');
    }

    /**
     * Mengambil foto yang dipilih sebagai thumbnail program.
     */
    public function thumbnailPhotos(): HasManyThrough
    {
        return $this->hasManyThrough(
            EventDocumentationPhoto::class,
            EventDocumentation::class
        )->where('event_documentation_photos.is_thumbnail', true);
    }

    public function getThumbnailPhotoAttribute(): ?EventDocumentationPhoto
    {
        return $this->thumbnailPhotos()->first();
    }

    public function getSlugAttribute(): string
    {
        return Str::slug((string) $this->name);
    }

    public function getLocalizedNameAttribute(): string
    {
        return $this->localizedValue('name_en', $this->name) ?? '';
    }

    public function getLocalizedScheduleAttribute(): ?string
    {
        return $this->localizedValue('schedule_en', $this->schedule);
    }

    public function getLocalizedDescriptionAttribute(): ?string
    {
        return $this->localizedValue('description_en', $this->description);
    }

    public function getImageUrlAttribute(): string
    {
        $image = trim((string) $this->image);

        if ($image === '') {
            return asset('assets/images/galeri/galeri-01.jpeg');
        }

        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $image;
        }

        return asset(ltrim($image, '/'));
    }

    private function localizedValue(string $englishAttribute, ?string $fallback): ?string
    {
        $english = trim((string) $this->getAttribute($englishAttribute));

        if (app()->getLocale() === 'en' && $english !== '') {
            return $english;
        }

        $value = trim((string) $fallback);

        return $value === '' ? null : $value;
    }
}