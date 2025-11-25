<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di SIMATURKOM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto:wght@300;400;500&family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

</head>

<body>

    @include('includes.header')

    <main>
        <section class="hero-container">
            <div class="container">
                <h1 class="hero-title">SIMATURKOM</h1>
                <p class="hero-subtitle">Sistem Informasi Manajemen Infrastruktur Komunikasi</p>
                <p class="hero-description">
                    Platform terpusat untuk visualisasi, pengelolaan, dan analisis data menara telekomunikasi serta
                    infrastruktur jaringan di Kabupaten Tabalong.
                </p>
                <div class="hero-actions">
                    <a href="#data-infrastruktur" class="hero-button btn-primary-custom">Lihat Data</a>
                    <a href="{{ route('peta.index') }}" class="hero-button btn-secondary-custom">Jelajahi Peta</a>
                </div>
            </div>
        </section>

        <section class="content-section">
            <div class="container">
                <h2 class="section-title">Tentang Sistem Kami</h2>
                <hr class="section-divider">
                <p>
                    SIMATURKOM adalah platform terintegrasi yang dirancang untuk mengelola dan memantau seluruh
                    infrastruktur komunikasi di Kabupaten Tabalong. Sistem ini bertujuan untuk meningkatkan efisiensi,
                    transparansi, dan pengambilan keputusan berbasis data yang akurat.
                </p>
                <p>
                    Dengan memanfaatkan teknologi terkini, kami menyediakan data real-time mengenai menara
                    telekomunikasi, jaringan hotspot, serta peta zona strategis. Hal ini memungkinkan Dinas Komunikasi
                    dan Informatika untuk merencanakan pengembangan infrastruktur secara lebih efektif dan merata bagi
                    seluruh masyarakat.
                </p>
            </div>
        </section>

        <section class="features-section">
            <div class="container">
                <h2 class="section-title">Fitur Unggulan</h2>
                <hr class="section-divider">
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-broadcast-tower"></i></div>
                        <h3>Manajemen Menara</h3>
                        <p>Kelola data menara telekomunikasi secara terpusat, mulai dari lokasi, status, hingga
                            perizinan.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-wifi"></i></div>
                        <h3>Pemetaan Hotspot</h3>
                        <p>Visualisasikan persebaran titik hotspot publik untuk analisis jangkauan dan optimalisasi
                            layanan.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-map-marked-alt"></i></div>
                        <h3>Analisis Spasial</h3>
                        <p>Gunakan Peta Zona dan Peta Tower untuk perencanaan strategis dan penempatan infrastruktur
                            baru.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="data-infrastruktur" class="stats-and-chart-section">
            <div class="container">
                <h2 class="section-title">Data Infrastruktur</h2>
                <hr class="section-divider">

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="icon"><i class="fas fa-satellite-dish"></i></div>
                        <div class="info">
                            <p class="number">{{ $totalMenara }}</p>
                            <p class="label">Jumlah Tower BTS</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="icon"><i class="fas fa-clipboard-list"></i></div>
                        <div class="info">
                            <p class="number">{{ $rencanaPembangunan }}</p>
                            <p class="label">Rencana Pembangunan</p>
                        </div>
                    </div>

                    <a href="{{ route('blankspot.index') }}" class="stat-card-link">
                        <div class="stat-card">
                            <div class="icon"><i class="fas fa-map-pin"></i></div>
                            <div class="info">
                                <p class="number">{{ $totalBlankspot }}</p>
                                <p class="label">Total Titik Blankspot</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="chart-container">
                    <div class="chart-tabs">
                        <div>
                            <button class="chart-tab-item active">Chart Pemilik Tower</button>
                            <button class="chart-tab-item" disabled>Chart Tipe Koneksi</button>
                            <button class="chart-tab-item" disabled>Chart Operator</button>
                        </div>
                        <div>
                            <button id="downloadChartBtn" class="btn-download-chart">
                                <i class="fas fa-download"></i> Download Chart
                            </button>
                        </div>
                    </div>

                    <div class="chart-filters">
                        <select id="kecamatanChartFilter" class="form-select">
                            <option value="semua">Semua Kecamatan</option>
                            @foreach ($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->kecamatan }}">{{ $kecamatan->kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <canvas id="towerChart"></canvas>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function generateBarColors(numColors) {
                const colors = [];
                const baseColors = [
                    'rgba(243, 156, 18, 0.8)',  // Oranye
                    'rgba(26, 35, 126, 0.8)',   // Biru Tua
                    'rgba(63, 81, 181, 0.8)',   // Indigo
                    'rgba(220, 53, 69, 0.8)',   // Merah
                    'rgba(255, 193, 7, 0.8)',   // Kuning
                    'rgba(0, 123, 255, 0.8)',  // Biru Cerah
                    'rgba(25, 135, 84, 0.8)',   // Hijau
                    'rgba(108, 117, 125, 0.8)', // Abu-abu
                    'rgba(52, 172, 224, 0.8)',  // Biru Langit
                ];
                for (let i = 0; i < numColors; i++) {
                    colors.push(baseColors[i % baseColors.length]);
                }
                return colors;
            }

            const initialChartData = {
                labels: @json($initialChartData['labels']),
                data: @json($initialChartData['data'])
            };

            const initialColors = generateBarColors(initialChartData.data.length);

            Chart.register(ChartDataLabels);

            const ctx = document.getElementById('towerChart').getContext('2d');
            const towerChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: initialChartData.labels,
                    datasets: [{
                        label: 'Jumlah',
                        data: initialChartData.data,
                        backgroundColor: initialColors,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            color: '#333',
                            font: {
                                weight: 'bold'
                            },
                            formatter: (value, context) => {
                                const dataset = context.chart.data.datasets[0];
                                const total = dataset.data.reduce((sum, val) => sum + val, 0);
                                if (total === 0) return '0%';
                                const percentage = (value / total * 100).toFixed(1) + '%';
                                return percentage;
                            },
                        }
                    }
                }
            });

            const kecamatanFilter = document.getElementById('kecamatanChartFilter');
            kecamatanFilter.addEventListener('change', function() {
                const selectedKecamatan = this.value;

                fetch(`{{ route('chart.data') }}?kecamatan=${selectedKecamatan}`)
                    .then(response => response.json())
                    .then(newData => {
                        const newColors = generateBarColors(newData.data.length);
                        towerChart.data.labels = newData.labels;
                        towerChart.data.datasets[0].data = newData.data;
                        towerChart.data.datasets[0].backgroundColor = newColors;
                        towerChart.update();
                    });
            });

            const downloadBtn = document.getElementById('downloadChartBtn');
            downloadBtn.addEventListener('click', function() {
                const image = towerChart.toBase64Image();
                const link = document.createElement('a');
                link.href = image;
                link.download = 'chart-pemilik-tower.png';
                link.click();
            });
        });
    </script>

    @include('includes.footer')

</body>

</html>
