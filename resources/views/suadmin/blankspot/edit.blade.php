<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Blankspot - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    {{-- Menggunakan CSS Admin yang sama agar konsisten --}}
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7fc; }
        .fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; transform: translateY(20px); }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }

        .form-card-header { border-bottom: 1px solid #eef2f9; }
        .form-card-header .title { font-size: 1.25rem; font-weight: 600; color: #1a237e; }

        .form-label { color: #344767; font-size: 0.875rem; }
        .form-control, .form-select { padding: 0.6rem 1rem; border-color: #d2d6da; border-radius: 0.5rem; font-size: 0.9rem; }
        .form-control:focus, .form-select:focus { border-color: #1a237e; box-shadow: 0 0 0 0.2rem rgba(26, 35, 126, 0.25); }

        .btn-primary { background-color: #1a237e; border-color: #1a237e; }
        .btn-primary:hover { background-color: #151c68; border-color: #151c68; }
    </style>
</head>
<body>
    @include('includes.header')

    <main class="container py-5">
        <div class="card fade-in-up border-0 shadow-sm">
            <div class="card-header bg-white py-3 form-card-header">
                <span class="title mb-0">Edit Data Blankspot: {{ $blankspot->desa }}</span>
            </div>
            <div class="card-body p-4 p-lg-5">
                <form action="{{ route('suadmin.blankspot.update', $blankspot->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <h5 class="mb-0" style="color: #1a237e; font-weight: 600;">Informasi Lokasi</h5>

                        {{-- Desa --}}
                        <div class="col-md-6">
                            <label for="desa" class="form-label fw-bold">Desa</label>
                            <input type="text" class="form-control @error('desa') is-invalid @enderror" id="desa" name="desa" value="{{ old('desa', $blankspot->desa) }}" required>
                            @error('desa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Kecamatan --}}
                        <div class="col-md-6">
                            <label for="kecamatan" class="form-label fw-bold">Kecamatan</label>
                            <input type="text" class="form-control @error('kecamatan') is-invalid @enderror" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $blankspot->kecamatan) }}" required>
                            @error('kecamatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Site --}}
                        <div class="col-12">
                            <label for="site" class="form-label fw-bold">Site / Nama Lokasi</label>
                            <input type="text" class="form-control @error('site') is-invalid @enderror" id="site" name="site" value="{{ old('site', $blankspot->site) }}" required>
                            @error('site')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-3">
                        <h5 class="mb-0" style="color: #1a237e; font-weight: 600;">Koordinat Peta</h5>

                        {{-- Latitude --}}
                        <div class="col-md-6">
                            <label for="latitude" class="form-label fw-bold">Latitude</label>
                            <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude', $blankspot->latitude) }}" required>
                            @error('latitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Longitude --}}
                        <div class="col-md-6">
                            <label for="longitude" class="form-label fw-bold">Longitude</label>
                            <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude', $blankspot->longitude) }}" required>
                            @error('longitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-3">
                        <h5 class="mb-0" style="color: #1a237e; font-weight: 600;">Status & Layanan</h5>

                        {{-- Layanan Pendidikan --}}
                        <div class="col-md-6">
                            <label for="layanan_pendidikan" class="form-label fw-bold">Layanan Pendidikan</label>
                            <input type="text" class="form-control" id="layanan_pendidikan" name="layanan_pendidikan" value="{{ old('layanan_pendidikan', $blankspot->layanan_pendidikan) }}">
                        </div>

                        {{-- Layanan Kesehatan --}}
                        <div class="col-md-6">
                            <label for="layanan_kesehatan" class="form-label fw-bold">Layanan Kesehatan</label>
                            <input type="text" class="form-control" id="layanan_kesehatan" name="layanan_kesehatan" value="{{ old('layanan_kesehatan', $blankspot->layanan_kesehatan) }}">
                        </div>

                        {{-- Status --}}
                        <div class="col-md-12">
                            <label for="status" class="form-label fw-bold">Status Pengajuan</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="Diusulkan" {{ old('status', $blankspot->status) == 'Diusulkan' ? 'selected' : '' }}>Diusulkan</option>
                                <option value="Selesai" {{ old('status', $blankspot->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Dalam Pembangunan" {{ old('status', $blankspot->status) == 'Dalam Pembangunan' ? 'selected' : '' }}>Dalam Pembangunan</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary">Update Data</button>
                        <a href="{{ route('suadmin.blankspot.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @include('includes.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
