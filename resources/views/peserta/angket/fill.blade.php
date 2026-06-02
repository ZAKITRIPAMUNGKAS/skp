@extends('layouts.main')

@section('title', 'Angket Penyelenggaraan')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4" x-data="angketFill()">

    <div class="mb-6">
        <a href="{{ route('peserta.dashboard') }}" class="text-xs text-primary hover:underline mb-2 inline-block">← Kembali ke Dashboard</a>
        <h1 class="text-xl font-heading font-bold text-gray-800">Angket Penyelenggaraan</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $event->nama_event }}</p>
    </div>

    {{-- Instructions --}}
    <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4 mb-6 text-xs text-blue-700">
        Berikan penilaian Anda terhadap penyelenggaraan kegiatan. Pilih salah satu pada setiap pertanyaan.
    </div>

    {{-- Items per Category --}}
    @foreach($items as $kategori => $categoryItems)
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-3">
                <span class="px-2.5 py-1 bg-primary/10 text-primary text-xs font-bold rounded-lg">{{ $kategori }}</span>
                <span class="text-xs text-gray-400">{{ $categoryItems->count() }} pertanyaan</span>
            </div>

            <div class="space-y-3">
                @foreach($categoryItems as $item)
                    <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-sm transition-all">
                        <div class="flex items-start gap-3 mb-3">
                            <span class="w-6 h-6 rounded bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-500 flex-shrink-0 mt-0.5">{{ $loop->iteration }}</span>
                            <p class="text-sm text-gray-800 leading-relaxed">{{ $item->teks_item }}</p>
                        </div>

                        {{-- Radio Options --}}
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 ml-9">
                            @php
                                $opts = [
                                    'A' => ['label' => 'Sangat Baik', 'color' => 'green-600', 'bg' => 'green-50', 'activeBorder' => 'green-500'],
                                    'B' => ['label' => 'Baik', 'color' => 'blue-600', 'bg' => 'blue-50', 'activeBorder' => 'blue-500'],
                                    'C' => ['label' => 'Kurang', 'color' => 'yellow-600', 'bg' => 'yellow-50', 'activeBorder' => 'yellow-500'],
                                    'D' => ['label' => 'Tidak Baik', 'color' => 'red-600', 'bg' => 'red-50', 'activeBorder' => 'red-500'],
                                ];
                            @endphp
                            @foreach($opts as $key => $opt)
                                <button @click="setAnswer({{ $item->id }}, '{{ $key }}')"
                                    :class="answers[{{ $item->id }}] === '{{ $key }}'
                                        ? 'border-2 border-{{ $opt['activeBorder'] }} bg-{{ $opt['bg'] }} shadow-sm'
                                        : 'border border-gray-200 hover:bg-gray-50'"
                                    class="p-2.5 rounded-xl text-center transition-all">
                                    <span class="text-xs font-bold block"
                                        :class="answers[{{ $item->id }}] === '{{ $key }}' ? 'text-{{ $opt['color'] }}' : 'text-gray-600'">{{ $key }}</span>
                                    <span class="text-[10px]"
                                        :class="answers[{{ $item->id }}] === '{{ $key }}' ? 'text-{{ $opt['color'] }}' : 'text-gray-400'">{{ $opt['label'] }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    {{-- Comment Section --}}
    <div class="bg-white rounded-xl border border-gray-100 p-5 mb-6">
        <div class="flex items-center gap-2 mb-3">
            <span class="px-2.5 py-1 bg-primary/10 text-primary text-xs font-bold rounded-lg">I</span>
            <span class="text-sm font-semibold text-gray-800">Lain-lain (Komentar)</span>
        </div>
        <textarea x-model="komentar" rows="4" placeholder="Tuliskan saran, kritik, atau komentar Anda..."
            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none resize-none"></textarea>
    </div>

    {{-- Submit --}}
    <div class="text-center">
        <button @click="submitAll()" :disabled="isSubmitting"
            class="px-8 py-3 bg-primary text-white text-sm font-bold rounded-2xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 disabled:opacity-40">
            <span x-text="isSubmitting ? 'Menyimpan...' : 'Kirim Angket'"></span>
        </button>
    </div>
</div>

<script>
function angketFill() {
    return {
        answers: @json($existingAnswers),
        komentar: @json($existingComment?->komentar ?? ''),
        isSubmitting: false,

        setAnswer(itemId, jawaban) { this.answers[itemId] = jawaban; },

        async submitAll() {
            this.isSubmitting = true;
            const payload = Object.entries(this.answers).map(([item_id, jawaban]) => ({ item_id: parseInt(item_id), jawaban }));
            const res = await fetch('{{ route("peserta.angket.save", $event) }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ answers: payload, komentar: this.komentar }),
            });
            if (res.ok) { window.location.href = '{{ route("peserta.dashboard") }}'; }
            else { this.isSubmitting = false; alert('Gagal menyimpan.'); }
        },
    };
}
</script>
@endsection
