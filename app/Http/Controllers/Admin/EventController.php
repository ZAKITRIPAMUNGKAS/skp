<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\JawabanPeserta;
use App\Models\AfektifJawaban;
use App\Models\PenilaianAkhir;
use App\Exports\PenilaianExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Event::withCount('eventPesertaAktif');

        if ($user->isFasilitator()) {
            // Hanya tampilkan event yang ditugaskan ke fasilitator ini
            $query->whereHas('facilitators', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        } elseif ($user->isAdmin()) {
            // Admin utama melihat semua event miliknya atau seluruh event?
            // "Admin dapat mengelola seluruh event yang dibuatnya." -> mari kita batasi created_by = admin_id jika diperlukan,
            // atau jika admin ingin melihat semua event. Mari batasi created_by jika itu adalah rules yang diinginkan.
            // "Admin: Dapat membuat event. Dapat mengelola seluruh event yang dibuatnya."
            $query->where('created_by', $user->id);
        }

        $query->orderBy('tanggal_mulai', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_event', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->paginate(10)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_event'      => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi'          => 'nullable|string|max:255',
            'deskripsi'       => 'nullable|string',
            'status'          => 'required|in:persiapan,berlangsung,selesai',
            'kuota'           => 'nullable|integer|min:0',
        ]);

        $validated['created_by'] = auth()->id();

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dibuat!');
    }

    public function show(Event $event)
    {
        $this->authorizeEventAccess($event);

        $event->loadCount('eventPesertaAktif', 'sesi');

        // Statistik
        $totalPeserta = $event->event_peserta_aktif_count;

        $completedPretest = JawabanPeserta::where('event_id', $event->id)
            ->distinct('peserta_id')
            ->count('peserta_id');

        $completedAfektif = AfektifJawaban::where('event_id', $event->id)
            ->distinct('peserta_id')
            ->count('peserta_id');

        // Peserta dengan progres evaluasi (hanya yang aktif/bersedia)
        $participants = EventPeserta::where('event_id', $event->id)
            ->where('status_aktif', true)
            ->with(['peserta'])
            ->paginate(50);

        // Sesi
        $sessions = $event->sesi()->orderBy('urutan')->get();

        // Data Fasilitator (Hanya untuk Admin Utama)
        $allFasilitators = [];
        $assignedFasilitatorIds = [];
        if (auth()->user()->isAdmin()) {
            $allFasilitators = \App\Models\User::where('role', 'fasilitator')->get();
            $assignedFasilitatorIds = $event->facilitators()->pluck('users.id')->toArray();
        }

        // Kalkulasi Statistik Laporan Kognitif & SAW
        $stats = [
            'avg_pretest'   => 0,
            'avg_posttest'  => 0,
            'avg_kehadiran' => 0,
            'avg_ngain'     => 0,
        ];

        $chartData = [
            'predikat_labels' => ['Amat Baik', 'Baik', 'Cukup', 'Kurang'],
            'predikat_data'   => [0, 0, 0, 0],
            'pre_post_avg'    => [0, 0]
        ];

        $topRankings = collect();

        $penilaian = PenilaianAkhir::where('event_id', $event->id)
            ->whereHas('peserta.eventPeserta', function ($q) use ($event) {
                $q->where('event_id', $event->id)->where('status_aktif', true);
            })
            ->get();
        
        if ($penilaian->count()) {
            $stats['avg_pretest']   = $penilaian->avg('nilai_pretest') ?? 0;
            $stats['avg_posttest']  = $penilaian->avg('nilai_posttest') ?? 0;
            $stats['avg_kehadiran'] = $penilaian->avg('nilai_kehadiran') ?? 0;
            
            $nGains = $penilaian->map(fn($p) => $p->n_gain_score);
            $stats['avg_ngain']     = $nGains->avg() ?? 0;

            $chartData['predikat_data'] = [
                $penilaian->where('predikat', 'Amat Baik')->count(),
                $penilaian->where('predikat', 'Baik')->count(),
                $penilaian->where('predikat', 'Cukup')->count(),
                $penilaian->where('predikat', 'Kurang')->count(),
            ];

            $chartData['pre_post_avg'] = [
                round($stats['avg_pretest'], 2),
                round($stats['avg_posttest'], 2)
            ];
        }

        $topRankings = PenilaianAkhir::where('event_id', $event->id)
            ->with('peserta')
            ->whereNotNull('ranking')
            ->orderBy('ranking')
            ->take(10)
            ->get();

        // Logs aktivitas khusus untuk event ini (Dilihat oleh Admin Utama)
        $eventLogs = [];
        if (auth()->user()->isAdmin()) {
            $eventLogs = \App\Models\ActivityLog::where('event_id', $event->id)
                ->with('user')
                ->latest()
                ->take(100)
                ->get();
        }

        // Fetch RTLs for this event
        $rtls = \App\Models\Rtl::where('event_id', $event->id)
            ->with(['peserta'])
            ->latest()
            ->get();

        // Load or initialize RTL questions
        $rtlSoal = \App\Models\RtlSoal::where('event_id', $event->id)->orderBy('urutan')->get();
        if ($rtlSoal->isEmpty()) {
            $defaultQuestions = [
                'Tujuan Rencana Aksi',
                'Sasaran Utama Penerima Dampak',
                'Indikator Keberhasilan',
                'Waktu Pelaksanaan',
                'Mitra & Pihak Terlibat'
            ];
            foreach ($defaultQuestions as $index => $qText) {
                \App\Models\RtlSoal::create([
                    'event_id' => $event->id,
                    'pertanyaan' => $qText,
                    'urutan' => $index + 1,
                ]);
            }
            $rtlSoal = \App\Models\RtlSoal::where('event_id', $event->id)->orderBy('urutan')->get();
        }

        return view('admin.events.show', compact(
            'event',
            'totalPeserta',
            'completedPretest',
            'completedAfektif',
            'participants',
            'sessions',
            'allFasilitators',
            'assignedFasilitatorIds',
            'eventLogs',
            'rtls',
            'rtlSoal',
            'stats',
            'chartData',
            'topRankings'
        ));
    }

    public function statistics(Event $event)
    {
        $this->authorizeEventAccess($event);

        $event->loadCount('eventPesertaAktif');
        $totalPeserta = $event->event_peserta_aktif_count;

        $penilaian = PenilaianAkhir::where('event_id', $event->id)
            ->whereHas('peserta.eventPeserta', function ($q) use ($event) {
                $q->where('event_id', $event->id)->where('status_aktif', true);
            })
            ->get();

        // Predikat distribution data
        $predikatData = [
            'Amat Baik' => $penilaian->where('predikat', 'Amat Baik')->count(),
            'Baik' => $penilaian->where('predikat', 'Baik')->count(),
            'Cukup' => $penilaian->where('predikat', 'Cukup')->count(),
            'Kurang' => $penilaian->where('predikat', 'Kurang')->count(),
        ];

        // Kelulusan distribution data
        $kelulusanData = [
            'Lulus Sangat Memuaskan' => $penilaian->where('status_kelulusan', 'Lulus Sangat Memuaskan')->count(),
            'Lulus Memuaskan' => $penilaian->where('status_kelulusan', 'Lulus Memuaskan')->count(),
            'Lulus' => $penilaian->where('status_kelulusan', 'Lulus')->count(),
            'Tidak Lulus' => $penilaian->where('status_kelulusan', 'Tidak Lulus')->count(),
        ];

        // N-Gain Category distribution
        $nGainData = [
            'Tinggi (> 0.7)' => $penilaian->filter(fn($p) => $p->n_gain_score > 0.7)->count(),
            'Sedang (0.3 - 0.7)' => $penilaian->filter(fn($p) => $p->n_gain_score >= 0.3 && $p->n_gain_score <= 0.7)->count(),
            'Rendah (< 0.3)' => $penilaian->filter(fn($p) => $p->n_gain_score < 0.3)->count(),
        ];

        // Pretest vs Posttest average values
        $avgPretest = round($penilaian->avg('nilai_pretest') ?? 0, 2);
        $avgPosttest = round($penilaian->avg('nilai_posttest') ?? 0, 2);
        $avgAfektif = round($penilaian->avg('nilai_afektif') ?? 0, 2);
        $avgPsikomotor = round($penilaian->avg('nilai_psikomotor') ?? 0, 2);
        $avgKehadiran = round($penilaian->avg('nilai_kehadiran') ?? 0, 2);

        return view('admin.events.statistics', compact(
            'event',
            'totalPeserta',
            'penilaian',
            'predikatData',
            'kelulusanData',
            'nGainData',
            'avgPretest',
            'avgPosttest',
            'avgAfektif',
            'avgPsikomotor',
            'avgKehadiran'
        ));
    }

    public function edit(Event $event)
    {
        $this->authorizeEventAccess($event, false);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeEventAccess($event, false);

        $validated = $request->validate([
            'nama_event'      => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi'          => 'nullable|string|max:255',
            'deskripsi'       => 'nullable|string',
            'status'          => 'required|in:persiapan,berlangsung,selesai',
            'kuota'           => 'nullable|integer|min:0',
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        $this->authorizeEventAccess($event, false);

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }

    public function downloadReport(Event $event)
    {
        $this->authorizeEventAccess($event);

        $penilaian = PenilaianAkhir::where('event_id', $event->id)
            ->whereHas('peserta.eventPeserta', function ($q) use ($event) {
                $q->where('event_id', $event->id)->where('status_aktif', true);
            })
            ->with('peserta')
            ->orderBy('ranking', 'asc')
            ->get();

        $pdf = Pdf::loadView('admin.events.report-pdf', compact('event', 'penilaian'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan_Hasil_Baitul_Arqam_' . str_replace(' ', '_', $event->nama_event) . '.pdf');
    }

    public function downloadWinnersReport(Event $event)
    {
        $this->authorizeEventAccess($event);

        $winners = PenilaianAkhir::where('event_id', $event->id)
            ->whereHas('peserta.eventPeserta', function ($q) use ($event) {
                $q->where('event_id', $event->id)->where('status_aktif', true)->where('konfirmasi_kesediaan', 'bersedia');
            })
            ->with('peserta')
            ->orderBy('ranking', 'asc')
            ->take(3)
            ->get();

        $pdf = Pdf::loadView('admin.events.winners-pdf', compact('event', 'winners'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('Piagam_3_Besar_Terbaik_' . str_replace(' ', '_', $event->nama_event) . '.pdf');
    }

    public function downloadAngketReport(Event $event)
    {
        $this->authorizeEventAccess($event);

        $participants = EventPeserta::where('event_id', $event->id)
            ->where('status_aktif', true)
            ->where('konfirmasi_kesediaan', 'bersedia')
            ->with(['peserta'])
            ->get();

        $angketItems = \App\Models\AngketItem::where('event_id', $event->id)->orderBy('urutan')->get();
        $jawabanAngket = \App\Models\AngketJawaban::where('event_id', $event->id)->get();
        $komentars = \App\Models\AngketKomentar::where('event_id', $event->id)->get();

        $pdf = Pdf::loadView('admin.events.angket-report-pdf', compact('event', 'participants', 'angketItems', 'jawabanAngket', 'komentars'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Angket_Per_Peserta_' . str_replace(' ', '_', $event->nama_event) . '.pdf');
    }

    public function exportExcel(Event $event)
    {
        $this->authorizeEventAccess($event);

        $fileName = 'Laporan_Hasil_Baitul_Arqam_' . str_replace(' ', '_', $event->nama_event) . '.xlsx';
        return Excel::download(new PenilaianExport($event->id), $fileName);
    }

    public function assignFacilitators(Request $request, Event $event)
    {
        $this->authorizeEventAccess($event, false);

        $validated = $request->validate([
            'facilitators' => 'nullable|array',
            'facilitators.*' => 'exists:users,id',
        ]);

        $facilitators = $validated['facilitators'] ?? [];

        \Illuminate\Support\Facades\DB::transaction(function () use ($event, $facilitators) {
            $oldIds = $event->facilitators()->pluck('users.id')->toArray();
            
            $event->facilitators()->sync($facilitators);

            // Log activity manually for the assignment
            if (auth()->check()) {
                $user = auth()->user();
                $oldNames = \App\Models\User::whereIn('id', $oldIds)->pluck('name')->toArray();
                $newNames = \App\Models\User::whereIn('id', $facilitators)->pluck('name')->toArray();

                \App\Models\ActivityLog::create([
                    'user_id'     => $user->id,
                    'event_id'    => $event->id,
                    'action'      => 'updated',
                    'role_user'   => $user->role,
                    'model_type'  => get_class($event),
                    'model_id'    => $event->id,
                    'description' => "Admin '{$user->name}' memperbarui penugasan fasilitator untuk event '{$event->nama_event}'",
                    'old_values'  => ['facilitators' => $oldNames],
                    'new_values'  => ['facilitators' => $newNames],
                    'ip_address'  => request()->ip(),
                ]);
            }
        });

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Fasilitator berhasil diperbarui!');
    }

    public function downloadSuratTugas(Event $event)
    {
        $this->authorizeEventAccess($event);

        $facilitators = $event->facilitators()->get();

        $pdf = Pdf::loadView('admin.events.surat-tugas-pdf', compact('event', 'facilitators'))
            ->setPaper('a4', 'portrait')
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream('Surat_Tugas_Fasilitator_' . str_replace(' ', '_', $event->nama_event) . '.pdf');
    }

    public function updateStatus(Request $request, Event $event)
    {
        $this->authorizeEventAccess($event, false);

        $request->validate([
            'status' => 'required|in:persiapan,berlangsung,selesai'
        ]);

        $oldStatus = $event->status;
        $newStatus = $request->status;

        $event->status = $newStatus;
        $event->save();

        if (auth()->check()) {
            $user = auth()->user();
            \App\Models\ActivityLog::create([
                'user_id'     => $user->id,
                'event_id'    => $event->id,
                'action'      => 'updated',
                'role_user'   => $user->role,
                'model_type'  => get_class($event),
                'model_id'    => $event->id,
                'description' => "Admin '{$user->name}' memperbarui status event '{$event->nama_event}' dari '{$oldStatus}' menjadi '{$newStatus}'",
                'old_values'  => ['status' => $oldStatus],
                'new_values'  => ['status' => $newStatus],
                'ip_address'  => request()->ip(),
            ]);
        }

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Status event berhasil diperbarui menjadi ' . ucfirst($newStatus) . '!');
    }

    public function resetEvent(Event $event)
    {
        $this->authorizeEventAccess($event, false);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // Hapus data dinamis yang diinputkan peserta/proses di event ini
            \App\Models\JawabanPeserta::where('event_id', $event->id)->delete();
            \App\Models\PesertaTesMulai::where('event_id', $event->id)->delete();
            \App\Models\Absensi::where('event_id', $event->id)->delete();
            \App\Models\AfektifJawaban::where('event_id', $event->id)->delete();
            \App\Models\AngketJawaban::where('event_id', $event->id)->delete();
            \App\Models\AngketKomentar::where('event_id', $event->id)->delete();
            \App\Models\PsikomotorNilai::where('event_id', $event->id)->delete();
            \App\Models\PenilaianAkhir::where('event_id', $event->id)->delete();
            
            // Hapus RTL & Jawabannya
            $rtlIds = \App\Models\Rtl::where('event_id', $event->id)->pluck('id');
            \App\Models\RtlJawaban::whereIn('rtl_id', $rtlIds)->delete();
            \App\Models\Rtl::where('event_id', $event->id)->delete();

            // Reset status sesi tes ke non-aktif
            \App\Models\SesiTes::where('event_id', $event->id)->update(['status' => 'non-aktif']);

            // Catat log aktivitas reset
            if (auth()->check()) {
                $user = auth()->user();
                \App\Models\ActivityLog::create([
                    'user_id'     => $user->id,
                    'event_id'    => $event->id,
                    'action'      => 'deleted',
                    'role_user'   => $user->role,
                    'model_type'  => get_class($event),
                    'model_id'    => $event->id,
                    'description' => "Admin '{$user->name}' melakukan reset semua data hasil (absensi, jawaban ujian, angket, nilai akhir) untuk event '{$event->nama_event}'",
                    'ip_address'  => request()->ip(),
                ]);
            }

            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('admin.events.show', $event)
                ->with('success', 'Seluruh data evaluasi/hasil event berhasil di-reset!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect()->route('admin.events.show', $event)
                ->with('error', 'Gagal meriset data event: ' . $e->getMessage());
        }
    }

    private function authorizeEventAccess(Event $event, $allowFasilitator = true)
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            if ($event->created_by != $user->id) {
                abort(403, 'Akses ditolak. Anda tidak berhak mengelola event ini.');
            }
        } elseif ($user->isFasilitator()) {
            if (!$allowFasilitator) {
                abort(403, 'Akses ditolak. Fasilitator tidak diizinkan melakukan tindakan ini.');
            }
            if (!$event->facilitators()->where('users.id', $user->id)->exists()) {
                abort(403, 'Akses ditolak. Anda tidak ditugaskan pada event ini.');
            }
        } else {
            abort(403, 'Akses ditolak.');
        }
    }
}
