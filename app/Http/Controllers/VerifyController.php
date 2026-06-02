<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Peserta;
use App\Models\PenilaianAkhir;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function verify($hash)
    {
        $found = PenilaianAkhir::with(['event', 'peserta'])
            ->where('verification_hash', $hash)
            ->first();

        if (!$found) {
            return view('verify-certificate', ['status' => 'invalid']);
        }

        return view('verify-certificate', [
            'status' => 'valid',
            'penilaian' => $found,
            'event' => $found->event,
            'peserta' => $found->peserta
        ]);
    }
}
