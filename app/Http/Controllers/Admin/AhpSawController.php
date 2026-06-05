<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AhpBobot;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\PenilaianAkhir;
use App\Services\AhpService;
use Illuminate\Http\Request;

class AhpSawController extends Controller
{
    /**
     * Hitung bobot AHP dari matriks perpasangan.
     */
    public function calculateAhp(Request $request, Event $event)
    {
        $request->validate(['matrix' => 'required|array']);

        $matrix = AhpService::buildMatrix($request->matrix);
        $result = AhpService::calculate($matrix);

        return response()->json([
            'weights'       => $result['weights'],
            'lambda_max'    => $result['lambda_max'],
            'ci'            => $result['ci'],
            'cr'            => $result['cr'],
            'is_consistent' => $result['is_consistent'],
            'labels'        => AhpService::LABELS,
        ]);
    }

    /**
     * Simpan bobot AHP yang konsisten.
     */
    public function saveAhp(Request $request, Event $event)
    {
        $request->validate(['matrix' => 'required|array']);

        $matrix = AhpService::buildMatrix($request->matrix);
        $result = AhpService::calculate($matrix);

        if (!$result['is_consistent']) {
            return response()->json(['error' => 'Matriks tidak konsisten (CR > 0.1)'], 422);
        }

        AhpBobot::updateOrCreate(
            ['event_id' => $event->id],
            [
                'matriks'       => json_encode($request->matrix),
                'bobot_c1'      => $result['weights'][0],
                'bobot_c2'      => $result['weights'][1],
                'bobot_c3'      => $result['weights'][2],
                'bobot_c4'      => $result['weights'][3],
                'bobot_c5'      => $result['weights'][4],
                'cr_value'      => $result['cr'],
                'is_consistent' => true,
            ]
        );

        return response()->json(['status' => 'success', 'weights' => $result['weights'], 'cr' => $result['cr']]);
    }

    /**
     * Dapatkan bobot AHP yang disimpan.
     */
    public function getAhp(Event $event)
    {
        $bobot = AhpBobot::where('event_id', $event->id)->first();
        return response()->json(['bobot' => $bobot]);
    }

    /**
     * Hitung peringkat SAW.
     */
    public function calculateSaw(Request $request, Event $event)
    {
        $bobot = AhpBobot::where('event_id', $event->id)->where('is_consistent', true)->first();
        if (!$bobot) {
            return response()->json(['error' => 'Bobot AHP belum dihitung atau tidak konsisten.'], 422);
        }

        $rows = \App\Services\SawService::calculate($event->id);

        // Periksa kelengkapan
        $incomplete = [];
        $penilaian = PenilaianAkhir::where('event_id', $event->id)
            ->whereHas('peserta.eventPeserta', function ($q) use ($event) {
                $q->where('event_id', $event->id)->where('status_aktif', true);
            })
            ->with('peserta')
            ->get();
        foreach ($penilaian as $p) {
            $missing = [];
            if ($p->nilai_pretest == 0) $missing[] = 'C1 (Pretest)';
            if ($p->nilai_posttest == 0) $missing[] = 'C2 (Posttest)';
            if ($p->nilai_afektif == 0) $missing[] = 'C3 (Afektif)';
            if ($p->nilai_psikomotor == 0) $missing[] = 'C4 (Psikomotor)';
            if ($p->nilai_kehadiran == 0) $missing[] = 'C5 (Kehadiran)';
            if (!empty($missing)) {
                $incomplete[] = ['nama' => $p->peserta->nama_lengkap ?? 'Unknown', 'missing' => $missing];
            }
        }

        if (!$request->input('force') && !empty($incomplete)) {
            return response()->json([
                'status' => 'warning',
                'incomplete' => $incomplete
            ]);
        }

        // Terapkan peringkat ke database
        \App\Services\SawService::hitungUlang($event->id);

        return response()->json([
            'rows'       => $rows,
            'weights'    => [$bobot->bobot_c1, $bobot->bobot_c2, $bobot->bobot_c3, $bobot->bobot_c4, $bobot->bobot_c5],
            'labels'     => AhpService::LABELS,
            'incomplete' => $incomplete,
        ]);
    }
}
