@extends('layouts.main')

@section('title', 'Video Tutorial - ArqamApp')

@section('content')
<div class="space-y-6" x-data="{
    activeVideo: {
        @if(auth()->user()->isAdmin())
        id: 'RGSeBnnDJ3k',
        title: 'Pengenalan & Dashboard Utama ArqamApp',
        description: 'Membahas pengenalan antarmuka (interface) aplikasi, gambaran umum fitur-fitur, dan statistik dashboard administrator.',
        duration: '02:15',
        index: 0
        @else
        id: 'YOUR_VIDEO_ID',
        title: 'Coming Soon: Panduan Penggunaan Untuk Fasilitator',
        description: 'Materi panduan ini sedang dalam tahap produksi dan akan segera tersedia. Nantinya akan membahas cara memindai QR code presensi dan mengisi nilai evaluasi peserta.',
        duration: '--:--',
        index: 0
        @endif
    },
    videos: [
        @if(auth()->user()->isAdmin())
        {
            id: 'RGSeBnnDJ3k',
            title: 'Pengenalan & Dashboard Utama ArqamApp',
            description: 'Membahas pengenalan antarmuka (interface) aplikasi, gambaran umum fitur-fitur, dan statistik dashboard administrator.',
            duration: '02:15'
        },
        {
            id: 'RGSeBnnDJ3k',
            title: 'Manajemen Event & Import Data Peserta via Excel',
            description: 'Panduan lengkap membuat event Baitul Arqam baru, mengunduh format template Excel, mengimpor data peserta massal, dan plotting fasilitator.',
            duration: '03:40'
        },
        {
            id: 'RGSeBnnDJ3k',
            title: 'Pengaturan Sesi Jadwal & Kelola Bank Soal',
            description: 'Langkah-langkah menyusun sesi jadwal pelatihan keagamaan, mengelola butir-butir soal ujian kognitif pretest dan posttest.',
            duration: '04:10'
        },
        {
            id: 'RGSeBnnDJ3k',
            title: 'Presensi QR-Code & Input Evaluasi Psikomotorik / Afektif',
            description: 'Cara memindai QR-Code peserta untuk presensi kehadiran, cara fasilitator mengisi form nilai afektif dan praktik keagamaan psikomotorik.',
            duration: '03:05'
        },
        {
            id: 'RGSeBnnDJ3k',
            title: 'Kalkulasi SPK AHP-SAW & Ekspor Laporan Akhir',
            description: 'Proses pembobotan kriteria menggunakan matriks AHP, normalisasi nilai SAW, penentuan predikat kelulusan otomatis, dan pencetakan berkas laporan PDF/Excel.',
            duration: '04:50'
        }
        @else
        {
            id: 'YOUR_VIDEO_ID',
            title: 'Coming Soon: Panduan Penggunaan Untuk Fasilitator',
            description: 'Materi panduan ini sedang dalam tahap produksi dan akan segera tersedia. Nantinya akan membahas cara memindai QR code presensi dan mengisi nilai evaluasi peserta.',
            duration: '--:--'
        }
        @endif
    ],
    selectVideo(video, idx) {
        this.activeVideo = {
            id: video.id,
            title: video.title,
            description: video.description,
            duration: video.duration,
            index: idx
        };
    }
}">
    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800 font-heading">Video Tutorial Penggunaan</h1>
            <p class="text-sm text-gray-500 mt-1">Panduan visual untuk mengoperasikan fitur-fitur utama di ArqamApp secara bertahap.</p>
        </div>
    </div>

    {{-- Video Container --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Video Player Card --}}
        <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-4">
            <div class="aspect-video w-full rounded-2xl bg-slate-900 overflow-hidden relative border border-slate-800">
                <template x-if="activeVideo.id !== 'YOUR_VIDEO_ID'">
                    <iframe 
                        class="w-full h-full"
                        :src="'https://www.youtube.com/embed/' + activeVideo.id" 
                        title="YouTube video player" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen>
                    </iframe>
                </template>
                <template x-if="activeVideo.id === 'YOUR_VIDEO_ID'">
                    <div class="w-full h-full flex flex-col items-center justify-center text-center p-6 text-slate-400">
                        <svg class="w-16 h-16 mb-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l-3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-xl font-bold text-white mb-2">Video Segera Hadir</h3>
                        <p class="text-sm">Materi panduan ini sedang dalam tahap produksi.</p>
                    </div>
                </template>
            </div>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pt-2">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-primary bg-primary/10 px-2.5 py-1 rounded-md uppercase tracking-widest">
                        Materi Bagian <span x-text="activeVideo.index + 1"></span>
                    </span>
                    <h3 class="text-lg font-bold text-gray-800 mt-2" x-text="activeVideo.title"></h3>
                    <p class="text-xs text-gray-500" x-text="activeVideo.description"></p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-xl">
                        Durasi: <span x-text="activeVideo.duration"></span>
                    </span>
                    <a x-show="activeVideo.id !== 'YOUR_VIDEO_ID'" :href="'https://www.youtube.com/watch?v=' + activeVideo.id" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary-600 text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                        Tonton di YT
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Playlist / Topic Steps --}}
        <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-6">
            <div>
                <h3 class="font-bold text-gray-800 font-heading text-lg">Daftar Materi Video</h3>
                <p class="text-xs text-gray-500 mt-1">Pilih materi panduan di bawah ini:</p>
            </div>

            <div class="space-y-3">
                <template x-for="(video, index) in videos" :key="index">
                    <div 
                        @click="selectVideo(video, index)"
                        :class="activeVideo.index === index ? 'bg-primary/5 border-primary/20 text-primary' : 'hover:bg-gray-50 border-transparent hover:border-gray-100'"
                        class="flex items-start gap-3 p-3 border rounded-2xl cursor-pointer transition-all duration-200"
                    >
                        <div 
                            :class="activeVideo.index === index ? 'bg-primary text-white' : 'bg-gray-100 text-gray-600'"
                            class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs shrink-0" 
                            x-text="index + 1"
                        ></div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-gray-800" x-text="video.title"></h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[9px] text-gray-400 font-medium" x-text="'Durasi: ' + video.duration"></span>
                                <span class="text-[9px] text-primary font-semibold" x-show="activeVideo.index === index">Sedang Diputar</span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
@endsection
