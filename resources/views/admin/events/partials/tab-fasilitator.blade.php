{{-- Fasilitator Tab Content --}}
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h3 class="text-lg font-semibold font-heading text-gray-800">Manajemen Fasilitator</h3>
            <p class="text-sm text-gray-500 mt-1">Tugaskan fasilitator untuk membantu mengelola event ini.</p>
        </div>
    </div>

    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-150">
        <form method="POST" action="{{ route('admin.events.assignFacilitators', $event) }}">
            @csrf
            <div class="space-y-4">
                <label class="block text-sm font-semibold text-gray-700">Pilih Fasilitator yang Ditugaskan:</label>
                
                @if(count($allFasilitators) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($allFasilitators as $fasilitator)
                            @php
                                $isChecked = in_array($fasilitator->id, $assignedFasilitatorIds);
                            @endphp
                            <label class="flex items-start gap-3 p-4 bg-white rounded-xl border border-gray-200 hover:border-primary/40 hover:bg-primary/5 transition-all cursor-pointer select-none">
                                <input type="checkbox" name="facilitators[]" value="{{ $fasilitator->id }}"
                                       @if($isChecked) checked @endif
                                       class="mt-1 text-primary focus:ring-primary rounded border-gray-300">
                                <div>
                                    <span class="block text-sm font-medium text-gray-800">{{ $fasilitator->name }}</span>
                                    <span class="block text-xs text-gray-400 font-mono">@</span><span class="text-xs text-gray-400 font-mono">{{ $fasilitator->username }}</span>
                                    <span class="block text-xs text-gray-400 mt-0.5">{{ $fasilitator->email }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 text-gray-500">
                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Belum ada user dengan role <strong>Fasilitator</strong> di sistem.
                    </div>
                @endif

                <div class="flex justify-end pt-4 border-t border-gray-200/60 mt-6">
                    <x-button type="submit" variant="primary">
                        Simpan Penugasan Fasilitator
                    </x-button>
                </div>
            </div>
        </form>
    </div>
</div>
