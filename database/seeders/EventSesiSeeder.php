<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventSesi;

class EventSesiSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();
        if (!$event) return;

        $sesi = [
            ['nama_sesi' => 'Pembukaan & Orientasi BA'],
            ['nama_sesi' => 'Materi 1: Ideologi Muhammadiyah'],
            ['nama_sesi' => 'Materi 2: Pedoman Hidup Islami Warga Muhammadiyah (PHIWM)'],
            ['nama_sesi' => 'Praktik Ibadah & Tahsin'],
            ['nama_sesi' => 'Dinamika Kelompok & Outbound'],
            ['nama_sesi' => 'Penutupan, RTL, & Pembagian Sertifikat'],
        ];

        foreach ($sesi as $i => $s) {
            EventSesi::create(array_merge($s, [
                'event_id' => $event->id, 
                'urutan' => $i + 1
            ]));
        }
    }
}
