<?php

namespace App\Imports;

use App\Models\DataBakti;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class DataBaktiImport implements ToModel, WithStartRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    /**
     * Fungsi ini berjalan SEBELUM Validasi.
     * Mengubah format DMS menjadi Desimal.
     */
    public function prepareForValidation($data, $index)
    {
        // 1. Handle Konversi Longitude (Sekarang Index 4)
        if (!empty($data['4'])) {
            $data['4'] = $this->convertDMSToDecimal($data['4']);
        }

        // 2. Handle Konversi Latitude (Sekarang Index 5)
        if (!empty($data['5'])) {
            $data['5'] = $this->convertDMSToDecimal($data['5']);
        }

        // 3. Handle Tinggi Tower (Sekarang Index 7)
        // Bersihkan jika ada teks " meter" atau "m"
        if (!empty($data['7'])) {
             $data['7'] = (int) filter_var($data['7'], FILTER_SANITIZE_NUMBER_INT);
        }

        return $data;
    }

    /**
     * Helper Function: Rumus Matematika Konversi DMS ke Desimal
     */
    private function convertDMSToDecimal($coordinate)
    {
        // Jika sudah angka biasa (desimal), kembalikan langsung
        if (is_numeric($coordinate)) {
            return (float) $coordinate;
        }

        $coordinate = trim($coordinate);

        // Regex untuk menangkap format: 1°45'37.61"S
        if (preg_match('/(\d+)°(\d+)\'([\d.]+)"([NSEW])/i', $coordinate, $matches)) {
            $degrees = (float) $matches[1];
            $minutes = (float) $matches[2];
            $seconds = (float) $matches[3];
            $direction = strtoupper($matches[4]);

            // Rumus: Derajat + (Menit/60) + (Detik/3600)
            $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);

            // Jika Arah Selatan (S) atau Barat (W), jadikan negatif
            if ($direction == 'S' || $direction == 'W') {
                $decimal = $decimal * -1;
            }

            return $decimal;
        }

        return null;
    }

    /**
     * @param array $row
     */
    public function model(array $row)
    {
        if (!array_filter($row)) {
            return null;
        }

        return new DataBakti([
            // Kode dihapus
            'provider'      => $row[0],          // Index 0 (Dulunya 1)
            'kelurahan'     => $row[1],          // Index 1
            'kecamatan'     => $row[2],          // Index 2
            'alamat'        => $row[3] ?? null,  // Index 3
            'longitude'     => isset($row[4]) ? (float) $row[4] : null, // Index 4
            'latitude'      => isset($row[5]) ? (float) $row[5] : null, // Index 5
            'status'        => $row[6] ?? null,  // Index 6
            'tinggi_tower'  => isset($row[7]) ? (int) $row[7] : null,   // Index 7
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            // Provider/Nama (Index 0) wajib diisi
            '0' => ['required', 'string', 'max:255'],

            // Validasi Kode DIHAPUS

            // Longitude (Index 4)
            '4' => ['nullable', 'numeric'],

            // Latitude (Index 5)
            '5' => ['nullable', 'numeric'],

            // Tinggi (Index 7)
            '7' => ['nullable', 'integer'],
        ];
    }

    public function customValidationAttributes()
    {
        return [
            '0' => 'Nama (Provider)',
            '1' => 'Kelurahan',
            '2' => 'Kecamatan',
            '4' => 'Longitude',
            '5' => 'Latitude',
            '7' => 'Tinggi Tower',
        ];
    }
}
