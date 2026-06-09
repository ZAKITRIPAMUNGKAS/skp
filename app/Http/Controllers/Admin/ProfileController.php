<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $user->id,
            'username'     => 'required|string|max:50|unique:users,username,' . $user->id . '|alpha_dash',
            'password'     => 'nullable|string|min:6|confirmed',
            'cropped_foto' => 'nullable|string',
        ], [
            'name.required'       => 'Nama wajib diisi.',
            'email.required'      => 'Email wajib diisi.',
            'email.unique'        => 'Email sudah digunakan oleh akun lain.',
            'username.required'   => 'Username wajib diisi.',
            'username.unique'     => 'Username sudah digunakan oleh akun lain.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip, dan garis bawah.',
            'password.min'        => 'Password minimal 6 karakter.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->username = $validated['username'];

        if ($request->filled('cropped_foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto baru
            $base64Image = $request->cropped_foto;
            $image_parts = explode(";base64,", $base64Image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1] ?? 'jpeg';
            $image_base64 = base64_decode($image_parts[1]);
            
            $fileName = 'foto_' . time() . '_' . Str::random(10) . '.' . $image_type;
            Storage::disk('public')->put('users/' . $fileName, $image_base64);
            $user->foto = 'users/' . $fileName;
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
