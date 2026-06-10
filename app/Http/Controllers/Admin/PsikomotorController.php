<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\PenilaianAkhir;
use App\Models\PsikomotorNilai;
use App\Models\PsikomotorTemplate;
use Illuminate\Http\Request;

class PsikomotorController extends Controller
{
    /**
     * Inisialisasi template psikomotor default untuk suatu event.
     */
    public function initTemplates(Event $event)
    {
        $existing = PsikomotorTemplate::where('event_id', $event->id)->count();
        if ($existing > 0) {
            return response()->json(['status' => 'exists', 'message' => 'Template sudah ada']);
        }

        $defaults = [
            ['jenis' => 'outbound', 'nama_aspek' => 'Semangat (Enthusiasm)'],
            ['jenis' => 'outbound', 'nama_aspek' => 'Kedisiplinan (Discipline)'],
            ['jenis' => 'outbound', 'nama_aspek' => 'Kerjasama Tim (Teamwork)'],
            ['jenis' => 'outbound', 'nama_aspek' => 'Komunikasi (Communication)'],
            ['jenis' => 'ibadah',   'nama_aspek' => 'Ketertiban Sholat (Orderliness)'],
            ['jenis' => 'ibadah',   'nama_aspek' => 'Bacaan Al-Quran (Recitation)'],
            ['jenis' => 'ibadah',   'nama_aspek' => 'Kesesuaian dengan Tarjih (Tarjih Compliance)'],
        ];

        foreach ($defaults as $d) {
            PsikomotorTemplate::create([
                'event_id'  => $event->id,
                'jenis'     => $d['jenis'],
                'nama_aspek'=> $d['nama_aspek'],
                'skor_maks' => 4,
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Get psychomotor scoring data for mass table.
     */
    public function data(Event $event)
    {
        $templates = PsikomotorTemplate::where('event_id', $event->id)->get();
        $pesertaIds = EventPeserta::where('event_id', $event->id)->where('status_aktif', true)->pluck('peserta_id');

        $pesertaList = \App\Models\Peserta::whereIn('id', $pesertaIds)
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap', 'unit_kerja']);

        $nilaiMap = PsikomotorNilai::where('event_id', $event->id)
            ->get()
            ->groupBy('peserta_id');

        $rows = $pesertaList->map(function ($p) use ($templates, $nilaiMap, $event) {
            $pNilai = $nilaiMap->get($p->id, collect());
            $scores = [];
            $totalSkor = 0;

            foreach ($templates as $t) {
                $val = $pNilai->firstWhere('template_id', $t->id);
                $score = $val ? $val->skor : null;
                $scores[$t->id] = $score;
                $totalSkor += ($score ?? 0);
            }

            $maxSkor = $templates->sum('skor_maks');
            $percentage = $maxSkor > 0 ? round(($totalSkor / $maxSkor) * 100, 2) : 0;

            return [
                'peserta_id'   => $p->id,
                'nama'         => $p->nama_lengkap,
                'unit_kerja'   => $p->unit_kerja,
                'scores'       => $scores,
                'total'        => $totalSkor,
                'percentage'   => $percentage,
                'has_all'      => $pNilai->count() >= $templates->count(),
            ];
        });

        return response()->json([
            'templates' => $templates,
            'rows'      => $rows,
        ]);
    }

    /**
     * Simpan skor untuk peserta (simpan otomatis baris).
     */
    public function saveRow(Request $request, Event $event)
    {
        $request->validate([
            'peserta_id'            => 'required|integer',
            'scores'                => 'required|array',
            'scores.*.template_id'  => 'required|integer',
            'scores.*.skor'         => 'required|integer|min:1|max:4',
        ]);

        foreach ($request->scores as $s) {
            PsikomotorNilai::updateOrCreate(
                [
                    'event_id'    => $event->id,
                    'peserta_id'  => $request->peserta_id,
                    'template_id' => $s['template_id'],
                ],
                [
                    'skor'        => $s['skor'],
                    'dinilai_oleh'=> auth()->id(),
                ]
            );
        }

        // Hitung ulang skor psikomotor
        $this->recalculateScore($event->id, $request->peserta_id);

        return response()->json(['status' => 'success']);
    }

    /**
     * Simpan semua baris sekaligus.
     */
    public function saveAll(Request $request, Event $event)
    {
        $request->validate([
            'data'                       => 'required|array',
            'data.*.peserta_id'          => 'required|integer',
            'data.*.scores'              => 'required|array',
            'data.*.scores.*.template_id'=> 'required|integer',
            'data.*.scores.*.skor'       => 'required|integer|min:1|max:4',
        ]);

        foreach ($request->data as $row) {
            foreach ($row['scores'] as $s) {
                PsikomotorNilai::updateOrCreate(
                    [
                        'event_id'    => $event->id,
                        'peserta_id'  => $row['peserta_id'],
                        'template_id' => $s['template_id'],
                    ],
                    [
                        'skor'        => $s['skor'],
                        'dinilai_oleh'=> auth()->id(),
                    ]
                );
            }
            $this->recalculateScore($event->id, $row['peserta_id']);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Hitung ulang skor psikomotor untuk seorang peserta.
     */
    private function recalculateScore(int $eventId, int $pesertaId): void
    {
        $templates = PsikomotorTemplate::where('event_id', $eventId)->get();
        $totalSkor = PsikomotorNilai::where('event_id', $eventId)
            ->where('peserta_id', $pesertaId)
            ->sum('skor');

        $maxSkor = $templates->sum('skor_maks');
        $nilai = $maxSkor > 0 ? round(($totalSkor / $maxSkor) * 100, 2) : 0;

        PenilaianAkhir::updateOrCreate(
            ['event_id' => $eventId, 'peserta_id' => $pesertaId],
            ['nilai_psikomotor' => $nilai]
        );
    }
}
