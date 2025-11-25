<?php

namespace App\Http\Controllers\SuAdmin;

use App\Http\Controllers\Controller;
use App\Models\DataBakti; // MENGGUNAKAN MODEL DataBakti
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class DataBaktiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DataBakti::query();

        // Logika Pencarian (KODE DIHAPUS)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Pencarian kode dihapus
                $q->where('provider', 'like', '%' . $search . '%') // Provider sekarang dianggap sebagai "Nama"
                  ->orWhere('kecamatan', 'like', '%' . $search . '%');
            });
        }

        // Logika Filter untuk Dropdown
        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }


        $dataBakti = $query->latest()->paginate(10)->withQueryString();

        // Ambil data filter untuk dropdown
        $providers = DataBakti::select('provider')->distinct()->orderBy('provider')->get();
        $kecamatans = DataBakti::select('kecamatan')->distinct()->orderBy('kecamatan')->get();

        // Kirim semua data dan filter ke view
        return view('suadmin.databakti.index', compact('dataBakti', 'providers', 'kecamatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // PERBAIKAN: Hapus 'pages.'
        return view('suadmin.databakti.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Validasi KODE DIHAPUS
            'provider' => 'required|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'status' => 'nullable|string|max:255',
            'tinggi_tower' => 'nullable|integer',
        ]);

        DataBakti::create($validated);

        return redirect()->route('suadmin.databakti.index')->with('success', 'Data Bakti berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataBakti $dataBakti)
    {
        // Method ini biasanya tidak dipakai, biarkan saja
    }

    /**
     * UBAH KE MANUAL: Menggunakan $id bukan binding model otomatis
     */
    public function edit($id)
    {
        // Cari data secara manual. Jika tidak ada, akan otomatis melempar 404.
        $dataBakti = DataBakti::findOrFail($id);

        // PERBAIKAN: Hapus 'pages.'
        return view('suadmin.databakti.edit', compact('dataBakti'));
    }

    /**
     * UBAH KE MANUAL: Menggunakan $id
     */
    public function update(Request $request, $id)
    {
        $dataBakti = DataBakti::findOrFail($id); // Cari data secara manual

        $validated = $request->validate([
            // Validasi KODE DIHAPUS
            'provider' => 'required|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'status' => 'nullable|string|max:255',
            'tinggi_tower' => 'nullable|integer',
        ]);

        $dataBakti->update($validated);

        return redirect()->route('suadmin.databakti.index')->with('success', 'Data Bakti berhasil diperbarui.');
    }

    /**
     * UBAH KE MANUAL: Menggunakan $id
     */
    public function destroy($id)
    {
        $dataBakti = DataBakti::findOrFail($id); // Cari data secara manual
        $dataBakti->delete();

        return redirect()->route('suadmin.databakti.index')->with('success', 'Data Bakti berhasil dihapus.');
    }

    /**
     * Membuat file PDF dari data bakti.
     */
    public function generatePDF(Request $request)
    {
        $query = DataBakti::query();

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

        $dataBakti = $query->latest()->get();

        $pdf = Pdf::loadView('suadmin.databakti.pdf', compact('dataBakti'));
        $pdf->setPaper('a4', 'landscape');

        $fileName = 'data-bakti-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $importClass = '\App\Imports\DataBaktiImport';

            if (!class_exists($importClass)) {
                return redirect()->back()->with('error', 'Gagal: Fitur import belum siap. Class <strong>' . $importClass . '</strong> tidak ditemukan.');
            }

            $import = new $importClass;

            Excel::import($import, $request->file('file_excel'));

            if (method_exists($import, 'failures')) {
                $failures = $import->failures();

                if ($failures->isNotEmpty()) {
                    $errorMessage = "Gagal mengimpor sebagian data. Ada " . count($failures) . " baris yang bermasalah:<br>";
                    foreach ($failures as $failure) {
                        $errorMessage .= "- Baris " . $failure->row() . ": " . implode(", ", $failure->errors()) . "<br>";
                    }
                    return redirect()->route('suadmin.databakti.index')->with('error', $errorMessage);
                }
            }

            return redirect()->route('suadmin.databakti.index')->with('success', 'Data Bakti berhasil diimpor.');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             $errorMessage = "Gagal validasi data Excel:<br>";
             foreach ($failures as $failure) {
                 $errorMessage .= "- Baris " . $failure->row() . ": " . implode(", ", $failure->errors()) . "<br>";
             }
             return redirect()->route('suadmin.databakti.index')->with('error', $errorMessage);

        } catch (Exception $e) {
            return redirect()->route('suadmin.databakti.index')->with('error', 'Gagal mengimpor data. Error: ' . $e->getMessage());
        }
    }
}
