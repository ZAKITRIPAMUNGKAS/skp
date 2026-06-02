<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\AfektifSubAspek;
use App\Models\AfektifButir;

class AfektifSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();
        if (!$event) return;

        $subAspeks = [
            [
                'nama' => 'A. Sikap Keislaman',
                'butirs' => [
                    ['Saya melaksanakan shalat jamaah lima waktu di masjid.', 'P'],
                    ['Saya sering mengabaikan tilawah Al-Quran harian.', 'N'],
                    ['Saya antusias mendengarkan kajian keislaman di kampus/kantor.', 'P'],
                    ['Membayar zakat dan sedekah terasa memberatkan bagi saya.', 'N'],
                    ['Saya berusaha menjaga lisan dari perkataan yang sia-sia.', 'P'],
                    ['Saya merasa puasa sunnah tidak terlalu penting jika sudah puasa wajib.', 'N'],
                    ['Saya senantiasa berdoa sebelum dan sesudah melakukan aktivitas rutin.', 'P'],
                    ['Sesekali saya masih sulit menghindari ghibah (membicarakan aib orang lain).', 'N'],
                ]
            ],
            [
                'nama' => 'B. Sikap Kemuhammadiyahan',
                'butirs' => [
                    ['Saya bangga dan memahami identitas Muhammadiyah sebagai gerakan dakwah tajdid.', 'P'],
                    ['Saya kurang tertarik menyosialisasikan program Muhammadiyah di masyarakat.', 'N'],
                    ['Saya aktif dan rutin mendukung program amal usaha Muhammadiyah tempat saya bekerja.', 'P'],
                    ['Saya menganggap putusan Tarjih Muhammadiyah bersifat kaku.', 'N'],
                    ['Saya bersedia menjadi kader penggerak persyarikatan kapan pun dibutuhkan.', 'P'],
                    ['Aktivitas organisasi Ranting/Cabang Muhammadiyah membuang banyak waktu saya.', 'N'],
                    ['Saya mendasarkan pemahaman agama pada AI-Quran dan Sunnah sesuai manhaj Tarjih.', 'P'],
                    ['Saya merasa kajian kemuhammadiyahan seringkali monoton dan membosankan.', 'N'],
                ]
            ],
            [
                'nama' => 'C. Etos Kerja & Kepemimpinan',
                'butirs' => [
                    ['Saya selalu menyelesaikan tugas yang diberikan dengan dedikasi tinggi dan tepat waktu.', 'P'],
                    ['Menunda-nunda pekerjaan adalah hal yang lumrah jika atasan tidak mengawasi.', 'N'],
                    ['Saya berinisiatif memberikan solusi jika terjadi kendala dalam pekerjaan tim.', 'P'],
                    ['Saya lebih suka bekerja individual dan menghindari tanggung jawab kepemimpinan.', 'N'],
                    ['Saya menjaga integritas dengan tidak menyalahgunakan fasilitas institusi.', 'P'],
                    ['Sikap disiplin tidak terlalu diutamakan selama target minimum pekerjaan tercapai.', 'N'],
                    ['Saya bersedia membimbing kolega baru untuk beradaptasi dengan budaya kerja Islami.', 'P'],
                    ['Kritik dari atasan atau bawahan saya anggap sebagai bentuk ketidaksukaan pribadi.', 'N'],
                ]
            ],
            [
                'nama' => 'D. Sikap Sosial Kemasyarakatan',
                'butirs' => [
                    ['Saya peduli dan aktif membantu warga sekitar yang tertimpa musibah.', 'P'],
                    ['Saya ragu untuk meluangkan waktu demi kegiatan bakti sosial di luar jam kerja.', 'N'],
                    ['Menjaga silaturahmi dengan kolega dan tetangga adalah prioritas saya.', 'P'],
                    ['Saya acuh tak acuh terhadap isu kemiskinan dan dhuafa di lingkungan saya.', 'N'],
                    ['Saya memposisikan diri secara adil tanpa memandang status ekonomi orang lain.', 'P'],
                    ['Bersedekah secara diam-diam kurang memberikan keuntungan sosial bagi saya.', 'N'],
                    ['Saya berusaha mengajak rekan kerja untuk ikut serta dalam gerakan pemberdayaan umat.', 'P'],
                    ['Toleransi beragama cukup sekadar tidak saling mengganggu tanpa perlu berdialog.', 'N'],
                ]
            ],
        ];

        foreach ($subAspeks as $index => $aspek) {
            $sa = AfektifSubAspek::create([
                'event_id'       => $event->id,
                'nama_sub_aspek' => $aspek['nama'],
                'status'         => 'aktif',
                'urutan'         => $index + 1,
            ]);

            foreach ($aspek['butirs'] as $urutan => $butir) {
                AfektifButir::create([
                    'sub_aspek_id'    => $sa->id,
                    'teks_pernyataan' => $butir[0],
                    'is_positif'      => $butir[1] === 'P',
                    'urutan'          => $urutan + 1,
                ]);
            }
        }
    }
}
