<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blankspot extends Model
{
    use HasFactory;

    protected $fillable = [
        'desa',
        'kecamatan',
        'site',
        'lokasi_blankspot',
        'status',
        'layanan_pendidikan',
        'layanan_kesehatan',
    ];
}