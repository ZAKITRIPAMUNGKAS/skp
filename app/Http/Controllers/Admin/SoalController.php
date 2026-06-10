<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Soal;
use App\Models\PilihanJawaban;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    public function index(Request $request)
    {
        $query = Soal::with(['event', 'pilihanJawaban'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('teks_soal', 'like', "%{$search}%")
                  ->orWhereHas('event', fn($q) => $q->where('nama_event', 'like', "%{$search}%"));
        }

        $soals = $query->paginate(20)->withQueryString();
        $events = Event::with('eventSesi')->orderByDesc('tanggal_mulai')->get();

        return view('admin.soal.index', compact('soals', 'events'));
    }

    /**
     * Simpan soal baru beserta pilihannya.
     */
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'tipe'            => 'required|in:pretest,posttest',
            'event_sesi_id'   => 'required|exists:event_sesi,id',
            'teks_soal'       => 'required|string',
            'pilihan'         => 'required|array|size:4',
            'pilihan.*.teks'  => 'required|string',
            'jawaban_benar'   => 'required|in:A,B,C,D',
        ]);

        $maxUrutan = Soal::where('event_id', $event->id)
            ->where('event_sesi_id', $request->event_sesi_id)
            ->where('tipe', $request->tipe)
            ->max('urutan') ?? 0;

        $soal = Soal::create([
            'event_id'      => $event->id,
            'event_sesi_id' => $request->event_sesi_id,
            'tipe'          => $request->tipe,
            'teks_soal'     => $request->teks_soal,
            'urutan'        => $maxUrutan + 1,
        ]);

        $hurufList = ['A', 'B', 'C', 'D'];
        foreach ($request->pilihan as $i => $pilihan) {
            PilihanJawaban::create([
                'soal_id'      => $soal->id,
                'huruf'        => $hurufList[$i],
                'teks_pilihan' => $pilihan['teks'],
                'is_correct'   => $hurufList[$i] === $request->jawaban_benar,
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'soal'   => $soal->load('pilihanJawaban'),
            ]);
        }

        return back()->with('success', 'Soal berhasil ditambahkan');
    }

    /**
     * Perbarui soal yang ada.
     */
    public function update(Request $request, Event $event, Soal $soal)
    {
        $request->validate([
            'teks_soal'       => 'required|string',
            'pilihan'         => 'required|array|size:4',
            'pilihan.*.teks'  => 'required|string',
            'jawaban_benar'   => 'required|in:A,B,C,D',
        ]);

        $soal->update(['teks_soal' => $request->teks_soal]);

        $hurufList = ['A', 'B', 'C', 'D'];
        foreach ($request->pilihan as $i => $pilihan) {
            $soal->pilihanJawaban()
                ->where('huruf', $hurufList[$i])
                ->update([
                    'teks_pilihan' => $pilihan['teks'],
                    'is_correct'   => $hurufList[$i] === $request->jawaban_benar,
                ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'soal'   => $soal->fresh()->load('pilihanJawaban'),
            ]);
        }

        return back()->with('success', 'Soal berhasil diperbarui');
    }

    /**
     * Hapus soal.
     */
    public function destroy(Event $event, Soal $soal)
    {
        $soal->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['status' => 'success']);
        }

        return back()->with('success', 'Soal berhasil dihapus');
    }

    /**
     * Urutkan ulang soal melalui drag-and-drop.
     */
    public function reorder(Request $request, Event $event)
    {
        $request->validate([
            'order'       => 'required|array',
            'order.*.id'  => 'required|integer',
            'order.*.urutan' => 'required|integer',
        ]);

        foreach ($request->order as $item) {
            Soal::where('id', $item['id'])
                ->where('event_id', $event->id)
                ->update(['urutan' => $item['urutan']]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Gandakan soal pretest ke posttest.
     */
    public function duplicateToPosttest(Request $request, Event $event)
    {
        $request->validate([
            'event_sesi_id' => 'required|exists:event_sesi,id',
        ]);

        // Hapus soal posttest yang ada untuk materi ini
        Soal::where('event_id', $event->id)->where('event_sesi_id', $request->event_sesi_id)->where('tipe', 'posttest')->delete();

        // Salin soal pretest untuk materi ini
        $pretestSoal = Soal::where('event_id', $event->id)
            ->where('event_sesi_id', $request->event_sesi_id)
            ->where('tipe', 'pretest')
            ->with('pilihanJawaban')
            ->orderBy('urutan')
            ->get();

        foreach ($pretestSoal as $soal) {
            $newSoal = Soal::create([
                'event_id'      => $event->id,
                'event_sesi_id' => $request->event_sesi_id,
                'tipe'          => 'posttest',
                'teks_soal'     => $soal->teks_soal,
                'urutan'        => $soal->urutan,
            ]);

            foreach ($soal->pilihanJawaban as $pilihan) {
                PilihanJawaban::create([
                    'soal_id'      => $newSoal->id,
                    'huruf'        => $pilihan->huruf,
                    'teks_pilihan' => $pilihan->teks_pilihan,
                    'is_correct'   => $pilihan->is_correct,
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'count'  => $pretestSoal->count(),
        ]);
    }

    /**
     * Salin soal dari event lain.
     */
    public function copyFromEvent(Request $request, Event $event)
    {
        $request->validate([
            'source_event_id'      => 'required|exists:events,id',
            'source_event_sesi_id' => 'required|exists:event_sesi,id',
            'event_sesi_id'        => 'required|exists:event_sesi,id',
            'tipe'                 => 'required|in:pretest,posttest'
        ]);

        if ($request->source_event_id == $event->id) {
            return back()->with('error', 'Tidak dapat menyalin dari event yang sama.');
        }

        // Verify source session belongs to source event
        $sourceSesi = \App\Models\EventSesi::where('id', $request->source_event_sesi_id)
            ->where('event_id', $request->source_event_id)
            ->first();
        if (!$sourceSesi) {
            return back()->with('error', 'Sesi sumber tidak valid untuk event sumber yang dipilih.');
        }

        // Verify target session belongs to current event
        $targetSesi = \App\Models\EventSesi::where('id', $request->event_sesi_id)
            ->where('event_id', $event->id)
            ->first();
        if (!$targetSesi) {
            return back()->with('error', 'Sesi target tidak valid untuk event saat ini.');
        }

        $sourceSoals = Soal::where('event_id', $request->source_event_id)
            ->where('event_sesi_id', $request->source_event_sesi_id)
            ->where('tipe', $request->tipe)
            ->with('pilihanJawaban')
            ->get();

        if ($sourceSoals->isEmpty()) {
            return back()->with('error', 'Sesi sumber tidak memiliki soal ' . ucfirst($request->tipe));
        }

        $latestUrutan = Soal::where('event_id', $event->id)
            ->where('event_sesi_id', $request->event_sesi_id)
            ->where('tipe', $request->tipe)
            ->max('urutan') ?? 0;

        foreach ($sourceSoals as $s) {
            $latestUrutan++;
            $newSoal = Soal::create([
                'event_id'      => $event->id,
                'event_sesi_id' => $request->event_sesi_id,
                'tipe'          => $request->tipe,
                'teks_soal'     => $s->teks_soal,
                'urutan'        => $latestUrutan,
            ]);

            foreach ($s->pilihanJawaban as $p) {
                PilihanJawaban::create([
                    'soal_id'      => $newSoal->id,
                    'huruf'        => $p->huruf,
                    'teks_pilihan' => $p->teks_pilihan,
                    'is_correct'   => $p->is_correct,
                ]);
            }
        }

        return back()->with('success', count($sourceSoals) . ' Soal ' . ucfirst($request->tipe) . ' berhasil disalin ke sesi ' . $targetSesi->nama_sesi . '.');
    }

    /**
     * Salin soal tunggal ke event lain.
     */
    public function copyToEvent(Request $request, Soal $soal)
    {
        $request->validate([
            'target_event_id' => 'required|exists:events,id',
            'event_sesi_id'   => 'nullable|exists:event_sesi,id',
            'tipe'            => 'required|in:pretest,posttest'
        ]);

        $targetEvent = Event::findOrFail($request->target_event_id);

        $latestUrutan = Soal::where('event_id', $targetEvent->id)
            ->where('tipe', $request->tipe)
            ->max('urutan') ?? 0;

        $newSoal = Soal::create([
            'event_id'      => $targetEvent->id,
            'event_sesi_id' => $request->event_sesi_id,
            'tipe'          => $request->tipe,
            'teks_soal'     => $soal->teks_soal,
            'urutan'        => $latestUrutan + 1,
        ]);

        foreach ($soal->pilihanJawaban as $p) {
            PilihanJawaban::create([
                'soal_id'      => $newSoal->id,
                'huruf'        => $p->huruf,
                'teks_pilihan' => $p->teks_pilihan,
                'is_correct'   => $p->is_correct,
            ]);
        }

        return back()->with('success', 'Soal berhasil disalin ke event: ' . $targetEvent->nama_event);
    }

    /**
     * Salin beberapa soal sekaligus ke event lain.
     */
    public function copyBulk(Request $request)
    {
        $request->validate([
            'soal_ids'        => 'required|array',
            'soal_ids.*'      => 'exists:soal,id',
            'target_event_id' => 'required|exists:events,id',
            'event_sesi_id'   => 'nullable|exists:event_sesi,id',
            'tipe'            => 'required|in:pretest,posttest'
        ]);

        $targetEvent = Event::findOrFail($request->target_event_id);
        $soals = Soal::whereIn('id', $request->soal_ids)->with('pilihanJawaban')->get();

        if ($soals->isEmpty()) {
            return back()->with('error', 'Tidak ada soal yang dipilih.');
        }

        $latestUrutan = Soal::where('event_id', $targetEvent->id)
            ->where('tipe', $request->tipe)
            ->max('urutan') ?? 0;

        $copiedCount = 0;
        foreach ($soals as $soal) {
            $latestUrutan++;
            $newSoal = Soal::create([
                'event_id'      => $targetEvent->id,
                'event_sesi_id' => $request->event_sesi_id,
                'tipe'          => $request->tipe,
                'teks_soal'     => $soal->teks_soal,
                'urutan'        => $latestUrutan,
            ]);

            foreach ($soal->pilihanJawaban as $p) {
                PilihanJawaban::create([
                    'soal_id'      => $newSoal->id,
                    'huruf'        => $p->huruf,
                    'teks_pilihan' => $p->teks_pilihan,
                    'is_correct'   => $p->is_correct,
                ]);
            }
            $copiedCount++;
        }

        return back()->with('success', "{$copiedCount} soal berhasil disalin ke event: " . $targetEvent->nama_event);
    }

    public function getMaterialData(Request $request, Event $event)
    {
        $request->validate([
            'event_sesi_id' => 'required|exists:event_sesi,id',
        ]);

        $eventSesiId = $request->event_sesi_id;

        $pretestSoal = Soal::where('event_id', $event->id)
            ->where('event_sesi_id', $eventSesiId)
            ->where('tipe', 'pretest')
            ->with('pilihanJawaban')
            ->orderBy('urutan')
            ->get();

        $posttestSoal = Soal::where('event_id', $event->id)
            ->where('event_sesi_id', $eventSesiId)
            ->where('tipe', 'posttest')
            ->with('pilihanJawaban')
            ->orderBy('urutan')
            ->get();

        $pretestSesi = \App\Models\SesiTes::where('event_id', $event->id)
            ->where('event_sesi_id', $eventSesiId)
            ->where('tipe', 'pretest')
            ->first();

        $posttestSesi = \App\Models\SesiTes::where('event_id', $event->id)
            ->where('event_sesi_id', $eventSesiId)
            ->where('tipe', 'posttest')
            ->first();

        $pretestRemainingSecs = $pretestSesi && $pretestSesi->status === 'aktif' && $pretestSesi->waktu_mulai ? max(0, ($pretestSesi->waktu_mulai->timestamp + ($pretestSesi->durasi_menit * 60)) - now()->timestamp) : 0;
        $posttestRemainingSecs = $posttestSesi && $posttestSesi->status === 'aktif' && $posttestSesi->waktu_mulai ? max(0, ($posttestSesi->waktu_mulai->timestamp + ($posttestSesi->durasi_menit * 60)) - now()->timestamp) : 0;

        return response()->json([
            'pretestSoal' => $pretestSoal,
            'posttestSoal' => $posttestSoal,
            'pretestSesiStatus' => $pretestSesi?->status ?? 'belum_buka',
            'posttestSesiStatus' => $posttestSesi?->status ?? 'belum_buka',
            'pretestRemainingSecs' => $pretestRemainingSecs,
            'posttestRemainingSecs' => $posttestRemainingSecs,
            'pretestDurasi' => $pretestSesi?->durasi_menit ?? 30,
            'posttestDurasi' => $posttestSesi?->durasi_menit ?? 30,
        ]);
    }
}
