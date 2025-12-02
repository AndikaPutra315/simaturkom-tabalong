<?php

namespace App\Imports;

use App\Models\DataMenara;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class DataMenaraImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    /**
     * 1. PREPARE FOR VALIDATION
     * Berjalan sebelum validasi.
     * - Mengubah koordinat DMS (derajat) ke Desimal.
     * - Mengubah string kosong "" menjadi NULL agar aman masuk database.
     */
    public function prepareForValidation($data, $index)
    {
        // 1. Handle Kode: Jika kosong/spasi, paksa jadi NULL agar tidak kena unique check pada string kosong
        if (array_key_exists('kode', $data) && (is_null($data['kode']) || trim($data['kode']) === '')) {
            $data['kode'] = null;
        }

        // 2. Konversi Longitude & Latitude (DMS -> Decimal)
        if (!empty($data['longitude'])) {
            $data['longitude'] = $this->convertDMSToDecimal($data['longitude']);
        }
        if (!empty($data['latitude'])) {
            $data['latitude'] = $this->convertDMSToDecimal($data['latitude']);
        }

        // 3. Bersihkan Tinggi Tower (hapus teks "meter", "m", dll)
        if (!empty($data['tinggi_tower'])) {
             $data['tinggi_tower'] = (int) filter_var($data['tinggi_tower'], FILTER_SANITIZE_NUMBER_INT);
        }

        return $data;
    }

    /**
     * Helper: Rumus Matematika Konversi DMS ke Desimal
     */
    private function convertDMSToDecimal($coordinate)
    {
        if (is_numeric($coordinate)) {
            return (float) $coordinate;
        }

        $coordinate = trim($coordinate);

        // Regex format: 1°45'37.61"S
        if (preg_match('/(\d+)°(\d+)\'([\d.]+)"([NSEW])/i', $coordinate, $matches)) {
            $degrees = (float) $matches[1];
            $minutes = (float) $matches[2];
            $seconds = (float) $matches[3];
            $direction = strtoupper($matches[4]);

            $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);

            if ($direction == 'S' || $direction == 'W') {
                $decimal = $decimal * -1;
            }

            return $decimal;
        }

        return null;
    }

    /**
     * 2. MODEL MAPPING
     */
    public function model(array $row)
    {
        // Pastikan nama key array sesuai dengan HEADER di Excel (huruf kecil)
        return new DataMenara([
            'kode'          => $row['kode'] ?? null,
            'provider'      => $row['provider'] ?? null,
            'kelurahan'     => $row['kelurahan'] ?? null,
            'kecamatan'     => $row['kecamatan'] ?? null,
            'alamat'        => $row['alamat'] ?? null,
            'longitude'     => $row['longitude'] ?? null,
            'latitude'      => $row['latitude'] ?? null,
            'status'        => $row['status'] ?? null,
            'tinggi_tower'  => $row['tinggi_tower'] ?? null,
        ]);
    }

    /**
     * 3. RULES (VALIDASI)
     * Semua diubah jadi 'nullable' sesuai permintaan klien.
     */
    public function rules(): array
    {
        return [
            'kode'          => ['nullable', 'unique:data_menara,kode'],
            'provider'      => ['nullable'],
            'kelurahan'     => ['nullable'],
            'kecamatan'     => ['nullable'],
            'alamat'        => ['nullable'],
            'longitude'     => ['nullable', 'numeric'],
            'latitude'      => ['nullable', 'numeric'],
            'status'        => ['nullable'],
            'tinggi_tower'  => ['nullable', 'integer'],
        ];
    }
}
