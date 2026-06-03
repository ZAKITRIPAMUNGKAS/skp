<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SesiTes;
use Illuminate\Http\Request;

class SesiTesController extends Controller
{
    /**
     * Buka sesi tes (pretest atau posttest).
     */
    public function open(Request $request, Event $event)
    {
        $request->validate([
            'tipe'          => 'required|in:pretest,posttest',
            'event_sesi_id' => 'required|exists:event_sesi,id',
            'durasi_menit'  => 'nullable|integer|min:5|max:180',
        ]);

        $sesiTes = SesiTes::updateOrCreate(
            ['event_id' => $event->id, 'tipe' => $request->tipe, 'event_sesi_id' => $request->event_sesi_id],
            [
                'status'       => 'aktif',
                'waktu_mulai'  => now(),
                'waktu_selesai'=> null,
                'durasi_menit' => $request->durasi_menit ?? 30,
            ]
        );

        return response()->json([
            'status'      => 'success',
            'sesi_tes'    => $sesiTes,
            'waktu_mulai' => $sesiTes->waktu_mulai->format('H:i:s'),
        ]);
    }

    /**
     * Tutup sesi tes.
     */
    public function close(Request $request, Event $event)
    {
        $request->validate([
            'tipe'          => 'required|in:pretest,posttest',
            'event_sesi_id' => 'required|exists:event_sesi,id',
        ]);

        $sesiTes = SesiTes::where('event_id', $event->id)
            ->where('event_sesi_id', $request->event_sesi_id)
            ->where('tipe', $request->tipe)
            ->first();

        if ($sesiTes) {
            $sesiTes->update([
                'status'        => 'tutup',
                'waktu_selesai' => now(),
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Dapatkan status sesi tes saat ini.
     */
    public function status(Request $request, Event $event, string $tipe)
    {
        $request->validate([
            'event_sesi_id' => 'required|exists:event_sesi,id',
        ]);

        $sesiTes = SesiTes::where('event_id', $event->id)
            ->where('event_sesi_id', $request->event_sesi_id)
            ->where('tipe', $tipe)
            ->first();

        return response()->json([
            'status'        => $sesiTes?->status ?? 'belum_buka',
            'waktu_mulai'   => $sesiTes?->waktu_mulai?->toIso8601String(),
            'durasi_menit'  => $sesiTes?->durasi_menit,
        ]);
    }
}
