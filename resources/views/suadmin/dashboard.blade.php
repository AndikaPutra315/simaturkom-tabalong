<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIMATURKOM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @include('includes.header')

    <main class="container py-5">
        <div class="row mb-4">
            <div class="col">
                <h1 class="fw-bold">Dashboard</h1>
                <p class="text-muted">Selamat datang kembali!</p>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-6 col-xl-3">
                <div class="stat-card card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="fa-3x me-4 text-primary"><i class="fas fa-broadcast-tower"></i></div>
                        <div>
                            <h2 class="mb-0">{{ $totalMenara }}</h2>
                            <span class="text-muted">Total Data Menara</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card card h-100 text-success">
                    <div class="card-body d-flex align-items-center">
                        <div class="fa-3x me-4"><i class="fas fa-wifi"></i></div>
                        <div>
                            <h2 class="mb-0">{{ $totalHotspot }}</h2>
                            <span class="text-muted">Total Titik Hotspot</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card card h-100 text-warning">
                    <div class="card-body d-flex align-items-center">
                        <div class="fa-3x me-4"><i class="fas fa-file-alt"></i></div>
                        <div>
                            <h2 class="mb-0">{{ $totalRegulasi }}</h2>
                            <span class="text-muted">Total Dokumen Regulasi</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="stat-card card h-100 text-danger">
                    <div class="card-body d-flex align-items-center">
                        <div class="fa-3x me-4"><i class="fas fa-users"></i></div>
                        <div>
                            <h2 class="mb-0">{{ $totalUser }}</h2>
                            <span class="text-muted">Total Pengguna</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-xl-8">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Jumlah Menara per Provider</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="providerChart" style="height: 350px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Aksi Cepat</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <a href="{{ route('suadmin.datamenara.create') }}" class="btn btn-primary btn-lg"><i class="fas fa-plus me-2"></i> Tambah Data Menara</a>
                            <a href="{{ route('suadmin.blankspot.create') }}" class="btn btn-primary btn-lg"><i class="fas fa-plus me-2"></i> Tambah Data Blankspot</a>
                            <a href="{{ route('suadmin.hotspot.create') }}" class="btn btn-success btn-lg"><i class="fas fa-plus me-2"></i> Tambah Data Hotspot</a>
                            <a href="{{ route('suadmin.regulasi.create') }}" class="btn btn-warning btn-lg text-white"><i class="fas fa-plus me-2"></i> Tambah Regulasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('includes.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('providerChart').getContext('2d');

            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(74, 144, 226, 0.8)');
            gradient.addColorStop(1, 'rgba(74, 144, 226, 0.2)');

            const providerChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($menaraPerProvider->pluck('provider')) !!},
                    datasets: [{
                        label: 'Jumlah Menara',
                        data: {!! json_encode($menaraPerProvider->pluck('total')) !!},
                        backgroundColor: gradient,
                        borderColor: 'rgba(74, 144, 226, 1)',
                        borderWidth: 2,
                        borderRadius: 5,
                        hoverBackgroundColor: 'rgba(74, 144, 226, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#333',
                            titleFont: { size: 14, weight: 'bold' },
                            bodyFont: { size: 12 },
                            cornerRadius: 6,
                            padding: 10
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
