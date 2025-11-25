<?php

namespace App\Imports;

use App\Models\HotspotData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HotspotImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Pengecekan sederhana agar tidak mengimpor baris kosong
        if (empty($row['nama_tempat'])) {
            return null;
        }

        // --- PERUBAHAN UTAMA: PENGECEKAN DATA DUPLIKAT ---
        
        // 1. Cek apakah data dengan 'nama_tempat' yang sama sudah ada di database.
        $existingHotspot = HotspotData::where('nama_tempat', $row['nama_tempat'])->first();

        // 2. Jika sudah ada (tidak null), lewati baris ini dan jangan impor.
        if ($existingHotspot) {
            return null;
        }

        // 3. Jika belum ada, buat data baru.
        return new HotspotData([
            'nama_tempat' => $row['nama_tempat'],
            'alamat'      => $row['alamat'],
            'tahun'       => $row['tahun'],
            'keterangan'  => $row['keterangan'],
        ]);
    }
}