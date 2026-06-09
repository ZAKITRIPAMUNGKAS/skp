@extends('layouts.main')

@section('title', 'Profil Saya — ARQAM')

@section('content')
    <x-page-header title="Profil Saya" subtitle="Kelola dan perbarui informasi data diri Anda." />

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-4 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">
            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Profile Summary Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center text-center h-fit">
            <div class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center mb-4 ring-4 ring-primary/5 overflow-hidden">
                @if($user->foto_url)
                    <img src="{{ $user->foto_url }}" class="w-full h-full object-cover">
                @else
                    <span class="text-2xl font-bold text-primary">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                @endif
            </div>
            
            <h3 class="text-lg font-bold text-gray-800">{{ $user->name }}</h3>
            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-primary/10 text-primary capitalize">
                {{ $user->role }}
            </span>

            <div class="w-full border-t border-gray-100 my-5"></div>

            <div class="w-full space-y-4 text-left">
                <div>
                    <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Username</label>
                    <p class="text-sm font-semibold text-gray-800 font-mono mt-0.5">{{ $user->username }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Email Utama</label>
                    <p class="text-sm font-medium text-gray-700 mt-0.5">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        {{-- Form Edit Card --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h4 class="text-base font-bold text-gray-800 mb-6 font-heading flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Informasi Profil
                </h4>

                <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all @error('name') border-red-300 @enderror">
                            @error('name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Username <span class="text-red-500">*</span></label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-mono @error('username') border-red-300 @enderror">
                            @error('username')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all @error('email') border-red-300 @enderror">
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Foto Profil (Maks. 2MB, otomatis dipotong 1x1)</label>
                        <div x-data="{ 
                            previewUrl: '{{ $user->foto_url ?? '' }}', 
                            warning: '',
                            handleFile(e) {
                                const file = e.target.files[0];
                                if (!file) return;
                                if (file.size > 2 * 1024 * 1024) {
                                    this.warning = 'Ukuran berkas melebihi 2MB! Silakan pilih berkas yang lebih kecil atau kurangi ukurannya.';
                                    this.previewUrl = '{{ $user->foto_url ?? '' }}';
                                    e.target.value = '';
                                    document.getElementById('cropped_foto_input').value = '';
                                    return;
                                }
                                this.warning = '';
                                
                                const reader = new FileReader();
                                reader.onload = (event) => {
                                    const img = new Image();
                                    img.onload = () => {
                                        const canvas = document.createElement('canvas');
                                        const size = Math.min(img.width, img.height);
                                        canvas.width = size;
                                        canvas.height = size;
                                        const ctx = canvas.getContext('2d');
                                        ctx.drawImage(img, (img.width - size) / 2, (img.height - size) / 2, size, size, 0, 0, size, size);
                                        const croppedDataUrl = canvas.toDataURL('image/jpeg');
                                        this.previewUrl = croppedDataUrl;
                                        document.getElementById('cropped_foto_input').value = croppedDataUrl;
                                    };
                                    img.src = event.target.result;
                                };
                                reader.readAsDataURL(file);
                            }
                        }">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center overflow-hidden shrink-0">
                                    <template x-if="previewUrl">
                                        <img :src="previewUrl" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!previewUrl">
                                        <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </template>
                                </div>
                                <div class="flex-1">
                                    <input type="file" accept="image/*" @change="handleFile($event)"
                                           class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                                </div>
                            </div>
                            <p x-show="warning" class="mt-2 text-xs font-semibold text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100" x-text="warning" x-cloak></p>
                            <input type="hidden" name="cropped_foto" id="cropped_foto_input">
                        </div>
                    </div>

                    <div class="border-t border-gray-100 my-6 pt-5">
                        <h5 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            Ganti Password (Opsional)
                        </h5>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Password Baru</label>
                                <input type="password" name="password" placeholder="Kosongkan jika tidak diganti"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all @error('password') border-red-300 @enderror">
                                @error('password')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-all shadow-sm active:scale-95">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
