<?php

namespace App\Http\Controllers\SuAdmin;

use App\Http\Controllers\Controller;
use App\Models\DataMenara;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataMenaraImport;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Validation\Rule;

class DataMenaraController extends Controller
{
    /**
     * Menampilkan daftar semua data menara dengan filter dan paginasi.
     */
    public function index(Request $request)
    {
        $query = DataMenara::query();

        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

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

        $menara = $query->latest()->paginate(10)->withQueryString();
        $providers = DataMenara::select('provider')->distinct()->orderBy('provider')->get();
        $kecamatans = DataMenara::select('kecamatan')->distinct()->orderBy('kecamatan')->get();

        return view('suadmin.datamenara.index', compact('menara', 'providers', 'kecamatans'));
    }

    public function create()
    {
        return view('suadmin.datamenara.create');
    }

    /**
     * Menyimpan data menara baru ke database.
     */
    public function store(Request $request)
    {
        // --- VALIDASI BERSIH (KODE BOLEH KOSONG) ---
        $rules = [
            'provider' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'longitude' => 'required|numeric|between:-180,180',
            'latitude' => 'required|numeric|between:-90,90',
            'status' => 'required|string|max:255',
            'tinggi_tower' => 'required|integer',
        ];

        // Kode boleh kosong (nullable)
        $kodeRules = ['nullable', 'string', 'max:255'];

        // Cek unique hanya jika user mengisi kode (dan bukan "-")
        if ($request->filled('kode') && $request->input('kode') !== '-') {
            $kodeRules[] = Rule::unique('data_menara');
        }
        $rules['kode'] = $kodeRules;

        $request->validate($rules);

        // SIMPAN DATA (Tanpa manipulasi kode acak, NULL masuk sebagai NULL)
        DataMenara::create($request->all());

        return redirect()->route('suadmin.datamenara.index')
                         ->with('success', 'Data menara baru berhasil ditambahkan.');
    }

    public function edit(DataMenara $datamenara)
    {
        return view('suadmin.datamenara.edit', compact('datamenara'));
    }

    /**
     * Memperbarui data menara di database.
     */
    public function update(Request $request, DataMenara $datamenara)
    {
        // --- VALIDASI BERSIH (KODE BOLEH KOSONG) ---
        $rules = [
            'provider' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'longitude' => 'required|numeric|between:-180,180',
            'latitude' => 'required|numeric|between:-90,90',
            'status' => 'required|string|max:255',
            'tinggi_tower' => 'required|integer',
        ];

        $kodeRules = ['nullable', 'string', 'max:255'];

        // Cek unique hanya jika user mengisi kode (dan bukan "-")
        if ($request->filled('kode') && $request->input('kode') !== '-') {
            $kodeRules[] = Rule::unique('data_menara')->ignore($datamenara->id);
        }
        $rules['kode'] = $kodeRules;

        $request->validate($rules);

        // UPDATE DATA (Tanpa manipulasi kode acak)
        $datamenara->update($request->all());

        return redirect()->route('suadmin.datamenara.index')
                         ->with('success', 'Data menara berhasil diperbarui.');
    }

    public function destroy(DataMenara $datamenara)
    {
        $datamenara->delete();
        return redirect()->route('suadmin.datamenara.index')
                         ->with('success', 'Data menara berhasil dihapus.');
    }

    public function generatePDF(Request $request)
    {
        $query = DataMenara::query();

        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }
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
        $menaraData = $query->get();
        $title = 'Laporan Data Menara Telekomunikasi';
        $pdf = Pdf::loadView('pages.datamenara_pdf', compact('menaraData', 'title'));
        return $pdf->stream('laporan-data-menara.pdf');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new DataMenaraImport, $request->file('file_excel'));
            return redirect()->route('suadmin.datamenara.index')->with('success', 'Data Excel berhasil diimpor.');
        } catch (ValidationException $e) {
             $failures = $e->failures();
             return redirect()->route('suadmin.datamenara.index')->with('error', 'Terjadi error saat impor. Pastikan data unik dan format sudah benar.');
        } catch (\Exception $e) {
            return redirect()->route('suadmin.datamenara.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
