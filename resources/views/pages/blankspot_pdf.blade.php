<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Blankspot</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 10px; }
        h1 { text-align: center; margin-bottom: 20px; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #777; padding: 6px; text-align: left; }
        thead { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Data Blankspot Kabupaten Tabalong</h1>
    <table>
        <thead>
            <tr>
                <th>Desa</th>
                <th>Kecamatan</th>
                <th>Site</th>
                <th>Titik/Lokasi Blankspot</th>
                <th>Layanan Pendidikan</th>
                <th>Layanan Kesehatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($blankspots as $data)
                <tr>
                    <td>{{ $data->desa }}</td>
                    <td>{{ $data->kecamatan }}</td>
                    <td>{{ $data->site }}</td>
                    <td>{{ $data->lokasi_blankspot }}</td>
                    <td>{{ $data->layanan_pendidikan }}</td>
                    <td>{{ $data->layanan_kesehatan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>