<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HotspotData;
use Barryvdh\DomPDF\Facade\Pdf;

class HotspotController extends Controller
{
    // Daftar keterangan yang masuk kategori 'Layanan Internet Gratis'
    protected $kategoriLayananGratis = [
        'Ruang Terbuka Hijau',
        'Ruang Publik',
        'Ruang Pendidikan',
        'Fasilitas Umum',
        
        // Tambahkan nilai lain jika perlu (misal: 'Ruang Terbuka Hijau')
    ];

    public function index(Request $request)
    {
        $kategoriAktif = $request->query('kategori', 'skpd');
        $searchTerm = $request->query('search');

        $query = HotspotData::query();

        // Filter Kategori
        if ($kategoriAktif == 'skpd') {
            $query->where('keterangan', 'SKPD');
        } elseif ($kategoriAktif == 'starlink') {
            $query->where('keterangan', 'Starlink');
        } else { // Layanan Gratis
            $query->whereIn('keterangan', $this->kategoriLayananGratis);
        }

        // Filter Pencarian
        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_tempat', 'like', "%{$searchTerm}%")
                  ->orWhere('alamat', 'like', "%{$searchTerm}%")
                  ->orWhere('tahun', 'like', "%{$searchTerm}%");
            });
        }

        // --- PERUBAHAN SORTING DI SINI ---
        // Urutkan pertama berdasarkan Keterangan, lalu Tahun (ASC = Lama ke Baru)
        $hotspots = $query->orderBy('keterangan', 'asc') // Kelompokkan berdasarkan Keterangan
                          ->orderBy('tahun', 'asc')      // Urutkan berdasarkan Tahun (Lama ke Baru) di dalam kelompok
                          ->paginate(15);
        // --- AKHIR PERUBAHAN ---

        $hotspots->appends($request->only(['kategori', 'search']));

        return view('pages.hotspot', compact('hotspots', 'kategoriAktif', 'searchTerm'));
    }

    public function autocomplete(Request $request)
    {
       // ... method autocomplete tidak perlu diubah ...
    }

    public function generatePDF(Request $request)
    {
        $kategoriAktif = $request->query('kategori', 'skpd');
        $searchTerm = $request->query('search');

        $query = HotspotData::query();

        // Filter Kategori
        if ($kategoriAktif == 'skpd') {
             $query->where('keterangan', 'SKPD');
        } elseif ($kategoriAktif == 'starlink') {
              $query->where('keterangan', 'Starlink');
        } else { // Layanan Gratis
              $query->whereIn('keterangan', $this->kategoriLayananGratis);
        }

        // Filter Pencarian
        if ($searchTerm) {
             $query->where(function($q) use ($searchTerm) {
                 $q->where('nama_tempat', 'like', "%{$searchTerm}%")
                   ->orWhere('alamat', 'like', "%{$searchTerm}%")
                   ->orWhere('tahun', 'like', "%{$searchTerm}%");
             });
        }
        
        // --- PERUBAHAN SORTING DI SINI (Sama seperti di index) ---
        $hotspots = $query->orderBy('keterangan', 'asc')
                          ->orderBy('tahun', 'asc')
                          ->get(); // Ambil semua data untuk PDF
        // --- AKHIR PERUBAHAN ---

        $pdf = Pdf::loadView('pages.hotspot_pdf', compact('hotspots'));
        $fileName = 'data-hotspot-' . str_replace('/', '-', $kategoriAktif) . '-' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($fileName);
    }
}