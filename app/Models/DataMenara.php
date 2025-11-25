<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMenara extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'data_menara';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'kode',
        'provider',
        'kelurahan',
        'kecamatan',
        'alamat',
        'longitude',
        'latitude',
        'tipe_ukuran',
        'status',
        'tinggi_tower',
    ];
}
