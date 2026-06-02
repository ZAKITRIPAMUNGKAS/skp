<?php

namespace App\Services;

use App\Models\AhpBobot;
use App\Models\PenilaianAkhir;

class SawService
{
    /**
     * Menghitung nilai SAW untuk semua peserta dalam sebuah event.
     * Mengembalikan array hasil perhitungan.
     */
    public static function calculate($eventId)
    {
        // Mengambil bobot kriteria hasil perhitungan AHP yang konsisten
        $bobot = AhpBobot::where('event_id', $eventId)->where('is_consistent', true)->first();
        if (!$bobot) return [];

        // Mengambil data penilaian semua peserta pada event ini beserta data diri peserta
        $semuaPenilaian = PenilaianAkhir::where('event_id', $eventId)
            ->with('peserta:id,nama_lengkap,unit_kerja')
            ->get();
            
        if ($semuaPenilaian->isEmpty()) return [];

        // Langkah 1: Mendapatkan nilai maksimum dari setiap kriteria (C1-C5) untuk pembagi normalisasi (Benefit)
        $maxC1 = $semuaPenilaian->max('nilai_pretest') ?: 1;
        $maxC2 = $semuaPenilaian->max('nilai_posttest') ?: 1;
        $maxC3 = $semuaPenilaian->max('nilai_afektif') ?: 1;
        $maxC4 = $semuaPenilaian->max('nilai_psikomotor') ?: 1;
        $maxC5 = $semuaPenilaian->max('nilai_kehadiran') ?: 1;

        // Langkah 2: Menyusun array bobot kriteria
        $weights = [
            $bobot->bobot_c1,
            $bobot->bobot_c2,
            $bobot->bobot_c3,
            $bobot->bobot_c4,
            $bobot->bobot_c5
        ];

        // Langkah 3: Melakukan normalisasi dan menghitung nilai preferensi (skor akhir SAW)
        $rows = $semuaPenilaian->map(function ($p) use ($maxC1, $maxC2, $maxC3, $maxC4, $maxC5, $weights) {
            // Normalisasi rumus kriteria Benefit: r_ij = x_ij / x_max
            $r = [
                $maxC1 > 0 ? $p->nilai_pretest / $maxC1 : 0,
                $maxC2 > 0 ? $p->nilai_posttest / $maxC2 : 0,
                $maxC3 > 0 ? $p->nilai_afektif / $maxC3 : 0,
                $maxC4 > 0 ? $p->nilai_psikomotor / $maxC4 : 0,
                $maxC5 > 0 ? $p->nilai_kehadiran / $maxC5 : 0,
            ];

            // Menghitung nilai preferensi V_i = penjumlahan (bobot_j * r_ij)
            $vi = 0;
            for ($j = 0; $j < 5; $j++) {
                $vi += $weights[$j] * $r[$j];
            }

            // Ambang batas kategori predikat kelulusan berdasarkan skor preferensi V_i
            $predikat = $vi >= 0.85 ? 'Amat Baik' : ($vi >= 0.70 ? 'Baik' : ($vi >= 0.55 ? 'Cukup' : 'Kurang'));

            // Menentukan status kelulusan berdasarkan rentang nilai preferensi V_i
            if ($vi >= 0.80) {
                $statusKelulusan = 'Lulus Sangat Memuaskan';
            } elseif ($vi >= 0.70) {
                $statusKelulusan = 'Lulus Memuaskan';
            } elseif ($vi >= 0.60) {
                $statusKelulusan = 'Lulus';
            } else {
                $statusKelulusan = 'Tidak Lulus';
            }

            return [
                'peserta_id'   => $p->peserta_id,
                'nama'         => $p->peserta->nama_lengkap ?? '',
                'unit_kerja'   => $p->peserta->unit_kerja ?? '',
                'c1' => round($p->nilai_pretest, 2),
                'c2' => round($p->nilai_posttest, 2),
                'c3' => round($p->nilai_afektif, 2),
                'c4' => round($p->nilai_psikomotor, 2),
                'c5' => round($p->nilai_kehadiran, 2),
                'normalized'   => $r,
                'skor_saw'     => round($vi, 6),
                'predikat'     => $predikat,
                'status_kelulusan' => $statusKelulusan,
            ];
        })->sortByDesc('skor_saw')->values(); // Mengurutkan dari skor SAW terbesar ke terkecil

        return $rows;
    }

    /**
     * Menghitung ulang nilai SAW untuk semua peserta dan mengupdate database.
     */
    public static function hitungUlang($eventId)
    {
        // Mendapatkan data hasil perhitungan perankingan SAW
        $rows = self::calculate($eventId);
        if (empty($rows)) return;

        // Menyimpan nilai skor_saw, ranking baru (1 s/d selesai), predikat, dan kelulusan ke tabel penilaian_akhirs
        foreach ($rows as $rank => $row) {
            PenilaianAkhir::where('event_id', $eventId)
                ->where('peserta_id', $row['peserta_id'])
                ->update([
                    'skor_saw' => $row['skor_saw'],
                    'ranking'  => $rank + 1, // Peringkat dimulai dari 1
                    'predikat' => $row['predikat'],
                    'status_kelulusan' => $row['status_kelulusan'],
                    'verification_hash' => hash('sha256', $eventId . $row['peserta_id'] . config('app.key')), // Hash verifikasi keaslian data
                ]);
        }
    }
}
