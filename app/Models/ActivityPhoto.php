<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityPhoto extends Model
{
    protected $fillable = ['activity_id', 'photo', 'caption'];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
}
