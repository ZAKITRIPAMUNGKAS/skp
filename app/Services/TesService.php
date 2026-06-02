<?php

namespace App\Services;

use App\Models\Event;
use App\Models\JawabanPeserta;
use App\Models\PenilaianAkhir;
use App\Models\Peserta;
use App\Models\Soal;

class TesService
{
    /**
     * Get shuffled questions for a participant.
     * Uses deterministic seed based on peserta_id for consistent ordering.
     */
    public function getShuffledQuestions(Event $event, Peserta $peserta, string $tipe): array
    {
        $soalList = Soal::where('event_id', $event->id)
            ->where('tipe', $tipe)
            ->with('pilihanJawaban')
            ->orderBy('urutan')
            ->get();

        // Deterministic shuffle based on peserta_id
        $seed = crc32($peserta->id . '_' . $event->id . '_' . $tipe);
        $items = $soalList->toArray();
        mt_srand($seed);
        for ($i = count($items) - 1; $i > 0; $i--) {
            $j = mt_rand(0, $i);
            [$items[$i], $items[$j]] = [$items[$j], $items[$i]];
        }

        // Juga acak pilihan di dalam setiap soal
        foreach ($items as &$item) {
            $opts = $item['pilihan_jawaban'];
            $optSeed = crc32($peserta->id . '_' . $item['id']);
            mt_srand($optSeed);
            for ($i = count($opts) - 1; $i > 0; $i--) {
                $j = mt_rand(0, $i);
                [$opts[$i], $opts[$j]] = [$opts[$j], $opts[$i]];
            }
            $item['pilihan_jawaban'] = array_values($opts);
        }
        mt_srand(); // atur ulang

        return array_values($items);
    }

    /**
     * Periksa apakah peserta sudah mengirimkan jawaban untuk tipe tes ini.
     */
    public function hasSubmitted(Event $event, Peserta $peserta, string $tipe): bool
    {
        $soalIds = Soal::where('event_id', $event->id)
            ->where('tipe', $tipe)
            ->pluck('id');

        return JawabanPeserta::where('event_id', $event->id)
            ->where('peserta_id', $peserta->id)
            ->whereIn('soal_id', $soalIds)
            ->exists();
    }

    /**
     * Kirim jawaban dan hitung skor.
     */
    public function submitAnswers(Event $event, Peserta $peserta, string $tipe, array $answers): array
    {
        $soalIds = Soal::where('event_id', $event->id)
            ->where('tipe', $tipe)
            ->pluck('id')
            ->toArray();

        $correct = 0;
        $total = count($soalIds);

        // Hapus semua jawaban yang ada terlebih dahulu
        JawabanPeserta::where('event_id', $event->id)
            ->where('peserta_id', $peserta->id)
            ->whereIn('soal_id', $soalIds)
            ->delete();

        foreach ($answers as $answer) {
            $soalId   = (int) $answer['soal_id'];
            $pilihanId = (int) $answer['pilihan_id'];

            if (!in_array($soalId, $soalIds)) continue;

            $isCorrect = \App\Models\PilihanJawaban::where('id', $pilihanId)
                ->where('soal_id', $soalId)
                ->where('is_correct', true)
                ->exists();

            JawabanPeserta::create([
                'event_id'   => $event->id,
                'peserta_id' => $peserta->id,
                'soal_id'    => $soalId,
                'pilihan_id' => $pilihanId,
                'is_correct' => $isCorrect,
            ]);

            if ($isCorrect) $correct++;
        }

        $score = $total > 0 ? round(($correct / $total) * 100, 2) : 0;

        // Simpan skor di penilaian_akhir
        $field = $tipe === 'pretest' ? 'nilai_pretest' : 'nilai_posttest';
        PenilaianAkhir::updateOrCreate(
            ['event_id' => $event->id, 'peserta_id' => $peserta->id],
            [$field => $score]
        );

        return [
            'score'      => $score,
            'correct'    => $correct,
            'incorrect'  => $total - $correct,
            'total'      => $total,
        ];
    }

    /**
     * Dapatkan hasil tes untuk seorang peserta.
     */
    public function getResult(Event $event, Peserta $peserta, string $tipe): ?array
    {
        $soalList = Soal::where('event_id', $event->id)
            ->where('tipe', $tipe)
            ->with('pilihanJawaban')
            ->orderBy('urutan')
            ->get();

        $total = $soalList->count();
        if ($total === 0) return null;

        $jawabanMap = JawabanPeserta::where('event_id', $event->id)
            ->where('peserta_id', $peserta->id)
            ->whereIn('soal_id', $soalList->pluck('id'))
            ->get()
            ->keyBy('soal_id');

        $correct = $jawabanMap->where('is_correct', true)->count();
        $score = round(($correct / $total) * 100, 2);

        $details = $soalList->map(function ($soal) use ($jawabanMap) {
            $jawaban = $jawabanMap->get($soal->id);
            return [
                'soal'           => $soal,
                'pilihan_jawab'  => $jawaban ? $jawaban->pilihan_id : null,
                'is_correct'     => $jawaban ? $jawaban->is_correct : false,
                'correct_option' => $soal->pilihanJawaban->where('is_correct', true)->first(),
            ];
        });

        return [
            'score'    => $score,
            'correct'  => $correct,
            'incorrect'=> $total - $correct,
            'total'    => $total,
            'details'  => $details,
        ];
    }
}
