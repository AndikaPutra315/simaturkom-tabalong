<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Blankspot - Admin</title>
    {{-- Bootstrap & Fonts (Sama seperti Data Menara) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        /* CSS Profesional (Diadopsi dari Data Menara) */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
            color: #333;
        }
        main {
            padding: 40px 0;
            min-height: 80vh;
        }
        .container-fluid {
            max-width: 1200px;
            padding: 0 30px;
        }

        /* Card Styling */
        .card.fade-in-up {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
            background-color: #ffffff;
            overflow: hidden;
        }

        .form-card-header {
            background-color: #fff;
            border-bottom: 1px solid #eef2f9;
            padding: 25px 40px;
        }
        .form-card-header .title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a237e;
        }

        .card-body {
            padding: 40px;
        }

        /* Form Inputs */
        .form-label {
            font-weight: 600;
            color: #33425e;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            padding: 10px 15px;
            border: 1px solid #dcdfe6;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #1a237e;
            box-shadow: 0 0 0 0.2rem rgba(26, 35, 126, 0.1);
        }

        /* Divider */
        hr.my-3 {
            border-top: 1px solid #eef2f9;
            opacity: 1;
            margin: 2rem 0 !important;
        }
        h5.mb-0 {
            font-weight: 600;
            color: #1a237e;
            margin-bottom: 1.5rem !important;
            font-size: 1.1rem;
        }

        /* Buttons */
        .btn-primary {
            background-color: #1a237e;
            border-color: #1a237e;
            padding: 10px 30px;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #151c68;
            border-color: #151c68;
        }
        .btn-secondary {
            background-color: #f8f9fa;
            border-color: #dcdfe6;
            color: #333;
            padding: 10px 30px;
            font-weight: 500;
        }
        .btn-secondary:hover {
            background-color: #e2e6ea;
            color: #333;
        }
    </style>
</head>
<body>
    @include('includes.header')

    <main class="container-fluid">
        <div class="card fade-in-up">
            <div class="card-header form-card-header">
                <span class="title mb-0">Tambah Data Blankspot</span>
            </div>

            <div class="card-body">
                <form action="{{ route('suadmin.blankspot.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        {{-- BAGIAN 1: LOKASI --}}
                        <h5 class="mb-0">Informasi Lokasi</h5>

                        <div class="col-md-6">
                            <label class="form-label">Desa <span class="text-danger">*</span></label>
                            <input type="text" name="desa" class="form-control @error('desa') is-invalid @enderror" value="{{ old('desa') }}" required>
                            @error('desa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                            <input type="text" name="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror" value="{{ old('kecamatan') }}" required>
                            @error('kecamatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Site ID / Nama Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="site" class="form-control @error('site') is-invalid @enderror" value="{{ old('site') }}" required>
                            @error('site')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- BAGIAN 2: KOORDINAT --}}
                        <hr class="my-3">
                        <h5 class="mb-0">Koordinat Peta</h5>

                        <div class="col-md-6">
                            <label class="form-label">Latitude <span class="text-danger">*</span></label>
                            <input type="text" name="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude') }}" placeholder="-2.xxxxx" required>
                            @error('latitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Longitude <span class="text-danger">*</span></label>
                            <input type="text" name="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude') }}" placeholder="115.xxxxx" required>
                            @error('longitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- BAGIAN 3: INFORMASI LAYANAN --}}
                        <hr class="my-3">
                        <h5 class="mb-0">Status & Layanan</h5>

                        <div class="col-md-6">
                            <label class="form-label">Layanan Pendidikan</label>
                            <input type="text" name="layanan_pendidikan" class="form-control" value="{{ old('layanan_pendidikan') }}" placeholder="Contoh: Ada / Tidak Ada">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Layanan Kesehatan</label>
                            <input type="text" name="layanan_kesehatan" class="form-control" value="{{ old('layanan_kesehatan') }}" placeholder="Contoh: Puskesmas / Pustu">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Status Pengajuan <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="" disabled selected>Pilih Status...</option>
                                <option value="Diusulkan" {{ old('status') == 'Diusulkan' ? 'selected' : '' }}>Diusulkan</option>
                                <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Dalam Pembangunan" {{ old('status') == 'Dalam Pembangunan' ? 'selected' : '' }}>Dalam Pembangunan</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mt-5 pt-3 border-top text-end">
                        <a href="{{ route('suadmin.blankspot.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @include('includes.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
