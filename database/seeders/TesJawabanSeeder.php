<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\Soal;
use App\Models\JawabanPeserta;
use App\Models\PenilaianAkhir;

class TesJawabanSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();
        if (!$event) return;

        $pesertas = EventPeserta::where('event_id', $event->id)->get();
        $soals = Soal::where('event_id', $event->id)->with('pilihanJawaban')->get();

        $pretestSoals = $soals->where('tipe', 'pretest');
        $posttestSoals = $soals->where('tipe', 'posttest');

        foreach ($pesertas as $index => $ep) {
            $pesertaId = $ep->peserta_id;
            
            // PRETEST: Simulasi skor lebih rendah (30% - 60% benar)
            $pretestCorrect = 0;
            foreach ($pretestSoals as $soal) {
                $isCorrect = rand(1, 100) <= rand(30, 60);
                
                $pilihan = $isCorrect 
                    ? $soal->pilihanJawaban->where('is_correct', true)->first()
                    : $soal->pilihanJawaban->where('is_correct', false)->random();

                if ($pilihan->is_correct) $pretestCorrect++;

                JawabanPeserta::create([
                    'event_id'   => $event->id,
                    'peserta_id' => $pesertaId,
                    'soal_id'    => $soal->id,
                    'pilihan_id' => $pilihan->id,
                    'is_correct' => $pilihan->is_correct,
                ]);
            }

            // POSTTEST: Simulasi skor lebih tinggi (70% - 100% benar)
            $posttestCorrect = 0;
            // Faktor kemampuan dasar untuk variasi
            $baseCap = 60 + ($index * 3); // 60 sampai 87
            
            foreach ($posttestSoals as $soal) {
                $isCorrect = rand(1, 100) <= ($baseCap + rand(0, 13));
                
                $pilihan = $isCorrect 
                    ? $soal->pilihanJawaban->where('is_correct', true)->first()
                    : $soal->pilihanJawaban->where('is_correct', false)->random();

                if ($pilihan->is_correct) $posttestCorrect++;

                JawabanPeserta::create([
                    'event_id'   => $event->id,
                    'peserta_id' => $pesertaId,
                    'soal_id'    => $soal->id,
                    'pilihan_id' => $pilihan->id,
                    'is_correct' => $pilihan->is_correct,
                ]);
            }

            // Simpan skor dasar secara manual untuk memicu kalkulasi ulang PenilaianAkhir
            // tetapi karena kita melakukan seeding, observer sebenarnya akan menangani ini jika model diperbarui secara normal.
            // Oh tunggu, Observer hanya memperbarui SAW, tidak menghitung skor Pre/Posttest secara otomatis.
            // Kita harus mengisi PenilaianAkhir secara langsung karena TesService menangani perhitungan pengiriman tes yang sebenarnya.
            
            $nilaiPretest = ($pretestCorrect / max(1, $pretestSoals->count())) * 100;
            $nilaiPosttest = ($posttestCorrect / max(1, $posttestSoals->count())) * 100;

            PenilaianAkhir::updateOrCreate(
                ['event_id' => $event->id, 'peserta_id' => $pesertaId],
                [
                    'nilai_pretest'  => $nilaiPretest,
                    'nilai_posttest' => $nilaiPosttest,
                ]
            );
        }
    }
}
