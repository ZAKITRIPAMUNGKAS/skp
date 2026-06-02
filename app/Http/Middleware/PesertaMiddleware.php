<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PesertaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isPeserta()) {
            abort(403, 'Akses ditolak. Anda bukan peserta.');
        }

        return $next($request);
    }
}
