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
        $sesiTes = SesiTes::where('event_id', $eventId)
            ->where('event_sesi_id', $eventSesiId)
            ->where('tipe', $tipe)
            ->first();

        if ($sesiTes && $sesiTes->status === 'aktif' && $sesiTes->waktu_mulai) {
            $endTime = $sesiTes->waktu_mulai->timestamp + ($sesiTes->durasi_menit * 60);
            if (now()->timestamp >= $endTime) {
                $sesiTes->update([
                    'status' => 'tutup',
                    'waktu_selesai' => now(),
                ]);
                $sesiTes->status = 'tutup';
            }
        }
        return $sesiTes;
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
            return redirect()->route('peserta.tes.result', [$event, $eventSesi, $tipe]);
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
            return redirect()->route('peserta.tes.result', [$event, $eventSesi, $tipe]);
        }

        $questions = $this->tesService->getShuffledQuestions($event, $peserta, $tipe, $eventSesi->id);

        $remainingSeconds = 0;
        if ($sesiTes->waktu_mulai) {
            $endTime = $sesiTes->waktu_mulai->timestamp + ($sesiTes->durasi_menit * 60);
            $remainingSeconds = max(0, $endTime - now()->timestamp);
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

        $this->checkAndCloseSession($event->id, $tipe, $eventSesi->id);

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
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        $result = $this->tesService->getResult($event, $peserta, $tipe, $eventSesi->id);
        if (!$result) {
            return redirect()->route('peserta.tes.instruction', [$event, $eventSesi, $tipe]);
        }

        return view('peserta.tes.result', compact('event', 'eventSesi', 'tipe', 'result'));
    }
}
