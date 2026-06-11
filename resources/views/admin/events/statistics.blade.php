@extends('layouts.main')

@section('title', 'Statistik & Analisis Hasil - ' . $event->nama_event)

@section('breadcrumb')
    <a href="{{ auth()->user()->isFasilitator() ? route('admin.events.index') : route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Dashboard</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('admin.events.index') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Kelola Event</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('admin.events.show', $event) }}" class="text-sm text-gray-500 hover:text-primary transition-colors">{{ Str::limit($event->nama_event, 20) }}</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-sm font-medium text-gray-700">Analisis Grafik</span>
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.events.show', $event) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800 font-heading">Visualisasi & Analisis Grafik</h1>
            <p class="text-sm text-gray-500 mt-1">Laporan analitik distribusi nilai kriteria SPK, kelulusan SAW, dan indeks keefektifan N-Gain.</p>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary font-bold text-lg">
                👥
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Total Peserta Terdaftar</p>
                <p class="text-xl font-bold text-gray-800 mt-0.5">{{ $totalPeserta }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 font-bold text-lg">
                🎓
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Total Lulus</p>
                <p class="text-xl font-bold text-gray-800 mt-0.5">{{ $penilaian->where('status_kelulusan', '!=', 'Tidak Lulus')->count() }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 font-bold text-lg">
                ❌
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Ditangguhkan / Tidak Lulus</p>
                <p class="text-xl font-bold text-gray-800 mt-0.5">{{ $penilaian->where('status_kelulusan', '===', 'Tidak Lulus')->count() }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 font-bold text-lg">
                📈
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Rata-rata N-Gain</p>
                <p class="text-xl font-bold text-gray-800 mt-0.5">{{ round($penilaian->avg('n_gain_score') ?? 0, 4) }}</p>
            </div>
        </div>
    </div>

    {{-- Main Visualizations Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Chart 1: Predikat Kelulusan AHP-SAW --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
            <div>
                <h3 class="font-bold text-gray-800 font-heading">Distribusi Predikat Kelulusan</h3>
                <p class="text-xs text-gray-400 mt-0.5">Proporsi klasifikasi predikat kelulusan berdasarkan skor preferensi akhir SAW.</p>
            </div>
            <div class="h-64 flex items-center justify-center">
                <canvas id="predikatChart"></canvas>
            </div>
        </div>

        {{-- Chart 2: Distribusi Kategori N-Gain --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
            <div>
                <h3 class="font-bold text-gray-800 font-heading">Distribusi Kategori N-Gain (Hake)</h3>
                <p class="text-xs text-gray-400 mt-0.5">Efektivitas peningkatan pemahaman kognitif (Pretest vs Posttest).</p>
            </div>
            <div class="h-64 flex items-center justify-center">
                <canvas id="nGainChart"></canvas>
            </div>
        </div>

        {{-- Chart 3: Nilai Rata-rata Kriteria --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm lg:col-span-2 space-y-4">
            <div>
                <h3 class="font-bold text-gray-800 font-heading">Perbandingan Rata-rata Skor Kriteria</h3>
                <p class="text-xs text-gray-400 mt-0.5">Rata-rata nilai riil peserta di lima kriteria utama (skala 0 - 100).</p>
            </div>
            <div class="h-80 flex items-center justify-center">
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
        // Chart 1: Predikat Kelulusan
        const predikatCtx = document.getElementById('predikatChart').getContext('2d');
        new Chart(predikatCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($predikatData)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($predikatData)) !!},
                    backgroundColor: ['#10B981', '#3B82F6', '#F59E0B', '#EF4444'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, font: { size: 10 } }
                    }
                }
            }
        });

        // Chart 2: N-Gain Distribution
        const nGainCtx = document.getElementById('nGainChart').getContext('2d');
        new Chart(nGainCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($nGainData)) !!},
                datasets: [{
                    label: 'Jumlah Peserta',
                    data: {!! json_encode(array_values($nGainData)) !!},
                    backgroundColor: '#1A6D9B',
                    borderRadius: 8,
                    maxBarThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Chart 3: Kriteria Comparison
        const kriteriaCtx = document.getElementById('kriteriaChart').getContext('2d');
        new Chart(kriteriaCtx, {
            type: 'bar',
            data: {
                labels: ['C1 (Pretest)', 'C2 (Posttest)', 'C3 (Afektif)', 'C4 (Psikomotor)', 'C5 (Kehadiran)'],
                datasets: [{
                    label: 'Skor Rata-rata',
                    data: [{{ $avgPretest }}, {{ $avgPosttest }}, {{ $avgAfektif }}, {{ $avgPsikomotor }}, {{ $avgKehadiran }}],
                    backgroundColor: [
                        '#60A5FA',
                        '#3B82F6',
                        '#D4A017',
                        '#8B5CF6',
                        '#10B981'
                    ],
                    borderRadius: 12,
                    maxBarThickness: 60
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, max: 100 },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endpush
