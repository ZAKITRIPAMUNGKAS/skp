<?php

namespace App\Observers;

use App\Models\Absensi;
use App\Services\NilaiService;
use App\Services\SawService;

class AbsensiObserver
{
    /**
     * Tangani event Absensi "created" (dibuat).
     */
    public function created(Absensi $absensi): void
    {
        NilaiService::hitungKehadiran($absensi->event_id, $absensi->peserta_id);
        SawService::hitungUlang($absensi->event_id, $absensi->peserta_id);
    }

    /**
     * Tangani event Absensi "deleted" (dihapus).
     */
    public function deleted(Absensi $absensi): void
    {
        NilaiService::hitungKehadiran($absensi->event_id, $absensi->peserta_id);
        SawService::hitungUlang($absensi->event_id, $absensi->peserta_id);
    }
}
