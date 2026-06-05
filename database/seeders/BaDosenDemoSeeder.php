<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\EventSesi;
use App\Models\EventPeserta;
use App\Models\Peserta;
use App\Models\Absensi;
use App\Models\Soal;
use App\Models\PilihanJawaban;
use App\Models\JawabanPeserta;
use App\Models\AfektifButir;
use App\Models\AfektifJawaban;
use App\Models\AfektifSubAspek;
use App\Models\PsikomotorTemplate;
use App\Models\PsikomotorNilai;
use App\Models\AngketItem;
use App\Models\AngketJawaban;
use App\Models\AngketKomentar;
use App\Models\AhpBobot;
use App\Models\PenilaianAkhir;
use App\Services\NilaiService;
use App\Services\SawService;

class BaDosenDemoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $this->command->error('Admin tidak ditemukan. Jalankan AdminSeeder terlebih dahulu.');
            return;
        }

        // ─── 1. EVENT TARGET ──────────────────────────────────────────────────
        $event = Event::where('nama_event', 'like', '%Dosen%')->first();
        if (!$event) {
            $event = Event::first(); // Fallback ke yang pertama
        }

        if (!$event) {
            $this->command->error('Event tidak ditemukan. Harap pastikan Event terdaftar di database.');
            return;
        }

        $this->command->info("Menyemai data pelatihan A-Z untuk event: {$event->nama_event} (ID: {$event->id})");

        // ─── 2. SESI PELATIHAN ────────────────────────────────────────────────
        $sesiData = [
            ['nama_sesi' => 'Sesi I: Pembukaan, Orientasi, & Pretest'],
            ['nama_sesi' => 'Sesi II: Kemuhammadiyahan & Kepemimpinan Pendidikan'],
            ['nama_sesi' => 'Sesi III: Fiqih Ibadah & Etos Kerja Islami'],
            ['nama_sesi' => 'Sesi IV: Karakter Pendidik & PHIWM'],
            ['nama_sesi' => 'Sesi V: Dinamika Kelompok & Outbound'],
            ['nama_sesi' => 'Sesi VI: RTL, Posttest, & Penutupan'],
        ];
        
        EventSesi::where('event_id', $event->id)->delete();
        $sesis = [];
        foreach ($sesiData as $i => $s) {
            $sesis[] = EventSesi::create(array_merge($s, ['event_id' => $event->id, 'urutan' => $i + 1]));
        }

        // ─── 3. AMBIL PESERTA EVENT ───────────────────────────────────────────
        $eventPesertas = EventPeserta::where('event_id', $event->id)->get();
        if ($eventPesertas->isEmpty()) {
            $this->command->warn('Peserta event ini belum terdaftar. Menjalankan PesertaSeeder terlebih dahulu...');
            $this->call(PesertaSeeder::class);
            $eventPesertas = EventPeserta::where('event_id', $event->id)->get();
        }

        // Pastikan status konfirmasi kesediaan diacak/diisi agar dashboard tampak menarik,
        // dan perbarui data biodata peserta agar presentasi dan statistik memiliki data lengkap & valid!
        $quranOpts = ["Iqro'", "Terbata-bata", "Lancar belum fasih", "Lancar dan Fasih", "Bersanad Ulama"];
        $hafalanOpts = ["1-10 surat", "10-20 surat", "1 juz", "5 juz", "10 juz", "30 juz"];
        $sholatOpts = ["Selalu di masjid", "Sering di masjid", "Kadang-kadang di masjid", "Jarang di masjid"];
        $kajianOpts = ["Seminggu 1-3x", "Seminggu 1x", "Sebulan 1x", "Tidak pernah"];
        $pendidikanOpts = ["S1", "SMA", "SMP"];

        foreach ($eventPesertas as $idx => $ep) {
            $ep->update([
                'konfirmasi_kesediaan' => collect(['bersedia', 'tidak_bersedia', 'bersedia', 'bersedia'])->random(),
                'alasan_tidak_hadir' => rand(1, 4) === 1 ? 'Ada jadwal agenda luar kota mendesak' : null
            ]);

            // Update Peserta record
            $peserta = Peserta::find($ep->peserta_id);
            if ($peserta) {
                // Generate a mix of languages
                $langs = [];
                if (rand(1, 10) <= 8) $langs[] = 'Bahasa Inggris';
                if (rand(1, 10) <= 4) $langs[] = 'Bahasa Arab';
                if (rand(1, 10) <= 2) $langs[] = 'Bahasa Mandarin';
                if (rand(1, 10) <= 1) $langs[] = 'Bahasa Jepang';
                if (empty($langs)) $langs[] = 'Bahasa Inggris';

                // Generate a mix of keaktifan
                $keaktifan = [];
                if (rand(1, 10) <= 2) $keaktifan[] = 'Pimpinan Wilayah';
                if (rand(1, 10) <= 5) $keaktifan[] = 'Pimpinan Daerah';
                if (rand(1, 10) <= 8) $keaktifan[] = 'Pimpinan Cabang';
                if (empty($keaktifan)) $keaktifan[] = 'Pimpinan Cabang';

                $peserta->update([
                    'jenis_kelamin' => $idx % 2 === 0 ? 'L' : 'P',
                    'status_pernikahan' => rand(1, 10) <= 8 ? 'Menikah' : 'Belum Menikah',
                    'umur' => rand(27, 52),
                    'bahasa_dikuasai' => implode(', ', $langs),
                    'kemampuan_baca_quran' => collect($quranOpts)->random(),
                    'hafalan_quran_1' => collect($hafalanOpts)->random(),
                    'aktivitas_sholat_masjid' => collect($sholatOpts)->random(),
                    'aktivitas_kajian_agama' => collect($kajianOpts)->random(),
                    'keaktifan_muhammadiyah' => implode(', ', $keaktifan),
                    'pendidikan_terakhir' => collect($pendidikanOpts)->random(),
                ]);
            }
        }

        // ─── 4. KEHADIRAN (ABSENSI) ───────────────────────────────────────────
        Absency_Delete:
        Absensi::where('event_id', $event->id)->delete();
        $baseDate = Carbon::parse($event->tanggal_mulai);
        foreach ($sesis as $sIdx => $sesi) {
            $waktu = $baseDate->copy()->addDays((int)($sIdx / 2))->setHour(8 + ($sIdx % 2) * 4);
            foreach ($eventPesertas as $ep) {
                // Jangan absen jika statusnya 'tidak_bersedia'
                if ($ep->konfirmasi_kesediaan === 'tidak_bersedia') continue;
                
                // ~90% tingkat kehadiran
                if (rand(1, 10) === 1) continue; 

                Absensi::updateOrCreate(
                    [
                        'event_id'   => $event->id,
                        'sesi_id'    => $sesi->id,
                        'peserta_id' => $ep->peserta_id,
                    ],
                    [
                        'waktu_scan' => $waktu->copy()->addMinutes(rand(-15, 20)),
                        'scanned_by' => $admin->id,
                    ]
                );
            }
        }

        // ─── 5. SOAL PRETEST & POSTTEST ───────────────────────────────────────
        Soal::where('event_id', $event->id)->delete();
        $soalData = [
            ['teks' => 'Muhammadiyah didirikan pada tahun?', 'tipe' => 'pretest', 'jawaban' => ['1912', '1920', '1908', '1945'], 'benar' => 0],
            ['teks' => 'Kepanjangan PHIWM adalah?', 'tipe' => 'pretest', 'jawaban' => ['Pedoman Hidup Islami Warga Muhammadiyah', 'Program Hidup Islami', 'Panduan Hukum Islam', 'Matan Keyakinan Warga'], 'benar' => 0],
            ['teks' => 'Matan Keyakinan dan Cita-cita Hidup (MKCH) Muhammadiyah ditetapkan pada sidang Tanwir tahun?', 'tipe' => 'pretest', 'jawaban' => ['1969 di Ponorogo', '1912 di Yogyakarta', '1971 di Makassar', '1980 di Jakarta'], 'benar' => 0],
            ['teks' => 'Tujuan Muhammadiyah adalah menegakkan dan menjunjung tinggi Agama Islam sehingga terwujud?', 'tipe' => 'pretest', 'jawaban' => ['Masyarakat Islam yang sebenar-benarnya', 'Negara Islam Indonesia', 'Masyarakat adil makmur', 'Kerajaan Islam berdaulat'], 'benar' => 0],
            ['teks' => 'KH Ahmad Dahlan dilahirkan dengan nama kecil?', 'tipe' => 'pretest', 'jawaban' => ['Muhammad Darwis', 'Muhammad Dahlan', 'Ahmad Darwis', 'Muhammad Syamil'], 'benar' => 0],
            ['teks' => 'Sifat kepribadian Muhammadiyah salah satunya adalah?', 'tipe' => 'posttest', 'jawaban' => ['Beramal saleh dan berjuang untuk perdamaian', 'Mengutamakan kekuasaan politik', 'Eksklusif dan tertutup', 'Bekerjasama dengan kolonial'], 'benar' => 0],
            ['teks' => 'Apa itu amal usaha Muhammadiyah (AUM)?', 'tipe' => 'posttest', 'jawaban' => ['Wahana dakwah amal saleh organisasi', 'Badan usaha komersil murni', 'Lembaga politik praktis', 'Yayasan sosial non-keagamaan'], 'benar' => 0],
            ['teks' => 'Berikut yang merupakan organisasi otonom (Ortom) Muhammadiyah, KECUALI?', 'tipe' => 'posttest', 'jawaban' => ['Lembaga Hikmah dan Kebijakan Publik', 'Ikatan Pelajar Muhammadiyah', 'Tapak Suci Putera Muhammadiyah', 'Nasyiatul Aisyiyah'], 'benar' => 0],
            ['teks' => 'Dakwah Islam amar makruf nahi munkar ditujukan kepada dua bidang yaitu?', 'tipe' => 'posttest', 'jawaban' => ['Perorangan dan Masyarakat', 'Pemerintah dan Oposisi', 'Laki-laki dan Perempuan', 'Muslim dan Non-muslim'], 'benar' => 0],
            ['teks' => 'Buku pedoman resmi berkehidupan warga Muhammadiyah dinamakan?', 'tipe' => 'posttest', 'jawaban' => ['Pedoman Hidup Islami Warga Muhammadiyah (PHIWM)', 'AD/ART Muhammadiyah', 'Muqaddimah Anggaran Dasar', 'Kepribadian Muhammadiyah'], 'benar' => 0],
        ];

        $soalObjs = [];
        foreach ($soalData as $sNum => $sd) {
            $soal = Soal::create(['event_id' => $event->id, 'teks_soal' => $sd['teks'], 'tipe' => $sd['tipe'], 'urutan' => $sNum + 1]);
            foreach ($sd['jawaban'] as $jIdx => $jTeks) {
                PilihanJawaban::create(['soal_id' => $soal->id, 'teks_pilihan' => $jTeks, 'is_correct' => $jIdx === $sd['benar']]);
            }
            $soalObjs[] = $soal->load('pilihanJawaban');
        }

        // ─── 6. JAWABAN TES & SKOR PRETEST/POSTTEST ───────────────────────────
        JawabanPeserta::where('event_id', $event->id)->delete();
        $pretestSoals  = collect($soalObjs)->where('tipe', 'pretest');
        $posttestSoals = collect($soalObjs)->where('tipe', 'posttest');

        foreach ($eventPesertas as $idx => $ep) {
            if ($ep->konfirmasi_kesediaan === 'tidak_bersedia') {
                PenilaianAkhir::updateOrCreate(
                    ['event_id' => $event->id, 'peserta_id' => $ep->peserta_id],
                    ['nilai_pretest' => 0.0, 'nilai_posttest' => 0.0]
                );
                continue;
            }

            $pretestCorrect = 0;
            foreach ($pretestSoals as $soal) {
                $isCorrect = rand(1, 100) <= rand(35, 60);
                $pilihan = $isCorrect
                    ? $soal->pilihanJawaban->where('is_correct', true)->first()
                    : $soal->pilihanJawaban->where('is_correct', false)->random();
                if ($pilihan->is_correct) $pretestCorrect++;
                
                JawabanPeserta::create([
                    'event_id'   => $event->id,
                    'peserta_id' => $ep->peserta_id,
                    'soal_id'    => $soal->id,
                    'pilihan_id' => $pilihan->id,
                    'is_correct' => $pilihan->is_correct
                ]);
            }

            // Dosen biasanya punya peningkatan nilai yang tinggi saat posttest
            $baseCap = 75 + ($idx % 5);
            $posttestCorrect = 0;
            foreach ($posttestSoals as $soal) {
                $isCorrect = rand(1, 100) <= min(98, $baseCap + rand(0, 15));
                $pilihan = $isCorrect
                    ? $soal->pilihanJawaban->where('is_correct', true)->first()
                    : $soal->pilihanJawaban->where('is_correct', false)->random();
                if ($pilihan->is_correct) $posttestCorrect++;

                JawabanPeserta::create([
                    'event_id'   => $event->id,
                    'peserta_id' => $ep->peserta_id,
                    'soal_id'    => $soal->id,
                    'pilihan_id' => $pilihan->id,
                    'is_correct' => $pilihan->is_correct
                ]);
            }

            PenilaianAkhir::updateOrCreate(
                ['event_id' => $event->id, 'peserta_id' => $ep->peserta_id],
                [
                    'nilai_pretest'  => round(($pretestCorrect / max(1, $pretestSoals->count())) * 100, 2),
                    'nilai_posttest' => round(($posttestCorrect / max(1, $posttestSoals->count())) * 100, 2),
                ]
            );
        }

        // ─── 7. PENILAIAN AFEKTIF (SIKAP & KEHADIRAN IBADAH) ──────────────────
        AfektifSubAspek::where('event_id', $event->id)->delete();
        $aspekData = [
            ['nama' => 'A. Kedisiplinan & Aqidah', 'butirs' => [
                ['Saya berniat ikhlas mengikuti Baitul Arqam demi ridha Allah.', 'P'],
                ['Saya disiplin menghadiri seluruh rangkaian sesi tepat waktu.', 'P'],
            ]],
            ['nama' => 'B. Ibadah & Amaliah Harian', 'butirs' => [
                ['Saya sholat berjamaah 5 waktu tepat waktu selama masa pelatihan.', 'P'],
                ['Saya merasa enggan mengikuti qiyamul lail (sholat malam).', 'N'],
            ]],
            ['nama' => 'C. Karakter & Kerjasama Kelompok', 'butirs' => [
                ['Saya bersedia berdiskusi dengan sopan dan menghargai ide peserta lain.', 'P'],
                ['Saya bersikap ramah dan saling tolong-menolong selama di asrama.', 'P'],
            ]],
        ];

        $allButirs = [];
        foreach ($aspekData as $aIdx => $aData) {
            $subAspek = AfektifSubAspek::create([
                'event_id'       => $event->id,
                'nama_sub_aspek' => $aData['nama'],
                'status'         => 'aktif',
                'urutan'         => $aIdx + 1,
            ]);
            foreach ($aData['butirs'] as $bIdx => $bArr) {
                $allButirs[] = AfektifButir::create([
                    'sub_aspek_id'    => $subAspek->id,
                    'teks_pernyataan' => $bArr[0],
                    'is_positif'      => $bArr[1] === 'P',
                    'urutan'          => $bIdx + 1,
                ]);
            }
        }

        AfektifJawaban::where('event_id', $event->id)->delete();
        foreach ($eventPesertas as $ep) {
            if ($ep->konfirmasi_kesediaan === 'tidak_bersedia') {
                PenilaianAkhir::updateOrCreate(
                    ['event_id' => $event->id, 'peserta_id' => $ep->peserta_id],
                    ['nilai_afektif' => 0.0]
                );
                continue;
            }

            $total = 0;
            foreach ($allButirs as $butir) {
                $jawaban = rand(1, 100) <= 85 ? (rand(0, 1) ? 'SS' : 'S') : (rand(0, 1) ? 'TS' : 'STS');
                $mapPos  = ['SS' => 4, 'S' => 3, 'TS' => 2, 'STS' => 1];
                $mapNeg  = ['SS' => 1, 'S' => 2, 'TS' => 3, 'STS' => 4];
                $skor    = $butir->is_positif ? $mapPos[$jawaban] : $mapNeg[$jawaban];
                
                AfektifJawaban::create([
                    'event_id'     => $event->id,
                    'peserta_id'   => $ep->peserta_id,
                    'sub_aspek_id' => $butir->sub_aspek_id,
                    'butir_id'     => $butir->id,
                    'jawaban'      => $jawaban,
                    'skor'         => $skor,
                ]);
                $total += $skor;
            }
            $nilaiAfektif = count($allButirs) > 0 ? round(($total / (count($allButirs) * 4)) * 100, 2) : 0;
            
            PenilaianAkhir::updateOrCreate(
                ['event_id' => $event->id, 'peserta_id' => $ep->peserta_id],
                ['nilai_afektif' => $nilaiAfektif]
            );
        }

        // ─── 8. PENILAIAN PSIKOMOTOR (PRAKTIK IBADAH) ─────────────────────────
        PsikomotorTemplate::where('event_id', $event->id)->delete();
        $templateData = ['Praktik Sholat Berjamaah & Wirid', 'Tahsin & Hafalan Al-Quran', 'Penyusunan RTL & Kepemimpinan'];
        $templates = [];
        foreach ($templateData as $tNama) {
            $templates[] = PsikomotorTemplate::create([
                'event_id'   => $event->id,
                'nama_aspek' => $tNama,
                'jenis'      => 'ibadah',
                'skor_maks'  => 4,
            ]);
        }

        PsikomotorNilai::where('event_id', $event->id)->delete();
        foreach ($eventPesertas as $ep) {
            if ($ep->konfirmasi_kesediaan === 'tidak_bersedia') {
                PenilaianAkhir::updateOrCreate(
                    ['event_id' => $event->id, 'peserta_id' => $ep->peserta_id],
                    ['nilai_psikomotor' => 0.0]
                );
                continue;
            }

            $total = 0;
            foreach ($templates as $tmpl) {
                $skor = rand(3, 4); // Dosen rata-rata mendapatkan skor 3 dan 4
                PsikomotorNilai::create([
                    'event_id'     => $event->id,
                    'peserta_id'   => $ep->peserta_id,
                    'template_id'  => $tmpl->id,
                    'skor'         => $skor,
                    'dinilai_oleh' => $admin->id
                ]);
                $total += $skor;
            }
            $nilaiPsi = count($templates) > 0 ? round(($total / (count($templates) * 4)) * 100, 2) : 0;
            
            PenilaianAkhir::updateOrCreate(
                ['event_id' => $event->id, 'peserta_id' => $ep->peserta_id],
                ['nilai_psikomotor' => $nilaiPsi]
            );
        }

        // ─── 9. ANGKET EVALUASI KEGIATAN ─────────────────────────────────────
        AngketItem::where('event_id', $event->id)->delete();
        $angketItems = [];
        $itemTeks = [
            'Relevansi dan kualitas penyampaian materi narasumber',
            'Ketepatan waktu dan kenyamanan jadwal acara',
            'Kenyamanan fasilitas penginapan dan ruang kelas',
            'Kualitas konsumsi dan keramahan panitia',
            'Manfaat Baitul Arqam terhadap etos kerja dosen/tendik',
        ];
        foreach ($itemTeks as $urut => $teks) {
            $angketItems[] = AngketItem::create([
                'event_id'  => $event->id,
                'teks_item' => $teks,
                'kategori'  => 'A',
                'urutan'    => $urut + 1,
            ]);
        }

        $komentars = [
            'Sangat mencerahkan, menyegarkan kembali komitmen keislaman dan kemuhammadiyahan saya sebagai dosen.',
            'Secara umum luar biasa, pemateri sangat mumpuni. Fasilitas kelas agak sedikit dingin AC-nya.',
            'Alhamdulillah, baarakallahu fiikum untuk panitia. Sangat menginspirasi!',
            'Semoga program ini diselenggarakan berkala agar semangat ibadah dan ber-Persyarikatan selalu terjaga.',
            'Koordinasi waktu acara sudah sangat baik, materi RTL sangat membekali tugas dinas saya.',
        ];

        AngketJawaban::where('event_id', $event->id)->delete();
        AngketKomentar::where('event_id', $event->id)->delete();
        foreach ($eventPesertas as $ep) {
            if ($ep->konfirmasi_kesediaan === 'tidak_bersedia') continue;
            
            foreach ($angketItems as $item) {
                // Jawaban: A (Sangat Baik), B (Baik), C (Cukup), D (Kurang)
                $pilihanJawaban = rand(1, 100) <= 85 ? (rand(0, 1) ? 'A' : 'B') : 'C';
                AngketJawaban::create([
                    'event_id'   => $event->id,
                    'peserta_id' => $ep->peserta_id,
                    'item_id'    => $item->id,
                    'jawaban'    => $pilihanJawaban
                ]);
            }
            AngketKomentar::create([
                'event_id'   => $event->id,
                'peserta_id' => $ep->peserta_id,
                'komentar'   => $komentars[array_rand($komentars)]
            ]);
        }

        // ─── 10. PEMBOBOTAN AHP & PERANKINGAN SAW ──────────────────────────────
        AhpBobot::updateOrCreate(
            ['event_id' => $event->id],
            [
                'matriks'       => json_encode(['0_1' => '1', '0_2' => '1', '0_3' => '1', '0_4' => '1', '1_2' => '1', '1_3' => '1', '1_4' => '1', '2_3' => '1', '2_4' => '1', '3_4' => '1']),
                'bobot_c1'      => 0.20, // Pretest
                'bobot_c2'      => 0.20, // Posttest
                'bobot_c3'      => 0.20, // Praktik Ibadah
                'bobot_c4'      => 0.20, // Sikap / Afektif
                'bobot_c5'      => 0.20, // Kehadiran Sesi
                'cr_value'      => 0.0,
                'is_consistent' => true,
            ]
        );

        // Hitung persentase kehadiran masing-masing peserta
        foreach ($eventPesertas as $ep) {
            NilaiService::hitungKehadiran($event->id, $ep->peserta_id);
        }

        // Proses perankingan SAW dan evaluasi kelulusan otomatis
        SawService::hitungUlang($event->id);

        $this->command->info("✅ BaDosenDemoSeeder berhasil disemai untuk Event ID {$event->id}. Seluruh modul dari A-Z (Sesi, Absen, Pre/Posttest, Afektif, Psikomotor, Angket, AHP, SAW) telah terisi penuh!");
    }
}
