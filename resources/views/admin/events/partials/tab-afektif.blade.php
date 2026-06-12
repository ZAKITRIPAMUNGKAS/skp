{{-- Afektif Tab Content --}}
@php
    $subAspeks = \App\Models\AfektifSubAspek::where('event_id', $event->id)
        ->with(['butir' => fn($q) => $q->orderBy('urutan')])
        ->orderBy('urutan')
        ->get();

    $pesertas = \App\Models\EventPeserta::with('peserta.user')
        ->where('event_id', $event->id)
        ->get();
        
    $penilaianAkhirs = \App\Models\PenilaianAkhir::where('event_id', $event->id)
        ->pluck('nilai_afektif', 'peserta_id');

    $afektifParticipants = $pesertas->map(function($ep) use ($penilaianAkhirs) {
        $score = $penilaianAkhirs->get($ep->peserta_id);
        return [
            'id' => $ep->peserta_id,
            'nama' => $ep->peserta->nama_lengkap ?? ($ep->peserta->user->name ?? 'Unknown'),
            'score' => $score !== null ? round($score, 1) : null,
            'done' => $score !== null
        ];
    })->values()->toArray();
@endphp

<div x-data="afektifManager()" x-init="init()">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-sm font-semibold text-gray-800">Sub-Aspek Afektif</h3>
            <p class="text-xs text-gray-500 mt-0.5" x-text="subAspeks.length + ' sub-aspek'"></p>
        </div>
        <button @click="showAddSubAspek = true"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-white text-sm rounded-xl hover:bg-primary/90 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Sub-Aspek
        </button>
    </div>

    {{-- Sub-Aspect Cards --}}
    <div class="space-y-4">
        <template x-for="(sa, sIdx) in subAspeks" :key="sa.id">
            <div class="bg-white rounded-xl border border-gray-100 hover:shadow-sm transition-all overflow-hidden">
                {{-- Sub-Aspect Header --}}
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50 cursor-pointer" @click="sa._expanded = !sa._expanded">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-xs font-bold text-primary" x-text="sIdx + 1"></span>
                        <div>
                            <p class="text-sm font-semibold text-gray-800" x-text="sa.nama_sub_aspek"></p>
                            <p class="text-xs text-gray-400" x-text="(sa.butir?.length || 0) + ' pernyataan'"></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        {{-- Status Badge --}}
                        <template x-if="sa.status === 'aktif'">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-50 text-green-600 text-[10px] font-semibold rounded-full border border-green-100">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>AKTIF
                            </span>
                        </template>
                        <template x-if="sa.status === 'tutup'">
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-500 text-[10px] font-semibold rounded-full">TUTUP</span>
                        </template>
                        <template x-if="sa.status === 'belum_buka'">
                            <span class="px-2.5 py-1 bg-yellow-50 text-yellow-600 text-[10px] font-semibold rounded-full border border-yellow-100">BELUM BUKA</span>
                        </template>

                        {{-- Toggle Button --}}
                        <template x-if="sa.status !== 'aktif'">
                            <button @click.stop="toggleStatus(sa, 'aktif')" class="px-3 py-1 text-[10px] font-semibold bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">Buka</button>
                        </template>
                        <template x-if="sa.status === 'aktif'">
                            <button @click.stop="toggleStatus(sa, 'tutup')" class="px-3 py-1 text-[10px] font-semibold bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">Tutup</button>
                        </template>

                        {{-- Actions --}}
                        <button @click.stop="editSubAspek(sa)" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-primary transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <button @click.stop="deleteSubAspek(sa)" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>

                        <svg class="w-4 h-4 text-gray-400 transition-transform" :class="sa._expanded ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                {{-- Butir List (Expandable) --}}
                <div x-show="sa._expanded" x-transition.duration.200ms class="px-5 py-4 bg-gray-50/50 space-y-2">
                    <template x-for="(b, bIdx) in sa.butir" :key="b.id">
                        <div class="flex items-start gap-3 bg-white rounded-lg border border-gray-100 p-3 group"
                             draggable="true" @dragstart="$event.dataTransfer.setData('text/plain', b.id)"
                             @dragover.prevent @drop.prevent="handleButirDrop($event, sa, b)">
                            <div class="flex items-center gap-2 pt-0.5">
                                <span class="cursor-grab text-gray-300 hover:text-gray-400"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg></span>
                                <span class="w-5 h-5 rounded text-[10px] font-bold flex items-center justify-center bg-primary/10 text-primary" x-text="bIdx + 1"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-700 leading-relaxed" x-text="b.teks_pernyataan.length > 120 ? b.teks_pernyataan.substring(0,120)+'...' : b.teks_pernyataan"></p>
                                <div class="flex items-center gap-2 mt-1.5">
                                    <span :class="b.is_positif ? 'bg-green-50 text-green-600 border-green-100' : 'bg-red-50 text-red-600 border-red-100'"
                                        class="text-[9px] px-2 py-0.5 rounded border font-semibold" x-text="b.is_positif ? 'POSITIF • SS=4 S=3 TS=2 STS=1' : 'NEGATIF • SS=1 S=2 TS=3 STS=4'"></span>
                                </div>
                            </div>
                            <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button @click="editButir(sa, b)" class="p-1 rounded hover:bg-primary/10 text-gray-400 hover:text-primary">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button @click="deleteButir(sa, b)" class="p-1 rounded hover:bg-red-50 text-gray-400 hover:text-red-500">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </template>

                    <button @click="showButirForm = true; activeSubAspek = sa; butirForm = {teks_pernyataan:'', is_positif:true}; editingButir = null"
                        class="w-full py-2 border-2 border-dashed border-gray-200 rounded-lg text-xs text-gray-400 hover:text-primary hover:border-primary/30 transition-colors">
                        + Tambah Pernyataan
                    </button>
                </div>
            </div>
        </template>
    </div>

    <template x-if="subAspeks.length === 0">
        <div class="py-8">
            <x-empty-state title="Belum ada sub-aspek" description="Tambahkan sub-aspek afektif untuk evaluasi." icon="document" />
        </div>
    </template>

    {{-- Participant Progress --}}
    <div class="mt-8 bg-white rounded-xl border border-gray-100 p-6 shadow-sm" x-show="participants.length > 0">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Progres Nilai Afektif Peserta</h3>
            <div class="relative">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" x-model="searchQuery" placeholder="Cari nama peserta..." 
                    class="pl-9 pr-4 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none w-64">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-gray-400 font-semibold bg-gray-50/50">
                        <th class="py-3 px-4 rounded-tl-xl">Nama Peserta</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center rounded-tr-xl">Nilai Afektif</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <template x-for="p in filteredParticipants" :key="p.id">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 font-medium text-gray-800" x-text="p.nama"></td>
                            <td class="py-3 px-4 text-center">
                                <span x-show="p.done" class="inline-flex px-2.5 py-1 bg-green-50 text-green-600 rounded-lg text-xs font-bold">Selesai</span>
                                <span x-show="!p.done" class="inline-flex px-2.5 py-1 bg-gray-100 text-gray-500 rounded-lg text-xs font-bold">Belum</span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="font-bold" :class="p.score >= 70 ? 'text-green-600' : 'text-red-500'" x-text="p.done ? p.score : '-'"></span>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="filteredParticipants.length === 0">
                        <td colspan="3" class="text-center py-8 text-gray-400">Belum ada data peserta yang cocok.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add Sub-Aspek Modal --}}
    <div x-show="showAddSubAspek || showEditSubAspek" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" @click.self="showAddSubAspek = false; showEditSubAspek = false">
        <div x-transition class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-semibold font-heading text-gray-800 mb-4" x-text="showEditSubAspek ? 'Edit Sub-Aspek' : 'Tambah Sub-Aspek'"></h3>
            <input type="text" x-model="subAspekName" placeholder="Nama Sub-Aspek"
                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm mb-4">
            <div class="flex gap-3">
                <button @click="showAddSubAspek = false; showEditSubAspek = false" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm rounded-xl hover:bg-gray-200 transition-colors">Batal</button>
                <button @click="saveSubAspek()" class="flex-1 px-4 py-2.5 bg-primary text-white text-sm rounded-xl hover:bg-primary/90 transition-colors font-medium">Simpan</button>
            </div>
        </div>
    </div>

    {{-- Add/Edit Butir Modal --}}
    <div x-show="showButirForm" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" @click.self="showButirForm = false">
        <div x-transition class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 w-full max-w-lg mx-4">
            <h3 class="text-lg font-semibold font-heading text-gray-800 mb-4" x-text="editingButir ? 'Edit Pernyataan' : 'Tambah Pernyataan'"></h3>

            <textarea x-model="butirForm.teks_pernyataan" rows="4" placeholder="Teks pernyataan..."
                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm resize-none mb-3"></textarea>

            <div class="flex items-center gap-4 mb-4">
                <label class="text-sm text-gray-600">Tipe:</label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" :value="true" x-model="butirForm.is_positif" class="text-green-500 focus:ring-green-500">
                    <span class="text-sm font-medium text-green-600">POSITIF</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" :value="false" x-model="butirForm.is_positif" class="text-red-500 focus:ring-red-500">
                    <span class="text-sm font-medium text-red-600">NEGATIF</span>
                </label>
            </div>

            <div class="p-3 rounded-lg text-xs font-mono mb-4"
                :class="butirForm.is_positif ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-red-50 text-red-700 border border-red-100'"
                x-text="butirForm.is_positif ? 'SS=4 | S=3 | TS=2 | STS=1' : 'SS=1 | S=2 | TS=3 | STS=4'"></div>

            <div class="flex gap-3">
                <button @click="showButirForm = false" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm rounded-xl">Batal</button>
                <button @click="saveButir()" class="flex-1 px-4 py-2.5 bg-primary text-white text-sm rounded-xl font-medium">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function afektifManager() {
    return {
        subAspeks: @json($subAspeks->map(fn($sa) => array_merge($sa->toArray(), ['_expanded' => false]))),
        participants: @json($afektifParticipants),
        searchQuery: '',
        showAddSubAspek: false, showEditSubAspek: false, showButirForm: false,
        subAspekName: '', editingSubAspek: null, activeSubAspek: null,
        butirForm: { teks_pernyataan: '', is_positif: true }, editingButir: null,

        get filteredParticipants() {
            if (this.searchQuery.trim() === '') return this.participants;
            const query = this.searchQuery.toLowerCase();
            return this.participants.filter(p => p.nama.toLowerCase().includes(query));
        },

        init() {},

        async saveSubAspek() {
            if (!this.subAspekName.trim()) return;
            if (this.editingSubAspek) {
                const url = '{{ route("admin.afektif.updateSubAspek", [$event, "__SA__"]) }}'.replace('__SA__', this.editingSubAspek.id);
                const res = await fetch(url, { method: 'PUT', headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: JSON.stringify({nama_sub_aspek: this.subAspekName}) });
                const data = await res.json();
                if (data.status === 'success') {
                    const idx = this.subAspeks.findIndex(s => s.id === this.editingSubAspek.id);
                    if (idx >= 0) this.subAspeks[idx].nama_sub_aspek = this.subAspekName;
                }
                this.showEditSubAspek = false;
            } else {
                const res = await fetch('{{ route("admin.afektif.storeSubAspek", $event) }}', { method: 'POST', headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: JSON.stringify({nama_sub_aspek: this.subAspekName}) });
                const data = await res.json();
                if (data.status === 'success') { data.sub_aspek._expanded = false; this.subAspeks.push(data.sub_aspek); }
                this.showAddSubAspek = false;
            }
            this.subAspekName = ''; this.editingSubAspek = null;
        },

        editSubAspek(sa) { this.editingSubAspek = sa; this.subAspekName = sa.nama_sub_aspek; this.showEditSubAspek = true; },

        async deleteSubAspek(sa) {
            if (!confirm('Hapus sub-aspek "' + sa.nama_sub_aspek + '"?')) return;
            await fetch('{{ route("admin.afektif.destroySubAspek", [$event, "__SA__"]) }}'.replace('__SA__', sa.id), { method: 'DELETE', headers: {'X-CSRF-TOKEN':'{{ csrf_token() }}'} });
            this.subAspeks = this.subAspeks.filter(s => s.id !== sa.id);
        },

        async toggleStatus(sa, newStatus) {
            await fetch('{{ route("admin.afektif.toggleStatus", [$event, "__SA__"]) }}'.replace('__SA__', sa.id), { method: 'POST', headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: JSON.stringify({status: newStatus}) });
            sa.status = newStatus;
        },

        editButir(sa, b) { this.activeSubAspek = sa; this.editingButir = b; this.butirForm = { teks_pernyataan: b.teks_pernyataan, is_positif: b.is_positif }; this.showButirForm = true; },

        async saveButir() {
            if (!this.butirForm.teks_pernyataan.trim()) return;
            if (this.editingButir) {
                const res = await fetch('{{ route("admin.afektif.updateButir", [$event, "__B__"]) }}'.replace('__B__', this.editingButir.id), { method: 'PUT', headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: JSON.stringify(this.butirForm) });
                const data = await res.json();
                if (data.status === 'success') { Object.assign(this.editingButir, data.butir); }
            } else {
                const res = await fetch('{{ route("admin.afektif.storeButir", [$event, "__SA__"]) }}'.replace('__SA__', this.activeSubAspek.id), { method: 'POST', headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: JSON.stringify(this.butirForm) });
                const data = await res.json();
                if (data.status === 'success') { this.activeSubAspek.butir.push(data.butir); }
            }
            this.showButirForm = false;
        },

        async deleteButir(sa, b) {
            if (!confirm('Hapus pernyataan ini?')) return;
            await fetch('{{ route("admin.afektif.destroyButir", [$event, "__B__"]) }}'.replace('__B__', b.id), { method: 'DELETE', headers: {'X-CSRF-TOKEN':'{{ csrf_token() }}'} });
            sa.butir = sa.butir.filter(x => x.id !== b.id);
        },

        async handleButirDrop(event, sa, targetButir) {
            const draggedId = parseInt(event.dataTransfer.getData('text/plain'));
            if (draggedId === targetButir.id) return;
            const fromIdx = sa.butir.findIndex(b => b.id === draggedId);
            const toIdx = sa.butir.findIndex(b => b.id === targetButir.id);
            if (fromIdx < 0 || toIdx < 0) return;
            const [item] = sa.butir.splice(fromIdx, 1);
            sa.butir.splice(toIdx, 0, item);
            const order = sa.butir.map((b, i) => ({ id: b.id, urutan: i + 1 }));
            await fetch('{{ route("admin.afektif.reorderButir", [$event, "__SA__"]) }}'.replace('__SA__', sa.id), { method: 'POST', headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: JSON.stringify({order}) });
        },
    };
}
</script>
@endpush
