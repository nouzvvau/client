<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = [
        'name',
        'position',
        'photo',
        'description',
        'is_active',
        'sort_order',
    ];
}
