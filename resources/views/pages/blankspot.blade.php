<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Blankspot - SIMATURKOM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hotspot.css') }}">
</head>
<body>
    @include('includes.header')
    <main>
        <div class="container">
            <div class="content-card">
                <div class="card-header">
                    <h1>Data Blankspot</h1>
                    <p>Daftar data lokasi titik blankspot di Kabupaten Tabalong.</p>
                </div>

                <div class="toolbar">
                    <form action="{{ route('blankspot.index') }}" method="GET" class="search-form">
                        <input type="text" name="search" class="form-control" placeholder="Cari desa, kecamatan, site..." value="{{ $search ?? '' }}">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </form>
                    <div class="action-buttons">
                        <a href="{{ route('blankspot.index') }}" class="btn-custom btn-refresh"><i class="fas fa-sync-alt"></i> Refresh</a>
                        <a href="{{ route('blankspot.pdf', request()->query()) }}" class="btn-custom btn-pdf" target="_blank">
                            <i class="fas fa-file-pdf"></i> Generate PDF
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Desa</th>
                                <th>Kecamatan</th>
                                <th>Site</th>
                                <th>Titik/Lokasi Blankspot</th>
                                <th>Layanan Pendidikan</th>
                                <th>Layanan Kesehatan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($blankspots as $data)
                                <tr>
                                    <td>{{ $data->desa }}</td>
                                    <td>{{ $data->kecamatan }}</td>
                                    <td>{{ $data->site }}</td>
                                    <td>{{ $data->lokasi_blankspot }}</td>
                                    <td>{{ $data->layanan_pendidikan }}</td>
                                    <td>{{ $data->layanan_kesehatan }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($data->status) {
                                                'Selesai' => 'bg-success',
                                                'Pembangunan' => 'bg-warning text-dark',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} text-white" style="padding: 8px 12px; border-radius: 20px; font-weight: 500;">
                                            {{ $data->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 20px;">
                                        Data blankspot tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <div class="entries-info">
                        @if ($blankspots->total() > 0)
                            Menampilkan {{ $blankspots->firstItem() }} sampai {{ $blankspots->lastItem() }} dari {{ $blankspots->total() }} entri
                        @else
                            Tidak ada entri
                        @endif
                    </div>
                    {{ $blankspots->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </main>
    @include('includes.footer')
</body>
</html>
