@extends('layouts.app')

@section('title', 'Lupa Password — ARQAM App')

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

    [x-cloak] { display: none !important; }
</style>

<div class="min-h-screen flex items-center justify-center p-4 lg:p-8 bg-gray-50/50">

    {{-- Back to landing --}}
    <div class="absolute top-4 left-4 z-50">
        <a href="{{ route('landing') }}"
           class="group flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-md border border-gray-100 rounded-full text-xs font-bold text-gray-500 hover:text-primary transition-all active:scale-95 shadow-sm">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Beranda
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
                    <img src="{{ asset('images/arka/arka_fokus.png') }}" alt="Arka Fokus"
                         class="w-full h-full object-contain filter drop-shadow-2xl">
                </div>

                <h2 class="font-heading font-bold text-3xl text-white text-center leading-tight mb-3 tracking-tight relative z-10">
                    Lupa Password?
                </h2>
                <p class="text-white/75 text-sm text-center leading-relaxed relative z-10 max-w-[230px]">
                    Tenang! Verifikasi identitas Anda dengan username dan nomor HP yang terdaftar.
                </p>

                {{-- Decorative dots --}}
                <div class="absolute bottom-8 left-0 right-0 flex justify-center gap-2 z-10">
                    <span class="w-6 h-1.5 bg-white/60 rounded-full"></span>
                    <span class="w-2 h-1.5 bg-white/30 rounded-full"></span>
                    <span class="w-2 h-1.5 bg-white/30 rounded-full"></span>
                </div>
            </div>

            {{-- ── Right: Form ── --}}
            <div class="lg:w-7/12 flex items-center justify-center p-8 lg:px-14">
                <div class="w-full max-w-md">

                    {{-- Header --}}
                    <div class="mb-8">
                        <span class="inline-block text-[10px] font-bold text-primary/70 uppercase tracking-[0.25em] mb-2">Langkah 1 dari 2</span>
                        <h1 class="font-heading font-bold text-2xl lg:text-3xl text-gray-800 leading-tight">
                            Verifikasi Identitas
                        </h1>
                        <p class="text-sm text-gray-500 mt-1.5">
                            Masukkan username dan nomor HP Anda yang terdaftar.
                        </p>
                    </div>

                    {{-- Flash success (jika ada) --}}
                    @if (session('success'))
                        <div class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl mb-6 text-sm">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

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
                    <form method="POST" action="{{ route('password.verify') }}" class="space-y-5" x-data="{ loading: false }" @submit="loading = true">
                        @csrf

                        {{-- Username --}}
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] ml-1">
                                Username
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    name="username"
                                    value="{{ old('username') }}"
                                    required
                                    autocomplete="username"
                                    placeholder="Masukkan username Anda"
                                    class="w-full pl-11 pr-5 py-4 text-sm border {{ $errors->has('username') ? 'border-red-400 bg-red-50/30' : 'border-gray-100 bg-gray-50/50' }} rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all">
                            </div>
                            @error('username')
                                <p class="text-xs text-red-500 ml-1 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nomor HP --}}
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] ml-1">
                                Nomor HP / WhatsApp
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </span>
                                <input
                                    type="tel"
                                    name="no_hp"
                                    value="{{ old('no_hp') }}"
                                    required
                                    autocomplete="tel"
                                    placeholder="Contoh: 08123456789"
                                    class="w-full pl-11 pr-5 py-4 text-sm border {{ $errors->has('no_hp') ? 'border-red-400 bg-red-50/30' : 'border-gray-100 bg-gray-50/50' }} rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all">
                            </div>
                            @error('no_hp')
                                <p class="text-xs text-red-500 ml-1 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Info note --}}
                        <div class="flex items-start gap-2.5 bg-amber-50 border border-amber-200 rounded-2xl px-4 py-3.5">
                            <svg class="w-4.5 h-4.5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs text-amber-800 leading-relaxed">
                                <strong>Info:</strong> Jika Anda lupa password, Anda bisa <strong>langsung menghubungi Fasilitator</strong> atau Admin untuk melakukan reset password. Anda juga bisa melakukan verifikasi mandiri menggunakan formulir di atas.
                            </p>
                        </div>

                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-primary hover:bg-primary-600 text-white font-bold py-4 rounded-2xl transition-all shadow-lg shadow-primary/25 active:scale-[0.98] text-sm mt-2"
                            :disabled="loading">
                            <span x-show="!loading">Verifikasi & Lanjutkan</span>
                            <span x-show="loading" x-cloak class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Memverifikasi...
                            </span>
                            <svg x-show="!loading" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </form>

                    {{-- Footer link --}}
                    <p class="text-center text-sm text-gray-500 mt-6">
                        Sudah ingat password Anda?
                        <a href="{{ route('login') }}" class="text-primary font-bold hover:underline ml-1">Masuk di sini</a>
                    </p>

                </div>
            </div>
            {{-- ── End Right ── --}}

        </div>
    </div>
</div>
@endsection
