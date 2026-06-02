<?php

namespace App\Services;

use App\Models\Absensi;
use App\Models\Event;
use App\Models\EventPeserta;
use App\Models\EventSesi;
use App\Models\PenilaianAkhir;
use App\Models\Peserta;
use Illuminate\Support\Carbon;

class AbsensiService
{
    /**
     * Proses pemindaian kode QR untuk kehadiran.
     */
    public function processScan(string $qrCode, int $sesiId, int $scannedBy): array
    {
        // Langkah 1: Dekode QR — coba format pemisah pipa terlebih dahulu, lalu kembali ke format ARQAM-
        $decoded = $this->decodeQr($qrCode);

        if (!$decoded) {
            return [
                'status'  => 'error',
                'message' => 'QR Code tidak dikenali',
            ];
        }

        $eventId   = $decoded['event_id'];
        $pesertaId = $decoded['peserta_id'];

        // Langkah 2: Periksa apakah peserta ada
        $peserta = Peserta::find($pesertaId);
        if (!$peserta) {
            return [
                'status'  => 'error',
                'message' => 'Peserta tidak ditemukan',
            ];
        }

        // Langkah 3: Periksa apakah peserta terdaftar dalam event
        $eventPeserta = EventPeserta::where('event_id', $eventId)
            ->where('peserta_id', $pesertaId)
            ->first();

        if (!$eventPeserta) {
            return [
                'status'  => 'error',
                'type'    => 'not_registered',
                'message' => 'Peserta tidak terdaftar pada event ini.'
            ];
        }

        // Langkah 4: Periksa apakah sesi ada
        $sesi = EventSesi::where('id', $sesiId)
            ->where('event_id', $eventId)
            ->first();

        if (!$sesi) {
            return [
                'status'  => 'error',
                'message' => 'Sesi tidak ditemukan',
            ];
        }

        if ($sesi->status === 'tutup') {
            return [
                'status'  => 'error',
                'message' => 'Sesi sudah ditutup oleh admin.'
            ];
        }

        // Langkah 5: Periksa apakah sudah menghadiri sesi ini
        $existing = Absensi::where('event_id', $eventId)
            ->where('sesi_id', $sesiId)
            ->where('peserta_id', $pesertaId)
            ->first();

        if ($existing) {
            return [
                'status'     => 'duplicate',
                'nama'       => $peserta->nama_lengkap,
                'unit_kerja' => $peserta->unit_kerja,
                'foto'       => $peserta->foto ? asset('storage/' . $peserta->foto) : null,
                'waktu_scan' => $existing->waktu_scan->format('H:i:s'),
            ];
        }

        // Langkah 6: Masukkan data kehadiran baru
        $now = Carbon::now();
        Absensi::create([
            'event_id'   => $eventId,
            'sesi_id'    => $sesiId,
            'peserta_id' => $pesertaId,
            'waktu_scan' => $now,
            'scanned_by' => $scannedBy,
        ]);

        // Langkah 7: Hitung ulang skor kehadiran
        $this->recalculateAttendance($eventId, $pesertaId);

        // Hitung kehadiran saat ini untuk sesi ini
        $hadirCount = Absensi::where('event_id', $eventId)
            ->where('sesi_id', $sesiId)
            ->count();

        return [
            'status'      => 'success',
            'nama'        => $peserta->nama_lengkap,
            'unit_kerja'  => $peserta->unit_kerja,
            'foto'        => $peserta->foto ? asset('storage/' . $peserta->foto) : null,
            'waktu_scan'  => $now->format('H:i:s'),
            'hadir_count' => $hadirCount,
        ];
    }

    /**
     * Decode QR code string.
     * Supports: "event_id|peserta_id|token" and "ARQAM-event_id-peserta_id-token"
     */
    private function decodeQr(string $qrCode): ?array
    {
        $qrCode = trim($qrCode);

        // Format 1: Base64 JSON dengan HMAC (Format Aman Baru)
        $decodedJson = json_decode(base64_decode($qrCode), true);
        if ($decodedJson && isset($decodedJson['e'], $decodedJson['p'], $decodedJson['t'])) {
            $expectedToken = hash_hmac('sha256', $decodedJson['e'] . '-' . $decodedJson['p'], config('app.key'));
            if (hash_equals($expectedToken, $decodedJson['t'])) {
                return [
                    'event_id'   => (int) $decodedJson['e'],
                    'peserta_id' => (int) $decodedJson['p'],
                    'token'      => $decodedJson['t'],
                ];
            }
            // Jika tanda tangan HMAC tidak valid tetapi formatnya adalah JSON base64, gagalkan segera.
            return null;
        }

        // Format 2: event_id|peserta_id|token_hash (Legacy Support)
        if (str_contains($qrCode, '|')) {
            $parts = explode('|', $qrCode);
            if (count($parts) >= 2) {
                return [
                    'event_id'   => (int) $parts[0],
                    'peserta_id' => (int) $parts[1],
                    'token'      => $parts[2] ?? '',
                ];
            }
        }

        // Format 3: ARQAM-eventId-pesertaId-token (Dukungan Warisan/Lama)
        if (str_starts_with($qrCode, 'ARQAM-')) {
            $parts = explode('-', $qrCode);
            if (count($parts) >= 3) {
                return [
                    'event_id'   => (int) $parts[1],
                    'peserta_id' => (int) $parts[2],
                    'token'      => $parts[3] ?? '',
                ];
            }
        }

        // Try matching from event_peserta.qr_code column directly
        $ep = EventPeserta::where('qr_code', $qrCode)->first();
        if ($ep) {
            return [
                'event_id'   => $ep->event_id,
                'peserta_id' => $ep->peserta_id,
                'token'      => '',
            ];
        }

        return null;
    }

    /**
     * Hitung ulang skor kehadiran untuk peserta dalam suatu event.
     */
    private function recalculateAttendance(int $eventId, int $pesertaId): void
    {
        $totalSesi = EventSesi::where('event_id', $eventId)->count();
        if ($totalSesi === 0) return;

        $totalHadir = Absensi::where('event_id', $eventId)
            ->where('peserta_id', $pesertaId)
            ->distinct('sesi_id')
            ->count('sesi_id');

        $nilaiKehadiran = ($totalHadir / $totalSesi) * 100;

        PenilaianAkhir::updateOrCreate(
            ['event_id' => $eventId, 'peserta_id' => $pesertaId],
            ['nilai_kehadiran' => round($nilaiKehadiran, 2)]
        );
    }
}
