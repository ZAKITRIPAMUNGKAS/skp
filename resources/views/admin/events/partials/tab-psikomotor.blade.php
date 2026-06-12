{{-- Psikomotor Tab Content --}}
<div x-data="psikomotorManager()" x-init="init()">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-sm font-semibold text-gray-800">Penilaian Psikomotor</h3>
            <p class="text-xs text-gray-500 mt-0.5">Evaluasi Outbound & Ibadah</p>
        </div>
        <div class="flex items-center gap-2">
            <template x-if="!hasTemplates">
                <button @click="initTemplates()" class="px-4 py-2 bg-primary text-white text-sm rounded-xl hover:bg-primary/90 transition-colors shadow-sm font-medium">
                    Inisialisasi Template
                </button>
            </template>
            <template x-if="hasTemplates && rows.length > 0">
                <button @click="saveAll()" :disabled="isSaving"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-500 text-white text-sm rounded-xl hover:bg-green-600 transition-colors shadow-sm font-medium disabled:opacity-60">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span x-text="isSaving ? 'Menyimpan...' : 'Simpan Semua'"></span>
                </button>
            </template>
        </div>
    </div>

    {{-- Filter & Search --}}
    <template x-if="hasTemplates && rows.length > 0">
        <div class="flex items-center justify-between mb-4 bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" x-model="searchQuery" placeholder="Cari nama peserta..." 
                        class="pl-9 pr-4 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none w-64">
                </div>
                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer hover:text-gray-800 transition-colors">
                    <input type="checkbox" x-model="filterUnevaluated" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                    Hanya yang belum dinilai
                </label>
            </div>
            <span class="text-xs font-semibold text-primary bg-primary/10 px-2.5 py-1 rounded-lg" x-text="filteredRows.length + ' peserta'"></span>
        </div>
    </template>

    {{-- Mass Scoring Table --}}
    <template x-if="hasTemplates && rows.length > 0">
        <div class="bg-white rounded-xl border border-gray-200 overflow-x-auto shadow-sm">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider sticky left-0 bg-white z-10 w-48">Peserta</th>

                        {{-- Outbound headers --}}
                        <template x-for="t in outboundTemplates" :key="'th_'+t.id">
                            <th class="px-3 py-3 text-center text-[10px] font-semibold text-gray-500 uppercase min-w-[80px]">
                                <span x-text="t.nama_aspek.split('(')[0].trim()"></span>
                            </th>
                        </template>

                        {{-- Ibadah headers --}}
                        <template x-for="t in ibadahTemplates" :key="'th_'+t.id">
                            <th class="px-3 py-3 text-center text-[10px] font-semibold text-gray-500 uppercase min-w-[80px]">
                                <span x-text="t.nama_aspek.split('(')[0].trim()"></span>
                            </th>
                        </template>

                        <th class="px-4 py-3 text-center text-xs font-semibold text-primary uppercase">Total</th>
                    </tr>

                    {{-- Group header row --}}
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <td class="px-4 py-1.5 sticky left-0 bg-gray-50/50 z-10"></td>
                        <td :colspan="outboundTemplates.length" class="text-center text-[9px] font-semibold text-blue-600 uppercase py-1.5 border-x border-gray-100">Outbound</td>
                        <td :colspan="ibadahTemplates.length" class="text-center text-[9px] font-semibold text-purple-600 uppercase py-1.5 border-r border-gray-100">Ibadah</td>
                        <td class="py-1.5"></td>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="(row, rIdx) in filteredRows" :key="row.peserta_id">
                        <tr :class="activeRow === row.peserta_id ? 'bg-primary/5' : 'hover:bg-gray-50'" class="transition-colors"
                            @focusin="activeRow = row.peserta_id"
                            @focusout="handleRowBlur(row)">
                            <td class="px-4 py-3 sticky left-0 z-10" :class="activeRow === row.peserta_id ? 'bg-primary/5' : 'bg-white'">
                                <p class="text-sm font-medium text-gray-800 truncate max-w-[180px]" x-text="row.nama"></p>
                                <p class="text-[10px] text-gray-400" x-text="row.unit_kerja || '-'"></p>
                            </td>

                            <template x-for="t in templates" :key="'cell_'+row.peserta_id+'_'+t.id">
                                <td class="px-2 py-2 text-center">
                                    <select x-model.number="row.scores[t.id]"
                                        @change="markDirty(row)"
                                        class="w-14 h-9 text-center text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white appearance-none cursor-pointer">
                                        <option value="">-</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </td>
                            </template>

                            <td class="px-4 py-3 text-center">
                                <span class="text-sm font-bold" :class="getRowTotal(row) > 0 ? 'text-primary' : 'text-gray-300'" x-text="getRowTotal(row) > 0 ? getRowPercentage(row) + '%' : '-'"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </template>

    <template x-if="!hasTemplates">
        <div class="py-8">
            <x-empty-state title="Template belum dibuat" description="Klik 'Inisialisasi Template' untuk membuat template penilaian psikomotor default." icon="document" />
        </div>
    </template>

    <template x-if="hasTemplates && rows.length === 0">
        <div class="py-8">
            <x-empty-state title="Belum ada peserta" description="Tambahkan peserta terlebih dahulu di tab Peserta." icon="users" />
        </div>
    </template>
</div>

@push('scripts')
<script>
function psikomotorManager() {
    return {
        templates: [], rows: [], hasTemplates: false,
        filterUnevaluated: false, searchQuery: '', activeRow: null, isSaving: false,
        dirtyRows: new Set(),

        get outboundTemplates() { return this.templates.filter(t => t.jenis === 'outbound'); },
        get ibadahTemplates() { return this.templates.filter(t => t.jenis === 'ibadah'); },
        get filteredRows() { 
            let result = this.rows;
            if (this.filterUnevaluated) {
                result = result.filter(r => !r.has_all);
            }
            if (this.searchQuery.trim() !== '') {
                const query = this.searchQuery.toLowerCase();
                result = result.filter(r => r.nama.toLowerCase().includes(query));
            }
            return result;
        },

        async init() { await this.loadData(); },

        async loadData() {
            const res = await fetch('{{ route("admin.psikomotor.data", $event) }}');
            const data = await res.json();
            this.templates = data.templates;
            this.rows = data.rows;
            this.hasTemplates = data.templates.length > 0;
        },

        async initTemplates() {
            await fetch('{{ route("admin.psikomotor.init", $event) }}', { method: 'POST', headers: {'X-CSRF-TOKEN':'{{ csrf_token() }}'} });
            await this.loadData();
        },

        getRowTotal(row) {
            return this.templates.reduce((sum, t) => sum + (parseInt(row.scores[t.id]) || 0), 0);
        },

        getRowPercentage(row) {
            const total = this.getRowTotal(row);
            const max = this.templates.reduce((sum, t) => sum + (parseInt(t.skor_maks) || 0), 0);
            return max > 0 ? Math.round((total / max) * 100) : 0;
        },

        markDirty(row) { this.dirtyRows.add(row.peserta_id); },

        async handleRowBlur(row) {
            setTimeout(async () => {
                if (document.activeElement?.closest('tr') !== null) return;
                if (!this.dirtyRows.has(row.peserta_id)) return;
                await this.saveRow(row);
            }, 200);
        },

        async saveRow(row) {
            const scores = this.templates
                .filter(t => row.scores[t.id])
                .map(t => ({ template_id: t.id, skor: parseInt(row.scores[t.id]) }));
            if (scores.length === 0) return;

            await fetch('{{ route("admin.psikomotor.saveRow", $event) }}', {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
                body: JSON.stringify({ peserta_id: row.peserta_id, scores }),
            });
            this.dirtyRows.delete(row.peserta_id);
        },

        async saveAll() {
            this.isSaving = true;
            const data = this.rows.filter(r => {
                return this.templates.some(t => r.scores[t.id]);
            }).map(r => ({
                peserta_id: r.peserta_id,
                scores: this.templates.filter(t => r.scores[t.id]).map(t => ({ template_id: t.id, skor: parseInt(r.scores[t.id]) })),
            }));

            await fetch('{{ route("admin.psikomotor.saveAll", $event) }}', {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
                body: JSON.stringify({ data }),
            });
            this.dirtyRows.clear();
            this.isSaving = false;
            await this.loadData();
        },
    };
}
</script>
@endpush
