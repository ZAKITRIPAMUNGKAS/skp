{{-- Sesi Tab Content --}}
<div x-data="{
    editSession: null,
    reordering: false,
    async updateOrder(items) {
        const order = items.map((el, idx) => ({
            id: parseInt(el.dataset.id),
            urutan: idx + 1
        }));
        const response = await fetch('{{ route('admin.sessions.reorder', $event) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ order })
        });
        if (response.ok) {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: { message: 'Urutan sesi berhasil diperbarui!', type: 'success' }
            }));
        }
    }
}">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold font-heading text-gray-800">Daftar Sesi ({{ $sessions->count() }})</h3>
        <button @click="$dispatch('open-modal-show-add-session')"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary to-[#155C84] hover:from-primary/95 hover:to-[#155C84]/95 text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-md shadow-primary/10 hover:shadow-lg hover:shadow-primary/20 hover:-translate-y-0.5 active:translate-y-0 select-none group">
            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Sesi Baru
        </button>
    </div>

    {{-- Session List --}}
    @if($sessions->count())
    <div class="space-y-3" id="session-list">
        @foreach($sessions as $sesi)
            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-primary/20 hover:bg-primary/5 transition-all group"
                 data-id="{{ $sesi->id }}" draggable="true"
                 @dragstart="$event.dataTransfer.effectAllowed = 'move'; $event.dataTransfer.setData('text/plain', $el.dataset.id)"
                 @dragover.prevent="$event.dataTransfer.dropEffect = 'move'; $el.classList.add('border-primary', 'bg-primary/10')"
                 @dragleave="$el.classList.remove('border-primary', 'bg-primary/10')"
                 @drop.prevent="
                    $el.classList.remove('border-primary', 'bg-primary/10');
                    const draggedId = $event.dataTransfer.getData('text/plain');
                    const draggedEl = document.querySelector('[data-id=\'' + draggedId + '\']');
                    if (draggedEl && draggedEl !== $el) {
                        const parent = $el.parentNode;
                        const rect = $el.getBoundingClientRect();
                        const mid = rect.top + rect.height / 2;
                        if ($event.clientY < mid) {
                            parent.insertBefore(draggedEl, $el);
                        } else {
                            parent.insertBefore(draggedEl, $el.nextSibling);
                        }
                        updateOrder([...parent.children]);
                    }
                 ">
                {{-- Drag handle --}}
                <div class="cursor-grab active:cursor-grabbing text-gray-300 hover:text-gray-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                </div>

                {{-- Order badge --}}
                <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <span class="text-sm font-bold text-primary">{{ $sesi->urutan }}</span>
                </div>

                {{-- Session info --}}
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-800">{{ $sesi->nama_sesi }}</p>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1 text-xs">
                        @if($sesi->pemateri)
                            <span class="text-gray-500 font-medium flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Pemateri: {{ $sesi->pemateri }}
                            </span>
                        @endif
                        @if($sesi->file_materi)
                            <a href="{{ asset('storage/' . $sesi->file_materi) }}" target="_blank" class="text-primary hover:underline font-semibold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Unduh Materi
                            </a>
                        @endif
                        @php
                            $absenCount = $sesi->absensi()->count();
                            $totalPeserta = $participants->count();
                        @endphp
                        <x-badge type="{{ $absenCount > 0 ? 'berlangsung' : 'persiapan' }}">
                            Sudah absen {{ $absenCount }} / {{ $totalPeserta }} peserta
                        </x-badge>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('admin.absensi.scan', [$event, $sesi]) }}"
                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary text-white text-xs rounded-lg hover:bg-primary-600 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        Scan Absensi
                    </a>
                    <button type="button" @click="$dispatch('open-modal-show-edit-session', { session: @json($sesi) })"
                            class="p-1.5 rounded-lg hover:bg-gray-200 text-gray-500 hover:text-gray-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    </button>
                    <form method="POST" action="{{ route('admin.sessions.destroy', [$event, $sesi]) }}"
                          onsubmit="return confirm('Hapus sesi ini?')" class="inline">
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
        <x-empty-state title="Belum ada sesi" description="Tambahkan sesi kegiatan untuk event ini." icon="document" />
    @endif

    {{-- Add Session Modal --}}
    <x-modal name="show-add-session" title="Tambah Sesi Baru">
        <form method="POST" action="{{ route('admin.sessions.store', $event) }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sesi <span class="text-red-500">*</span></label>
                <input type="text" name="nama_sesi" required
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50"
                    placeholder="Contoh: Materi Pembinaan Aqidah">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemateri</label>
                <input type="text" name="pemateri"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50"
                    placeholder="Contoh: Ustadz Dr. H. Sofyan Anif, M.Si.">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">File Materi (PDF, PPT, PPTX, Doc, Docx, Zip)</label>
                <input type="file" name="file_materi"
                    class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <x-button variant="ghost" type="button" @click="show = false">Batal</x-button>
                <x-button type="submit" variant="primary">Tambah Sesi</x-button>
            </div>
        </form>
    </x-modal>

    {{-- Edit Session Modal --}}
    <x-modal name="show-edit-session" title="Edit Sesi">
        <div x-data="{
            editSession: null,
            init() {
                window.addEventListener('open-modal-show-edit-session', (e) => {
                    this.editSession = e.detail.session;
                });
            }
        }">
            <form method="POST" :action="'{{ route('admin.sessions.update', [$event, '__SESSION_ID__']) }}'.replace('__SESSION_ID__', editSession ? editSession.id : '')" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sesi <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_sesi" required :value="editSession ? editSession.nama_sesi : ''"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemateri</label>
                    <input type="text" name="pemateri" :value="editSession ? editSession.pemateri : ''"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">File Materi (Kosongkan jika tidak diubah)</label>
                    <input type="file" name="file_materi"
                        class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                    <template x-if="editSession && editSession.file_materi">
                        <p class="text-xs text-gray-500 mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Materi saat ini sudah diunggah.
                        </p>
                    </template>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <x-button variant="ghost" type="button" @click="$dispatch('close-modal-show-edit-session')">Batal</x-button>
                    <x-button type="submit" variant="primary">Simpan Perubahan</x-button>
                </div>
            </form>
        </div>
    </x-modal>

</div>
