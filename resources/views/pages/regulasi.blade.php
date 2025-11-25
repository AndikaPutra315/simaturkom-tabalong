<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regulasi - SIMATURKOM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/regulasi.css') }}">
</head>
<body>
    @include('includes.header')

    <main class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h1 class="fw-bold" style="color: #1a237e;">Dokumen Regulasi</h1>
                    <p class="text-muted">Daftar peraturan dan dokumen terkait menara telekomunikasi.</p>
                </div>
            </div>

            <div class="row g-4">
                @forelse ($regulasiData as $dokumen)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 d-flex flex-column">
                            <div class="card-body">
                                <h5 class="card-title">{{ $dokumen->nama_dokumen }}</h5>
                            </div>
                            <div class="card-footer d-flex gap-2">
                                <a href="{{ route('regulasi.view.public', $dokumen->id) }}" class="btn btn-outline-primary w-100" target="_blank">
                                    <i class="fas fa-eye me-2"></i> Lihat
                                </a>
                                <a href="{{ route('regulasi.download.public', $dokumen->id) }}" class="btn btn-primary w-100">
                                    <i class="fas fa-download me-2"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Saat ini belum ada dokumen regulasi yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    @include('includes.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
