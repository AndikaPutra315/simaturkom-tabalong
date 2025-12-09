<?php

namespace App\Http\Controllers\Suadmin;

use App\Http\Controllers\Controller;
use App\Models\Regulasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegulasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regulasi = Regulasi::latest()->paginate(10);
        return view('suadmin.regulasi.index', compact('regulasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suadmin.regulasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'file_dokumen' => 'required|file|mimes:pdf|max:5120',
        ]);

        $file = $request->file('file_dokumen');
        $path = $file->store('regulasi_files', 'public'); // Simpan di storage/app/public/regulasi_files

        Regulasi::create([
            'nama_dokumen' => $request->nama_dokumen,
            'file_path' => $path,
            'nama_file_asli' => $file->getClientOriginalName(),
        ]);

        return redirect()->route('suadmin.regulasi.index')
                         ->with('success', 'Dokumen regulasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Regulasi $regulasi)
    {
        return view('suadmin.regulasi.edit', compact('regulasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Regulasi $regulasi)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf|max:5120', // Boleh kosong
        ]);

        $regulasi->nama_dokumen = $request->nama_dokumen;

        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama
            Storage::disk('public')->delete($regulasi->file_path);

            // Upload file baru
            $file = $request->file('file_dokumen');
            $path = $file->store('regulasi_files', 'public');
            $regulasi->file_path = $path;
            $regulasi->nama_file_asli = $file->getClientOriginalName();
        }

        $regulasi->save();

        return redirect()->route('suadmin.regulasi.index')
                         ->with('success', 'Dokumen regulasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Regulasi $regulasi)
    {
        // Hapus file dari storage
        Storage::disk('public')->delete($regulasi->file_path);

        // Hapus data dari database
        $regulasi->delete();

        return redirect()->route('suadmin.regulasi.index')
                         ->with('success', 'Dokumen regulasi berhasil dihapus.');
    }

    public function trackDownload(Regulasi $regulasi)
    {
        $regulasi->increment('download_count');

        return Storage::disk('public')->download($regulasi->file_path, $regulasi->nama_file_asli);
    }
}
