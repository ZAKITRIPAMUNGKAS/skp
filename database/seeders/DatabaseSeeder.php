<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            EventSeeder::class,
            EventSesiSeeder::class,
            PesertaSeeder::class,
            SoalSeeder::class,
            AfektifSeeder::class,
            PsikomotorSeeder::class,
            AngketSeeder::class,
            AbsensiSeeder::class,
            TesJawabanSeeder::class,
            AfektifJawabanSeeder::class,
            PsikomotorNilaiSeeder::class,
            AngketJawabanSeeder::class,
            PenilaianAkhirSeeder::class,
        ]);
    }
}
