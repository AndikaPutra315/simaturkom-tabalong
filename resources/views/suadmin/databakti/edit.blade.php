<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Bakti - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
            color: #333;
        }
        main { flex: 1; padding: 40px 0; }

        .container-fluid { max-width: 1200px; padding: 0 30px; }

        .content-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
            border: none;
            overflow: hidden;
        }

        .card-header {
            padding: 25px 30px;
            border-bottom: 1px solid #eef2f9;
            background-color: #fff;
        }
        .card-header h1 { margin: 0; font-size: 1.75rem; font-weight: 600; color: #1a237e; }
        .card-header p { margin: 5px 0 0 0; color: #66789a; font-size: 0.95rem; }

        .card-body { padding: 30px; }

        .form-label { font-weight: 600; color: #33425e; font-size: 0.9rem; margin-bottom: 8px; }

        .form-control, .form-select {
            padding: 10px 15px;
            border: 1px solid #dcdfe6;
            border-radius: 6px;
            font-size: 0.9rem;
            color: #333;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0,123,255,.25);
        }
        textarea.form-control { resize: vertical; }

        .card-footer {
            background-color: #f8f9fc;
            padding: 20px 30px;
            border-top: 1px solid #eef2f9;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }
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

        .btn-cancel { background-color: #6c757d; color: white; }
        .btn-cancel:hover { background-color: #5a6268; }

        .btn-save { background-color: #0d6efd; color: white; }
        .btn-save:hover { background-color: #0b5ed7; }
    </style>
</head>
<body>
    @include('includes.header')

    <main>
        <div class="container-fluid">

            @if ($errors->any())
                <div class="alert alert-danger mb-4 border-0 shadow-sm rounded-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-2 fs-5"></i>
                        <h5 class="alert-heading mb-0 fs-6 fw-bold">Gagal Menyimpan Data</h5>
                    </div>
                    <hr class="my-2">
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('suadmin.databakti.update', $dataBakti->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="content-card">
                    <div class="card-header">
                        <h1>Edit Data Bakti</h1>
                        <p>Perbarui data untuk: <strong>{{ $dataBakti->provider }}</strong></p>
                    </div>

                    <div class="card-body">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="provider" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="provider" name="provider" value="{{ old('provider', $dataBakti->provider) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $dataBakti->kecamatan) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="kelurahan" class="form-label">Kelurahan/Desa</label>
                                <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="{{ old('kelurahan', $dataBakti->kelurahan) }}">
                            </div>
                            <div class="col-12">
                                <label for="alamat" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ old('alamat', $dataBakti->alamat) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude', $dataBakti->latitude) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude', $dataBakti->longitude) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="Aktif" {{ old('status', $dataBakti->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Nonaktif" {{ old('status', $dataBakti->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    <option value="Lainnya" {{ old('status', $dataBakti->status) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="tinggi_tower" class="form-label">Tinggi Tower (meter)</label>
                                <input type="number" class="form-control" id="tinggi_tower" name="tinggi_tower" value="{{ old('tinggi_tower', $dataBakti->tinggi_tower) }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('suadmin.databakti.index') }}" class="btn-custom btn-cancel">Batal</a>
                        <button type="submit" class="btn-custom btn-save">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    @include('includes.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
