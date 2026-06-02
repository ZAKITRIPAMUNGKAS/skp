@extends('layouts.main')

@section('title', 'Kelola Peserta — ARQAM')

@section('content')
<div class="p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold font-heading text-gray-800">Kelola Peserta</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar seluruh peserta yang terdaftar di sistem.</p>
        </div>
        
        <form method="GET" action="{{ route('admin.participants.index') }}" class="flex gap-2">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nama, email, atau unit..."
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
                        <th class="px-6 py-4 font-semibold text-gray-600">Peserta</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Unit Kerja</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-center">Terdaftar Pada</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($participants as $p)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                    @if($p->foto)
                                        <img src="{{ asset('storage/' . $p->foto) }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <span class="text-xs font-bold text-primary">{{ strtoupper(substr($p->nama_lengkap, 0, 2)) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $p->nama_lengkap }}</p>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] px-1 bg-gray-100 text-gray-500 rounded font-mono">{{ $p->user->username }}</span>
                                        <span class="text-[10px] text-gray-400">{{ $p->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $p->unit_kerja ?? '-' }}</td>
                        <td class="px-6 py-4 text-center text-gray-500">{{ $p->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.participants.show', $p) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary/5 text-primary hover:bg-primary hover:text-white rounded-lg text-xs font-bold transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                            Tidak ada data peserta ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($participants->hasPages())
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            {{ $participants->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
