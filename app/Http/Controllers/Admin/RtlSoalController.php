<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\RtlSoal;
use Illuminate\Http\Request;

class RtlSoalController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'tipe' => 'required|in:deskripsi,essay,upload',
        ]);

        $maxUrutan = RtlSoal::where('event_id', $event->id)->max('urutan') ?? 0;
        
        RtlSoal::create([
            'event_id' => $event->id,
            'pertanyaan' => $validated['pertanyaan'],
            'tipe' => $validated['tipe'],
            'urutan' => $maxUrutan + 1,
        ]);

        return redirect()->route('admin.events.show', [$event, 'tab' => 'rtl'])
            ->with('success', 'Pertanyaan RTL berhasil ditambahkan!');
    }

    public function update(Request $request, Event $event, RtlSoal $soal)
    {
        if ($soal->event_id != $event->id) {
            abort(404);
        }

        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'tipe' => 'required|in:deskripsi,essay,upload',
        ]);

        $soal->update([
            'pertanyaan' => $validated['pertanyaan'],
            'tipe' => $validated['tipe'],
        ]);

        return redirect()->route('admin.events.show', [$event, 'tab' => 'rtl'])
            ->with('success', 'Pertanyaan RTL berhasil diperbarui!');
    }

    public function destroy(Event $event, RtlSoal $soal)
    {
        if ($soal->event_id != $event->id) {
            abort(404);
        }

        $soal->delete();

        return redirect()->route('admin.events.show', [$event, 'tab' => 'rtl'])
            ->with('success', 'Pertanyaan RTL berhasil dihapus!');
    }

    public function updateDeadline(Request $request, Event $event)
    {
        $validated = $request->validate([
            'rtl_deadline' => 'nullable|date',
        ]);

        $event->update([
            'rtl_deadline' => $validated['rtl_deadline'],
        ]);

        return redirect()->route('admin.events.show', [$event, 'tab' => 'rtl'])
            ->with('success', 'Tanggat waktu (deadline) RTL berhasil diperbarui!');
    }

    public function reorder(Request $request, Event $event)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:rtl_soal,id',
        ]);

        foreach ($request->ids as $index => $id) {
            RtlSoal::where('id', $id)
                ->where('event_id', $event->id)
                ->update(['urutan' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
