<?php

namespace App\Imports;

use App\Models\DataMenara;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;

// 1. TAMBAHKAN 'USE' STATEMENTS BARU
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class DataMenaraImport extends DefaultValueBinder implements ToModel, WithStartRow, WithValidation, SkipsOnFailure, WithCustomValueBinder
{
    use Importable;

    /**
     * Memaksa semua cell dibaca sebagai string mentah.
     */
    public function bindValue(Cell $cell, $value)
    {
        $cell->setValueExplicit($value, DataType::TYPE_STRING);
        return true;
    }

    public function startRow(): int
    {
        return 2; // Mulai membaca data dari baris ke-2
    }

    /**
     * Dijalankan sebelum validasi: normalisasi / pembersihan data.
     */
    public function prepareForValidation(array $row): array
    {
        // --- KODE: trim, kalau kosong -> isi '-' (jangan jadi NULL)
        $kode_raw = isset($row[0]) ? (string)$row[0] : '';
        $kode_trim = trim($kode_raw);

        if ($kode_trim === '') {
            // kosong di Excel -> kita standar-kan jadi '-' (sama seperti form manual)
            $row[0] = '-';
        } else {
            $row[0] = $kode_trim;
        }

        // --- Provider / text fields: trim (opsional tetapi bagus)
        if (isset($row[1])) $row[1] = trim((string)$row[1]);
        if (isset($row[2])) $row[2] = trim((string)$row[2]);
        if (isset($row[3])) $row[3] = trim((string)$row[3]);
        if (isset($row[4])) $row[4] = trim((string)$row[4]);
        if (isset($row[7])) $row[7] = trim((string)$row[7]);

        // --- Longitude & Latitude: ganti koma ke titik, trim
        if (isset($row[5])) $row[5] = str_replace(',', '.', trim((string)$row[5]));
        if (isset($row[6])) $row[6] = str_replace(',', '.', trim((string)$row[6]));

        // --- Tinggi tower: ambil angka saja dan trim
        if (isset($row[8])) {
            $rawTinggi = trim((string)$row[8]);
            if ($rawTinggi === '') {
                $row[8] = 0;
            } elseif (!is_numeric($rawTinggi)) {
                preg_match('/[0-9]+/', $rawTinggi, $matches);
                $row[8] = isset($matches[0]) ? (int)$matches[0] : 0;
            } else {
                $row[8] = (int)$rawTinggi;
            }
        } else {
            $row[8] = 0;
        }

        return $row;
    }

    /**
    * Buat model Eloquent untuk setiap baris (pastikan menggunakan nilai yang sudah dibersihkan)
    */
    public function model(array $row)
    {
        // Pastikan kode tetap string (sudah dibersihkan di prepareForValidation)
        $kode_value = isset($row[0]) ? (string) $row[0] : '-';

        // Longitude / latitude sudah diganti koma->titik di prepareForValidation
        $longitude_value = isset($row[5]) ? (string)$row[5] : null;
        $latitude_value  = isset($row[6]) ? (string)$row[6] : null;

        // Tinggi sudah menjadi integer di prepareForValidation
        $tinggi_value = isset($row[8]) ? (int)$row[8] : 0;

        return new DataMenara([
            'kode'         => $kode_value,
            'provider'     => $row[1] ?? null,
            'kelurahan'    => $row[2] ?? null,
            'kecamatan'    => $row[3] ?? null,
            'alamat'       => $row[4] ?? null,
            'longitude'    => $longitude_value,
            'latitude'     => $latitude_value,
            'status'       => $row[7] ?? null,
            'tinggi_tower' => $tinggi_value,
        ]);
    }

    /**
     * Aturan validasi.
     *
     * Catatan: saya ubah rule '0' menjadi required|string sehingga
     * sel kosong tidak lolos (kita sudah mengganti kosong ke '-').
     *
     * Jika Anda ingin menegakkan unik untuk kode pada import,
     * kita bisa tambahkan 'unique:data_menara,kode' — tapi hati-hati:
     * banyak '-' duplicate akan menyebabkan gagal jika unique aktif.
     */
    public function rules(): array
    {
        return [
            '0' => 'required|string',
            '1' => 'required|string',
            '2' => 'required|string',
            '3' => 'required|string',
            '4' => 'required|string',
            '5' => 'required|numeric|between:-180,180',
            '6' => 'required|numeric|between:-90,90',
            '7' => 'required|string',
            '8' => 'required', // integer handling sudah dilakukan di prepareForValidation
        ];
    }

    /**
     * Pesan kustom jika validasi gagal.
     */
    public function customValidationMessages()
    {
        return [
            '0.required' => 'Kolom Kode tidak boleh kosong. Jika tidak ada kode, isi dengan "-".',
            '5.numeric' => 'Longitude harus berupa angka.',
            '6.numeric' => 'Latitude harus berupa angka.',
        ];
    }

    /**
     * Lewati baris yang gagal.
     */
    public function onFailure(Failure ...$failures)
    {
        // Biarkan kosong (skip baris yang gagal)
    }
}
