@extends('layouts.main')

@section('title', ucfirst($tipe) . ' — ' . $event->nama_event)

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="bg-white rounded-2xl shadow-card border border-gray-100 overflow-hidden">
        {{-- Header --}}
        <div class="bg-gradient-to-br from-primary to-primary/80 text-white p-8 text-center">
            <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
            <h1 class="text-2xl font-heading font-bold mb-1">{{ ucfirst($tipe) }}</h1>
            <p class="text-white/70 text-sm">{{ $event->nama_event }}</p>
        </div>

        {{-- Info Cards --}}
        <div class="p-8">
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="bg-primary/5 rounded-xl p-4 text-center border border-primary/10">
                    <p class="text-2xl font-heading font-bold text-primary">{{ $totalSoal }}</p>
                    <p class="text-xs text-gray-500 mt-1">Jumlah Soal</p>
                </div>
                <div class="bg-accent/5 rounded-xl p-4 text-center border border-accent/10">
                    <p class="text-2xl font-heading font-bold text-accent">{{ $sesiTes->durasi_menit }}</p>
                    <p class="text-xs text-gray-500 mt-1">Menit</p>
                </div>
            </div>

            {{-- Rules --}}
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-800 mb-3">Aturan Pengerjaan</h3>
                <div class="space-y-2.5">
                    @php
                    $rules = [
                        'Baca setiap pertanyaan dengan cermat sebelum menjawab.',
                        'Pilih satu jawaban yang paling tepat untuk setiap pertanyaan.',
                        'Anda dapat berpindah antar soal secara bebas.',
                        'Jawaban tersimpan otomatis — tidak hilang jika halaman di-refresh.',
                        'Setelah waktu habis, jawaban akan otomatis diserahkan.',
                        'Setelah dikumpulkan, jawaban tidak dapat diubah.',
                    ];
                    @endphp
                    @foreach($rules as $i => $rule)
                        <div class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 text-xs font-bold text-primary mt-0.5">{{ $i + 1 }}</span>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $rule }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Start Button --}}
            <a href="{{ route('peserta.tes.take', [$event, $tipe]) }}"
               class="w-full flex items-center justify-center gap-2 py-4 bg-primary hover:bg-primary/90 text-white text-lg font-heading font-bold rounded-2xl transition-all shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30"
               onclick="return confirm('Yakin mulai {{ ucfirst($tipe) }}? Timer akan langsung berjalan.')">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                MULAI {{ strtoupper($tipe) }}
            </a>
        </div>
    </div>
</div>
@endsection
