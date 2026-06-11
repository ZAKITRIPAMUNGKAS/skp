{{-- Laporan Tab Content --}}
<div class="space-y-6">

    {{-- Stats Widgets --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <x-card hover="true" class="!p-5 border-l-4 border-l-blue-500">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Peserta</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_peserta'] ?? 0 }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0v-5H7v5m10 0v-5H7v5m5-10V4m-5 4V4m10 4V4"/></svg>
                </div>
            </div>
        </x-card>
        
        <x-card hover="true" class="!p-5 border-l-4 border-l-yellow-500">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Rata-rata Pretest</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['avg_pretest'] ?? 0, 2) }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
            </div>
        </x-card>

        <x-card hover="true" class="!p-5 border-l-4 border-l-green-500">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Rata-rata Posttest</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['avg_posttest'] ?? 0, 2) }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
            </div>
        </x-card>

        <x-card hover="true" class="!p-5 border-l-4 border-l-purple-500">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Rata-rata N-Gain</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['avg_ngain'] ?? 0, 2) }}</h3>
                    <p class="text-[10px] text-gray-400 mt-1">
                        Efektivitas: 
                        <strong>
                            @if(($stats['avg_ngain'] ?? 0) > 0.7) Tinggi
                            @elseif(($stats['avg_ngain'] ?? 0) >= 0.3) Sedang
                            @else Rendah
                            @endif
                        </strong>
                    </p>
                </div>
                <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                </div>
            </div>
        </x-card>

        <x-card hover="true" class="!p-5 border-l-4 border-l-primary">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Rata-rata Kehadiran</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ number_format($stats['avg_kehadiran'] ?? 0, 2) }}%</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center text-primary">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-card class="relative">
            <h3 class="text-sm font-semibold text-gray-800 mb-4">Distribusi Predikat Kelulusan</h3>
            <div class="h-64 relative w-full">
                <canvas id="predikatChart"></canvas>
            </div>
            @if(array_sum($chartData['predikat_data']) === 0)
            <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/95 backdrop-blur-sm z-10 rounded-2xl p-6">
                <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 111.063 1.06l-.041.02a.75.75 0 11-1.063-1.06zm-6 0h.008v.008H5.25v-.008zm6 0h.008v.008h-.008v-.008zm6 0h.008v.008h-.008v-.008zM4.5 9h15M5.25 6H18.75A2.25 2.25 0 0121 8.25v9.75A2.25 2.25 0 0118.75 20H5.25A2.25 2.25 0 013 17.75V8.25A2.25 2.25 0 015.25 6z" />
                </svg>
                <p class="text-xs text-gray-400 font-medium">Belum ada data nilai kelulusan</p>
            </div>
            @endif
        </x-card>
        
        <x-card class="relative">
            <h3 class="text-sm font-semibold text-gray-800 mb-4">Peningkatan Kognitif (Pretest vs Posttest)</h3>
            <div class="h-64 relative w-full flex items-center justify-center">
                <canvas id="kognitifChart"></canvas>
            </div>
            @if(($stats['avg_pretest'] ?? 0) == 0 && ($stats['avg_posttest'] ?? 0) == 0)
            <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/95 backdrop-blur-sm z-10 rounded-2xl p-6">
                <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                </svg>
                <p class="text-xs text-gray-400 font-medium">Belum ada data nilai pretest/posttest</p>
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

        @if(isset($topRankings) && $topRankings->count() > 0)
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

    {{-- Download Actions --}}
    <div class="space-y-4">
        <div>
            <h3 class="text-sm font-semibold text-gray-800 mb-1">Laporan & Berkas Pendukung</h3>
            <p class="text-xs text-gray-500">Unduh data evaluasi perkaderan Baitul Arqam dalam format PDF & Excel.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Presentasi Analisis --}}
            <a href="{{ route('admin.events.presentasi', $event) }}" target="_blank"
               class="bg-white rounded-xl border-2 border-blue-100 hover:shadow-lg hover:border-blue-300 transition-all p-5 group block sm:col-span-2">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-900 flex items-center justify-center flex-shrink-0 shadow">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-blue-900 group-hover:text-blue-700 transition-colors flex items-center gap-2">
                            🎯 Presentasi Analisis Laporan
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Slideshow interaktif untuk forum sidang/rapat laporan: demografi, Qur'an, kehadiran, & predikat kelulusan.</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.events.report', $event) }}" target="_blank"
               class="bg-white rounded-xl border border-gray-100 hover:shadow-md transition-all p-5 group block">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800 group-hover:text-primary transition-colors">Laporan Evaluasi Lengkap</p>
                        <p class="text-xs text-gray-500 mt-1">PDF Laporan Akhir: Data biodata, nilai kognitif (N-Gain), afektif, psikomotor, absensi, & ranking.</p>
                    </div>
                </div>
            </a>

            {{-- Ranking Print --}}
            <a href="{{ route('admin.events.winnersReport', $event) }}" target="_blank"
               class="bg-white rounded-xl border border-gray-100 hover:shadow-md transition-all p-5 group block">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800 group-hover:text-primary transition-colors">Cetak Piagam 3 Besar</p>
                        <p class="text-xs text-gray-500 mt-1">Generate piagam sertifikat penghargaan formal 3 peserta terbaik.</p>
                    </div>
                </div>
            </a>

            {{-- Angket Report --}}
            <a href="{{ route('admin.events.angketReport', $event) }}" target="_blank"
               class="bg-white rounded-xl border border-gray-100 hover:shadow-md transition-all p-5 group block">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800 group-hover:text-primary transition-colors">Laporan Angket Kepuasan</p>
                        <p class="text-xs text-gray-500 mt-1">PDF kuesioner tanggapan item evaluasi, komentar, & masukan tertulis.</p>
                    </div>
                </div>
            </a>

            {{-- Excel Export --}}
            <a href="{{ route('admin.events.exportExcel', $event) }}"
               class="bg-white rounded-xl border border-gray-100 hover:shadow-md transition-all p-5 group block">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-accent/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800 group-hover:text-primary transition-colors">Export Excel Lengkap</p>
                        <p class="text-xs text-gray-500 mt-1">Unduh rekapitulasi data nilai seluruh kriteria dalam satu file berkas Excel.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

</div>

{{-- Scripts Render Charts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                legend: { 
                    position: 'right', 
                    labels: { 
                        usePointStyle: true, 
                        boxWidth: 8, 
                        font: { family: "'Inter', sans-serif", size: 11 } 
                    } 
                }
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
                    backgroundColor: '#1A6D9B', // Primary Navy
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
                legend: { 
                    position: 'top', 
                    labels: { 
                        usePointStyle: true, 
                        boxWidth: 8, 
                        font: { family: "'Inter', sans-serif" } 
                    } 
                }
            }
        }
    });
});
</script>
