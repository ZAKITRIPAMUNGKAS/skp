<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Peserta;
use App\Models\User;
use App\Models\EventPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventRegistrationController extends Controller
{
    public function show(string $token)
    {
        $event = Event::where('registration_token', $token)->firstOrFail();
        
        if ($event->status === 'selesai') {
            return view('registration.closed', compact('event'));
        }

        return view('registration.form', compact('event'));
    }

    public function store(Request $request, string $token)
    {
        $event = Event::where('registration_token', $token)->firstOrFail();

        $rules = [
            'konfirmasi_kesediaan' => 'required|in:bersedia,tidak_bersedia',
            'nama_lengkap' => 'required|string|max:255',
            'no_hp'        => 'required|string|max:20',
            'nik'          => 'required|string',
        ];

        if ($request->konfirmasi_kesediaan === 'tidak_bersedia') {
            $rules['alasan_tidak_hadir'] = 'required|string';
        } else {
            $rules = array_merge($rules, [
                'email'        => 'nullable|email|max:255',
                'foto'         => 'nullable|image|max:2048',
                'cropped_foto' => 'nullable|string',
                
                'nama_panggilan'   => 'nullable|string|max:255',
                'arqam_ke'         => 'nullable|string|max:255',
                'provinsi'         => 'nullable|string|max:255',
                'jumlah_anak'      => 'nullable|integer',
                'alamat_rumah'     => 'nullable|string',
                'jenis_kelamin'    => 'nullable|in:L,P',
                'nbm'              => 'nullable|string',
                'jabatan_aum'      => 'nullable|string',
                'tempat_lahir'     => 'nullable|string',
                'tanggal_lahir'    => 'nullable|date',
                'umur'             => 'nullable|integer',
                'status_pernikahan'=> 'nullable|string',
                'desa_kelurahan'   => 'nullable|string',
                'kecamatan'        => 'nullable|string',
                'kabupaten'        => 'nullable|string',
                'pendidikan_terakhir' => 'required|string',
                'pendidikan_sd'    => 'nullable|string',
                'pendidikan_smp'   => 'nullable|string',
                'pendidikan_sma'   => 'nullable|string',
                'pendidikan_s1'    => 'nullable|string',
                'bahasa_dikuasai'  => 'nullable|array',
                'kemampuan_baca_quran' => 'nullable|string',
                'kompetensi_keberagamaan' => 'nullable|string',
                'kompetensi_akademis'     => 'nullable|string',
                'kompetensi_sosial'       => 'nullable|string',
                'kompetensi_keorganisasian'=> 'nullable|string',
                'hafalan_quran_1'  => 'nullable|string',
                'hafalan_quran_2'  => 'nullable|string',
                'aktivitas_sholat_masjid' => 'nullable|string',
                'aktivitas_kajian_agama'  => 'nullable|string',
                'jumlah_buku_agama'       => 'nullable|integer',
                'sumber_info_muhammadiyah' => 'nullable|array',
                'langganan_suara_muhammadiyah' => 'nullable|string',
                'lembaga_zis_diikuti'     => 'nullable|array',
                'tokoh_berpengaruh'       => 'nullable|string',
                'alasan_pilih_tokoh'      => 'nullable|string',
                'keaktifan_muhammadiyah'  => 'nullable|array',
                'keaktifan_ortom'         => 'nullable|array',
                'organisasi_lain'         => 'nullable|string',
                'harapan_mengikuti_ba'    => 'nullable|string',
                'ukuran_kaos'             => 'nullable|string',
                'rencana_keberangkatan'   => 'nullable|string',
                'aktivitas_duduk'         => 'nullable|string',
                'aktivitas_tangga'        => 'nullable|string',
                'aktivitas_sholat'        => 'nullable|string',
                'catatan_makanan'         => 'nullable|string',
                'catatan_kesehatan'       => 'nullable|string',
            ]);
        }

        $request->validate($rules);

        // 1. Tangani pembuatan User (jika email disediakan) atau cari yang sudah ada
        $email = $request->email;
        $nameForUsername = !empty($request->nama_panggilan) ? $request->nama_panggilan : explode(' ', trim($request->nama_lengkap))[0];
        $username = $this->generateUsername($nameForUsername, $email);
        if (empty($email)) {
            $email = $username . '@arqam.test';
        }
        
        $password = config('app.default_participant_password', 'peserta123');
        if (!empty($request->nik)) {
            $cleanedNik = preg_replace('/[^0-9]/', '', $request->nik);
            if (strlen($cleanedNik) >= 4) {
                $password = substr($cleanedNik, -4);
            } elseif (strlen($cleanedNik) > 0) {
                $password = $cleanedNik;
            }
        }

        $user = User::where('email', $email)->orWhere('username', $username)->first();

        if (!$user) {
            $user = User::create([
                'name'     => $request->nama_lengkap,
                'email'    => $email,
                'username' => $username,
                'password' => Hash::make($password),
                'role'     => 'peserta',
            ]);
        }

        // 2. Handle Peserta creation/update
        $peserta = Peserta::where('user_id', $user->id)->first();
        
        $fotoPath = null;
        if ($request->filled('cropped_foto')) {
            $base64Image = $request->input('cropped_foto');
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $image = substr($base64Image, strpos($base64Image, ',') + 1);
                $type = strtolower($type[1]);

                if (in_array($type, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $image = base64_decode($image);

                    if ($image !== false) {
                        $fileName = 'peserta/' . \Illuminate\Support\Str::random(40) . '.' . $type;
                        if ($peserta && $peserta->foto) {
                            Storage::disk('public')->delete($peserta->foto);
                        }
                        Storage::disk('public')->put($fileName, $image);
                        $fotoPath = $fileName;
                    }
                }
            }
        } elseif ($request->hasFile('foto')) {
            if ($peserta && $peserta->foto) {
                Storage::disk('public')->delete($peserta->foto);
            }
            $fotoPath = $request->file('foto')->store('peserta', 'public');
        }

        $dataPeserta = $request->only([
            'nama_lengkap', 'nama_panggilan', 'email', 'no_hp', 'unit_kerja', 'arqam_ke',
            'alamat_rumah', 'jenis_kelamin', 'nik', 'nbm', 'jabatan_aum',
            'tempat_lahir', 'tanggal_lahir', 'umur', 'status_pernikahan', 'jumlah_anak',
            'provinsi', 'desa_kelurahan', 'pendidikan_terakhir', 'pendidikan_sd', 'pendidikan_smp', 'pendidikan_sma', 'pendidikan_s1',
            'kemampuan_baca_quran', 'kompetensi_keberagamaan', 'kompetensi_akademis', 'kompetensi_sosial', 'kompetensi_keorganisasian',
            'hafalan_quran_1', 'hafalan_quran_2', 'aktivitas_sholat_masjid', 'aktivitas_kajian_agama',
            'langganan_suara_muhammadiyah',
            'tokoh_berpengaruh', 'alasan_pilih_tokoh',
            'organisasi_lain', 'harapan_mengikuti_ba',
            'ukuran_kaos', 'rencana_keberangkatan', 'aktivitas_duduk', 'aktivitas_tangga', 'aktivitas_sholat', 'catatan_makanan', 'catatan_kesehatan'
        ]);

        // Tangani Input Array (Checkbox) - Set null jika tidak ada di request
        $arrayFields = [
            'bahasa_dikuasai', 'sumber_info_muhammadiyah', 
            'lembaga_zis_diikuti', 'keaktifan_muhammadiyah', 'keaktifan_ortom'
        ];
        foreach ($arrayFields as $field) {
            if ($request->has($field)) {
                $dataPeserta[$field] = is_array($request->input($field)) 
                    ? implode(', ', $request->input($field)) 
                    : $request->input($field);
            } else {
                $dataPeserta[$field] = null;
            }
        }

        // Tangani kolom teks/dropdown spesifik
        $dataPeserta['kabupaten'] = $request->kabupaten_name;
        $dataPeserta['kecamatan'] = $request->kecamatan_name;
        
        // Tangani angka teks dari radio
        if ($request->has('jumlah_buku_agama_text')) {
            $dataPeserta['jumlah_buku_agama'] = 0; // Default atau logika untuk mengekstrak angka
            // Sebenarnya, kita bisa menyimpannya sebagai teks jika migrasi mengizinkan string, 
            // tetapi migrasi menetapkan integer untuk jumlah_buku_agama.
            // Saya akan mengambil angka pertama atau hanya menyimpan representasi integer.
            preg_match('/\d+/', $request->jumlah_buku_agama_text, $matches);
            $dataPeserta['jumlah_buku_agama'] = $matches[0] ?? 0;
        }
        
        if ($fotoPath) {
            $dataPeserta['foto'] = $fotoPath;
        }

        if (!$peserta) {
            $dataPeserta['user_id'] = $user->id;
            $peserta = Peserta::create($dataPeserta);
        } else {
            $peserta->update($dataPeserta);
        }

        // 3. Daftarkan ke Event
        $isRegistered = EventPeserta::where('event_id', $event->id)
            ->where('peserta_id', $peserta->id)
            ->exists();

        if (!$isRegistered) {
            $qrToken = hash_hmac('sha256', $event->id . '-' . $peserta->id, config('app.key'));
            $qrCode = base64_encode(json_encode([
                'e' => $event->id,
                'p' => $peserta->id,
                't' => $qrToken
            ]));

            EventPeserta::create([
                'event_id'             => $event->id,
                'peserta_id'           => $peserta->id,
                'qr_code'              => $qrCode,
                'status_aktif'         => true,
                'konfirmasi_kesediaan' => $request->konfirmasi_kesediaan,
                'alasan_tidak_hadir'   => $request->alasan_tidak_hadir,
            ]);
        } else {
            // Update jika sudah terdaftar tapi ingin mengubah konfirmasi
            EventPeserta::where('event_id', $event->id)
                ->where('peserta_id', $peserta->id)
                ->update([
                    'konfirmasi_kesediaan' => $request->konfirmasi_kesediaan,
                    'alasan_tidak_hadir'   => $request->alasan_tidak_hadir,
                ]);
        }

        return redirect()->route('registration.success', [
            'token'    => $token,
            'username' => $username,
            'password' => $password
        ]);
    }

    public function success(string $token)
    {
        $event = Event::where('registration_token', $token)->firstOrFail();
        $username = request('username');
        $password = request('password');

        return view('registration.success', compact('event', 'username', 'password'));
    }

    private function generateUsername($name, $email = null)
    {
        if (!empty($email) && strpos($email, '@') !== false && !str_ends_with($email, '@arqam.test')) {
            $base = strstr($email, '@', true);
            $base = preg_replace('/[^a-zA-Z0-9._-]/', '', $base);
        } else {
            $base = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($name));
            if (empty($base)) {
                $base = 'peserta';
            }
        }
        
        $username = $base;
        $count = 0;
        $original = $username;
        while (User::where('username', $username)->exists()) {
            $count++;
            $username = $original . $count;
        }
        
        return $username;
    }
}
