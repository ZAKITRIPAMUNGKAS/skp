<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventSesi;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'nama_sesi' => 'required|string|max:255',
        ]);

        $maxUrutan = $event->sesi()->max('urutan') ?? 0;

        $event->sesi()->create([
            'nama_sesi' => $validated['nama_sesi'],
            'urutan'    => $maxUrutan + 1,
        ]);

        return back()->with('success', 'Sesi berhasil ditambahkan!');
    }

    public function update(Request $request, Event $event, EventSesi $session)
    {
        $validated = $request->validate([
            'nama_sesi' => 'required|string|max:255',
        ]);

        $session->update($validated);

        return back()->with('success', 'Sesi berhasil diperbarui!');
    }

    public function destroy(Event $event, EventSesi $session)
    {
        $session->delete();

        // Urutkan ulang sesi yang tersisa
        $event->sesi()->orderBy('urutan')->get()->each(function ($sesi, $index) {
            $sesi->update(['urutan' => $index + 1]);
        });

        return back()->with('success', 'Sesi berhasil dihapus!');
    }

    public function reorder(Request $request, Event $event)
    {
        $request->validate([
            'order'        => 'required|array',
            'order.*.id'   => 'required|integer|exists:event_sesi,id',
            'order.*.urutan' => 'required|integer|min:1',
        ]);

        foreach ($request->order as $item) {
            EventSesi::where('id', $item['id'])
                ->where('event_id', $event->id)
                ->update(['urutan' => $item['urutan']]);
        }

        return response()->json(['success' => true]);
    }
}
