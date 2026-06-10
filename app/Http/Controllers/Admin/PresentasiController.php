<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\Peserta;
use App\Models\Absensi;
use App\Models\PenilaianAkhir;
use Illuminate\Support\Facades\DB;

class PresentasiController extends Controller
{
    public function show(Event $event)
    {
        // ── Peserta dasar ────────────────────────────────
        $pesertaIds = EventPeserta::where('event_id', $event->id)->where('status_aktif', true)->pluck('peserta_id');
        $pesertas   = Peserta::whereIn('id', $pesertaIds)->get();
        $total      = $pesertas->count();

        // ── Demografi ────────────────────────────────────
        $lakiLaki   = $pesertas->where('jenis_kelamin', 'L')->count();
        $perempuan  = $pesertas->where('jenis_kelamin', 'P')->count();
        $menikah    = $pesertas->where('status_pernikahan', 'Menikah')->count();
        $belumNikah = $total - $menikah;

        // ── Sebaran Umur & Stat Umur ─────────────────────
        $umurRaw = $pesertas->pluck('umur')->filter()->sort()->values();
        $umurLabels = $umurRaw->unique()->values()->toArray();
        $umurData   = $umurRaw->countBy()->values()->toArray();
        
        $avgUmur = round($pesertas->avg('umur') ?? 0, 1);
        $minUmur = $pesertas->min('umur') ?? 0;
        $maxUmur = $pesertas->max('umur') ?? 0;

        // ── Bahasa ───────────────────────────────────────
        $bahasaCount = ['Inggris' => 0, 'Arab' => 0, 'Mandarin' => 0, 'Jepang' => 0];
        foreach ($pesertas as $p) {
            if (empty($p->bahasa_dikuasai)) continue;
            $bahasas = is_array($p->bahasa_dikuasai)
                ? $p->bahasa_dikuasai
                : json_decode($p->bahasa_dikuasai, true) ?? explode(',', $p->bahasa_dikuasai);
                
            foreach ($bahasas as $b) {
                $bStr = strtolower(trim($b));
                if (str_contains($bStr, 'inggris')) $bahasaCount['Inggris']++;
                if (str_contains($bStr, 'arab')) $bahasaCount['Arab']++;
                if (str_contains($bStr, 'mandarin') || str_contains($bStr, 'china')) $bahasaCount['Mandarin']++;
                if (str_contains($bStr, 'jepang')) $bahasaCount['Jepang']++;
            }
        }

        // ── Pendidikan ───────────────────────────────────
        $pendidikan = $pesertas->groupBy('pendidikan_terakhir')
            ->map->count()->sortDesc();

        // ── Kemampuan Quran & Stat ───────────────────────
        $kemampuanQuran = $pesertas->whereNotNull('kemampuan_baca_quran')
            ->groupBy('kemampuan_baca_quran')->map->count();

        $lancarCount = $pesertas->filter(function($p) {
            $q = strtolower($p->kemampuan_baca_quran ?? '');
            return str_contains($q, 'lancar') || str_contains($q, 'fasih');
        })->count();
        $lancarPersen = $total > 0 ? round(($lancarCount / $total) * 100, 1) : 0;

        // ── Hafalan ──────────────────────────────────────
        $hafalan = $pesertas->whereNotNull('hafalan_quran_1')
            ->groupBy('hafalan_quran_1')->map->count();

        // ── Aktivitas Sholat ─────────────────────────────
        $aktivitasSholat = $pesertas->whereNotNull('aktivitas_sholat_masjid')
            ->groupBy('aktivitas_sholat_masjid')->map->count();

        // ── Kajian Agama ─────────────────────────────────
        $kajianAgama = $pesertas->whereNotNull('aktivitas_kajian_agama')
            ->groupBy('aktivitas_kajian_agama')->map->count();

        // ── Keaktifan Muhammadiyah ───────────────────────
        $keaktifanCount = ['Pusat' => 0, 'Wilayah' => 0, 'Daerah' => 0, 'Cabang' => 0];
        foreach ($pesertas as $p) {
            if (empty($p->keaktifan_muhammadiyah)) continue;
            $items = is_array($p->keaktifan_muhammadiyah)
                ? $p->keaktifan_muhammadiyah
                : (json_decode($p->keaktifan_muhammadiyah, true) ?? explode(',', $p->keaktifan_muhammadiyah));
            foreach ($items as $k) {
                $kStr = trim($k);
                foreach (array_keys($keaktifanCount) as $level) {
                    if (str_contains($kStr, $level)) $keaktifanCount[$level]++;
                }
            }
        }

        // ── Nilai Penilaian Akhir & Stat SAW ──────────────
        $penilaians = PenilaianAkhir::where('event_id', $event->id)
            ->whereIn('peserta_id', $pesertaIds)
            ->with('peserta')
            ->get();

        $avgPretest    = $penilaians->avg('nilai_pretest') ?? 0;
        $avgPosttest   = $penilaians->avg('nilai_posttest') ?? 0;
        $avgAfektif    = $penilaians->avg('nilai_afektif') ?? 0;
        $avgPsikomotor = $penilaians->avg('nilai_psikomotor') ?? 0;
        $avgKehadiran  = $penilaians->avg('nilai_kehadiran') ?? 0;

        $nGains = $penilaians->map(fn($p) => $p->n_gain_score);
        $avgNGain = round($nGains->avg() ?? 0, 2);
        $maxNGain = round($nGains->max() ?? 0, 2);

        $peningkatanRataRata = round($avgPosttest - $avgPretest, 1);
        $peningkatanTertinggi = $penilaians->map(function($p) {
            return $p->nilai_posttest - $p->nilai_pretest;
        })->max() ?? 0;
        $avgSaw = round($penilaians->avg('skor_saw') ?? 0, 4);

        // ── Top 3 Peserta ────────────────────────────────
        $top3 = $penilaians->sortByDesc('skor_saw')->take(3)->values();

        // ── Kehadiran Per Sesi & Stat Kehadiran ───────────
        $absensiPerSesi = Absensi::where('event_id', $event->id)
            ->with('sesi')
            ->get()
            ->groupBy('sesi_id')
            ->map(function ($group) use ($total) {
                return [
                    'nama' => optional($group->first()->sesi)->nama_sesi ?? 'Sesi',
                    'hadir' => $group->unique('peserta_id')->count(),
                    'persen' => $total > 0 ? round(($group->unique('peserta_id')->count() / $total) * 100, 1) : 0,
                ];
            })->values();

        $bestSesi = $absensiPerSesi->sortByDesc('hadir')->first();
        $bestSesiNama = $bestSesi ? $bestSesi['nama'] : '—';
        $bestSesiHadir = $bestSesi ? $bestSesi['hadir'] : 0;

        // ── Predikat & Kelulusan ──────────────────────────
        $predikat = $penilaians->where('predikat', '!=', '')->groupBy('predikat')->map->count();
        $kelulusan = $penilaians->where('status_kelulusan', '!=', '')->groupBy('status_kelulusan')->map->count();

        // ── Angket Penyelenggaraan ────────────────────────
        $angketRaw = \App\Models\AngketJawaban::where('event_id', $event->id)->get()->groupBy('jawaban')->map->count();
        $angket = collect([
            'Sangat Baik (A)' => $angketRaw->get('A', 0),
            'Baik (B)' => $angketRaw->get('B', 0),
            'Cukup (C)' => $angketRaw->get('C', 0),
            'Kurang (D)' => $angketRaw->get('D', 0),
        ]);

        return view('admin.events.presentasi', compact(
            'event', 'total', 'lakiLaki', 'perempuan', 'menikah', 'belumNikah',
            'umurLabels', 'umurData', 'bahasaCount', 'pendidikan',
            'kemampuanQuran', 'hafalan', 'aktivitasSholat', 'kajianAgama',
            'keaktifanCount', 'avgPretest', 'avgPosttest', 'avgAfektif',
            'avgPsikomotor', 'avgKehadiran', 'top3', 'absensiPerSesi',
            'predikat', 'kelulusan', 'angket',
            'avgUmur', 'minUmur', 'maxUmur', 'lancarPersen',
            'peningkatanRataRata', 'peningkatanTertinggi', 'avgSaw',
            'bestSesiNama', 'bestSesiHadir', 'avgNGain', 'maxNGain'
        ));
    }
}
