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

        $pretest = SesiTes::where('event_id', $eventId)->where('tipe', 'pretest')->where('status', 'aktif')->exists();
        $posttest = SesiTes::where('event_id', $eventId)->where('tipe', 'posttest')->where('status', 'aktif')->exists();

        return response()->json([
            'success'   => true,
            'event_id'  => $eventId,
            'pretest'   => $pretest,
            'posttest'  => $posttest,
            'status'    => $eventPeserta->event->status
        ]);
    }
}
