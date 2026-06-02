<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AfektifButir;
use App\Models\AfektifJawaban;
use App\Models\AfektifSubAspek;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\PenilaianAkhir;
use Illuminate\Http\Request;

class AfektifController extends Controller
{
    /**
     * Simpan sub-aspek baru.
     */
    public function storeSubAspek(Request $request, Event $event)
    {
        $request->validate([
            'nama_sub_aspek' => 'required|string|max:255',
        ]);

        $maxUrutan = AfektifSubAspek::where('event_id', $event->id)->max('urutan') ?? 0;

        $subAspek = AfektifSubAspek::create([
            'event_id'       => $event->id,
            'nama_sub_aspek' => $request->nama_sub_aspek,
            'urutan'         => $maxUrutan + 1,
            'status'         => 'belum_buka',
        ]);

        return response()->json(['status' => 'success', 'sub_aspek' => $subAspek->load('butir')]);
    }

    /**
     * Perbarui sub-aspek.
     */
    public function updateSubAspek(Request $request, Event $event, AfektifSubAspek $subAspek)
    {
        $request->validate(['nama_sub_aspek' => 'required|string|max:255']);
        $subAspek->update(['nama_sub_aspek' => $request->nama_sub_aspek]);
        return response()->json(['status' => 'success', 'sub_aspek' => $subAspek]);
    }

    /**
     * Hapus sub-aspek.
     */
    public function destroySubAspek(Event $event, AfektifSubAspek $subAspek)
    {
        $subAspek->delete();
        return response()->json(['status' => 'success']);
    }

    /**
     * Alihkan status sub-aspek (belum_buka → aktif → tutup).
     */
    public function toggleStatus(Request $request, Event $event, AfektifSubAspek $subAspek)
    {
        $request->validate(['status' => 'required|in:belum_buka,aktif,tutup']);
        $subAspek->update(['status' => $request->status]);
        return response()->json(['status' => 'success', 'current_status' => $subAspek->status]);
    }

    /**
     * Simpan pernyataan (butir) baru.
     */
    public function storeButir(Request $request, Event $event, AfektifSubAspek $subAspek)
    {
        $request->validate([
            'teks_pernyataan' => 'required|string',
            'is_positif'      => 'required|boolean',
        ]);

        $maxUrutan = AfektifButir::where('sub_aspek_id', $subAspek->id)->max('urutan') ?? 0;

        $butir = AfektifButir::create([
            'sub_aspek_id'    => $subAspek->id,
            'teks_pernyataan' => $request->teks_pernyataan,
            'is_positif'      => $request->is_positif,
            'urutan'          => $maxUrutan + 1,
        ]);

        return response()->json(['status' => 'success', 'butir' => $butir]);
    }

    /**
     * Perbarui pernyataan.
     */
    public function updateButir(Request $request, Event $event, AfektifButir $butir)
    {
        $request->validate([
            'teks_pernyataan' => 'required|string',
            'is_positif'      => 'required|boolean',
        ]);

        $butir->update([
            'teks_pernyataan' => $request->teks_pernyataan,
            'is_positif'      => $request->is_positif,
        ]);

        return response()->json(['status' => 'success', 'butir' => $butir]);
    }

    /**
     * Hapus pernyataan.
     */
    public function destroyButir(Event $event, AfektifButir $butir)
    {
        $butir->delete();
        return response()->json(['status' => 'success']);
    }

    /**
     * Urutkan ulang pernyataan.
     */
    public function reorderButir(Request $request, Event $event, AfektifSubAspek $subAspek)
    {
        $request->validate([
            'order'          => 'required|array',
            'order.*.id'     => 'required|integer',
            'order.*.urutan' => 'required|integer',
        ]);

        foreach ($request->order as $item) {
            AfektifButir::where('id', $item['id'])
                ->where('sub_aspek_id', $subAspek->id)
                ->update(['urutan' => $item['urutan']]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Dapatkan ringkasan penyelesaian untuk admin.
     */
    public function summary(Event $event)
    {
        $subAspeks = AfektifSubAspek::where('event_id', $event->id)
            ->with('butir')
            ->orderBy('urutan')
            ->get();

        $totalPeserta = EventPeserta::where('event_id', $event->id)->count();

        $summaryData = $subAspeks->map(function ($sa) use ($event, $totalPeserta) {
            $butirCount = $sa->butir->count();
            if ($butirCount === 0) {
                return [
                    'id' => $sa->id,
                    'nama' => $sa->nama_sub_aspek,
                    'total_peserta' => $totalPeserta,
                    'completed' => 0,
                    'percentage' => 0,
                ];
            }

            // Hitung peserta yang menjawab SEMUA butir di sub-aspek ini
            $completed = AfektifJawaban::where('event_id', $event->id)
                ->where('sub_aspek_id', $sa->id)
                ->selectRaw('peserta_id, COUNT(DISTINCT butir_id) as cnt')
                ->groupBy('peserta_id')
                ->havingRaw('cnt >= ?', [$butirCount])
                ->count();

            return [
                'id' => $sa->id,
                'nama' => $sa->nama_sub_aspek,
                'total_peserta' => $totalPeserta,
                'completed' => $completed,
                'percentage' => $totalPeserta > 0 ? round(($completed / $totalPeserta) * 100) : 0,
            ];
        });

        return response()->json($summaryData);
    }
}
