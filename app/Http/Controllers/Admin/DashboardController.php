<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PenilaianAkhir;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hour = Carbon::now()->format('H');
        if ($hour < 12) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($hour < 18) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }

        // Event aktif
        $activeEvent = Event::where('status', 'berlangsung')->withCount('eventPesertaAktif')->first();
        if (!$activeEvent) {
            $activeEvent = Event::where('status', 'persiapan')->withCount('eventPesertaAktif')->first();
        }
        if (!$activeEvent) {
            $activeEvent = Event::withCount('eventPesertaAktif')->latest()->first();
        }

        $stats = [
            'total_peserta'    => 0,
            'avg_pretest'      => 0,
            'avg_posttest'     => 0,
            'avg_kehadiran'    => 0,
            'avg_ngain'        => 0,
        ];

        $chartData = [
            'predikat_labels' => ['Amat Baik', 'Baik', 'Cukup', 'Kurang'],
            'predikat_data'   => [0, 0, 0, 0],
            'pre_post_avg'    => [0, 0]
        ];

        $topRankings = collect();

        if ($activeEvent) {
            $stats['total_peserta'] = $activeEvent->event_peserta_aktif_count;
            
            $penilaian = PenilaianAkhir::where('event_id', $activeEvent->id)
                ->whereHas('peserta.eventPeserta', function ($q) use ($activeEvent) {
                    $q->where('event_id', $activeEvent->id)->where('status_aktif', true);
                })
                ->get();
            
            if ($penilaian->count()) {
                $stats['avg_pretest']   = $penilaian->avg('nilai_pretest') ?? 0;
                $stats['avg_posttest']  = $penilaian->avg('nilai_posttest') ?? 0;
                $stats['avg_kehadiran'] = $penilaian->avg('nilai_kehadiran') ?? 0;
                
                $nGains = $penilaian->map(fn($p) => $p->n_gain_score);
                $stats['avg_ngain']     = $nGains->avg() ?? 0;

                $chartData['predikat_data'] = [
                    $penilaian->where('predikat', 'Amat Baik')->count(),
                    $penilaian->where('predikat', 'Baik')->count(),
                    $penilaian->where('predikat', 'Cukup')->count(),
                    $penilaian->where('predikat', 'Kurang')->count(),
                ];

                $chartData['pre_post_avg'] = [
                    round($stats['avg_pretest'], 2),
                    round($stats['avg_posttest'], 2)
                ];
            }

            $topRankings = PenilaianAkhir::where('event_id', $activeEvent->id)
                ->with('peserta')
                ->whereNotNull('ranking')
                ->orderBy('ranking')
                ->take(10)
                ->get();
        }

        return view('admin.dashboard', compact('greeting', 'activeEvent', 'stats', 'chartData', 'topRankings'));
    }
}
