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

class BaPkuSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $this->command->error('Admin tidak ditemukan. Jalankan AdminSeeder terlebih dahulu.');
            return;
        }

        // ─── 1. EVENT ─────────────────────────────────────────────────────────
        $event = Event::updateOrCreate(
            ['registration_token' => 'BAPKU2026'],
            [
                'nama_event'       => 'Baitul Arqam PKU Muhammadiyah Karanganyar 2026',
                'tanggal_mulai'    => '2026-06-06',
                'tanggal_selesai'  => '2026-06-08',
                'lokasi'           => 'PKU Muhammadiyah Karanganyar',
                'deskripsi'        => 'Pelatihan intensif kemuhammadiyahan untuk karyawan PKU Muhammadiyah meliputi materi aqidah, ibadah, akhlak, dan dinamika persyarikatan.',
                'status'           => 'selesai',
                'created_by'       => $admin->id,
            ]
        );

        // ─── 2. SESI ──────────────────────────────────────────────────────────
        $sesiData = [
            ['nama_sesi' => 'Pembukaan & Orientasi BA'],
            ['nama_sesi' => 'Materi 1: Ideologi Muhammadiyah'],
            ['nama_sesi' => 'Materi 2: PHIWM'],
            ['nama_sesi' => 'Praktik Ibadah & Tahsin'],
            ['nama_sesi' => 'Dinamika Kelompok & Outbound'],
            ['nama_sesi' => 'Penutupan & RTL'],
        ];
        EventSesi::where('event_id', $event->id)->delete();
        $sesis = [];
        foreach ($sesiData as $i => $s) {
            $sesis[] = EventSesi::create(array_merge($s, ['event_id' => $event->id, 'urutan' => $i + 1]));
        }

        // ─── 3. PESERTA ───────────────────────────────────────────────────────
        $pesertaData = [
            ['nama' => 'dr. Ahmad Fauzi, Sp.PD', 'unit' => 'Divisi Penyakit Dalam', 'jabatan' => 'Dokter Spesialis', 'gender' => 'L'],
            ['nama' => 'Siti Aminah, S.Kep., Ns.', 'unit' => 'Ruang ICU', 'jabatan' => 'Kepala Ruangan', 'gender' => 'P'],
            ['nama' => 'Budi Santoso, A.Md.Kep.', 'unit' => 'UGD', 'jabatan' => 'Perawat Pelaksana', 'gender' => 'L'],
            ['nama' => 'dr. Rina Wati, M.Kes.', 'unit' => 'Divisi Anak', 'jabatan' => 'Dokter Umum', 'gender' => 'P'],
            ['nama' => 'Hasan Bisri, S.Kep., Ns.', 'unit' => 'Rawat Inap Kelas I', 'jabatan' => 'Perawat Senior', 'gender' => 'L'],
            ['nama' => 'Dewi Lestari, S.Farm., Apt.', 'unit' => 'Instalasi Farmasi', 'jabatan' => 'Apoteker', 'gender' => 'P'],
            ['nama' => 'Agus Rahman, S.Kep.', 'unit' => 'Poli Umum', 'jabatan' => 'Perawat Pelaksana', 'gender' => 'L'],
            ['nama' => 'Nurul Hidayati, A.Md.Rad.', 'unit' => 'Radiologi', 'jabatan' => 'Radiografer', 'gender' => 'P'],
            ['nama' => 'Arif Budiman, S.T.', 'unit' => 'IPSRS', 'jabatan' => 'Teknisi Elektromedik', 'gender' => 'L'],
            ['nama' => 'Indah Purnamasari, S.K.M.', 'unit' => 'Promosi Kesehatan', 'jabatan' => 'Staf Promkes', 'gender' => 'P'],
            ['nama' => 'Wahyu Setiawan, A.Md.Kep.', 'unit' => 'Ruang Kebidanan', 'jabatan' => 'Perawat Pelaksana', 'gender' => 'L'],
            ['nama' => 'Fitri Handayani, S.Gz.', 'unit' => 'Instalasi Gizi', 'jabatan' => 'Ahli Gizi', 'gender' => 'P'],
        ];

        $eventPesertas = [];
        foreach ($pesertaData as $idx => $p) {
            $email = 'pku.' . strtolower(preg_replace('/[^a-zA-Z]/', '', explode(',', $p['nama'])[0])) . $idx . '@arqam.test';

            $user = User::firstOrCreate(['email' => $email], [
                'name'     => $p['nama'],
                'password' => Hash::make('password'),
                'role'     => 'peserta',
            ]);

            $peserta = Peserta::firstOrCreate(['user_id' => $user->id], [
                'nama_lengkap'         => $p['nama'],
                'email'                => $email,
                'no_hp'                => '0812' . str_pad(rand(10000000, 99999999), 8, '0'),
                'unit_kerja'           => 'PKU Muhammadiyah Karanganyar - ' . $p['unit'],
                'jabatan_aum'          => $p['jabatan'],
                'jenis_kelamin'        => $p['gender'],
                'tempat_lahir'         => collect(['Solo', 'Karanganyar', 'Sragen', 'Wonogiri'])->random(),
                'tanggal_lahir'        => Carbon::now()->subYears(rand(25, 50))->subDays(rand(0, 365))->format('Y-m-d'),
                'umur'                 => rand(25, 50),
                'status_pernikahan'    => rand(0, 1) ? 'Menikah' : 'Belum Menikah',
                'pendidikan_terakhir'  => collect(['SMA', 'S1'])->random(),
                'pendidikan_sd'        => 'SDN ' . rand(1, 10) . ' Karanganyar',
                'pendidikan_smp'       => 'SMP Muhammadiyah Karanganyar',
                'pendidikan_sma'       => 'SMA Muhammadiyah ' . rand(1, 3) . ' Karanganyar',
                'kemampuan_baca_quran' => collect(["Terbata-bata", "Lancar belum fasih", "Lancar dan Fasih"])->random(),
                'hafalan_quran_1'      => collect(["1-10 surat", "10-20 surat", "1 juz"])->random(),
                'aktivitas_sholat_masjid' => collect(["Selalu di masjid", "Sering di masjid", "Kadang-kadang di masjid"])->random(),
                'aktivitas_kajian_agama'  => collect(["Seminggu 1-3x", "Seminggu 1x", "Sebulan 1x"])->random(),
                'langganan_suara_muhammadiyah' => collect(['Berlangganan', 'Terkadang beli', 'Tidak pernah'])->random(),
                'tokoh_berpengaruh'    => collect(['KH Ahmad Dahlan', 'Buya Hamka', 'AR Fachruddin'])->random(),
                'alasan_pilih_tokoh'   => 'Beliau adalah teladan dalam dakwah dan amal usaha.',
                'harapan_pcm'          => 'PCM semakin solid dan proaktif dalam syiar Islam.',
                'harapan_mengikuti_ba' => 'Menjadi karyawan PKU yang lebih islami dan profesional.',
                'organisasi_lain'      => '-',
            ]);

            $token = hash_hmac('sha256', $event->id . '-' . $peserta->id, config('app.key'));
            $qrCode = base64_encode(json_encode(['e' => $event->id, 'p' => $peserta->id, 't' => $token]));

            $ep = EventPeserta::firstOrCreate(
                ['event_id' => $event->id, 'peserta_id' => $peserta->id],
                ['qr_code' => $qrCode, 'status_aktif' => true]
            );
            $eventPesertas[] = $ep;
        }

        // ─── 4. ABSENSI ───────────────────────────────────────────────────────
        Absensi::where('event_id', $event->id)->delete();
        $baseDate = Carbon::parse($event->tanggal_mulai);
        foreach ($sesis as $sIdx => $sesi) {
            $waktu = $baseDate->copy()->addDays((int)($sIdx / 2))->setHour(8 + ($sIdx % 2) * 4);
            foreach ($eventPesertas as $pIdx => $ep) {
                if ($pIdx > 6 && rand(1, 10) === 1) continue; // ~10% absen untuk beberapa orang
                Absensi::create([
                    'event_id'   => $event->id,
                    'sesi_id'    => $sesi->id,
                    'peserta_id' => $ep->peserta_id,
                    'waktu_scan' => $waktu->copy()->addMinutes(rand(-10, 15)),
                    'scanned_by' => $admin->id,
                ]);
            }
        }

        // ─── 5. SOAL PRETEST & POSTTEST ───────────────────────────────────────
        Soal::where('event_id', $event->id)->delete();
        $soalData = [
            ['teks' => 'Muhammadiyah didirikan pada tahun?', 'tipe' => 'pretest', 'jawaban' => ['1912', '1920', '1908', '1945'], 'benar' => 0],
            ['teks' => 'Pendiri Muhammadiyah adalah?', 'tipe' => 'pretest', 'jawaban' => ['KH Ahmad Dahlan', 'Hasyim Asy\'ari', 'Soekarno', 'KH Wahab'], 'benar' => 0],
            ['teks' => 'Kepanjangan PHIWM adalah?', 'tipe' => 'pretest', 'jawaban' => ['Pedoman Hidup Islami Warga Muhammadiyah', 'Pedoman Hukum Islam Warga Mu', 'Program Hidup Islami', 'Panduan Hidup Islam Warga'], 'benar' => 0],
            ['teks' => 'Majelis PKU singkatan dari?', 'tipe' => 'pretest', 'jawaban' => ['Pembina Kesehatan Umat', 'Pemuliaan Kader Unggulan', 'Pengembangan Kualitas Umat', 'Pembantu Kesejahteraan Umat'], 'benar' => 0],
            ['teks' => 'Baitul Arqam adalah program pembinaan untuk?', 'tipe' => 'pretest', 'jawaban' => ['Kader Muhammadiyah', 'Siswa SMA', 'Santri Pesantren', 'Mahasiswa Baru'], 'benar' => 0],
            ['teks' => 'Ideologi Muhammadiyah berlandaskan?', 'tipe' => 'posttest', 'jawaban' => ['Al-Quran dan Sunnah', 'Pancasila saja', 'UUD 1945', 'Adat Istiadat'], 'benar' => 0],
            ['teks' => 'Tujuan Muhammadiyah sesuai Anggaran Dasar adalah?', 'tipe' => 'posttest', 'jawaban' => ['Menegakkan dan menjunjung tinggi agama Islam', 'Mendirikan negara Islam', 'Menjadi organisasi terbesar', 'Menentang penjajahan'], 'benar' => 0],
            ['teks' => 'Matan Keyakinan dan Cita-cita Hidup (MKCH) Muhammadiyah ditetapkan tahun?', 'tipe' => 'posttest', 'jawaban' => ['1969', '1912', '1945', '1966'], 'benar' => 0],
            ['teks' => 'Sifat dakwah Muhammadiyah adalah?', 'tipe' => 'posttest', 'jawaban' => ['Amar ma\'ruf nahi munkar', 'Militan dan revolusioner', 'Pasif dan moderat', 'Eksklusif'], 'benar' => 0],
            ['teks' => 'PKU Muhammadiyah merupakan bentuk amal usaha di bidang?', 'tipe' => 'posttest', 'jawaban' => ['Kesehatan', 'Pendidikan', 'Ekonomi', 'Politik'], 'benar' => 0],
        ];

        $soalObjs = [];
        foreach ($soalData as $sNum => $sd) {
            $soal = Soal::create(['event_id' => $event->id, 'teks_soal' => $sd['teks'], 'tipe' => $sd['tipe'], 'urutan' => $sNum + 1]);
            foreach ($sd['jawaban'] as $jIdx => $jTeks) {
                PilihanJawaban::create(['soal_id' => $soal->id, 'teks_pilihan' => $jTeks, 'is_correct' => $jIdx === $sd['benar']]);
            }
            $soalObjs[] = $soal->load('pilihanJawaban');
        }

        // ─── 6. JAWABAN TES ───────────────────────────────────────────────────
        JawabanPeserta::where('event_id', $event->id)->delete();
        $pretestSoals  = collect($soalObjs)->where('tipe', 'pretest');
        $posttestSoals = collect($soalObjs)->where('tipe', 'posttest');

        foreach ($eventPesertas as $idx => $ep) {
            $pretestCorrect = 0;
            foreach ($pretestSoals as $soal) {
                $isCorrect = rand(1, 100) <= rand(30, 55);
                $pilihan = $isCorrect
                    ? $soal->pilihanJawaban->where('is_correct', true)->first()
                    : $soal->pilihanJawaban->where('is_correct', false)->random();
                if ($pilihan->is_correct) $pretestCorrect++;
                JawabanPeserta::create(['event_id' => $event->id, 'peserta_id' => $ep->peserta_id, 'soal_id' => $soal->id, 'pilihan_id' => $pilihan->id, 'is_correct' => $pilihan->is_correct]);
            }

            $baseCap = 65 + ($idx * 2);
            $posttestCorrect = 0;
            foreach ($posttestSoals as $soal) {
                $isCorrect = rand(1, 100) <= min(95, $baseCap + rand(0, 10));
                $pilihan = $isCorrect
                    ? $soal->pilihanJawaban->where('is_correct', true)->first()
                    : $soal->pilihanJawaban->where('is_correct', false)->random();
                if ($pilihan->is_correct) $posttestCorrect++;
                JawabanPeserta::create(['event_id' => $event->id, 'peserta_id' => $ep->peserta_id, 'soal_id' => $soal->id, 'pilihan_id' => $pilihan->id, 'is_correct' => $pilihan->is_correct]);
            }

            PenilaianAkhir::updateOrCreate(
                ['event_id' => $event->id, 'peserta_id' => $ep->peserta_id],
                [
                    'nilai_pretest'  => round(($pretestCorrect / max(1, $pretestSoals->count())) * 100, 2),
                    'nilai_posttest' => round(($posttestCorrect / max(1, $posttestSoals->count())) * 100, 2),
                ]
            );
        }

        // ─── 7. AFEKTIF ───────────────────────────────────────────────────────
        AfektifSubAspek::where('event_id', $event->id)->delete();
        $aspekData = [
            ['nama' => 'A. Aqidah & Keimanan', 'butirs' => [
                ['Saya meyakini Allah sebagai satu-satunya Tuhan yang berhak disembah.', 'P'],
                ['Saya rajin membaca Al-Quran setiap hari.', 'P'],
            ]],
            ['nama' => 'B. Ibadah & Amaliah', 'butirs' => [
                ['Saya sholat 5 waktu tepat waktu dan berjamaah.', 'P'],
                ['Saya merasa malas mengikuti kegiatan kajian agama di PKU.', 'N'],
            ]],
            ['nama' => 'C. Akhlak & Muamalah', 'butirs' => [
                ['Saya jujur dan amanah dalam bekerja di PKU Muhammadiyah.', 'P'],
                ['Saya bersikap ramah dan sabar kepada seluruh pasien.', 'P'],
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
            $total = 0;
            foreach ($allButirs as $butir) {
                $jawaban = rand(1, 100) <= 80 ? (rand(0, 1) ? 'SS' : 'S') : (rand(0, 1) ? 'TS' : 'STS');
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

        // ─── 8. PSIKOMOTOR ────────────────────────────────────────────────────
        PsikomotorTemplate::where('event_id', $event->id)->delete();
        $templateData = ['Praktik Sholat Berjamaah', 'Tahsin Al-Quran', 'Presentasi RTL'];
        $templates = [];
        foreach ($templateData as $tNama) {
            $templates[] = PsikomotorTemplate::create([
                'event_id'  => $event->id,
                'nama_aspek' => $tNama,
                'jenis'      => 'ibadah',
                'skor_maks'  => 4,
            ]);
        }

        PsikomotorNilai::where('event_id', $event->id)->delete();
        foreach ($eventPesertas as $ep) {
            $total = 0;
            foreach ($templates as $tmpl) {
                $skor = rand(2, 4);
                PsikomotorNilai::create(['event_id' => $event->id, 'peserta_id' => $ep->peserta_id, 'template_id' => $tmpl->id, 'skor' => $skor, 'dinilai_oleh' => $admin->id]);
                $total += $skor;
            }
            $nilaiPsi = count($templates) > 0 ? round(($total / (count($templates) * 4)) * 100, 2) : 0;
            PenilaianAkhir::updateOrCreate(['event_id' => $event->id, 'peserta_id' => $ep->peserta_id], ['nilai_psikomotor' => $nilaiPsi]);
        }

        // ─── 9. ANGKET ────────────────────────────────────────────────────────
        AngketItem::where('event_id', $event->id)->delete();
        $angketItems = [];
        $itemTeks = [
            'Kualitas materi kegiatan',
            'Kemampuan dan penguasaan pemateri',
            'Manajemen waktu & kesesuaian jadwal',
            'Fasilitas dan akomodasi kegiatan',
            'Relevansi materi dengan tugas di PKU',
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
            'Kegiatan sangat bermanfaat dan menginspirasi, luar biasa!',
            'Fasilitas perlu ditingkatkan, namun materi sangat relevan.',
            'Terima kasih, saya jadi lebih memahami nilai-nilai Muhammadiyah.',
            'Semoga ada tindak lanjut dari RTL yang sudah disusun.',
            'Alhamdulillah, kegiatan berjalan lancar dan penuh hikmah.',
        ];

        AngketJawaban::where('event_id', $event->id)->delete();
        AngketKomentar::where('event_id', $event->id)->delete();
        foreach ($eventPesertas as $ep) {
            foreach ($angketItems as $item) {
                AngketJawaban::create(['event_id' => $event->id, 'peserta_id' => $ep->peserta_id, 'item_id' => $item->id, 'jawaban' => rand(1, 100) <= 80 ? (rand(0, 1) ? 'A' : 'B') : 'C']);
            }
            AngketKomentar::create(['event_id' => $event->id, 'peserta_id' => $ep->peserta_id, 'komentar' => $komentars[array_rand($komentars)]]);
        }

        // ─── 10. AHP & SAW FINAL ─────────────────────────────────────────────
        AhpBobot::updateOrCreate(
            ['event_id' => $event->id],
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

        foreach ($eventPesertas as $ep) {
            NilaiService::hitungKehadiran($event->id, $ep->peserta_id);
        }
        SawService::hitungUlang($event->id);

        $this->command->info('✅ BaPkuSeeder selesai: ' . count($eventPesertas) . ' peserta, event "' . $event->nama_event . '" telah diisi penuh dari awal hingga akhir.');
    }
}
