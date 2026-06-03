@extends('layouts.main')

@section('title', 'Hasil ' . ucfirst($tipe))

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4" x-data="{ animScore: 0, showDetails: false }" x-init="
    let target = {{ $result['score'] }};
    let step = target / 60;
    let interval = setInterval(() => {
        animScore += step;
        if (animScore >= target) { animScore = target; clearInterval(interval); }
    }, 16);
">
    {{-- Score Card --}}
    <div class="bg-white rounded-2xl shadow-card border border-gray-100 overflow-hidden mb-6">
        <div class="bg-gradient-to-br from-primary to-primary/80 text-white p-10 text-center">
            <p class="text-sm text-white/60 mb-2 font-heading uppercase tracking-wider">Hasil {{ ucfirst($tipe) }}</p>

            {{-- Animated Score Circle --}}
            <div class="relative w-40 h-40 mx-auto mb-6">
                <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">
                    <circle cx="60" cy="60" r="52" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="8"/>
                    <circle cx="60" cy="60" r="52" fill="none" stroke="white" stroke-width="8"
                        stroke-dasharray="326.73"
                        :stroke-dashoffset="326.73 - (326.73 * animScore / 100)"
                        stroke-linecap="round" class="transition-all duration-100"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div>
                        <span class="text-4xl font-heading font-extrabold" x-text="Math.round(animScore)"></span>
                        <span class="text-xl text-white/60">/100</span>
                    </div>
                </div>
            </div>

            {{-- Badge --}}
            @php
                $score = $result['score'];
                if ($score >= 80) { $badge = 'Sangat Baik'; $badgeColor = 'bg-green-400/20 text-green-200 border-green-400/30'; }
                elseif ($score >= 60) { $badge = 'Baik'; $badgeColor = 'bg-blue-400/20 text-blue-200 border-blue-400/30'; }
                elseif ($score >= 40) { $badge = 'Cukup'; $badgeColor = 'bg-yellow-400/20 text-yellow-200 border-yellow-400/30'; }
                else { $badge = 'Perlu Belajar Lagi'; $badgeColor = 'bg-red-400/20 text-red-200 border-red-400/30'; }
            @endphp
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold border {{ $badgeColor }}">
                {{ $badge }}
            </span>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 divide-x divide-gray-100">
            <div class="p-5 text-center">
                <p class="text-2xl font-heading font-bold text-green-600">{{ $result['correct'] }}</p>
                <p class="text-xs text-gray-500 mt-1">Benar</p>
            </div>
            <div class="p-5 text-center">
                <p class="text-2xl font-heading font-bold text-red-500">{{ $result['incorrect'] }}</p>
                <p class="text-xs text-gray-500 mt-1">Salah</p>
            </div>
            <div class="p-5 text-center">
                <p class="text-2xl font-heading font-bold text-gray-700">{{ $result['total'] }}</p>
                <p class="text-xs text-gray-500 mt-1">Total Soal</p>
            </div>
        </div>
    </div>

    {{-- Show Details Toggle --}}
    <div class="text-center mb-6">
        <button @click="showDetails = !showDetails"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-sm font-medium text-gray-600 rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-4 h-4 transition-transform" :class="showDetails ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
            <span x-text="showDetails ? 'Sembunyikan Detail' : 'Lihat Pembahasan'"></span>
        </button>
    </div>

    {{-- Question Details --}}
    <div x-show="showDetails" x-transition class="space-y-4">
        @foreach($result['details'] as $i => $detail)
            @php
                $soal = $detail['soal'];
                $isCorrect = $detail['is_correct'];
                $correctOpt = $detail['correct_option'];
            @endphp
            <div class="bg-white rounded-xl border {{ $isCorrect ? 'border-green-200' : 'border-red-200' }} overflow-hidden">
                <div class="px-5 py-3 flex items-center justify-between {{ $isCorrect ? 'bg-green-50' : 'bg-red-50' }} border-b {{ $isCorrect ? 'border-green-100' : 'border-red-100' }}">
                    <span class="text-sm font-semibold {{ $isCorrect ? 'text-green-700' : 'text-red-700' }}">
                        Soal {{ $i + 1 }}
                    </span>
                    <span class="text-xs font-semibold {{ $isCorrect ? 'text-green-600' : 'text-red-600' }}">
                        {{ $isCorrect ? '✓ Benar' : '✗ Salah' }}
                    </span>
                </div>
                <div class="p-5">
                    <p class="text-gray-800 mb-4" style="font-family: 'Amiri', 'Scheherazade New', serif; font-size: 15px; line-height: 2;">
                        {{ $soal->teks_soal }}
                    </p>
                    <div class="space-y-2">
                        @foreach($soal->pilihanJawaban as $opt)
                            @php
                                $isSelected = $detail['pilihan_jawab'] == $opt->id;
                                $isCorrectOpt = $opt->is_correct;
                            @endphp
                            <div class="flex items-center gap-3 p-3 rounded-xl border
                                {{ $isCorrectOpt ? 'border-green-300 bg-green-50' : ($isSelected && !$isCorrect ? 'border-red-300 bg-red-50' : 'border-gray-100') }}">
                                <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0
                                    {{ $isCorrectOpt ? 'bg-green-500 text-white' : ($isSelected && !$isCorrect ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-500') }}">
                                    {{ $opt->huruf }}
                                </span>
                                <span class="text-sm {{ $isCorrectOpt ? 'text-green-800 font-medium' : ($isSelected && !$isCorrect ? 'text-red-700' : 'text-gray-600') }}"
                                      style="font-family: 'Amiri', 'Scheherazade New', serif;">
                                    {{ $opt->teks_pilihan }}
                                </span>
                                @if($isSelected)
                                    <span class="ml-auto text-xs {{ $isCorrect ? 'text-green-500' : 'text-red-500' }}">← Jawaban Anda</span>
                                @endif
                                @if($isCorrectOpt && !$isSelected)
                                    <span class="ml-auto text-xs text-green-500">← Jawaban Benar</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
        <a href="{{ route('peserta.tes.index') }}"
           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white text-sm font-medium rounded-xl hover:bg-primary/95 transition-colors shadow-sm">
            ← Kembali ke Daftar Tes
        </a>
        <a href="{{ route('peserta.dashboard') }}"
           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary/10 text-primary text-sm font-medium rounded-xl hover:bg-primary/20 transition-colors">
            Ke Dashboard Utama
        </a>
    </div>
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Amiri&family=Scheherazade+New&display=swap" rel="stylesheet">
@endpush
