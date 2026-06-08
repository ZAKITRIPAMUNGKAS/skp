@extends('layouts.main')

@section('title', 'Galeri Pelatihan')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Dashboard</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-sm font-medium text-gray-700">Galeri Pelatihan</span>
@endsection

@section('content')

    <x-page-header title="Galeri Pelatihan" subtitle="Kelola foto galeri dokumentasi pelatihan Baitul Arqam">
        <x-slot:actions>
            <x-button variant="primary" href="{{ route('admin.galleries.create') }}">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Foto Galeri
            </x-button>
        </x-slot:actions>
    </x-page-header>

    {{-- Gallery Grid --}}
    @if($galleries->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
            @foreach($galleries as $gallery)
                <div class="bg-white rounded-2xl overflow-hidden shadow-card border border-gray-100 flex flex-col group hover:shadow-lg transition-all duration-300">
                    <div class="relative aspect-video w-full overflow-hidden bg-gray-100">
                        <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <span class="absolute top-3 left-3 bg-black/60 backdrop-blur-sm text-white text-[11px] font-medium px-2.5 py-1 rounded-full">
                            Urutan: {{ $gallery->urutan }}
                        </span>
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div class="mb-4">
                            <h3 class="font-bold text-gray-800 line-clamp-1 text-sm mb-1">{{ $gallery->title }}</h3>
                            <p class="text-xs text-gray-400 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $gallery->event_name ?? 'Umum' }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 border-t border-gray-50 pt-3">
                            <a href="{{ route('admin.galleries.edit', $gallery) }}" class="flex-1 inline-flex justify-center items-center py-2 px-3 bg-accent/10 hover:bg-accent/20 text-accent font-semibold text-xs rounded-xl transition-colors">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.galleries.destroy', $gallery) }}" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus foto galeri ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full inline-flex justify-center items-center py-2 px-3 bg-red-50 hover:bg-red-100 text-red-600 font-semibold text-xs rounded-xl transition-colors">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($galleries->hasPages())
            <div class="bg-white rounded-2xl p-4 shadow-card border border-gray-100">
                {{ $galleries->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-2xl shadow-card border border-gray-100 py-16">
            <x-empty-state title="Belum Ada Galeri" description="Tambahkan foto galeri pelatihan pertama Anda." icon="image">
                <x-button variant="primary" href="{{ route('admin.galleries.create') }}">Tambah Foto Galeri</x-button>
            </x-empty-state>
        </div>
    @endif

@endsection
