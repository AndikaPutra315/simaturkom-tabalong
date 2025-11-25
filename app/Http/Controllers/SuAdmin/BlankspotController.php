<?php
namespace App\Http\Controllers\SuAdmin;

use App\Http\Controllers\Controller;
use App\Models\Blankspot;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BlankspotImport;
use \Maatwebsite\Excel\Validators\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf; // <-- 1. TAMBAHKAN INI

class BlankspotController extends Controller
{
    // Aturan validasi untuk form
    private function validationRules()
    {
        return [
            'desa' => 'nullable|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'site' => 'nullable|string|max:255',
            'lokasi_blankspot' => 'required|string|max:255',
            'status' => 'required|string|in:Diusulkan,Pembangunan,Selesai',
            'layanan_pendidikan' => 'nullable|string|in:Ada,Tidak Ada',  
            'layanan_kesehatan' => 'nullable|string|in:Ada,Tidak Ada',      
        ];
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = Blankspot::query();
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('desa', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('site', 'like', "%{$search}%")
                  ->orWhere('lokasi_blankspot', 'like', "%{$search}%");
            });
        }
        $blankspots = $query->orderBy('kecamatan')->orderBy('desa')->paginate(15);
        $blankspots->appends($request->only('search')); // Jaga pencarian saat paginasi

        return view('suadmin.blankspot.index', compact('blankspots', 'search'));
    }

    public function create()
    {
        return view('suadmin.blankspot.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules());
        Blankspot::create($request->all());
        return redirect()->route('suadmin.blankspot.index')->with('success', 'Data blankspot berhasil ditambahkan.');
    }

    public function edit(Blankspot $blankspot)
    {
        return view('suadmin.blankspot.edit', compact('blankspot'));
    }

    public function update(Request $request, Blankspot $blankspot)
    {
        $request->validate($this->validationRules());
        $blankspot->update($request->all());
        return redirect()->route('suadmin.blankspot.index')->with('success', 'Data blankspot berhasil diperbarui.');
    }

    public function destroy(Blankspot $blankspot)
    {
        $blankspot->delete();
        return redirect()->route('suadmin.blankspot.index')->with('success', 'Data blankspot berhasil dihapus.');
    }

    public function handleImport(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new BlankspotImport, $request->file('excel_file'));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
        
        return redirect()->route('suadmin.blankspot.index')->with('success', 'Data blankspot berhasil diimpor.');
    }

    /**
     * BARU: Method untuk membuat PDF data blankspot
     */
    public function generatePDF(Request $request)
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

        // Kita bisa menggunakan ulang view PDF dari halaman publik
        $pdf = Pdf::loadView('pages.blankspot_pdf', compact('blankspots')); 
        $pdf->setPaper('a4', 'landscape');
        
        $fileName = 'data-blankspot-admin-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }
}