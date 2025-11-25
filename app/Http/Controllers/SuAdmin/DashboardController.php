<?php

namespace App\Http\Controllers\SuAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataMenara;
use App\Models\HotspotData;
use App\Models\Regulasi;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data untuk Kartu Statistik Utama
        $totalMenara = DataMenara::count();
        $totalHotspot = HotspotData::count();
        $totalRegulasi = Regulasi::count();
        $totalUser = User::count();

        // 2. Data untuk Grafik (Jumlah Menara per Provider)
        $menaraPerProvider = DataMenara::select('provider', DB::raw('count(*) as total'))
                                ->groupBy('provider')
                                ->orderBy('total', 'desc')
                                ->get();

        // 3. Data untuk Aktivitas Terbaru (5 data menara terakhir yang dibuat)
        $aktivitasTerbaru = DataMenara::latest()->take(5)->get();

        // Kirim semua data ke view
        return view('suadmin.dashboard', compact(
            'totalMenara',
            'totalHotspot',
            'totalRegulasi',
            'totalUser',
            'menaraPerProvider',
            'aktivitasTerbaru'
        ));
    }
}
