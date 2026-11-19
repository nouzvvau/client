<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public const CLASSES = [
        'Ruang Edukasi & Workshop',
        'Karawitan',
        'Tari',
        'Seni Tradisional',
    ];

    public $timestamps = false;

    protected $fillable = [
        'name',
        'class',
    ];

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
