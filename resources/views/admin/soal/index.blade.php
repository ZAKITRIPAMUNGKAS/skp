@extends('layouts.main')

@section('title', 'Bank Soal — ARQAM')

@section('content')
<div class="p-6" x-data="{ 
    showCopyModal: false, 
    showBulkCopyModal: false, 
    targetSoalUrl: '', 
    targetSoalTeks: '', 
    tipe: 'pretest', 
    selectedEventId: '',
    selectedSoalIds: JSON.parse(localStorage.getItem('selected_soal_ids') || '[]'),
    eventsData: {{ $events->map(fn($e) => ['id' => $e->id, 'nama_event' => $e->nama_event, 'sessions' => $e->eventSesi->map(fn($s) => ['id' => $s->id, 'nama_sesi' => $s->nama_sesi])])->toJson() }},
    
    init() {
        this.$watch('selectedSoalIds', value => {
            localStorage.setItem('selected_soal_ids', JSON.stringify(value));
        });
    },
    get sessions() {
        if (!this.selectedEventId) return [];
        const ev = this.eventsData.find(e => e.id == this.selectedEventId);
        return ev ? ev.sessions : [];
    },
    toggleAll(e) {
        const currentPageIds = @json($soals->pluck('id')->toArray());
        if (e.target.checked) {
            this.selectedSoalIds = [...new Set([...this.selectedSoalIds, ...currentPageIds])];
        } else {
            this.selectedSoalIds = this.selectedSoalIds.filter(id => !currentPageIds.includes(id));
        }
    },
    isAllPageSelected() {
        const currentPageIds = @json($soals->pluck('id')->toArray());
        if (currentPageIds.length === 0) return false;
        return currentPageIds.every(id => this.selectedSoalIds.includes(id));
    }
}">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold font-heading text-gray-800">Bank Soal</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola seluruh database soal pretest dan posttest.</p>
        </div>
        
        <form method="GET" action="{{ route('admin.soal.index') }}" class="flex gap-2">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari teks soal atau event..."
                    class="w-64 pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <x-button type="submit" variant="primary">Filter</x-button>
        </form>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold text-gray-600 w-12 text-center">
                            <input type="checkbox" @change="toggleAll($event)" :checked="isAllPageSelected()" class="rounded border-gray-300 text-primary focus:ring-primary cursor-pointer">
                        </th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Teks Soal</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Event Asal</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-center">Tipe</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($soals as $s)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 text-center">
                            <input type="checkbox" :value="{{ $s->id }}" x-model="selectedSoalIds" class="rounded border-gray-300 text-primary focus:ring-primary cursor-pointer">
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gray-800 line-clamp-2 max-w-md">{{ $s->teks_soal }}</p>
                            <div class="flex gap-1 mt-1">
                                @foreach($s->pilihanJawaban as $p)
                                    <span class="text-[9px] px-1 rounded {{ $p->is_correct ? 'bg-green-100 text-green-600 font-bold' : 'bg-gray-100 text-gray-400' }}">
                                        {{ $p->huruf }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            <span class="text-xs font-medium">{{ $s->event->nama_event ?? 'Event Tidak Ditemukan' }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <x-badge :type="$s->tipe === 'pretest' ? 'persiapan' : 'berlangsung'">
                                {{ strtoupper($s->tipe) }}
                            </x-badge>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <button type="button" 
                                        @click="targetSoalUrl = '{{ route('admin.soal.copyToEvent', $s) }}'; targetSoalTeks = '{{ addslashes($s->teks_soal) }}'; tipe = '{{ $s->tipe }}'; selectedEventId = ''; showCopyModal = true"
                                        class="text-xs px-2.5 py-1 bg-blue-50 text-blue-600 rounded-lg border border-blue-200 hover:bg-blue-100 transition-colors font-medium">
                                    Salin ke Event Lain
                                </button>
                                @if($s->event_id)
                                    <a href="{{ route('admin.events.show', $s->event_id) }}" class="text-xs text-slate-500 hover:text-primary hover:underline">Edit</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                            Tidak ada data soal ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($soals->hasPages())
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            {{ $soals->links() }}
        </div>
        @endif
    </div>

    <!-- Floating Action Bar for Bulk Action -->
    <div x-show="selectedSoalIds.length > 0" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-10"
         class="fixed bottom-6 left-1/2 -translate-x-1/2 z-40 bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center gap-6 border border-slate-800"
         style="display: none;">
        <span class="text-sm font-medium">
            <span class="text-blue-400 font-bold" x-text="selectedSoalIds.length"></span> soal terpilih
        </span>
        <div class="h-4 w-px bg-slate-700"></div>
        <div class="flex gap-2">
            <button type="button" @click="selectedSoalIds = []" class="px-3 py-1.5 text-xs font-semibold text-slate-400 hover:text-white transition-colors">
                Batal
            </button>
            <button type="button" @click="selectedEventId = ''; showBulkCopyModal = true" class="px-4 py-1.5 text-xs font-bold bg-primary text-white rounded-xl hover:bg-primary/95 transition-colors shadow-sm">
                Salin ke Event
            </button>
        </div>
    </div>

    {{-- Copy Single Question Modal --}}
    <div x-show="showCopyModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
         @click.self="showCopyModal = false" style="display: none;">
        <div x-show="showCopyModal" x-transition class="bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
                <h3 class="text-lg font-bold text-gray-800 font-heading">Salin Soal</h3>
                <button type="button" @click="showCopyModal = false" class="p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-200 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form :action="targetSoalUrl" method="POST" class="p-6">
                @csrf
                <p class="text-xs text-gray-500 mb-4 bg-slate-50 p-3 rounded-xl border border-slate-100 italic" x-text="targetSoalTeks.length > 100 ? targetSoalTeks.substring(0, 100) + '...' : targetSoalTeks"></p>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Event Target</label>
                        <select name="target_event_id" x-model="selectedEventId" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50 cursor-pointer">
                            <option value="">-- Pilih Event --</option>
                            <template x-for="ev in eventsData" :key="ev.id">
                                <option :value="ev.id" x-text="ev.nama_event"></option>
                            </template>
                        </select>
                    </div>
                    <div x-show="sessions.length > 0">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Sesi/Materi Target (Opsional)</label>
                        <select name="event_sesi_id" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50 cursor-pointer">
                            <option value="">-- Pilih Sesi --</option>
                            <template x-for="ses in sessions" :key="ses.id">
                                <option :value="ses.id" x-text="ses.nama_sesi"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Tes di Target</label>
                        <select name="tipe" x-model="tipe" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50 cursor-pointer">
                            <option value="pretest">PRETEST</option>
                            <option value="posttest">POSTTEST</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" @click="showCopyModal = false" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-xl transition-colors font-medium">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-colors shadow-sm">
                        Salin Soal
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Copy Bulk Questions Modal --}}
    <div x-show="showBulkCopyModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
         @click.self="showBulkCopyModal = false" style="display: none;">
        <div x-show="showBulkCopyModal" x-transition class="bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
                <h3 class="text-lg font-bold text-gray-800 font-heading">Salin Banyak Soal</h3>
                <button type="button" @click="showBulkCopyModal = false" class="p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-200 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="{{ route('admin.soal.copyBulk') }}" method="POST" class="p-6" @submit="localStorage.removeItem('selected_soal_ids')">
                @csrf
                
                <!-- Hidden inputs for selected IDs -->
                <template x-for="id in selectedSoalIds" :key="id">
                    <input type="hidden" name="soal_ids[]" :value="id">
                </template>

                <p class="text-xs text-gray-600 mb-4 bg-blue-50 p-3 rounded-xl border border-blue-100 font-medium">
                    Akan menyalin <span class="text-blue-600 font-bold" x-text="selectedSoalIds.length"></span> soal yang Anda pilih ke event target.
                </p>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Event Target</label>
                        <select name="target_event_id" x-model="selectedEventId" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50 cursor-pointer">
                            <option value="">-- Pilih Event --</option>
                            <template x-for="ev in eventsData" :key="ev.id">
                                <option :value="ev.id" x-text="ev.nama_event"></option>
                            </template>
                        </select>
                    </div>
                    <div x-show="sessions.length > 0">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Sesi/Materi Target (Opsional)</label>
                        <select name="event_sesi_id" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50 cursor-pointer">
                            <option value="">-- Pilih Sesi --</option>
                            <template x-for="ses in sessions" :key="ses.id">
                                <option :value="ses.id" x-text="ses.nama_sesi"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Tes di Target</label>
                        <select name="tipe" x-model="tipe" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50 cursor-pointer">
                            <option value="pretest">PRETEST</option>
                            <option value="posttest">POSTTEST</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" @click="showBulkCopyModal = false" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-xl transition-colors font-medium">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-colors shadow-sm">
                        Salin Semua Soal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
