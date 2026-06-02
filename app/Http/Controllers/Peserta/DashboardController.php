<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\JawabanPeserta;
use App\Models\AfektifJawaban;
use App\Models\AngketJawaban;
use App\Models\PenilaianAkhir;
use App\Models\Absensi;
use App\Models\SesiTes;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) {
            abort(403, 'Akses ditolak, harap lengkapi profil peserta.');
        }

        $eventPeserta = EventPeserta::where('peserta_id', $peserta->id)
            ->with(['event' => fn($q) => $q->withCount('sesi')])
            ->whereHas('event', function ($q) {
                $q->whereIn('status', ['persiapan', 'berlangsung', 'selesai']);
            })
            ->latest()
            ->first();

        $activeEvent = $eventPeserta ? $eventPeserta->event : null;
        $progress = [];
        $scores = null;
        $sesiStatus = ['pretest' => false, 'posttest' => false];
        $chartData = null;

        if ($activeEvent) {
            $eventId = $activeEvent->id;
            
            $pretestDone = JawabanPeserta::where('event_id', $eventId)
                ->where('peserta_id', $peserta->id)
                ->whereHas('soal', fn($q) => $q->where('tipe', 'pretest'))
                ->exists();

            $posttestDone = JawabanPeserta::where('event_id', $eventId)
                ->where('peserta_id', $peserta->id)
                ->whereHas('soal', fn($q) => $q->where('tipe', 'posttest'))
                ->exists();

            $afektifDone = AfektifJawaban::where('event_id', $eventId)
                ->where('peserta_id', $peserta->id)
                ->exists();

            $angketDone = AngketJawaban::where('event_id', $eventId)
                ->where('peserta_id', $peserta->id)
                ->exists();

            $attended = Absensi::where('event_id', $eventId)
                ->where('peserta_id', $peserta->id)
                ->count();

            $progress = [
                'pretest'    => $pretestDone,
                'posttest'   => $posttestDone,
                'afektif'    => $afektifDone,
                'angket'     => $angketDone,
                'attended'   => $attended,
                'total_sesi' => $activeEvent->sesi_count,
            ];

            $preSesi = SesiTes::where('event_id', $eventId)->where('tipe', 'pretest')->first();
            $postSesi = SesiTes::where('event_id', $eventId)->where('tipe', 'posttest')->first();

            $sesiStatus['pretest'] = $preSesi && $preSesi->status === 'aktif';
            $sesiStatus['posttest'] = $postSesi && $postSesi->status === 'aktif';

            $scores = PenilaianAkhir::where('event_id', $eventId)->where('peserta_id', $peserta->id)->first();
            
            if ($scores) {
                $chartData = [
                    'labels' => ['Pretest', 'Posttest', 'Afektif', 'Psikomotor', 'Kehadiran'],
                    'data'   => [
                        (float) $scores->nilai_pretest,
                        (float) $scores->nilai_posttest,
                        (float) $scores->nilai_afektif,
                        (float) $scores->nilai_psikomotor,
                        (float) $scores->nilai_kehadiran,
                    ]
                ];
            }
        }

        return view('peserta.dashboard', compact('peserta', 'activeEvent', 'eventPeserta', 'progress', 'scores', 'sesiStatus', 'chartData'));
    }

    public function downloadSertifikat(Event $event)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        $skor = PenilaianAkhir::where('event_id', $event->id)->where('peserta_id', $peserta->id)->first();
        
        if (!$skor || empty($skor->status_kelulusan) || str_contains($skor->status_kelulusan, 'Tidak Lulus')) {
            abort(403, 'Sertifikat belum tersedia atau Anda tidak lulus evaluasi.');
        }

        if (empty($skor->verification_hash)) {
            $skor->verification_hash = hash('sha256', $event->id . $peserta->id . config('app.key'));
            $skor->save();
        }

        $verificationUrl = route('certificate.verify', $skor->verification_hash);

        $pdf = Pdf::loadView('peserta.sertifikat-pdf', compact('event', 'peserta', 'skor', 'verificationUrl'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Sertifikat_Baitul_Arqam_' . str_replace(' ', '_', $peserta->nama_lengkap) . '.pdf');
    }

    public function downloadIdCard(Event $event)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        $eventPeserta = EventPeserta::where('event_id', $event->id)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        // Konten Kode QR: Gunakan blob QR berbasis token yang aman
        $qrData = $eventPeserta->qr_code; 

        $pdf = Pdf::loadView('peserta.idcard-pdf', compact('event', 'peserta', 'qrData'))
            ->setPaper([0, 0, 243.7, 388.3]); // Ukuran ID Card dalam poin (sekitar 86mm x 137mm atau sejenisnya)

        return $pdf->download('ID_Card_' . str_replace(' ', '_', $peserta->nama_lengkap) . '.pdf');
    }

    /**
     * Tampilkan riwayat kehadiran peserta.
     */
    public function kehadiran()
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) {
            abort(403, 'Akses ditolak, harap lengkapi profil peserta.');
        }

        $eventPeserta = EventPeserta::where('peserta_id', $peserta->id)
            ->with(['event'])
            ->whereHas('event', function ($q) {
                $q->whereIn('status', ['persiapan', 'berlangsung', 'selesai']);
            })
            ->latest()
            ->first();

        $activeEvent = $eventPeserta ? $eventPeserta->event : null;
        $sessions = collect();
        $attendedCount = 0;
        $totalSessions = 0;

        if ($activeEvent) {
            $sessions = \App\Models\EventSesi::where('event_id', $activeEvent->id)
                ->orderBy('urutan')
                ->get()
                ->map(function ($sesi) use ($peserta, $activeEvent) {
                    $absensi = Absensi::where('event_id', $activeEvent->id)
                        ->where('sesi_id', $sesi->id)
                        ->where('peserta_id', $peserta->id)
                        ->first();

                    return [
                        'id' => $sesi->id,
                        'nama_sesi' => $sesi->nama_sesi,
                        'urutan' => $sesi->urutan,
                        'attended' => !is_null($absensi),
                        'waktu_scan' => $absensi ? $absensi->waktu_scan : null,
                    ];
                });

            $attendedCount = $sessions->where('attended', true)->count();
            $totalSessions = $sessions->count();
        }

        return view('peserta.kehadiran.index', compact('peserta', 'activeEvent', 'sessions', 'attendedCount', 'totalSessions'));
    }

    /**
     * Tampilkan laporan hasil penilaian akhir peserta.
     */
    public function hasil()
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) {
            abort(403, 'Akses ditolak, harap lengkapi profil peserta.');
        }

        $eventPeserta = EventPeserta::where('peserta_id', $peserta->id)
            ->with(['event'])
            ->whereHas('event', function ($q) {
                $q->whereIn('status', ['persiapan', 'berlangsung', 'selesai']);
            })
            ->latest()
            ->first();

        $activeEvent = $eventPeserta ? $eventPeserta->event : null;
        $scores = null;

        if ($activeEvent) {
            $scores = PenilaianAkhir::where('event_id', $activeEvent->id)
                ->where('peserta_id', $peserta->id)
                ->first();
        }

        return view('peserta.hasil.index', compact('peserta', 'activeEvent', 'scores'));
    }

    /**
     * Tampilkan jadwal sesi kegiatan.
     */
    public function jadwal()
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        $eventPeserta = EventPeserta::where('peserta_id', $peserta->id)
            ->with(['event'])
            ->whereHas('event', function ($q) {
                $q->whereIn('status', ['persiapan', 'berlangsung', 'selesai']);
            })
            ->latest()
            ->first();

        $activeEvent = $eventPeserta ? $eventPeserta->event : null;
        $sessions = collect();

        if ($activeEvent) {
            $sessions = \App\Models\EventSesi::where('event_id', $activeEvent->id)
                ->orderBy('urutan')
                ->get()
                ->map(function ($sesi) use ($peserta, $activeEvent) {
                    $absensi = Absensi::where('event_id', $activeEvent->id)
                        ->where('sesi_id', $sesi->id)
                        ->where('peserta_id', $peserta->id)
                        ->first();
                    return [
                        'id'            => $sesi->id,
                        'urutan'        => $sesi->urutan,
                        'nama_sesi'     => $sesi->nama_sesi,
                        'deskripsi'     => $sesi->deskripsi ?? null,
                        'waktu_mulai'   => $sesi->waktu_mulai ?? null,
                        'waktu_selesai' => $sesi->waktu_selesai ?? null,
                        'attended'      => !is_null($absensi),
                        'waktu_scan'    => $absensi ? $absensi->waktu_scan : null,
                    ];
                });
        }

        return view('peserta.jadwal.index', compact('peserta', 'activeEvent', 'sessions'));
    }
}
