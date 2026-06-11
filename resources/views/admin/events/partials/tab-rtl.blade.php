{{-- RTL Tab Content --}}
<div x-data="{
    subTab: 'status_peserta',
    searchQuery: '',
    selectedCategory: '',
    showForm: false,
    editingQuestion: null,
    formPertanyaan: '',
    formTipe: 'essay',
    
    filterRtls() {
        let rows = this.$el.querySelectorAll('.rtl-row');
        rows.forEach(row => {
            let name = row.dataset.name.toLowerCase();
            let category = row.dataset.category;
            let matchSearch = name.includes(this.searchQuery.toLowerCase());
            let matchCategory = this.selectedCategory === '' || category === this.selectedCategory;
            
            if (matchSearch && matchCategory) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    },

    editQuestion(q) {
        this.editingQuestion = q;
        this.formPertanyaan = q.pertanyaan;
        this.formTipe = q.tipe || 'essay';
        this.showForm = true;
    },

    resetForm() {
        this.editingQuestion = null;
        this.formPertanyaan = '';
        this.formTipe = 'essay';
    }
}">
    {{-- Header & Deadline Setter --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6 pb-6 border-b border-gray-100">
        <div>
            <h3 class="text-lg font-semibold font-heading text-gray-800">Rencana Tindak Lanjut (RTL)</h3>
            <p class="text-xs text-gray-500 mt-1">Kelola tanggat waktu, butir pertanyaan dinamis (Deskripsi, Esai, Unggah Bukti), dan tinjau pengumpulan RTL peserta.</p>
        </div>
        <div class="bg-gray-55/40 border border-gray-100/70 p-4 rounded-2xl max-w-md w-full lg:w-auto">
            <form action="{{ route('admin.events.rtlDeadline.update', $event) }}" method="POST" class="flex flex-col sm:flex-row items-end gap-3">
                @csrf @method('PUT')
                <div class="w-full">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggat Waktu (Deadline) RTL</label>
                    <input type="datetime-local" name="rtl_deadline" 
                           value="{{ $event->rtl_deadline ? $event->rtl_deadline->format('Y-m-d\TH:i') : '' }}"
                           class="w-full px-3 py-1.5 text-xs border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                </div>
                <button type="submit" class="px-4 py-2 bg-primary text-white text-xs font-semibold rounded-lg hover:bg-primary/90 transition-colors shadow-sm whitespace-nowrap">
                    Simpan Batas
                </button>
            </form>
        </div>
    </div>

    {{-- Sub-tabs --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex gap-1 bg-gray-100 rounded-xl p-1">
            <button @click="subTab = 'status_peserta'"
                :class="subTab === 'status_peserta' ? 'bg-white shadow-sm text-primary font-semibold' : 'text-gray-500 hover:text-gray-700'"
                class="px-5 py-2 text-sm rounded-lg transition-all">
                Status Pengumpulan Peserta
            </button>
            <button @click="subTab = 'soal'"
                :class="subTab === 'soal' ? 'bg-white shadow-sm text-primary font-semibold' : 'text-gray-500 hover:text-gray-700'"
                class="px-5 py-2 text-sm rounded-lg transition-all">
                Kelola Pertanyaan RTL ({{ count($rtlSoal) }})
            </button>
        </div>

        <div x-show="subTab === 'soal'">
            <button type="button" @click="showForm = true; resetForm()"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-white text-sm rounded-xl hover:bg-primary/90 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pertanyaan
            </button>
        </div>
    </div>

    {{-- Section 2: Status Pengumpulan RTL Peserta --}}
    <div x-show="subTab === 'status_peserta'" style="display: none;">
        @php
            // Get all participants of this event
            $eventParticipants = \App\Models\EventPeserta::where('event_id', $event->id)
                ->where('status_aktif', true)
                ->with('peserta')
                ->get();
            $submittedPesertaIds = $rtls->pluck('peserta_id')->toArray();
        @endphp

        <div class="overflow-x-auto border border-gray-100 rounded-xl bg-white shadow-sm">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="text-left px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Nama Peserta</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Unit Kerja / Instansi</th>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Status Kelulusan</th>
                        <th class="text-center px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Status RTL</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($eventParticipants as $ep)
                        @php
                            $isSubmitted = in_array($ep->peserta_id, $submittedPesertaIds);
                            // Get their score info to see if they are actually graded / passed
                            $penilaian = \App\Models\PenilaianAkhir::where('event_id', $event->id)->where('peserta_id', $ep->peserta_id)->first();
                            $lulus = $penilaian && str_contains($penilaian->status_kelulusan, 'Lulus') && !str_contains($penilaian->status_kelulusan, 'Tidak Lulus');
                        @endphp
                        <tr class="hover:bg-gray-55/40 transition-colors">
                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $ep->peserta->nama_lengkap }}
                            </td>
                            <td class="px-4 py-3 text-gray-500">
                                {{ $ep->peserta->unit_kerja ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                @if($penilaian)
                                    @if($lulus)
                                        <span class="px-2 py-0.5 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full border border-emerald-100">Lulus</span>
                                    @else
                                        <span class="px-2 py-0.5 text-xs font-semibold text-red-700 bg-red-50 rounded-full border border-red-100">Tidak Lulus / Evaluasi</span>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-400">Belum Dinilai</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($isSubmitted)
                                    <span class="px-2.5 py-1 text-xs font-bold text-emerald-700 bg-emerald-50 rounded-lg inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        Sudah Mengumpulkan
                                    </span>
                                @else
                                    @if($lulus)
                                        @if($event->rtl_deadline && now()->gt($event->rtl_deadline))
                                            <span class="px-2.5 py-1 text-xs font-bold text-red-600 bg-red-50 rounded-lg inline-flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Terlambat / Belum Mengisi
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-bold text-amber-600 bg-amber-50 rounded-lg inline-flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Menunggu Pengisian
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if($isSubmitted)
                                    @php
                                        $userRtl = $rtls->firstWhere('peserta_id', $ep->peserta_id);
                                    @endphp
                                    @if($userRtl)
                                        <a href="{{ route('admin.events.rtl.show', [$event, $userRtl]) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 hover:bg-primary hover:text-white text-gray-700 text-xs font-bold rounded-lg transition-all active:scale-95">
                                            Detail RTL
                                        </a>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-400 font-medium">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-400">Belum ada peserta terdaftar di event ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Section 3: Kelola Pertanyaan RTL --}}
    <div x-show="subTab === 'soal'" style="display: none;">
        @if(count($rtlSoal) > 0)
        <div class="space-y-3">
            @foreach($rtlSoal as $index => $soal)
                <div class="bg-white rounded-xl border border-gray-100 hover:border-primary/20 hover:shadow-sm transition-all group p-4 flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <span class="w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center text-xs font-bold text-primary mt-0.5">
                            {{ $index + 1 }}
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-gray-800 leading-relaxed">{{ $soal->pertanyaan }}</p>
                            <span class="text-[10px] px-2 py-0.5 rounded bg-gray-100 text-gray-600 font-medium inline-block mt-1">
                                @if($soal->tipe === 'deskripsi')
                                    Penjelasan Teknis (Instruksi)
                                @elseif($soal->tipe === 'essay')
                                    Esai / Pertanyaan Teks
                                @elseif($soal->tipe === 'upload')
                                    Unggah Gambar Bukti (Wajib)
                                @else
                                    {{ ucfirst($soal->tipe) }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button type="button" @click="editQuestion({{ json_encode($soal) }})"
                                class="p-1.5 rounded-lg hover:bg-primary/10 text-gray-400 hover:text-primary transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <form method="POST" action="{{ route('admin.events.rtlSoal.destroy', [$event, $soal]) }}" onsubmit="return confirm('Hapus pertanyaan RTL ini? Tindakan ini juga akan menghapus jawaban peserta terkait.')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        @else
            <x-empty-state title="Belum ada pertanyaan RTL" description="Tambahkan pertanyaan baru untuk memandu peserta mengisi RTL." icon="survey" />
        @endif
    </div>

    {{-- Add/Edit Question Modal --}}
    <div x-show="showForm" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
         @click.self="showForm = false" style="display: none;">
        <div x-show="showForm" x-transition class="bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
                <h3 class="text-lg font-bold text-gray-800 font-heading" x-text="editingQuestion ? 'Edit Pertanyaan RTL' : 'Tambah Pertanyaan RTL'"></h3>
                <button @click="showForm = false" class="p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-200 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form :action="editingQuestion ? '{{ route('admin.events.rtlSoal.update', [$event, '__ID__']) }}'.replace('__ID__', editingQuestion.id) : '{{ route('admin.events.rtlSoal.store', $event) }}'" method="POST" class="p-6">
                @csrf
                <template x-if="editingQuestion">
                    <input type="hidden" name="_method" value="PUT">
                </template>
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Pertanyaan <span class="text-red-500">*</span></label>
                    <select name="tipe" x-model="formTipe" required
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50 font-medium">
                        <option value="deskripsi">Penjelasan Teknis (Hanya Instruksi)</option>
                        <option value="essay">Jawaban Esai / Teks</option>
                        <option value="upload">Unggah Gambar Bukti (Wajib)</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Teks Pertanyaan / Deskripsi <span class="text-red-500">*</span></label>
                    <textarea name="pertanyaan" x-model="formPertanyaan" rows="4" required placeholder="Tuliskan teks pertanyaan atau instruksi teknis..."
                              class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none resize-none bg-gray-50/50"></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" @click="showForm = false" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-xl transition-colors font-medium">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-colors shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

