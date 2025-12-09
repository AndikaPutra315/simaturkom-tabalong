<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Regulasi Baru - Admin</title>
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
                    <h1 class="mb-0 fw-bold">Tambah Dokumen Regulasi Baru</h1>
                 </div>
                 <div class="card-body p-4">
                    <form action="{{ route('suadmin.regulasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_dokumen" class="form-label">Nama Dokumen</label>
                            <input type="text" class="form-control" id="nama_dokumen" name="nama_dokumen" required>
                        </div>
                        <div class="mb-3">
                            <label for="file_dokumen" class="form-label">Upload File (PDF)</label>
                            <input class="form-control" type="file" id="file_dokumen" name="file_dokumen" accept=".pdf" required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('suadmin.regulasi.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Dokumen</button>
                        </div>
                    </form>
                 </div>
            </div>
        </div>
    </main>

    @include('includes.footer')
</body>
</html>

