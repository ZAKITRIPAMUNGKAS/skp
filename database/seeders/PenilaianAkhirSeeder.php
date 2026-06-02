<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\AhpBobot;
use App\Services\NilaiService;
use App\Services\SawService;

class PenilaianAkhirSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();
        if (!$event) return;

        // 1. Siapkan Matriks AHP yang sangat konsisten untuk kriteria evaluasi
        // Matriks 5x5 di mana semua elemen bernilai 1 = tingkat kepentingan yang sama.
        // C1 (Pretest), C2 (Posttest), C3 (Afektif), C4 (Psikomotor), C5 (Kehadiran)
        
        $matrix = [];
        for ($i = 0; $i < 5; $i++) {
            for ($j = $i + 1; $j < 5; $j++) {
                $matrix["{$i}_{$j}"] = "1";
            }
        }

        AhpBobot::updateOrCreate(
            ['event_id' => $event->id],
            [
                'matriks'       => json_encode($matrix),
                'bobot_c1'      => 0.2, // 20%
                'bobot_c2'      => 0.2, // 20%
                'bobot_c3'      => 0.2, // 20%
                'bobot_c4'      => 0.2, // 20%
                'bobot_c5'      => 0.2, // 20%
                'cr_value'      => 0.0, // Konsisten
                'is_consistent' => true,
            ]
        );

        // 2. Kita telah melakukan seeding Absensi secara acak, sekarang instruksikan NilaiService untuk menghitung kehadiran secara akurat
        $pesertas = \App\Models\EventPeserta::where('event_id', $event->id)->get();
        foreach ($pesertas as $ep) {
            NilaiService::hitungKehadiran($event->id, $ep->peserta_id);
        }

        // 3. Evaluasi Ulang Peringkat melalui SAW Service (yang akan disimpan ke Penilaian Akhir)
        SawService::hitungUlang($event->id);
    }
}
