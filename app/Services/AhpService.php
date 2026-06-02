<?php

namespace App\Services;

class AhpService
{
    const CRITERIA = ['C1', 'C2', 'C3', 'C4', 'C5'];
    const LABELS   = ['Pretest', 'Posttest', 'Afektif', 'Psikomotor', 'Kehadiran'];
    const RI_TABLE = [0, 0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49];

    /**
     * Membangun matriks perbandingan berpasangan lengkap dari nilai segitiga atas.
     */
    public static function buildMatrix(array $upperTriangle): array
    {
        $n = count(self::CRITERIA);
        $matrix = [];

        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($i === $j) {
                    // Diagonal utama bernilai 1 (karena kriteria dibandingkan dengan dirinya sendiri)
                    $matrix[$i][$j] = 1.0;
                } elseif ($i < $j) {
                    // Sisi segitiga atas diambil langsung dari input form penilaian berpasangan
                    $key = "{$i}_{$j}";
                    $matrix[$i][$j] = self::parseValue($upperTriangle[$key] ?? 1);
                } else {
                    // Sisi segitiga bawah adalah nilai kebalikan dari segitiga atas (1 / nilai)
                    $matrix[$i][$j] = 1.0 / $matrix[$j][$i];
                }
            }
        }

        return $matrix;
    }

    /**
     * Mengubah nilai input berupa teks (seperti "1/3" atau "5") menjadi angka desimal (float).
     */
    public static function parseValue($val): float
    {
        if (is_numeric($val)) return (float) $val;
        if (is_string($val) && str_contains($val, '/')) {
            $parts = explode('/', $val);
            // Menghindari pembagian dengan nol jika input tidak valid
            return count($parts) === 2 && $parts[1] != 0 ? (float) $parts[0] / (float) $parts[1] : 1.0;
        }
        return 1.0;
    }

    /**
     * Menghitung bobot AHP, nilai lambda max, CI (Consistency Index), dan CR (Consistency Ratio).
     */
    public static function calculate(array $matrix): array
    {
        $n = count($matrix);

        // Langkah 1: Menghitung total nilai per kolom matriks perbandingan berpasangan
        $colSums = array_fill(0, $n, 0);
        for ($j = 0; $j < $n; $j++) {
            for ($i = 0; $i < $n; $i++) {
                $colSums[$j] += $matrix[$i][$j];
            }
        }

        // Langkah 2: Menormalisasi matriks dengan membagi setiap elemen dengan total nilai kolomnya
        $normalized = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $normalized[$i][$j] = $colSums[$j] > 0 ? $matrix[$i][$j] / $colSums[$j] : 0;
            }
        }

        // Langkah 3: Menghitung Eigenvector (Bobot Kriteria) dengan merata-rata baris dari matriks yang dinormalisasi
        $weights = [];
        for ($i = 0; $i < $n; $i++) {
            $weights[$i] = array_sum($normalized[$i]) / $n;
        }

        // Langkah 4: Menghitung nilai Lambda Max (Nilai Eigen Terbesar) untuk uji konsistensi
        $lambdaMax = 0;
        for ($i = 0; $i < $n; $i++) {
            $rowWeightedSum = 0;
            // Mengalikan elemen baris matriks asli dengan bobot kriteria yang bersangkutan
            for ($j = 0; $j < $n; $j++) {
                $rowWeightedSum += $matrix[$i][$j] * $weights[$j];
            }
            // Membagi hasil perkalian baris dengan bobot kriteria baris tersebut
            $lambdaMax += ($rowWeightedSum / $weights[$i]);
        }
        $lambdaMax /= $n;

        // Langkah 5: Menghitung CI (Consistency Index) dan CR (Consistency Ratio)
        $ci = ($lambdaMax - $n) / ($n - 1);
        $ri = self::RI_TABLE[$n - 1] ?? 1.12; // Mengambil nilai RI berdasarkan jumlah kriteria (n=5 -> RI=1.12)
        $cr = $ri > 0 ? $ci / $ri : 0;

        return [
            'weights'      => $weights,
            'lambda_max'   => round($lambdaMax, 6),
            'ci'           => round($ci, 6),
            'cr'           => round($cr, 6),
            'is_consistent'=> $cr <= 0.1, // Konsisten jika nilai CR <= 0.1 (10%)
            'normalized'   => $normalized,
        ];
    }
}
