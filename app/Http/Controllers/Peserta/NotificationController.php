<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\EventPeserta;
use App\Models\SesiTes;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function poll(Request $request)
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) {
            return response()->json(['success' => false]);
        }

        $eventPeserta = EventPeserta::where('peserta_id', $peserta->id)
            ->whereHas('event', function ($q) {
                $q->whereIn('status', ['berlangsung', 'persiapan', 'selesai']);
            })
            ->latest()
            ->first();

        if (!$eventPeserta) {
             return response()->json(['success' => false]);
        }

        $eventId = $eventPeserta->event_id;

        $pretestSesi = SesiTes::where('event_id', $eventId)->where('tipe', 'pretest')->where('status', 'aktif')->first();
        $posttestSesi = SesiTes::where('event_id', $eventId)->where('tipe', 'posttest')->where('status', 'aktif')->first();

        return response()->json([
            'success'   => true,
            'event_id'  => $eventId,
            'pretest'   => $pretestSesi ? true : false,
            'pretest_sesi_id' => $pretestSesi ? $pretestSesi->event_sesi_id : null,
            'posttest'  => $posttestSesi ? true : false,
            'posttest_sesi_id' => $posttestSesi ? $posttestSesi->event_sesi_id : null,
            'status'    => $eventPeserta->event->status
        ]);
    }
}
