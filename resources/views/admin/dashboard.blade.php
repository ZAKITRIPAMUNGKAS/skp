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
                <p class="text-xs text-slate-300 leading-relaxed mb-6">Untuk melihat laporan hasil evaluasi, grafik peningkatan nilai, dan statistik ranking peserta, silakan masuk ke menu kelola event masing-masing lalu buka tab <strong>Laporan</strong>.</p>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center gap-4 bg-white/5 border border-white/10 rounded-2xl p-4">
                    <div class="w-10 h-10 rounded-xl bg-yellow-400/20 text-yellow-400 flex items-center justify-center font-bold">1</div>
                    <div>
                        <h4 class="text-sm font-bold text-white">Menu Event</h4>
                        <p class="text-[11px] text-slate-400">Pilih salah satu event yang ingin dikelola.</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 bg-white/5 border border-white/10 rounded-2xl p-4">
                    <div class="w-10 h-10 rounded-xl bg-cyan-400/20 text-cyan-400 flex items-center justify-center font-bold">2</div>
                    <div>
                        <h4 class="text-sm font-bold text-white">Tab Laporan</h4>
                        <p class="text-[11px] text-slate-400">Lihat visualisasi data, chart kognitif, & ranking SAW.</p>
                    </div>
                </div>
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
