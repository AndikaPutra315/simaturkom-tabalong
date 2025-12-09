<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Regulasi - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background-color: #f4f7fc; }
        .content-card { background-color: #ffffff; border-radius: 12px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07); }
        .card-header h1 { color: #1a237e; }
        .table thead th { text-transform: uppercase; font-weight: 600; color: #33425e;}
        .table td { vertical-align: middle; }
    </style>
</head>
<body>
    @include('includes.header')

    <main class="py-5">
        <div class="container">
            <div class="content-card">
                <div class="card-header p-4 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="mb-0 fw-bold">Kelola Regulasi</h1>
                            <p class="text-muted mb-0">Tambah, edit, atau hapus dokumen regulasi.</p>
                        </div>
                        <a href="{{ route('suadmin.regulasi.create') }}" class="btn btn-primary fw-bold">
                            <i class="fas fa-plus me-2"></i>Tambah Dokumen
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Dokumen</th>
                                    <th class="text-center">Dilihat</th>
                                    <th class="text-center">Diunduh</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($regulasi as $item)
                                    <tr>
                                        <td>
                                            <a href="{{ route('regulasi.view.public', $item->id) }}" target="_blank">{{ $item->nama_dokumen }}</a>
                                            <small class="d-block text-muted">{{ $item->nama_file_asli }}</small>
                                        </td>
                                        <td class="text-center">{{ $item->view_count }}</td>
                                        <td class="text-center">{{ $item->download_count }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('suadmin.regulasi.download', $item->id) }}" class="btn btn-success btn-sm" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a href="{{ route('suadmin.regulasi.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('suadmin.regulasi.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus dokumen ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            Data regulasi belum tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('includes.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
