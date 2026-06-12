@extends('layouts.main')

@section('title', 'Detail Peserta — ARQAM')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.participants.index') }}" class="p-2 bg-white border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold font-heading text-gray-800">Detail Peserta</h1>
                <p class="text-sm text-gray-500">Informasi profil lengkap, data kompetensi, logistik, dan riwayat event.</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.participants.edit', $peserta) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-[13px] font-bold rounded-xl hover:bg-primary-dark transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Profil
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Profile Card & Basic Info --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
                <div class="w-28 h-28 rounded-full bg-primary/10 mx-auto mb-4 flex items-center justify-center border-4 border-white shadow-md overflow-hidden relative group">
                    @if($peserta->foto)
                        <img src="{{ $peserta->foto_url }}" referrerpolicy="no-referrer" class="w-full h-full object-cover">
                        <a href="{{ $peserta->foto }}" target="_blank" class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs transition-opacity font-semibold">
                            Buka Foto ↗
                        </a>
                    @else
                        <svg class="w-16 h-16 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>
                <h2 class="text-lg font-bold text-gray-800 leading-tight">{{ $peserta->nama_lengkap }}</h2>
                <p class="text-xs text-gray-400 font-mono mt-1 mb-4">{{ '@' . ($peserta->user->username ?? '-') }}</p>
                
                <div class="flex justify-center gap-2 flex-wrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-primary/10 text-primary border border-primary/20">
                        {{ $peserta->unit_kerja ?? 'Peserta' }}
                    </span>
                    @if($peserta->arqam_ke)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-accent/10 text-accent-600 border border-accent/30">
                            Arqam ke-{{ $peserta->arqam_ke }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Identitas Utama --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Identitas Diri
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">NIK</p>
                        <p class="text-sm text-gray-700 font-semibold">{{ $peserta->nik ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">NBM (Nomor Baku Muhammadiyah)</p>
                        <p class="text-sm text-gray-700">{{ $peserta->nbm ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Nama Panggilan</p>
                        <p class="text-sm text-gray-700">{{ $peserta->nama_panggilan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Jenis Kelamin</p>
                        <p class="text-sm text-gray-700">{{ $peserta->jenis_kelamin ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Umur / Tgl Lahir</p>
                        <p class="text-sm text-gray-700">
                            {{ $peserta->umur ? $peserta->umur . ' Tahun' : '-' }}
                            @if($peserta->tempat_lahir || $peserta->tanggal_lahir)
                                <span class="text-xs text-gray-400 block">
                                    ({{ $peserta->tempat_lahir ?? '-' }}, {{ $peserta->tanggal_lahir ? $peserta->tanggal_lahir->format('d M Y') : '-' }})
                                </span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Status Pernikahan / Jumlah Anak</p>
                        <p class="text-sm text-gray-700">
                            {{ $peserta->status_pernikahan ?? '-' }} 
                            @if($peserta->jumlah_anak !== null)
                                ({{ $peserta->jumlah_anak }} Anak)
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Kontak --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Informasi Kontak
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Email</p>
                        <a href="mailto:{{ $peserta->email }}" class="text-sm text-primary hover:underline block break-all">{{ $peserta->email ?? '-' }}</a>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">No. WhatsApp</p>
                        @if($peserta->no_hp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $peserta->no_hp) }}" target="_blank" class="text-sm text-primary hover:underline flex items-center gap-1">
                                {{ $peserta->no_hp }} ↗
                            </a>
                        @else
                            <p class="text-sm text-gray-700">-</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Unit Kerja / Jabatan</p>
                        <p class="text-sm text-gray-700 font-semibold">{{ $peserta->unit_kerja ?? '-' }}</p>
                        @if($peserta->jabatan_aum)
                            <p class="text-xs text-gray-500 mt-0.5">{{ $peserta->jabatan_aum }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Tabs or Organized Sections --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Riwayat Event --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" x-data="{ filterKesediaan: 'all' }">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-800">Riwayat Pendaftaran Event ({{ $peserta->eventPeserta->count() }})</h3>
                    <div class="flex items-center gap-2">
                        <label for="filter-kesediaan" class="text-xs text-gray-500">Filter:</label>
                        <select x-model="filterKesediaan" id="filter-kesediaan" class="text-xs px-2.5 py-1.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary">
                            <option value="all">Semua Kesediaan</option>
                            <option value="bersedia">Bersedia</option>
                            <option value="tidak_bersedia">Tidak Hadir</option>
                            <option value="belum_konfirmasi">Belum Konfirmasi</option>
                        </select>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-6 py-3 font-semibold text-gray-600">Event</th>
                                <th class="px-6 py-3 font-semibold text-gray-600 text-center">Kesediaan</th>
                                <th class="px-6 py-3 font-semibold text-gray-600 text-center">Skor</th>
                                <th class="px-6 py-3 font-semibold text-gray-600 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($peserta->eventPeserta as $ep)
                            <tr x-show="filterKesediaan === 'all' || filterKesediaan === '{{ $ep->konfirmasi_kesediaan ?? 'belum_konfirmasi' }}'" class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800">{{ optional($ep->event)->nama_event ?? 'Event tidak ditemukan/dihapus' }}</p>
                                    <p class="text-[10px] text-gray-400">
                                        {{ $ep->event ? \Carbon\Carbon::parse($ep->event->tanggal_mulai)->format('d M Y') : '-' }}
                                        @if(optional($ep->event)->lokasi)
                                            &bull; {{ $ep->event->lokasi }}
                                        @endif
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($ep->konfirmasi_kesediaan === 'bersedia')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                            Bersedia
                                        </span>
                                    @elseif($ep->konfirmasi_kesediaan === 'tidak_bersedia')
                                        <div class="inline-flex flex-col items-center">
                                            <button type="button" 
                                                @click="$dispatch('open-alasan-modal', { 
                                                    pesertaNama: '{{ addslashes($peserta->nama_lengkap) }}', 
                                                    eventNama: '{{ addslashes(optional($ep->event)->nama_event) }}{{ optional($ep->event)->lokasi ? ' (&bull; ' . addslashes($ep->event->lokasi) . ')' : '' }}', 
                                                    alasan: '{{ addslashes($ep->alasan_tidak_hadir) }}' 
                                                })"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200 hover:bg-red-100 hover:border-red-300 transition-colors shadow-sm cursor-pointer"
                                                title="Klik untuk melihat alasan">
                                                Tidak Hadir ⓘ
                                            </button>
                                            @if($ep->alasan_tidak_hadir)
                                                <span class="text-[10px] text-gray-500 mt-1 max-w-[150px] truncate block" title="{{ $ep->alasan_tidak_hadir }}">
                                                    "{{ $ep->alasan_tidak_hadir }}"
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-50 text-gray-600 border border-gray-200">
                                            Belum Konfirmasi
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($ep->skor)
                                        <span class="font-bold text-primary">{{ number_format($ep->skor->skor_akhir, 1) }}</span>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($ep->skor)
                                        @if(str_contains($ep->skor->status_kelulusan, 'Lulus'))
                                            <span class="px-2 py-1 bg-green-50 text-green-600 text-[10px] font-bold rounded-lg uppercase">LULUS</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-50 text-red-600 text-[10px] font-bold rounded-lg uppercase">TIDAK LULUS</span>
                                        @endif
                                    @else
                                        <span class="px-2 py-1 bg-yellow-50 text-yellow-600 text-[10px] font-bold rounded-lg uppercase">PROSES</span>
                                    @endif
                                </td>
                             </tr>
                             @empty
                             <tr>
                                 <td colspan="4" class="px-6 py-8 text-center text-gray-400">
                                     Belum pernah mendaftar event.
                                 </td>
                             </tr>
                             @endforelse
                         </tbody>
                     </table>
                 </div>
             </div>

             {{-- Alamat & Logistik --}}
             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                 <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                     <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                         <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                         Alamat Rumah (Asal)
                     </h3>
                     <div class="space-y-3 text-sm">
                         <div>
                             <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Alamat Lengkap</p>
                             <p class="text-gray-700 leading-relaxed font-medium">{{ $peserta->alamat_rumah ?? '-' }}</p>
                         </div>
                         <div class="grid grid-cols-2 gap-4 pt-2">
                             <div>
                                 <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Desa/Kelurahan</p>
                                 <p class="text-gray-700 font-medium">{{ $peserta->desa_kelurahan ?? '-' }}</p>
                             </div>
                             <div>
                                 <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Kecamatan</p>
                                 <p class="text-gray-700 font-medium">{{ $peserta->kecamatan ?? '-' }}</p>
                             </div>
                             <div>
                                 <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Kabupaten/Kota</p>
                                 <p class="text-gray-700 font-medium">{{ $peserta->kabupaten ?? '-' }}</p>
                             </div>
                             <div>
                                 <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Provinsi</p>
                                 <p class="text-gray-700 font-medium">{{ $peserta->provinsi ?? '-' }}</p>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                     <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                         <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                         Logistik & Keberangkatan
                     </h3>
                     <div class="space-y-4 text-sm">
                         <div>
                             <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Mengikuti Baitul Arqam ke-</p>
                             @if($peserta->arqam_ke)
                                 <span class="inline-flex items-center px-3 py-1 bg-primary/10 text-primary border border-primary/20 rounded-lg text-xs font-bold mt-1">
                                     Ke-{{ $peserta->arqam_ke }}
                                 </span>
                             @else
                                 <p class="text-gray-400 text-sm mt-1">-</p>
                             @endif
                         </div>
                         <div>
                             <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Ukuran Kaos</p>
                             <span class="inline-flex items-center px-3 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-lg text-xs font-bold mt-1">
                                 {{ $peserta->ukuran_kaos ?? '-' }}
                             </span>
                         </div>
                         <div>
                             <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Rencana Keberangkatan</p>
                             <p class="text-gray-700 font-medium leading-normal mt-0.5">{{ $peserta->rencana_keberangkatan ?? '-' }}</p>
                         </div>
                     </div>
                 </div>
             </div>

             {{-- Kondisi Fisik & Kebutuhan Khusus --}}
             <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                 <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                     <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                     Kondisi Fisik & Kebutuhan Khusus
                 </h3>
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm mb-6">
                     <div>
                         <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Aktivitas Duduk</p>
                         <p class="text-gray-700 font-medium mt-1">{{ $peserta->aktivitas_duduk ?? '-' }}</p>
                     </div>
                     <div>
                         <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Aktivitas Tangga</p>
                         <p class="text-gray-700 font-medium mt-1">{{ $peserta->aktivitas_tangga ?? '-' }}</p>
                     </div>
                     <div>
                         <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Aktivitas Sholat</p>
                         <p class="text-gray-700 font-medium mt-1">{{ $peserta->aktivitas_sholat ?? '-' }}</p>
                     </div>
                 </div>
                 <hr class="border-gray-100 my-4" />
                 <div class="space-y-4 text-sm">
                     <div>
                         <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Catatan Makanan</p>
                         <p class="text-gray-700 mt-0.5 leading-relaxed">{{ $peserta->catatan_makanan ?? '-' }}</p>
                     </div>
                     <div>
                         <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Catatan Kesehatan / Alergi / Penyakit</p>
                         <p class="text-gray-700 mt-0.5 leading-relaxed">{{ $peserta->catatan_kesehatan ?? '-' }}</p>
                     </div>
                     <div>
                         <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Catatan Lain untuk Panitia</p>
                         <p class="text-gray-700 mt-0.5 leading-relaxed">{{ $peserta->catatan_panitia ?? '-' }}</p>
                     </div>
                 </div>
             </div>

             {{-- Kompetensi & Keaktifan --}}
             <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                 <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                     <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                     Kompetensi & Keaktifan Persyarikatan
                 </h3>
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm mb-6">
                     <div>
                         <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Kemampuan Membaca Al-Qur'an</p>
                         <p class="text-gray-700 font-semibold mt-1">{{ $peserta->kemampuan_baca_quran ?? '-' }}</p>
                     </div>
                     <div>
                         <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Kompetensi Keberagamaan</p>
                         <p class="text-gray-700 font-semibold mt-1">{{ $peserta->kompetensi_keberagamaan ?? '-' }}</p>
                     </div>
                     <div>
                         <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Kompetensi Akademis</p>
                         <p class="text-gray-700 font-semibold mt-1">{{ $peserta->kompetensi_akademis ?? '-' }}</p>
                     </div>
                     <div>
                         <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Kompetensi Sosial</p>
                         <p class="text-gray-700 font-semibold mt-1">{{ $peserta->kompetensi_sosial ?? '-' }}</p>
                     </div>
                     <div class="md:col-span-2">
                         <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Kompetensi Keorganisasian & Kepemimpinan</p>
                         <p class="text-gray-700 font-semibold mt-1">{{ $peserta->kompetensi_keorganisasian ?? '-' }}</p>
                     </div>
                 </div>
                 <hr class="border-gray-100 my-4" />
                 <div class="space-y-4 text-sm">
                     <div>
                         <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Keaktifan di Organisasi Otonom (Ortom)</p>
                         <p class="text-gray-700 mt-1 leading-relaxed">{{ $peserta->keaktifan_ortom ?? '-' }}</p>
                     </div>
                     <div>
                         <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Keaktifan di Muhammadiyah/Aisyiyah</p>
                         <p class="text-gray-700 mt-1 leading-relaxed">{{ $peserta->keaktifan_muhammadiyah ?? '-' }}</p>
                     </div>
                 </div>
             </div>

             {{-- Dokumen & Lampiran --}}
             <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                 <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                     <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                     Unggahan Dokumen & Lampiran
                 </h3>
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                     <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 flex flex-col justify-between gap-3">
                         <div>
                             <p class="text-xs font-bold text-gray-700">Surat Pernyataan Komitmen</p>
                             <p class="text-[11px] text-gray-400 mt-1">Unduh atau lihat berkas komitmen peserta.</p>
                         </div>
                         @if($peserta->surat_komitmen)
                             <a href="{{ $peserta->surat_komitmen }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-3 py-2 bg-primary text-white text-[12px] font-bold rounded-lg hover:bg-primary-dark transition-all">
                                 Buka Dokumen Komitmen ↗
                             </a>
                         @else
                             <button disabled class="inline-flex items-center justify-center gap-2 px-3 py-2 bg-gray-200 text-gray-400 text-[12px] font-bold rounded-lg cursor-not-allowed">
                                 Belum Diunggah
                             </button>
                         @endif
                     </div>

                     <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 flex flex-col justify-between gap-3">
                         <div>
                             <p class="text-xs font-bold text-gray-700">Surat Pernyataan Tidak Bersedia</p>
                             <p class="text-[11px] text-gray-400 mt-1">Surat keterangan berhalangan hadir.</p>
                         </div>
                         @if($peserta->surat_tidak_bersedia)
                             <a href="{{ $peserta->surat_tidak_bersedia }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-3 py-2 bg-red-600 text-white text-[12px] font-bold rounded-lg hover:bg-red-700 transition-all">
                                 Buka Surat Berhalangan ↗
                             </a>
                         @else
                             <button disabled class="inline-flex items-center justify-center gap-2 px-3 py-2 bg-gray-200 text-gray-400 text-[12px] font-bold rounded-lg cursor-not-allowed">
                                 Belum Diunggah
                             </button>
                         @endif
                     </div>
                 </div>
             </div>
         </div>
     </div>

     {{-- Dynamic Modal for Absence Reason --}}
     <div x-data="{ 
             showModal: false, 
             pesertaNama: '', 
             eventNama: '', 
             alasan: '' 
          }"
          x-on:open-alasan-modal.window="
             pesertaNama = $event.detail.pesertaNama;
             eventNama = $event.detail.eventNama;
             alasan = $event.detail.alasan;
             showModal = true;
          "
          x-show="showModal"
          x-cloak
          class="fixed inset-0 z-[80] overflow-y-auto"
          style="display: none;">
          
          <div x-show="showModal"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="opacity-0"
               x-transition:enter-end="opacity-100"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="opacity-100"
               x-transition:leave-end="opacity-0"
               @click="showModal = false"
               class="fixed inset-0 bg-black/40 backdrop-blur-sm">
          </div>

          <div class="flex min-h-full items-center justify-center p-4">
              <div x-show="showModal"
                   x-transition:enter="transition ease-out duration-300"
                   x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                   x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                   x-transition:leave="transition ease-in duration-200"
                   x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                   x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                   @click.outside="showModal = false"
                   class="relative w-full sm:max-w-lg bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-gray-100">
                   
                   {{-- Header --}}
                   <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between">
                       <div class="flex items-center gap-3">
                           <div class="w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center">
                               <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                               </svg>
                           </div>
                           <div class="text-left">
                               <h3 class="text-base font-bold text-gray-800 font-heading">Alasan Tidak Hadir</h3>
                               <p class="text-[11px] text-gray-400">Keterangan berhalangan menghadiri event</p>
                           </div>
                       </div>
                       <button @click="showModal = false"
                               class="w-8 h-8 rounded-xl hover:bg-gray-50 flex items-center justify-center transition-colors text-gray-400 hover:text-gray-600 cursor-pointer">
                           <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                           </svg>
                       </button>
                   </div>
                   
                   {{-- Body Content --}}
                   <div class="p-6 space-y-4.5 text-left">
                       <div class="grid grid-cols-2 gap-4">
                           <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-4">
                               <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Peserta</span>
                               <p class="text-xs font-bold text-gray-800" x-text="pesertaNama"></p>
                           </div>
                           <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-4">
                               <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Event</span>
                               <p class="text-xs font-bold text-gray-700" x-text="eventNama"></p>
                           </div>
                       </div>
                       
                       <div>
                           <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Keterangan / Alasan Detail</span>
                           <div class="bg-red-50/20 border-l-4 border-red-500 rounded-r-2xl p-4">
                               <p class="text-xs text-gray-600 leading-relaxed whitespace-pre-wrap font-medium" x-text="alasan || 'Tidak ada alasan detail ditulis.'"></p>
                           </div>
                       </div>
                   </div>
                   
                   {{-- Footer --}}
                   <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-50 flex items-center justify-end">
                       <button type="button" @click="showModal = false"
                               class="px-5 py-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 transition-all rounded-xl text-xs font-bold shadow-sm cursor-pointer active:scale-95">
                           Tutup
                       </button>
                   </div>
              </div>
          </div>
     </div>
</div>
@endsection

