<!DOCTYPE html>
<html>
<head>
    <title>Data Bakti</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; font-size: 10px; }
        th { background-color: #f2f2f2; text-align: left; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Data Bakti - SIMATURKOM</h1>
    <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Provider (Nama)</th>
                <th>Kecamatan</th>
                <th>Alamat</th>
                <th>Koordinat</th>
                <th>Status</th>
                <th>Tinggi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataBakti as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->provider }}</td>
                <td>{{ $item->kecamatan }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->latitude }}, {{ $item->longitude }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->tinggi_tower ? $item->tinggi_tower . ' M' : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
