<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranMurid extends Model
{
    protected $fillable = [
        'nama_murid',
        'tanggal_lahir',
        'nama_wali',
        'whatsapp',
        'alamat',
        'program',
        'pengalaman',
        'catatan',
        'status'
    ];
}