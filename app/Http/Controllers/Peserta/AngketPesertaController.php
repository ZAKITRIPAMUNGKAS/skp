<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\AngketItem;
use App\Models\AngketJawaban;
use App\Models\AngketKomentar;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\Peserta;
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

        // Ambil semua peserta aktif di event ini kecuali diri sendiri untuk nominasi
        $eventParticipants = Peserta::whereHas('eventPeserta', function ($q) use ($event) {
            $q->where('event_id', $event->id)->where('status_aktif', true);
        })
        ->where('id', '!=', $peserta->id)
        ->orderBy('nama_lengkap', 'asc')
        ->get(['id', 'nama_lengkap']);

        return view('peserta.angket.fill', compact('event', 'items', 'existingAnswers', 'existingComment', 'eventParticipants'));
    }

    public function save(Request $request, Event $event)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) return response()->json(['error' => 'Unauthorized'], 403);

        $request->validate([
            'answers'            => 'required|array',
            'answers.*.item_id'  => 'required|integer',
            'answers.*.jawaban'  => 'required|string',
            'nominasi_disiplin_id' => 'nullable|integer|exists:peserta,id',
            'nominasi_aktif_id'    => 'nullable|integer|exists:peserta,id',
            'nominasi_favorit_id'  => 'nullable|integer|exists:peserta,id',
        ]);

        foreach ($request->answers as $ans) {
            AngketJawaban::updateOrCreate(
                ['event_id' => $event->id, 'peserta_id' => $peserta->id, 'item_id' => $ans['item_id']],
                ['jawaban' => $ans['jawaban']]
            );
        }

        AngketKomentar::updateOrCreate(
            ['event_id' => $event->id, 'peserta_id' => $peserta->id],
            [
                'komentar'             => $request->komentar ?? '',
                'nominasi_disiplin_id' => $request->nominasi_disiplin_id,
                'nominasi_aktif_id'    => $request->nominasi_aktif_id,
                'nominasi_favorit_id'  => $request->nominasi_favorit_id,
            ]
        );

        return response()->json(['status' => 'success']);
    }
}
