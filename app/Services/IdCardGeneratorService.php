<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventPeserta;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class IdCardGeneratorService
{
    public function generate(Event $event)
    {
        $participants = EventPeserta::where('event_id', $event->id)
            ->where('status_aktif', true)
            ->with('peserta')
            ->get();

        // Buat SVG kode QR untuk setiap peserta
        $qrCodes = [];
        foreach ($participants as $ep) {
            $qrData = $ep->qr_code;
            if (empty($qrData)) {
                $token = hash_hmac('sha256', $event->id . '-' . $ep->peserta_id, config('app.key'));
                $qrData = base64_encode(json_encode([
                    'e' => $event->id,
                    'p' => $ep->peserta_id,
                    't' => $token
                ]));
                $ep->update(['qr_code' => $qrData]);
                $ep->qr_code = $qrData;
            }

            $qrCodes[$ep->peserta_id] = base64_encode(
                QrCode::format('svg')
                    ->size(200)
                    ->errorCorrection('M')
                    ->generate($qrData)
            );
        }

        $pdf = Pdf::loadView('pdf.id-card', [
            'event'        => $event,
            'participants' => $participants,
            'qrCodes'      => $qrCodes,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }
}
