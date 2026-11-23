<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = [
        'name',
        'value',
    ];

    public static function get(string $name, ?string $default = null): ?string
    {
        if (! Schema::hasTable('settings')) {
            return $default;
        }

        $value = static::query()->where('name', $name)->value('value');

        return $value ?? $default;
    }

    public static function set(string $name, ?string $value): void
    {
        static::query()->updateOrCreate(['name' => $name], ['value' => $value]);
    }

    /**
     * @param  array<string, string|null>  $values
     */
    public static function setMany(array $values): void
    {
        DB::transaction(function () use ($values): void {
            foreach ($values as $name => $value) {
                static::set($name, $value);
            }
        });
    }
}
