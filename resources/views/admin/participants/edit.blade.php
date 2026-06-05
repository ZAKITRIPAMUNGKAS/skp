@extends('layouts.main')

@section('title', 'Edit Peserta — ' . $peserta->nama_lengkap)

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Dashboard</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('admin.participants.index') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Kelola Peserta</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('admin.participants.show', $peserta) }}" class="text-sm text-gray-500 hover:text-primary transition-colors">{{ Str::limit($peserta->nama_lengkap, 20) }}</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-sm font-medium text-gray-700">Edit Profil</span>
@endsection

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold font-heading text-gray-800">Edit Profil Peserta</h1>
            <p class="text-sm text-gray-500 mt-1">Ubah data identitas, kontak, dan riwayat umum milik {{ $peserta->nama_lengkap }}.</p>
        </div>
    </div>

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
            {{ session('error') }}
        </div>
    @endif

    <x-card>
        <form method="POST" action="{{ route('admin.participants.update', $peserta) }}">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                {{-- Bagian 1: Informasi Pokok / Akun --}}
                <div>
                    <h3 class="text-sm font-bold text-primary uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Informasi Akun & Login</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap beserta Gelar <span class="text-red-500">*</span></label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap"
                                value="{{ old('nama_lengkap', $peserta->nama_lengkap) }}"
                                class="w-full px-4 py-2.5 text-sm border {{ $errors->has('nama_lengkap') ? 'border-red-300 bg-red-50/50' : 'border-gray-200' }} rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white" required>
                            @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="nama_panggilan" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Panggilan</label>
                            <input type="text" id="nama_panggilan" name="nama_panggilan"
                                value="{{ old('nama_panggilan', $peserta->nama_panggilan) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Aktif <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', $peserta->email) }}"
                                class="w-full px-4 py-2.5 text-sm border {{ $errors->has('email') ? 'border-red-300 bg-red-50/50' : 'border-gray-200' }} rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white" required>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Reset Password <span class="text-xs text-gray-400">(Isi hanya jika ingin diganti)</span></label>
                            <input type="password" id="password" name="password"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white" placeholder="Minimal 6 karakter">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Bagian 2: Data Identitas --}}
                <div>
                    <h3 class="text-sm font-bold text-primary uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Identitas & Kontak</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-1.5">NIK</label>
                            <input type="text" id="nik" name="nik"
                                value="{{ old('nik', $peserta->nik) }}"
                                class="w-full px-4 py-2.5 text-sm border {{ $errors->has('nik') ? 'border-red-300' : 'border-gray-200' }} rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white">
                            @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="nbm" class="block text-sm font-medium text-gray-700 mb-1.5">NBM (Jika ada)</label>
                            <input type="text" id="nbm" name="nbm"
                                value="{{ old('nbm', $peserta->nbm) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white">
                        </div>
                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1.5">No. WhatsApp</label>
                            <input type="text" id="no_hp" name="no_hp"
                                value="{{ old('no_hp', $peserta->no_hp) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white">
                        </div>
                        <div>
                            <label for="unit_kerja" class="block text-sm font-medium text-gray-700 mb-1.5">Homebase / Unit Kerja</label>
                            <input type="text" id="unit_kerja" name="unit_kerja"
                                value="{{ old('unit_kerja', $peserta->unit_kerja) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white" placeholder="Fakultas / Program Studi">
                        </div>
                        <div>
                            <label for="jabatan_aum" class="block text-sm font-medium text-gray-700 mb-1.5">Jabatan di AUM</label>
                            <input type="text" id="jabatan_aum" name="jabatan_aum"
                                value="{{ old('jabatan_aum', $peserta->jabatan_aum) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white">
                        </div>
                        <div>
                            <label for="ukuran_kaos" class="block text-sm font-medium text-gray-700 mb-1.5">Ukuran Kaos</label>
                            <input type="text" id="ukuran_kaos" name="ukuran_kaos"
                                value="{{ old('ukuran_kaos', $peserta->ukuran_kaos) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white" placeholder="S, M, L, XL, XXL, etc.">
                        </div>
                    </div>
                </div>

                {{-- Bagian 3: Profil Pribadi & Tempat Tanggal Lahir --}}
                <div>
                    <h3 class="text-sm font-bold text-primary uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Profil Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1.5">Tempat Lahir</label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir"
                                value="{{ old('tempat_lahir', $peserta->tempat_lahir) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white">
                        </div>
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $peserta->tanggal_lahir?->format('Y-m-d')) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white">
                        </div>
                        <div>
                            <label for="umur" class="block text-sm font-medium text-gray-700 mb-1.5">Umur</label>
                            <input type="number" id="umur" name="umur"
                                value="{{ old('umur', $peserta->umur) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white">
                        </div>
                        <div>
                            <label for="status_pernikahan" class="block text-sm font-medium text-gray-700 mb-1.5">Status Nikah</label>
                            <select id="status_pernikahan" name="status_pernikahan"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white">
                                <option value="" {{ old('status_pernikahan', $peserta->status_pernikahan) == '' ? 'selected' : '' }}>Pilih Status</option>
                                <option value="Menikah" {{ old('status_pernikahan', $peserta->status_pernikahan) == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                <option value="Belum Menikah" {{ old('status_pernikahan', $peserta->status_pernikahan) == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="Cerai" {{ old('status_pernikahan', $peserta->status_pernikahan) == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Bagian 4: Domisili --}}
                <div>
                    <h3 class="text-sm font-bold text-primary uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Alamat & Domisili</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-4">
                            <label for="alamat_rumah" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Lengkap</label>
                            <textarea id="alamat_rumah" name="alamat_rumah" rows="2"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white resize-none">{{ old('alamat_rumah', $peserta->alamat_rumah) }}</textarea>
                        </div>
                        <div>
                            <label for="desa_kelurahan" class="block text-sm font-medium text-gray-700 mb-1.5">Desa / Kelurahan</label>
                            <input type="text" id="desa_kelurahan" name="desa_kelurahan"
                                value="{{ old('desa_kelurahan', $peserta->desa_kelurahan) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white">
                        </div>
                        <div>
                            <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1.5">Kecamatan</label>
                            <input type="text" id="kecamatan" name="kecamatan"
                                value="{{ old('kecamatan', $peserta->kecamatan) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white">
                        </div>
                        <div>
                            <label for="kabupaten" class="block text-sm font-medium text-gray-700 mb-1.5">Kabupaten / Kota</label>
                            <input type="text" id="kabupaten" name="kabupaten"
                                value="{{ old('kabupaten', $peserta->kabupaten) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white">
                        </div>
                        <div>
                            <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-1.5">Provinsi</label>
                            <input type="text" id="provinsi" name="provinsi"
                                value="{{ old('provinsi', $peserta->provinsi) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white">
                        </div>
                    </div>
                </div>

                {{-- Bagian 5: Kompetensi --}}
                <div>
                    <h3 class="text-sm font-bold text-primary uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Kompetensi & Kemampuan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="kemampuan_baca_quran" class="block text-sm font-medium text-gray-700 mb-1.5">Kemampuan Membaca Al-Qur'an</label>
                            <input type="text" id="kemampuan_baca_quran" name="kemampuan_baca_quran"
                                value="{{ old('kemampuan_baca_quran', $peserta->kemampuan_baca_quran) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white" placeholder="Contoh: Lancar dan tajwid baik">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <x-button variant="ghost" href="{{ route('admin.participants.show', $peserta) }}">Batal</x-button>
                <x-button type="submit" variant="primary">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
