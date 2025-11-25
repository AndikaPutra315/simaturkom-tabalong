<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>Data Hotspot</title>
    <style>
        body { font-family: sans-serif; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dddddd; padding: 8px; text-align: left; }
        thead { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Data Hotspot Kabupaten Tabalong</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Tempat</th>
                <th>Alamat</th>
                <th>Tahun</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hotspots as $hotspot)
                <tr>
                    <td>{{ $hotspot->nama_tempat }}</td>
                    <td>{{ $hotspot->alamat }}</td>
                    <td>{{ $hotspot->tahun }}</td>
                    <td>{{ $hotspot->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
