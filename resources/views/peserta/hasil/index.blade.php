@extends('layouts.main')

@section('title', 'Hasil Penilaian Akhir')

@if($activeEvent && $scores && $scores->ranking)
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('competencyRadarChart').getContext('2d');
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Pretest', 'Posttest', 'Afektif', 'Psikomotor', 'Kehadiran'],
            datasets: [{
                label: 'Kompetensi Anda',
                data: [
                    {{ (float) $scores->nilai_pretest }},
                    {{ (float) $scores->nilai_posttest }},
                    {{ (float) $scores->nilai_afektif }},
                    {{ (float) $scores->nilai_psikomotor }},
                    {{ (float) $scores->nilai_kehadiran }}
                ],
                backgroundColor: 'rgba(26, 109, 155, 0.15)',
                borderColor: '#1A6D9B',
                pointBackgroundColor: '#1A6D9B',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#1A6D9B',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    angleLines: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    suggestedMin: 0,
                    suggestedMax: 100,
                    ticks: {
                        stepSize: 20,
                        font: { size: 9 }
                    },
                    pointLabels: {
                        font: {
                            family: "'Inter', sans-serif",
                            size: 11,
                            weight: 'bold'
                        },
                        color: '#4b5563'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endpush
@endif

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <x-page-header title="Hasil Penilaian" subtitle="Laporan kelulusan dan nilai akhir evaluasi" />

    @if($activeEvent)
        @if($scores && $scores->ranking)
            {{-- Graduation Celebration Banner --}}
            <div class="mt-8 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl relative overflow-hidden group mb-8">
                <div class="absolute top-0 right-0 w-80 h-80 bg-primary/20 rounded-full blur-[100px] -mr-40 -mt-40 animate-pulse"></div>
                <div class="absolute bottom-0 left-0 w-80 h-80 bg-accent/10 rounded-full blur-[100px] -ml-40 -mb-40"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                    <div class="flex-1 text-center md:text-left">
                        <p class="text-accent font-bold uppercase tracking-widest text-xs mb-3">PENGUMUMAN HASIL AKHIR</p>
                        <h3 class="text-4xl md:text-5xl font-heading font-extrabold mb-4 leading-tight">
                            Anda Meraih Predikat<br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent to-yellow-200">
                                {{ $scores->predikat }}
                            </span>
                        </h3>
                        <p class="text-gray-400 text-base mb-8 max-w-md">
                            Selamat! Berdasarkan pengolahan data menggunakan metode AHP & SAW, Anda dinyatakan <strong>{{ $scores->status_kelulusan }}</strong> dengan peringkat <strong>#{{ $scores->ranking }}</strong> dari seluruh peserta.
                        </p>
                        
                        @if(!str_contains($scores->status_kelulusan, 'Tidak Lulus') && !empty($scores->status_kelulusan))
                            @if($hasRtl)
                                <a href="{{ route('peserta.sertifikat.download', $activeEvent) }}" target="_blank"
                                   class="inline-flex items-center gap-3 px-8 py-4 bg-accent text-gray-900 rounded-2xl font-bold hover:bg-accent-300 transition-all shadow-xl shadow-accent/25 active:scale-95">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Unduh Sertifikat Resmi
                                </a>
                            @else
                                <div class="space-y-4">
                                    <div class="p-4 bg-amber-500/10 border border-amber-500/20 text-amber-200 rounded-2xl text-xs max-w-md">
                                        <strong>Pemberitahuan:</strong> Anda wajib mengisi Rencana Tindak Lanjut (RTL) terlebih dahulu untuk mengunduh sertifikat resmi.
                                    </div>
                                    <a href="{{ route('peserta.rtl.index', $activeEvent) }}"
                                       class="inline-flex items-center gap-2.5 px-6 py-3 bg-amber-500 text-gray-900 rounded-2xl font-bold hover:bg-amber-400 transition-all shadow-lg active:scale-95 text-sm">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                        Isi Rencana Tindak Lanjut (RTL)
                                    </a>
                                </div>
                            @endif
                        @endif
                    </div>
                    
                    <div class="flex-shrink-0 w-48 h-48 md:w-56 md:h-56 relative">
                        <div class="absolute inset-0 bg-accent/20 rounded-full blur-3xl animate-pulse"></div>
                        <img src="{{ asset('images/arka/arka_selebrasi.png') }}" alt="Celebration" class="relative z-10 w-full h-full object-contain">
                    </div>
                </div>
            </div>

            {{-- Score Details Card --}}
            <div class="bg-white rounded-[2.5rem] border border-gray-100 p-8 shadow-sm">
                <h3 class="text-xl font-heading font-bold text-gray-800 mb-6">Rincian Komponen Penilaian</h3>
                
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                    {{-- Pretest --}}
                    <div class="bg-gray-50 border border-gray-100 rounded-3xl p-5 text-center">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block mb-1">Pretest</span>
                        <span class="text-2xl font-black text-gray-800">{{ $scores->nilai_pretest }}</span>
                    </div>

                    {{-- Posttest --}}
                    <div class="bg-gray-50 border border-gray-100 rounded-3xl p-5 text-center">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block mb-1">Posttest</span>
                        <span class="text-2xl font-black text-gray-800">{{ $scores->nilai_posttest }}</span>
                    </div>

                    {{-- Afektif --}}
                    <div class="bg-gray-50 border border-gray-100 rounded-3xl p-5 text-center">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block mb-1">Afektif</span>
                        <span class="text-2xl font-black text-gray-800">{{ $scores->nilai_afektif }}</span>
                    </div>

                    {{-- Psikomotor --}}
                    <div class="bg-gray-50 border border-gray-100 rounded-3xl p-5 text-center">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block mb-1">Psikomotor</span>
                        <span class="text-2xl font-black text-gray-800">{{ $scores->nilai_psikomotor }}</span>
                    </div>

                    {{-- Kehadiran --}}
                    <div class="bg-gray-50 border border-gray-100 rounded-3xl p-5 text-center col-span-2 sm:col-span-1">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block mb-1">Kehadiran</span>
                        <span class="text-2xl font-black text-gray-800">{{ $scores->nilai_kehadiran }}</span>
                    </div>
                </div>

                {{-- Radar Chart & Kompetensi Analysis --}}
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8 items-center border-t border-b border-gray-100 py-8">
                    <div class="h-64 relative w-full">
                        <canvas id="competencyRadarChart"></canvas>
                    </div>
                    <div class="space-y-4">
                        <h4 class="font-heading font-bold text-gray-700 text-sm">Grafik Kompetensi Diri</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Grafik radar di samping memetakan pencapaian kompetensi Anda pada lima pilar penilaian Baitul Arqam. 
                            Garis yang mendekati tepi luar menunjukkan keunggulan pada pilar tersebut, sedangkan area yang condong ke dalam menandai aspek yang masih memerlukan pembinaan lebih lanjut.
                        </p>
                        <div class="bg-purple-50 rounded-xl p-4 border border-purple-100 text-purple-700 text-xs">
                            <strong>Analisis N-Gain Kognitif Anda:</strong> {{ number_format($scores->n_gain_score, 2) }} 
                            (Efektivitas: <strong class="underline">{{ $scores->n_gain_category }}</strong>)
                        </div>
                    </div>
                </div>

                <div class="mt-8 bg-primary-50 rounded-2xl p-6 border border-primary-100 flex items-start gap-4">
                    <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-primary-800">Catatan Metode SAW</h4>
                        <p class="text-xs text-primary-600 mt-1 leading-relaxed">
                            Skor akhir dihitung secara otomatis dengan membobot kelima aspek di atas menggunakan metode Simple Additive Weighting (SAW). Skor akhir SAW Anda adalah <strong>{{ $scores->skor_saw }}</strong>.
                        </p>
                    </div>
                </div>
            </div>
        @else
            {{-- Results Still processing --}}
            <div class="mt-8 bg-white border border-gray-100 rounded-[2.5rem] p-12 text-center shadow-sm">
                <div class="w-64 h-64 mx-auto mb-8 animate-pulse">
                    <img src="{{ asset('images/arka/arka_fokus.png') }}" alt="Processing" class="w-full h-full object-contain">
                </div>
                <h3 class="text-2xl font-heading font-bold text-gray-800 mb-2">Penilaian Sedang Diproses</h3>
                <p class="text-gray-500 max-w-md mx-auto leading-relaxed">
                    Panitia sedang memproses dan merekap nilai akhir menggunakan perhitungan AHP & SAW. Nilai kelulusan, peringkat, dan sertifikat Anda akan tampil di halaman ini setelah proses pengolahan nilai selesai. Terima kasih atas kesabaran Anda.
                </p>
            </div>
        @endif
    @else
        <div class="flex flex-col items-center justify-center py-20 text-center bg-white border border-gray-100 rounded-[2.5rem] mt-8 p-8">
            <div class="w-64 h-64 mb-8">
                <img src="{{ asset('images/arka/arka_fokus.png') }}" alt="No Event" class="w-full h-full object-contain opacity-50 grayscale">
            </div>
            <h2 class="text-3xl font-heading font-bold text-gray-800 mb-2">Belum Ada Acara Aktif</h2>
            <p class="text-gray-500 max-w-md mx-auto">Saat ini Anda belum terdaftar dalam Baitul Arqam yang sedang aktif. Silakan hubungi admin LP3A UMS jika terjadi kesalahan.</p>
        </div>
    @endif
</div>
@endsection
