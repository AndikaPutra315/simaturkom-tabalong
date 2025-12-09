<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Regulasi - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7fc; }
        .content-card { background-color: #ffffff; border-radius: 12px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07); }
        .card-header h1 { color: #1a237e; }
    </style>
</head>
<body>
    @include('includes.header')

    <main class="py-5">
        <div class="container">
            <div class="content-card">
                 <div class="card-header p-4 border-bottom">
                    <h1 class="mb-0 fw-bold">Edit Dokumen: {{ $regulasi->nama_dokumen }}</h1>
                 </div>
                 <div class="card-body p-4">
                    <form action="{{ route('suadmin.regulasi.update', $regulasi->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nama_dokumen" class="form-label">Nama Dokumen</label>
                            <input type="text" class="form-control" id="nama_dokumen" name="nama_dokumen" value="{{ old('nama_dokumen', $regulasi->nama_dokumen) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="file_dokumen" class="form-label">Upload File Baru (PDF)</label>
                            <p class="text-muted small">File saat ini: <a href="{{ asset('storage/' . $regulasi->file_path) }}" target="_blank">{{ $regulasi->nama_file_asli }}</a>. Kosongkan jika tidak ingin mengubah file.</p>
                            <input class="form-control" type="file" id="file_dokumen" name="file_dokumen" accept=".pdf">
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('suadmin.regulasi.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Update Dokumen</button>
                        </div>
                    </form>
                 </div>
            </div>
        </div>
    </main>

    @include('includes.footer')
</body>
</html>

