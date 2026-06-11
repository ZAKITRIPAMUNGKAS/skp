@extends('layouts.main')

@section('title', 'Video Tutorial - ArqamApp')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800 font-heading">Video Tutorial Penggunaan</h1>
            <p class="text-sm text-gray-500 mt-1">Panduan visual untuk mengoperasikan fitur-fitur utama di ArqamApp.</p>
        </div>
    </div>

    {{-- Video Container --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Video Player Card --}}
        <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-4">
            <div class="aspect-video w-full rounded-2xl bg-slate-900 overflow-hidden relative border border-slate-800 flex items-center justify-center group">
                {{-- Placeholder/Poster --}}
                <div class="absolute inset-0 bg-cover bg-center opacity-60 filter blur-sm" style="background-image: url('{{ asset('images/dashboard_mockup.png') }}')"></div>
                <div class="absolute inset-0 bg-slate-950/80"></div>
                
                {{-- Play button overlay (Interactive mock or standard HTML5 video) --}}
                <div class="relative z-10 flex flex-col items-center justify-center text-center p-6 space-y-4">
                    <div class="w-16 h-16 rounded-full bg-primary text-white flex items-center justify-center shadow-lg shadow-primary/30 group-hover:scale-110 transition-transform duration-300 cursor-pointer">
                        <svg class="w-8 h-8 fill-current ml-1" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-lg">Video Panduan Utama ArqamApp</h4>
                        <p class="text-slate-400 text-sm mt-1">Durasi: 12 menit • Format MP4</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-2">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Panduan Lengkap Pengelolaan Baitul Arqam</h3>
                    <p class="text-xs text-gray-500 mt-1">Diunggah pada Juni 2026 • Oleh Tim Pengembang</p>
                </div>
                <a href="#" class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 hover:bg-primary/20 text-primary text-xs font-bold rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download Video
                </a>
            </div>
        </div>

        {{-- Playlist / Topic Steps --}}
        <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-6">
            <div>
                <h3 class="font-bold text-gray-800 font-heading text-lg">Daftar Materi Video</h3>
                <p class="text-xs text-gray-500 mt-1">Pilih bagian panduan yang ingin dipelajari.</p>
            </div>

            <div class="space-y-3">
                <div class="flex items-start gap-3 p-3 bg-primary/5 border border-primary/10 rounded-2xl cursor-pointer">
                    <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-xs shrink-0">1</div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs font-bold text-gray-800 truncate">Pengenalan & Dashboard Utama</h4>
                        <p class="text-[10px] text-gray-500 mt-0.5">Durasi: 02:15</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-3 hover:bg-gray-50 border border-transparent hover:border-gray-100 rounded-2xl cursor-pointer transition-all">
                    <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center font-bold text-xs shrink-0">2</div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs font-bold text-gray-800 truncate">Import Data Peserta via Excel</h4>
                        <p class="text-[10px] text-gray-500 mt-0.5">Durasi: 03:40</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-3 hover:bg-gray-50 border border-transparent hover:border-gray-100 rounded-2xl cursor-pointer transition-all">
                    <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center font-bold text-xs shrink-0">3</div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs font-bold text-gray-800 truncate">Pengaturan Ujian & Bank Soal</h4>
                        <p class="text-[10px] text-gray-500 mt-0.5">Durasi: 04:10</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-3 hover:bg-gray-50 border border-transparent hover:border-gray-100 rounded-2xl cursor-pointer transition-all">
                    <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center font-bold text-xs shrink-0">4</div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs font-bold text-gray-800 truncate">Penilaian Afektif & Psikomotor</h4>
                        <p class="text-[10px] text-gray-500 mt-0.5">Durasi: 03:05</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-3 hover:bg-gray-50 border border-transparent hover:border-gray-100 rounded-2xl cursor-pointer transition-all">
                    <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center font-bold text-xs shrink-0">5</div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs font-bold text-gray-800 truncate">Perhitungan AHP-SAW & Cetak Laporan</h4>
                        <p class="text-[10px] text-gray-500 mt-0.5">Durasi: 04:50</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
