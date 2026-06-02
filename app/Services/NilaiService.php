<?php

namespace App\Services;

use App\Models\EventSesi;
use App\Models\PenilaianAkhir;

class NilaiService
{
    /**
     * Menghitung nilai kehadiran peserta dan otomatis mengupdate penilaian_akhir.
     */
    public static function hitungKehadiran($eventId, $pesertaId)
    {
        // 1. Hitung total sesi di event ini
        $totalSesi = EventSesi::where('event_id', $eventId)->count();
        if ($totalSesi == 0) return 0;

        // 2. Hitung total absensi peserta di event ini
        $totalHadir = \App\Models\Absensi::where('event_id', $eventId)
            ->where('peserta_id', $pesertaId)
            ->count();

        // 3. Kalkulasi persentase
        $persentase = ($totalHadir / $totalSesi) * 100;

        // 4. Update nilai_kehadiran di tabel penilaian_akhir
        PenilaianAkhir::updateOrCreate(
            ['event_id' => $eventId, 'peserta_id' => $pesertaId],
            ['nilai_kehadiran' => $persentase]
        );

        return $persentase;
    }
}
