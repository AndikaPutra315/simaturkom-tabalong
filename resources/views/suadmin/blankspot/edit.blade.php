<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Blankspot - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @include('includes.header')
    <main class="py-5">
        <div class="container">
            <div class="content-card">
                 <div class="card-header p-4 border-bottom"><h1 class="mb-0 fw-bold">Edit Data Blankspot</h1></div>
                 <div class="card-body p-4">
                    <form action="{{ route('suadmin.blankspot.update', $blankspot->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="desa" class="form-label">Desa</label>
                                <input type="text" class="form-control" id="desa" name="desa" value="{{ old('desa', $blankspot->desa) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="kecamatan" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $blankspot->kecamatan) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="site" class="form-label">Site</label>
                                <input type="text" class="form-control" id="site" name="site" value="{{ old('site', $blankspot->site) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="lokasi_blankspot" class="form-label">Titik/Lokasi Blankspot <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lokasi_blankspot" name="lokasi_blankspot" value="{{ old('lokasi_blankspot', $blankspot->lokasi_blankspot) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="Diusulkan" @selected(old('status', $blankspot->status) == 'Diusulkan')>Diusulkan</option>
                                    <option value="Pembangunan" @selected(old('status', $blankspot->status) == 'Pembangunan')>Pembangunan</option>
                                    <option value="Selesai" @selected(old('status', $blankspot->status) == 'Selesai')>Selesai</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="layanan_pendidikan" class="form-label">Layanan Pendidikan</label>
                                <select class="form-select" id="layanan_pendidikan" name="layanan_pendidikan">
                                    <option value="">Pilih...</option>
                                    <option value="Ada" @selected(old('layanan_pendidikan', $blankspot->layanan_pendidikan) == 'Ada')>Ada</option>
                                    <option value="Tidak Ada" @selected(old('layanan_pendidikan', $blankspot->layanan_pendidikan) == 'Tidak Ada')>Tidak Ada</option>
                                </select>
                            </div>