@extends('layouts.main')

@section('title', 'Jadwal Kegiatan')

@push('styles')
<style>
    /* Timeline pulse animation for attended nodes */
    @keyframes pulseGreen {
        0%, 100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
        50%       { box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
    }
    .node-attended { animation: pulseGreen 2.5s infinite; }

    /* Shimmer on the timeline line */
    @keyframes shimmer {
        0%   { background-position: -200% center; }
        100% { background-position: 200% center; }
    }
    .timeline-line-gradient {
        background: linear-gradient(180deg, #1A6D9B 0%, #D4A017 100%);
    }

    /* Card entrance */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .sesi-card {
        animation: fadeSlideUp 0.4s ease-out both;
    }

    /* Progress ring */
    .progress-ring-circle {
        transition: stroke-dashoffset 1s ease-out;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto py-6 px-4">

    {{-- ── Page Header ──────────────────────────────── --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-1">
            <div class="w-1.5 h-8 rounded-full bg-gradient-to-b from-primary to-accent"></div>
            <h1 class="text-2xl font-heading font-extrabold text-gray-900 tracking-tight">Jadwal Kegiatan</h1>
        </div>
        <p class="text-sm text-gray-500 ml-5 pl-0.5">Alur sesi &amp; status kehadiran Anda</p>
    </div>

    @if($activeEvent)

        {{-- ── Hero Stat Card ───────────────────────── --}}
        @php
            $total    = $sessions->count();
            $attended = $sessions->where('attended', true)->count();
            $pct      = $total > 0 ? round(($attended / $total) * 100) : 0;
            // SVG progress ring
            $r   = 36;
            $circ = round(2 * M_PI * $r, 2);
            $dash = round($circ - ($circ * $pct / 100), 2);
        @endphp

        <div class="relative overflow-hidden bg-gradient-to-br from-[#1A6D9B] via-[#155C84] to-[#0B3A56] rounded-[2rem] p-7 text-white shadow-2xl shadow-primary/30 mb-8">

            {{-- Decorative blobs --}}
            <div class="absolute -top-8 -right-8 w-48 h-48 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-6 -left-6 w-36 h-36 bg-accent/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative flex flex-col sm:flex-row items-center gap-6">

                {{-- Ring progress --}}
                <div class="relative shrink-0 flex items-center justify-center"
                     x-data="{ pct: 0 }"
                     x-init="setTimeout(() => pct = {{ $pct }}, 300)">
                    <svg width="96" height="96" viewBox="0 0 96 96">
                        {{-- track --}}
                        <circle cx="48" cy="48" r="{{ $r }}" fill="none" stroke="rgba(255,255,255,0.12)" stroke-width="8"/>
                        {{-- filled --}}
                        <circle cx="48" cy="48" r="{{ $r }}" fill="none"
                                stroke="#D4A017"
                                stroke-width="8"
                                stroke-linecap="round"
                                stroke-dasharray="{{ $circ }}"
                                :stroke-dashoffset="{{ $circ }} - ({{ $circ }} * pct / 100)"
                                class="progress-ring-circle"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-black font-heading text-accent-300" x-text="pct + '%'">0%</span>
                    </div>
                </div>

                {{-- Info --}}
                <div class="flex-1 text-center sm:text-left">
                    <span class="inline-block px-3 py-0.5 text-[10px] font-bold uppercase tracking-widest bg-white/10 border border-white/20 rounded-full text-white/90 mb-2">
                        {{ $activeEvent->nama_event ?? 'Baitul Arqam' }}
                    </span>
                    <h2 class="text-3xl font-heading font-extrabold text-white leading-tight">
                        {{ $attended }} <span class="text-white/50 font-light text-xl">/ {{ $total }}</span>
                    </h2>
                    <p class="text-sm text-primary-200 mt-1">sesi telah Anda hadiri</p>
                </div>

                {{-- Quick stats --}}
                <div class="shrink-0 flex sm:flex-col gap-4 sm:gap-2">
                    <div class="text-center bg-white/10 backdrop-blur-sm border border-white/15 rounded-2xl px-5 py-3">
                        <span class="block text-xl font-bold text-white">{{ $total }}</span>
                        <span class="text-[10px] uppercase tracking-wide text-white/60">Total Sesi</span>
                    </div>
                    <div class="text-center bg-white/10 backdrop-blur-sm border border-white/15 rounded-2xl px-5 py-3">
                        <span class="block text-xl font-bold text-accent-300">{{ $attended }}</span>
                        <span class="text-[10px] uppercase tracking-wide text-white/60">Hadir</span>
                    </div>
                </div>
            </div>

            {{-- Progress bar --}}
            <div class="relative mt-6 h-2 bg-white/10 rounded-full overflow-hidden">
                <div class="absolute inset-y-0 left-0 rounded-full bg-gradient-to-r from-accent-400 to-accent-300 transition-all duration-1000"
                     x-data="{ w: 0 }"
                     x-init="setTimeout(() => w = {{ $pct }}, 400)"
                     :style="'width:' + w + '%'"></div>
            </div>
            <p class="text-[11px] text-white/40 mt-2 text-right">{{ $pct }}% kehadiran tercatat</p>
        </div>

        {{-- ── Timeline ──────────────────────────────── --}}
        @if($sessions->count() > 0)
        <div class="relative" x-data>

            {{-- Vertical connector line --}}
            <div class="absolute left-[23px] top-5 bottom-5 w-[3px] rounded-full timeline-line-gradient opacity-20 pointer-events-none"></div>

            <div class="space-y-4">
            @foreach($sessions as $index => $sesi)
                @php
                    $delay = $index * 60;
                    $isAttended = $sesi['attended'];
                @endphp

                <div class="sesi-card relative flex gap-4 group" style="animation-delay: {{ $delay }}ms">

                    {{-- ── Node ── --}}
                    <div class="relative z-10 shrink-0 flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-sm font-bold shadow-lg border-2 transition-all duration-300
                            {{ $isAttended
                                ? 'bg-green-500 border-green-400 text-white node-attended'
                                : 'bg-white border-gray-200 text-gray-400 group-hover:border-primary/50 group-hover:text-primary' }}">
                            @if($isAttended)
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                <span class="font-heading">{{ str_pad($sesi['urutan'], 2, '0', STR_PAD_LEFT) }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- ── Card ── --}}
                    <div class="flex-1 mb-1 rounded-2xl border transition-all duration-300 overflow-hidden
                        {{ $isAttended
                            ? 'bg-gradient-to-br from-green-50 to-emerald-50/60 border-green-100 shadow-sm shadow-green-100/50'
                            : 'bg-white border-gray-100 shadow-card group-hover:shadow-card-hover group-hover:border-primary/20' }}">

                        <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center gap-3">

                            {{-- Left: info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start gap-2 flex-wrap">
                                    <span class="shrink-0 inline-block px-2 py-0.5 text-[10px] font-bold uppercase rounded-md
                                        {{ $isAttended ? 'bg-green-100 text-green-700' : 'bg-primary-50 text-primary-600' }}">
                                        Sesi {{ str_pad($sesi['urutan'], 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                                <h3 class="mt-2 text-base font-heading font-bold leading-snug
                                    {{ $isAttended ? 'text-green-900' : 'text-gray-800 group-hover:text-primary' }}">
                                    {{ $sesi['nama_sesi'] }}
                                </h3>

                                @if(!empty($sesi['deskripsi']))
                                <p class="mt-1 text-xs text-gray-500 leading-relaxed line-clamp-2">
                                    {{ $sesi['deskripsi'] }}
                                </p>
                                @endif

                                {{-- Time badges --}}
                                @if(!empty($sesi['waktu_mulai']) || !empty($sesi['waktu_selesai']))
                                <div class="mt-2 flex items-center gap-2 flex-wrap">
                                    @if(!empty($sesi['waktu_mulai']))
                                    <span class="inline-flex items-center gap-1 text-[11px] text-gray-500">
                                        <svg class="w-3.5 h-3.5 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        @if($sesi['waktu_mulai'] instanceof \Carbon\Carbon)
                                            {{ $sesi['waktu_mulai']->format('H:i') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($sesi['waktu_mulai'])->format('H:i') }}
                                        @endif
                                        @if(!empty($sesi['waktu_selesai']))
                                            &ndash;
                                            @if($sesi['waktu_selesai'] instanceof \Carbon\Carbon)
                                                {{ $sesi['waktu_selesai']->format('H:i') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($sesi['waktu_selesai'])->format('H:i') }}
                                            @endif
                                            WIB
                                        @else
                                            WIB
                                        @endif
                                    </span>
                                    @endif
                                </div>
                                @endif
                            </div>

                            {{-- Right: status badge --}}
                            <div class="shrink-0 self-start sm:self-center">
                                @if($isAttended)
                                    <div class="flex flex-col items-end gap-0.5 bg-green-100 border border-green-200 rounded-xl px-4 py-2.5">
                                        <span class="flex items-center gap-1 text-xs font-bold text-green-700">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Hadir
                                        </span>
                                        @if($sesi['waktu_scan'])
                                            <span class="text-[10px] font-mono text-green-600 tabular-nums">
                                                @if($sesi['waktu_scan'] instanceof \Carbon\Carbon)
                                                    {{ $sesi['waktu_scan']->format('d M · H:i') }}
                                                @else
                                                    {{ \Carbon\Carbon::parse($sesi['waktu_scan'])->format('d M · H:i') }}
                                                @endif
                                                WIB
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-gray-100 text-gray-500 border border-gray-200">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Belum
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Attended accent bar --}}
                        @if($isAttended)
                        <div class="h-1 bg-gradient-to-r from-green-400 to-emerald-300"></div>
                        @endif
                    </div>
                </div>
            @endforeach
            </div>
        </div>

        {{-- Legend --}}
        <div class="mt-8 flex flex-wrap items-center justify-center gap-5 text-xs text-gray-500">
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span>
                Sesi Dihadiri
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-gray-200 inline-block"></span>
                Belum Hadir
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-gradient-to-b from-primary to-accent inline-block"></span>
                Alur Kegiatan
            </span>
        </div>

        @else
        {{-- Empty sessions inside active event --}}
        <div class="bg-white border border-gray-100 rounded-[2rem] p-12 text-center shadow-card">
            <div class="w-16 h-16 mx-auto mb-4 bg-primary-50 rounded-2xl flex items-center justify-center">
                <svg class="w-8 h-8 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-heading font-bold text-gray-700 mb-1">Sesi Belum Tersedia</h3>
            <p class="text-sm text-gray-400 max-w-xs mx-auto">Panitia belum menambahkan sesi untuk acara ini. Cek kembali nanti.</p>
        </div>
        @endif

    @else
    {{-- ── Empty state: no active event ── --}}
    <div class="flex flex-col items-center justify-center py-16 text-center bg-white border border-gray-100 rounded-[2.5rem] p-8 shadow-card">
        <div class="w-52 h-52 mb-6">
            <img src="{{ asset('images/arka/arka_fokus.png') }}" alt="Tidak ada acara" class="w-full h-full object-contain opacity-50 grayscale">
        </div>
        <span class="px-3 py-1 text-xs font-bold uppercase tracking-widest bg-primary-50 text-primary-600 rounded-full border border-primary-100 mb-3">Tidak Ada Acara</span>
        <h2 class="text-2xl font-heading font-bold text-gray-800 mb-2">Belum Ada Jadwal Aktif</h2>
        <p class="text-gray-500 max-w-sm mx-auto text-sm leading-relaxed">
            Saat ini Anda belum terdaftar dalam Baitul Arqam yang sedang aktif.<br>
            Silakan hubungi admin MPKSDI jika terjadi kesalahan.
        </p>
        <a href="{{ route('peserta.dashboard') }}" class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-600 transition-colors shadow-md shadow-primary/20">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Kembali ke Beranda
        </a>
    </div>
    @endif

</div>
@endsection
