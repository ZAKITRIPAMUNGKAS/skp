<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\AfektifButir;
use App\Models\AfektifJawaban;
use App\Models\PenilaianAkhir;

class AfektifJawabanSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();
        if (!$event) return;

        $pesertas = EventPeserta::where('event_id', $event->id)->get();
        $butirs = AfektifButir::whereHas('subAspek', function($q) use ($event) {
            $q->where('event_id', $event->id);
        })->get();

        foreach ($pesertas as $ep) {
            $pesertaId = $ep->peserta_id;
            
            $totalSkor = 0;
            foreach ($butirs as $butir) {
                // Simulasikan jawaban: 70% peluang jawaban 'Baik', 30% peluang 'Oke'
                // Baik untuk Positif (P): SS/S
                // Baik untuk Negatif (N): STS/TS
                
                $isP = $butir->is_positif;
                
                if (rand(1, 100) <= 80) {
                    $jawaban = $isP ? (rand(0,1) ? 'SS' : 'S') : (rand(0,1) ? 'STS' : 'TS');
                } else {
                    $jawaban = $isP ? (rand(0,1) ? 'TS' : 'STS') : (rand(0,1) ? 'SS' : 'S');
                }

                $map_positif = ['SS' => 4, 'S' => 3, 'TS' => 2, 'STS' => 1];
                $map_negatif = ['SS' => 1, 'S' => 2, 'TS' => 3, 'STS' => 4];
                $skor = $isP ? $map_positif[$jawaban] : $map_negatif[$jawaban];

                $aj = AfektifJawaban::create([
                    'event_id'     => $event->id,
                    'peserta_id'   => $pesertaId,
                    'sub_aspek_id' => $butir->sub_aspek_id,
                    'butir_id'     => $butir->id,
                    'jawaban'      => $jawaban,
                    'skor'         => $skor,
                ]);

                $totalSkor += $aj->skor;
            }

            // Hitung skor afektif akhir
            $maxSkor = $butirs->count() * 4;
            $nilaiAfektif = ($totalSkor / max(1, $maxSkor)) * 100;

            PenilaianAkhir::updateOrCreate(
                ['event_id' => $event->id, 'peserta_id' => $pesertaId],
                ['nilai_afektif' => round($nilaiAfektif, 2)]
            );
        }
    }
}
