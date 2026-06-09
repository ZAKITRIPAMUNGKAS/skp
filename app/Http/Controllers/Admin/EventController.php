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

        $query->latest();

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

        // Logs aktivitas khusus untuk event ini (Dilihat oleh Admin Utama)
        $eventLogs = [];
        if (auth()->user()->isAdmin()) {
            $eventLogs = \App\Models\ActivityLog::where('event_id', $event->id)
                ->with('user')
                ->latest()
                ->take(100)
                ->get();
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
            'eventLogs'
        ));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
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

        $event->update($validated);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus!');
    }

    public function downloadReport(Event $event)
    {
        $penilaian = PenilaianAkhir::where('event_id', $event->id)
            ->whereHas('peserta.eventPeserta', function ($q) use ($event) {
                $q->where('event_id', $event->id)->where('status_aktif', true);
            })
            ->with('peserta')
            ->orderBy('ranking', 'asc') // Peringkat 1 = terbaik
            ->get();

        $pdf = Pdf::loadView('admin.events.report-pdf', compact('event', 'penilaian'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan_Hasil_Baitul_Arqam_' . str_replace(' ', '_', $event->nama_event) . '.pdf');
    }

    public function downloadWinnersReport(Event $event)
    {
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
        $fileName = 'Laporan_Hasil_Baitul_Arqam_' . str_replace(' ', '_', $event->nama_event) . '.xlsx';
        return Excel::download(new PenilaianExport($event->id), $fileName);
    }

    public function assignFacilitators(Request $request, Event $event)
    {
        // Hanya bisa dilakukan oleh Admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

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
        $facilitators = $event->facilitators()->get();

        $pdf = Pdf::loadView('admin.events.surat-tugas-pdf', compact('event', 'facilitators'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Surat_Tugas_Fasilitator_' . str_replace(' ', '_', $event->nama_event) . '.pdf');
    }
}
