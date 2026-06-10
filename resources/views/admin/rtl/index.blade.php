@extends('layouts.main')

@section('title', 'Kelola RTL Peserta — ARQAM')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Rencana Tindak Lanjut (RTL)</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau dan tinjau seluruh usulan Rencana Tindak Lanjut (RTL) yang diserahkan oleh peserta pelatihan.</p>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.rtl.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Search --}}
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nama Peserta</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peserta..."
                       class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
            </div>

            {{-- Event --}}
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Pilih Baitul Arqam</label>
                <select name="event_id"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                    <option value="">Semua Event</option>
                    @foreach($events as $e)
                        <option value="{{ $e->id }}" {{ request('event_id') == $e->id ? 'selected' : '' }}>{{ $e->nama_event }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Bidang / Kategori</label>
                <select name="kategori"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                    <option value="">Semua Kategori</option>
                    <option value="Ibadah & Keagamaan" {{ request('kategori') == 'Ibadah & Keagamaan' ? 'selected' : '' }}>Ibadah & Keagamaan</option>
                    <option value="Organisasi & Kepemimpinan" {{ request('kategori') == 'Organisasi & Kepemimpinan' ? 'selected' : '' }}>Organisasi & Kepemimpinan</option>
                    <option value="Sosial Kemasyarakatan" {{ request('kategori') == 'Sosial Kemasyarakatan' ? 'selected' : '' }}>Sosial Kemasyarakatan</option>
                    <option value="Amal Usaha Muhammadiyah (AUM)" {{ request('kategori') == 'Amal Usaha Muhammadiyah (AUM)' ? 'selected' : '' }}>Amal Usaha Muhammadiyah (AUM)</option>
                    <option value="Kaderisasi & Dakwah" {{ request('kategori') == 'Kaderisasi & Dakwah' ? 'selected' : '' }}>Kaderisasi & Dakwah</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-2.5 bg-primary hover:bg-primary-600 text-white rounded-xl text-sm font-bold shadow-md transition-all active:scale-95">
                    Filter
                </button>
                <a href="{{ route('admin.rtl.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-bold transition-all text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                        <th class="px-6 py-4">Peserta</th>
                        <th class="px-6 py-4">Baitul Arqam</th>
                        <th class="px-6 py-4">Rencana Kegiatan</th>
                        <th class="px-6 py-4">Bidang / Kategori</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @forelse($rtls as $rtl)
                        <tr class="hover:bg-gray-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800 leading-snug">{{ $rtl->peserta->nama_lengkap }}</div>
                                <div class="text-[10px] text-gray-400 font-medium mt-0.5">{{ $rtl->peserta->unit_kerja }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 bg-blue-50 text-blue-700 text-xs font-semibold rounded-lg">
                                    {{ $rtl->event->nama_event }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-700 max-w-xs truncate" title="{{ $rtl->judul_kegiatan }}">
                                {{ $rtl->judul_kegiatan }}
                            </td>
                            <td class="px-6 py-4 text-xs font-bold text-primary">
                                {{ $rtl->kategori_rtl }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-500">
                                {{ $rtl->waktu_pelaksanaan }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.rtl.show', $rtl) }}"
                                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-primary hover:text-white text-gray-700 text-xs font-bold rounded-xl transition-all shadow-sm active:scale-95">
                                    Tinjau Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                Tidak ada usulan Rencana Tindak Lanjut (RTL) yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($rtls->hasPages())
            <div class="px-6 py-4 border-t border-gray-50">
                {{ $rtls->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
