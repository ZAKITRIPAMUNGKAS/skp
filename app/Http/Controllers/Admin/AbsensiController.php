<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\EventSesi;
use App\Services\AbsensiService;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    protected AbsensiService $absensiService;

    public function __construct(AbsensiService $absensiService)
    {
        $this->absensiService = $absensiService;
    }

    /**
     * Tampilkan halaman pemindaian kehadiran.
     */
    public function scanPage(Event $event, EventSesi $sesi)
    {
        $totalPeserta = EventPeserta::where('event_id', $event->id)->where('status_aktif', true)->count();
        $hadirCount   = Absensi::where('event_id', $event->id)
            ->where('sesi_id', $sesi->id)
            ->count();

        $recentScans = Absensi::where('event_id', $event->id)
            ->where('sesi_id', $sesi->id)
            ->with('peserta')
            ->orderBy('waktu_scan', 'desc')
            ->take(10)
            ->get()
            ->map(fn($a) => [
                'nama'       => $a->peserta->nama_lengkap,
                'unit_kerja' => $a->peserta->unit_kerja,
                'foto'       => $a->peserta->foto_url,
                'waktu_scan' => $a->waktu_scan->format('H:i:s'),
            ]);

        return view('admin.absensi.scan', compact(
            'event', 'sesi', 'totalPeserta', 'hadirCount', 'recentScans'
        ));
    }

    /**
     * Proses pemindaian QR melalui AJAX.
     */
    public function scan(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string|max:500',
            'sesi_id' => 'required|integer|exists:event_sesi,id',
        ]);

        $result = $this->absensiService->processScan(
            $request->input('qr_code'),
            $request->input('sesi_id'),
            auth()->id()
        );

        return response()->json($result);
    }
}
