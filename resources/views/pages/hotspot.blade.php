<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Hotspot - SIMATURKOM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/hotspot.css') }}">

</head>

<body>
    @include('includes.header')
    <main>
        <div class="container">
            <div class="content-card">
                <div class="card-header">
                    <h1>Data Hotspot</h1>
                    <p>Daftar titik hotspot SKPD, layanan gratis, dan Starlink Akses di Kabupaten Tabalong.</p>
                </div>

                <div class="toolbar">
                    <form action="{{ route('hotspot.index') }}" method="GET" class="search-form" id="searchForm">
                        <input type="hidden" name="kategori" value="{{ $kategoriAktif }}">
                        <input type="text" name="search" id="searchInput" class="form-control"
                            placeholder="Cari nama, alamat, atau tahun..." value="{{ $searchTerm ?? '' }}"
                            autocomplete="off">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        <div class="autocomplete-suggestions" id="suggestions"></div>
                    </form>
                    <div class="action-buttons">
                        <a href="{{ route('hotspot.index', ['kategori' => $kategoriAktif]) }}"
                            class="btn-custom btn-refresh"><i class="fas fa-sync-alt"></i> Refresh</a>
                        <a href="{{ route('hotspot.pdf', ['kategori' => $kategoriAktif, 'search' => $searchTerm ?? '']) }}"
                            class="btn-custom btn-pdf" target="_blank">
                            <i class="fas fa-file-pdf"></i> Generate PDF
                        </a>
                    </div>
                </div>

                <div class="tabs-container">
                                        <a href="{{ route('hotspot.index', ['kategori' => 'skpd', 'search' => $searchTerm ?? '']) }}"
                        class="tab-link {{ $kategoriAktif == 'skpd' ? 'active' : '' }}">Hotspot SKPD</a>

                    <a href="{{ route('hotspot.index', ['kategori' => 'free', 'search' => $searchTerm ?? '']) }}"
                        class="tab-link {{ $kategoriAktif == 'free' ? 'active' : '' }}">Layanan Internet Gratis</a>

                    <a href="{{ route('hotspot.index', ['kategori' => 'starlink', 'search' => $searchTerm ?? '']) }}"
                        class="tab-link {{ $kategoriAktif == 'starlink' ? 'active' : '' }}">Starlink Akses</a>
                </div>

                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Tempat</th>
                                <th>Alamat</th>
                                <th>Tahun</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hotspots as $hotspot)
                                <tr>
                                    <td>{{ $hotspot->nama_tempat }}</td>
                                    <td>{{ $hotspot->alamat }}</td>
                                    <td>{{ $hotspot->tahun }}</td>
                                    <td>{{ $hotspot->keterangan }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 20px;">
                                        Tidak ada data hotspot yang ditemukan untuk kategori ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <div class="entries-info">
                        @if ($hotspots->total() > 0)
                            Menampilkan {{ $hotspots->firstItem() }} sampai {{ $hotspots->lastItem() }} dari
                            {{ $hotspots->total() }} entri
                        @else
                            Tidak ada entri
                        @endif
                    </div>
                    {{ $hotspots->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </main>
    @include('includes.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const suggestionsContainer = document.getElementById('suggestions');
            const searchForm = document.getElementById('searchForm');
            let debounceTimer;

            searchInput.addEventListener('input', function() {
                const term = this.value;
                clearTimeout(debounceTimer);
                if (term.length < 2) {
                    suggestionsContainer.innerHTML = '';
                    suggestionsContainer.style.display = 'none';
                    return;
                }
                debounceTimer = setTimeout(() => {
                    fetch(`{{ route('hotspot.autocomplete') }}?term=${term}`)
                        .then(response => response.json())
                        .then(data => {
                            suggestionsContainer.innerHTML = '';
                            if (data.length > 0) {
                                suggestionsContainer.style.display = 'block';
                                data.forEach(suggestion => {
                                    const item = document.createElement('div');
                                    item.classList.add('suggestion-item');
                                    item.textContent = suggestion;
                                    item.addEventListener('click', function() {
                                        searchInput.value = this.textContent;
                                        suggestionsContainer.style.display = 'none';
                                        searchForm.submit();
                                    });
                                    suggestionsContainer.appendChild(item);
                                });
                            } else {
                                suggestionsContainer.style.display = 'none';
                            }
                        });
                }, 300);
            });

            document.addEventListener('click', function(e) {
                if (!searchForm.contains(e.target)) {
                    suggestionsContainer.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
