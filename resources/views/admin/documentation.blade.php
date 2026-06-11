@extends('layouts.main')

@section('title', 'Dokumentasi Lengkap Sistem - ArqamApp')

@section('content')
<div class="space-y-8">
    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800 font-heading">Buku Panduan & Dokumentasi Lengkap</h1>
            <p class="text-sm text-gray-500 mt-1">Panduan akademis, alur operasional sistem, tabel parameter AHP-SAW, dan dokumentasi arsitektur sistem ArqamApp.</p>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Sticky Navigation Menu --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm sticky top-6 space-y-4">
                <h3 class="font-bold text-gray-800 font-heading text-xs uppercase tracking-wider text-primary">Daftar Materi</h3>
                <nav class="space-y-1.5">
                    <a href="#arsitektur" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold text-primary bg-primary/5 hover:bg-primary/5 transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                        1. Spesifikasi Sistem
                    </a>
                    <a href="#kriteria" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-primary hover:bg-gray-50 transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-transparent"></span>
                        2. Kriteria & Parameter
                    </a>
                    <a href="#kalkulasi-ahp" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-primary hover:bg-gray-50 transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-transparent"></span>
                        3. Perhitungan AHP
                    </a>
                    <a href="#kalkulasi-saw" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-primary hover:bg-gray-50 transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-transparent"></span>
                        4. Normalisasi SAW
                    </a>
                    <a href="#skema-predikat" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-primary hover:bg-gray-50 transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-transparent"></span>
                        5. Predikat Kelulusan
                    </a>
                    <a href="#skema-database" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-primary hover:bg-gray-50 transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-transparent"></span>
                        6. Skema Database
                    </a>
                    <a href="#langkah-penggunaan" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-primary hover:bg-gray-50 transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-transparent"></span>
                        7. Alur Kerja Pengguna
                    </a>
                </nav>
                <div class="pt-4 border-t border-gray-100">
                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Status Aplikasi</span>
                        <div class="flex items-center gap-1.5 mt-1">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-xs font-bold text-gray-700">Production Ready</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Scrollable Content --}}
        <div class="lg:col-span-3 space-y-8">
            {{-- 1. Spesifikasi Sistem --}}
            <div id="arsitektur" class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 font-heading">1. Spesifikasi Sistem</h2>
                        <p class="text-xs text-gray-400">Teknologi dan spesifikasi lingkungan perangkat lunak.</p>
                    </div>
                </div>
                <hr class="border-gray-100">
                <p class="text-sm text-gray-600 leading-relaxed">
                    <strong>ArqamApp</strong> merupakan Sistem Informasi Evaluasi Baitul Arqam berbasis web yang dirancang khusus untuk standarisasi penilaian pelatihan tingkat Universitas/Institusi secara terkomputerisasi.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-4">
                    <div class="border border-gray-100 rounded-2xl p-4 bg-gray-50">
                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Laravel Framework</h4>
                        <p class="text-[11px] text-gray-500 mt-1">Menggunakan Laravel 10/11 dengan arsitektur MVC, Eloquent ORM, dan pengamanan Session Auth.</p>
                    </div>
                    <div class="border border-gray-100 rounded-2xl p-4 bg-gray-50">
                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Desain UI Premium</h4>
                        <p class="text-[11px] text-gray-500 mt-1">Menggunakan Tailwind CSS v3 dengan HSL kustom, tipografi modern Inter/Outfit, dan transisi mikro interaktif.</p>
                    </div>
                    <div class="border border-gray-100 rounded-2xl p-4 bg-gray-50">
                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">QR Code Engine</h4>
                        <p class="text-[11px] text-gray-500 mt-1">Generator dan scanner QR Code instan tanpa aplikasi eksternal untuk mempercepat presensi peserta.</p>
                    </div>
                </div>
            </div>

            {{-- 2. Kriteria & Parameter --}}
            <div id="kriteria" class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 font-heading">2. Definisi Kriteria Penilaian</h2>
                        <p class="text-xs text-gray-400">Variabel input penilaian AHP-SAW.</p>
                    </div>
                </div>
                <hr class="border-gray-100">
                <p class="text-sm text-gray-600 leading-relaxed">
                    Sistem ini mendefinisikan 5 kriteria utama berjenis <strong>Benefit</strong> (Semakin tinggi nilainya, semakin baik) untuk dihitung ke dalam matriks keputusan:
                </p>
                <div class="overflow-x-auto border border-gray-100 rounded-2xl">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-800 font-bold">
                                <th class="p-4">Kode</th>
                                <th class="p-4">Nama Kriteria</th>
                                <th class="p-4">Deskripsi</th>
                                <th class="p-4">Tipe Kriteria</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-gray-600">
                            <tr>
                                <td class="p-4 font-mono font-bold text-primary">C1</td>
                                <td class="p-4 font-semibold">Pretest</td>
                                <td class="p-4">Mengukur pemahaman kognitif awal peserta sebelum materi disampaikan.</td>
                                <td class="p-4 font-bold text-emerald-600">Benefit</td>
                            </tr>
                            <tr>
                                <td class="p-4 font-mono font-bold text-primary">C2</td>
                                <td class="p-4 font-semibold">Posttest</td>
                                <td class="p-4">Mengukur pemahaman kognitif akhir peserta setelah seluruh rangkaian materi selesai.</td>
                                <td class="p-4 font-bold text-emerald-600">Benefit</td>
                            </tr>
                            <tr>
                                <td class="p-4 font-mono font-bold text-primary">C3</td>
                                <td class="p-4 font-semibold">Afektif</td>
                                <td class="p-4">Mengukur sikap, moral, kepribadian, dan kepatuhan norma ibadah selama pelatihan.</td>
                                <td class="p-4 font-bold text-emerald-600">Benefit</td>
                            </tr>
                            <tr>
                                <td class="p-4 font-mono font-bold text-primary">C4</td>
                                <td class="p-4 font-semibold">Psikomotorik</td>
                                <td class="p-4">Mengukur keterampilan praktik ibadah (wudhu, tayamum, sholat, baca Al-Qur'an, dll).</td>
                                <td class="p-4 font-bold text-emerald-600">Benefit</td>
                            </tr>
                            <tr>
                                <td class="p-4 font-mono font-bold text-primary">C5</td>
                                <td class="p-4 font-semibold">Kehadiran</td>
                                <td class="p-4">Mengukur tingkat partisipasi kehadiran (presensi) peserta pada seluruh sesi materi.</td>
                                <td class="p-4 font-bold text-emerald-600">Benefit</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 3. Perhitungan AHP --}}
            <div id="kalkulasi-ahp" class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-yellow-400/20 text-yellow-500 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2a2 2 0 00-2 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 font-heading">3. Metode AHP (Analytical Hierarchy Process)</h2>
                        <p class="text-xs text-gray-400">Pencarian bobot prioritas kriteria dengan uji konsistensi.</p>
                    </div>
                </div>
                <hr class="border-gray-100">
                
                <div class="space-y-4 text-sm text-gray-600 leading-relaxed">
                    <p>
                        AHP digunakan untuk memperoleh bobot prioritas masing-masing kriteria. Matriks perbandingan berpasangan dibangun dari masukan nilai berpasangan oleh Admin, dengan diagonal utama bernilai 1.
                    </p>

                    <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 space-y-4">
                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">1. Matriks Perbandingan Berpasangan:</h4>
                        <p class="text-xs">
                            Jika kriteria A memiliki tingkat kepentingan <code>x</code> kali lebih penting dari kriteria B, maka sel <code>A-B</code> diisi dengan <code>x</code>, dan sel <code>B-A</code> diisi dengan nilai kebalikannya yaitu <code>1/x</code>.
                        </p>

                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">2. Konsistensi Matriks (Consistency Index - CI & Consistency Ratio - CR):</h4>
                        <p class="text-xs">
                            Untuk menjamin keabsahan penilaian, dilakukan pengujian rasio konsistensi matriks perbandingan dengan rumus:
                        </p>
                        <div class="p-3 bg-white border border-gray-100 rounded-xl font-mono text-center text-sm">
                            CI = (&lambda;<sub>max</sub> - n) / (n - 1) &nbsp;&bull;&nbsp; CR = CI / RI
                        </div>
                        <p class="text-xs text-gray-500">
                            Dimana <strong>&lambda;<sub>max</sub></strong> merupakan nilai eigen terbesar, <strong>n</strong> adalah jumlah kriteria (n=5), dan <strong>RI</strong> adalah Random Consistency Index.
                        </p>
                        
                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Tabel Nilai RI (Random Index):</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs border border-gray-100 rounded-xl">
                                <thead>
                                    <tr class="bg-white border-b border-gray-100 font-bold text-gray-700">
                                        <th class="p-2">n (Kriteria)</th>
                                        <th class="p-2">1</th>
                                        <th class="p-2">2</th>
                                        <th class="p-2">3</th>
                                        <th class="p-2">4</th>
                                        <th class="p-2">5</th>
                                        <th class="p-2">6</th>
                                        <th class="p-2">7</th>
                                        <th class="p-2">8</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="font-mono bg-white text-gray-600">
                                        <td class="p-2 font-bold bg-gray-50">RI</td>
                                        <td class="p-2">0.00</td>
                                        <td class="p-2">0.00</td>
                                        <td class="p-2 font-bold text-primary">0.58</td>
                                        <td class="p-2">0.90</td>
                                        <td class="p-2 font-bold text-emerald-600 bg-emerald-50">1.12</td>
                                        <td class="p-2">1.24</td>
                                        <td class="p-2">1.32</td>
                                        <td class="p-2">1.41</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-xs text-slate-500 mt-2">
                            Untuk kriteria berjumlah 5 (n=5), nilai RI yang digunakan adalah <strong>1.12</strong>. Hasil perhitungan dinyatakan valid/konsisten secara ilmiah apabila <strong>CR &le; 0.1 (10%)</strong>.
                        </p>
                    </div>
                </div>
            </div>

            {{-- 4. Perhitungan SAW --}}
            <div id="kalkulasi-saw" class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-cyan-400/20 text-cyan-500 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 font-heading">4. Metode SAW (Simple Additive Weighting)</h2>
                        <p class="text-xs text-gray-400">Peringkat preferensi dengan normalisasi bertipe Benefit.</p>
                    </div>
                </div>
                <hr class="border-gray-100">
                
                <div class="space-y-4 text-sm text-gray-600 leading-relaxed">
                    <p>
                        Setelah diperoleh bobot kriteria AHP (W<sub>j</sub>), sistem menghitung skor kelulusan alternatif (peserta) dengan tahapan metode SAW:
                    </p>

                    <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 space-y-4">
                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">1. Normalisasi Matriks Keputusan (Rumus Benefit):</h4>
                        <div class="p-3 bg-white border border-gray-100 rounded-xl font-mono text-center text-sm">
                            r<sub>ij</sub> = x<sub>ij</sub> / Max<sub>i</sub>(x<sub>ij</sub>)
                        </div>
                        <p class="text-xs text-gray-500">
                            Dimana nilai asli kriteria peserta dibagi dengan nilai tertinggi yang ada di kelompok peserta tersebut pada kriteria yang bersangkutan.
                        </p>

                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">2. Penjumlahan Nilai Preferensi (V<sub>i</sub>):</h4>
                        <div class="p-3 bg-white border border-gray-100 rounded-xl font-mono text-center text-sm">
                            V<sub>i</sub> = &Sigma;<sub>j=1</sub><sup>n</sup> W<sub>j</sub> &times; r<sub>ij</sub>
                        </div>
                        <p class="text-xs text-gray-500">
                            Nilai normalisasi dikalikan dengan bobot kriteria dari AHP, kemudian seluruh hasil perkalian kriteria (C1-C5) dijumlahkan untuk mendapatkan skor akhir SAW.
                        </p>
                    </div>
                </div>
            </div>

            {{-- 5. Klasifikasi Predikat --}}
            <div id="skema-predikat" class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 font-heading">5. Ambang Batas Predikat & Kelulusan</h2>
                        <p class="text-xs text-gray-400">Pengelompokan otomatis berdasarkan skor preferensi SAW.</p>
                    </div>
                </div>
                <hr class="border-gray-100">
                <p class="text-sm text-gray-600 leading-relaxed">
                    Sistem akan mengklasifikasikan predikat dan status kelulusan peserta berdasarkan nilai preferensi akhir SAW (skor V<sub>i</sub>):
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Predikat --}}
                    <div class="border border-gray-100 rounded-2xl overflow-hidden">
                        <div class="bg-gray-50 p-3 font-bold text-xs text-gray-700 border-b border-gray-100">Kategori Predikat Nilai</div>
                        <table class="w-full text-left text-xs">
                            <tbody class="divide-y divide-gray-100 text-gray-600">
                                <tr>
                                    <td class="p-3 font-mono font-semibold">&ge; 0.85</td>
                                    <td class="p-3 text-emerald-600 font-bold">Amat Baik</td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-mono font-semibold">&ge; 0.70</td>
                                    <td class="p-3 text-blue-600 font-bold">Baik</td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-mono font-semibold">&ge; 0.55</td>
                                    <td class="p-3 text-yellow-600 font-bold">Cukup</td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-mono font-semibold">&lt; 0.55</td>
                                    <td class="p-3 text-red-600 font-bold">Kurang</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Status Kelulusan --}}
                    <div class="border border-gray-100 rounded-2xl overflow-hidden">
                        <div class="bg-gray-50 p-3 font-bold text-xs text-gray-700 border-b border-gray-100">Status Kelulusan</div>
                        <table class="w-full text-left text-xs">
                            <tbody class="divide-y divide-gray-100 text-gray-600">
                                <tr>
                                    <td class="p-3 font-mono font-semibold">&ge; 0.80</td>
                                    <td class="p-3 text-emerald-600 font-bold">Lulus Sangat Memuaskan</td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-mono font-semibold">&ge; 0.70</td>
                                    <td class="p-3 text-blue-600 font-bold">Lulus Memuaskan</td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-mono font-semibold">&ge; 0.60</td>
                                    <td class="p-3 text-yellow-600 font-bold">Lulus</td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-mono font-semibold">&lt; 0.60</td>
                                    <td class="p-3 text-red-600 font-bold">Tidak Lulus</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 6. Skema Database --}}
            <div id="skema-database" class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 font-heading">6. Skema Database Relasional</h2>
                        <p class="text-xs text-gray-400">Definisi tabel database yang terintegrasi di dalam sistem.</p>
                    </div>
                </div>
                <hr class="border-gray-100">

                <div class="space-y-4 text-sm text-gray-600">
                    <p>
                        Struktur database dirancang secara berelasi penuh untuk menjaga sinkronisasi data antar-tabel evaluasi:
                    </p>

                    <div class="overflow-x-auto border border-gray-100 rounded-2xl">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100 text-gray-800 font-bold">
                                    <th class="p-4">Nama Tabel</th>
                                    <th class="p-4">Kolom Penting</th>
                                    <th class="p-4">Tipe & Keterangan Relasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr>
                                    <td class="p-4 font-semibold text-gray-800">events</td>
                                    <td class="p-4 font-mono text-gray-500">id, nama_event, tgl_mulai, token_registrasi</td>
                                    <td class="p-4 text-xs">Menyimpan data induk pelaksanaan Baitul Arqam.</td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-semibold text-gray-800">peserta</td>
                                    <td class="p-4 font-mono text-gray-500">id, nama_lengkap, unit_kerja, status_aktif</td>
                                    <td class="p-4 text-xs">Mencatat profil lengkap peserta yang didaftarkan.</td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-semibold text-gray-800">ahp_bobots</td>
                                    <td class="p-4 font-mono text-gray-500">event_id, bobot_c1..c5, cr_value, is_consistent</td>
                                    <td class="p-4 text-xs">Menyimpan data bobot kriteria AHP hasil perbandingan. Relasi <code>One-to-One</code> ke <code>events</code>.</td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-semibold text-gray-800">penilaian_akhirs</td>
                                    <td class="p-4 font-mono text-gray-500">peserta_id, nilai_pretest..nilai_kehadiran, skor_saw, ranking</td>
                                    <td class="p-4 text-xs">Mencatat perolehan nilai, skor SAW, predikat, dan peringkat. Relasi <code>Many-to-One</code> ke <code>peserta</code>.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 7. Alur Kerja Pengguna --}}
            <div id="langkah-penggunaan" class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 font-heading">7. Alur Kerja Penggunaan Sistem (Buku Panduan Operator)</h2>
                        <p class="text-xs text-gray-400">Langkah operasional yang runtut untuk mengelola event.</p>
                    </div>
                </div>
                <hr class="border-gray-100">

                <div class="space-y-6 text-sm text-gray-600">
                    <div class="flex items-start gap-4">
                        <span class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold shrink-0">1</span>
                        <div>
                            <h4 class="font-bold text-gray-800">Pembuatan Event & Import Peserta</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Buat event Baitul Arqam baru di menu "Kelola Event", lalu gunakan fitur "Import Peserta" via Excel untuk mendaftarkan nama secara massal.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <span class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold shrink-0">2</span>
                        <div>
                            <h4 class="font-bold text-gray-800">Menyusun Sesi & Jadwal Materi</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Tambahkan sesi-sesi kajian/jadwal materi pada event untuk mengaktifkan pemindaian kehadiran (absensi QR Code).</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <span class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold shrink-0">3</span>
                        <div>
                            <h4 class="font-bold text-gray-800">Mengisi Butir Soal & Melaksanakan Tes</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Kelola bank soal untuk Pretest & Posttest. Peserta akan mengerjakan ujian secara mandiri melalui panel akun peserta masing-masing.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <span class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold shrink-0">4</span>
                        <div>
                            <h4 class="font-bold text-gray-800">Penilaian Afektif & Psikomotorik</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Fasilitator/Penguji menginput nilai praktik ibadah (C4) dan sikap afektif peserta (C3) melalui halaman event yang bersangkutan.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <span class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold shrink-0">5</span>
                        <div>
                            <h4 class="font-bold text-gray-800">Penghitungan AHP & Ranking Akhir SAW</h4>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Terakhir, atur prioritas kriteria pada form AHP (kombinasi matriks perbandingan). Pastikan statusnya "Konsisten (CR &le; 10%)", kemudian jalankan tombol "Hitung Ranking SAW" untuk mengalkulasi nilai akhir peserta.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
