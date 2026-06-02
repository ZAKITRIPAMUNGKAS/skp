<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Peserta;
use App\Models\Event;
use App\Models\EventPeserta;

class PesertaSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();
        if (!$event) return;

        $pesertas = [
            ['nama' => 'Dr. Ahmad Fauzi, M.Pd.', 'email' => 'ahmad.fauzi@arqam.test', 'unit' => 'Fakultas Keguruan dan Ilmu Pendidikan'],
            ['nama' => 'Siti Aminah, S.Kom., M.Kom.', 'email' => 'siti.aminah@arqam.test', 'unit' => 'Fakultas Teknik'],
            ['nama' => 'Budi Santoso, S.E., M.Si.', 'email' => 'budi.santoso@arqam.test', 'unit' => 'Fakultas Ekonomi dan Bisnis'],
            ['nama' => 'Dr. Rina Wati, M.Kes.', 'email' => 'rina.wati@arqam.test', 'unit' => 'Fakultas Ilmu Kesehatan'],
            ['nama' => 'Prof. Dr. H. Hasan Bisri, M.Ag.', 'email' => 'hasan.bisri@arqam.test', 'unit' => 'Fakultas Agama Islam'],
            ['nama' => 'Dewi Lestari, S.H., M.H.', 'email' => 'dewi.lestari@arqam.test', 'unit' => 'Fakultas Hukum'],
            ['nama' => 'Agus Rahman, S.IP., M.A.', 'email' => 'agus.rahman@arqam.test', 'unit' => 'Fakultas Ilmu Sosial dan Ilmu Politik'],
            ['nama' => 'Nurul Hidayati, S.Si., M.Sc.', 'email' => 'nurul.hidayati@arqam.test', 'unit' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam'],
            ['nama' => 'Arif Budiman, S.T., M.T.', 'email' => 'arif.budiman@arqam.test', 'unit' => 'Fakultas Teknik'],
            ['nama' => 'Indah Purnamasari, S.Psi., M.A.', 'email' => 'indah.purnama@arqam.test', 'unit' => 'Fakultas Psikologi']
        ];

        foreach ($pesertas as $index => $p) {
            $user = User::create([
                'name'     => $p['nama'],
                'email'    => $p['email'],
                'password' => Hash::make('password'),
                'role'     => 'peserta',
            ]);

            $peserta = Peserta::create([
                'user_id'      => $user->id,
                'nama_lengkap' => $p['nama'],
                'email'        => $p['email'],
                'no_hp'        => '0812345670' . sprintf('%02d', $index + 1),
                'unit_kerja'   => $p['unit'],
            ]);

            $token = hash_hmac('sha256', $event->id . '-' . $peserta->id, config('app.key'));
            $qrCode = base64_encode(json_encode([
                'e' => $event->id,
                'p' => $peserta->id,
                't' => $token
            ]));

            EventPeserta::create([
                'event_id'     => $event->id,
                'peserta_id'   => $peserta->id,
                'qr_code'      => $qrCode,
                'status_aktif' => true,
            ]);
        }
    }
}
