@extends('layouts.main')

@section('title', 'Edit Galeri Pelatihan')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Dashboard</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('admin.galleries.index') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Galeri Pelatihan</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-sm font-medium text-gray-700">Edit</span>
@endsection

@section('content')

    <x-page-header title="Edit Foto Galeri" subtitle="Perbarui detail dokumentasi foto untuk kegiatan Baitul Arqam UMS">
        <x-slot:actions>
            <x-button variant="secondary" href="{{ route('admin.galleries.index') }}">
                Kembali
            </x-button>
        </x-slot:actions>
    </x-page-header>

    <x-card>
        <form method="POST" action="{{ route('admin.galleries.update', $gallery) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <x-form-input label="Judul Foto / Kegiatan" name="title" value="{{ $gallery->title }}" placeholder="Masukkan judul galeri..." required="true" />

            <x-form-input label="Nama Event (Opsional)" name="event_name" value="{{ $gallery->event_name }}" placeholder="Contoh: Baitul Arqam Dosen & Tendik..." />

            <div>
                <label for="image" class="relative flex items-center justify-center border-2 border-dashed border-gray-200 hover:border-primary rounded-2xl p-6 transition-all bg-gray-50/50 hover:bg-white cursor-pointer group"
                     x-data="{ preview: '{{ $gallery->image_url }}' }">
                    <input type="file" id="image" name="image" class="hidden" accept="image/*"
                           @change="const file = $event.target.files[0]; if(file){ preview = URL.createObjectURL(file); }">
                    
                    <div x-show="!preview" class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-primary transition-colors mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm font-medium text-gray-700">Pilih berkas atau seret kemari</p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG hingga 3MB</p>
                    </div>

                    <div x-show="preview" class="w-full flex flex-col items-center gap-3">
                        <img :src="preview" class="max-h-48 rounded-xl object-contain shadow-sm border border-gray-100 bg-white p-1">
                        <p class="text-xs text-gray-500 font-medium text-primary">Klik untuk mengganti gambar</p>
                    </div>
                </label>
                @error('image')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <x-form-input label="Urutan Tampilan" name="urutan" type="number" value="{{ $gallery->urutan }}" placeholder="Contoh: 1, 2, 3..." required="true" helper="Menentukan urutan prioritas kemunculan foto di landing page." />

            <div class="flex items-center gap-3 justify-end border-t border-gray-100 pt-5 mt-8">
                <x-button variant="secondary" href="{{ route('admin.galleries.index') }}">Batal</x-button>
                <x-button type="submit" variant="primary">Perbarui Foto</x-button>
            </div>
        </form>
    </x-card>

@endsection
