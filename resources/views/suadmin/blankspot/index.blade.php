<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Blankspot - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background-color: #f4f7fc; }
        main { flex: 1; padding: 40px 0; }
        .container-fluid { max-width: 1800px; padding: 0 30px; }

        .content-card { background-color: #ffffff; border-radius: 12px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07); overflow: hidden; }

        .card-header { padding: 25px 30px; border-bottom: 1px solid #eef2f9; }
        .card-header h1 { margin: 0; font-size: 1.75rem; font-weight: 600; color: #1a237e; }
        .card-header p { margin: 5px 0 0 0; color: #66789a; font-size: 0.95rem; }

        .toolbar { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; padding: 20px 30px; gap: 15px; }
        .filter-group { display: flex; gap: 15px; align-items: center; }
        .filter-group select { padding: 10px 15px; border: 1px solid #dcdfe6; border-radius: 6px; font-size: 0.9rem; }

        .action-buttons { display: flex; gap: 10px; align-items: center; }
        .btn-custom {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            border: none;
        }
        .btn-custom i { margin-right: 8px; }
        .btn-refresh { background-color: #1a237e; color: white; }
        .btn-refresh:hover { background-color: #151c68; color: white; }
        .btn-pdf { background-color: #c82333; color: white; }
        .btn-pdf:hover { background-color: #a21b29; color: white; }
        .btn-add { background-color: #0d6efd; color: white; }
        .btn-add:hover { background-color: #0b5ed7; color: white; }
        .btn-import { background-color: #198754; color: white; }
        .btn-import:hover { background-color: #157347; color: white; }

        .table-responsive { width: 100%; overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; white-space: nowrap; }
        .data-table th, .data-table td { padding: 15px 20px; text-align: left; font-size: 0.9rem; vertical-align: middle; }
        .data-table thead { background-color: #f8f9fc; }
        .data-table th { font-weight: 600; color: #33425e; text-transform: uppercase; letter-spacing: 0.5px; }
        .data-table tbody tr { border-bottom: 1px solid #eef2f9; }
        .data-table tbody tr:hover { background-color: #f4f7fc; }

        .status-badge { display: inline-block; padding: 5px 12px; border-radius: 15px; font-weight: 500; font-size: 0.8rem; text-transform: capitalize; }

        .status-diusulkan { background-color: #e2e3e5; color: #383d41; } /* Abu-abu */
        .status-tercover { background-color: #d1e7dd; color: #0f5132; } /* Hijau */
        .status-proses { background-color: #fff3cd; color: #664d03; }   /* Kuning */

        .table-footer { display: flex; justify-content: space-between; align-items: center; padding: 20px 30px; border-top: 1px solid #eef2f9; }
        .entries-info { color: #66789a; font-size: 0.9rem; }

        .coord-text { font-family: monospace; color: #1a237e; }
    </style>
</head>
<body>

    @include('includes.header')

    <main>
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!! session('error') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="content-card">
                <div class="card-header">
                    <div>
                        <h1>Kelola Data Blankspot</h1>
                        <p>Daftar titik lokasi blankspot di Kabupaten Tabalong.</p>
                    </div>
                </div>

                <div class="toolbar">
                    <form action="{{ route('suadmin.blankspot.index') }}" method="GET" class="filter-group" style="flex-grow: 1;">
                        <div class="input-group" style="max-width: 400px;">
                            <input type="text" class="form-control" name="search" placeholder="Cari Desa, Kecamatan..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                    <div class="action-buttons">
                        <a href="{{ route('suadmin.blankspot.index') }}" class="btn-custom btn-refresh">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </a>
                        <a href="{{ route('suadmin.blankspot.pdf') }}" class="btn-custom btn-pdf" target="_blank">
                            <i class="fas fa-file-pdf"></i> Generate PDF
                        </a>

                        <button type="button" class="btn-custom btn-import" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                            <i class="fas fa-file-excel"></i> Import Excel
                        </button>

                        <a href="{{ route('suadmin.blankspot.create') }}" class="btn-custom btn-add">
                            <i class="fas fa-plus"></i> Tambah Data
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Desa</th>
                                <th>Kecamatan</th>
                                <th>Site ID</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Layanan Pendidikan</th>
                                <th>Layanan Kesehatan</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($blankspots as $bs)
                                <tr>
                                    <td>{{ $bs->desa }}</td>
                                    <td>{{ $bs->kecamatan }}</td>
                                    <td>{{ $bs->site }}</td>
                                    <td class="coord-text">{{ $bs->latitude }}</td>
                                    <td class="coord-text">{{ $bs->longitude }}</td>
                                    <td>{{ $bs->layanan_pendidikan ?? '-' }}</td>
                                    <td>{{ $bs->layanan_kesehatan ?? '-' }}</td>
                                    <td>
                                        {{-- PERBAIKAN LOGIKA STATUS --}}
                                        @if($bs->status == 'Diusulkan')
                                            <span class="status-badge status-diusulkan">{{ $bs->status }}</span>

                                        @elseif($bs->status == 'Sudah Tercover' || $bs->status == 'Selesai')
                                            {{-- Jika Selesai, pakai warna hijau (tercover) --}}
                                            <span class="status-badge status-tercover">{{ $bs->status }}</span>

                                        @else
                                            {{-- Jika lainnya (Proses, dll), pakai warna kuning dan tampilkan teks aslinya --}}
                                            <span class="status-badge status-proses">{{ $bs->status }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('suadmin.blankspot.edit', $bs->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit Data" style="color:white">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('suadmin.blankspot.destroy', $bs->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Hapus Data" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <h5>Data Tidak Ditemukan</h5>
                                        <p>Belum ada data blankspot yang tersedia.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="table-footer">
                    <div class="entries-info">
                        Menampilkan {{ $blankspots->firstItem() }} sampai {{ $blankspots->lastItem() }} dari {{ $blankspots->total() }} entri
                    </div>
                    {{ $blankspots->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="importExcelModalLabel">Upload Data Excel (Blankspot)</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('suadmin.blankspot.import.handle') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p>Pilih file Excel (.xlsx atau .xls) untuk diimpor.</p>
                        <p class="mb-1"><small>Kolom yang wajib ada (Header huruf kecil):</small></p>
                        <small><code>desa</code>, <code>kecamatan</code>, <code>site</code>, <code>latitude</code>, <code>longitude</code>, <code>status</code></small>

                        <hr>

                        <div class="my-3">
                            <label for="file" class="form-label fw-bold">Pilih File:</label>
                            <input class="form-control" type="file" name="file" id="file"
                                   accept=".xlsx, .xls, .csv" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Import Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('includes.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
</body>
</html>
