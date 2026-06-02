@extends('layouts.main')

@section('title', $subAspek->nama_sub_aspek . ' — Afektif')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4" x-data="afektifFill()">

    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('peserta.afektif.index', $event) }}" class="text-xs text-primary hover:underline mb-2 inline-block">← Kembali ke Sub-Aspek</a>
        <h1 class="text-xl font-heading font-bold text-gray-800">{{ $subAspek->nama_sub_aspek }}</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $completedCount }} dari {{ $allSubAspeks->count() }} sub-aspek selesai</p>
    </div>

    {{-- Progress --}}
    <div class="bg-white rounded-xl border border-gray-100 p-4 mb-6">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold text-gray-600">Dijawab <span class="text-primary" x-text="answeredCount"></span> dari {{ $butirList->count() }} pernyataan</span>
            <span class="text-xs text-gray-400" x-text="Math.round(answeredCount / {{ $butirList->count() }} * 100) + '%'"></span>
        </div>
        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-primary rounded-full transition-all duration-300"
                 :style="'width: ' + (answeredCount / {{ $butirList->count() }} * 100) + '%'"></div>
        </div>
    </div>

    {{-- Instructions --}}
    <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4 mb-6 text-xs text-blue-700">
        Pilih jawaban yang paling sesuai dengan diri Anda. SS = Sangat Setuju, S = Setuju, TS = Tidak Setuju, STS = Sangat Tidak Setuju.
    </div>

    {{-- Statements --}}
    <div class="space-y-4">
        @foreach($butirList as $i => $butir)
            <div id="butir-{{ $butir->id }}" :class="{'ring-2 ring-red-500/50 border-red-200': showErrors && !answers[{{ $butir->id }}]}" class="bg-white rounded-xl border border-gray-100 p-5 transition-all">
                <div class="flex items-start gap-3 mb-4">
                    <span :class="showErrors && !answers[{{ $butir->id }}] ? 'bg-red-100 text-red-600' : 'bg-primary/10 text-primary'" class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">{{ $i + 1 }}</span>
                    <p class="text-sm text-gray-800 leading-relaxed">{{ $butir->teks_pernyataan }}</p>
                </div>

                {{-- Likert Cards 2x2 Grid --}}
                <div class="grid grid-cols-2 gap-2 ml-10">
                    @php
                        $options = [
                            'SS' => ['label' => 'Sangat Setuju', 'color' => 'green-600', 'bg' => 'green-50', 'border' => 'green-200', 'hoverBg' => 'green-100'],
                            'S'  => ['label' => 'Setuju', 'color' => 'green-500', 'bg' => 'green-50/50', 'border' => 'green-100', 'hoverBg' => 'green-50'],
                            'TS' => ['label' => 'Tidak Setuju', 'color' => 'orange-500', 'bg' => 'orange-50/50', 'border' => 'orange-100', 'hoverBg' => 'orange-50'],
                            'STS'=> ['label' => 'Sangat Tidak Setuju', 'color' => 'red-500', 'bg' => 'red-50/50', 'border' => 'red-100', 'hoverBg' => 'red-50'],
                        ];
                    @endphp
                    @foreach($options as $key => $opt)
                        <button @click="setAnswer({{ $butir->id }}, '{{ $key }}')"
                            :class="answers[{{ $butir->id }}] === '{{ $key }}'
                                ? 'border-2 border-{{ $opt['color'] }} bg-{{ $opt['bg'] }} shadow-sm ring-2 ring-{{ $opt['color'] }}/20'
                                : 'border border-gray-200 hover:bg-{{ $opt['hoverBg'] }} hover:border-{{ $opt['border'] }}'"
                            class="p-3 rounded-xl text-center transition-all group">
                            <span class="text-xs font-bold block mb-0.5"
                                :class="answers[{{ $butir->id }}] === '{{ $key }}' ? 'text-{{ $opt['color'] }}' : 'text-gray-600'">{{ $key }}</span>
                            <span class="text-[10px]"
                                :class="answers[{{ $butir->id }}] === '{{ $key }}' ? 'text-{{ $opt['color'] }}' : 'text-gray-400'">{{ $opt['label'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- Submit --}}
    <div class="mt-8 text-center">
        <button @click="submitAll()" :disabled="isSubmitting"
            class="px-8 py-3 bg-primary text-white text-sm font-bold rounded-2xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 disabled:opacity-40 disabled:cursor-not-allowed disabled:shadow-none">
            <span x-show="!isSubmitting">Simpan Jawaban</span>
            <span x-show="isSubmitting">Menyimpan...</span>
        </button>
        <p class="text-xs text-gray-400 mt-2" x-show="showErrors && answeredCount < {{ $butirList->count() }}">
            <span class="text-red-500 font-medium">Ada pernyataan yang belum dijawab.</span>
        </p>
    </div>
</div>

<script>
function afektifFill() {
    return {
        answers: @json($existingAnswers),
        isSubmitting: false,
        showErrors: false,
        autoSaveTimer: null,
        butirIds: @json($butirList->pluck('id')),

        get answeredCount() { return Object.keys(this.answers).length; },

        init() {
            // Auto-save every 30 seconds
            this.autoSaveTimer = setInterval(() => { this.autoSave(); }, 30000);
        },

        setAnswer(butirId, jawaban) {
            this.answers[butirId] = jawaban;
            if (this.showErrors && this.answeredCount === this.butirIds.length) {
                this.showErrors = false;
            }
        },

        async autoSave() {
            const payload = Object.entries(this.answers).map(([butirId, jawaban]) => ({ butir_id: parseInt(butirId), jawaban }));
            if (payload.length === 0) return;

            await fetch('{{ route("peserta.afektif.save", [$event, $subAspek]) }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ answers: payload }),
            });
        },

        async submitAll() {
            if (this.answeredCount < this.butirIds.length) {
                this.showErrors = true;
                this.$nextTick(() => {
                    const firstUnanswered = this.butirIds.find(id => !this.answers[id]);
                    if (firstUnanswered) {
                        const el = document.getElementById('butir-' + firstUnanswered);
                        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
                return;
            }

            this.isSubmitting = true;
            clearInterval(this.autoSaveTimer);

            const payload = Object.entries(this.answers).map(([butirId, jawaban]) => ({ butir_id: parseInt(butirId), jawaban }));

            const res = await fetch('{{ route("peserta.afektif.save", [$event, $subAspek]) }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ answers: payload }),
            });

            if (res.ok) {
                window.location.href = '{{ route("peserta.afektif.index", $event) }}';
            } else {
                this.isSubmitting = false;
                alert('Gagal menyimpan. Silakan coba lagi.');
            }
        },
    };
}
</script>
@endsection
