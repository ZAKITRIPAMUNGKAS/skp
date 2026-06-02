@extends('layouts.main')

@section('title', 'Kelola Event')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Dashboard</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-sm font-medium text-gray-700">Kelola Event</span>
@endsection

@section('content')

    <x-page-header title="Kelola Event" subtitle="Kelola seluruh kegiatan Baitul Arqam">
        <x-slot:actions>
            <x-button variant="primary" href="{{ route('admin.events.create') }}">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Event Baru
            </x-button>
        </x-slot:actions>
    </x-page-header>

    {{-- Filters --}}
    <div class="mb-6">
        <form method="GET" action="{{ route('admin.events.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari event..."
                    class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-white">
            </div>
            <select name="status" onchange="this.form.submit()"
                class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                <option value="">Semua Status</option>
                <option value="persiapan" {{ request('status') == 'persiapan' ? 'selected' : '' }}>Persiapan</option>
                <option value="berlangsung" {{ request('status') == 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            <x-button type="submit" variant="secondary" size="md">Cari</x-button>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-card border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="text-left px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Nama Event</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Tanggal</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Lokasi</th>
                        <th class="text-center px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Peserta</th>
                        <th class="text-center px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Status</th>
                        <th class="text-right px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($events as $event)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.events.show', $event) }}" class="font-medium text-gray-800 hover:text-primary transition-colors">
                                    {{ $event->nama_event }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $event->tanggal_mulai->format('d M Y') }} — {{ $event->tanggal_selesai->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $event->lokasi ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center gap-1 text-gray-600">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    {{ $event->event_peserta_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <x-badge :type="$event->status">{{ ucfirst($event->status) }}</x-badge>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.events.show', $event) }}" class="p-2 rounded-lg hover:bg-primary/10 text-gray-400 hover:text-primary transition-colors" title="Detail">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.events.edit', $event) }}" class="p-2 rounded-lg hover:bg-accent/10 text-gray-400 hover:text-accent transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <x-empty-state title="Belum ada event" description="Buat event pertama untuk memulai kegiatan Baitul Arqam." icon="document">
                                    <x-button variant="primary" href="{{ route('admin.events.create') }}">Buat Event Baru</x-button>
                                </x-empty-state>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($events->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                {{ $events->links() }}
            </div>
        @endif
    </div>

@endsection
