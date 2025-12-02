<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Menara BTS - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @include('includes.header')

    <main class="container py-5">
        <div class="card fade-in-up">
            <div class="card-header bg-white py-3 form-card-header">
                {{-- Gunakan optional() untuk menghindari error jika kode null, meski kode null tidak masalah --}}
                <span class="title mb-0">Edit Data Menara BTS: {{ $datamenara->kode ?? '(Tanpa Kode)' }}</span>
            </div>
            <div class="card-body p-4 p-lg-5">
                <form action="{{ route('suadmin.datamenara.update', $datamenara->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <h5 class="mb-0">Informasi Dasar</h5>
                        <div class="col-md-6">
                            <label for="kode" class="form-label fw-bold">Kode</label>
                            {{-- HAPUS 'required' --}}
                            <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{ old('kode', $datamenara->kode) }}">
                            @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="provider" class="form-label fw-bold">Provider</label>
                            {{-- HAPUS 'required' --}}
                            <input type="text" class="form-control @error('provider') is-invalid @enderror" id="provider" name="provider" value="{{ old('provider', $datamenara->provider) }}">
                            @error('provider')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-3">
                        <h5 class="mb-0">Informasi Lokasi</h5>
                        <div class="col-md-6">
                            <label for="kelurahan" class="form-label fw-bold">Kelurahan</label>
                            {{-- HAPUS 'required' --}}
                            <input type="text" class="form-control @error('kelurahan') is-invalid @enderror" id="kelurahan" name="kelurahan" value="{{ old('kelurahan', $datamenara->kelurahan) }}">
                            @error('kelurahan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="kecamatan" class="form-label fw-bold">Kecamatan</label>
                            {{-- HAPUS 'required' --}}
                            <input type="text" class="form-control @error('kecamatan') is-invalid @enderror" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $datamenara->kecamatan) }}">
                            @error('kecamatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="alamat" class="form-label fw-bold">Alamat</label>
                            {{-- HAPUS 'required' --}}
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat', $datamenara->alamat) }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="longitude" class="form-label fw-bold">Longitude</label>
                            {{-- HAPUS 'required' --}}
                            <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude', $datamenara->longitude) }}">
                            @error('longitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="latitude" class="form-label fw-bold">Latitude</label>
                            {{-- HAPUS 'required' --}}
                            <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude', $datamenara->latitude) }}">
                            @error('latitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-3">
                        <h5 class="mb-0">Informasi Teknis</h5>
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-bold">Status</label>
                             {{-- HAPUS 'required' --}}
                             <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="" disabled>Pilih Status...</option>
                                <option value="aktif" {{ old('status', $datamenara->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $datamenara->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tinggi_tower" class="form-label fw-bold">Tinggi Tower (meter)</label>
                            {{-- HAPUS 'required' --}}
                            <input type="number" class="form-control @error('tinggi_tower') is-invalid @enderror" id="tinggi_tower" name="tinggi_tower" value="{{ old('tinggi_tower', $datamenara->tinggi_tower) }}">
                            @error('tinggi_tower')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary">Update Data</button>
                        <a href="{{ route('suadmin.datamenara.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @include('includes.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
