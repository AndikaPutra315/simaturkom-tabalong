<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataMenara;

class PetaController extends Controller
{
    public function index()
    {
        $providers = DataMenara::select('provider')->distinct()->orderBy('provider')->get();
        $kecamatans = DataMenara::select('kecamatan')->distinct()->orderBy('kecamatan')->get();

        return view('pages.peta', compact('providers', 'kecamatans'));
    }

    public function getMenaraData(Request $request)
    {
        // Mulai query dengan filter untuk memastikan koordinat valid
        $query = DataMenara::query()
                    ->whereNotNull('latitude')
                    ->where('latitude', '!=', '')
                    ->where('latitude', '!=', 0) // <-- PERBAIKAN: Jangan ambil data jika latitude 0
                    ->whereNotNull('longitude')
                    ->where('longitude', '!=', '')
                    ->where('longitude', '!=', 0); // <-- PERBAIKAN: Jangan ambil data jika longitude 0

        // Filter berdasarkan provider jika dipilih
        if ($request->has('provider') && $request->provider != 'semua') {
            $query->where('provider', $request->provider);
        }

        // Filter berdasarkan kecamatan jika dipilih
        if ($request->has('kecamatan') && $request->kecamatan != 'semua') {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Ambil data yang cocok
        $menaraData = $query->get(['provider', 'alamat', 'longitude', 'latitude']);

        return response()->json($menaraData);
    }
}
