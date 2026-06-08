@extends('layouts.app')

@section('title', 'Login — ARQAM UMS')

@section('content')
<style>
    body { background-color: #ffffff; overflow: auto; }
    
    .auth-left {
        animation: fadeIn 0.6s ease-out forwards;
    }
    
    .auth-right {
        animation: fadeIn 0.8s ease-out forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Premium input focus transition */
    .premium-input {
        transition: all 0.2s ease-in-out;
    }
    .premium-input:focus {
        border-color: #1A6D9B;
        box-shadow: 0 0 0 4px rgba(26, 109, 155, 0.1);
    }
</style>

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-12 overflow-hidden bg-white">
    
    <!-- LEFT SIDE: MINIMALIST & PROFESSIONAL FORM -->
    <div class="auth-left lg:col-span-5 flex flex-col justify-between p-8 sm:p-12 xl:p-16 bg-white min-h-screen">
        
        <!-- Header: Logo & Back link -->
        <div class="flex items-center justify-between w-full">
            <img src="{{ asset('logo.webp') }}" alt="UMS Logo" class="h-10 object-contain">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-primary transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Beranda
            </a>
        </div>

        <!-- Form Content -->
        <div class="w-full max-w-sm mx-auto my-auto py-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight font-heading">Selamat Datang</h1>
                <p class="text-sm text-gray-500 mt-2">Silakan masuk menggunakan akun Anda untuk mengelola data perkaderan.</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-100 text-red-700 p-4 rounded-xl mb-6 text-xs font-medium space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> 
                            {{ $error }}
                        </p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                
                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-bold text-gray-700 tracking-wide">Email atau Username</label>
                    <input type="text" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="premium-input w-full px-4 py-3 text-sm border border-gray-200 rounded-xl outline-none bg-gray-50/35" 
                        placeholder="nama@ums.ac.id atau username">
                </div>
                
                <div class="space-y-1.5" x-data="{ show: false }">
                    <div class="flex justify-between items-center">
                        <label for="password" class="text-xs font-bold text-gray-700 tracking-wide">Password</label>
                        <a href="{{ route('password.forgot') }}" class="text-xs text-primary font-semibold hover:underline">Lupa password?</a>
                    </div>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" id="password" name="password" autocomplete="current-password" required 
                            class="premium-input w-full px-4 py-3 text-sm border border-gray-200 rounded-xl outline-none bg-gray-50/35 pr-10" 
                            placeholder="••••••••">
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                            <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.415-2.793M9.172 9.172L15 15M3 3l18 18M9.88 9.88a3 3 0 114.24 4.24"/></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/20 mr-2.5 transition-all">
                        <span class="text-xs text-gray-500 group-hover:text-gray-700 transition-colors select-none">Ingat sesi saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-[#155C84] text-white font-bold py-3 px-4 rounded-xl transition-all shadow-sm active:scale-[0.99] text-sm tracking-wide">
                    Masuk
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="w-full text-left text-xs text-gray-400">
            &copy; {{ date('Y') }} Universitas Muhammadiyah Surakarta.
        </div>
    </div>

    <!-- RIGHT SIDE: PREMIUM DEEP NAVY/BLUE BRANDING (MATCHES MAIN THEME) -->
    <div class="auth-right hidden lg:col-span-7 bg-gradient-to-br from-[#1A6D9B] to-[#06293F] lg:flex flex-col justify-between p-16 xl:p-24 text-white relative">
        
        <!-- Subtle Pattern -->
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px]"></div>
        </div>

        <!-- Top Right Subtitle -->
        <div class="flex justify-end w-full relative z-10">
            <span class="text-xs font-semibold tracking-wider text-white/80 bg-white/10 px-3.5 py-1.5 rounded-full backdrop-blur-md">
                Baitul Arqam &middot; LP3A UMS
            </span>
        </div>

        <!-- Central Branding Info -->
        <div class="max-w-md mx-auto my-auto relative z-10 text-center lg:text-left">
            <div class="w-24 h-24 mb-8 bg-white/10 rounded-3xl p-3 flex items-center justify-center backdrop-blur-md">
                <img src="{{ asset('logo.webp') }}" alt="UMS Logo" class="w-full h-full object-contain filter brightness-0 invert">
            </div>
            
            <h2 class="text-3xl xl:text-4xl font-extrabold tracking-tight mb-4 text-[#FAFAFA] font-heading">
                Sistem Evaluasi Perkaderan Berbasis Digital
            </h2>
            <p class="text-sm xl:text-base text-white/80 leading-relaxed mb-8">
                Mewujudkan penilaian objektif, akurat, dan transparan melalui integrasi algoritma pendukung keputusan (AHP & SAW).
            </p>

            <!-- Testimonial card/Visual highlight inside glassmorphism -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-md relative overflow-hidden text-left shadow-lg">
                <div class="absolute top-0 right-0 p-3 opacity-10">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M14 17h3l2-4V7h-6v6h3M4 17h3l2-4V7H3v6h3"/></svg>
                </div>
                <p class="text-xs text-white/75 italic leading-relaxed mb-4">
                    "Evaluasi Baitul Arqam kini terstandardisasi dengan penilaian multi-dimensi (kognitif, afektif, psikomotorik) yang dapat dipantau langsung secara real-time."
                </p>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-white/20 flex items-center justify-center">
                        <img src="logoums.png" alt="UMS Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white">Lembaga Agama Pengembangan Persyarikatan Pengkaderan & Alumni(LP3A)</h4>
                        <p class="text-[10px] text-white/50">Universitas Muhammadiyah Surakarta</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Version -->
        <div class="w-full text-right text-xs text-white/40 relative z-10">
            v2.1.0 &middot; Secure Auth Portal
        </div>

    </div>

</div>
@endsection
