@extends('layouts.main')

@section('title', 'Profil Saya')

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'edit' }">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Profil Saya</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola akun dan lihat data biodata pendaftaran Anda.</p>
    </div>

    {{-- Profile Card Header --}}
    <div class="bg-gradient-to-r from-primary to-primary-700 rounded-3xl p-6 text-white flex items-center gap-5">
        <div class="w-20 h-20 rounded-2xl bg-white/20 border-2 border-white/30 overflow-hidden flex-shrink-0">
            @if($peserta->foto)
                <img src="{{ $peserta->foto_url }}" class="w-full h-full object-cover" alt="Foto">
            @else
                <div class="w-full h-full flex items-center justify-center font-extrabold text-3xl text-white font-heading">
                    {{ strtoupper(substr($peserta->nama_lengkap, 0, 1)) }}
                </div>
            @endif
        </div>
        <div>
            <h2 class="text-xl font-bold leading-tight">{{ $peserta->nama_lengkap }}</h2>
            <p class="text-primary-100 text-sm mt-0.5">{{ $peserta->unit_kerja ?? 'Peserta Baitul Arqam' }}</p>
            <p class="text-primary-200 text-xs mt-1">&#64;{{ auth()->user()->username }}</p>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="flex gap-1 bg-gray-100 p-1 rounded-2xl w-full sm:w-auto sm:inline-flex">
        <button @click="activeTab = 'edit'"
            class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-sm font-semibold transition-all"
            :class="activeTab === 'edit' ? 'bg-white text-primary shadow-sm' : 'text-gray-500 hover:text-gray-700'">
            Edit Profil
        </button>
        <button @click="activeTab = 'biodata'"
            class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-sm font-semibold transition-all"
            :class="activeTab === 'biodata' ? 'bg-white text-primary shadow-sm' : 'text-gray-500 hover:text-gray-700'">
            Data Biodata
        </button>
        <button @click="activeTab = 'riwayat'"
            class="flex-1 sm:flex-none px-5 py-2.5 rounded-xl text-sm font-semibold transition-all"
            :class="activeTab === 'riwayat' ? 'bg-white text-primary shadow-sm' : 'text-gray-500 hover:text-gray-700'">
            Riwayat Event
        </button>
    </div>

    {{-- Tab: Edit Profil --}}
    <div x-show="activeTab === 'edit'" x-transition>
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Edit Data Dasar</h3>
            <form action="{{ route('peserta.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf @method('PUT')

                <div class="flex flex-col sm:flex-row gap-6 items-start">
                    <div class="shrink-0 flex flex-col items-center" id="profilePhotoSection"
                         x-data="{ preview: '{{ $peserta->foto_url }}' }">
                        <div class="w-24 h-24 rounded-full bg-gray-100 overflow-hidden mb-3 border-2 border-primary/20">
                            <template x-if="preview">
                                <img :src="preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!preview">
                                <div class="w-full h-full flex items-center justify-center font-bold text-xl text-primary font-heading">
                                    {{ strtoupper(substr($peserta->nama_lengkap, 0, 2)) }}
                                </div>
                            </template>
                        </div>
                        <label class="px-3 py-1.5 bg-gray-50 text-xs font-semibold text-gray-600 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors">
                            Ganti Foto
                            <input type="file" id="fotoInput" name="foto" class="hidden" accept="image/*"
                                @change="handleProfilePhotoChange($event)">
                        </label>
                        <input type="hidden" name="cropped_foto" id="croppedFotoInput">
                        @error('foto') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex-1 space-y-4 w-full">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $peserta->nama_lengkap) }}" required
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                            @error('nama_lengkap') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP / WA</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $peserta->no_hp) }}"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Unit Kerja / Instansi</label>
                                <input type="text" name="unit_kerja" value="{{ old('unit_kerja', $peserta->unit_kerja) }}"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Panggilan</label>
                                <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan', $peserta->nama_panggilan) }}"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIK (Nomor Induk Kependudukan)</label>
                                <input type="text" name="nik" value="{{ old('nik', $peserta->nik) }}" maxlength="16"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NBM (Nomor Baku Muhammadiyah)</label>
                                <input type="text" name="nbm" value="{{ old('nbm', $peserta->nbm) }}"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $peserta->tempat_lahir) }}"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $peserta->tanggal_lahir ? $peserta->tanggal_lahir->format('Y-m-d') : '') }}"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan di AUM</label>
                                <input type="text" name="jabatan_aum" value="{{ old('jabatan_aum', $peserta->jabatan_aum) }}"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ukuran Kaos</label>
                                <select name="ukuran_kaos" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['S', 'M', 'L', 'XL', 'XXL', 'XXXL'] as $size)
                                        <option value="{{ $size }}" {{ old('ukuran_kaos', $peserta->ukuran_kaos) == $size ? 'selected' : '' }}>{{ $size }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status Pernikahan</label>
                                <select name="status_pernikahan" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                                        <option value="{{ $status }}" {{ old('status_pernikahan', $peserta->status_pernikahan) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-xs text-gray-400 font-normal">(Tidak dapat diubah)</span></label>
                                <input type="email" value="{{ $peserta->email }}" disabled
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Bahasa yang Dikuasai <span class="text-red-500">*</span></label>
                                @php
                                    $currentBahasas = [];
                                    if ($peserta->bahasa_dikuasai) {
                                        $currentBahasas = is_array($peserta->bahasa_dikuasai) 
                                            ? $peserta->bahasa_dikuasai 
                                            : json_decode($peserta->bahasa_dikuasai, true) ?? explode(',', $peserta->bahasa_dikuasai);
                                    }
                                    // Bersihkan spasi atau karakter aneh
                                    $currentBahasas = array_map('trim', $currentBahasas);
                                @endphp
                                <div class="grid grid-cols-2 gap-2 p-3 bg-gray-50 border border-gray-200 rounded-xl">
                                    @foreach(['Inggris', 'Arab', 'Mandarin', 'Jepang'] as $lang)
                                        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer select-none">
                                            <input type="checkbox" name="bahasa_dikuasai[]" value="{{ $lang }}"
                                                @if(in_array($lang, $currentBahasas)) checked @endif
                                                class="rounded text-primary focus:ring-primary border-gray-300">
                                            {{ $lang }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('bahasa_dikuasai') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Hafalan Al-Quran <span class="text-red-500">*</span></label>
                                <select name="hafalan_quran_1" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                                    <option value="">-- Pilih Tingkat Hafalan --</option>
                                    @foreach([
                                        'Juz 30 (Juz Amma)',
                                        '1-2 Juz',
                                        '3-5 Juz',
                                        '6-10 Juz',
                                        '11-20 Juz',
                                        '21-30 Juz (Hafidz)'
                                    ] as $hafalan)
                                        <option value="{{ $hafalan }}" {{ old('hafalan_quran_1', $peserta->hafalan_quran_1) == $hafalan ? 'selected' : '' }}>{{ $hafalan }}</option>
                                    @endforeach
                                </select>
                                @error('hafalan_quran_1') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Rumah Lengkap</label>
                            <textarea name="alamat_rumah" rows="3"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50 resize-none">{{ old('alamat_rumah', $peserta->alamat_rumah) }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div x-data="{ changePas: false }">
                    <label class="flex items-center gap-2 cursor-pointer mb-3">
                        <input type="checkbox" x-model="changePas" class="text-primary focus:ring-primary rounded">
                        <span class="text-sm font-medium text-gray-700">Ubah Password Akun</span>
                    </label>
                    <div x-show="changePas" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100 mb-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Password Baru</label>
                            <input type="password" name="password" minlength="6" autocomplete="new-password"
                                class="w-full px-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" minlength="6" autocomplete="new-password"
                                class="w-full px-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary-600 transition-all shadow-md active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tab: Biodata Lengkap --}}
    <div x-show="activeTab === 'biodata'" x-transition>
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-8">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800">Data Biodata Lengkap</h3>
                <span class="text-xs bg-blue-50 text-blue-600 font-semibold px-3 py-1 rounded-full border border-blue-100">Dari formulir pendaftaran</span>
            </div>

            @php
            function biodataField($label, $value) {
                $val = $value ? e($value) : '<span class="text-gray-300 italic text-xs">Tidak diisi</span>';
                return "<div><p class='text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5'>{$label}</p><p class='text-sm font-semibold text-gray-800'>{$val}</p></div>";
            }
            @endphp

            {{-- Identitas Diri --}}
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 pb-2 border-b border-gray-100">Identitas Diri</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    {!! biodataField('Nama Lengkap', $peserta->nama_lengkap) !!}
                    {!! biodataField('NIK', $peserta->nik) !!}
                    {!! biodataField('NBM (Nomor Baku Muhammadiyah)', $peserta->nbm) !!}
                    {!! biodataField('Jenis Kelamin', $peserta->jenis_kelamin === 'L' ? 'Laki-laki' : ($peserta->jenis_kelamin === 'P' ? 'Perempuan' : null)) !!}
                    {!! biodataField('Tempat Lahir', $peserta->tempat_lahir) !!}
                    {!! biodataField('Tanggal Lahir', $peserta->tanggal_lahir ? \Carbon\Carbon::parse($peserta->tanggal_lahir)->translatedFormat('d F Y') : null) !!}
                    {!! biodataField('Umur', $peserta->umur ? $peserta->umur.' Tahun' : null) !!}
                    {!! biodataField('Status Pernikahan', $peserta->status_pernikahan) !!}
                </div>
            </div>

            {{-- Kontak & Pekerjaan --}}
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 pb-2 border-b border-gray-100">Kontak & Pekerjaan</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    {!! biodataField('Nomor HP / WA', $peserta->no_hp) !!}
                    {!! biodataField('Email', $peserta->email) !!}
                    {!! biodataField('Jabatan di AUM', $peserta->jabatan_aum) !!}
                    {!! biodataField('Unit Kerja / Instansi', $peserta->unit_kerja) !!}
                </div>
            </div>

            {{-- Domisili --}}
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 pb-2 border-b border-gray-100">Domisili</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    {!! biodataField('Kabupaten / Kota', $peserta->kabupaten) !!}
                    {!! biodataField('Kecamatan', $peserta->kecamatan) !!}
                    {!! biodataField('Desa / Kelurahan', $peserta->desa_kelurahan) !!}
                    {!! biodataField('Alamat Lengkap', $peserta->alamat_rumah) !!}
                </div>
            </div>

            {{-- Pendidikan --}}
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 pb-2 border-b border-gray-100">Riwayat Pendidikan</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    {!! biodataField('Pendidikan Terakhir', $peserta->pendidikan_terakhir) !!}
                    {!! biodataField('Bahasa Dikuasai', $peserta->bahasa_dikuasai) !!}
                    {!! biodataField('SD', $peserta->pendidikan_sd) !!}
                    {!! biodataField('SMP / MTs', $peserta->pendidikan_smp) !!}
                    {!! biodataField('SMA / SMK / MA', $peserta->pendidikan_sma) !!}
                    {!! biodataField('S1 (Kampus & Prodi)', $peserta->pendidikan_s1) !!}
                </div>
            </div>

            {{-- Keagamaan --}}
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 pb-2 border-b border-gray-100">Latar Keagamaan</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    {!! biodataField("Kemampuan Baca Al-Qur'an", $peserta->kemampuan_baca_quran) !!}
                    {!! biodataField("Hafalan Al-Qur'an", $peserta->hafalan_quran_1) !!}
                    {!! biodataField('Sholat Berjamaah di Masjid', $peserta->aktivitas_sholat_masjid) !!}
                    {!! biodataField('Kehadiran Kajian Agama', $peserta->aktivitas_kajian_agama) !!}
                    {!! biodataField('Jumlah Buku Agama', $peserta->jumlah_buku_agama ? $peserta->jumlah_buku_agama.' buku' : null) !!}
                </div>
            </div>

            {{-- Kemuhammadiyahan --}}
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 pb-2 border-b border-gray-100">Kemuhammadiyahan</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    {!! biodataField('Sumber Info Muhammadiyah', $peserta->sumber_info_muhammadiyah) !!}
                    {!! biodataField('Suara Muhammadiyah', $peserta->langganan_suara_muhammadiyah) !!}
                    {!! biodataField('Lembaga ZIS Diikuti', $peserta->lembaga_zis_diikuti) !!}
                    {!! biodataField('Keaktifan Muhammadiyah', $peserta->keaktifan_muhammadiyah) !!}
                    {!! biodataField('Keaktifan Ortom', $peserta->keaktifan_ortom) !!}
                    {!! biodataField('Organisasi Lain', $peserta->organisasi_lain) !!}
                    {!! biodataField('Tokoh Berpengaruh', $peserta->tokoh_berpengaruh) !!}
                    {!! biodataField('Alasan Memilih Tokoh', $peserta->alasan_pilih_tokoh) !!}
                </div>
            </div>

            {{-- Harapan --}}
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 pb-2 border-b border-gray-100">Harapan</h4>
                <div class="grid grid-cols-1 gap-y-4">
                    {!! biodataField('Harapan terhadap PCM', $peserta->harapan_pcm) !!}
                    {!! biodataField('Harapan Mengikuti Baitul Arqam', $peserta->harapan_mengikuti_ba) !!}
                </div>
            </div>

        </div>
    </div>

    {{-- Tab: Riwayat Event --}}
    <div x-show="activeTab === 'riwayat'" x-transition>
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Riwayat Partisipasi Event</h3>
            <div class="space-y-4">
                @forelse($history as $h)
                <div class="relative pl-7 border-l-2 @if($loop->first) border-primary @else border-gray-200 @endif pt-1 pb-5">
                    <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full border-4 border-white @if($loop->first) bg-primary @else bg-gray-300 @endif"></span>
                    <h4 class="text-sm font-semibold text-gray-800 leading-tight mb-1">{{ $h->event->nama_event }}</h4>
                    <p class="text-[10px] text-gray-500 font-medium mb-2 uppercase tracking-wide">
                        {{ \Carbon\Carbon::parse($h->event->tanggal_mulai)->translatedFormat('d M Y') }}
                    </p>
                    <div class="bg-gray-50 rounded-xl p-3 border border-gray-100 text-xs space-y-1.5">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Status Event</span>
                            <span class="font-semibold capitalize @if($h->event->status=='selesai') text-blue-600 @else text-green-600 @endif">{{ ucfirst($h->event->status) }}</span>
                        </div>
                        @php $nilai = \App\Models\PenilaianAkhir::where('event_id', $h->event_id)->where('peserta_id', $peserta->id)->first(); @endphp
                        @if($h->event->status == 'selesai' && $nilai)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Nilai Akhir</span>
                            <span class="font-bold text-primary">{{ number_format($nilai->nilai_akhir, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Peringkat</span>
                            <span class="font-semibold text-gray-700">#{{ $nilai->ranking }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Status Kelulusan</span>
                            <span class="font-semibold {{ str_contains($nilai->status_kelulusan ?? '', 'Tidak') ? 'text-red-500' : 'text-emerald-600' }}">
                                {{ $nilai->status_kelulusan ?? '-' }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="py-12 text-center">
                    <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p class="text-gray-400 text-sm font-medium">Belum ada riwayat partisipasi event.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Modal Crop Foto --}}
    <div id="cropModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeCropModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-6 py-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800" id="modal-title">Sesuaikan & Potong Foto</h3>
                    <button type="button" onclick="closeCropModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <div id="faceDetectStatus" class="mb-4 text-xs font-semibold px-3 py-2.5 rounded-xl flex items-center gap-2 bg-blue-50 text-blue-700 border border-blue-100">
                        <svg class="animate-spin h-4 w-4 text-blue-700" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="faceDetectText">Mendeteksi wajah otomatis...</span>
                    </div>

                    <div class="relative w-full max-h-[350px] bg-gray-50 rounded-2xl overflow-hidden flex items-center justify-center">
                        <img id="imageToCrop" src="" class="max-w-full max-h-[350px] block">
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3 rounded-b-3xl">
                    <button type="button" onclick="applyCrop()" class="px-5 py-2.5 bg-primary hover:bg-primary-600 text-white rounded-xl text-sm font-bold shadow-md transition-all active:scale-95">
                        Potong & Simpan
                    </button>
                    <button type="button" onclick="closeCropModal()" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-sm font-bold transition-all">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1.7.12/dist/face-api.js"></script>
<script>
    let cropperInstance = null;
    let faceapiLoaded = false;
    let faceapiModelsLoaded = false;
    
    async function initFaceApi() {
        if (faceapiLoaded) return;
        try {
            await faceapi.nets.tinyFaceDetector.loadFromUri('https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model');
            faceapiLoaded = true;
            faceapiModelsLoaded = true;
        } catch (e) {
            console.error("Gagal memuat model deteksi wajah:", e);
        }
    }

    async function handleProfilePhotoChange(event) {
        const file = event.target.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('Foto maksimal 2MB!');
            event.target.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            openCropModal(e.target.result);
        };
        reader.readAsDataURL(file);
    }

    function openCropModal(imageSrc) {
        const modal = document.getElementById('cropModal');
        const imageToCrop = document.getElementById('imageToCrop');
        const faceDetectStatus = document.getElementById('faceDetectStatus');
        const faceDetectText = document.getElementById('faceDetectText');

        imageToCrop.src = imageSrc;
        modal.classList.remove('hidden');

        faceDetectStatus.className = "mb-4 text-xs font-semibold px-3 py-2.5 rounded-xl flex items-center gap-2 bg-blue-50 text-blue-700 border border-blue-100";
        faceDetectText.innerText = "Mendeteksi wajah otomatis...";

        if (cropperInstance) {
            cropperInstance.destroy();
        }

        cropperInstance = new Cropper(imageToCrop, {
            aspectRatio: 3/4,
            viewMode: 1,
            autoCropArea: 0.85,
            responsive: true,
            background: false,
            ready() {
                setTimeout(async () => {
                    try {
                        await initFaceApi();
                        const detections = await faceapi.detectAllFaces(imageToCrop, new faceapi.TinyFaceDetectorOptions());

                        if (detections && detections.length > 0) {
                            const face = detections[0].box;
                            const imageData = cropperInstance.getImageData();
                            const scaleX = imageData.width / imageData.naturalWidth;
                            const scaleY = imageData.height / imageData.naturalHeight;

                            const faceWidth = face.width * scaleX;
                            const faceHeight = face.height * scaleY;
                            const faceX = face.x * scaleX + imageData.left;
                            const faceY = face.y * scaleY + imageData.top;

                            const targetWidth = Math.max(faceWidth, faceHeight * 0.75) * 2.4;
                            const targetHeight = targetWidth * (4/3);

                            const left = faceX + (faceWidth / 2) - (targetWidth / 2);
                            const top = faceY + (faceHeight / 2) - (targetHeight * 0.42);

                            cropperInstance.setCropBoxData({
                                left: left,
                                top: top,
                                width: targetWidth,
                                height: targetHeight
                            });

                            faceDetectStatus.className = "mb-4 text-xs font-semibold px-3 py-2.5 rounded-xl flex items-center gap-2 bg-emerald-50 text-emerald-700 border border-emerald-100";
                            faceDetectText.innerText = "Wajah berhasil dideteksi dan diposisikan di tengah!";
                        } else {
                            faceDetectStatus.className = "mb-4 text-xs font-semibold px-3 py-2.5 rounded-xl flex items-center gap-2 bg-amber-50 text-amber-700 border border-amber-100";
                            faceDetectText.innerText = "Wajah tidak terdeteksi. Silakan posisikan crop box secara manual.";
                        }
                    } catch (err) {
                        console.error("Deteksi wajah gagal:", err);
                        faceDetectStatus.className = "mb-4 text-xs font-semibold px-3 py-2.5 rounded-xl flex items-center gap-2 bg-red-50 text-red-700 border border-red-100";
                        faceDetectText.innerText = "Gagal memproses deteksi wajah otomatis.";
                    }
                }, 400);
            }
        });
    }

    function closeCropModal() {
        document.getElementById('cropModal').classList.add('hidden');
        document.getElementById('fotoInput').value = '';
        if (cropperInstance) {
            cropperInstance.destroy();
            cropperInstance = null;
        }
    }

    function applyCrop() {
        if (!cropperInstance) return;
        const canvas = cropperInstance.getCroppedCanvas({
            width: 300,
            height: 400
        });

        const base64Data = canvas.toDataURL('image/jpeg', 0.95);
        document.getElementById('croppedFotoInput').value = base64Data;
        
        const el = document.getElementById('profilePhotoSection');
        if (el && el.__x) {
            el.__x.$data.preview = base64Data;
        } else {
            const els = document.querySelectorAll('[x-data]');
            for (let item of els) {
                if (item.__x && item.__x.$data && item.__x.$data.preview !== undefined) {
                    item.__x.$data.preview = base64Data;
                }
            }
        }
        document.getElementById('cropModal').classList.add('hidden');
    }
</script>
@endpush

@endsection
