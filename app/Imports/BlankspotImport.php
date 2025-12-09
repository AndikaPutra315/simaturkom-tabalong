<?php

namespace App\Imports;

use App\Models\Blankspot;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class BlankspotImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    /**
     * Mengubah format DMS ke Desimal sebelum validasi
     */
    public function prepareForValidation($data, $index)
    {
        // Pastikan header Excel menggunakan huruf kecil (desa, kecamatan, latitude, ...)

        if (!empty($data['latitude'])) {
            $data['latitude'] = $this->convertDMSToDecimal($data['latitude']);
        }

        if (!empty($data['longitude'])) {
            $data['longitude'] = $this->convertDMSToDecimal($data['longitude']);
        }

        return $data;
    }

    private function convertDMSToDecimal($coordinate)
    {
        // Jika sudah angka (desimal), kembalikan langsung
        if (is_numeric($coordinate)) {
            // Cek jika angka terlalu besar (kemungkinan lupa titik desimal), kita bantu bagi
            // Asumsi Latitude max 90, Longitude max 180.
            // Jika nilai > 1000, kemungkinan itu salah format integer (misal -1778015)
            if (abs($coordinate) > 180) {
                // Coba ubah manual (ini hanya tebakan cerdas, sebaiknya data Excel diperbaiki)
                return (float) substr_replace($coordinate, '.', (strpos($coordinate, '-') === false ? 3 : 4), 0);
            }
            return (float) $coordinate;
        }

        $coordinate = trim($coordinate);
        // Regex format DMS: 1°45'37.61"S
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

    public function model(array $row)
    {
        return new Blankspot([
            'desa'      => $row['desa'],
            'kecamatan' => $row['kecamatan'],
            'site'      => $row['site'],
            'latitude'  => $row['latitude'],
            'longitude' => $row['longitude'],
            'layanan_pendidikan' => $row['layanan_pendidikan'] ?? null,
            'layanan_kesehatan' => $row['layanan_kesehatan'] ?? null,
            // Jika status kosong di Excel, default ke 'Diusulkan'
            'status'    => $row['status'] ?? 'Diusulkan',
        ]);
    }

    public function rules(): array
    {
        return [
            'desa'      => ['required', 'string'],
            'kecamatan' => ['required', 'string'],
            'site'      => ['required', 'string'],
            'latitude'  => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ];
    }
}
