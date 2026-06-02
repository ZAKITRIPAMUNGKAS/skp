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
    public function import(UploadedFile $file, Event $event, string $duplicateAction = 'skip'): array
    {
        $imported = 0;
        $skipped = 0;
        $errors = [];

        $rows = $this->parseFile($file);

        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                $namaLengkap = strip_tags(trim($row['nama_lengkap'] ?? ''));
                $email       = filter_var(trim($row['email'] ?? ''), FILTER_SANITIZE_EMAIL);
                $noHp        = strip_tags(trim($row['no_hp'] ?? ''));
                $unitKerja   = strip_tags(trim($row['unit_kerja'] ?? ''));

                if (empty($namaLengkap) || empty($email)) {
                    $skipped++;
                    continue;
                }

                // Periksa duplikat dalam event
                $existingPeserta = Peserta::where('email', $email)->first();

                if ($existingPeserta) {
                    $alreadyInEvent = EventPeserta::where('event_id', $event->id)
                        ->where('peserta_id', $existingPeserta->id)
                        ->exists();

                    if ($alreadyInEvent) {
                        if ($duplicateAction === 'update') {
                            $existingPeserta->update([
                                'nama_lengkap' => $namaLengkap,
                                'no_hp'        => $noHp ?: $existingPeserta->no_hp,
                                'unit_kerja'   => $unitKerja ?: $existingPeserta->unit_kerja,
                            ]);
                            $imported++;
                        } else {
                            $skipped++;
                        }
                        continue;
                    }

                    // Peserta exists but not in this event — add to event
                    $token = hash_hmac('sha256', $event->id . '-' . $existingPeserta->id, config('app.key'));
                    $qrCode = base64_encode(json_encode(['e' => $event->id, 'p' => $existingPeserta->id, 't' => $token]));
                    EventPeserta::create([
                        'event_id'     => $event->id,
                        'peserta_id'   => $existingPeserta->id,
                        'qr_code'      => $qrCode,
                        'status_aktif' => true,
                    ]);
                    $imported++;
                    continue;
                }

                // Create new user + peserta
                $defaultPassword = config('app.default_participant_password', 'peserta123');
                
                // Buat username unik dari inisial atau slug
                $username = $this->generateUsername($namaLengkap);

                $user = User::create([
                    'name'     => $namaLengkap,
                    'email'    => $email ?: $username . '@arqam.test',
                    'username' => $username,
                    'password' => Hash::make($defaultPassword),
                    'role'     => 'peserta',
                ]);

                $peserta = Peserta::create([
                    'user_id'      => $user->id,
                    'nama_lengkap' => $namaLengkap,
                    'email'        => $email ?: $user->email,
                    'no_hp'        => $noHp ?: null,
                    'unit_kerja'   => $unitKerja ?: null,
                ]);

                $token = hash_hmac('sha256', $event->id . '-' . $peserta->id, config('app.key'));
                $qrCode = base64_encode(json_encode(['e' => $event->id, 'p' => $peserta->id, 't' => $token]));
                EventPeserta::create([
                    'event_id'     => $event->id,
                    'peserta_id'   => $peserta->id,
                    'qr_code'      => $qrCode,
                    'status_aktif' => true,
                ]);

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

    private function generateUsername(string $name): string
    {
        $words = explode(' ', strtolower($name));
        $initials = '';
        foreach ($words as $w) {
            if (!empty($w)) $initials .= $w[0];
        }

        // Jika inisial terlalu pendek, gunakan slug
        $base = (strlen($initials) >= 2) ? $initials : Str::slug($name, '');
        
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
        $extension = $file->getClientOriginalExtension();
        $rows = [];

        if (in_array($extension, ['csv', 'txt'])) {
            $handle = fopen($file->getPathname(), 'r');
            // Lewati BOM
            $bom = fread($handle, 3);
            if ($bom !== chr(0xEF) . chr(0xBB) . chr(0xBF)) {
                rewind($handle);
            }
            $header = fgetcsv($handle);
            $header = array_map('trim', array_map('strtolower', $header));
            
            // Validasi header
            $expected = ['nama_lengkap', 'email', 'no_hp', 'unit_kerja'];
            if (count(array_intersect($expected, $header)) !== count($expected)) {
                fclose($handle);
                throw new \Exception('Format file tidak sesuai template. Silakan download template terlebih dahulu.');
            }

            while (($data = fgetcsv($handle)) !== false) {
                $row = [];
                foreach ($header as $i => $col) {
                    $row[$col] = $data[$i] ?? '';
                }
                $rows[] = $row;
            }
            fclose($handle);
        } else {
            // Gunakan Maatwebsite Excel untuk xlsx/xls
            $collection = \Maatwebsite\Excel\Facades\Excel::toArray(new class implements \Maatwebsite\Excel\Concerns\WithMultipleSheets {
                public function sheets(): array { return [0 => new class implements \Maatwebsite\Excel\Concerns\ToArray { public function array(array $array) { return $array; } }]; }
            }, $file);
            if (!empty($collection[0])) {
                $sheet = $collection[0];
                $header = array_map('trim', array_map('strtolower', $sheet[0]));
                
                // Validasi header
                $expected = ['nama_lengkap', 'email', 'no_hp', 'unit_kerja'];
                if (count(array_intersect($expected, $header)) !== count($expected)) {
                    throw new \Exception('Format file tidak sesuai template. Silakan download template terlebih dahulu.');
                }

                for ($i = 1; $i < count($sheet); $i++) {
                    $row = [];
                    foreach ($header as $j => $col) {
                        $row[$col] = $sheet[$i][$j] ?? '';
                    }
                    $rows[] = $row;
                }
            }
        }

        return $rows;
    }
}
