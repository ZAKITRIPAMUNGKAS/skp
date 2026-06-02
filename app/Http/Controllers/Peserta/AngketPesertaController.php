<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\AngketItem;
use App\Models\AngketJawaban;
use App\Models\AngketKomentar;
use App\Models\Event;
use App\Models\EventPeserta;
use Illuminate\Http\Request;

class AngketPesertaController extends Controller
{
    public function indexRoot()
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        $eventPeserta = EventPeserta::where('peserta_id', $peserta->id)
            ->whereHas('event', function ($q) {
                $q->whereIn('status', ['persiapan', 'berlangsung', 'selesai']);
            })
            ->latest()
            ->first();

        if ($eventPeserta && $eventPeserta->event) {
            return redirect()->route('peserta.angket.fill', $eventPeserta->event->id);
        }

        return redirect()->route('peserta.dashboard')->with('error', 'Belum ada acara aktif untuk mengisi angket evaluasi.');
    }

    public function fill(Event $event)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) abort(403);

        EventPeserta::where('event_id', $event->id)->where('peserta_id', $peserta->id)->firstOrFail();

        $items = AngketItem::where('event_id', $event->id)->orderBy('kategori')->orderBy('urutan')->get()->groupBy('kategori');

        $existingAnswers = AngketJawaban::where('event_id', $event->id)->where('peserta_id', $peserta->id)
            ->pluck('jawaban', 'item_id')->toArray();

        $existingComment = AngketKomentar::where('event_id', $event->id)->where('peserta_id', $peserta->id)->first();

        return view('peserta.angket.fill', compact('event', 'items', 'existingAnswers', 'existingComment'));
    }

    public function save(Request $request, Event $event)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) return response()->json(['error' => 'Unauthorized'], 403);

        $request->validate([
            'answers'            => 'required|array',
            'answers.*.item_id'  => 'required|integer',
            'answers.*.jawaban'  => 'required|in:A,B,C,D',
        ]);

        foreach ($request->answers as $ans) {
            AngketJawaban::updateOrCreate(
                ['event_id' => $event->id, 'peserta_id' => $peserta->id, 'item_id' => $ans['item_id']],
                ['jawaban' => $ans['jawaban']]
            );
        }

        if ($request->filled('komentar')) {
            AngketKomentar::updateOrCreate(
                ['event_id' => $event->id, 'peserta_id' => $peserta->id],
                ['komentar' => $request->komentar]
            );
        }

        return response()->json(['status' => 'success']);
    }
}
