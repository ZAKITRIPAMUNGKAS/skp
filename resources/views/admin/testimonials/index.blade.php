@extends('layouts.main')

@section('title', 'Testimoni (Apa Kata Mereka)')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Dashboard</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-sm font-medium text-gray-700">Testimoni</span>
@endsection

@section('content')

    <x-page-header title="Testimoni (Apa Kata Mereka)" subtitle="Kelola data testimoni peserta/alumni kegiatan Baitul Arqam UMS">
        <x-slot:actions>
            <x-button variant="primary" href="{{ route('admin.testimonials.create') }}">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Testimoni
            </x-button>
        </x-slot:actions>
    </x-page-header>

    {{-- Testimonial List --}}
    @if($testimonials->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @foreach($testimonials as $testimonial)
                <div class="bg-white rounded-2xl p-6 shadow-card border border-gray-100 flex flex-col justify-between group hover:shadow-lg transition-all duration-300">
                    <div>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 ring-2 ring-primary/20">
                                <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm">{{ $testimonial->name }}</h3>
                                <p class="text-xs text-gray-400">{{ $testimonial->role }}</p>
                            </div>
                        </div>
                        <div class="relative mb-6">
                            <span class="absolute -top-3 -left-2 text-primary/10 text-5xl font-serif">“</span>
                            <p class="text-sm text-gray-600 italic relative z-10 line-clamp-4 pl-4">{{ $testimonial->quote }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between border-t border-gray-50 pt-4 mt-auto">
                        <span class="text-xs text-gray-400 bg-gray-50 px-2.5 py-1 rounded-full font-medium">Urutan: {{ $testimonial->urutan }}</span>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="inline-flex items-center justify-center p-2 bg-accent/10 hover:bg-accent/20 text-accent rounded-xl transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus testimoni ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($testimonials->hasPages())
            <div class="bg-white rounded-2xl p-4 shadow-card border border-gray-100">
                {{ $testimonials->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-2xl shadow-card border border-gray-100 py-16">
            <x-empty-state title="Belum Ada Testimoni" description="Tambahkan testimoni / review pertama dari peserta." icon="comment">
                <x-button variant="primary" href="{{ route('admin.testimonials.create') }}">Tambah Testimoni</x-button>
            </x-empty-state>
        </div>
    @endif

@endsection
