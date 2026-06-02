@extends('layouts.main')

@section('title', 'Detail Peserta — ARQAM')

@section('content')
<div class="p-6 max-w-5xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.participants.index') }}" class="p-2 bg-white border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold font-heading text-gray-800">Detail Peserta</h1>
                <p class="text-sm text-gray-500">Informasi profil dan riwayat event.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Profile Card --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
                <div class="w-24 h-24 rounded-full bg-primary/10 mx-auto mb-4 flex items-center justify-center border-4 border-white shadow-sm overflow-hidden">
                    @if($peserta->foto)
                        <img src="{{ asset('storage/' . $peserta->foto) }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-2xl font-bold text-primary">{{ strtoupper(substr($peserta->nama_lengkap, 0, 2)) }}</span>
                    @endif
                </div>
                <h2 class="text-lg font-bold text-gray-800">{{ $peserta->nama_lengkap }}</h2>
                <p class="text-xs text-gray-400 font-mono mb-4">{{ $peserta->user->username }}</p>
                
                <div class="flex justify-center gap-2">
                    <x-badge type="berlangsung">Peserta Aktif</x-badge>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Informasi Kontak
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Email</p>
                        <p class="text-sm text-gray-700">{{ $peserta->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">No. WhatsApp</p>
                        <p class="text-sm text-gray-700">{{ $peserta->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Unit Kerja / Instansi</p>
                        <p class="text-sm text-gray-700">{{ $peserta->unit_kerja ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Event History --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-800">Riwayat Perkaderan ({{ $peserta->eventPeserta->count() }})</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-6 py-3 font-semibold text-gray-600">Event</th>
                                <th class="px-6 py-3 font-semibold text-gray-600 text-center">Skor</th>
                                <th class="px-6 py-3 font-semibold text-gray-600 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($peserta->eventPeserta as $ep)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800">{{ $ep->event->nama_event }}</p>
                                    <p class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($ep->event->tgl_mulai)->format('d M Y') }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($ep->skor)
                                        <span class="font-bold text-primary">{{ number_format($ep->skor->skor_akhir, 1) }}</span>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($ep->skor)
                                        @if(str_contains($ep->skor->status_kelulusan, 'Lulus'))
                                            <span class="px-2 py-1 bg-green-50 text-green-600 text-[10px] font-bold rounded-lg uppercase">LULUS</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-50 text-red-600 text-[10px] font-bold rounded-lg uppercase">TIDAK LULUS</span>
                                        @endif
                                    @else
                                        <span class="px-2 py-1 bg-yellow-50 text-yellow-600 text-[10px] font-bold rounded-lg uppercase">PROSES</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-400">
                                    Belum pernah mengikuti event.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
