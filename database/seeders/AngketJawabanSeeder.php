<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\AngketItem;
use App\Models\AngketJawaban;
use App\Models\AngketKomentar;

class AngketJawabanSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();
        if (!$event) return;

        $pesertas = EventPeserta::where('event_id', $event->id)->get();
        $items = AngketItem::where('event_id', $event->id)->get();

        $komentarSamples = [
            'Kegiatan sangat bermanfaat dan menginspirasi, pemateri luar biasa!',
            'Fasilitas penginapan perlu ditingkatkan untuk event selanjutnya.',
            'Acara sudah berjalan lancar, instruktur ramah dan responsif. Terima kasih.',
            'Secara keseluruhan sangat baik, namun rundown kadang meleset dari jadwal.',
            'Mohon waktu diskusi sesi Kemuhammadiyahan diperpanjang.',
            'Makanannya enak, lokasi kondusif. Saya sangat merekomendasikan Baitul Arqam ini.',
        ];

        foreach ($pesertas as $ep) {
            $pesertaId = $ep->peserta_id;
            
            foreach ($items as $item) {
                // 80% choose A or B (Baik/Sangat Baik)
                $jawaban = rand(1, 100) <= 80 ? (rand(0,1) ? 'A' : 'B') : (rand(0,1) ? 'C' : 'D');

                AngketJawaban::updateOrCreate(
                    [
                        'event_id'   => $event->id,
                        'peserta_id' => $pesertaId,
                        'item_id'    => $item->id,
                    ],
                    [
                        'jawaban' => $jawaban
                    ]
                );
            }

            // Peserta also fills Komentar
            AngketKomentar::updateOrCreate(
                [
                    'event_id'   => $event->id,
                    'peserta_id' => $pesertaId,
                ],
                [
                    'komentar' => $komentarSamples[array_rand($komentarSamples)]
                ]
            );
        }
    }
}
