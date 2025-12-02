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

    public function prepareForValidation($data, $index)
    {

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
        if (is_numeric($coordinate)) {
            return (float) $coordinate;
        }

        $coordinate = trim($coordinate);

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
            'status'    => $row['status'],
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
            'status'    => ['required', 'string'],
        ];
    }
}
