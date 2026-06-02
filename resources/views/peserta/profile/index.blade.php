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
                <img src="{{ asset('storage/' . $peserta->foto) }}" class="w-full h-full object-cover" alt="Foto">
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
                    <div class="shrink-0 flex flex-col items-center"
                         x-data="{ preview: '{{ $peserta->foto ? asset('storage/'.$peserta->foto) : '' }}' }">
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
                            <input type="file" name="foto" class="hidden" accept="image/*"
                                @change="const f=$event.target.files[0]; if(f && f.size<=2097152){preview=URL.createObjectURL(f)} else if(f){alert('Foto maksimal 2MB!'); $event.target.value=''}">
                        </label>
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
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-xs text-gray-400 font-normal">(Tidak dapat diubah)</span></label>
                            <input type="email" value="{{ $peserta->email }}" disabled
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed">
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

</div>
@endsection
