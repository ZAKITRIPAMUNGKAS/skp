<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\EventPeserta;

class CheckEventStarted
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->isPeserta() && $user->peserta) {
            $peserta = $user->peserta;
            
            // Dapatkan event aktif terbaru untuk peserta ini
            $eventPeserta = EventPeserta::where('peserta_id', $peserta->id)
                ->whereHas('event', function ($q) {
                    $q->whereIn('status', ['persiapan', 'berlangsung', 'selesai']);
                })
                ->latest()
                ->first();

            if ($eventPeserta && $eventPeserta->event) {
                $event = $eventPeserta->event;

                // Jika status event masih persiapan
                if ($event->status === 'persiapan') {
                    // Hanya izinkan akses ke dashboard, profile, and logout
                    $allowedRoutes = ['peserta.dashboard', 'peserta.profile.index', 'peserta.profile.update', 'logout', 'peserta.notifications.poll'];
                    
                    $currentRouteName = $request->route() ? $request->route()->getName() : '';
                    
                    if (!in_array($currentRouteName, $allowedRoutes)) {
                        return redirect()->route('peserta.dashboard')
                            ->with('error', 'Kegiatan Baitul Arqam belum dimulai (Status: Persiapan). Silakan menunggu arahan dari panitia.');
                    }
                }
            }
        }

        return $next($request);
    }
}
