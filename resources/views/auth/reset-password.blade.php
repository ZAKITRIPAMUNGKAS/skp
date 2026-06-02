@extends('layouts.app')

@section('title', 'Reset Password — ARQAM App')

@section('content')
<style>
    body { background-color: #f8fafc; }

    :root {
        --premium-ease: cubic-bezier(0.65, 0, 0.076, 1);
    }

    .card-wrapper {
        animation: cardEntrance 0.9s var(--premium-ease) forwards;
        opacity: 0;
        transform: translateY(28px) scale(0.97);
    }

    @keyframes cardEntrance {
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    @keyframes floatY {
        0%, 100% { transform: translateY(0px); }
        50%       { transform: translateY(-10px); }
    }

    .animate-float { animation: floatY 4s ease-in-out infinite; }

    .strength-bar {
        transition: width 0.4s ease, background-color 0.4s ease;
    }

    [x-cloak] { display: none !important; }
</style>

<div class="min-h-screen flex items-center justify-center p-4 lg:p-8 bg-gray-50/50">

    {{-- Back --}}
    <div class="absolute top-4 left-4 z-50">
        <a href="{{ route('password.forgot') }}"
           class="group flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-md border border-gray-100 rounded-full text-xs font-bold text-gray-500 hover:text-primary transition-all active:scale-95 shadow-sm">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Main card --}}
    <div class="card-wrapper w-full max-w-4xl">
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-primary/10 overflow-hidden flex flex-col lg:flex-row min-h-[560px]">

            {{-- ── Left: Gradient Panel ── --}}
            <div class="relative lg:w-5/12 bg-gradient-to-br from-[#06293F] via-[#1A6D9B] to-[#155C84] flex flex-col items-center justify-center px-10 py-14 overflow-hidden">

                {{-- Decorative blobs --}}
                <div class="absolute top-[-15%] left-[-15%] w-[55%] h-[55%] bg-white/10 rounded-full blur-3xl animate-pulse pointer-events-none"></div>
                <div class="absolute bottom-[-15%] right-[-15%] w-[65%] h-[65%] bg-accent/20 rounded-full blur-3xl animate-pulse pointer-events-none" style="animation-delay:2s"></div>

                {{-- Mascot --}}
                <div class="relative z-10 w-52 h-52 mb-6 animate-float">
                    <img src="{{ asset('images/arka/arka_pemandu.png') }}" alt="Arka Pemandu"
                         class="w-full h-full object-contain filter drop-shadow-2xl">
                </div>

                <h2 class="font-heading font-bold text-3xl text-white text-center leading-tight mb-3 tracking-tight relative z-10">
                    Buat Password<br>Baru
                </h2>
                <p class="text-white/75 text-sm text-center leading-relaxed relative z-10 max-w-[230px]">
                    Identitas terverifikasi! Sekarang buat password baru yang kuat dan mudah diingat.
                </p>

                {{-- Step indicator --}}
                <div class="flex items-center gap-2 mt-8 relative z-10">
                    <div class="flex items-center justify-center w-7 h-7 rounded-full bg-white/20 border-2 border-white/40">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="w-8 h-0.5 bg-white/30"></div>
                    <div class="flex items-center justify-center w-7 h-7 rounded-full bg-white border-2 border-white shadow-md">
                        <span class="text-primary font-bold text-xs">2</span>
                    </div>
                </div>
            </div>

            {{-- ── Right: Form ── --}}
            <div class="lg:w-7/12 flex items-center justify-center p-8 lg:px-14"
                 x-data="{
                     showPass: false,
                     showConfirm: false,
                     password: '',
                     loading: false,
                     get strength() {
                         if (this.password.length === 0) return 0;
                         let s = 0;
                         if (this.password.length >= 6)  s++;
                         if (this.password.length >= 10) s++;
                         if (/[A-Z]/.test(this.password)) s++;
                         if (/[0-9]/.test(this.password)) s++;
                         if (/[^A-Za-z0-9]/.test(this.password)) s++;
                         return s;
                     },
                     get strengthLabel() {
                         const l = ['', 'Sangat Lemah', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
                         return l[this.strength] ?? '';
                     },
                     get strengthColor() {
                         const c = ['', 'bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-blue-400', 'bg-green-500'];
                         return c[this.strength] ?? '';
                     },
                     get strengthWidth() {
                         return (this.strength / 5 * 100) + '%';
                     }
                 }">
                <div class="w-full max-w-md">

                    {{-- Header --}}
                    <div class="mb-8">
                        <span class="inline-block text-[10px] font-bold text-primary/70 uppercase tracking-[0.25em] mb-2">Langkah 2 dari 2</span>
                        <h1 class="font-heading font-bold text-2xl lg:text-3xl text-gray-800 leading-tight">
                            Set Password Baru
                        </h1>
                        <p class="text-sm text-gray-500 mt-1.5">
                            Buat password baru minimal 6 karakter.
                        </p>
                    </div>

                    {{-- Validation errors --}}
                    @if ($errors->any())
                        <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div class="text-sm space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('password.reset.submit') }}" class="space-y-5" @submit="loading = true">
                        @csrf

                        {{-- New Password --}}
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] ml-1">
                                Password Baru
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </span>
                                <input
                                    :type="showPass ? 'text' : 'password'"
                                    name="password"
                                    x-model="password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Minimal 6 karakter"
                                    class="w-full pl-11 pr-12 py-4 text-sm border {{ $errors->has('password') ? 'border-red-400 bg-red-50/30' : 'border-gray-100 bg-gray-50/50' }} rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all">
                                <button type="button" @click="showPass = !showPass"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                                    <svg x-show="!showPass" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showPass" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.415-2.793M9.172 9.172L15 15M3 3l18 18M9.88 9.88a3 3 0 114.24 4.24"/>
                                    </svg>
                                </button>
                            </div>

                            {{-- Strength meter --}}
                            <div x-show="password.length > 0" x-cloak class="mt-2 space-y-1.5">
                                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="strength-bar h-1.5 rounded-full"
                                         :class="strengthColor"
                                         :style="'width: ' + strengthWidth"></div>
                                </div>
                                <p class="text-[11px] ml-1 font-semibold transition-colors"
                                   :class="{
                                       'text-red-400':    strength <= 1,
                                       'text-orange-400': strength === 2,
                                       'text-yellow-500': strength === 3,
                                       'text-blue-500':   strength === 4,
                                       'text-green-600':  strength === 5,
                                   }"
                                   x-text="'Kekuatan: ' + strengthLabel"></p>
                            </div>
                            @error('password')
                                <p class="text-xs text-red-500 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] ml-1">
                                Konfirmasi Password
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </span>
                                <input
                                    :type="showConfirm ? 'text' : 'password'"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Ulangi password baru Anda"
                                    class="w-full pl-11 pr-12 py-4 text-sm border border-gray-100 bg-gray-50/50 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all">
                                <button type="button" @click="showConfirm = !showConfirm"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                                    <svg x-show="!showConfirm" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showConfirm" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.415-2.793M9.172 9.172L15 15M3 3l18 18M9.88 9.88a3 3 0 114.24 4.24"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Password rules note --}}
                        <div class="flex items-start gap-2.5 bg-primary/5 border border-primary/15 rounded-2xl px-4 py-3.5">
                            <svg class="w-4 h-4 text-primary flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs text-primary/80 leading-relaxed">
                                Password minimal 6 karakter. Untuk keamanan lebih baik, kombinasikan huruf besar, angka, dan simbol.
                            </p>
                        </div>

                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-primary hover:bg-primary-600 text-white font-bold py-4 rounded-2xl transition-all shadow-lg shadow-primary/25 active:scale-[0.98] text-sm mt-2"
                            :disabled="loading">
                            <span x-show="!loading" class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Password Baru
                            </span>
                            <span x-show="loading" x-cloak class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Menyimpan...
                            </span>
                        </button>
                    </form>

                    {{-- Footer link --}}
                    <p class="text-center text-sm text-gray-500 mt-6">
                        Kembali ke
                        <a href="{{ route('login') }}" class="text-primary font-bold hover:underline ml-1">Halaman Login</a>
                    </p>

                </div>
            </div>
            {{-- ── End Right ── --}}

        </div>
    </div>
</div>
@endsection
