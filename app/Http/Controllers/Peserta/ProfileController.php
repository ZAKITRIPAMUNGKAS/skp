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
            'nama_lengkap'   => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'no_hp'          => 'nullable|string|max:20',
            'unit_kerja'     => 'nullable|string|max:255',
            'nik'            => 'nullable|string|max:20',
            'nbm'            => 'nullable|string|max:50',
            'jenis_kelamin'  => 'nullable|in:L,P',
            'tempat_lahir'   => 'nullable|string|max:255',
            'tanggal_lahir'  => 'nullable|date',
            'status_pernikahan' => 'nullable|string|max:50',
            'jabatan_aum'    => 'nullable|string|max:255',
            'ukuran_kaos'    => 'nullable|string|max:10',
            'alamat_rumah'   => 'nullable|string',
            'bahasa_dikuasai' => 'required|array|min:1',
            'bahasa_dikuasai.*' => 'string|max:100',
            'hafalan_quran_1' => 'required|string|max:255',
            'foto'           => 'nullable|image|max:2048',
            'password'       => 'nullable|min:6|confirmed'
        ]);

        if ($request->hasFile('foto')) {
            if ($peserta->foto) {
                Storage::disk('public')->delete($peserta->foto);
            }
            $peserta->foto = $request->file('foto')->store('peserta/foto', 'public');
        }

        $peserta->nama_lengkap = $validated['nama_lengkap'];
        $peserta->nama_panggilan = $validated['nama_panggilan'] ?? null;
        $peserta->no_hp = $validated['no_hp'] ?? null;
        $peserta->unit_kerja = $validated['unit_kerja'] ?? null;
        $peserta->nik = $validated['nik'] ?? null;
        $peserta->nbm = $validated['nbm'] ?? null;
        $peserta->jenis_kelamin = $validated['jenis_kelamin'] ?? null;
        $peserta->tempat_lahir = $validated['tempat_lahir'] ?? null;
        $peserta->tanggal_lahir = $validated['tanggal_lahir'] ?? null;
        $peserta->status_pernikahan = $validated['status_pernikahan'] ?? null;
        $peserta->jabatan_aum = $validated['jabatan_aum'] ?? null;
        $peserta->ukuran_kaos = $validated['ukuran_kaos'] ?? null;
        $peserta->alamat_rumah = $validated['alamat_rumah'] ?? null;
        
        // Simpan bahasa asing & hafalan quran
        $peserta->bahasa_dikuasai = json_encode($validated['bahasa_dikuasai']);
        $peserta->hafalan_quran_1 = $validated['hafalan_quran_1'];

        if (!empty($validated['tanggal_lahir'])) {
            $peserta->umur = \Carbon\Carbon::parse($validated['tanggal_lahir'])->age;
        }

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
