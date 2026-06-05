<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\Peserta;
use App\Models\User;
use App\Services\ImportParticipantService;
use App\Services\IdCardGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $query = Peserta::with(['user', 'eventPeserta.event'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('unit_kerja', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhereHas('eventPeserta', function($epQuery) use ($search) {
                      $epQuery->where('alasan_tidak_hadir', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('event_id')) {
            $query->whereHas('eventPeserta', function($q) use ($request) {
                $q->where('event_id', $request->event_id);
                if ($request->filled('kesediaan')) {
                    $q->where('konfirmasi_kesediaan', $request->kesediaan);
                }
            });
        } elseif ($request->filled('kesediaan')) {
            $query->whereHas('eventPeserta', function($q) use ($request) {
                $q->where('konfirmasi_kesediaan', $request->kesediaan);
            });
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $participants = $query->paginate(20)->withQueryString();
        $events = Event::latest()->get();

        return view('admin.participants.index', compact('participants', 'events'));
    }

    public function show(Peserta $peserta)
    {
        $peserta->load(['user', 'eventPeserta.event']);
        return view('admin.participants.show', compact('peserta'));
    }

    public function edit(Peserta $peserta)
    {
        $peserta->load('user');
        return view('admin.participants.edit', compact('peserta'));
    }

    public function update(Request $request, Peserta $peserta)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $peserta->user_id,
            'no_hp' => 'nullable|string|max:20',
            'unit_kerja' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:50|unique:peserta,nik,' . $peserta->id,
            'nbm' => 'nullable|string|max:50',
            'jabatan_aum' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'umur' => 'nullable|integer',
            'status_pernikahan' => 'nullable|string|max:255',
            'jumlah_anak' => 'nullable|integer',
            'alamat_rumah' => 'nullable|string',
            'desa_kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'ukuran_kaos' => 'nullable|string|max:10',
            'kemampuan_baca_quran' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        DB::beginTransaction();
        try {
            $user = $peserta->user;
            $user->update([
                'name' => $validated['nama_lengkap'],
                'email' => $validated['email'],
            ]);

            if (!empty($validated['password'])) {
                $user->update([
                    'password' => Hash::make($validated['password']),
                ]);
            }

            $peserta->update($validated);

            DB::commit();

            return redirect()->route('admin.participants.show', $peserta)->with('success', 'Data peserta berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data peserta: ' . $e->getMessage())->withInput();
        }
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:500',
            'email'        => 'nullable|email',
            'no_hp'        => 'nullable|string|max:20',
            'unit_kerja'   => 'nullable|string|max:255',
            'foto'         => 'nullable|image|max:2048',
            'password'     => 'nullable|string|min:6',
            'auto_password'=> 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $defaultPassword = config('app.default_participant_password', 'peserta123');
            $password = $validated['auto_password'] ?? true
                ? $defaultPassword
                : ($validated['password'] ?? $defaultPassword);

            // Periksa apakah user sudah ada (berdasarkan email jika disediakan)
            $user = null;
            if (!empty($validated['email'])) {
                $user = User::where('email', $validated['email'])->first();
            }

            if (!$user) {
                $importService = new ImportParticipantService();
                $emailForUsername = !empty($validated['email']) && !str_ends_with($validated['email'], '@arqam.test') ? $validated['email'] : null;
                $username = $importService->generateUsername($validated['nama_lengkap'], $emailForUsername);
                
                $user = User::create([
                    'name'     => $validated['nama_lengkap'],
                    'email'    => $validated['email'] ?? ($username . '@arqam.test'),
                    'username' => $username,
                    'password' => Hash::make($password),
                    'role'     => 'peserta',
                ]);
            }

            // Check if peserta profile exists
            $peserta = Peserta::where('user_id', $user->id)->first();

            if (!$peserta) {
                $fotoPath = null;
                if ($request->hasFile('foto')) {
                    $fotoPath = $request->file('foto')->store('peserta/foto', 'public');
                }

                $peserta = Peserta::create([
                    'user_id'      => $user->id,
                    'nama_lengkap' => $validated['nama_lengkap'],
                    'email'        => $user->email,
                    'no_hp'        => $validated['no_hp'] ?? null,
                    'unit_kerja'   => $validated['unit_kerja'] ?? null,
                    'foto'         => $fotoPath,
                ]);
            }

            // Periksa apakah sudah terdaftar untuk event ini
            $exists = EventPeserta::where('event_id', $event->id)
                ->where('peserta_id', $peserta->id)
                ->exists();

            if ($exists) {
                DB::rollBack();
                return back()->with('error', 'Peserta sudah terdaftar di event ini.');
            }

            // Buat kode QR dengan aman menggunakan HMAC
            $token = hash_hmac('sha256', $event->id . '-' . $peserta->id, config('app.key'));
            $qrCode = base64_encode(json_encode([
                'e' => $event->id,
                'p' => $peserta->id,
                't' => $token
            ]));

            EventPeserta::create([
                'event_id'    => $event->id,
                'peserta_id'  => $peserta->id,
                'qr_code'     => $qrCode,
                'status_aktif'=> true,
            ]);

            DB::commit();

            return back()->with('success', "Peserta '{$validated['nama_lengkap']}' berhasil ditambahkan! Login: " . ($user->username ?? $user->email));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan peserta: ' . $e->getMessage());
        }
    }

    public function downloadAccounts(Event $event)
    {
        $participants = EventPeserta::where('event_id', $event->id)
            ->where('status_aktif', true)
            ->with(['peserta.user'])
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.events.accounts-pdf', [
            'event' => $event,
            'participants' => $participants,
            'defaultPassword' => config('app.default_participant_password', 'peserta123')
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('Daftar_Akun_' . str_replace(' ', '_', $event->nama_event) . '.pdf');
    }

    public function destroy(Event $event, Peserta $participant)
    {
        EventPeserta::where('event_id', $event->id)
            ->where('peserta_id', $participant->id)
            ->delete();

        return back()->with('success', 'Peserta berhasil dihapus dari event.');
    }

    public function downloadTemplate()
    {
        $headers = [
            'Timestamp', 'Email Address', 'NIK', 'Nama', 'Homebase', 'No HP', 'Konfirmasi Kesediaan',
            'Sebab (Mohon dituliskan secara detail, dikarenakan BA sebagai syarat kenaikan pangkat)',
            'Unggah Surat Pernyataan Tidak Bersedia (diketahui Kaprodi)',
            'Rencana Keberangkatan ke Lokasi Baitul Arqam', 'Nama Panggilan', 'Jenis Kelamin',
            'Upload Foto bebas untuk IDCard', 'Unggah Surat Pernyataan Komitmen',
            'Alamat Asal (Tuliskan alamat lengkap asal/lahir. Dukuh, Kalurahan, Kec, Kab, Propinsi)',
            'Dukuh, Rt/Rw', 'Kalurahan/Desa', 'Kecamatan', 'Kabupaten/Kota', 'Propinsi', 'Umur',
            'Status Pernikahan', 'Jumlah Anak', 'Pernah/sedang aktif di Ortom (Bisa pilih lebih dari satu)',
            'Pernah/Sedang Aktif di Persyarikatan Muhammadiyah/Aisyiyah', 'Mengikuti Baitul Arqam Dosen UMS ke-',
            'Aktivitas duduk', 'Aktivitas naik-turun tangga', 'Aktivitas sholat', 'Ukuran Kaos',
            'Kemampuan Membaca Al-Qur\'an', 'Kompetensi Keberagamaan', 'Kompetensi Akademis',
            'Kompetensi Sosial Kemanusiaan dan Kepeloporan', 'Kompetensi Keorganisasian dan Kepemimpinan',
            'Tuliskan Keterlibatan Bapak/Ibu di Ranting Muhammadiyah/Aisyiyah/Ortom dan Lingkungan Sekitar',
            'Adakah hal khusus yang perlu disampaikan terkait Makanan',
            'Adakah hal khusus yang perlu disampaikan terkait Kesehatan',
            'Adakah hal-hal lain yang perlu disampaikan kepada Panitia'
        ];

        $callback = function () use ($headers) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, $headers);
            fputcsv($file, [
                '5/19/2026 20:36:13', 'ma956@ums.ac.id', '100.2432', 'Muk Andhim, S.Pd, M.Pd.', 'FAI - Program Studi Pendidikan Agama Islam',
                '082136538276', 'Bersedia', '', '', 'Bersama Rombongan dari UMS', 'Andhim', 'Laki-Laki',
                'https://drive.google.com/open?id=1ZjmpXm9yEDlPwFEFCYhhHlcjERjyuMdO',
                'https://drive.google.com/open?id=1OgPZnSmBS7ZdJDbvfC5VDobgDDB-kjQs',
                'Desa Ngargomulyo, Kec. Lasem, Kab. Rembang, Jawa Tengah', 'Saripan, RT. 02 RW. 12',
                'Makamhaji', 'Kartasura', 'Sukoharjo', 'Jawa Tengah', '30', 'Menikah', '1',
                'Pemuda Muhammadiyah', 'Muhammadiyah', '12', 'Bisa', 'Bisa', 'Bisa', 'XL',
                'Baik', 'Baik', 'Baik', 'Baik', 'Baik', 'Aktif di Ranting', 'Tidak ada', 'Tidak ada', ''
            ]);
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_peserta_v2.csv"',
        ]);
    }

    public function import(Request $request, Event $event)
    {
        $request->validate([
            'file'            => 'required|file|mimes:csv,xlsx,xls|max:5120',
            'duplicate_action'=> 'nullable|in:skip,update',
        ]);

        $service = new ImportParticipantService();
        $result = $service->import(
            $request->file('file'),
            $event,
            $request->input('duplicate_action', 'skip')
        );

        return back()->with('success',
            "Import selesai! {$result['imported']} peserta ditambahkan, {$result['skipped']} duplikat dilewati."
        );
    }

    public function generateQr(Event $event, Peserta $participant)
    {
        $ep = EventPeserta::where('event_id', $event->id)
            ->where('peserta_id', $participant->id)
            ->first();

        if (!$ep) {
            return back()->with('error', 'Peserta tidak terdaftar di event ini.');
        }

        if (empty($ep->qr_code)) {
            $token = hash_hmac('sha256', $event->id . '-' . $participant->id, config('app.key'));
            $ep->update([
                'qr_code' => base64_encode(json_encode([
                    'e' => $event->id,
                    'p' => $participant->id,
                    't' => $token
                ])),
            ]);
        }

        return back()->with('success', 'QR Code berhasil di-generate!');
    }

    public function downloadIdCards(Event $event)
    {
        $participants = EventPeserta::where('event_id', $event->id)
            ->where('status_aktif', true)
            ->with('peserta')
            ->get();

        if ($participants->isEmpty()) {
            return back()->with('error', 'Belum ada peserta di event ini.');
        }

        // Auto-generate missing QR codes
        foreach ($participants as $ep) {
            if (empty($ep->qr_code)) {
                $token = hash_hmac('sha256', $event->id . '-' . $ep->peserta_id, config('app.key'));
                $qrCode = base64_encode(json_encode([
                    'e' => $event->id,
                    'p' => $ep->peserta_id,
                    't' => $token
                ]));
                $ep->update(['qr_code' => $qrCode]);
                $ep->qr_code = $qrCode; // Update in-memory object
            }
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.events.batch-idcard-pdf', [
            'event' => $event,
            'participants' => $participants
        ])->setPaper('a4', 'portrait'); // Ukuran A4

        return $pdf->stream('ID_Cards_A4_' . str_replace(' ', '_', $event->nama_event) . '.pdf');
    }

    public function downloadIdCard(Event $event, Peserta $participant)
    {
        $ep = EventPeserta::where('event_id', $event->id)
            ->where('peserta_id', $participant->id)
            ->first();

        $qrData = $ep ? $ep->qr_code : null;

        if (empty($qrData)) {
            $token = hash_hmac('sha256', $event->id . '-' . $participant->id, config('app.key'));
            $qrData = base64_encode(json_encode([
                'e' => $event->id,
                'p' => $participant->id,
                't' => $token
            ]));
            if ($ep) {
                $ep->update(['qr_code' => $qrData]);
            }
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('peserta.idcard-pdf', [
            'event' => $event,
            'peserta' => $participant,
            'qrData' => $qrData
        ])->setPaper([0, 0, 243.7, 388.3]);

        return $pdf->stream('ID_Card_' . str_replace(' ', '_', $participant->nama_lengkap) . '.pdf');
    }

    public function downloadSertifikat(Event $event, Peserta $participant)
    {
        $skor = \App\Models\PenilaianAkhir::where('event_id', $event->id)
            ->where('peserta_id', $participant->id)
            ->first();
            
        if (!$skor || empty($skor->status_kelulusan) || str_contains($skor->status_kelulusan, 'Tidak Lulus')) {
            return back()->with('error', 'Peserta belum lulus atau sertifikat belum tersedia.');
        }

        if (empty($skor->verification_hash)) {
            $skor->verification_hash = hash('sha256', $event->id . $participant->id . config('app.key'));
            $skor->save();
        }

        $verificationUrl = route('certificate.verify', $skor->verification_hash);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('peserta.sertifikat-pdf', [
            'event' => $event,
            'peserta' => $participant,
            'skor' => $skor,
            'verificationUrl' => $verificationUrl
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('Sertifikat_' . str_replace(' ', '_', $participant->nama_lengkap) . '.pdf');
    }
    public function participantsPdf(Event $event)
    {
        $participants = EventPeserta::with(['peserta', 'peserta.user'])
            ->where('event_id', $event->id)
            ->where('status_aktif', true)
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.events.participants-pdf', compact('event', 'participants'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Data_Peserta_' . str_replace(' ', '_', $event->nama_event) . '.pdf');
    }

    public function export(Event $event)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\ParticipantsExport($event), 
            'Data_Peserta_' . str_replace(' ', '_', $event->nama_event) . '.xlsx'
        );
    }

    public function destroyParticipant(Peserta $peserta)
    {
        DB::beginTransaction();
        try {
            $user = $peserta->user;

            // Hapus pendaftaran event
            EventPeserta::where('peserta_id', $peserta->id)->delete();

            // Hapus profile peserta
            $peserta->delete();

            // Hapus user account
            if ($user) {
                $user->delete();
            }

            DB::commit();
            return redirect()->route('admin.participants.index')->with('success', 'Peserta berhasil dihapus beserta akun loginnya.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus peserta: ' . $e->getMessage());
        }
    }
}
