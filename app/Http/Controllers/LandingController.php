<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Peserta;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Untuk bagian statistik
        $totalEvents = Event::where('status', 'selesai')->count();
        $totalAlumni = Peserta::count();
        $totalMitra = Peserta::whereNotNull('unit_kerja')->distinct('unit_kerja')->count('unit_kerja');
        $totalSertifikat = \App\Models\PenilaianAkhir::where('status_kelulusan', 'lulus')->count();
        
        // Event aktif atau event mendatang terbaru
        $activeEvent = Event::whereIn('status', ['berlangsung', 'persiapan'])
            ->orderBy('tanggal_mulai', 'asc')
            ->first();

        // Jika tidak ada yang aktif, ambil yang terbaru
        if (!$activeEvent) {
            $activeEvent = Event::latest('tanggal_mulai')->first();
        }

        return view('landing.index', compact(
            'totalEvents', 
            'totalAlumni', 
            'totalMitra', 
            'totalSertifikat', 
            'activeEvent'
        ));
    }
}
