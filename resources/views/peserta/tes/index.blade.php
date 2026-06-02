@extends('layouts.main')

@section('title', 'Pretest & Posttest')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <x-page-header title="Pretest / Posttest" subtitle="Evaluasi pemahaman awal dan akhir materi" />

    @if($activeEvent)
        <div class="mt-8 bg-white rounded-3xl border border-gray-100 p-6 md:p-8 shadow-sm mb-8">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-heading font-bold text-gray-800">Petunjuk Evaluasi</h3>
                    <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                        Evaluasi kognitif terdiri dari dua bagian: <strong>Pretest</strong> (dilakukan di awal kegiatan untuk mengukur kemampuan dasar) dan <strong>Posttest</strong> (dilakukan di akhir kegiatan untuk mengukur pemahaman materi). Pastikan Anda mengerjakan tes saat sesi telah dibuka oleh panitia.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Pretest Card --}}
            <div class="relative overflow-hidden bg-white rounded-[2rem] border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-md flex flex-col justify-between group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-full -mr-6 -mt-6 group-hover:scale-110 transition-transform duration-300"></div>
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <span class="px-4 py-1.5 bg-blue-50 text-blue-600 rounded-2xl text-[10px] font-bold uppercase tracking-wider border border-blue-100">
                            Tahap Awal
                        </span>
                        @if($pretestStatus['done'])
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-50 text-green-600 rounded-full text-xs font-semibold border border-green-100">
                                Selesai
                            </span>
                        @elseif($pretestStatus['active'])
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-semibold border border-emerald-100 animate-pulse">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-50 text-gray-400 rounded-full text-xs font-semibold border border-gray-100">
                                Belum Dibuka
                            </span>
                        @endif
                    </div>

                    <h4 class="text-2xl font-heading font-extrabold text-gray-800 mb-2">Pretest</h4>
                    <p class="text-sm text-gray-400 leading-relaxed mb-6">
                        Mengukur pemahaman dasar materi Baitul Arqam sebelum sesi pemaparan dimulai.
                    </p>

                    @if($pretestStatus['done'])
                        <div class="bg-gray-50 rounded-2xl p-4 flex items-center justify-between border border-gray-100">
                            <div>
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Nilai Anda</span>
                                <span class="block text-2xl font-extrabold text-primary mt-0.5">
                                    {{ $pretestStatus['score'] ?? '-' }}
                                </span>
                            </div>
                            <a href="{{ route('peserta.tes.result', [$activeEvent, 'pretest']) }}" class="px-4 py-2 bg-gray-900 text-white rounded-xl text-xs font-bold hover:bg-primary transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    @else
                        <div class="flex items-center justify-between text-xs text-gray-400 font-semibold border-t border-gray-50 pt-4">
                            <span>Jumlah Soal:</span>
                            <span class="text-gray-700 font-bold">{{ $pretestStatus['total_soal'] }} Butir</span>
                        </div>
                    @endif
                </div>

                @if(!$pretestStatus['done'])
                    <div class="p-6 bg-gray-50 border-t border-gray-100 rounded-b-[2rem]">
                        @if($pretestStatus['active'])
                            <a href="{{ route('peserta.tes.instruction', [$activeEvent, 'pretest']) }}" class="w-full flex items-center justify-center gap-2 py-3.5 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary-600 transition-colors shadow-md active:scale-[0.98]">
                                Mulai Mengerjakan
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @else
                            <button disabled class="w-full py-3.5 bg-gray-200 text-gray-400 rounded-xl font-bold text-sm cursor-not-allowed border border-gray-300">
                                Sesi Belum Dibuka
                            </button>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Posttest Card --}}
            <div class="relative overflow-hidden bg-white rounded-[2rem] border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-md flex flex-col justify-between group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-accent/5 rounded-full -mr-6 -mt-6 group-hover:scale-110 transition-transform duration-300"></div>
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <span class="px-4 py-1.5 bg-amber-50 text-amber-600 rounded-2xl text-[10px] font-bold uppercase tracking-wider border border-amber-100">
                            Tahap Akhir
                        </span>
                        @if($posttestStatus['done'])
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-50 text-green-600 rounded-full text-xs font-semibold border border-green-100">
                                Selesai
                            </span>
                        @elseif($posttestStatus['active'])
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-semibold border border-emerald-100 animate-pulse">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-50 text-gray-400 rounded-full text-xs font-semibold border border-gray-100">
                                Belum Dibuka
                            </span>
                        @endif
                    </div>

                    <h4 class="text-2xl font-heading font-extrabold text-gray-800 mb-2">Posttest</h4>
                    <p class="text-sm text-gray-400 leading-relaxed mb-6">
                        Mengukur pemahaman materi secara menyeluruh setelah seluruh rangkaian program Baitul Arqam selesai.
                    </p>

                    @if($posttestStatus['done'])
                        <div class="bg-gray-50 rounded-2xl p-4 flex items-center justify-between border border-gray-100">
                            <div>
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Nilai Anda</span>
                                <span class="block text-2xl font-extrabold text-primary mt-0.5">
                                    {{ $posttestStatus['score'] ?? '-' }}
                                </span>
                            </div>
                            <a href="{{ route('peserta.tes.result', [$activeEvent, 'posttest']) }}" class="px-4 py-2 bg-gray-900 text-white rounded-xl text-xs font-bold hover:bg-primary transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    @else
                        <div class="flex items-center justify-between text-xs text-gray-400 font-semibold border-t border-gray-50 pt-4">
                            <span>Jumlah Soal:</span>
                            <span class="text-gray-700 font-bold">{{ $posttestStatus['total_soal'] }} Butir</span>
                        </div>
                    @endif
                </div>

                @if(!$posttestStatus['done'])
                    <div class="p-6 bg-gray-50 border-t border-gray-100 rounded-b-[2rem]">
                        @if($posttestStatus['active'])
                            <a href="{{ route('peserta.tes.instruction', [$activeEvent, 'posttest']) }}" class="w-full flex items-center justify-center gap-2 py-3.5 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary-600 transition-colors shadow-md active:scale-[0.98]">
                                Mulai Mengerjakan
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @else
                            <button disabled class="w-full py-3.5 bg-gray-200 text-gray-400 rounded-xl font-bold text-sm cursor-not-allowed border border-gray-300">
                                Sesi Belum Dibuka
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-20 text-center bg-white border border-gray-100 rounded-[2.5rem] mt-8 p-8">
            <div class="w-64 h-64 mb-8">
                <img src="{{ asset('images/arka/arka_fokus.png') }}" alt="No Event" class="w-full h-full object-contain opacity-50 grayscale">
            </div>
            <h2 class="text-3xl font-heading font-bold text-gray-800 mb-2">Belum Ada Acara Aktif</h2>
            <p class="text-gray-500 max-w-md mx-auto">Saat ini Anda belum terdaftar dalam Baitul Arqam yang sedang aktif. Silakan hubungi admin MPKSDI jika terjadi kesalahan.</p>
        </div>
    @endif
</div>
@endsection
