@extends('layouts.main')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Greeting Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 font-heading">{{ $greeting }}, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-sm text-gray-500 mt-1">Selamat datang di panel admin utama ArqamApp.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-600 text-white text-sm font-semibold rounded-xl transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Buat Event Baru
            </a>
        </div>
    </div>

    {{-- Welcome Panel --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Welcome Card --}}
        <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 p-8 shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[350px]">
            <div class="absolute right-0 bottom-0 opacity-15 pointer-events-none translate-y-6 translate-x-6">
                <img src="{{ asset('images/arka/arka_fokus.png') }}" class="w-64 h-auto" alt="Mascot Arka" onerror="this.style.display='none'">
            </div>
            
            <div class="relative z-10 space-y-4">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
                    Selamat Datang di ArqamApp
                </span>
                <h2 class="text-3xl font-bold font-heading text-gray-800 leading-tight">Kelola Pelatihan & Evaluasi Baitul Arqam dengan Mudah</h2>
                <p class="text-gray-500 leading-relaxed text-sm max-w-xl">
                    ArqamApp dirancang untuk membantu Anda memantau dan mengevaluasi pelaksanaan Baitul Arqam secara real-time. Kelola peserta, presensi kehadiran berbasis QR Code, tes kognitif, penilaian afektif/psikomotorik, hingga perankingan otomatis (AHP-SAW) dalam satu dashboard.
                </p>
            </div>

            <div class="relative z-10 pt-6 flex flex-wrap items-center gap-3">
                @if($latestEvent)
                    <a href="{{ route('admin.events.show', $latestEvent) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white text-sm font-bold rounded-2xl hover:bg-primary-600 transition-all shadow-md shadow-primary/20 hover:-translate-y-0.5">
                        Kelola Event Terakhir ({{ Str::limit($latestEvent->nama_event, 20) }})
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                    </a>
                @else
                    <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white text-sm font-bold rounded-2xl hover:bg-primary-600 transition-all shadow-md shadow-primary/20 hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Buat Event Sekarang
                    </a>
                @endif
                <a href="{{ route('admin.events.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-50 border border-gray-200 text-gray-700 text-sm font-bold rounded-2xl hover:bg-gray-100 transition-all">
                    Lihat Semua Event
                </a>
            </div>
        </div>

        {{-- Guide Summary Panel --}}
        <div class="bg-gradient-to-br from-gray-900 to-slate-800 rounded-3xl p-8 text-white shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-lg font-heading text-yellow-400 mb-2">Panduan Pengguna</h3>
                <p class="text-xs text-slate-300 leading-relaxed mb-6">Akses panduan lengkap penggunaan ArqamApp untuk membantu Anda mengelola sistem secara maksimal.</p>
            </div>
            
            <div class="space-y-3">
                {{-- Manual Book v1 --}}
                <a href="#" target="_blank" class="flex items-center gap-4 bg-white/5 border border-white/10 rounded-2xl p-4 hover:bg-white/10 hover:border-white/20 transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-yellow-400/20 text-yellow-400 flex items-center justify-center font-bold group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-white group-hover:text-yellow-300 transition-colors">Manual Book v1</h4>
                        <p class="text-[11px] text-slate-400">Unduh buku panduan penggunaan format PDF.</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </a>

                {{-- Video Tutorial --}}
                <a href="{{ route('admin.dashboard.video') }}" class="flex items-center gap-4 bg-white/5 border border-white/10 rounded-2xl p-4 hover:bg-white/10 hover:border-white/20 transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-cyan-400/20 text-cyan-400 flex items-center justify-center font-bold group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l-3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-white group-hover:text-cyan-300 transition-colors">Video Tutorial</h4>
                        <p class="text-[11px] text-slate-400">Tonton video panduan langkah demi langkah.</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                {{-- Documentation Sistem --}}
                <a href="{{ route('admin.dashboard.documentation') }}" class="flex items-center gap-4 bg-white/5 border border-white/10 rounded-2xl p-4 hover:bg-white/10 hover:border-white/20 transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-emerald-400/20 text-emerald-400 flex items-center justify-center font-bold group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-white group-hover:text-emerald-300 transition-colors">Documentation Sistem</h4>
                        <p class="text-[11px] text-slate-400">Pelajari dokumentasi teknis & arsitektur sistem.</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {{-- Step by Step Tutorial --}}
    <div class="mt-8">
        <h3 class="text-lg font-bold text-gray-800 font-heading mb-6">Panduan Alur Kerja Pengelolaan Event</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            {{-- Step 1 --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex flex-col justify-between min-h-[200px] hover:border-primary/20 transition-all">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">01</div>
                    <h4 class="font-bold text-gray-800 text-sm">Registrasi Event & Peserta</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Buat event baru, kemudian masuk ke halaman detail event untuk melakukan **Import Peserta** secara massal via Excel.</p>
                </div>
            </div>

            {{-- Step 2 --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex flex-col justify-between min-h-[200px] hover:border-primary/20 transition-all">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center font-bold text-sm">02</div>
                    <h4 class="font-bold text-gray-800 text-sm">Atur Sesi & Bank Soal</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Tambahkan sesi jadwal pelatihan dan siapkan butir soal ujian untuk dikerjakan peserta secara online.</p>
                </div>
            </div>

            {{-- Step 3 --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex flex-col justify-between min-h-[200px] hover:border-primary/20 transition-all">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-accent/10 text-accent flex items-center justify-center font-bold text-sm">03</div>
                    <h4 class="font-bold text-gray-800 text-sm">Evaluasi Berlangsung</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Panitia melakukan pemindaian QR-Code untuk presensi dan mengisi form psikomotor/afektif peserta.</p>
                </div>
            </div>

            {{-- Step 4 --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex flex-col justify-between min-h-[200px] hover:border-primary/20 transition-all">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-sm">04</div>
                    <h4 class="font-bold text-gray-800 text-sm">Kalkulasi SAW & Laporan</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Lakukan pembobotan AHP, hitung peringkat SAW, lalu unduh berkas laporan akhir Excel & PDF di tab **Laporan**.</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
