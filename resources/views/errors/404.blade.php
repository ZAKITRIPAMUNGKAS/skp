@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<style>
    /* Background Grid Pattern Halus */
    .bg-grid-pattern {
        background-size: 40px 40px;
        background-image: 
            linear-gradient(to right, rgba(26, 109, 155, 0.03) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(26, 109, 155, 0.03) 1px, transparent 1px);
    }

    /* Teks 404 Raksasa Berongga (Outline) */
    .text-outline {
        color: transparent;
        -webkit-text-stroke: 2px rgba(26, 109, 155, 0.1);
        background-clip: text;
        -webkit-background-clip: text;
    }

    /* Animasi Entrance Mulus */
    .animate-fade-up {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeUp 1s cubic-bezier(0.65, 0, 0.076, 1) forwards;
    }

    .delay-100 { animation-delay: 100ms; }
    .delay-200 { animation-delay: 200ms; }
    .delay-300 { animation-delay: 300ms; }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Animasi Melayang untuk Mascot */
    .animate-float {
        animation: float 5s ease-in-out infinite;
        will-change: transform;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    /* Animasi Bayangan Bawah Mascot (Realism) */
    .animate-shadow {
        animation: shadowScale 5s ease-in-out infinite;
        will-change: transform, opacity;
    }

    @keyframes shadowScale {
        0%, 100% { transform: scale(1); opacity: 0.3; }
        50% { transform: scale(0.6); opacity: 0.1; }
    }
</style>

<div class="min-h-screen bg-white flex flex-col items-center justify-center p-6 relative bg-grid-pattern overflow-hidden">
    
    <!-- Dekorasi Cahaya Latar -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-[500px] bg-primary/5 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full max-w-2xl h-[300px] bg-accent/5 rounded-full blur-[80px] pointer-events-none"></div>

    <!-- Kontainer Utama -->
    <div class="max-w-2xl w-full text-center relative z-10 flex flex-col items-center">
        
        <!-- Elemen Visual (Gambar & 404) -->
        <div class="relative w-full flex justify-center items-center mb-6 animate-fade-up delay-100">
            <!-- Teks 404 Raksasa di Belakang -->
            <h1 class="absolute text-[200px] sm:text-[320px] font-heading font-black text-outline select-none tracking-tighter leading-none z-0">
                404
            </h1>
            
            <!-- Mascot Arka -->
            <div class="relative z-10 flex flex-col items-center mt-12 sm:mt-24">
                <img src="{{ asset('images/arka/arka_notfound.png') }}" 
                     alt="Arka Bingung - 404" 
                     class="w-72 sm:w-[420px] h-auto animate-float drop-shadow-2xl">
                
                <!-- Bayangan Animasi di Bawah Maskot -->
                <div class="w-32 h-4 bg-gray-900/20 rounded-[100%] blur-sm mt-4 animate-shadow"></div>
            </div>
        </div>

        <!-- Teks Deskripsi -->
        <div class="space-y-4 animate-fade-up delay-200 relative z-20">
            <h2 class="text-3xl sm:text-4xl font-heading font-bold text-gray-800 tracking-tight">Waduh, Halaman Hilang!</h2>
            <p class="text-gray-500 leading-relaxed max-w-md mx-auto text-[15px] sm:text-base">
                Arka sudah menggunakan <span class="font-semibold text-gray-700">Algoritma Pencarian</span> ke seluruh server, tapi sepertinya halaman yang Anda cari tidak ada atau sudah dipindahkan.
            </p>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:w-auto animate-fade-up delay-300 relative z-20">
            <a href="{{ route('landing') }}" class="w-full sm:w-auto px-8 py-3.5 bg-primary text-white font-bold rounded-2xl shadow-lg shadow-primary/20 hover:bg-primary-600 hover:shadow-xl transition-all hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Kembali ke Beranda
            </a>
            
            <button onclick="window.history.back()" class="w-full sm:w-auto px-8 py-3.5 bg-white text-gray-700 font-bold rounded-2xl border-2 border-gray-100 shadow-sm hover:border-gray-200 hover:bg-gray-50 transition-all active:scale-95 flex items-center justify-center gap-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Halaman Sebelumnya
            </button>
        </div>

    </div>

    <!-- Footer Copyright Sederhana -->
    <div class="absolute bottom-6 left-0 w-full text-center animate-fade-up delay-300 pointer-events-none">
        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em]">© 2026 gemala.dev x LP3A UMS</p>
    </div>

</div>
@endsection
