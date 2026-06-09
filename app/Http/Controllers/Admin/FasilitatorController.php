<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FasilitatorController extends Controller
{
    /**
     * Tampilkan daftar semua fasilitator.
     */
    public function index(Request $request)
    {
        $query = User::select(['id', 'name', 'email', 'username', 'role', 'foto', 'created_at'])
            ->where('role', 'fasilitator')
            ->withCount('assignedEvents')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        $fasilitators = $query->paginate(15)->withQueryString();

        return view('admin.fasilitator.index', compact('fasilitators'));
    }

    /**
     * Tampilkan detail fasilitator beserta event yang ditugaskan.
     */
    public function show(int $id)
    {
        $fasilitator = User::where('role', 'fasilitator')
            ->with(['assignedEvents' => function($query) {
                $query->latest();
            }])
            ->findOrFail($id);

        return view('admin.fasilitator.show', compact('fasilitator'));
    }

    /**
     * Simpan akun fasilitator baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'username' => 'required|string|max:50|unique:users,username|alpha_dash',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required'          => 'Nama wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.unique'           => 'Email sudah digunakan oleh akun lain.',
            'username.required'      => 'Username wajib diisi.',
            'username.unique'        => 'Username sudah digunakan oleh akun lain.',
            'username.alpha_dash'    => 'Username hanya boleh berisi huruf, angka, strip, dan garis bawah.',
            'password.required'      => 'Password wajib diisi.',
            'password.min'           => 'Password minimal 6 karakter.',
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',
        ]);

        DB::beginTransaction();
        try {
            $fotoPath = null;
            if ($request->filled('cropped_foto')) {
                $base64Image = $request->cropped_foto;
                $image_parts = explode(";base64,", $base64Image);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1] ?? 'jpeg';
                $image_base64 = base64_decode($image_parts[1]);
                
                $fileName = 'foto_' . time() . '_' . Str::random(10) . '.' . $image_type;
                \Illuminate\Support\Facades\Storage::disk('public')->put('users/' . $fileName, $image_base64);
                $fotoPath = 'users/' . $fileName;
            }

            User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'role'     => 'fasilitator',
                'foto'     => $fotoPath,
            ]);

            DB::commit();

            return redirect()->route('admin.fasilitator.index')
                ->with('success', "Akun fasilitator '{$validated['name']}' berhasil dibuat!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Gagal membuat akun fasilitator: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hapus akun fasilitator beserta semua penugasannya.
     */
    public function destroy(int $id)
    {
        $fasilitator = User::where('role', 'fasilitator')->findOrFail($id);

        DB::beginTransaction();
        try {
            // Lepas semua penugasan event
            $fasilitator->assignedEvents()->detach();

            // Hapus user
            $fasilitator->delete();

            DB::commit();

            return redirect()->route('admin.fasilitator.index')
                ->with('success', "Akun fasilitator berhasil dihapus.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus fasilitator: ' . $e->getMessage());
        }
    }

    /**
     * Reset password fasilitator.
     */
    public function resetPassword(Request $request, int $id)
    {
        $fasilitator = User::where('role', 'fasilitator')->findOrFail($id);

        $validated = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required'  => 'Password baru wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $fasilitator->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', "Password fasilitator '{$fasilitator->name}' berhasil direset!");
    }
}
