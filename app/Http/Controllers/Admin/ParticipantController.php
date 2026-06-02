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
        $query = Peserta::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('unit_kerja', 'like', "%{$search}%");
            });
        }

        $participants = $query->paginate(20)->withQueryString();

        return view('admin.participants.index', compact('participants'));
    }

    public function show(Peserta $peserta)
    {
        $peserta->load(['user', 'eventPeserta.event', 'eventPeserta.skor']);
        return view('admin.participants.show', compact('peserta'));
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
                $username = $importService->generateUsername($validated['nama_lengkap']);
                
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
        $headers = ['nama_lengkap', 'email', 'no_hp', 'unit_kerja'];
        $callback = function () use ($headers) {
            $file = fopen('php://output', 'w');
            // BOM untuk UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, $headers);
            fputcsv($file, ['Dr. Ahmad Fauzi, M.Pd.', 'ahmad@example.com', '08123456789', 'Fakultas Teknik']);
            fputcsv($file, ['Siti Aminah, S.Pd.', 'siti@example.com', '08234567890', 'Fakultas Ekonomi']);
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_peserta.csv"',
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
            ->with('peserta')
            ->get();

        if ($participants->isEmpty()) {
            return back()->with('error', 'Belum ada peserta di event ini.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.events.batch-idcard-pdf', [
            'event' => $event,
            'participants' => $participants
        ])->setPaper('a4', 'portrait'); // Ukuran A4

        return $pdf->stream('ID_Cards_A4_' . str_replace(' ', '_', $event->nama_event) . '.pdf');
    }

    public function downloadIdCard(Event $event, Peserta $participant)
    {
        $qrData = $participant->email; 

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
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.events.participants-pdf', compact('event', 'participants'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('Data_Peserta_' . str_replace(' ', '_', $event->nama_event) . '.pdf');
    }

    public function export(Event $event)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\ParticipantsExport($event), 
            'Data_Peserta_' . str_replace(' ', '_', $event->nama_event) . '.xlsx'
        );
    }
}
