<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\JawabanPeserta;
use App\Models\AfektifJawaban;
use App\Models\AngketJawaban;
use App\Models\PenilaianAkhir;
use App\Models\Absensi;
use App\Models\SesiTes;
use App\Models\Soal;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) {
            abort(403, 'Akses ditolak, harap lengkapi profil peserta.');
        }

        $eventPeserta = EventPeserta::where('peserta_id', $peserta->id)
            ->with(['event' => fn($q) => $q->withCount('sesi')])
            ->whereHas('event', function ($q) {
                $q->whereIn('status', ['persiapan', 'berlangsung', 'selesai']);
            })
            ->latest()
            ->first();

        if ($eventPeserta && empty($eventPeserta->qr_code)) {
            $token = hash_hmac('sha256', $eventPeserta->event_id . '-' . $peserta->id, config('app.key'));
            $qrCode = base64_encode(json_encode([
                'e' => $eventPeserta->event_id,
                'p' => $peserta->id,
                't' => $token
            ]));
            $eventPeserta->update(['qr_code' => $qrCode]);
            $eventPeserta->qr_code = $qrCode;
        }

        $activeEvent = $eventPeserta ? $eventPeserta->event : null;
        $progress = [];
        $scores = null;
        $sesiStatus = ['pretest' => false, 'posttest' => false];
        $chartData = null;

        if ($activeEvent) {
            $eventId = $activeEvent->id;
            
            $materials = \App\Models\EventSesi::where('event_id', $eventId)->get();
            $tesService = app(\App\Services\TesService::class);

            $pretestTotalCount = 0;
            $pretestDoneCount = 0;
            $posttestTotalCount = 0;
            $posttestDoneCount = 0;

            foreach ($materials as $material) {
                // Check if pretest is configured (has questions)
                $hasPretest = Soal::where('event_id', $eventId)
                    ->where('event_sesi_id', $material->id)
                    ->where('tipe', 'pretest')
                    ->exists();
                if ($hasPretest) {
                    $pretestTotalCount++;
                    if ($tesService->hasSubmitted($activeEvent, $peserta, 'pretest', $material->id)) {
                        $pretestDoneCount++;
                    }
                }

                // Check if posttest is configured (has questions)
                $hasPosttest = Soal::where('event_id', $eventId)
                    ->where('event_sesi_id', $material->id)
                    ->where('tipe', 'posttest')
                    ->exists();
                if ($hasPosttest) {
                    $posttestTotalCount++;
                    if ($tesService->hasSubmitted($activeEvent, $peserta, 'posttest', $material->id)) {
                        $posttestDoneCount++;
                    }
                }
            }

            $pretestDone = ($pretestTotalCount > 0) ? ($pretestDoneCount >= $pretestTotalCount) : true;
            $posttestDone = ($posttestTotalCount > 0) ? ($posttestDoneCount >= $posttestTotalCount) : true;

            $afektifDone = AfektifJawaban::where('event_id', $eventId)
                ->where('peserta_id', $peserta->id)
                ->exists();

            $angketDone = AngketJawaban::where('event_id', $eventId)
                ->where('peserta_id', $peserta->id)
                ->exists();

            $attended = Absensi::where('event_id', $eventId)
                ->where('peserta_id', $peserta->id)
                ->count();

            $attendedSessionIds = Absensi::where('event_id', $eventId)
                ->where('peserta_id', $peserta->id)
                ->pluck('sesi_id')
                ->toArray();

            $progress = [
                'pretest'        => $pretestDone,
                'pretest_done'   => $pretestDoneCount,
                'pretest_total'  => $pretestTotalCount,
                'posttest'       => $posttestDone,
                'posttest_done'  => $posttestDoneCount,
                'posttest_total' => $posttestTotalCount,
                'afektif'        => $afektifDone,
                'angket'         => $angketDone,
                'attended'       => $attended,
                'total_sesi'     => $activeEvent->sesi_count,
            ];

            // Find any active pretest session
            $activePreSesis = SesiTes::where('event_id', $eventId)->where('tipe', 'pretest')->where('status', 'aktif')->get();
            $preActive = false;
            $preSesi = null;
            foreach ($activePreSesis as $aps) {
                $preActive = true;
                $preSesi = $aps;
                break;
            }

            // Find any active posttest session
            $activePostSesis = SesiTes::where('event_id', $eventId)->where('tipe', 'posttest')->where('status', 'aktif')->get();
            $postActive = false;
            $postSesi = null;
            foreach ($activePostSesis as $aps) {
                $postActive = true;
                $postSesi = $aps;
                break;
            }

            $preRemainingSeconds = 0;
            if ($preActive && $preSesi) {
                $pesertaMulai = \App\Models\PesertaTesMulai::where('peserta_id', $peserta->id)
                    ->where('event_id', $eventId)
                    ->where('event_sesi_id', $preSesi->event_sesi_id)
                    ->where('tipe', 'pretest')
                    ->first();
                if ($pesertaMulai) {
                    $endTime = $pesertaMulai->waktu_mulai->timestamp + ($preSesi->durasi_menit * 60);
                    $preRemainingSeconds = max(0, $endTime - now()->timestamp);
                }
            }

            $postRemainingSeconds = 0;
            if ($postActive && $postSesi) {
                $pesertaMulai = \App\Models\PesertaTesMulai::where('peserta_id', $peserta->id)
                    ->where('event_id', $eventId)
                    ->where('event_sesi_id', $postSesi->event_sesi_id)
                    ->where('tipe', 'posttest')
                    ->first();
                if ($pesertaMulai) {
                    $endTime = $pesertaMulai->waktu_mulai->timestamp + ($postSesi->durasi_menit * 60);
                    $postRemainingSeconds = max(0, $endTime - now()->timestamp);
                }
            }

            $sesiStatus['pretest'] = $preActive;
            $sesiStatus['pretest_durasi'] = $preSesi ? $preSesi->durasi_menit : 30;
            $sesiStatus['pretest_remaining_seconds'] = $preRemainingSeconds;
            $sesiStatus['pretest_event_sesi_id'] = $preSesi ? $preSesi->event_sesi_id : null;

            $sesiStatus['posttest'] = $postActive;
            $sesiStatus['posttest_durasi'] = $postSesi ? $postSesi->durasi_menit : 30;
            $sesiStatus['posttest_remaining_seconds'] = $postRemainingSeconds;
            $sesiStatus['posttest_event_sesi_id'] = $postSesi ? $postSesi->event_sesi_id : null;

            $scores = PenilaianAkhir::where('event_id', $eventId)->where('peserta_id', $peserta->id)->first();
            
            if ($scores) {
                $chartData = [
                    'labels' => ['Pretest', 'Posttest', 'Afektif', 'Psikomotor', 'Kehadiran'],
                    'data'   => [
                        (float) $scores->nilai_pretest,
                        (float) $scores->nilai_posttest,
                        (float) $scores->nilai_afektif,
                        (float) $scores->nilai_psikomotor,
                        (float) $scores->nilai_kehadiran,
                    ]
                ];
            }
        }

        $hasRtl = false;
        if ($activeEvent) {
            $hasRtl = \App\Models\Rtl::where('event_id', $activeEvent->id)
                ->where('peserta_id', $peserta->id)
                ->where('status', 'submitted')
                ->exists();
        }

        return view('peserta.dashboard', compact('peserta', 'activeEvent', 'eventPeserta', 'progress', 'scores', 'sesiStatus', 'chartData', 'materials', 'attendedSessionIds', 'hasRtl'));
    }

    public function downloadSertifikat(Event $event)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        $skor = PenilaianAkhir::where('event_id', $event->id)->where('peserta_id', $peserta->id)->first();
        
        if (!$skor || empty($skor->status_kelulusan) || str_contains($skor->status_kelulusan, 'Tidak Lulus')) {
            abort(403, 'Sertifikat belum tersedia atau Anda tidak lulus evaluasi.');
        }

        // Validate mandatory profile fields
        if (empty($peserta->nama_lengkap) || empty($peserta->nik) || empty($peserta->tempat_lahir) || empty($peserta->tanggal_lahir)) {
            return redirect()->route('peserta.profile.index')->with('error', 'Silakan lengkapi profil Anda (Nama Lengkap, NIK, Tempat Lahir, dan Tanggal Lahir) terlebih dahulu untuk mengunduh sertifikat.');
        }

        // Check if RTL is submitted
        $hasRtl = \App\Models\Rtl::where('event_id', $event->id)
            ->where('peserta_id', $peserta->id)
            ->where('status', 'submitted')
            ->exists();

        if (!$hasRtl) {
            if ($event->rtl_deadline && now()->gt($event->rtl_deadline)) {
                return redirect()->route('peserta.hasil')->with('error', 'Anda tidak dapat mengunduh sertifikat karena belum menyelesaikan RTL dan batas waktu pengerjaan telah habis.');
            }
            return redirect()->route('peserta.rtl.index', $event)->with('error', 'Anda wajib mengisi Rencana Tindak Lanjut (RTL) terlebih dahulu untuk mengunduh sertifikat.');
        }

        if (empty($skor->verification_hash)) {
            $skor->verification_hash = hash('sha256', $event->id . $peserta->id . config('app.key'));
            $skor->save();
        }

        $verificationUrl = route('certificate.verify', $skor->verification_hash);

        $pdf = Pdf::loadView('peserta.sertifikat-pdf', compact('event', 'peserta', 'skor', 'verificationUrl'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Sertifikat_Baitul_Arqam_' . str_replace(' ', '_', $peserta->nama_lengkap) . '.pdf');
    }

    public function downloadIdCard(Event $event)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        $eventPeserta = EventPeserta::where('event_id', $event->id)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        // Konten Kode QR: Gunakan blob QR berbasis token yang aman
        $qrData = $eventPeserta->qr_code; 
        if (empty($qrData)) {
            $token = hash_hmac('sha256', $event->id . '-' . $peserta->id, config('app.key'));
            $qrData = base64_encode(json_encode([
                'e' => $event->id,
                'p' => $peserta->id,
                't' => $token
            ]));
            $eventPeserta->update(['qr_code' => $qrData]);
        }

        $pdf = Pdf::loadView('peserta.idcard-pdf', compact('event', 'peserta', 'qrData'))
            ->setPaper([0, 0, 243.7, 388.3]) // Ukuran ID Card dalam poin (sekitar 86mm x 137mm atau sejenisnya)
            ->setOption('isRemoteEnabled', true);

        return $pdf->download('ID_Card_' . str_replace(' ', '_', $peserta->nama_lengkap) . '.pdf');
    }

    /**
     * Tampilkan riwayat kehadiran peserta.
     */
    public function kehadiran()
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) {
            abort(403, 'Akses ditolak, harap lengkapi profil peserta.');
        }

        $eventPeserta = EventPeserta::where('peserta_id', $peserta->id)
            ->with(['event'])
            ->whereHas('event', function ($q) {
                $q->whereIn('status', ['persiapan', 'berlangsung', 'selesai']);
            })
            ->latest()
            ->first();

        $activeEvent = $eventPeserta ? $eventPeserta->event : null;
        $sessions = collect();
        $attendedCount = 0;
        $totalSessions = 0;

        if ($activeEvent) {
            $sessions = \App\Models\EventSesi::where('event_id', $activeEvent->id)
                ->orderBy('urutan')
                ->get()
                ->map(function ($sesi) use ($peserta, $activeEvent) {
                    $absensi = Absensi::where('event_id', $activeEvent->id)
                        ->where('sesi_id', $sesi->id)
                        ->where('peserta_id', $peserta->id)
                        ->first();

                    return [
                        'id' => $sesi->id,
                        'nama_sesi' => $sesi->nama_sesi,
                        'urutan' => $sesi->urutan,
                        'attended' => !is_null($absensi),
                        'waktu_scan' => $absensi ? $absensi->waktu_scan : null,
                    ];
                });

            $attendedCount = $sessions->where('attended', true)->count();
            $totalSessions = $sessions->count();
        }

        return view('peserta.kehadiran.index', compact('peserta', 'activeEvent', 'sessions', 'attendedCount', 'totalSessions'));
    }

    /**
     * Tampilkan laporan hasil penilaian akhir peserta.
     */
    public function hasil()
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) {
            abort(403, 'Akses ditolak, harap lengkapi profil peserta.');
        }

        $eventPeserta = EventPeserta::where('peserta_id', $peserta->id)
            ->with(['event'])
            ->whereHas('event', function ($q) {
                $q->whereIn('status', ['persiapan', 'berlangsung', 'selesai']);
            })
            ->latest()
            ->first();

        $activeEvent = $eventPeserta ? $eventPeserta->event : null;
        $scores = null;
        $hasRtl = false;

        if ($activeEvent) {
            $scores = PenilaianAkhir::where('event_id', $activeEvent->id)
                ->where('peserta_id', $peserta->id)
                ->first();
            
            $hasRtl = \App\Models\Rtl::where('event_id', $activeEvent->id)
                ->where('peserta_id', $peserta->id)
                ->where('status', 'submitted')
                ->exists();
        }

        return view('peserta.hasil.index', compact('peserta', 'activeEvent', 'scores', 'hasRtl'));
    }

    /**
     * Tampilkan jadwal sesi kegiatan.
     */
    public function jadwal()
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        $eventPeserta = EventPeserta::where('peserta_id', $peserta->id)
            ->with(['event'])
            ->whereHas('event', function ($q) {
                $q->whereIn('status', ['persiapan', 'berlangsung', 'selesai']);
            })
            ->latest()
            ->first();

        $activeEvent = $eventPeserta ? $eventPeserta->event : null;
        $sessions = collect();

        if ($activeEvent) {
            $sessions = \App\Models\EventSesi::where('event_id', $activeEvent->id)
                ->orderBy('urutan')
                ->get()
                ->map(function ($sesi) use ($peserta, $activeEvent) {
                    $absensi = Absensi::where('event_id', $activeEvent->id)
                        ->where('sesi_id', $sesi->id)
                        ->where('peserta_id', $peserta->id)
                        ->first();
                    return [
                        'id'            => $sesi->id,
                        'urutan'        => $sesi->urutan,
                        'nama_sesi'     => $sesi->nama_sesi,
                        'deskripsi'     => $sesi->deskripsi ?? null,
                        'waktu_mulai'   => $sesi->waktu_mulai ?? null,
                        'waktu_selesai' => $sesi->waktu_selesai ?? null,
                        'pemateri'      => $sesi->pemateri ?? null,
                        'file_materi'   => $sesi->file_materi ?? null,
                        'attended'      => !is_null($absensi),
                        'waktu_scan'    => $absensi ? $absensi->waktu_scan : null,
                    ];
                });
        }

        return view('peserta.jadwal.index', compact('peserta', 'activeEvent', 'sessions'));
    }

    public function rtlPage(Event $event)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        $eventPeserta = EventPeserta::where('event_id', $event->id)
            ->where('peserta_id', $peserta->id)
            ->firstOrFail();

        $skor = PenilaianAkhir::where('event_id', $event->id)->where('peserta_id', $peserta->id)->first();
        if (!$skor || empty($skor->status_kelulusan)) {
            return redirect()->route('peserta.hasil')->with('error', 'RTL belum dapat diakses karena pengumuman kelulusan belum dirilis oleh panitia.');
        }
        if (str_contains($skor->status_kelulusan, 'Tidak Lulus')) {
            return redirect()->route('peserta.hasil')->with('error', 'RTL hanya dapat diakses oleh peserta yang dinyatakan lulus evaluasi.');
        }

        $rtl = \App\Models\Rtl::where('event_id', $event->id)
            ->where('peserta_id', $peserta->id)
            ->with('jawaban.soal')
            ->first();

        // Check deadline
        if ($event->rtl_deadline && now()->gt($event->rtl_deadline)) {
            if (!$rtl || $rtl->status !== 'submitted') {
                return redirect()->route('peserta.hasil')->with('error', 'Batas waktu pengisian RTL telah habis.');
            }
        }

        $rtlSoal = \App\Models\RtlSoal::where('event_id', $event->id)->orderBy('urutan')->get();
        if ($rtlSoal->isEmpty()) {
            // Gunakan DB transaction untuk menghindari race condition ketika banyak
            // peserta membuka halaman RTL bersamaan saat soal belum tersedia
            \Illuminate\Support\Facades\DB::transaction(function () use ($event) {
                // Cek ulang di dalam transaction agar thread lain tidak insert ganda
                $existing = \App\Models\RtlSoal::where('event_id', $event->id)->exists();
                if (!$existing) {
                    $defaultQuestions = [
                        'Tujuan Rencana Aksi',
                        'Sasaran Utama Penerima Dampak',
                        'Indikator Keberhasilan',
                        'Waktu Pelaksanaan',
                        'Mitra & Pihak Terlibat'
                    ];
                    foreach ($defaultQuestions as $index => $qText) {
                        \App\Models\RtlSoal::create([
                            'event_id'   => $event->id,
                            'pertanyaan' => $qText,
                            'tipe'       => 'essay',
                            'urutan'     => $index + 1,
                        ]);
                    }
                }
            });
            $rtlSoal = \App\Models\RtlSoal::where('event_id', $event->id)->orderBy('urutan')->get();
        }

        return view('peserta.rtl.index', compact('peserta', 'event', 'rtl', 'rtlSoal'));
    }

    public function submitRtl(Request $request, Event $event)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        if ($event->rtl_deadline && now()->gt($event->rtl_deadline)) {
            return redirect()->route('peserta.hasil')->with('error', 'Waktu pengerjaan RTL telah berakhir.');
        }

        $rtlSoals = \App\Models\RtlSoal::where('event_id', $event->id)->get();

        // Build validation rules dynamically
        $rules = [
            'judul_kegiatan' => 'required|string|max:255',
            'kategori_rtl'   => 'required|string|max:100',
            'steps'          => 'required|array|min:1',
            'steps.*.deskripsi'      => 'required|string|max:255',
            'steps.*.target_tanggal' => 'required|string|max:100',
        ];

        foreach ($rtlSoals as $soal) {
            if ($soal->tipe === 'essay') {
                $rules["answers.{$soal->id}"] = 'required|string';
            } elseif ($soal->tipe === 'upload') {
                $rules["answers.{$soal->id}"] = $request->hasFile("answers.{$soal->id}") ? 'required|image|max:5120' : 'nullable';
            }
        }

        $request->validate($rules);

        // Proses upload file di luar transaction (I/O tidak boleh dalam transaction)
        $uploadedFiles = [];
        foreach ($rtlSoals as $soal) {
            if ($soal->tipe === 'upload' && $request->hasFile("answers.{$soal->id}")) {
                $file = $request->file("answers.{$soal->id}");
                $filename = time() . '_' . $peserta->id . '_' . $soal->id . '.' . $file->getClientOriginalExtension();
                $uploadPath = public_path('uploads/rtl');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $file->move($uploadPath, $filename);
                $uploadedFiles[$soal->id] = 'uploads/rtl/' . $filename;
            }
        }

        $steps = [];
        foreach ($request->input('steps') as $index => $step) {
            $steps[] = [
                'step'           => $index + 1,
                'deskripsi'      => $step['deskripsi'],
                'target_tanggal' => $step['target_tanggal']
            ];
        }

        // Bungkus semua operasi database dalam satu transaction untuk mencegah data partial
        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($request, $event, $peserta, $rtlSoals, $steps, $uploadedFiles) {
                $rtl = \App\Models\Rtl::updateOrCreate(
                    [
                        'event_id'   => $event->id,
                        'peserta_id' => $peserta->id,
                    ],
                    [
                        'judul_kegiatan'  => $request->judul_kegiatan,
                        'kategori_rtl'    => $request->kategori_rtl,
                        'langkah_langkah' => $steps,
                        'status'          => 'submitted',
                    ]
                );

                // Save answers
                foreach ($rtlSoals as $soal) {
                    if ($soal->tipe === 'deskripsi') {
                        continue;
                    }

                    $jawabanText = '';

                    if ($soal->tipe === 'essay') {
                        $jawabanText = $request->input("answers.{$soal->id}");
                    } elseif ($soal->tipe === 'upload') {
                        if (isset($uploadedFiles[$soal->id])) {
                            $jawabanText = $uploadedFiles[$soal->id];
                        } else {
                            // Pertahankan file lama jika tidak ada file baru
                            $oldJawaban = \App\Models\RtlJawaban::where('rtl_id', $rtl->id)
                                ->where('rtl_soal_id', $soal->id)
                                ->first();
                            if ($oldJawaban) {
                                $jawabanText = $oldJawaban->jawaban;
                            } else {
                                throw new \Exception("upload_required:{$soal->id}");
                            }
                        }
                    }

                    \App\Models\RtlJawaban::updateOrCreate(
                        [
                            'rtl_id'      => $rtl->id,
                            'rtl_soal_id' => $soal->id,
                        ],
                        [
                            'jawaban' => $jawabanText,
                        ]
                    );
                }
            });
        } catch (\Exception $e) {
            // Hapus file yang sudah ter-upload jika transaction gagal
            foreach ($uploadedFiles as $filePath) {
                $fullPath = public_path($filePath);
                if (file_exists($fullPath)) {
                    @unlink($fullPath);
                }
            }

            if (str_starts_with($e->getMessage(), 'upload_required:')) {
                $soalId = str_replace('upload_required:', '', $e->getMessage());
                return back()->withInput()->withErrors(["answers.{$soalId}" => "Unggah bukti gambar wajib diisi."]);
            }

            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan RTL. Silakan coba lagi.');
        }

        return redirect()->route('peserta.hasil')->with('success', 'Rencana Tindak Lanjut (RTL) berhasil disimpan! Anda sekarang dapat mengunduh sertifikat.');
    }
}
