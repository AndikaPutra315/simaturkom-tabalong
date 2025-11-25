<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataMenara;
use App\Models\Regulasi;
use App\Models\HotspotData;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Blankspot;
use App\Models\DataBakti; // <-- Ini sudah benar

class HomeController extends Controller
{
    public function index()
    {
        $chartPemilikData = DataMenara::query()
            ->select('provider', DB::raw('count(*) as total'))
            ->groupBy('provider')
            ->orderBy('total', 'desc')
            ->get();

        $initialChartData = [
            'labels' => $chartPemilikData->pluck('provider'),
            'data' => $chartPemilikData->pluck('total'),
        ];

        $totalMenara = DataMenara::count();
        $rencanaPembangunan = 12; // Data statis

        // --- 1. TAMBAHKAN BARIS INI ---
        $totalBlankspot = Blankspot::count();

        $kecamatans = DataMenara::select('kecamatan')->distinct()->orderBy('kecamatan')->get();

        // --- 2. TAMBAHKAN '$totalBlankspot' KE DALAM COMPACT ---
        return view('pages.home', compact('initialChartData', 'totalMenara', 'rencanaPembangunan', 'kecamatans', 'totalBlankspot'));
    }

    public function getChartData(Request $request)
    {
        $kecamatan = $request->query('kecamatan');

        $query = DataMenara::query()
            ->select('provider', DB::raw('count(*) as total'))
            ->groupBy('provider')
            ->orderBy('total', 'desc');

        if ($kecamatan && $kecamatan !== 'semua') {
            $query->where('kecamatan', $kecamatan);
        }

        $data = $query->get();

        $chartData = [
            'labels' => $data->pluck('provider'),
            'data' => $data->pluck('total'),
        ];

        return response()->json($chartData);
    }

    /**
     * DIUBAH: Menampilkan halaman data menara dengan filter DAN PENCARIAN.
     */
    public function dataMenara(Request $request)
    {
        $query = DataMenara::query();

        // Logika Pencarian Baru
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('provider', 'like', "%{$search}%")
                  ->orWhere('kelurahan', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        // Logika filter yang sudah ada
        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Paginasi diubah agar menyertakan semua parameter (filter & search)
        $menaraData = $query->latest()->paginate(10)->withQueryString();

        $providers = DataMenara::select('provider')->distinct()->orderBy('provider')->get();
        $kecamatans = DataMenara::select('kecamatan')->distinct()->orderBy('kecamatan')->get();

        return view('pages.datamenara', compact('menaraData', 'providers', 'kecamatans'));
    }

    // --- (INI BAGIAN YANG SAYA PERBAIKI) ---
    /**
     * Menampilkan halaman publik untuk Data Bakti.
     * (VERSI FINAL - Sesuai dengan database baru 'provider')
     */
    public function dataBakti(Request $request)
    {
        $query = DataBakti::query(); // Menggunakan Model DataBakti

        // Logika Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Pencarian KODE DIHAPUS
                $q->where('provider', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('kelurahan', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        // Logika filter
        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Paginasi
        $dataBakti = $query->latest()->paginate(10)->withQueryString();

        // Ambil data filter dari kolom 'provider'
        $providers = DataBakti::select('provider')->distinct()->orderBy('provider')->get();
        $kecamatans = DataBakti::select('kecamatan')->distinct()->orderBy('kecamatan')->get();

        // Mengarahkan ke view publik 'pages.databakti'
        return view('pages.databakti', compact('dataBakti', 'providers', 'kecamatans'));
    }
    // --- AKHIR FUNGSI BARU ---

    public function regulasi()
    {
        $regulasiData = Regulasi::latest()->get();
        return view('pages.regulasi', ['regulasiData' => $regulasiData]);
    }

    public function generateMenaraPDF(Request $request)
    {
        $query = DataMenara::query();

        // Logika filter dan pencarian ditambahkan ke PDF juga
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('provider', 'like', "%{$search}%")
                  ->orWhere('kelurahan', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }
        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        $menaraData = $query->latest()->get();

        $pdf = Pdf::loadView('pages.datamenara_pdf', compact('menaraData'));
        $pdf->setPaper('a4', 'landscape');

        $fileName = 'data-menara-telekomunikasi-' . date('Y-md') . '.pdf';

        return $pdf->download($fileName);
    }

    public function trackRegulasiView(Regulasi $regulasi)
    {
        $regulasi->increment('view_count');
        return redirect()->to(Storage::disk('public')->url($regulasi->file_path));
    }

    public function trackRegulasiDownload(Regulasi $regulasi)
    {
        $regulasi->increment('download_count');
        return Storage::disk('public')->download($regulasi->file_path, $regulasi->nama_file_asli);
    }

    public function blankspot(Request $request) // Tambahkan Request $request
    {
        $search = $request->query('search'); // Ambil kata kunci pencarian
        $query = Blankspot::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('desa', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('site', 'like', "%{$search}%")
                  ->orWhere('lokasi_blankspot', 'like', "%{$search}%");
            });
        }

        $blankspots = $query->orderBy('kecamatan')->orderBy('desa')->paginate(20);
        $blankspots->appends($request->only('search')); // Jaga pencarian saat paginasi

        // Kirim $search ke view
        return view('pages.blankspot', compact('blankspots', 'search'));
    }

    /**
     * BARU: Method untuk membuat PDF data blankspot
     */
    public function generateBlankspotPDF(Request $request)
    {
        $search = $request->query('search');
        $query = Blankspot::query();

        // Terapkan logika pencarian yang sama
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('desa', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('site', 'like', "%{$search}%")
                  ->orWhere('lokasi_blankspot', 'like', "%{$search}%");
            });
        }

        // Ambil SEMUA data yang cocok (tanpa paginasi)
        $blankspots = $query->orderBy('kecamatan')->orderBy('desa')->get();

        $pdf = Pdf::loadView('pages.blankspot_pdf', compact('blankspots'));

        // Atur ke landscape karena tabelnya lebar
        $pdf->setPaper('a4', 'landscape');

        $fileName = 'data-blankspot-' . date('Y-md') . '.pdf';
        return $pdf->download($fileName);
    }

    // --- (FUNGSI BARU SAYA TAMBAHKAN DI SINI) ---
    /**
     * BARU: Method untuk membuat PDF data bakti (Publik).
     */
    public function generateBaktiPDF(Request $request)
    {
        $query = DataBakti::query(); // Gunakan model DataBakti

        // Salin logika filter dari method dataBakti()
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Pencarian KODE DIHAPUS
                $q->where('provider', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%");
            });
        }
        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Ambil SEMUA data yang cocok (tanpa paginasi)
        $dataBakti = $query->latest()->get();

        // PENTING: Muat view PDF terpisah untuk tamu
        $pdf = Pdf::loadView('pages.databakti_pdf', compact('dataBakti'));
        $pdf->setPaper('a4', 'landscape');

        $fileName = 'data-bakti-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }
}
