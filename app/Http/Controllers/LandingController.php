<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Peserta;
use App\Models\Gallery;
use App\Models\Testimonial;
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
        $activeEvents = Event::whereIn('status', ['berlangsung', 'persiapan'])
            ->orderBy('tanggal_mulai', 'desc')
            ->take(5)
            ->get();

        // Jika tidak ada yang aktif, ambil yang terbaru
        if ($activeEvents->isEmpty()) {
            $activeEvents = Event::latest('tanggal_mulai')->take(3)->get();
        }

        $galleries = Gallery::orderBy('urutan')->get();
        $testimonials = Testimonial::orderBy('urutan')->get();

        return view('landing.index', compact(
            'totalEvents', 
            'totalAlumni', 
            'totalMitra', 
            'totalSertifikat', 
            'activeEvents',
            'galleries',
            'testimonials'
        ));
    }
}
