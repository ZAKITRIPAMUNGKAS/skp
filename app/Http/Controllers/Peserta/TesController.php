<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\EventSesi;
use App\Models\SesiTes;
use App\Models\Soal;
use App\Services\TesService;
use Illuminate\Http\Request;

class TesController extends Controller
{
    protected TesService $tesService;

    public function __construct(TesService $tesService)
    {
        $this->tesService = $tesService;
    }

    /**
     * Cek apakah sesi tes sudah habis waktu dan tutup otomatis di DB jika sudah.
     */
    private function checkAndCloseSession($eventId, $tipe, $eventSesiId)
    {
        return SesiTes::where('event_id', $eventId)
            ->where('event_sesi_id', $eventSesiId)
            ->where('tipe', $tipe)
            ->first();
    }

    /**
     * Tampilkan daftar tes pretest & posttest kelompok materi.
     */
    public function index()
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403, 'Anda bukan peserta');

        $eventPeserta = EventPeserta::where('peserta_id', $peserta->id)
            ->with(['event'])
            ->whereHas('event', function ($q) {
                $q->whereIn('status', ['persiapan', 'berlangsung', 'selesai']);
            })
            ->latest()
            ->first();

        $activeEvent = $eventPeserta ? $eventPeserta->event : null;
        $materials = collect();

        if ($activeEvent) {
            $materials = EventSesi::where('event_id', $activeEvent->id)
                ->orderBy('urutan')
                ->get()
                ->map(function ($sesi) use ($activeEvent, $peserta) {
                    $this->checkAndCloseSession($activeEvent->id, 'pretest', $sesi->id);
                    $this->checkAndCloseSession($activeEvent->id, 'posttest', $sesi->id);

                    $preSesi = SesiTes::where('event_id', $activeEvent->id)->where('event_sesi_id', $sesi->id)->where('tipe', 'pretest')->first();
                    $postSesi = SesiTes::where('event_id', $activeEvent->id)->where('event_sesi_id', $sesi->id)->where('tipe', 'posttest')->first();

                    $pretestStatus = [
                        'done' => $this->tesService->hasSubmitted($activeEvent, $peserta, 'pretest', $sesi->id),
                        'active' => $preSesi && $preSesi->status === 'aktif',
                        'score' => $this->tesService->hasSubmitted($activeEvent, $peserta, 'pretest', $sesi->id)
                            ? ($this->tesService->getResult($activeEvent, $peserta, 'pretest', $sesi->id)['score'] ?? 0)
                            : null,
                        'total_soal' => Soal::where('event_id', $activeEvent->id)->where('event_sesi_id', $sesi->id)->where('tipe', 'pretest')->count(),
                    ];

                    $posttestStatus = [
                        'done' => $this->tesService->hasSubmitted($activeEvent, $peserta, 'posttest', $sesi->id),
                        'active' => $postSesi && $postSesi->status === 'aktif',
                        'score' => $this->tesService->hasSubmitted($activeEvent, $peserta, 'posttest', $sesi->id)
                            ? ($this->tesService->getResult($activeEvent, $peserta, 'posttest', $sesi->id)['score'] ?? 0)
                            : null,
                        'total_soal' => Soal::where('event_id', $activeEvent->id)->where('event_sesi_id', $sesi->id)->where('tipe', 'posttest')->count(),
                    ];

                    return [
                        'id' => $sesi->id,
                        'nama_sesi' => $sesi->nama_sesi,
                        'urutan' => $sesi->urutan,
                        'pretest' => $pretestStatus,
                        'posttest' => $posttestStatus,
                    ];
                });
        }

        return view('peserta.tes.index', compact('peserta', 'activeEvent', 'materials'));
    }

    /**
     * Tampilkan halaman instruksi sebelum memulai tes.
     */
    public function instruction(Event $event, EventSesi $eventSesi, string $tipe)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403, 'Anda bukan peserta');

        $ep = EventPeserta::where('event_id', $event->id)
            ->where('peserta_id', $peserta->id)
            ->first();
        if (!$ep) abort(403, 'Anda tidak terdaftar di event ini');

        $sesiTes = $this->checkAndCloseSession($event->id, $tipe, $eventSesi->id);

        if (!$sesiTes || $sesiTes->status !== 'aktif') {
            return view('peserta.tes.closed', compact('event', 'eventSesi', 'tipe'));
        }

        if ($this->tesService->hasSubmitted($event, $peserta, $tipe, $eventSesi->id)) {
            return redirect()->route('peserta.tes.index');
        }

        $totalSoal = Soal::where('event_id', $event->id)
            ->where('event_sesi_id', $eventSesi->id)
            ->where('tipe', $tipe)
            ->count();

        return view('peserta.tes.instruction', compact(
            'event', 'eventSesi', 'tipe', 'sesiTes', 'totalSoal'
        ));
    }

    /**
     * Tampilkan antarmuka tes.
     */
    public function take(Event $event, EventSesi $eventSesi, string $tipe)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        $sesiTes = $this->checkAndCloseSession($event->id, $tipe, $eventSesi->id);

        if (!$sesiTes || $sesiTes->status !== 'aktif') {
            return redirect()->route('peserta.tes.instruction', [$event, $eventSesi, $tipe])
                ->with('error', 'Tes belum dibuka atau sudah ditutup');
        }

        if ($this->tesService->hasSubmitted($event, $peserta, $tipe, $eventSesi->id)) {
            return redirect()->route('peserta.tes.index');
        }

        $questions = $this->tesService->getShuffledQuestions($event, $peserta, $tipe, $eventSesi->id);

        $pesertaMulai = \App\Models\PesertaTesMulai::firstOrCreate(
            [
                'peserta_id' => $peserta->id,
                'event_id' => $event->id,
                'event_sesi_id' => $eventSesi->id,
                'tipe' => $tipe,
            ],
            [
                'waktu_mulai' => now(),
            ]
        );

        $durasiMenit = $sesiTes->durasi_menit ?? 30;
        $endTime = $pesertaMulai->waktu_mulai->timestamp + ($durasiMenit * 60);
        $remainingSeconds = max(0, $endTime - now()->timestamp);

        if ($remainingSeconds <= 0) {
            $this->tesService->submitAnswers($event, $peserta, $tipe, [], $eventSesi->id);
            return redirect()->route('peserta.tes.index')->with('error', 'Waktu pengerjaan ujian Anda telah habis.');
        }

        return view('peserta.tes.take', compact(
            'event', 'eventSesi', 'tipe', 'sesiTes', 'questions', 'remainingSeconds'
        ));
    }

    /**
     * Kirim jawaban melalui AJAX.
     */
    public function submit(Request $request, Event $event, EventSesi $eventSesi, string $tipe)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) return response()->json(['error' => 'Unauthorized'], 403);

        $request->validate([
            'answers'             => 'required|array',
            'answers.*.soal_id'   => 'required|integer',
            'answers.*.pilihan_id'=> 'required|integer',
        ]);

        if ($this->tesService->hasSubmitted($event, $peserta, $tipe, $eventSesi->id)) {
            return response()->json(['error' => 'Anda sudah mengerjakan tes ini.'], 422);
        }

        $sesiTes = $this->checkAndCloseSession($event->id, $tipe, $eventSesi->id);
        if (!$sesiTes || $sesiTes->status !== 'aktif') {
            return response()->json(['error' => 'Sesi tes tidak aktif.'], 422);
        }

        // Validate individual timer
        $pesertaMulai = \App\Models\PesertaTesMulai::where('peserta_id', $peserta->id)
            ->where('event_id', $event->id)
            ->where('event_sesi_id', $eventSesi->id)
            ->where('tipe', $tipe)
            ->first();

        if ($pesertaMulai) {
            $durasiMenit = $sesiTes->durasi_menit ?? 30;
            $endTime = $pesertaMulai->waktu_mulai->timestamp + ($durasiMenit * 60);
            
            // Allow 15 seconds tolerance for network latency
            if (now()->timestamp > ($endTime + 15)) {
                $this->tesService->submitAnswers($event, $peserta, $tipe, [], $eventSesi->id);
                return response()->json(['error' => 'Waktu pengerjaan telah habis.'], 422);
            }
        }

        $result = $this->tesService->submitAnswers(
            $event, $peserta, $tipe, $request->answers, $eventSesi->id
        );

        return response()->json([
            'status' => 'success',
            'result' => $result,
        ]);
    }

    /**
     * Tampilkan halaman hasil tes.
     */
    public function result(Event $event, EventSesi $eventSesi, string $tipe)
    {
        return redirect()->route('peserta.tes.index')->with('success', 'Ujian telah selesai dikerjakan.');
    }
}
