<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan formulir login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Tangani permintaan login.
     */
    public function login(Request $request)
    {
        $loginValue = $request->input('email');
        $field = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $loginValue, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (auth()->user()->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            } elseif (auth()->user()->isFasilitator()) {
                return redirect()->intended('/admin/events');
            }

            return redirect()->intended('/peserta/dashboard');
        }

        return back()->withErrors([
            'email' => 'Login (Email/Username) atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan formulir registrasi.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Tangani permintaan registrasi.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'peserta', // Role default untuk registrasi mandiri
        ]);

        // Create peserta profile
        Peserta::create([
            'user_id' => $user->id,
            'nama_lengkap' => $request->name,
            'email' => $request->email,
        ]);

        Auth::login($user);

        return redirect('/peserta/dashboard');
    }

    /**
     * Tangani permintaan logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
