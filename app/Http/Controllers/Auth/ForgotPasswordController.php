<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'no_hp'    => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();
        if (!$user || !$user->peserta) {
            return back()->withErrors(['username' => 'Username tidak ditemukan.'])->withInput();
        }

        $peserta = $user->peserta;
        // Strip non-digit chars for comparison
        $inputHp  = preg_replace('/\D/', '', $request->no_hp);
        $storedHp = preg_replace('/\D/', '', $peserta->no_hp ?? '');

        if (empty($storedHp) || $inputHp !== $storedHp) {
            return back()->withErrors(['no_hp' => 'Nomor HP tidak cocok dengan data kami.'])->withInput();
        }

        // Store verified username in session
        session(['password_reset_username' => $user->username]);
        return redirect()->route('password.reset.form');
    }

    public function showResetForm()
    {
        if (!session('password_reset_username')) {
            return redirect()->route('password.forgot');
        }
        return view('auth.reset-password');
    }

    public function reset(Request $request)
    {
        if (!session('password_reset_username')) {
            return redirect()->route('password.forgot');
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('username', session('password_reset_username'))->first();
        if (!$user) {
            return redirect()->route('password.forgot')->withErrors(['error' => 'Sesi tidak valid.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget('password_reset_username');

        return redirect()->route('login')->with('success', 'Password berhasil diubah! Silakan login dengan password baru Anda.');
    }
}
