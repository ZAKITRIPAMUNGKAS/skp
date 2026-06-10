@extends('layouts.main')

@section('title', 'Kuisioner')

@section('content')
@php
    $categoryLabels = [
        'A' => 'Materi & Narasumber',
        'B' => 'Fasilitator',
        'C' => 'Panitia',
        'D' => 'Lokasi Baitul Arqam',
        'E' => 'Konsumsi',
        'F' => 'Kepuasan Pengguna',
    ];
@endphp
<div class="max-w-3xl mx-auto py-8 px-4" x-data="angketFill()">

    <div class="mb-6">
        <a href="{{ route('peserta.dashboard') }}" class="text-xs text-primary hover:underline mb-2 inline-block">← Kembali ke Dashboard</a>
        <h1 class="text-xl font-heading font-bold text-gray-800">Kuisioner</h1>
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
                <span class="text-xs font-semibold text-gray-700">{{ $categoryLabels[$kategori] ?? '' }}</span>
                <span class="text-xs text-gray-400">({{ $categoryItems->count() }} pertanyaan)</span>
            </div>

            <div class="space-y-3">
                @foreach($categoryItems as $item)
                    <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-sm transition-all">
                        <div class="flex items-start gap-3 mb-3">
                            <span class="w-6 h-6 rounded bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-500 flex-shrink-0 mt-0.5">{{ $loop->iteration }}</span>
                            <p class="text-sm text-gray-800 leading-relaxed">{{ $item->teks_item }}</p>
                        </div>

                        @if($item->tipe === 'voting')
                            {{-- Dropdown voting --}}
                            <div class="ml-9 max-w-sm">
                                <select @change="setAnswer({{ $item->id }}, $event.target.value)"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none bg-gray-50/50">
                                    <option value="">-- Pilih Rekan Peserta --</option>
                                    @foreach($eventParticipants as $p)
                                        <option value="{{ $p->id }}" {{ ($existingAnswers[$item->id] ?? '') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
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
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    {{-- Nominasi Peserta Section --}}
    <div class="bg-white rounded-xl border border-gray-100 p-5 mb-6">
        <div class="flex items-center gap-2 mb-4">
            <span class="px-2.5 py-1 bg-accent/10 text-accent text-xs font-bold rounded-lg">★</span>
            <span class="sm:text-sm text-xs font-semibold text-gray-800">Nominasi Peserta Terbaik / Ter-</span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Peserta Terdisiplin <span class="text-red-500">*</span></label>
                <select x-model="nominasi_disiplin_id" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none bg-gray-50/50">
                    <option value="">-- Pilih Peserta --</option>
                    @foreach($eventParticipants as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Peserta Teraktif <span class="text-red-500">*</span></label>
                <select x-model="nominasi_aktif_id" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none bg-gray-50/50">
                    <option value="">-- Pilih Peserta --</option>
                    @foreach($eventParticipants as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Peserta Terfavorit <span class="text-red-500">*</span></label>
                <select x-model="nominasi_favorit_id" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none bg-gray-50/50">
                    <option value="">-- Pilih Peserta --</option>
                    @foreach($eventParticipants as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Comment Section --}}
    <div class="bg-white rounded-xl border border-gray-100 p-5 mb-6">
        <div class="flex items-center gap-2 mb-3">
            <span class="px-2.5 py-1 bg-primary/10 text-primary text-xs font-bold rounded-lg">I</span>
            <span class="text-sm font-semibold text-gray-800">Lain-lain (masukan untuk pelaksanaan kedepan)</span>
        </div>
        <textarea x-model="komentar" rows="4" placeholder="Tuliskan saran, kritik, atau komentar Anda..."
            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none resize-none"></textarea>
    </div>

    {{-- Submit --}}
    <div class="text-center">
        <button @click="submitAll()" :disabled="isSubmitting"
            class="px-8 py-3 bg-primary text-white text-sm font-bold rounded-2xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 disabled:opacity-40">
            <span x-text="isSubmitting ? 'Menyimpan...' : 'Kirim Kuisioner'"></span>
        </button>
    </div>

    {{-- Success Modal Overlay --}}
    <div x-show="showSuccess" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-md" style="display: none;">
        <div x-show="showSuccess" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" class="bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full mx-4 text-center border border-gray-100">
            {{-- Checkmark Animation --}}
            <div class="mb-6">
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
            </div>
            <h2 class="text-2xl font-black font-heading text-gray-800 mb-2">Terima Kasih!</h2>
            <p class="text-sm text-gray-500 mb-6 leading-relaxed">Kuisioner evaluasi Baitul Arqam Anda telah berhasil disimpan.</p>
            {{-- Redirecting Indicator --}}
            <div class="flex items-center justify-center gap-2 text-xs font-semibold text-primary">
                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Mengarahkan kembali ke Dashboard...</span>
            </div>
        </div>
    </div>
</div>

<style>
.checkmark {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  display: block;
  stroke-width: 4;
  stroke: #10b981;
  stroke-miterlimit: 10;
  box-shadow: inset 0px 0px 0px #10b981;
  animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out 0s 1 both;
  margin: 0 auto;
}
.checkmark__circle {
  stroke-dasharray: 166;
  stroke-dashoffset: 166;
  stroke-width: 4;
  stroke-miterlimit: 10;
  stroke: #10b981;
  fill: none;
  animation: stroke .6s cubic-bezier(0.650, 0.000, 0.450, 1.000) forwards;
}
.checkmark__check {
  transform-origin: 50% 50%;
  stroke-dasharray: 48;
  stroke-dashoffset: 48;
  animation: stroke .3s cubic-bezier(0.650, 0.000, 0.450, 1.000) .8s forwards;
}
@keyframes stroke {
  100% {
    stroke-dashoffset: 0;
  }
}
@keyframes scale {
  0%, 100% {
    transform: scale3d(1, 1, 1);
  }
  50% {
    transform: scale3d(1.15, 1.15, 1.15);
  }
}
@keyframes fill {
  100% {
    box-shadow: inset 0px 0px 0px 40px #e6f4ea;
  }
}
</style>

<script>
function angketFill() {
    return {
        answers: @json($existingAnswers),
        komentar: @json($existingComment?->komentar ?? ''),
        nominasi_disiplin_id: @json($existingComment?->nominasi_disiplin_id ?? ''),
        nominasi_aktif_id: @json($existingComment?->nominasi_aktif_id ?? ''),
        nominasi_favorit_id: @json($existingComment?->nominasi_favorit_id ?? ''),
        isSubmitting: false,
        showSuccess: false,

        setAnswer(itemId, jawaban) { this.answers[itemId] = jawaban; },

        async submitAll() {
            if (!this.nominasi_disiplin_id || !this.nominasi_aktif_id || !this.nominasi_favorit_id) {
                alert('Silakan pilih nominasi peserta terdisiplin, teraktif, dan terfavorit!');
                return;
            }
            this.isSubmitting = true;
            const payload = Object.entries(this.answers).map(([item_id, jawaban]) => ({ item_id: parseInt(item_id), jawaban }));
            const res = await fetch('{{ route("peserta.angket.save", $event) }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ 
                    answers: payload, 
                    komentar: this.komentar,
                    nominasi_disiplin_id: parseInt(this.nominasi_disiplin_id),
                    nominasi_aktif_id: parseInt(this.nominasi_aktif_id),
                    nominasi_favorit_id: parseInt(this.nominasi_favorit_id)
                }),
            });
            if (res.ok) { 
                this.showSuccess = true;
                setTimeout(() => {
                    window.location.href = '{{ route("peserta.dashboard") }}';
                }, 2500);
            }
            else { this.isSubmitting = false; alert('Gagal menyimpan.'); }
        },
    };
}
</script>
@endsection
