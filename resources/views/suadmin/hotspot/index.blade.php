<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Hotspot - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
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
                            <h1 class="mb-0 fw-bold">Kelola Data Hotspot</h1>
                            <p class="text-muted mb-0">Tambah, edit, atau hapus data titik hotspot.</p>
                        </div>
                        <div class="d-flex gap-2">
                             <a href="{{ route('suadmin.hotspot.pdf', request()->query()) }}" class="btn btn-danger fw-bold" target="_blank">
                                <i class="fas fa-file-pdf me-2"></i>Generate PDF
                            </a>
                            
                            <button type="button" class="btn btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#importHotspotModal">
                                <i class="fas fa-file-excel me-2"></i>Impor Excel
                            </button>

                            <a href="{{ route('suadmin.hotspot.create') }}" class="btn-custom btn-add fw-bold">
                                <i class="fas fa-plus me-2"></i>Tambah Hotspot
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    {{-- ... (Semua kode untuk menampilkan session 'success', 'error', 'validation errors' tetap di sini) ... --}}
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

                    <form method="GET" action="{{ route('suadmin.hotspot.index') }}" class="mb-4">
                        <div class="row g-2">
                            <div class="col-md-5">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama, alamat, tahun..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <select name="filter_keterangan" class="form-select">
                                    <option value="">Semua Keterangan</option>
                                    <option value="skpd" @selected(request('filter_keterangan') == 'skpd')>SKPD</option>
                                    <option value="layanan_gratis" @selected(request('filter_keterangan') == 'layanan_gratis')>Layanan Internet Gratis</option>
                                    <option value="starlink" @selected(request('filter_keterangan') == 'starlink')>Starlink Akses</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                                <a href="{{ route('suadmin.hotspot.index') }}" class="btn btn-secondary w-100">Refresh</a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Tempat</th>
                                    <th>Alamat</th>
                                    <th>Tahun</th>
                                    <th>Keterangan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($hotspots as $hotspot)
                                    <tr>
                                        <td>{{ $hotspot->nama_tempat }}</td>
                                        <td>{{ $hotspot->alamat }}</td>
                                        <td>{{ $hotspot->tahun }}</td>
                                        <td>{{ $hotspot->keterangan }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('suadmin.hotspot.edit', $hotspot->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('suadmin.hotspot.destroy', $hotspot->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            Tidak ada data yang cocok dengan pencarian Anda.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $hotspots->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="importHotspotModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('suadmin.hotspot.import.handle') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Upload Data Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info py-2">
                            <p class="mb-1 fw-bold">Pastikan urutan kolom sesuai template:</p>
                            <small class="text-muted">nama_tempat, alamat, tahun, keterangan</small>
                            
                            <a href="{{ asset('files/contoh template hotspot.xlsx') }}" class="btn btn-sm btn-outline-success mt-2" download>
                                <i class="fas fa-file-excel me-1"></i> Download Template Contoh
                            </a>
                            
                        </div>
                        <div class="mb-3">
                            <label for="excel_file" class="form-label">Pilih file Excel (.xlsx, .xls)</label>
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