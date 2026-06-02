@extends('layouts.main')

@section('title', 'Penilaian Afektif')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <x-page-header title="Penilaian Afektif" subtitle="Pengisian kuesioner sikap dan kedisiplinan mandiri" />

    <div class="space-y-3 mt-6">
        @foreach($subAspeks as $sa)
            <div class="bg-white rounded-xl border border-gray-100 hover:shadow-sm transition-all p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold
                            {{ $sa['completed'] ? 'bg-green-50 text-green-600' : 'bg-primary/10 text-primary' }}">
                            @if($sa['completed'])✓@else{{ $loop->iteration }}@endif
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $sa['nama'] }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $sa['answered'] }}/{{ $sa['butirCount'] }} pernyataan
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($sa['completed'])
                            <span class="px-3 py-1 bg-green-50 text-green-600 text-xs font-semibold rounded-full border border-green-100">Selesai ✓</span>
                        @elseif($sa['status'] === 'aktif')
                            <a href="{{ route('peserta.afektif.fill', [$event, $sa['id']]) }}"
                               class="px-4 py-2 bg-primary text-white text-xs font-semibold rounded-xl hover:bg-primary/90 transition-colors shadow-sm">
                                Isi Sekarang →
                            </a>
                        @elseif($sa['status'] === 'tutup')
                            <span class="px-3 py-1 bg-gray-100 text-gray-400 text-xs font-semibold rounded-full">Ditutup</span>
                        @else
                            <span class="px-3 py-1 bg-yellow-50 text-yellow-600 text-xs font-semibold rounded-full border border-yellow-100">Belum Dibuka</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
