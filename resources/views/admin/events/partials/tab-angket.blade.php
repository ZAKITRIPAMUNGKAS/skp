{{-- Angket Tab Content --}}
@php
    $angketItems = \App\Models\AngketItem::where('event_id', $event->id)->orderBy('kategori')->orderBy('urutan')->get()->groupBy('kategori');
    $categoryLabels = [
        'A' => 'Materi & Narasumber',
        'B' => 'Fasilitator',
        'C' => 'Panitia',
        'D' => 'Lokasi Baitul Arqam',
        'E' => 'Konsumsi',
        'F' => 'Kepuasan Pengguna',
    ];
@endphp

<div x-data="angketManager()" x-init="init()">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-sm font-semibold text-gray-800">Angket Penyelenggaraan</h3>
            <p class="text-xs text-gray-500 mt-0.5">6 kategori pertanyaan</p>
        </div>
        <button @click="showForm = true; editingItem = null; form = {kategori:'A', teks_item:'', tipe:'skala'}"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-white text-sm rounded-xl hover:bg-primary/90 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Item
        </button>
    </div>

    {{-- Category Groups --}}
    
    @foreach(['A','B','C','D','E','F'] as $kat)
        <div class="mb-4" x-show="itemsByKategori('{{ $kat }}').length > 0">
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-0.5 bg-primary/10 text-primary text-xs font-bold rounded">{{ $kat }}</span>
                <span class="text-xs font-semibold text-gray-700">{{ $categoryLabels[$kat] ?? '' }}</span>
                <span class="text-xs text-gray-400" x-text="'(' + itemsByKategori('{{ $kat }}').length + ' item)'"></span>
            </div>
            <div class="space-y-2">
                <template x-for="(item, idx) in itemsByKategori('{{ $kat }}')" :key="item.id">
                    <div class="flex items-center gap-3 bg-white rounded-lg border border-gray-100 px-4 py-3 group hover:shadow-sm transition-all">
                        <span class="w-5 h-5 rounded text-[10px] font-bold flex items-center justify-center bg-gray-100 text-gray-500" x-text="idx + 1"></span>
                        <div class="flex-1 text-sm text-gray-700 flex items-center gap-2">
                            <span x-text="item.teks_item"></span>
                            <template x-if="item.tipe === 'voting'">
                                <span class="px-1.5 py-0.5 text-[9px] font-bold uppercase bg-amber-100 text-amber-800 rounded">Voting</span>
                            </template>
                        </div>
                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="editItem(item)" class="p-1 rounded hover:bg-primary/10 text-gray-400 hover:text-primary"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                            <button @click="deleteItem(item)" class="p-1 rounded hover:bg-red-50 text-gray-400 hover:text-red-500"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    @endforeach
 
    <template x-if="allItems.length === 0">
        <div class="py-8"><x-empty-state title="Belum ada item angket" description="Tambahkan item pertanyaan untuk angket." icon="document" /></div>
    </template>
 
    {{-- Add/Edit Modal --}}
    <div x-show="showForm" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" @click.self="showForm = false">
        <div x-transition class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-semibold font-heading text-gray-800 mb-4" x-text="editingItem ? 'Edit Item' : 'Tambah Item'"></h3>
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-600 mb-1 block">Kategori</label>
                    <select x-model="form.kategori" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        @foreach($categoryLabels as $k => $label) 
                            <option value="{{ $k }}">Kategori {{ $k }} ({{ $label }})</option> 
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm text-gray-600 mb-1 block">Tipe Penilaian</label>
                    <select x-model="form.tipe" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        <option value="skala">Skala Penilaian (Sangat Baik s/d Tidak Baik)</option>
                        <option value="voting">Voting Peserta (Pilih Rekan Peserta)</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm text-gray-600 mb-1 block">Teks Pertanyaan</label>
                    <textarea x-model="form.teks_item" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none resize-none" placeholder="Tuliskan pertanyaan..."></textarea>
                </div>
            </div>
            <div class="flex gap-3 mt-5">
                <button @click="showForm = false" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm rounded-xl">Batal</button>
                <button @click="saveItem()" class="flex-1 px-4 py-2.5 bg-primary text-white text-sm rounded-xl font-medium">Simpan</button>
            </div>
        </div>
    </div>
</div>
 
@push('scripts')
<script>
function angketManager() {
    return {
        allItems: @json($angketItems->flatten()->values()),
        showForm: false, editingItem: null,
        form: { kategori: 'A', teks_item: '', tipe: 'skala' },
 
        init() {},
        itemsByKategori(k) { return this.allItems.filter(i => i.kategori === k); },
 
        editItem(item) { this.editingItem = item; this.form = { kategori: item.kategori, teks_item: item.teks_item, tipe: item.tipe || 'skala' }; this.showForm = true; },

        async saveItem() {
            if (!this.form.teks_item.trim()) return;
            const url = this.editingItem
                ? '{{ route("admin.angket.updateItem", [$event, "__I__"]) }}'.replace('__I__', this.editingItem.id)
                : '{{ route("admin.angket.storeItem", $event) }}';
            const method = this.editingItem ? 'PUT' : 'POST';
            const res = await fetch(url, { method, headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: JSON.stringify(this.form) });
            const data = await res.json();
            if (data.status === 'success') {
                if (this.editingItem) { Object.assign(this.editingItem, data.item); }
                else {
                    if (Array.isArray(data.item)) {
                        this.allItems.push(...data.item);
                    } else {
                        this.allItems.push(data.item);
                    }
                }
                this.showForm = false;
            }
        },

        async deleteItem(item) {
            if (!confirm('Hapus item ini?')) return;
            await fetch('{{ route("admin.angket.destroyItem", [$event, "__I__"]) }}'.replace('__I__', item.id), { method: 'DELETE', headers: {'X-CSRF-TOKEN':'{{ csrf_token() }}'} });
            this.allItems = this.allItems.filter(i => i.id !== item.id);
        },
    };
}
</script>
@endpush
