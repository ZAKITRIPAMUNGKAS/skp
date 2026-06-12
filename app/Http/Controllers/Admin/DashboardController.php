<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PenilaianAkhir;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hour = Carbon::now()->format('H');
        if ($hour < 12) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($hour < 18) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }

        // Ambil event terakhir untuk dipandu jika ada
        if (auth()->user()->isFasilitator()) {
            $latestEvent = auth()->user()->assignedEvents()->latest()->first();
        } else {
            $latestEvent = Event::where('created_by', auth()->id())->latest()->first();
        }

        return view('admin.dashboard', compact('greeting', 'latestEvent'));
    }

    public function video()
    {
        return view('admin.video_tutorial');
    }

    public function documentation()
    {
        return view('admin.documentation');
    }
}
