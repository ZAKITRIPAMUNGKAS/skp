<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ImportParticipantService
{
    public function import(UploadedFile $file, Event $event, string $duplicateAction = 'update'): array
    {
        $imported = 0;
        $skipped = 0;
        $errors = [];

        $rows = $this->parseFile($file);

        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                // Ekstrak data
                $namaLengkap = strip_tags(trim($row['nama_lengkap'] ?? ''));
                $email       = filter_var(trim($row['email'] ?? ''), FILTER_SANITIZE_EMAIL);
                $noHp        = strip_tags(trim($row['no_hp'] ?? ''));
                if (str_ends_with($noHp, '.0')) {
                    $noHp = substr($noHp, 0, -2);
                }
                $unitKerja   = strip_tags(trim($row['unit_kerja'] ?? ''));
                $nik         = strip_tags(trim($row['nik'] ?? ''));
                if (str_ends_with($nik, '.0')) {
                    $nik = substr($nik, 0, -2);
                }

                if (empty($namaLengkap)) {
                    $skipped++;
                    continue;
                }

                // Normalisasi Email jika kosong
                if (empty($email)) {
                    $usernameTmp = $this->generateUsername($namaLengkap);
                    $email = $nik ? ($nik . '@arqam.test') : ($usernameTmp . '@arqam.test');
                }

                // Cari peserta berdasarkan NIK, lalu email
                $existingPeserta = null;
                if (!empty($nik)) {
                    $existingPeserta = Peserta::where('nik', $nik)->first();
                }
                if (!$existingPeserta && !empty($email) && !str_ends_with($email, '@arqam.test')) {
                    $existingPeserta = Peserta::where('email', $email)->first();
                }
                if (!$existingPeserta) {
                    $existingPeserta = Peserta::where('email', $email)->first();
                }

                // ── Normalisasi Konfirmasi Kesediaan ─────────────────────────
                // Desain: SEMUA peserta dicatat di event_peserta.
                // - bersedia/belum_konfirmasi → status_aktif = true
                // - tidak_bersedia            → status_aktif = false
                // Ini memastikan alasan, surat, dan track record per-event
                // tetap tersimpan dan bisa difilter.
                $kesediaanRaw = strtolower(trim($row['konfirmasi_kesediaan'] ?? ''));
                $kesediaan = 'belum_konfirmasi';
                if (str_contains($kesediaanRaw, 'tidak') || str_contains($kesediaanRaw, 'absen')) {
                    $kesediaan = 'tidak_bersedia';
                } elseif (str_contains($kesediaanRaw, 'ya') || str_contains($kesediaanRaw, 'bersedia') || str_contains($kesediaanRaw, 'hadir')) {
                    $kesediaan = 'bersedia';
                }
                $statusAktif = ($kesediaan !== 'tidak_bersedia');

                // ── Jenis Kelamin ─────────────────────────────────────────────
                $jkRaw = strtolower(trim($row['jenis_kelamin'] ?? ''));
                $jk = null;
                if (str_contains($jkRaw, 'laki') || $jkRaw === 'l') {
                    $jk = 'L';
                } elseif (str_contains($jkRaw, 'perempuan') || $jkRaw === 'p' || str_contains($jkRaw, 'wanita')) {
                    $jk = 'P';
                }

                // ── Umur ──────────────────────────────────────────────────────
                $umurRaw = trim(strval($row['umur'] ?? ''));
                $umur = null;
                if (!empty($umurRaw)) {
                    preg_match('/\d+/', $umurRaw, $umurMatches);
                    if (!empty($umurMatches)) {
                        $umur = intval($umurMatches[0]);
                        if (str_contains(strtolower($umurRaw), 'kurang') && $umur > 0) {
                            $umur = $umur - 1;
                        }
                    }
                }

                // ── Jumlah Anak ───────────────────────────────────────────────
                $jumlahAnakRaw = trim(strval($row['jumlah_anak'] ?? ''));
                $jumlahAnak = null;
                if ($jumlahAnakRaw !== '') {
                    preg_match('/\d+/', $jumlahAnakRaw, $anakMatches);
                    if (!empty($anakMatches)) {
                        $jumlahAnak = intval($anakMatches[0]);
                    }
                }

                $alamat = $row['alamat_asal'] ?? $row['alamat_rumah'] ?? null;

                // Parse tempat dan tanggal lahir
                $tempatLahir = null;
                $tanggalLahir = null;
                if (!empty($row['tempat_tanggal_lahir'])) {
                    $ttl = trim($row['tempat_tanggal_lahir']);
                    if (str_contains($ttl, '/')) {
                        $parts = explode('/', $ttl, 2);
                        $tempatLahir = trim($parts[0]);
                        $tglStr = trim($parts[1]);
                    } elseif (str_contains($ttl, ',')) {
                        $parts = explode(',', $ttl, 2);
                        $tempatLahir = trim($parts[0]);
                        $tglStr = trim($parts[1]);
                    } else {
                        $tglStr = $ttl;
                    }
                    if (!empty($tglStr)) {
                        $tanggalLahir = $this->parseIndonesianDate($tglStr);
                    }
                }
                $tempatLahir = $tempatLahir ?: ($row['tempat_lahir'] ?? null);
                $tanggalLahir = $tanggalLahir ?: ($row['tanggal_lahir'] ?? null);

                $dataProfil = [
                    'nama_lengkap'            => $namaLengkap,
                    'nama_panggilan'          => $row['nama_panggilan'] ?? null,
                    'email'                   => $email,
                    'no_hp'                   => $noHp ?: null,
                    'unit_kerja'              => $unitKerja ?: null,
                    'nik'                     => $nik ?: null,
                    'jenis_kelamin'           => $jk,
                    'tempat_lahir'            => $tempatLahir,
                    'tanggal_lahir'           => $tanggalLahir,
                    'jabatan_aum'             => $row['jabatan_aum'] ?? null,
                    'umur'                    => $umur,
                    'status_pernikahan'       => $row['status_pernikahan'] ?? null,
                    'jumlah_anak'             => $jumlahAnak,
                    'alamat_rumah'            => $alamat ?: null,
                    'desa_kelurahan'          => $row['desa_kelurahan'] ?? null,
                    'kecamatan'               => $row['kecamatan'] ?? null,
                    'kabupaten'               => $row['kabupaten'] ?? null,
                    'provinsi'                => $row['provinsi'] ?? null,
                    'ukuran_kaos'             => $row['ukuran_kaos'] ?? null,
                    'rencana_keberangkatan'   => $row['rencana_keberangkatan'] ?? null,
                    'aktivitas_duduk'         => $row['aktivitas_duduk'] ?? null,
                    'aktivitas_tangga'        => $row['aktivitas_tangga'] ?? null,
                    'aktivitas_sholat'        => $row['aktivitas_sholat'] ?? null,
                    'surat_komitmen'          => $row['surat_komitmen'] ?? null,
                    'surat_tidak_bersedia'    => $row['surat_tidak_bersedia'] ?? null,
                    'kemampuan_baca_quran'    => $row['kemampuan_baca_quran'] ?? null,
                    'kompetensi_keberagamaan' => $row['kompetensi_keberagamaan'] ?? null,
                    'kompetensi_akademis'     => $row['kompetensi_akademis'] ?? null,
                    'kompetensi_sosial'       => $row['kompetensi_sosial'] ?? null,
                    'kompetensi_keorganisasian' => $row['kompetensi_keorganisasian'] ?? null,
                    'catatan_makanan'         => $row['catatan_makanan'] ?? null,
                    'catatan_kesehatan'       => $row['catatan_kesehatan'] ?? null,
                    'catatan_panitia'         => $row['catatan_panitia'] ?? null,
                    'keaktifan_ortom'         => $row['keaktifan_ortom'] ?? null,
                    'keaktifan_muhammadiyah'  => $row['keaktifan_muhammadiyah'] ?? null,
                    'foto'                    => $row['foto'] ?? null,
                    'arqam_ke'                => $row['arqam_ke'] ?? null,
                ];

                // ── Payload event_peserta ─────────────────────────────────────
                $epPayload = [
                    'konfirmasi_kesediaan' => $kesediaan,
                    'alasan_tidak_hadir'   => $row['alasan_tidak_hadir'] ?? null,
                    'surat_tidak_hadir'    => $row['surat_tidak_hadir'] ?? null,
                    'status_aktif'         => $statusAktif,
                ];

                // ── Kasus A: Peserta sudah ada di database ────────────────────
                if ($existingPeserta) {
                    // Jangan timpa email jika email baru adalah email fallback (@arqam.test)
                    // dan email lama adalah email asli (tidak berakhiran @arqam.test)
                    if (str_ends_with($email, '@arqam.test') && !empty($existingPeserta->email) && !str_ends_with($existingPeserta->email, '@arqam.test')) {
                        unset($dataProfil['email']);
                    }
                    // Selalu update data profil (kecuali email jika email lama asli sedangkan email baru fallback)
                    $existingPeserta->update($dataProfil);

                    $alreadyInEvent = EventPeserta::where('event_id', $event->id)
                        ->where('peserta_id', $existingPeserta->id)
                        ->first();

                    if ($alreadyInEvent) {
                        // Sudah ada di event — update atau skip sesuai mode
                        if ($duplicateAction === 'update') {
                            $token  = hash_hmac('sha256', $event->id . '-' . $existingPeserta->id, config('app.key'));
                            $qrCode = base64_encode(json_encode(['e' => $event->id, 'p' => $existingPeserta->id, 't' => $token]));
                            $alreadyInEvent->update(array_merge($epPayload, [
                                'qr_code' => $qrCode
                            ]));
                            $imported++;
                        } else {
                            $skipped++;
                        }
                        continue;
                    }

                    // Belum ada di event — daftarkan (semua status, termasuk tidak_bersedia)
                    $token  = hash_hmac('sha256', $event->id . '-' . $existingPeserta->id, config('app.key'));
                    $qrCode = base64_encode(json_encode(['e' => $event->id, 'p' => $existingPeserta->id, 't' => $token]));
                    EventPeserta::create(array_merge($epPayload, [
                        'event_id'   => $event->id,
                        'peserta_id' => $existingPeserta->id,
                        'qr_code'    => $qrCode,
                    ]));
                    $imported++;
                    continue;
                }

                // ── Kasus B: Peserta baru ─────────────────────────────────────
                $defaultPassword = config('app.default_participant_password', 'peserta123');
                $emailForUsername = !empty($email) && !str_ends_with($email, '@arqam.test') ? $email : null;
                
                // Username default menggunakan NIK jika ada, jika tidak generate dari nama
                $username = !empty($nik) ? preg_replace('/[^a-zA-Z0-9._-]/', '', $nik) : $this->generateUsername($namaLengkap, $emailForUsername);
                $originalUsername = $username;
                $counter = 1;
                while (User::where('username', $username)->exists()) {
                    $username = $originalUsername . $counter;
                    $counter++;
                }

                // Password default menggunakan tanggal lahir (ddmmyyyy) jika ada, jika tidak pakai defaultPassword
                $passwordRaw = $defaultPassword;
                if (!empty($tanggalLahir)) {
                    $passwordRaw = date('dmY', strtotime($tanggalLahir));
                }

                $user = User::create([
                    'name'     => $namaLengkap,
                    'email'    => $email,
                    'username' => $username,
                    'password' => Hash::make($passwordRaw),
                    'role'     => 'peserta',
                ]);

                $dataProfil['user_id'] = $user->id;
                $peserta = Peserta::create($dataProfil);

                // Daftarkan ke event (semua status — tidak_bersedia dengan status_aktif=false)
                $token  = hash_hmac('sha256', $event->id . '-' . $peserta->id, config('app.key'));
                $qrCode = base64_encode(json_encode(['e' => $event->id, 'p' => $peserta->id, 't' => $token]));
                EventPeserta::create(array_merge($epPayload, [
                    'event_id'   => $event->id,
                    'peserta_id' => $peserta->id,
                    'qr_code'    => $qrCode,
                ]));

                $imported++;
            }


            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return [
            'imported' => $imported,
            'skipped'  => $skipped,
            'errors'   => $errors,
        ];
    }

    public function generateUsername(string $name, ?string $email = null): string
    {
        if (!empty($email) && strpos($email, '@') !== false && !str_ends_with($email, '@arqam.test')) {
            $base = strstr($email, '@', true);
            // Bersihkan dari karakter aneh selain huruf, angka, dot, dash, underscore
            $base = preg_replace('/[^a-zA-Z0-9._-]/', '', $base);
        } else {
            $base = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($name));
            if (empty($base)) {
                $base = 'peserta';
            }
        }
        
        $username = $base;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $base . $counter;
            $counter++;
        }
        
        return $username;
    }

    private function parseFile(UploadedFile $file): array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $rawData = [];

        if (in_array($extension, ['csv', 'txt'])) {
            $handle = fopen($file->getPathname(), 'r');
            // Lewati BOM jika ada
            $bom = fread($handle, 3);
            if ($bom !== chr(0xEF) . chr(0xBB) . chr(0xBF)) {
                rewind($handle);
            }
            $header = fgetcsv($handle);
            if (!$header) {
                fclose($handle);
                return [];
            }
            
            while (($data = fgetcsv($handle)) !== false) {
                $rawData[] = array_combine(range(0, count($header) - 1), array_slice($data, 0, count($header)));
            }
            fclose($handle);
        } else {
            // Gunakan Maatwebsite Excel untuk read xlsx/xls
            // Kita tidak mengimplementasikan WithMultipleSheets agar semua sheet dibaca
            $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new class {}, $file);

            // Cari sheet dengan kecocokan kolom terbanyak
            $bestSheet = [];
            $bestScore = -1;
            
            foreach ($sheets as $sIndex => $currentSheet) {
                if (empty($currentSheet) || !isset($currentSheet[0])) {
                    continue;
                }
                
                $headerRow = $currentSheet[0];
                $score = 0;
                $cleanedHeaders = array_map(function($h) {
                    return strtolower(trim(preg_replace('/[^a-zA-Z0-9;_]/', ' ', strval($h))));
                }, $headerRow);
                
                foreach ($cleanedHeaders as $h) {
                    if (empty($h)) continue;
                    if (str_contains($h, 'nama lengkap') || $h === 'nama_lengkap' || $h === 'nama') {
                        $score += 10;
                    } elseif ($h === 'nik') {
                        // Kolom NIK standalone (bukan gabungan no;nik;nama;homebase)
                        $score += 8;
                    } elseif (str_contains($h, 'homebase') || str_contains($h, 'unit kerja') || str_contains($h, 'aum')) {
                        $score += 5;
                    } elseif (str_contains($h, 'nomer induk') || str_contains($h, 'kependidikan')) {
                        $score += 5;
                    } elseif (str_contains($h, 'email')) {
                        $score += 5;
                    } elseif (str_contains($h, 'no hp') || str_contains($h, 'nomer wa') || $h === 'no_hp' || str_contains($h, 'telepon')) {
                        $score += 5;
                    } elseif (str_contains($h, 'alamat')) {
                        $score += 2;
                    } elseif (str_contains($h, 'kesediaan')) {
                        $score += 5;
                    }
                }
                
                if ($score > $bestScore) {
                    $bestScore = $score;
                    $bestSheet = $currentSheet;
                }
            }

            $sheet = !empty($bestSheet) ? $bestSheet : ($sheets[0] ?? []);
            if (empty($sheet)) {
                return [];
            }
            
            $header = $sheet[0];
            for ($i = 1; $i < count($sheet); $i++) {
                if (isset($sheet[$i]) && count($sheet[$i]) > 0) {
                    // Pastikan baris memiliki data (tidak kosong sama sekali)
                    $hasData = false;
                    foreach ($sheet[$i] as $val) {
                        if ($val !== null && trim(strval($val)) !== '') {
                            $hasData = true;
                            break;
                        }
                    }
                    if ($hasData) {
                        $rawData[] = $sheet[$i];
                    }
                }
            }
        }

        return $this->mapHeadersToKeys($header, $rawData);
    }

    private function mapHeadersToKeys(array $headers, array $rawData): array
    {
        // Bersihkan header
        $cleanedHeaders = array_map(function($h) {
            return strtolower(trim(preg_replace('/[^a-zA-Z0-9;_]/', ' ', strval($h))));
        }, $headers);

        $mappedRows = [];
        
        foreach ($rawData as $row) {
            $mappedRow = [];
            foreach ($cleanedHeaders as $idx => $header) {
                $val = $row[$idx] ?? null;

                // Cek kolom "No;NIK;Nama;Homebase" gabungan
                if (str_contains($header, 'no;nik;nama;homebase') && !empty($val)) {
                    $parts = explode(';', $val);
                    if (count($parts) >= 4) {
                        if (empty($mappedRow['nik']))        $mappedRow['nik']        = trim($parts[1]);
                        if (empty($mappedRow['nama_lengkap'])) $mappedRow['nama_lengkap'] = trim($parts[2]);
                        if (empty($mappedRow['unit_kerja'])) $mappedRow['unit_kerja'] = trim($parts[3]);
                    }
                    continue;
                }

                // Mapping dinamis menggunakan kata kunci
                if (str_contains($header, 'nama lengkap') || str_contains($header, 'nama dengan gelar') || $header === 'nama_lengkap') {
                    $mappedRow['nama_lengkap'] = $val;
                } elseif (str_contains($header, 'nama panggilan') || $header === 'nama_panggilan' || $header === 'panggilan') {
                    $mappedRow['nama_panggilan'] = $val;
                } elseif ($header === 'nama' || str_contains($header, 'nama')) {
                    // Kolom "Nama" standalone — jangan timpa yang sudah ada dari kolom gabungan
                    if (empty($mappedRow['nama_lengkap'])) $mappedRow['nama_lengkap'] = $val;
                } elseif (str_contains($header, 'tempat tanggal lahir') || str_contains($header, 'tempat/tanggal lahir') || str_contains($header, 'ttl')) {
                    $mappedRow['tempat_tanggal_lahir'] = $val;
                } elseif (str_contains($header, 'status kepegawaian') || str_contains($header, 'status_kepegawaian') || str_contains($header, 'status dosen') || str_contains($header, 'status_dosen')) {
                    $mappedRow['jabatan_aum'] = $val;
                } elseif (str_contains($header, 'jml ba') || str_contains($header, 'ba terakhir') || str_contains($header, 'jumlah ba')) {
                    $mappedRow['arqam_ke'] = $val;
                } elseif ($header === 'nik') {
                    // NIK standalone — jangan timpa yang sudah diset dari kolom gabungan
                    if (empty($mappedRow['nik'])) $mappedRow['nik'] = $val;
                } elseif (str_contains($header, 'email') || $header === 'email_address' || $header === 'email address') {
                    $mappedRow['email'] = $val;
                } elseif (str_contains($header, 'no hp') || str_contains($header, 'nomer wa') || $header === 'no_hp' || $header === 'no hp') {
                    $mappedRow['no_hp'] = $val;
                } elseif ($header === 'homebase' || str_contains($header, 'homebase') || str_contains($header, 'unit') || str_contains($header, 'aum')) {
                    if (empty($mappedRow['unit_kerja'])) $mappedRow['unit_kerja'] = $val;
                } elseif (str_contains($header, 'jenis kelamin') || $header === 'jenis_kelamin') {
                    $mappedRow['jenis_kelamin'] = $val;
                } elseif (str_contains($header, 'alamat asal') || str_contains($header, 'alamat rumah') || $header === 'alamat') {
                    $mappedRow['alamat_asal'] = $val;
                } elseif (str_contains($header, 'dukuh') || str_contains($header, 'rt rw') || str_contains($header, 'rt/rw')) {
                    // Dukuh, Rt/Rw — simpan ke alamat_detail (akan digabung ke alamat_rumah jika kosong)
                    $mappedRow['alamat_detail'] = $val;
                } elseif (str_contains($header, 'kalurahan') || str_contains($header, 'desa') || $header === 'desa_kelurahan') {
                    $mappedRow['desa_kelurahan'] = $val;
                } elseif (str_contains($header, 'kecamatan')) {
                    $mappedRow['kecamatan'] = $val;
                } elseif (str_contains($header, 'kabupaten') || str_contains($header, 'kota')) {
                    $mappedRow['kabupaten'] = $val;
                } elseif (str_contains($header, 'propinsi') || str_contains($header, 'provinsi')) {
                    $mappedRow['provinsi'] = $val;
                } elseif (str_contains($header, 'umur')) {
                    $mappedRow['umur'] = $val;
                } elseif (str_contains($header, 'pernikahan') || str_contains($header, 'menikah')) {
                    $mappedRow['status_pernikahan'] = $val;
                } elseif (str_contains($header, 'jumlah anak') || str_contains($header, 'jumlah_anak')) {
                    $mappedRow['jumlah_anak'] = $val;
                } elseif ($header === 'anak') {
                    if (empty($mappedRow['jumlah_anak'])) $mappedRow['jumlah_anak'] = $val;
                } elseif (str_contains($header, 'keterlibatan') || str_contains($header, 'di ranting')) {
                    // "Tuliskan Keterlibatan Bapak/Ibu di Ranting Muhammadiyah/Aisyiyah/Ortom..."
                    // Harus dicek SEBELUM rule 'ortom', karena header ini juga mengandung kata 'ortom'
                    if (empty($mappedRow['keaktifan_muhammadiyah'])) {
                        $mappedRow['keaktifan_muhammadiyah'] = $val;
                    }
                } elseif (str_contains($header, 'ortom') && !str_contains($header, 'keterlibatan') && !str_contains($header, 'ranting')) {
                    // "Pernah/sedang aktif di Ortom" — bukan kolom Keterlibatan
                    $mappedRow['keaktifan_ortom'] = $val;
                } elseif (str_contains($header, 'persyarikatan') || (str_contains($header, 'muhammadiyah') && !str_contains($header, 'mengikuti')) || str_contains($header, 'aisyiyah')) {
                    if (empty($mappedRow['keaktifan_muhammadiyah'])) $mappedRow['keaktifan_muhammadiyah'] = $val;
                } elseif (str_contains($header, 'baca') && (str_contains($header, 'quran') || str_contains($header, 'qur an') || str_contains($header, 'qur'))) {
                    $mappedRow['kemampuan_baca_quran'] = $val;
                } elseif (str_contains($header, 'kesediaan')) {
                    $mappedRow['konfirmasi_kesediaan'] = $val;
                } elseif (str_contains($header, 'sebab')) {
                    $mappedRow['alasan_tidak_hadir'] = $val;
                } elseif ((str_contains($header, 'tidak bersedia') || str_contains($header, 'pernyataan tidak')) && (str_contains($header, 'unggah') || str_contains($header, 'surat'))) {
                    $mappedRow['surat_tidak_bersedia'] = $val;
                    $mappedRow['surat_tidak_hadir']   = $val;
                } elseif ((str_contains($header, 'komitmen')) && (str_contains($header, 'unggah') || str_contains($header, 'surat') || str_contains($header, 'pernyataan'))) {
                    $mappedRow['surat_komitmen'] = $val;
                } elseif (str_contains($header, 'kaos')) {
                    $mappedRow['ukuran_kaos'] = $val;
                } elseif (str_contains($header, 'keberangkatan')) {
                    $mappedRow['rencana_keberangkatan'] = $val;
                } elseif (str_contains($header, 'duduk')) {
                    $mappedRow['aktivitas_duduk'] = $val;
                } elseif (str_contains($header, 'tangga')) {
                    $mappedRow['aktivitas_tangga'] = $val;
                } elseif (str_contains($header, 'sholat')) {
                    $mappedRow['aktivitas_sholat'] = $val;
                } elseif (str_contains($header, 'keberagamaan')) {
                    $mappedRow['kompetensi_keberagamaan'] = $val;
                } elseif (str_contains($header, 'akademis')) {
                    $mappedRow['kompetensi_akademis'] = $val;
                } elseif (str_contains($header, 'sosial')) {
                    $mappedRow['kompetensi_sosial'] = $val;
                } elseif (str_contains($header, 'keorganisasian') || str_contains($header, 'kepemimpinan')) {
                    $mappedRow['kompetensi_keorganisasian'] = $val;
                } elseif (str_contains($header, 'makanan')) {
                    $mappedRow['catatan_makanan'] = $val;
                } elseif (str_contains($header, 'kesehatan')) {
                    $mappedRow['catatan_kesehatan'] = $val;
                } elseif (
                    str_contains($header, 'hal lain') ||
                    str_contains($header, 'hal hal lain') ||  // setelah cleaning, tanda hubung jadi spasi
                    str_contains($header, 'kepada panitia')
                ) {
                    $mappedRow['catatan_panitia'] = $val;
                } elseif (str_contains($header, 'foto') || str_contains($header, 'idcard')) {
                    $mappedRow['foto'] = $val;
                } elseif (str_contains($header, 'mengikuti') && str_contains($header, 'arqam')) {
                    // "Mengikuti Baitul Arqam Dosen UMS ke-" — setelah cleaning: "mengikuti baitul arqam dosen ums ke"
                    $mappedRow['arqam_ke'] = $val;
                }
                // Kolom diabaikan: Timestamp, No (nomor urut)
            }

            // Jika ada alamat_detail tapi alamat_asal kosong, gabungkan
            if (!empty($mappedRow['alamat_detail']) && empty($mappedRow['alamat_asal'])) {
                $parts = [];
                if (!empty($mappedRow['alamat_detail'])) $parts[] = $mappedRow['alamat_detail'];
                if (!empty($mappedRow['desa_kelurahan'])) $parts[] = $mappedRow['desa_kelurahan'];
                if (!empty($mappedRow['kecamatan']))       $parts[] = $mappedRow['kecamatan'];
                if (!empty($mappedRow['kabupaten']))       $parts[] = $mappedRow['kabupaten'];
                if (!empty($mappedRow['provinsi']))        $parts[] = $mappedRow['provinsi'];
                $mappedRow['alamat_asal'] = implode(', ', array_filter($parts));
            }
            unset($mappedRow['alamat_detail']);

            $mappedRows[] = $mappedRow;
        }

        return $mappedRows;
    }

    public function parseIndonesianDate($dateStr)
    {
        if (empty($dateStr)) {
            return null;
        }

        $dateStr = strtolower(trim($dateStr));
        
        $months = [
            'januari' => 'january', 'februari' => 'february', 'maret' => 'march',
            'april' => 'april', 'mei' => 'may', 'juni' => 'june',
            'juli' => 'july', 'agustus' => 'august', 'september' => 'september',
            'oktober' => 'october', 'november' => 'november', 'desember' => 'december',
            // Singkatan
            'jan' => 'january', 'feb' => 'february', 'mar' => 'march',
            'apr' => 'april', 'jun' => 'june', 'jul' => 'july',
            'agt' => 'august', 'ags' => 'august', 'agu' => 'august',
            'sep' => 'september', 'okt' => 'october', 'nov' => 'november',
            'des' => 'december'
        ];

        foreach ($months as $id => $en) {
            if (str_contains($dateStr, $id)) {
                $dateStr = str_replace($id, $en, $dateStr);
                break;
            }
        }

        try {
            return \Illuminate\Support\Carbon::parse($dateStr)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
