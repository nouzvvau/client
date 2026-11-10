<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    protected $table = 'murids';

    protected $fillable = [
        'nama',
        'program',
        'tahun_masuk',
        'foto',
        'status',
    ];
}