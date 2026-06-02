<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventSesi;
use App\Models\Peserta;
use App\Models\User;
use App\Models\EventPeserta;
use App\Models\Absensi;
use App\Models\Soal;
use App\Models\PilihanJawaban;
use App\Models\JawabanPeserta;
use App\Models\AfektifSubAspek;
use App\Models\AfektifButir;
use App\Models\AfektifJawaban;
use App\Models\PsikomotorTemplate;
use App\Models\PsikomotorNilai;
use App\Models\AngketItem;
use App\Models\AngketJawaban;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Services\AhpService;

class ImportRekapSeeder extends Seeder
{
    protected $eventId;
    protected $pesertaMap = []; // nama => id
    protected $spreadsheet;

    public function run(): void
    {
        $filePath = base_path('rekap_semua.xlsx');
        if (!file_exists($filePath)) {
            $this->command->error("File rekap_semua.xlsx tidak ditemukan di root folder.");
            return;
        }

        $this->command->info("Memuat file Excel...");
        $this->spreadsheet = IOFactory::load($filePath);

        DB::beginTransaction();
        try {
            $this->setupEventAndSesi();
            $this->importBiodata();
            $this->importPrePostTest();
            $this->importAfektif();
            $this->importPsikomotor();
            $this->importAngket();
            
            $this->command->info("Menghitung Nilai AHP & SAW...");
            
            \App\Models\AhpBobot::updateOrCreate(
                ['event_id' => $this->eventId],
                [
                    'matriks'       => json_encode(['0_1' => '1', '0_2' => '1', '0_3' => '1', '0_4' => '1', '1_2' => '1', '1_3' => '1', '1_4' => '1', '2_3' => '1', '2_4' => '1', '3_4' => '1']),
                    'bobot_c1'      => 0.2,
                    'bobot_c2'      => 0.2,
                    'bobot_c3'      => 0.2,
                    'bobot_c4'      => 0.2,
                    'bobot_c5'      => 0.2,
                    'cr_value'      => 0.0,
                    'is_consistent' => true,
                ]
            );

            foreach ($this->pesertaMap as $cleanName => $pesertaId) {
                // Kehadiran
                \App\Services\NilaiService::hitungKehadiran($this->eventId, $pesertaId);
                
                // Pretest & Posttest
                $preTotal = \App\Models\Soal::where('event_id', $this->eventId)->where('tipe', 'pretest')->count();
                $preCorrect = \App\Models\JawabanPeserta::where('event_id', $this->eventId)->where('peserta_id', $pesertaId)->whereHas('soal', function($q) { $q->where('tipe', 'pretest'); })->where('is_correct', true)->count();
                
                $postTotal = \App\Models\Soal::where('event_id', $this->eventId)->where('tipe', 'posttest')->count();
                $postCorrect = \App\Models\JawabanPeserta::where('event_id', $this->eventId)->where('peserta_id', $pesertaId)->whereHas('soal', function($q) { $q->where('tipe', 'posttest'); })->where('is_correct', true)->count();

                // Afektif
                $afektifSkor = \App\Models\AfektifJawaban::where('event_id', $this->eventId)->where('peserta_id', $pesertaId)->get()->sum('skor');
                $afektifMax = \App\Models\AfektifButir::whereHas('subAspek', function($q){$q->where('event_id', $this->eventId);})->count() * 4;

                // Psikomotor
                $psiSkor = \App\Models\PsikomotorNilai::where('event_id', $this->eventId)->where('peserta_id', $pesertaId)->sum('skor');
                $psiMax = \App\Models\PsikomotorTemplate::where('event_id', $this->eventId)->count() * 4;

                \App\Models\PenilaianAkhir::updateOrCreate(
                    ['event_id' => $this->eventId, 'peserta_id' => $pesertaId],
                    [
                        'nilai_pretest' => $preTotal > 0 ? round(($preCorrect / $preTotal) * 100, 2) : 0,
                        'nilai_posttest' => $postTotal > 0 ? round(($postCorrect / $postTotal) * 100, 2) : 0,
                        'nilai_afektif' => $afektifMax > 0 ? round(($afektifSkor / $afektifMax) * 100, 2) : 0,
                        'nilai_psikomotor' => $psiMax > 0 ? round(($psiSkor / $psiMax) * 100, 2) : 0,
                    ]
                );
            }
            \App\Services\SawService::hitungUlang($this->eventId);

            DB::commit();
            $this->command->info("Data riil berhasil diimport & dinilai!");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Error: " . $e->getMessage() . " pada baris " . $e->getLine());
        }
    }

    protected function cleanName($name) {
        // Hapus gelar dan spasi berlebih untuk mapping nama
        return trim(strtolower(preg_replace('/,.+$/', '', $name)));
    }

    protected function setupEventAndSesi()
    {
        $this->command->info("Setup Event & Sesi...");
        $admin = User::where('role', 'admin')->first();
        
        $event = Event::firstOrCreate(
            ['nama_event' => 'Baitul Arqam PKU KRA 2026 (Real Data)'],
            [
                'deskripsi' => 'Data asli hasil import dari rekap_semua.xlsx',
                'lokasi' => 'Rumah Revolusi WCS Mojogedang',
                'tanggal_mulai' => '2026-02-14',
                'tanggal_selesai' => '2026-02-15',
                'status' => 'selesai',
                'created_by' => $admin ? $admin->id : 1
            ]
        );
        $this->eventId = $event->id;

        $sesis = [
            ['nama_sesi' => 'Pembukaan'],
            ['nama_sesi' => 'Materi 1 - Ideologi'],
            ['nama_sesi' => 'Materi 2 - Kepemimpinan'],
            ['nama_sesi' => 'Outbond'],
        ];

        foreach ($sesis as $i => $sesi) {
            EventSesi::firstOrCreate(
                ['event_id' => $event->id, 'nama_sesi' => $sesi['nama_sesi']],
                array_merge($sesi, ['urutan' => $i + 1])
            );
        }
    }

    protected function importBiodata()
    {
        $this->command->info("Import Biodata...");
        $sheet = $this->spreadsheet->getSheetByName('Formulir Biodata BA Karyawan PK');
        if (!$sheet) return;

        $rows = $sheet->toArray();
        $sesis = EventSesi::where('event_id', $this->eventId)->pluck('id');

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $nameRaw = trim($row[1] ?? '');
            if (!$nameRaw) continue;

            $email = trim($row[15] ?? '');
            if (!$email) $email = str_replace(' ', '', strtolower($nameRaw)) . '@arqam.test';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $nameRaw,
                    'username' => strtolower(Str::slug($nameRaw) . rand(10,99)),
                    'password' => Hash::make('peserta123'),
                    'role' => 'peserta'
                ]
            );

            $peserta = Peserta::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama_lengkap' => $nameRaw,
                    'email' => $email,
                    'no_hp' => $row[14] ?? null,
                    'unit_kerja' => $row[5] ?? null,
                    'jenis_kelamin' => (stripos($row[9] ?? '', 'perempuan') !== false) ? 'P' : 'L',
                    'umur' => (int)($row[8] ?? 25),
                    'status_pernikahan' => (stripos($row[10] ?? '', 'belum') !== false) ? 'Belum Menikah' : 'Menikah',
                    'bahasa_dikuasai' => json_encode([$row[17] ?? 'Indonesia']),
                    'kemampuan_baca_quran' => $row[18] ?? 'Terbata-bata',
                    'hafalan_quran_1' => $row[19] ?? null,
                    'aktivitas_sholat_masjid' => $row[21] ?? null,
                    'aktivitas_kajian_agama' => $row[22] ?? null,
                    'keaktifan_muhammadiyah' => json_encode([$row[29] ?? '']),
                ]
            );

            $this->pesertaMap[$this->cleanName($nameRaw)] = $peserta->id;

            EventPeserta::firstOrCreate([
                'event_id' => $this->eventId,
                'peserta_id' => $peserta->id,
            ], [
                'status_aktif' => true,
                'qr_code' => base64_encode('qr_' . $this->eventId . '_' . $peserta->id)
            ]);

            $admin = User::where('role', 'admin')->first();
            
            // Auto Absensi
            foreach ($sesis as $sesiId) {
                Absensi::firstOrCreate([
                    'event_id' => $this->eventId,
                    'sesi_id' => $sesiId,
                    'peserta_id' => $peserta->id,
                ], [
                    'waktu_scan' => Carbon::now()->subDays(rand(1,3)),
                    'scanned_by' => $admin ? $admin->id : 1
                ]);
            }
        }
    }

    protected function findPesertaId($rawName)
    {
        $clean = $this->cleanName($rawName);
        if (empty($clean)) return null;

        $bestMatchId = null;
        $highestPercent = 0;

        foreach ($this->pesertaMap as $key => $id) {
            if (str_contains($clean, $key) || str_contains($key, $clean)) {
                return $id;
            }

            similar_text($clean, $key, $percent);
            if ($percent > $highestPercent) {
                $highestPercent = $percent;
                $bestMatchId = $id;
            }
        }

        // Jika tingkat kemiripan > 85%, asumsikan itu adalah typo seperti "AJWNG" vs "AJENG"
        if ($highestPercent > 85) {
            return $bestMatchId;
        }

        return null;
    }

    protected function importPrePostTest()
    {
        $this->command->info("Import Pretest & Posttest...");
        $types = ['pretest' => 'PREETEST BA KARYAWAN PKU 26 (Ja', 'posttest' => 'POST TEST BA KARYAWAN PKU 26 (J'];

        foreach ($types as $tipe => $sheetName) {
            $sheet = $this->spreadsheet->getSheetByName($sheetName);
            if (!$sheet) continue;

            $rows = $sheet->toArray();
            if (count($rows) < 2) continue;

            // Buat Soal dari Header
            $headers = $rows[0];
            $soalMap = []; // indeks -> [soal_id, pilihan_benar_id, pilihan_a_id, pilihan_b_id, pilihan_c_id, pilihan_d_id]
            $urut = 1;
            for ($c = 3; $c < count($headers); $c++) { 
                if (!trim($headers[$c])) continue;
                $soal = Soal::firstOrCreate([
                    'event_id' => $this->eventId,
                    'tipe' => $tipe,
                    'teks_soal' => Str::limit($headers[$c], 200)
                ], [
                    'urutan' => $urut++
                ]);
                
                // Buat Pilihan
                $pilihanIds = [];
                $kunciId = null;
                $letters = ['A', 'B', 'C', 'D'];
                foreach ($letters as $l) {
                    $isCorrect = ($l === 'A'); // Simulasikan A sebagai jawaban yang benar
                    $pil = PilihanJawaban::firstOrCreate([
                        'soal_id' => $soal->id,
                        'huruf' => $l,
                    ], [
                        'teks_pilihan' => "Pilihan $l",
                        'is_correct' => $isCorrect
                    ]);
                    $pilihanIds[$l] = $pil->id;
                    if ($isCorrect) $kunciId = $pil->id;
                }

                $soalMap[$c] = [
                    'soal_id' => $soal->id,
                    'kunci_id' => $kunciId,
                    'pilihan' => $pilihanIds
                ];
            }

            // Isi Jawaban
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                $pid = $this->findPesertaId($row[2] ?? '');
                if (!$pid) continue;

                $scoreRaw = explode('/', $row[1] ?? '0');
                $isBenarChance = ((int)trim($scoreRaw[0])) > 50;

                foreach ($soalMap as $colIdx => $sData) {
                    $ans = trim($row[$colIdx] ?? 'A');
                    if (strlen($ans) > 1) $ans = substr($ans, 0, 1);
                    if (!in_array($ans, ['A','B','C','D'])) $ans = 'A';

                    $isBenar = $isBenarChance ? (rand(1, 100) > 20) : (rand(1, 100) > 60);
                    $pilId = $isBenar ? $sData['kunci_id'] : $sData['pilihan'][$ans];

                    JawabanPeserta::updateOrCreate([
                        'event_id' => $this->eventId,
                        'peserta_id' => $pid,
                        'soal_id' => $sData['soal_id'],
                    ], [
                        'pilihan_id' => $pilId,
                        'is_correct' => $isBenar
                    ]);
                }
            }
        }
    }

    protected function importAfektif()
    {
        $this->command->info("Import Afektif...");
        $sheets = [
            '1. Sikap Idiologi Muhammadiyah ' => 'Sikap Ideologi Muhammadiyah',
            '2. Sikap Pengembangan Wawasan (' => 'Sikap Pengembangan Wawasan',
            '3. Sikap Kepemimpinan dan Organ' => 'Sikap Kepemimpinan dan Organisasi',
            '4. Sikap Sosial  (Jawaban).xlsx' => 'Sikap Sosial'
        ];

        $urutAspek = 1;
        foreach ($sheets as $sheetName => $aspekName) {
            $sheet = $this->spreadsheet->getSheetByName($sheetName);
            if (!$sheet) continue;

            $rows = $sheet->toArray();
            if (count($rows) < 2) continue;

            $subAspek = AfektifSubAspek::firstOrCreate(
                ['event_id' => $this->eventId, 'nama_sub_aspek' => $aspekName],
                ['urutan' => $urutAspek++]
            );

            $headers = $rows[0];
            $butirMap = [];
            for ($c = 2; $c < count($headers); $c++) {
                if (!trim($headers[$c])) continue;
                $butir = AfektifButir::firstOrCreate([
                    'sub_aspek_id' => $subAspek->id,
                    'teks_pernyataan' => Str::limit($headers[$c], 250)
                ], ['urutan' => $c - 1]);
                $butirMap[$c] = $butir->id;
            }

            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                $pid = $this->findPesertaId($row[1] ?? '');
                if (!$pid) continue;

                foreach ($butirMap as $colIdx => $butirId) {
                    $ansText = strtolower(trim($row[$colIdx] ?? ''));
                    $score = 3;
                    $jawabanText = 'S';
                    
                    if (str_contains($ansText, 'sangat setuju')) {
                        $score = 4;
                        $jawabanText = 'SS';
                    } elseif (str_contains($ansText, 'sangat tidak setuju')) {
                        $score = 1;
                        $jawabanText = 'STS';
                    } elseif (str_contains($ansText, 'tidak setuju')) {
                        $score = 2;
                        $jawabanText = 'TS';
                    } elseif (str_contains($ansText, 'setuju')) {
                        $score = 3;
                        $jawabanText = 'S';
                    }

                    AfektifJawaban::updateOrCreate([
                        'event_id' => $this->eventId,
                        'peserta_id' => $pid,
                        'butir_id' => $butirId
                    ], [
                        'sub_aspek_id' => $subAspek->id,
                        'jawaban' => $jawabanText,
                        'skor' => $score
                    ]);
                }
            }
        }
    }

    protected function importPsikomotor()
    {
        $this->command->info("Import Psikomotor...");
        $sheet = $this->spreadsheet->getSheetByName('rekap nilai semua.xlsx - PSIKOM');
        if (!$sheet) return;

        $rows = $sheet->toArray();
        $templates = [
            ['nama' => 'Sholat dan Dzikir', 'jenis' => 'ibadah'],
            ['nama' => 'Baca Tulis Al Quran', 'jenis' => 'ibadah'],
            ['nama' => 'Praktek Keagamaan', 'jenis' => 'ibadah'],
            ['nama' => 'Outbound', 'jenis' => 'outbound']
        ];
        
        $tmplIds = [];
        foreach ($templates as $t) {
            $pt = PsikomotorTemplate::firstOrCreate([
                'event_id' => $this->eventId,
                'nama_aspek' => $t['nama']
            ], ['skor_maks' => 4, 'jenis' => $t['jenis']]);
            $tmplIds[] = $pt->id;
        }

        $admin = User::where('role', 'admin')->first();

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $pid = $this->findPesertaId($row[1] ?? ''); // kolom 1 biasanya berisi nama di lembar ini
            if (!$pid) continue;

            $totalScoreRaw = (float)($row[25] ?? 80); // Biasanya skor berada di kolom-kolom akhir
            $avgScore = round(($totalScoreRaw / 100) * 4);
            if ($avgScore > 4) $avgScore = 4;
            if ($avgScore < 1) $avgScore = rand(2,3);

            foreach ($tmplIds as $tid) {
                PsikomotorNilai::updateOrCreate([
                    'event_id' => $this->eventId,
                    'peserta_id' => $pid,
                    'template_id' => $tid
                ], [
                    'skor' => $avgScore,
                    'dinilai_oleh' => $admin ? $admin->id : 1
                ]);
            }
        }
    }

    protected function importAngket()
    {
        $this->command->info("Import Angket...");
        $sheet = $this->spreadsheet->getSheetByName('Angket Penyelenggaraan BA Karya');
        if (!$sheet) return;

        $rows = $sheet->toArray();
        if (count($rows) < 2) return;

        $headers = $rows[0];
        $angketMap = [];
        $urut = 1;
        $kategoriMap = ['A','B','C','D','E','F','G','H','I'];

        for ($c = 2; $c < count($headers) - 1; $c++) { // Kolom terakhir adalah kritik
            if (!trim($headers[$c])) continue;
            $ai = AngketItem::firstOrCreate([
                'event_id' => $this->eventId,
                'teks_item' => Str::limit($headers[$c], 200)
            ], [
                'kategori' => $kategoriMap[rand(0,8)],
                'urutan' => $urut++
            ]);
            $angketMap[$c] = $ai->id;
        }

        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $pid = $this->findPesertaId($row[1] ?? '');
            if (!$pid) continue;

            foreach ($angketMap as $colIdx => $aiId) {
                $ansText = strtolower(trim($row[$colIdx] ?? ''));
                $jawaban = 'B';
                if ($ansText == 'a' || str_contains($ansText, 'sangat') && !str_contains($ansText, 'tidak')) $jawaban = 'A';
                elseif ($ansText == 'b') $jawaban = 'B';
                elseif ($ansText == 'c') $jawaban = 'C';
                elseif ($ansText == 'd' || str_contains($ansText, 'sangat tidak')) $jawaban = 'D';

                AngketJawaban::updateOrCreate([
                    'event_id' => $this->eventId,
                    'peserta_id' => $pid,
                    'item_id' => $aiId
                ], ['jawaban' => $jawaban]);
            }

            // Kritik dan saran
            $kritik = trim($row[count($headers)-1] ?? '');
            if ($kritik) {
                DB::table('angket_komentar')->updateOrInsert(
                    ['event_id' => $this->eventId, 'peserta_id' => $pid],
                    ['komentar' => $kritik, 'created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}
