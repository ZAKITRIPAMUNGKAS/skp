@extends('layouts.main')

@section('title', 'Admin Dashboard')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="space-y-6">

    {{-- Greeting & Smart Actions --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $greeting }}, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-sm text-gray-500 mt-1">Berikut adalah ringkasan performa event Baitul Arqam saat ini.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Event Baru
            </a>
        </div>
    </div>

    @if($activeEvent)
        {{-- Running Event Card --}}
        <div class="bg-gradient-to-r from-primary to-primary-light rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 -mt-10 -mr-10 opacity-10">
                <svg width="200" height="200" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 22h20L12 2zm0 3.83L19.17 20H4.83L12 5.83z"/></svg>
            </div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/20 backdrop-blur-sm text-xs font-semibold uppercase tracking-wider mb-3">
                        <span class="w-2 h-2 rounded-full @if($activeEvent->status == 'berlangsung') bg-green-400 animate-pulse @else bg-yellow-400 @endif"></span>
                        Event {{ ucfirst($activeEvent->status) }}
                    </span>
                    <h2 class="text-2xl font-bold font-heading mb-1">{{ $activeEvent->nama_event }}</h2>
                    <p class="text-primary-50 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        @tanggal($activeEvent->tanggal_mulai) - @tanggal($activeEvent->tanggal_selesai)
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.events.show', $activeEvent) }}" class="px-5 py-2.5 bg-white text-primary text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors whitespace-nowrap">
                        Kelola Event
                    </a>
                </div>
            </div>
        </div>

        {{-- 4 Metrics Widgets --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-card class="!p-5 border-l-4 border-l-blue-500">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Peserta</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_peserta'] }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0v-5H7v5m10 0v-5H7v5m5-10V4m-5 4V4m10 4V4"/></svg>
                    </div>
                </div>
            </x-card>
            
            <x-card class="!p-5 border-l-4 border-l-yellow-500">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Rata-rata Pretest</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['avg_pretest'], 2) }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-500">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                </div>
            </x-card>

            <x-card class="!p-5 border-l-4 border-l-green-500">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Rata-rata Posttest</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['avg_posttest'], 2) }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-500">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                </div>
            </x-card>

            <x-card class="!p-5 border-l-4 border-l-primary">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Rata-rata Kehadiran</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['avg_kehadiran'], 2) }}%</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center text-primary">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                    </div>
                </div>
            </x-card>
        </div>

        {{-- Charts Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-card>
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Distribusi Predikat Kelulusan</h3>
                <div class="h-64 relative w-full">
                    <canvas id="predikatChart"></canvas>
                </div>
                @if(array_sum($chartData['predikat_data']) === 0)
                <div class="absolute inset-0 flex items-center justify-center bg-white/80 backdrop-blur-sm z-10 m-6 rounded-xl border border-gray-100">
                    <p class="text-sm text-gray-500 font-medium">Belum ada data nilai</p>
                </div>
                @endif
            </x-card>
            
            <x-card>
                <h3 class="text-sm font-semibold text-gray-800 mb-4">Peningkatan Kognitif (Pretest vs Posttest)</h3>
                <div class="h-64 relative w-full flex items-center justify-center">
                    <canvas id="kognitifChart"></canvas>
                </div>
                @if($stats['avg_pretest'] == 0 && $stats['avg_posttest'] == 0)
                <div class="absolute inset-0 flex items-center justify-center bg-white/80 backdrop-blur-sm z-10 m-6 rounded-xl border border-gray-100">
                    <p class="text-sm text-gray-500 font-medium">Belum ada data nilai</p>
                </div>
                @endif
            </x-card>
        </div>

        {{-- Top 10 Ranking --}}
        <x-card>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800 font-heading">Top 10 Peserta Terbaik</h3>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Berdasarkan Perhitungan SAW</span>
            </div>

            @if($topRankings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider rounded-tl-lg">Rank</th>
                            <th class="px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Nama Peserta</th>
                            <th class="px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Unit Kerja</th>
                            <th class="px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider text-center">Skor Akhir</th>
                            <th class="px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider text-center rounded-tr-lg">Predikat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($topRankings as $ranking)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-4 py-3 font-bold text-gray-700">
                                @if($ranking->ranking == 1) 🥇 @elseif($ranking->ranking == 2) 🥈 @elseif($ranking->ranking == 3) 🥉 @endif
                                {{ $ranking->ranking }}
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-800">{{ $ranking->peserta->nama_lengkap ?? 'Unknown' }}</p>
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs">{{ $ranking->peserta->unit_kerja ?? '-' }}</td>
                            <td class="px-4 py-3 text-center font-bold text-primary">{{ number_format($ranking->skor_saw, 4) }}</td>
                            <td class="px-4 py-3 text-center">
                                @predikat($ranking->predikat)
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="py-8 text-center text-gray-500 text-sm">
                Belum ada data ranking yang dihitung untuk event ini. Tentukan bobot AHP dan hitung SAW di halaman Event.
            </div>
            @endif
        </x-card>

    @else
        <x-empty-state 
            title="Tidak Ada Event Aktif" 
            description="Buat event baru untuk memulai pengelolaan Baitul Arqam." 
            icon="event" />
    @endif

</div>

@if($activeEvent)
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Predikat Donut Chart
    const ctxPredikat = document.getElementById('predikatChart').getContext('2d');
    new Chart(ctxPredikat, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($chartData['predikat_labels']) !!},
            datasets: [{
                data: {!! json_encode($chartData['predikat_data']) !!},
                backgroundColor: [
                    '#22c55e', // Green for Amat Baik
                    '#3b82f6', // Blue for Baik
                    '#eab308', // Yellow for Cukup
                    '#ef4444'  // Red for Kurang
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { position: 'right', labels: { usePointStyle: true, boxWidth: 8, font: { family: "'Inter', sans-serif", size: 11 } } }
            }
        }
    });

    // 2. Kognitif Bar Chart (Pretest vs Posttest)
    const ctxKognitif = document.getElementById('kognitifChart').getContext('2d');
    new Chart(ctxKognitif, {
        type: 'bar',
        data: {
            labels: ['Rata-rata Nilai'],
            datasets: [
                {
                    label: 'Pretest',
                    data: [{!! $chartData['pre_post_avg'][0] !!}],
                    backgroundColor: '#9ca3af', // Gray
                    borderRadius: 6,
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
                },
                {
                    label: 'Posttest',
                    data: [{!! $chartData['pre_post_avg'][1] !!}],
                    backgroundColor: '#00652D', // Primary
                    borderRadius: 6,
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, max: 100, grid: { borderDash: [4, 4], color: '#f3f4f6' } },
                x: { grid: { display: false } }
            },
            plugins: {
                legend: { position: 'top', labels: { usePointStyle: true, boxWidth: 8, font: { family: "'Inter', sans-serif" } } }
            }
        }
    });
});
</script>
@endif

@endsection
