<?php

namespace App\Http\Controllers\SuAdmin;

use App\Http\Controllers\Controller;
use App\Models\Blankspot;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BlankspotImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class BlankspotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Blankspot::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('desa', 'like', '%' . $search . '%')
                  ->orWhere('kecamatan', 'like', '%' . $search . '%')
                  ->orWhere('site', 'like', '%' . $search . '%');
                  // Pencarian lokasi dihapus karena kolomnya sudah dipecah
            });
        }

        $blankspots = $query->latest()->paginate(10);
        return view('suadmin.blankspot.index', compact('blankspots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suadmin.blankspot.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'site' => 'required|string|max:255',
            // PERUBAHAN: Validasi dipisah untuk Latitude & Longitude
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'layanan_pendidikan' => 'nullable|string|max:255',
            'layanan_kesehatan' => 'nullable|string|max:255',
            'status' => 'required|string',
        ]);

        Blankspot::create($request->all());

        return redirect()->route('suadmin.blankspot.index')->with('success', 'Data blankspot berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $blankspot = Blankspot::findOrFail($id);
        return view('suadmin.blankspot.edit', compact('blankspot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $blankspot = Blankspot::findOrFail($id);

        $request->validate([
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'site' => 'required|string|max:255',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'layanan_pendidikan' => 'nullable|string|max:255',
            'layanan_kesehatan' => 'nullable|string|max:255',
            'status' => 'required|string',
        ]);

        $blankspot->update($request->all());

        return redirect()->route('suadmin.blankspot.index')->with('success', 'Data blankspot berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blankspot = Blankspot::findOrFail($id);
        $blankspot->delete();

        return redirect()->route('suadmin.blankspot.index')->with('success', 'Data blankspot berhasil dihapus.');
    }

    /**
     * Import data from Excel
     */
    public function handleImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new BlankspotImport, $request->file('file'));
            return redirect()->route('suadmin.blankspot.index')->with('success', 'Data berhasil diimpor!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function showImportForm()
    {
        return view('suadmin.blankspot.import');
    }

    public function generatePDF()
    {
        $blankspots = Blankspot::all();
        $pdf = Pdf::loadView('suadmin.blankspot.pdf', compact('blankspots'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('laporan-blankspot.pdf');
    }
}
