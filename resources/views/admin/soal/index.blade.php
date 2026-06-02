@extends('layouts.main')

@section('title', 'Bank Soal — ARQAM')

@section('content')
<div class="p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold font-heading text-gray-800">Bank Soal</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola seluruh database soal pretest dan posttest.</p>
        </div>
        
        <form method="GET" action="{{ route('admin.soal.index') }}" class="flex gap-2">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari teks soal atau event..."
                    class="w-64 pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <x-button type="submit" variant="primary">Filter</x-button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold text-gray-600">Teks Soal</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Event Asal</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-center">Tipe</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($soals as $s)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <p class="text-gray-800 line-clamp-2 max-w-md">{{ $s->teks_soal }}</p>
                            <div class="flex gap-1 mt-1">
                                @foreach($s->pilihanJawaban as $p)
                                    <span class="text-[9px] px-1 rounded {{ $p->is_correct ? 'bg-green-100 text-green-600 font-bold' : 'bg-gray-100 text-gray-400' }}">
                                        {{ $p->huruf }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            <span class="text-xs font-medium">{{ $s->event->nama_event ?? 'Event Tidak Ditemukan' }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <x-badge :type="$s->tipe === 'pretest' ? 'persiapan' : 'berlangsung'">
                                {{ strtoupper($s->tipe) }}
                            </x-badge>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($s->event_id)
                                <a href="{{ route('admin.events.show', $s->event_id) }}" class="text-xs text-primary hover:underline">Edit di Event</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                            Tidak ada data soal ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($soals->hasPages())
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            {{ $soals->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
