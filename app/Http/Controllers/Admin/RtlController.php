<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rtl;
use App\Models\Event;
use Illuminate\Http\Request;

class RtlController extends Controller
{
    public function index(Request $request)
    {
        $query = Rtl::with(['peserta', 'event'])->latest();

        // Search by Participant Name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('peserta', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%");
            });
        }

        // Filter by Event
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        // Filter by Category
        if ($request->filled('kategori')) {
            $query->where('kategori_rtl', $request->kategori);
        }

        $rtls = $query->paginate(15)->withQueryString();
        $events = Event::latest()->get();

        return view('admin.rtl.index', compact('rtls', 'events'));
    }

    public function show(Rtl $rtl)
    {
        $rtl->load(['peserta', 'event']);
        return view('admin.rtl.show', compact('rtl'));
    }
}
