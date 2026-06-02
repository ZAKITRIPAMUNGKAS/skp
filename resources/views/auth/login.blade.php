@extends('layouts.app')

@section('title', 'Authentication — ARQAM App')

@section('content')
<style>
    body { background-color: #f8fafc; overflow: hidden; }
    
    /* 
       ==============================================================
       ARSITEKTUR ANIMASI PURE CSS (GPU ACCELERATED)
       ============================================================== 
    */
    :root {
        --transition-speed: 0.8s;
        --premium-ease: cubic-bezier(0.65, 0, 0.076, 1);
    }

    .auth-wrapper {
        position: relative;
        overflow: hidden;
        background-color: #fff;
        width: 100%;
        max-width: 1024px;
        height: 650px;
        border-radius: 2.5rem;
        box-shadow: 0 25px 50px -12px rgba(26, 109, 155, 0.15);
        animation: appEntrance 1s var(--premium-ease) forwards;
        opacity: 0;
        transform: translateY(30px) scale(0.98);
    }

    @keyframes appEntrance {
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ----- KONTAINER FORM ----- */
    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all var(--transition-speed) var(--premium-ease);
        will-change: transform, opacity;
    }

    .sign-in-container {
        left: 0;
        width: 50%;
        z-index: 2;
        opacity: 1;
    }

    .sign-up-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
        pointer-events: none;
    }

    /* ----- OVERLAY (Panel Biru) ----- */
    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform var(--transition-speed) var(--premium-ease);
        z-index: 100;
        will-change: transform;
    }

    .overlay {
        background: linear-gradient(135deg, #06293F 0%, #1A6D9B 50%, #155C84 100%);
        background-repeat: no-repeat;
        background-size: cover;
        color: #fff;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform var(--transition-speed) var(--premium-ease);
        will-change: transform;
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform var(--transition-speed) var(--premium-ease);
        will-change: transform;
    }

    .overlay-left { transform: translateX(-20%); }
    .overlay-right { right: 0; transform: translateX(0); }

    /* LOGIKA PERGERAKAN */
    .auth-wrapper.right-panel-active .sign-in-container {
        transform: translateX(100%);
        opacity: 0;
        pointer-events: none;
    }

    .auth-wrapper.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        pointer-events: auto;
    }

    .auth-wrapper.right-panel-active .overlay-container {
        transform: translateX(-100%);
    }

    .auth-wrapper.right-panel-active .overlay {
        transform: translateX(50%);
    }

    .auth-wrapper.right-panel-active .overlay-left {
        transform: translateX(0);
    }

    .auth-wrapper.right-panel-active .overlay-right {
        transform: translateX(20%);
    }

    /* MOBILE VIEW */
    @media (max-width: 1023px) {
        html, body { height: auto !important; overflow: auto !important; }
        body { background-color: #ffffff; }
        .auth-back-btn-container {
            position: static !important;
            padding: 1.5rem 1.5rem 0.5rem 1.5rem;
            background: #fff;
            width: 100%;
            display: block;
            box-sizing: border-box;
        }
        .auth-wrapper {
            box-shadow: none;
            border-radius: 0;
            margin: 0;
            width: 100%;
            height: auto;
            min-height: auto;
            display: flex;
            flex-direction: column;
            transform: none !important;
            animation: none !important;
            opacity: 1 !important;
        }
        .form-container { width: 100%; height: auto; position: relative; transition: opacity 0.4s ease; left: 0; transform: none !important;}
        .overlay-container { display: none; }
        
        .sign-in-container, .sign-up-container { padding: 2rem 1.5rem; width: 100%; position: relative; display: block; }
        .sign-in-container { opacity: 1; z-index: 10; }
        .sign-up-container { opacity: 0; z-index: 1; display: none; }

        .auth-wrapper.right-panel-active .sign-in-container { display: none; opacity: 0; }
        .auth-wrapper.right-panel-active .sign-up-container { display: block; opacity: 1; z-index: 10; }

        .mobile-tabs { display: flex; width: 100%; background: #fff; position: static; border-bottom: 1px solid #f1f5f9; padding-top: 0.5rem; }
    }
    @media (min-width: 1024px) {
        .mobile-tabs { display: none; }
    }
    
    [x-cloak] { display: none !important; }
</style>

<div class="min-h-screen flex flex-col lg:flex-row items-center justify-center p-0 lg:p-6 relative bg-gray-50/50" 
     x-data="{ mode: '{{ $mode ?? request()->query('mode', 'login') }}' }">
    
    <!-- Back Button -->
    <div class="auth-back-btn-container absolute top-4 left-4 lg:-top-12 lg:left-0 z-50">
        <a href="{{ route('landing') }}" class="group flex items-center gap-2 px-4 py-2 bg-white/80 lg:bg-transparent backdrop-blur-md lg:backdrop-blur-none border border-gray-100 lg:border-none rounded-full text-xs font-bold text-gray-500 hover:text-primary transition-all active:scale-95 shadow-sm lg:shadow-none">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Beranda
        </a>
    </div>

    <!-- MAIN WRAPPER -->
    <div class="auth-wrapper" :class="{ 'right-panel-active': mode === 'register' }">
        
        <!-- Mobile Tabs -->
        <div class="mobile-tabs px-8 pt-6 pb-0 flex gap-8">
            <button @click="mode = 'login'; window.history.pushState({}, '', '?mode=login')" 
                    class="pb-4 text-sm font-bold border-b-2 transition-all" 
                    :class="mode === 'login' ? 'border-primary text-primary' : 'border-transparent text-gray-400'">Masuk</button>
            <button @click="mode = 'register'; window.history.pushState({}, '', '?mode=register')" 
                    class="pb-4 text-sm font-bold border-b-2 transition-all" 
                    :class="mode === 'register' ? 'border-primary text-primary' : 'border-transparent text-gray-400'">Daftar Akun</button>
        </div>

        <!-- SIGN UP FORM -->
        <div class="form-container sign-up-container flex items-center justify-center p-8 lg:px-20">
            <div class="w-full max-w-sm">
                <div class="mb-10 flex items-center gap-5">
                    <div class="w-16 h-16 flex-shrink-0 bg-primary/5 rounded-2xl p-2.5">
                        <img src="{{ asset('images/arka/arka_fokus.png') }}" alt="Arka Fokus" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h2 class="font-heading font-bold text-3xl text-gray-800">Daftar Akun</h2>
                        <p class="text-sm text-gray-500">Transformasi digital perkaderan.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] ml-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-5 py-4 text-sm border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all bg-gray-50/50" placeholder="Nama lengkap Anda">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] ml-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-5 py-4 text-sm border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all bg-gray-50/50" placeholder="email@contoh.com">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5" x-data="{ show: false }">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] ml-1">Password</label>
                            <div class="relative group/pass">
                                <input :type="show ? 'text' : 'password'" name="password" required class="w-full px-5 py-4 text-sm border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all bg-gray-50/50 pr-12" placeholder="••••••••">
                                <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                                    <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.415-2.793M9.172 9.172L15 15M3 3l18 18M9.88 9.88a3 3 0 114.24 4.24"/></svg>
                                </button>
                            </div>
                        </div>
                        <div class="space-y-1.5" x-data="{ show: false }">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] ml-1">Konfirmasi</label>
                            <div class="relative group/pass">
                                <input :type="show ? 'text' : 'password'" name="password_confirmation" required class="w-full px-5 py-4 text-sm border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all bg-gray-50/50 pr-12" placeholder="••••••••">
                                <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                                    <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.415-2.793M9.172 9.172L15 15M3 3l18 18M9.88 9.88a3 3 0 114.24 4.24"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-primary hover:bg-primary-600 text-white font-bold py-3.5 rounded-2xl transition-all shadow-lg shadow-primary/20 active:scale-[0.98] mt-4 text-lg">
                        Daftar Sekarang
                    </button>
                </form>
            </div>
        </div>

        <!-- SIGN IN FORM -->
        <div class="form-container sign-in-container flex items-center justify-center p-8 lg:px-20">
            <div class="w-full max-w-sm">
                <div class="mb-10 flex items-center gap-5">
                    <div class="w-16 h-16 flex-shrink-0 bg-primary/5 rounded-2xl p-2.5 animate-floating">
                        <img src="{{ asset('images/arka/arka_pemandu.png') }}" alt="Arka Pemandu" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h2 class="font-heading font-bold text-3xl text-gray-800">Selamat Datang</h2>
                        <p class="text-sm text-gray-500">Masuk untuk melanjutkan.</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6 text-xs font-medium space-y-1">
                        @foreach ($errors->all() as $error)
                            <p class="flex items-center gap-2"><span class="w-1 h-1 bg-red-400 rounded-full"></span> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] ml-1">Email atau Username</label>
                        <input type="text" name="email" value="{{ old('email') }}" required class="w-full px-5 py-4 text-sm border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all bg-gray-50/50" placeholder="email@contoh.com atau username">
                    </div>
                    <div class="space-y-1.5" x-data="{ show: false }">
                        <div class="flex justify-between items-center mb-1 ml-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Password</label>
                            <a href="{{ route('password.forgot') }}" class="text-[9px] text-primary font-bold uppercase tracking-wider hover:underline">Lupa Password?</a>
                        </div>
                        <div class="relative group/pass">
                            <input :type="show ? 'text' : 'password'" name="password" required class="w-full px-5 py-4 text-sm border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all bg-gray-50/50 pr-12" placeholder="••••••••">
                            <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                                <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="show" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.415-2.793M9.172 9.172L15 15M3 3l18 18M9.88 9.88a3 3 0 114.24 4.24"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center ml-1">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-4.5 h-4.5 rounded border-gray-300 text-primary focus:ring-primary/40 mr-2.5 transition-all">
                            <span class="text-sm text-gray-500 group-hover:text-gray-700 transition-colors">Ingat Sesi Saya</span>
                        </label>
                    </div>
                    <button type="submit" class="w-full bg-primary hover:bg-primary-600 text-white font-bold py-3.5 rounded-2xl transition-all shadow-lg shadow-primary/20 active:scale-[0.98] text-lg">
                        Masuk Sekarang
                    </button>
                </form>
            </div>
        </div>

        <!-- OVERLAY CONTAINER -->
        <div class="overlay-container hidden lg:block">
            <div class="overlay">
                
                <!-- Background Decoration -->
                <div class="absolute inset-0 overflow-hidden pointer-events-none">
                    <div class="absolute top-[-20%] left-[-10%] w-[60%] h-[60%] bg-white/10 rounded-full blur-3xl animate-pulse"></div>
                    <div class="absolute bottom-[-20%] right-[-10%] w-[70%] h-[70%] bg-accent/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s"></div>
                </div>

                <!-- LEFT (Offers Login) -->
                <div class="overlay-panel overlay-left px-16">
                    <div class="w-64 h-64 mb-6 animate-float-slow">
                        <img src="{{ asset('images/arka/arka_login.png') }}" alt="Arka Login" class="w-full h-full object-contain filter drop-shadow-2xl">
                    </div>
                    <h2 class="font-heading font-bold text-4xl text-white leading-tight mb-5 tracking-tight">Sudah Punya<br>Akun?</h2>
                    <p class="text-white/80 text-lg leading-relaxed mb-12 max-w-[280px]">Masuk untuk melanjutkan pantauan progres Anda.</p>
                    <button @click="mode = 'login'; window.history.pushState({}, '', '?mode=login')" 
                            class="px-12 py-4 border-2 border-white/40 rounded-full font-bold text-sm uppercase tracking-widest text-white hover:bg-white hover:text-primary transition-all active:scale-95 shadow-xl">
                        Masuk Sekarang
                    </button>
                </div>

                <!-- RIGHT (Offers Register) -->
                <div class="overlay-panel overlay-right px-16">
                    <div class="w-64 h-64 mb-6 animate-float-slow">
                        <img src="{{ asset('images/arka/arka_register.png') }}" alt="Arka Register" class="w-full h-full object-contain filter drop-shadow-2xl">
                    </div>
                    <h2 class="font-heading font-bold text-4xl text-white leading-tight mb-5 tracking-tight">Halo,<br>Kader Baru!</h2>
                    <p class="text-white/80 text-lg leading-relaxed mb-12 max-w-[280px]">Daftar sekarang untuk mulai evaluasi digital terpadu.</p>
                    <button @click="mode = 'register'; window.history.pushState({}, '', '?mode=register')" 
                            class="px-12 py-4 border-2 border-white/40 rounded-full font-bold text-sm uppercase tracking-widest text-white hover:bg-white hover:text-primary transition-all active:scale-95 shadow-xl">
                        Daftar Akun
                    </button>
                </div>
                
            </div>
        </div>

    </div>
</div>
@endsection
