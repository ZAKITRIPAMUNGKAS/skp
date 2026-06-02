<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\AngketItem;

class AngketSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();
        if (!$event) return;

        $items = [
            ['A', 'Kesesuaian materi dengan tujuan Baitul Arqam'],
            ['A', 'Kedisiplinan narasumber/instruktur dalam kehadiran'],
            ['A', 'Penguasaan narasumber terhadap substansi materi'],
            ['B', 'Relevansi materi dengan kebutuhan/tugas peserta di Amal Usaha Muhammadiyah'],
            ['B', 'Metode penyampaian materi menarik dan mudah dipahami'],
            ['B', 'Kesempatan untuk mendiskusikan masalah keislaman & kemuhammadiyahan'],
            ['C', 'Kenyamanan fasilitas penginapan/ruang istirahat (jika menginap)'],
            ['C', 'Ketersediaan dan kenyamanan fasilitas ibadah (Masjid/Mushala, Al-Quran, dll)'],
            ['C', 'Kebersihan fasilitas umum (kamar mandi dan toilet)'],
            ['D', 'Kualitas dan higienitas konsumsi yang disajikan'],
            ['D', 'Ketepatan waktu dan kecukupan porsi konsumsi'],
            ['D', 'Variasi menu konsumsi selama kegiatan berlangsung'],
            ['E', 'Kesiapan instruktur lokal dalam melayani kebutuhan operasional peserta'],
            ['E', 'Sikap ramah, responsif, dan solutif dari instruktur/Master of Training (MoT)'],
            ['E', 'Kedisiplinan dalam pengelolaan waktu (kesesuaian dengan rundown acara)'],
            ['F', 'Fasilitas ruang materi/sidang (Kenyamanan, AC, kebersihan, pencahayaan)'],
            ['F', 'Kelengkapan dan fungsi fasilitas belajar (LCD, proyektor, papan tulis, sound system)'],
            ['F', 'Suasana lingkungan di sekitar tempat kegiatan (Terbebas dari kebisingan/kondusif)'],
            ['G', 'Manfaat riil kegiatan Baitul Arqam terhadap peningkatkan spiritual dan ibadah harian'],
            ['G', 'Dampak kegiatan dalam membangkitkan motivasi etos kerja yang Islami'],
            ['G', 'Peningkatan pemahaman dan keyakinan akan Ideologi Muhammadiyah'],
            ['H', 'Kejelasan informasi prakegiatan (undangan, jadwal, dresscode, dan tata tertib)'],
            ['H', 'Sistematika, relevansi, dan ketersediaan materi/modul (softcopy/hardcopy)'],
            ['H', 'Ketepatan panduan/pemberlakuan ibadah wajib dan sunnah selama acara'],
            ['I', 'Penilaian kepuasan secara keseluruhan (Rating umum) terhadap Baitul Arqam ini'],
            ['I', 'Kelayakan lokasi, penginapan dan ruang aula ini untuk menyelenggarakan acara serupa'],
            ['I', 'Tingkat rekomendasi pengalaman Baitul Arqam ini bagi kolega Anda lainnya'],
        ];

        foreach ($items as $index => $item) {
            AngketItem::create([
                'event_id'  => $event->id,
                'kategori'  => $item[0],
                'teks_item' => $item[1],
                'urutan'    => $index + 1
            ]);
        }
    }
}
