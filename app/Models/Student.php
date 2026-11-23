<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_NONE = 'none';

    /**
     * @var list<string>
     */
    public const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
        self::STATUS_NONE,
    ];

    public const CLASSES = [
        'Karawitan Mahir',
        'Karawitan Dasar Tingkat I (A)',
        'Karawitan Dasar Tingkat I (B)',
        'Karawitan Dasar Tingkat II (A)',
        'Karawitan Dasar Tingkat II (B)',
        'Karawitan Dasar Tingkat II (C)',
        'Karawitan Madya I',
        'Karawitan Madya II',
    ];

    public $timestamps = false;

    protected $fillable = [
        'name',
        'class',
        'status',
        'joined_at',
    ];

    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'joined_at' => 'date',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function getFullNameAttribute(): string
    {
        return (string) $this->name;
    }

    public function getProgramsAttribute(): Collection
    {
        if ($this->class === null || $this->class === '') {
            return new Collection;
        }

        return new Collection([
            (object) [
                'id' => $this->class,
                'name' => $this->class,
            ],
        ]);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_INACTIVE => 'Nonaktif',
            self::STATUS_NONE => 'Tidak ada',
            default => 'Aktif',
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            self::STATUS_INACTIVE => 'rejected',
            self::STATUS_NONE => 'secondary',
            default => 'accepted',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function statusOptions(): array
    {
        return [
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_INACTIVE => 'Nonaktif',
        ];
    }

    public static function classOptions(): Collection
    {
        return new Collection(array_map(
            fn (string $className): object => (object) [
                'id' => $className,
                'name' => $className,
            ],
            self::CLASSES
        ));
    }
}
