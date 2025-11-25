<?php

namespace App\Imports;

use App\Models\Blankspot;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BlankspotImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Pengecekan agar tidak mengimpor baris kosong
        if (empty($row['lokasi_blankspot']) || empty($row['kecamatan'])) {
            return null;
        }

        // Cek duplikat berdasarkan lokasi & kecamatan
        $existing = Blankspot::where('lokasi_blankspot', $row['lokasi_blankspot'])
                             ->where('kecamatan', $row['kecamatan'])
                             ->first();

        if ($existing) {
            return null; // Lewati jika data sudah ada
        }

        return new Blankspot([
            'desa'                 => $row['desa'],
            'kecamatan'            => $row['kecamatan'],
            'site'                 => $row['site'],
            'lokasi_blankspot'     => $row['lokasi_blankspot'],
            'layanan_pendidikan'   => $row['layanan_pendidikan'],
            'layanan_kesehatan'    => $row['layanan_kesehatan'],
        ]);
    }
}