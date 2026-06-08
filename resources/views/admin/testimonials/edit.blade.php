@extends('layouts.main')

@section('title', 'Edit Testimoni')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Dashboard</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('admin.testimonials.index') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Testimoni</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-sm font-medium text-gray-700">Edit</span>
@endsection

@section('content')

    <x-page-header title="Edit Testimoni" subtitle="Perbarui detail kutipan testimoni dari peserta / alumni Baitul Arqam">
        <x-slot:actions>
            <x-button variant="secondary" href="{{ route('admin.testimonials.index') }}">
                Kembali
            </x-button>
        </x-slot:actions>
    </x-page-header>

    <x-card>
        <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <x-form-input label="Nama Lengkap" name="name" value="{{ $testimonial->name }}" placeholder="Masukkan nama pemberi testimoni..." required="true" />

            <x-form-input label="Jabatan / Role / Instansi" name="role" value="{{ $testimonial->role }}" placeholder="Contoh: Dosen FAI UMS, Tendik BAA UMS..." required="true" />

            <x-form-input label="Isi Testimoni" name="quote" type="textarea" rows="4" value="{{ $testimonial->quote }}" placeholder="Masukkan testimoni atau kutipan..." required="true" />
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto Profil / Avatar (Kosongkan jika tidak ingin mengganti)</label>
                <label for="photo" class="relative flex items-center justify-center border-2 border-dashed border-gray-200 hover:border-primary rounded-2xl p-6 transition-all bg-gray-50/50 hover:bg-white cursor-pointer group"
                     x-data="{ preview: '{{ $testimonial->photo_url }}' }">
                    <input type="file" id="photo" name="photo" class="hidden" accept="image/*"
                           @change="const file = $event.target.files[0]; if(file){ preview = URL.createObjectURL(file); }">
                    
                    <div x-show="!preview" class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-primary transition-colors mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <p class="text-sm font-medium text-gray-700">Pilih foto atau seret kemari</p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG hingga 2MB</p>
                    </div>

                    <div x-show="preview" class="w-full flex flex-col items-center gap-3">
                        <img :src="preview" class="max-h-32 w-32 rounded-full object-cover shadow-sm border border-gray-100 bg-white p-1">
                        <p class="text-xs text-gray-500 font-medium text-primary">Klik untuk mengganti foto</p>
                    </div>
                </label>
                @error('photo')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <x-form-input label="Urutan Tampilan" name="urutan" type="number" value="{{ $testimonial->urutan }}" placeholder="Contoh: 1, 2, 3..." required="true" helper="Menentukan urutan prioritas kemunculan testimoni di landing page." />

            <div class="flex items-center gap-3 justify-end border-t border-gray-100 pt-5 mt-8">
                <x-button variant="secondary" href="{{ route('admin.testimonials.index') }}">Batal</x-button>
                <x-button type="submit" variant="primary">Perbarui Testimoni</x-button>
            </div>
        </form>
    </x-card>

@endsection
