<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Menara Telekomunikasi</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 10px; }
        h1 { text-align: center; margin-bottom: 20px; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #777; padding: 6px; text-align: left; }
        thead { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Data Menara Telekomunikasi Kabupaten Tabalong</h1>
    <table>
        <thead>
            <tr>
                {{-- Kolom Kode DIHAPUS untuk Guest --}}
                <th>Provider</th>
                <th>Desa/Kelurahan</th>
                <th>Kecamatan</th>
                <th>Alamat</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Status</th>
                <th>Tinggi Tower (m)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($menaraData as $menara)
                <tr>
                    {{-- Data Kode DIHAPUS untuk Guest --}}
                    <td>{{ $menara->provider }}</td>
                    <td>{{ $menara->kelurahan }}</td>
                    <td>{{ $menara->kecamatan }}</td>
                    <td>{{ $menara->alamat }}</td>
                    <td>{{ $menara->longitude }}</td>
                    <td>{{ $menara->latitude }}</td>
                    <td>{{ ucfirst($menara->status) }}</td>
                    <td>{{ $menara->tinggi_tower }}</td>
                </tr>
            @empty
                <tr>
                    {{-- Colspan diubah dari 9 menjadi 8 --}}
                    <td colspan="8" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
