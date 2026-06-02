<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\PsikomotorTemplate;
use App\Models\PsikomotorNilai;
use App\Models\PenilaianAkhir;
use App\Models\User;

class PsikomotorNilaiSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();
        if (!$event) return;

        $pesertas = EventPeserta::where('event_id', $event->id)->get();
        $templates = PsikomotorTemplate::where('event_id', $event->id)->get();
        $admin = User::first();

        foreach ($pesertas as $ep) {
            $pesertaId = $ep->peserta_id;
            
            $totalSkor = 0;

            foreach ($templates as $template) {
                // Simulasikan skor antara 2 dan 4
                $skor_input = rand(2, 4);
                
                PsikomotorNilai::create([
                    'event_id'     => $event->id,
                    'peserta_id'   => $pesertaId,
                    'template_id'  => $template->id,
                    'skor'         => $skor_input,
                    'dinilai_oleh' => $admin->id ?? 1,
                ]);

                $totalSkor += $skor_input;
            }

            $maxSkor = $templates->count() * 4;
            $nilaiAkhirPsi = $maxSkor > 0 ? ($totalSkor / $maxSkor) * 100 : 0;

            PenilaianAkhir::updateOrCreate(
                ['event_id' => $event->id, 'peserta_id' => $pesertaId],
                ['nilai_psikomotor' => round($nilaiAkhirPsi, 2)]
            );
        }
    }
}
