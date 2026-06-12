<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rtl;
use App\Models\Event;
use Illuminate\Http\Request;

class RtlController extends Controller
{
    public function show(Event $event, Rtl $rtl)
    {
        if ($rtl->event_id != $event->id) {
            abort(404);
        }
        $rtl->load(['peserta', 'event', 'jawaban.soal']);
        return view('admin.rtl.show', compact('rtl', 'event'));
    }
}
