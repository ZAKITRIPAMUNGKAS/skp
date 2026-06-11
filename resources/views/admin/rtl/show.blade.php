@extends('layouts.main')

@section('title', 'Tinjau Detail RTL — ARQAM')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Rencana Tindak Lanjut (RTL)</h1>
            <p class="text-sm text-gray-500 mt-1">Evaluasi rincian alur langkah dan sasaran rencana aksi peserta pelatihan.</p>
        </div>
        <div>
            <a href="{{ route('admin.events.show', [$event, 'tab' => 'rtl']) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-xl text-sm font-bold transition-all">
                ← Kembali ke Event
            </a>
        </div>
    </div>

    {{-- Detail Card --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between border-b border-gray-50 pb-5">
            <div class="space-y-1">
                <span class="px-2.5 py-1 text-xs font-bold text-primary bg-primary-50 rounded-lg">
                    {{ $rtl->event->nama_event }}
                </span>
                <h2 class="text-xl font-bold text-gray-800 mt-2">{{ $rtl->judul_kegiatan }}</h2>
                <p class="text-xs text-gray-400">Diusulkan oleh: <strong class="text-gray-700 font-semibold">{{ $rtl->peserta->nama_lengkap }}</strong> ({{ $rtl->peserta->unit_kerja ?? '-' }})</p>
            </div>
            <div class="text-right">
                <span class="text-xs text-gray-400 block mb-1">Kategori Bidang</span>
                <span class="px-3 py-1.5 bg-accent/10 text-accent font-bold text-xs rounded-xl">
                    {{ $rtl->kategori_rtl }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($rtl->jawaban as $jw)
                <div class="space-y-2">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $jw->soal?->pertanyaan }}</h3>
                    @if($jw->soal?->tipe === 'upload')
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 flex items-center justify-center">
                            <img src="{{ asset($jw->jawaban) }}" alt="Bukti Upload" class="max-h-60 rounded-xl object-contain shadow-sm border border-gray-200">
                        </div>
                    @else
                        <p class="text-sm text-gray-700 leading-relaxed bg-gray-55/40 p-4 rounded-2xl border border-gray-50/70 whitespace-pre-wrap">{{ $jw->jawaban }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Langkah-langkah Timeline --}}
        <div class="space-y-4 pt-4 border-t border-gray-100">
            <h3 class="text-sm font-bold text-gray-800">Alur & Rincian Langkah Kerja</h3>
            <div class="relative pl-6 border-l-2 border-primary-100 space-y-6">
                @foreach($rtl->langkah_langkah as $step)
                    <div class="relative">
                        <span class="absolute -left-[31px] top-1 w-6 h-6 rounded-full bg-primary border-4 border-white text-white font-extrabold text-[10px] flex items-center justify-center">
                            {{ $step['step'] }}
                        </span>
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <p class="text-sm font-semibold text-gray-800">{{ $step['deskripsi'] }}</p>
                            <span class="px-2.5 py-1 text-[10px] font-bold text-primary bg-primary-50 rounded-full shrink-0">
                                Target: {{ $step['target_tanggal'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
