<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Soal;
use App\Models\PilihanJawaban;

class SoalSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();
        if (!$event) return;

        // 5 soal dasar yang akan di-loop untuk membuat 25 pertanyaan
        $baseQuestions = [
            [
                'teks' => 'Tujuan didirikannya Muhammadiyah oleh KH. Ahmad Dahlan pada tahun 1912 adalah...',
                'pilihan' => [
                    ['A', 'Menegakkan dan menjunjung tinggi ajaran Islam sehingga terwujud masyarakat Islam yang sebenar-benarnya', true],
                    ['B', 'Membangun kekuatan politik umat Islam di nusantara', false],
                    ['C', 'Melawan penjajahan Belanda melalui pendidikan dan kesehatan', false],
                    ['D', 'Mengumpulkan dana umat untuk kesejahteraan pengurus', false]
                ]
            ],
            [
                'teks' => 'Salah satu sifat yang termaktub dalam Kepribadian Muhammadiyah adalah...',
                'pilihan' => [
                    ['A', 'Eksklusif dan tertutup dari golongan lain', false],
                    ['B', 'Mengindahkan undang-undang, peraturan-peraturan yang sah', true],
                    ['C', 'Mengutamakan kepentingan kelompok di atas kepentingan umat', false],
                    ['D', 'Memaksakan kehendak dalam berdakwah amar makruf nahi mungkar', false]
                ]
            ],
            [
                'teks' => 'Dalam Pedoman Hidup Islami Warga Muhammadiyah (PHIWM), kehidupan dalam keluarga seharusnya...',
                'pilihan' => [
                    ['A', 'Difokuskan pada pencarian materi semata', false],
                    ['B', 'Mengedepankan kebebasan individu mutlak', false],
                    ['C', 'Menjadi tempat sosialisasi nilai-nilai Islam yang utama', true],
                    ['D', 'Diserahkan sepenuhnya kepada lembaga sekolah', false]
                ]
            ],
            [
                'teks' => 'Matan Keyakinan dan Cita-Cita Hidup Muhammadiyah (MKCHM) menegaskan bahwa ajaran Islam bersumber pada...',
                'pilihan' => [
                    ['A', 'Al-Quran dan Sunnah Rasul yang shahih/maqbulah', true],
                    ['B', 'Hanya Al-Quran semata dengan interpretasi bebas', false],
                    ['C', 'Pendapat ulama mazhab empat tanpa kritik', false],
                    ['D', 'Tradisi dan budaya lokal yang disesuaikan', false]
                ]
            ],
            [
                'teks' => 'Landasan operasional persyarikatan Muhammadiyah yang dirumuskan pada muktamar ke-35 di Jakarta (1962) adalah...',
                'pilihan' => [
                    ['A', 'Khittah Perjuangan Muhammadiyah', false],
                    ['B', 'Kepribadian Muhammadiyah', true],
                    ['C', 'Muqaddimah Anggaran Dasar', false],
                    ['D', 'Pedoman Hidup Islami', false]
                ]
            ]
        ];

        $urutan = 1;
        // Ulangi 5 kali untuk membuat 25 pertanyaan
        for ($i = 0; $i < 5; $i++) {
            foreach ($baseQuestions as $q) {
                // Pretest
                $soal = Soal::create([
                    'event_id'  => $event->id,
                    'tipe'      => 'pretest',
                    'teks_soal' => $q['teks'] . ' (Variasi ' . ($i + 1) . ')',
                    'urutan'    => $urutan,
                ]);

                foreach ($q['pilihan'] as $p) {
                    PilihanJawaban::create([
                        'soal_id'      => $soal->id,
                        'huruf'        => $p[0],
                        'teks_pilihan' => $p[1],
                        'is_correct'   => $p[2],
                    ]);
                }
                $urutan++;
            }
        }

        // Duplikat Pretest ke Posttest
        $pretests = Soal::where('event_id', $event->id)->where('tipe', 'pretest')->with('pilihanJawaban')->get();
        foreach ($pretests as $pre) {
            $post = Soal::create([
                'event_id'  => $event->id,
                'tipe'      => 'posttest',
                'teks_soal' => $pre->teks_soal,
                'urutan'    => $pre->urutan,
            ]);

            foreach ($pre->pilihanJawaban as $pil) {
                PilihanJawaban::create([
                    'soal_id'      => $post->id,
                    'huruf'        => $pil->huruf,
                    'teks_pilihan' => $pil->teks_pilihan,
                    'is_correct'   => $pil->is_correct,
                ]);
            }
        }
    }
}
