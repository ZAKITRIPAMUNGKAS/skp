<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\EventSesi;
use App\Models\Absensi;
use App\Models\User;

class AbsensiSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();
        if (!$event) return;

        $admin = User::where('role', 'admin')->first();
        $pesertas = EventPeserta::where('event_id', $event->id)->get();
        $sesis = EventSesi::where('event_id', $event->id)->orderBy('urutan')->get();

        foreach ($sesis as $sesiIndex => $sesi) {
            $waktuMulai = Carbon::parse($event->tanggal_mulai)->addHours(8 + $sesiIndex * 2);
            
            foreach ($pesertas as $pesertaIndex => $ep) {
                // Simulasikan tingkat kehadiran 90% (1 dari 10 peluang absen sesi)
                // Tetapi mari kita buat 5 peserta teratas menghadiri semua sesi untuk skor SAW yang berbeda
                if ($pesertaIndex > 4 && rand(1, 10) > 9) {
                    continue;
                }

                $scanTime = $waktuMulai->copy()->addMinutes(rand(-15, 10))->addSeconds(rand(0, 59));

                Absensi::create([
                    'event_id'   => $event->id,
                    'sesi_id'    => $sesi->id,
                    'peserta_id' => $ep->peserta_id,
                    'waktu_scan' => $scanTime,
                    'scanned_by' => $admin->id ?? 1,
                ]);
            }
        }
    }
}
