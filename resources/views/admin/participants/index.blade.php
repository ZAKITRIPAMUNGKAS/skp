@extends('layouts.main')

@section('title', 'Kelola Peserta — ARQAM')

@section('content')
    <x-page-header title="Kelola Peserta" subtitle="Daftar seluruh peserta yang terdaftar di sistem." />

    {{-- Filters Panel --}}
    <div class="mb-6 bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
        <form method="GET" action="{{ route('admin.participants.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nama, NIK, alasan..."
                    class="w-64 pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <select name="event_id" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-white text-gray-700">
                <option value="">Semua Event</option>
                @foreach($events as $event)
                    <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>{{ Str::limit($event->nama_event, 25) }}</option>
                @endforeach
            </select>

            <select name="kesediaan" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-white text-gray-700">
                <option value="">Semua Kesediaan</option>
                <option value="bersedia" {{ request('kesediaan') == 'bersedia' ? 'selected' : '' }}>Bersedia</option>
                <option value="tidak_bersedia" {{ request('kesediaan') == 'tidak_bersedia' ? 'selected' : '' }}>Tidak Hadir</option>
                <option value="belum_konfirmasi" {{ request('kesediaan') == 'belum_konfirmasi' ? 'selected' : '' }}>Belum Konfirmasi</option>
            </select>

            <select name="jenis_kelamin" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-white text-gray-700">
                <option value="">Semua Jenis Kelamin</option>
                <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>

            <x-button type="submit" variant="primary">Filter</x-button>
            @if(request()->anyFilled(['search', 'event_id', 'kesediaan', 'jenis_kelamin']))
                <a href="{{ route('admin.participants.index') }}" class="text-xs text-gray-500 hover:text-red-500 underline transition-colors">Reset</a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold text-gray-600">Peserta</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Unit Kerja</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Status Kesediaan (Event)</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-center">Terdaftar Pada</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($participants as $p)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                    @if($p->foto)
                                        <img src="{{ $p->foto_url }}" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <span class="text-xs font-bold text-primary">{{ strtoupper(substr($p->nama_lengkap, 0, 2)) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $p->nama_lengkap }}</p>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] px-1 bg-gray-100 text-gray-500 rounded font-mono">{{ $p->user->username }}</span>
                                        <span class="text-[10px] text-gray-400">{{ $p->email }}</span>
                                        @if($p->jenis_kelamin)
                                            <span class="text-[10px] px-1 bg-blue-50 text-blue-600 rounded">{{ $p->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $p->unit_kerja ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                @forelse($p->eventPeserta as $ep)
                                    <div class="flex flex-col gap-0.5">
                                        <span class="text-xs font-medium text-gray-700">{{ optional($ep->event)->nama_event ?? 'Event' }}</span>
                                        <div class="flex items-center flex-wrap gap-1.5">
                                            @if($ep->konfirmasi_kesediaan === 'bersedia')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-green-50 text-green-700 border border-green-200">
                                                    Bersedia
                                                </span>
                                            @elseif($ep->konfirmasi_kesediaan === 'tidak_bersedia')
                                                <button type="button"
                                                    @click="$dispatch('open-alasan-modal', { 
                                                        pesertaNama: '{{ addslashes($p->nama_lengkap) }}', 
                                                        eventNama: '{{ addslashes(optional($ep->event)->nama_event) }}', 
                                                        alasan: '{{ addslashes($ep->alasan_tidak_hadir) }}' 
                                                    })"
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-50 text-red-700 border border-red-200 hover:bg-red-100 hover:border-red-300 transition-colors shadow-sm cursor-pointer"
                                                    title="Klik untuk melihat alasan">
                                                    Tidak Hadir ⓘ
                                                </button>
                                                @if($ep->alasan_tidak_hadir)
                                                    <span class="text-[10px] text-red-600 italic max-w-[220px] truncate block mt-0.5" title="{{ $ep->alasan_tidak_hadir }}">
                                                        ({{ Str::limit($ep->alasan_tidak_hadir, 25) }})
                                                    </span>
                                                @endif
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-50 text-gray-600 border border-gray-200">
                                                    Belum Konfirmasi
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <span class="text-xs text-gray-400 italic">Belum terdaftar event</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center text-gray-500">{{ $p->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.participants.show', $p) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary/5 text-primary hover:bg-primary hover:text-white rounded-lg text-xs font-bold transition-all">
                                    Detail
                                </a>
                                <a href="{{ route('admin.participants.edit', $p) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-xs font-bold transition-all">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.participants.destroyParticipant', $p) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peserta ini beserta akun loginnya?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 hover:bg-red-600 hover:text-white rounded-lg text-xs font-bold transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                            Tidak ada data peserta ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($participants->hasPages())
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            {{ $participants->links() }}
        </div>
        @endif
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
                  class="relative w-full sm:max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">
                  
                  <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-red-50/50">
                      <h3 class="text-lg font-semibold text-red-800 font-heading">Alasan Tidak Hadir</h3>
                      <button @click="showModal = false"
                              class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors text-gray-400 hover:text-gray-600">
                          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                          </svg>
                      </button>
                  </div>
                  
                  <div class="px-6 py-5 space-y-4">
                      <div>
                          <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama Peserta</label>
                          <p class="text-sm font-semibold text-gray-800" x-text="pesertaNama"></p>
                      </div>
                      <div>
                          <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Event</label>
                          <p class="text-sm font-medium text-gray-700" x-text="eventNama"></p>
                      </div>
                      <div>
                          <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Alasan Detail</label>
                          <div class="mt-1 p-4 bg-gray-50 border border-gray-100 rounded-xl">
                              <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap" x-text="alasan || 'Tidak ada alasan detail ditulis.'"></p>
                          </div>
                      </div>
                  </div>
                  
                  <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-end">
                      <x-button type="button" variant="ghost" @click="showModal = false">Tutup</x-button>
                  </div>
             </div>
         </div>
    </div>
@endsection
