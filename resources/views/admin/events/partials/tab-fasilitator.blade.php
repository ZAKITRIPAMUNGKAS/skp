{{-- Fasilitator Tab Content --}}
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h3 class="text-xl font-bold font-heading text-gray-800">Manajemen Fasilitator</h3>
            <p class="text-xs text-gray-500 mt-1">Tugaskan instruktur / fasilitator untuk membantu mendampingi dan mengelola event ini.</p>
        </div>
        @if(count($assignedFasilitatorIds) > 0)
            <div class="flex-shrink-0">
                <a href="{{ route('admin.events.facilitatorsPdf', $event) }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-700 border border-red-200 text-xs font-bold rounded-xl hover:bg-red-100 transition-all shadow-sm">
                    <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Unduh Surat Tugas (PDF)
                </a>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm">
        <form method="POST" action="{{ route('admin.events.assignFacilitators', $event) }}">
            @csrf
            <div class="space-y-6">
                <div class="flex items-center gap-2 pb-4 border-b border-gray-100">
                    <div class="w-2 h-2 rounded-full bg-primary animate-pulse"></div>
                    <span class="text-sm font-bold text-gray-800">Pilih Fasilitator yang Ditugaskan:</span>
                </div>
                
                @if(count($allFasilitators) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach($allFasilitators as $fasilitator)
                            @php
                                $isChecked = in_array($fasilitator->id, $assignedFasilitatorIds);
                            @endphp
                            <label x-data="{ checked: {{ $isChecked ? 'true' : 'false' }} }"
                                   :class="checked ? 'border-primary bg-primary/5 ring-2 ring-primary/10 shadow-md' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50/50 bg-white'"
                                   class="relative flex flex-col p-5 rounded-3xl border transition-all cursor-pointer select-none group w-full text-center">
                                
                                {{-- Checkbox --}}
                                <div class="absolute top-4 right-4 z-10">
                                    <input type="checkbox" name="facilitators[]" value="{{ $fasilitator->id }}"
                                           @change="checked = $el.checked"
                                           @if($isChecked) checked @endif
                                           class="w-5 h-5 text-primary focus:ring-primary/20 rounded-lg border-gray-300 cursor-pointer transition-all">
                                </div>
                                
                                {{-- Photo (1x1 square) --}}
                                <div class="w-full aspect-square rounded-2xl overflow-hidden mb-4 bg-slate-50 flex items-center justify-center border border-gray-100 shrink-0">
                                    @if($fasilitator->foto_url)
                                        <img src="{{ $fasilitator->foto_url }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    @else
                                        <div :class="checked ? 'bg-primary/10 text-primary' : 'bg-slate-100 text-slate-400'" 
                                             class="w-full h-full flex items-center justify-center transition-colors">
                                            <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Name & Details --}}
                                <div class="min-w-0">
                                    <span class="block text-sm font-bold text-gray-800 truncate group-hover:text-primary transition-colors" x-text="'{{ addslashes($fasilitator->name) }}'"></span>
                                    <div class="flex flex-col gap-0.5 mt-1 items-center">
                                        <span class="text-[10px] text-gray-400 truncate max-w-full px-2" x-text="'{{ addslashes($fasilitator->email) }}'"></span>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-gray-400 border-2 border-dashed border-gray-150 rounded-2xl bg-gray-50/30">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p class="text-sm font-semibold text-gray-600">Belum ada user Fasilitator</p>
                        <p class="text-xs text-gray-400 mt-1">Belum ada user dengan role <strong>Fasilitator</strong> di dalam sistem.</p>
                    </div>
                @endif

                <div class="flex justify-end pt-5 border-t border-gray-100 mt-6">
                    <x-button type="submit" variant="primary" class="px-6 py-3 font-semibold shadow-md hover:scale-[1.01] active:scale-95 transition-all">
                        Simpan Penugasan Fasilitator
                    </x-button>
                </div>
            </div>
        </form>
    </div>
</div>
