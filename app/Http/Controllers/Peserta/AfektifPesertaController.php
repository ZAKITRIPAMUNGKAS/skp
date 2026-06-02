<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\AfektifButir;
use App\Models\AfektifJawaban;
use App\Models\AfektifSubAspek;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\PenilaianAkhir;
use Illuminate\Http\Request;

class AfektifPesertaController extends Controller
{
    /**
     * Tampilkan daftar sub-aspek untuk seorang peserta.
     */
    public function index(Event $event)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        $ep = EventPeserta::where('event_id', $event->id)->where('peserta_id', $peserta->id)->firstOrFail();

        $subAspeks = AfektifSubAspek::where('event_id', $event->id)
            ->with('butir')
            ->orderBy('urutan')
            ->get()
            ->map(function ($sa) use ($peserta, $event) {
                $butirCount = $sa->butir->count();
                $answeredCount = AfektifJawaban::where('event_id', $event->id)
                    ->where('peserta_id', $peserta->id)
                    ->where('sub_aspek_id', $sa->id)
                    ->count();

                return [
                    'id'          => $sa->id,
                    'nama'        => $sa->nama_sub_aspek,
                    'status'      => $sa->status,
                    'butirCount'  => $butirCount,
                    'answered'    => $answeredCount,
                    'completed'   => $butirCount > 0 && $answeredCount >= $butirCount,
                ];
            });

        return view('peserta.afektif.index', compact('event', 'subAspeks'));
    }

    /**
     * Tampilkan halaman pengisian untuk suatu sub-aspek.
     */
    public function fill(Event $event, AfektifSubAspek $subAspek)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        if ($subAspek->status !== 'aktif') {
            return redirect()->route('peserta.afektif.index', $event)
                ->with('error', 'Sub-aspek ini belum dibuka atau sudah ditutup.');
        }

        $butirList = AfektifButir::where('sub_aspek_id', $subAspek->id)
            ->orderBy('urutan')
            ->get();

        // Dapatkan jawaban yang sudah ada
        $existingAnswers = AfektifJawaban::where('event_id', $event->id)
            ->where('peserta_id', $peserta->id)
            ->where('sub_aspek_id', $subAspek->id)
            ->pluck('jawaban', 'butir_id')
            ->toArray();

        // Hitung sub-aspek yang sudah selesai
        $allSubAspeks = AfektifSubAspek::where('event_id', $event->id)->withCount('butir')->orderBy('urutan')->get();
        $completedCount = 0;
        foreach ($allSubAspeks as $sa) {
            $cnt = AfektifJawaban::where('event_id', $event->id)
                ->where('peserta_id', $peserta->id)
                ->where('sub_aspek_id', $sa->id)
                ->count();
            if ($sa->butir_count > 0 && $cnt >= $sa->butir_count) $completedCount++;
        }

        return view('peserta.afektif.fill', compact(
            'event', 'subAspek', 'butirList', 'existingAnswers',
            'completedCount', 'allSubAspeks'
        ));
    }

    /**
     * Simpan jawaban (draf atau kirim final).
     */
    public function save(Request $request, Event $event, AfektifSubAspek $subAspek)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) return response()->json(['error' => 'Unauthorized'], 403);

        $request->validate([
            'answers'              => 'required|array',
            'answers.*.butir_id'   => 'required|integer',
            'answers.*.jawaban'    => 'required|in:SS,S,TS,STS',
        ]);

        foreach ($request->answers as $ans) {
            $butir = AfektifButir::find($ans['butir_id']);
            if (!$butir) continue;

            $skor = $this->calculateScore($ans['jawaban'], $butir->is_positif);

            AfektifJawaban::updateOrCreate(
                [
                    'event_id'    => $event->id,
                    'peserta_id'  => $peserta->id,
                    'sub_aspek_id'=> $subAspek->id,
                    'butir_id'    => $ans['butir_id'],
                ],
                [
                    'jawaban' => $ans['jawaban'],
                    'skor'    => $skor,
                ]
            );
        }

        // Hitung ulang total skor afektif
        $this->recalculateAfektifScore($event, $peserta);

        return response()->json(['status' => 'success']);
    }

    /**
     * Redirect to the active event's affective index page.
     */
    public function indexRoot()
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        $eventPeserta = EventPeserta::where('peserta_id', $peserta->id)
            ->whereHas('event', function ($q) {
                $q->whereIn('status', ['persiapan', 'berlangsung', 'selesai']);
            })
            ->latest()
            ->first();

        if ($eventPeserta && $eventPeserta->event) {
            return redirect()->route('peserta.afektif.index', $eventPeserta->event->id);
        }

        return redirect()->route('peserta.dashboard')->with('error', 'Belum ada acara aktif untuk mengisi penilaian afektif.');
    }

    /**
     * Hitung skor berdasarkan jawaban dan polaritas pernyataan.
     */
    private function calculateScore(string $jawaban, bool $isPositif): int
    {
        $positifScores = ['SS' => 4, 'S' => 3, 'TS' => 2, 'STS' => 1];
        $negatifScores = ['SS' => 1, 'S' => 2, 'TS' => 3, 'STS' => 4];

        return $isPositif ? $positifScores[$jawaban] : $negatifScores[$jawaban];
    }

    /**
     * Hitung ulang total skor afektif di semua sub-aspek.
     */
    private function recalculateAfektifScore(Event $event, $peserta): void
    {
        $totalSkor = AfektifJawaban::where('event_id', $event->id)
            ->where('peserta_id', $peserta->id)
            ->sum('skor');

        $totalButir = AfektifButir::whereHas('subAspek', function ($q) use ($event) {
            $q->where('event_id', $event->id);
        })->count();

        $maxSkor = $totalButir * 4;
        $nilaiAfektif = $maxSkor > 0 ? round(($totalSkor / $maxSkor) * 100, 2) : 0;

        PenilaianAkhir::updateOrCreate(
            ['event_id' => $event->id, 'peserta_id' => $peserta->id],
            ['nilai_afektif' => $nilaiAfektif]
        );
    }
}
