<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryPhoto extends Model
{
    protected $fillable = [
        'photo',
        'caption',
    ];

    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->photo);
    }
}