<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class CheckEventAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $event = $request->route('event');
        if (!$event) {
            return $next($request);
        }

        if (!$event instanceof Event) {
            $event = Event::findOrFail($event);
        }

        $user = auth()->user();
        if (!$user) {
            abort(401);
        }

        // 1. Jika user adalah Admin & pemilik event
        if ($user->isAdmin() && $event->created_by === $user->id) {
            return $next($request);
        }

        // 2. Jika user adalah Fasilitator & ditugaskan di event ini
        if ($user->isFasilitator()) {
            $isAssigned = DB::table('event_fasilitator')
                ->where('event_id', $event->id)
                ->where('user_id', $user->id)
                ->exists();

            if ($isAssigned) {
                return $next($request);
            }
        }

        abort(403, 'Akses ditolak. Anda tidak memiliki akses ke event ini.');
    }
}
