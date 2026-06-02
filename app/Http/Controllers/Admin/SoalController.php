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

        return view('admin.soal.index', compact('soals'));
    }

    /**
     * Simpan soal baru beserta pilihannya.
     */
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'tipe'            => 'required|in:pretest,posttest',
            'teks_soal'       => 'required|string',
            'pilihan'         => 'required|array|size:4',
            'pilihan.*.teks'  => 'required|string',
            'jawaban_benar'   => 'required|in:A,B,C,D',
        ]);

        $maxUrutan = Soal::where('event_id', $event->id)
            ->where('tipe', $request->tipe)
            ->max('urutan') ?? 0;

        $soal = Soal::create([
            'event_id' => $event->id,
            'tipe'     => $request->tipe,
            'teks_soal'=> $request->teks_soal,
            'urutan'   => $maxUrutan + 1,
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
    public function duplicateToPosttest(Event $event)
    {
        // Hapus soal posttest yang ada
        Soal::where('event_id', $event->id)->where('tipe', 'posttest')->delete();

        // Salin soal pretest
        $pretestSoal = Soal::where('event_id', $event->id)
            ->where('tipe', 'pretest')
            ->with('pilihanJawaban')
            ->orderBy('urutan')
            ->get();

        foreach ($pretestSoal as $soal) {
            $newSoal = Soal::create([
                'event_id'  => $event->id,
                'tipe'      => 'posttest',
                'teks_soal' => $soal->teks_soal,
                'urutan'    => $soal->urutan,
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
            'source_event_id' => 'required|exists:events,id',
            'tipe'            => 'required|in:pretest,posttest'
        ]);

        if ($request->source_event_id == $event->id) {
            return back()->with('error', 'Tidak dapat menyalin dari event yang sama.');
        }

        $sourceSoals = Soal::where('event_id', $request->source_event_id)
            ->where('tipe', $request->tipe)
            ->with('pilihanJawaban')
            ->get();

        if ($sourceSoals->isEmpty()) {
            return back()->with('error', 'Event sumber tidak memiliki soal ' . ucfirst($request->tipe));
        }

        $latestUrutan = Soal::where('event_id', $event->id)->where('tipe', $request->tipe)->max('urutan') ?? 0;

        foreach ($sourceSoals as $s) {
            $latestUrutan++;
            $newSoal = Soal::create([
                'event_id'  => $event->id,
                'tipe'      => $request->tipe,
                'teks_soal' => $s->teks_soal,
                'urutan'    => $latestUrutan,
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

        return back()->with('success', count($sourceSoals) . ' Soal ' . ucfirst($request->tipe) . ' berhasil disalin.');
    }

    /**
     * Salin soal tunggal ke event lain.
     */
    public function copyToEvent(Request $request, Soal $soal)
    {
        $request->validate([
            'target_event_id' => 'required|exists:events,id',
            'tipe'            => 'required|in:pretest,posttest'
        ]);

        $targetEvent = Event::findOrFail($request->target_event_id);

        $latestUrutan = Soal::where('event_id', $targetEvent->id)
            ->where('tipe', $request->tipe)
            ->max('urutan') ?? 0;

        $newSoal = Soal::create([
            'event_id'  => $targetEvent->id,
            'tipe'      => $request->tipe,
            'teks_soal' => $soal->teks_soal,
            'urutan'    => $latestUrutan + 1,
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
}
