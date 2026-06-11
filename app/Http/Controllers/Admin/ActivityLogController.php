<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->paginate(50)->withQueryString();
        $actions = ActivityLog::select('action')->distinct()->pluck('action');

        return view('admin.logs.index', compact('logs', 'actions'));
    }

    public function clearSoal()
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // Hapus semua pilihan jawaban dan soal
            // (karena cascade constrained delete, menghapus soal akan menghapus pilihan_jawaban)
            \App\Models\Soal::query()->delete();

            // Catat ke log aktivitas
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'description' => 'Menghapus seluruh data soal di Bank Soal',
                'ip_address' => request()->ip()
            ]);

            \Illuminate\Support\Facades\DB::commit();
            return redirect()->back()->with('success', 'Berhasil menghapus seluruh data Bank Soal.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data Bank Soal: ' . $e->getMessage());
        }
    }

    public function clearPeserta()
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // 1. Hapus pendaftaran event
            \App\Models\EventPeserta::query()->delete();
            
            // 2. Hapus profile peserta
            \App\Models\Peserta::query()->delete();
            
            // 3. Hapus user account yang role-nya peserta
            \App\Models\User::where('role', 'peserta')->delete();

            // Catat ke log aktivitas
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'description' => 'Menghapus seluruh data peserta beserta akun loginnya',
                'ip_address' => request()->ip()
            ]);

            \Illuminate\Support\Facades\DB::commit();
            return redirect()->back()->with('success', 'Berhasil menghapus seluruh data peserta beserta akun loginnya.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data peserta: ' . $e->getMessage());
        }
    }
}
