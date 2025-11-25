<?php

namespace App\Http\Controllers\SuAdmin;

use App\Http\Controllers\Controller;
use App\Models\HotspotData;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\HotspotImport;

class HotspotController extends Controller
{
    // Daftar keterangan yang masuk kategori "Layanan Gratis"
    protected $kategoriLayananGratis = [
        'Ruang Terbuka Hijau',
        'Ruang Publik',
        'Ruang Pendidikan',
        'Fasilitas Umum',
    ];

    public function index(Request $request)
    {
        $filterKeterangan = $request->query('filter_keterangan');
        $searchTerm = $request->query('search');

        $query = HotspotData::query();

        // Logika filter
        if ($filterKeterangan) {
            if ($filterKeterangan == 'skpd') {
                $query->where('keterangan', 'SKPD');
            } elseif ($filterKeterangan == 'starlink') {
                $query->where('keterangan', 'Starlink');
            } elseif ($filterKeterangan == 'layanan_gratis') {
                $query->whereIn('keterangan', $this->kategoriLayananGratis);
            }
        }

        // Logika search
        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_tempat', 'like', "%{$searchTerm}%")
                  ->orWhere('alamat', 'like', "%{$searchTerm}%")
                  ->orWhere('tahun', 'like', "%{$searchTerm}%")
                  ->orWhere('keterangan', 'like', "%{$searchTerm}%");
            });
        }

        $hotspots = $query->orderBy('keterangan', 'asc')
                          ->orderBy('tahun', 'asc')
                          ->paginate(15);

        $hotspots->appends($request->all());

        return view('suadmin.hotspot.index', compact('hotspots'));
    }

    public function create()
    {
        return view('suadmin.hotspot.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tempat' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tahun' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'keterangan' => 'required|string|max:255',
        ]);
        HotspotData::create($request->all());
        return redirect()->route('suadmin.hotspot.index')->with('success', 'Data hotspot baru berhasil ditambahkan.');
    }

    public function edit(HotspotData $hotspot)
    {
        return view('suadmin.hotspot.edit', compact('hotspot'));
    }

    public function update(Request $request, HotspotData $hotspot)
    {
        $request->validate([
            'nama_tempat' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tahun' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'keterangan' => 'required|string|max:255',
        ]);
        $hotspot->update($request->all());
        return redirect()->route('suadmin.hotspot.index')->with('success', 'Data hotspot berhasil diperbarui.');
    }

    public function destroy(HotspotData $hotspot)
    {
        $hotspot->delete();
        return redirect()->route('suadmin.hotspot.index')->with('success', 'Data hotspot berhasil dihapus.');
    }

    /**
     * PERBAIKAN: 'publicS' diubah menjadi 'public'
     */
    public function generatePDF(Request $request)
    {
        $filterKeterangan = $request->query('filter_keterangan');
        $searchTerm = $request->query('search');

        $query = HotspotData::query();

        // Terapkan logika filter yang sama
        if ($filterKeterangan) {
            if ($filterKeterangan == 'skpd') {
                $query->where('keterangan', 'SKPD');
            } elseif ($filterKeterangan == 'starlink') {
                $query->where('keterangan', 'Starlink');
            } elseif ($filterKeterangan == 'layanan_gratis') {
                $query->whereIn('keterangan', $this->kategoriLayananGratis);
            }
        }

        // Terapkan logika search yang sama
        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_tempat', 'like', "%{$searchTerm}%")
                  ->orWhere('alamat', 'like', "%{$searchTerm}%")
                  ->orWhere('tahun', 'like', "%{$searchTerm}%")
                  ->orWhere('keterangan', 'like', "%{$searchTerm}%");
            });
        }

        // Ambil SEMUA data yang cocok (tanpa paginasi)
        $hotspots = $query->orderBy('keterangan', 'asc')
                          ->orderBy('tahun', 'asc')
                          ->get();
                                
        $pdf = Pdf::loadView('pages.hotspot_pdf', compact('hotspots'));
        $fileName = 'data-hotspot-admin-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }

    public function showImportForm()
    {
        // Pastikan view ini ada atau hapus method ini jika menggunakan modal
        // return view('suadmin.hotspot.import');
    }

    public function handleImport(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new HotspotImport, $request->file('excel_file'));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
        
        return redirect()->route('suadmin.hotspot.index')->with('success', 'Data hotspot berhasil diimpor.');
    }
}