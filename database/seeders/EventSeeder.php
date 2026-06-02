<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        
        Event::create([
            'nama_event' => 'Baitul Arqam Dosen & Tendik 2026',
            'tanggal_mulai' => '2026-06-01',
            'tanggal_selesai' => '2026-06-03',
            'lokasi' => 'Gedung Pusdiklat Muhammadiyah',
            'deskripsi' => 'Pelatihan intensif kemuhammadiyahan untuk dosen dan tenaga kependidikan meliputi materi aqidah, ibadah, akhlak, dan dinamika persyarikatan.',
            'status' => 'persiapan',
            'created_by' => $admin->id ?? 1,
        ]);
    }
}
