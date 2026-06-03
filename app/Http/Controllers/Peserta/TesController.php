<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventPeserta;
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
    private function checkAndCloseSession($eventId, $tipe)
    {
        $sesiTes = SesiTes::where('event_id', $eventId)->where('tipe', $tipe)->first();
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
     * Tampilkan daftar tes pretest & posttest.
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
        $pretestStatus = null;
        $posttestStatus = null;

        if ($activeEvent) {
            // Auto close expired sessions
            $this->checkAndCloseSession($activeEvent->id, 'pretest');
            $this->checkAndCloseSession($activeEvent->id, 'posttest');

            $pretestStatus = [
                'done' => $this->tesService->hasSubmitted($activeEvent, $peserta, 'pretest'),
                'active' => SesiTes::where('event_id', $activeEvent->id)->where('tipe', 'pretest')->where('status', 'aktif')->exists(),
                'score' => \App\Models\PenilaianAkhir::where('event_id', $activeEvent->id)->where('peserta_id', $peserta->id)->value('nilai_pretest'),
                'total_soal' => Soal::where('event_id', $activeEvent->id)->where('tipe', 'pretest')->count(),
            ];
            $posttestStatus = [
                'done' => $this->tesService->hasSubmitted($activeEvent, $peserta, 'posttest'),
                'active' => SesiTes::where('event_id', $activeEvent->id)->where('tipe', 'posttest')->where('status', 'aktif')->exists(),
                'score' => \App\Models\PenilaianAkhir::where('event_id', $activeEvent->id)->where('peserta_id', $peserta->id)->value('nilai_posttest'),
                'total_soal' => Soal::where('event_id', $activeEvent->id)->where('tipe', 'posttest')->count(),
            ];
        }

        return view('peserta.tes.index', compact('peserta', 'activeEvent', 'pretestStatus', 'posttestStatus'));
    }

    /**
     * Tampilkan halaman instruksi sebelum memulai tes.
     */
    public function instruction(Event $event, string $tipe)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403, 'Anda bukan peserta');

        // Periksa pendaftaran
        $ep = EventPeserta::where('event_id', $event->id)
            ->where('peserta_id', $peserta->id)
            ->first();
        if (!$ep) abort(403, 'Anda tidak terdaftar di event ini');

        // Periksa apakah sesi tes aktif (dan auto close jika expired)
        $sesiTes = $this->checkAndCloseSession($event->id, $tipe);

        if (!$sesiTes || $sesiTes->status !== 'aktif') {
            return view('peserta.tes.closed', compact('event', 'tipe'));
        }

        // Periksa apakah sudah dikirim
        if ($this->tesService->hasSubmitted($event, $peserta, $tipe)) {
            return redirect()->route('peserta.tes.result', [$event, $tipe]);
        }

        $totalSoal = Soal::where('event_id', $event->id)
            ->where('tipe', $tipe)
            ->count();

        return view('peserta.tes.instruction', compact(
            'event', 'tipe', 'sesiTes', 'totalSoal'
        ));
    }

    /**
     * Tampilkan antarmuka tes.
     */
    public function take(Event $event, string $tipe)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        // Periksa apakah sesi tes aktif (dan auto close jika expired)
        $sesiTes = $this->checkAndCloseSession($event->id, $tipe);

        if (!$sesiTes || $sesiTes->status !== 'aktif') {
            return redirect()->route('peserta.tes.instruction', [$event, $tipe])
                ->with('error', 'Tes belum dibuka atau sudah ditutup');
        }

        if ($this->tesService->hasSubmitted($event, $peserta, $tipe)) {
            return redirect()->route('peserta.tes.result', [$event, $tipe]);
        }

        $questions = $this->tesService->getShuffledQuestions($event, $peserta, $tipe);

        // Hitung sisa detik berdasarkan waktu mulai sesi global
        $remainingSeconds = 0;
        if ($sesiTes->waktu_mulai) {
            $endTime = $sesiTes->waktu_mulai->timestamp + ($sesiTes->durasi_menit * 60);
            $remainingSeconds = max(0, $endTime - now()->timestamp);
        }

        return view('peserta.tes.take', compact(
            'event', 'tipe', 'sesiTes', 'questions', 'remainingSeconds'
        ));
    }

    /**
     * Kirim jawaban melalui AJAX.
     */
    public function submit(Request $request, Event $event, string $tipe)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) return response()->json(['error' => 'Unauthorized'], 403);

        $request->validate([
            'answers'             => 'required|array',
            'answers.*.soal_id'   => 'required|integer',
            'answers.*.pilihan_id'=> 'required|integer',
        ]);

        if ($this->tesService->hasSubmitted($event, $peserta, $tipe)) {
            return response()->json(['error' => 'Anda sudah mengerjakan tes ini.'], 422);
        }

        // Jalankan checkAndCloseSession tapi tetap izinkan submit jawaban
        $this->checkAndCloseSession($event->id, $tipe);

        $result = $this->tesService->submitAnswers(
            $event, $peserta, $tipe, $request->answers
        );

        return response()->json([
            'status' => 'success',
            'result' => $result,
        ]);
    }

    /**
     * Tampilkan halaman hasil tes.
     */
    public function result(Event $event, string $tipe)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        $result = $this->tesService->getResult($event, $peserta, $tipe);
        if (!$result) {
            return redirect()->route('peserta.tes.instruction', [$event, $tipe]);
        }

        return view('peserta.tes.result', compact('event', 'tipe', 'result'));
    }
}
