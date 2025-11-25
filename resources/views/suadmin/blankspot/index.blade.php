<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Blankspot - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">    
</head>
<body>
    @include('includes.header')
    <main class="py-5">
        <div class="container">
            <div class="content-card">
                <div class="card-header p-4 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="mb-0 fw-bold">Kelola Data Blankspot</h1>
                            <p class="text-muted mb-0">Tambah, edit, atau hapus data titik blankspot.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="fas fa-file-excel me-2"></i>Impor Excel
                            </button>
                            <a href="{{ route('suadmin.blankspot.pdf', request()->query()) }}" class="btn btn-danger fw-bold" target="_blank">
                                <i class="fas fa-file-pdf me-2"></i>Generate PDF
                            </a>
                            <a href="{{ route('suadmin.blankspot.create') }}" class="btn-custom btn-add fw-bold">
                                <i class="fas fa-plus me-2"></i>Tambah Data
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    {{-- Tampilkan notifikasi --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal!</strong> Periksa kembali input Anda.
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="GET" action="{{ route('suadmin.blankspot.index') }}" class="mb-4">
                        <div class="row g-2">
                            <div class="col-md-9">
                                <input type="text" name="search" class="form-control" placeholder="Cari desa, kecamatan, site, lokasi..." value="{{ $search ?? '' }}">
                            </div>
                            <div class="col-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                                <a href="{{ route('suadmin.blankspot.index') }}" class="btn btn-secondary w-100">Refresh</a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Desa</th>
                                    <th>Kecamatan</th>
                                    <th>Site</th>
                                    <th>Titik/Lokasi Blankspot</th>
                                    <th>Layanan Pendidikan</th>
                                    <th>Layanan Kesehatan</th>
                                    <th>Status</th> 
                                    <th class="text-center">Aksi</th>
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
                                        <td>
                                            @php
                                                $badgeClass = match($data->status) {
                                                    'Selesai' => 'bg-success',
                                                    'Pembangunan' => 'bg-warning text-dark',
                                                    default => 'bg-secondary', // Untuk 'Diusulkan' atau lainnya
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">
                                                {{ $data->status }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('suadmin.blankspot.edit', $data->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('suadmin.blankspot.destroy', $data->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            Data blankspot belum tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $blankspots->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('suadmin.blankspot.import.handle') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Upload Data Blankspot</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info py-2">
                            <p class="mb-1 fw-bold">Pastikan header kolom sesuai template:</p>
                            <small class="text-muted">desa, kecamatan, site, lokasi_blankspot, layanan_pendidikan, layanan_kesehatan</small>
                            
                            <a href="{{ asset('files/contoh template blankspot.xlsx') }}" class="btn btn-sm btn-outline-success mt-2" download>
                                <i class="fas fa-file-excel me-1"></i> Download Template Contoh
                            </a>
                        </div>
                        <div class="mb-3">
                            <label for="excel_file" class="form-label">Pilih file Excel (.xlsx, .xls, .csv)</label>
                            <input type="file" class="form-control" id="excel_file" name="excel_file" required accept=".xlsx,.xls,.csv">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Impor Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @include('includes.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>