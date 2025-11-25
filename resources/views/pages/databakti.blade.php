<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Bakti - SIMATURKOM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* SEMUA CSS KUSTOM DARI datamenara.blade.php DISALIN KE SINI */
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
            padding: 40px 0;
        }
        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .content-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }
        .card-header {
            padding: 25px 30px;
            border-bottom: 1px solid #eef2f9;
        }
        .card-header h1 {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 600;
            color: #1a237e;
        }
        .card-header p {
            margin: 5px 0 0 0;
            color: #66789a;
            font-size: 0.95rem;
        }
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            padding: 20px 30px;
            gap: 15px;
        }
        .filter-search-form {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 15px;
        }
        .filter-group {
            display: flex;
            gap: 15px;
        }
        .filter-group select,
        .input-group input {
            padding: 10px 15px;
            border: 1px solid #dcdfe6;
            border-radius: 6px;
            font-size: 0.9rem;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
        }
        .btn-refresh {
            background-color: #1a237e;
            color: white;
        }
        .btn-pdf {
            background-color: #c82333;
            color: white;
        }
        .action-buttons i {
            margin-right: 8px;
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }
        .data-table th,
        .data-table td {
            padding: 15px 20px;
            text-align: left;
            font-size: 0.9rem;
        }
        .data-table thead {
            background-color: #f8f9fc;
        }
        .data-table th {
            font-weight: 600;
            color: #33425e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .data-table tbody tr {
            border-bottom: 1px solid #eef2f9;
        }
        .data-table tbody tr:hover {
            background-color: #f4f7fc;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 15px;
            font-weight: 500;
            font-size: 0.8rem;
            text-transform: capitalize;
        }
        .status-aktif {
            background-color: #e7f5e8;
            color: #28a745;
        }
        .status-nonaktif {
            background-color: #f8d7da;
            color: #721c24;
        }
        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            border-top: 1px solid #eef2f9;
        }
        .entries-info {
            color: #66789a;
            font-size: 0.9rem;
        }
        .pagination-nav .pagination {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 5px;
        }
        .pagination-nav .pagination .page-item .page-link {
            display: block;
            padding: 8px 14px;
            text-decoration: none;
            color: #555;
            background-color: #fff;
            border: 1px solid #dcdfe6;
            border-radius: 6px;
        }
        .pagination-nav .pagination .page-item.active .page-link {
            background-color: #1a237e;
            color: white;
            border-color: #1a237e;
        }
    </style>
</head>

<body>

    @include('includes.header')

    <main>
        <div class="container">
            <div class="content-card">
                <div class="card-header">
                    <h1>Data Bakti</h1>
                    <p>Jelajahi data infrastruktur Bakti yang terdaftar di Kabupaten Tabalong.</p>
                </div>

                <div class="toolbar">
                    <form action="{{ route('databakti') }}" method="GET" class="filter-search-form">
                        <div class="filter-group">
                            <select name="provider" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua Provider</option>
                                @foreach($providers as $provider)
                                    <option value="{{ $provider->provider }}" @if(request('provider') == $provider->provider) selected @endif>{{ $provider->provider }}</option>
                                @endforeach
                            </select>
                            <select name="kecamatan" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua Kecamatan</option>
                                @foreach($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->kecamatan }}" @if(request('kecamatan') == $kecamatan->kecamatan) selected @endif>{{ $kecamatan->kecamatan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group" style="width: auto;">
                            <input type="text" class="form-control" name="search" placeholder="Cari data..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>

                    <div class="action-buttons">
                        <a href="{{ route('databakti') }}" class="btn-action btn-refresh"><i class="fas fa-sync-alt"></i> Refresh</a>
                        <a href="{{ route('databakti.pdf', request()->query()) }}" class="btn-action btn-pdf" target="_blank"><i class="fas fa-file-pdf"></i> Generate PDF</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Provider (Nama)</th>
                                <th>DESA/Kelurahan</th>
                                <th>Kecamatan</th>
                                <th>Alamat</th>
                                <th>Longitude</th>
                                <th>Latitude</th>
                                <th>Status</th>
                                <th>Tinggi Tower</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataBakti as $item)
                                <tr>
                                    <td>{{ $item->provider }}</td>
                                    <td>{{ $item->kelurahan }}</td>
                                    <td>{{ $item->kecamatan }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->longitude }}</td>
                                    <td>{{ $item->latitude }}</td>
                                    <td>
                                        @if (strtolower($item->status) == 'aktif')
                                            <span class="status-badge status-aktif">Aktif</span>
                                        @else
                                            <span class="status-badge status-nonaktif">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->tinggi_tower }} m</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 20px;">
                                        <h5>Data Tidak Ditemukan</h5>
                                        <p>Tidak ada data yang cocok dengan kriteria filter atau pencarian Anda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <div class="entries-info">
                        Menampilkan {{ $dataBakti->firstItem() }} sampai {{ $dataBakti->lastItem() }} dari {{ $dataBakti->total() }} entri
                    </div>
                    <nav class="pagination-nav">
                        {{ $dataBakti->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            </div>
        </div>
    </main>

    @include('includes.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
