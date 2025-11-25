<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DataMenara; // <-- Import Model kita

class DataMenaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama agar tidak duplikat setiap kali seeder dijalankan
        DataMenara::truncate();

        $dummyData = [
            [
                'kode' => '60935-PTPROTELIN-79',
                'provider' => 'PT PROTELINDO',
                'kelurahan' => 'SUNGAI DURIAN',
                'kecamatan' => 'BANUA LAWAS',
                'alamat' => 'Desa Sungai durian RT 05 RW',
                'longitude' => '115.27807',
                'latitude' => '-2.34552',
                'tipe_ukuran' => 'makrocell',
                'status' => 'aktif',
                'tinggi_tower' => 72
            ],
            [
                'kode' => '60940-PTDAYAMITR-164',
                'provider' => 'PT.DAYAMITRA TELEKOMUNIKASI',
                'kelurahan' => 'BANGKILING RAYA',
                'kecamatan' => 'BANUA LAWAS',
                'alamat' => 'JL. Bangkiling Raya RT.04',
                'longitude' => '115.2561389',
                'latitude' => '-2.33177778',
                'tipe_ukuran' => 'mikrocell',
                'status' => 'aktif',
                'tinggi_tower' => 52
            ],
            [
                'kode' => '60941-PT-CENTRAT-139',
                'provider' => 'PT. CENTRATAMA MENARA INDONESIA',
                'kelurahan' => 'BANUA LAWAS',
                'kecamatan' => 'BANUA LAWAS',
                'alamat' => 'Pematang RT.005 RW 00 Desa Pematang K',
                'longitude' => '115.29152778',
                'latitude' => '-2.33886111',
                'tipe_ukuran' => 'mikrocell',
                'status' => 'aktif',
                'tinggi_tower' => 52
            ],
            [
                'kode' => '60942-TELKOMSEL-76',
                'provider' => 'TELKOMSEL',
                'kelurahan' => 'BANUA LAWAS',
                'kecamatan' => 'BANUA LAWAS',
                'alamat' => 'Jl. Lapangan 17 mei Rt.02 Kel. Desa Banua L',
                'longitude' => '115.278028',
                'latitude' => '-2.320083',
                'tipe_ukuran' => 'makrocell',
                'status' => 'aktif',
                'tinggi_tower' => 71
            ],
        ];

        // Looping dan masukkan setiap baris data ke dalam database
        foreach ($dummyData as $data) {
            DataMenara::create($data);
        }
    }
}
