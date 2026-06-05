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
            $qrCodes[$ep->peserta_id] = base64_encode(
                QrCode::format('svg')
                    ->size(200)
                    ->errorCorrection('M')
                    ->generate($ep->qr_code ?? 'ARQAM-' . $event->id . '-' . $ep->peserta_id)
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
