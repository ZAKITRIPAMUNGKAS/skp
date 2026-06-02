<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\EventPeserta;

class ProfileController extends Controller
{
    public function index()
    {
        $peserta = auth()->user()->peserta;
        if (!$peserta) {
            abort(403, 'Akses ditolak.');
        }
        
        $history = EventPeserta::where('peserta_id', $peserta->id)
            ->whereHas('event')
            ->with(['event'])
            ->orderByDesc('created_at')
            ->get();

        return view('peserta.profile.index', compact('peserta', 'history'));
    }

    public function update(Request $request)
    {
        $peserta = auth()->user()->peserta;

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp'        => 'nullable|string|max:20',
            'unit_kerja'   => 'nullable|string|max:255',
            'foto'         => 'nullable|image|max:2048',
            'password'     => 'nullable|min:6|confirmed'
        ]);

        if ($request->hasFile('foto')) {
            if ($peserta->foto) {
                Storage::disk('public')->delete($peserta->foto);
            }
            $peserta->foto = $request->file('foto')->store('peserta/foto', 'public');
        }

        $peserta->nama_lengkap = $validated['nama_lengkap'];
        $peserta->no_hp = $validated['no_hp'];
        $peserta->unit_kerja = $validated['unit_kerja'];
        $peserta->save();

        $user = auth()->user();
        $user->name = $validated['nama_lengkap'];
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
