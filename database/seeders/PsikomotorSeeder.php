<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\PsikomotorTemplate;

class PsikomotorSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();
        if (!$event) return;

        $templates = [
            'Praktik Wudhu dan Tayamum' => 'ibadah',
            'Praktik Shalat Fardhu & Jama Qashar' => 'ibadah',
            'Praktik Penyelenggaraan Jenazah' => 'ibadah',
            'Tahsin / Kemampuan Membaca Al-Quran' => 'ibadah',
        ];

        foreach ($templates as $nama => $jenis) {
            PsikomotorTemplate::create([
                'event_id'   => $event->id,
                'nama_aspek' => $nama,
                'jenis'      => $jenis,
                'skor_maks'  => 4
            ]);
        }
    }
}
