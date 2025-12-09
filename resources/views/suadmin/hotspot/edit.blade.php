<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Hotspot - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @include('includes.header')
    <main class="py-5">
        <div class="container">
            <div class="content-card">
                 <div class="card-header p-4 border-bottom"><h1 class="mb-0 fw-bold">Edit Data Hotspot: {{ $hotspot->nama_tempat }}</h1></div>
                 <div class="card-body p-4">
                    <form action="{{ route('suadmin.hotspot.update', $hotspot->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nama_tempat" class="form-label">Nama Tempat</label>
                            <input type="text" class="form-control" id="nama_tempat" name="nama_tempat" value="{{ old('nama_tempat', $hotspot->nama_tempat) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $hotspot->alamat) }}</textarea>
                        </div>
                        <div class="row">
                             <div class="col-md-6 mb-3">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="number" class="form-control" id="tahun" name="tahun" value="{{ old('tahun', $hotspot->tahun) }}" required placeholder="Contoh: 2024" min="1900" max="{{ date('Y') + 1 }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <select class="form-select" id="keterangan" name="keterangan" required>
                                    <option value="">Pilih Keterangan...</option>
                                    <option value="SKPD" @selected(old('keterangan', $hotspot->keterangan) == 'SKPD')>SKPD</option>
                                    <option value="Ruang Terbuka Hijau" @selected(old('keterangan', $hotspot->keterangan) == 'Ruang Terbuka Hijau')>Ruang Terbuka Hijau</option>
                                    <option value="Ruang Publik" @selected(old('keterangan', $hotspot->keterangan) == 'Ruang Publik')>Ruang Publik</option>
                                    <option value="Ruang Pendidikan" @selected(old('keterangan', $hotspot->keterangan) == 'Ruang Pendidikan')>Ruang Pendidikan</option>
                                    <option value="Fasilitas Umum" @selected(old('keterangan', $hotspot->keterangan) == 'Fasilitas Umum')>Fasilitas Umum</option>
                                    <option value="Starlink" @selected(old('keterangan', $hotspot->keterangan) == 'Starlink')>Starlink</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('suadmin.hotspot.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Update Data</button>
                        </div>
                    </form>
                 </div>
            </div>
        </div>
    </main>
    @include('includes.footer')
</body>
</html>
