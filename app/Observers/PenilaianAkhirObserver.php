<?php

namespace App\Observers;

use App\Models\PenilaianAkhir;
use App\Services\SawService;

class PenilaianAkhirObserver
{
    /**
     * Tangani event PenilaianAkhir "updated" (diperbarui).
     */
    public function updated(PenilaianAkhir $penilaianAkhir): void
    {
        // Cek jika kolom nilai berubah, tapi tidak bereaksi jika hanya skor_saw/ranking yang berubah.
        $changed = $penilaianAkhir->getDirty();
        $triggerFields = ['nilai_pretest', 'nilai_posttest', 'nilai_afektif', 'nilai_psikomotor', 'nilai_kehadiran'];
        
        $shouldTrigger = false;
        foreach ($triggerFields as $field) {
            if (array_key_exists($field, $changed)) {
                $shouldTrigger = true;
                break;
            }
        }

        if ($shouldTrigger) {
            SawService::hitungUlang($penilaianAkhir->event_id, $penilaianAkhir->peserta_id);
        }
    }
}
