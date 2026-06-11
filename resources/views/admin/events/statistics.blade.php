@extends('layouts.main')

@section('title', 'Analisis Statistik - ' . $event->nama_event)

@section('breadcrumb')
    <a href="{{ auth()->user()->isFasilitator() ? route('admin.events.index') : route('admin.dashboard') }}" class="text-sm text-slate-500 hover:text-primary transition-colors">Dashboard</a>
    <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('admin.events.index') }}" class="text-sm text-slate-500 hover:text-primary transition-colors">Kelola Event</a>
    <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('admin.events.show', $event) }}" class="text-sm text-slate-500 hover:text-primary transition-colors">{{ Str::limit($event->nama_event, 20) }}</a>
    <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-sm font-medium text-slate-700">Analisis Grafik</span>
@endsection

@section('content')
<div class="space-y-8">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.events.show', $event) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 font-heading tracking-tight">Analisis & Statistik Kegiatan</h1>
                <p class="text-sm text-slate-500 mt-1">Laporan metrik hasil perhitungan SPK dan analisis efektivitas pembelajaran kognitif.</p>
            </div>
        </div>
        <div class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg self-start md:self-auto">
            ID Event: #{{ $event->id }}
        </div>
    </div>

    {{-- Stats Cards Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Card 1 --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Peserta</p>
                <p class="text-2xl font-bold text-slate-950 tracking-tight">{{ $totalPeserta }}</p>
            </div>
            <div class="p-3 bg-slate-50 text-slate-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Lulus Evaluasi</p>
                <p class="text-2xl font-bold text-slate-950 tracking-tight">{{ $penilaian->where('status_kelulusan', '!=', 'Tidak Lulus')->count() }}</p>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0" />
                </svg>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Ditangguhkan</p>
                <p class="text-2xl font-bold text-slate-950 tracking-tight">{{ $penilaian->where('status_kelulusan', '===', 'Tidak Lulus')->count() }}</p>
            </div>
            <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Rata-rata N-Gain</p>
                <p class="text-2xl font-bold text-slate-950 tracking-tight">{{ round($penilaian->avg('n_gain_score') ?? 0, 4) }}</p>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
        </div>
    </div>

    {{-- Main Visualizations Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Chart 1: Predikat Kelulusan AHP-SAW --}}
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xs space-y-4">
            <div>
                <h3 class="font-bold text-slate-800 font-heading text-base">Distribusi Predikat Kelulusan (AHP-SAW)</h3>
                <p class="text-xs text-slate-400">Klasifikasi kompetensi kelulusan berdasarkan pembobotan akhir.</p>
            </div>
            <div class="h-64 flex items-center justify-center">
                <canvas id="predikatChart"></canvas>
            </div>
        </div>

        {{-- Chart 2: Distribusi Kategori N-Gain --}}
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xs space-y-4">
            <div>
                <h3 class="font-bold text-slate-800 font-heading text-base">Tingkat Efektivitas Pembelajaran (N-Gain)</h3>
                <p class="text-xs text-slate-400">Distribusi efektivitas peningkatan kognitif menurut kategori Hake.</p>
            </div>
            <div class="h-64 flex items-center justify-center">
                <canvas id="nGainChart"></canvas>
            </div>
        </div>

        {{-- Chart 3: Nilai Rata-rata Kriteria --}}
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xs lg:col-span-2 space-y-4">
            <div>
                <h3 class="font-bold text-slate-800 font-heading text-base">Rata-rata Skor per Kriteria Evaluasi</h3>
                <p class="text-xs text-slate-400">Rasio nilai riil peserta pada 5 kriteria penentu kelulusan.</p>
            </div>
            <div class="h-80 w-full">
                <canvas id="kriteriaChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Global Chart Defaults for Clean Professional Aesthetics
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.font.size = 11;
        Chart.defaults.color = '#64748b';

        // Chart 1: Predikat Kelulusan (Cohesive Academic Blue-Gray Shades)
        const predikatCtx = document.getElementById('predikatChart').getContext('2d');
        new Chart(predikatCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($predikatData)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($predikatData)) !!},
                    backgroundColor: [
                        '#1e3a8a', // Deep Blue
                        '#3b82f6', // Light Blue
                        '#93c5fd', // Soft Blue
                        '#cbd5e1'  // Soft Gray
                    ],
                    borderWidth: 3,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 8,
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                cutout: '70%'
            }
        });

        // Chart 2: N-Gain Distribution
        const nGainCtx = document.getElementById('nGainChart').getContext('2d');
        new Chart(nGainCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($nGainData)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($nGainData)) !!},
                    backgroundColor: '#1e3a8a',
                    borderRadius: 6,
                    maxBarThickness: 32
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // Chart 3: Kriteria Comparison (Cohesive Blue theme)
        const kriteriaCtx = document.getElementById('kriteriaChart').getContext('2d');
        new Chart(kriteriaCtx, {
            type: 'bar',
            data: {
                labels: ['C1 (Pretest)', 'C2 (Posttest)', 'C3 (Afektif)', 'C4 (Psikomotor)', 'C5 (Kehadiran)'],
                datasets: [{
                    data: [{{ $avgPretest }}, {{ $avgPosttest }}, {{ $avgAfektif }}, {{ $avgPsikomotor }}, {{ $avgKehadiran }}],
                    backgroundColor: '#3b82f6',
                    hoverBackgroundColor: '#1e3a8a',
                    borderRadius: 8,
                    maxBarThickness: 48
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
