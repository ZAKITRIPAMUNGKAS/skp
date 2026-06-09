<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileCompletion
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->isPeserta()) {
            $peserta = $user->peserta;

            // Jika belum ada data peserta atau profil belum lengkap
            if (!$peserta || !$peserta->isComplete()) {
                // Berikan akses hanya ke halaman profil dan aksi update profil, serta logout
                if (!$request->routeIs('peserta.profile.*') && !$request->routeIs('logout')) {
                    return redirect()->route('peserta.profile.index')
                        ->with('error', 'Silakan lengkapi data profil Anda terlebih dahulu untuk dapat mengakses dashboard dan fitur lainnya.');
                }
            }
        }

        return $next($request);
    }
}
