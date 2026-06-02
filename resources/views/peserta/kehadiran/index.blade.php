@extends('layouts.main')

@section('title', 'Kehadiran Sesi')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <x-page-header title="Kehadiran" subtitle="Riwayat kehadiran sesi Baitul Arqam" />

    @if($activeEvent)
        {{-- Attendance Stat Card --}}
        <div class="mt-8 bg-gradient-to-r from-primary to-secondary rounded-[2.5rem] p-8 text-white shadow-xl shadow-primary/10 mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center md:text-left">
                <span class="px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-white/95 text-xs font-bold uppercase tracking-widest border border-white/20">
                    Rekapitulasi Kehadiran
                </span>
                <h3 class="text-3xl font-heading font-extrabold text-white">Persentase Kehadiran Anda</h3>
                <p class="text-primary-100 text-sm max-w-md">
                    Kehadiran Anda dicatat oleh panitia saat memindai Kode QR Anda di setiap sesi.
                </p>
            </div>
            
            <div class="flex items-center gap-6 shrink-0 bg-white/10 p-6 rounded-3xl border border-white/20 backdrop-blur-sm">
                <div class="text-center">
                    <span class="block text-4xl font-black text-accent-200">
                        {{ $totalSessions > 0 ? round(($attendedCount / $totalSessions) * 100) : 0 }}%
                    </span>
                    <span class="text-xs text-white/70 font-semibold uppercase tracking-wider block mt-1">Kehadiran</span>
                </div>
                <div class="h-12 w-[1px] bg-white/20"></div>
                <div class="text-center">
                    <span class="block text-2xl font-bold text-white">
                        {{ $attendedCount }} / {{ $totalSessions }}
                    </span>
                    <span class="text-xs text-white/70 font-semibold uppercase tracking-wider block mt-1">Sesi Terdaftar</span>
                </div>
            </div>
        </div>

        {{-- Timeline List --}}
        <div class="bg-white rounded-[2.5rem] border border-gray-100 p-8 shadow-sm">
            <h3 class="text-xl font-heading font-bold text-gray-800 mb-8">Riwayat Sesi & Presensi</h3>
            
            @if($sessions->count() > 0)
                <div class="relative space-y-8 pl-8 md:pl-12">
                    {{-- Vertical Line --}}
                    <div class="absolute left-[19px] md:left-[23px] top-2 bottom-2 w-[2px] bg-gray-100"></div>

                    @foreach($sessions as $sesi)
                        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-4 group">
                            {{-- Point Icon --}}
                            <div class="absolute left-[-29px] md:left-[-33px] top-1 md:top-auto z-10 w-8 h-8 rounded-full border-2 flex items-center justify-center transition-colors duration-300
                                {{ $sesi['attended'] ? 'bg-green-500 border-green-500 text-white' : 'bg-white border-gray-200 text-gray-300 group-hover:border-primary/45' }}">
                                @if($sesi['attended'])
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                @else
                                    <span class="text-xs font-bold">{{ str_pad($sesi['urutan'], 2, '0', STR_PAD_LEFT) }}</span>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="flex-1">
                                <h4 class="text-base font-bold text-gray-800 transition-colors group-hover:text-primary">
                                    {{ $sesi['nama_sesi'] }}
                                </h4>
                                <p class="text-xs text-gray-400 mt-1">
                                    Sesi ke-{{ $sesi['urutan'] }} pada {{ $activeEvent->nama_event }}
                                </p>
                            </div>

                            {{-- Status Label --}}
                            <div class="flex items-center shrink-0">
                                @if($sesi['attended'])
                                    <div class="bg-green-50 border border-green-100 rounded-2xl px-4 py-2 flex flex-col items-end">
                                        <span class="text-xs font-bold text-green-600">Hadir</span>
                                        <span class="text-[10px] text-green-500 font-mono mt-0.5">
                                            {{ $sesi['waktu_scan'] ? $sesi['waktu_scan']->format('d M Y - H:i') : '' }} WIB
                                        </span>
                                    </div>
                                @else
                                    <span class="px-4 py-1.5 bg-rose-50 text-rose-600 text-xs font-semibold rounded-full border border-rose-100">
                                        Tidak Hadir
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-sm font-semibold">Belum ada sesi yang terdaftar untuk acara ini.</p>
                </div>
            @endif
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-20 text-center bg-white border border-gray-100 rounded-[2.5rem] mt-8 p-8">
            <div class="w-64 h-64 mb-8">
                <img src="{{ asset('images/arka/arka_fokus.png') }}" alt="No Event" class="w-full h-full object-contain opacity-50 grayscale">
            </div>
            <h2 class="text-3xl font-heading font-bold text-gray-800 mb-2">Belum Ada Acara Aktif</h2>
            <p class="text-gray-500 max-w-md mx-auto">Saat ini Anda belum terdaftar dalam Baitul Arqam yang sedang aktif. Silakan hubungi admin MPKSDI jika terjadi kesalahan.</p>
        </div>
    @endif
</div>
@endsection
