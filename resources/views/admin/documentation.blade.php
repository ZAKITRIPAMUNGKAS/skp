@extends('layouts.main')

@section('title', 'Dokumentasi Sistem - ArqamApp')

@section('content')
<div class="space-y-6" x-data="{ activePage: 'spesifikasi' }">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800 font-heading">Dokumentasi & Panduan Pengembang</h1>
                <p class="text-sm text-gray-500 mt-1">Pusat dokumentasi sistem informasi pendukung keputusan evaluasi Baitul Arqam secara komprehensif.</p>
            </div>
        </div>
        
        {{-- Quick status badge --}}
        <div class="flex items-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-2xl text-xs font-semibold self-start md:self-auto">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>v2.0 (Stable)</span>
        </div>
    </div>

    {{-- Main Layout grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Navigation sidebar --}}
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-6">
                <div>
                    <h3 class="font-bold text-gray-400 font-heading text-[10px] uppercase tracking-wider">Daftar Dokumentasi</h3>
                    <p class="text-[11px] text-gray-500 mt-0.5">Pilih modul dokumentasi di bawah ini:</p>
                </div>

                <nav class="space-y-1.5">
                    {{-- 1. Spesifikasi Sistem --}}
                    <button @click="activePage = 'spesifikasi'" 
                            :class="activePage === 'spesifikasi' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span class="truncate">1. Spesifikasi Sistem</span>
                    </button>

                    {{-- 2. Kriteria & Parameter --}}
                    <button @click="activePage = 'kriteria'" 
                            :class="activePage === 'kriteria' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span class="truncate">2. Kriteria & Parameter</span>
                    </button>

                    {{-- 3. Perhitungan AHP --}}
                    <button @click="activePage = 'ahp'" 
                            :class="activePage === 'ahp' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2a2 2 0 00-2 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="truncate">3. Perhitungan AHP</span>
                    </button>

                    {{-- 4. Normalisasi SAW --}}
                    <button @click="activePage = 'saw'" 
                            :class="activePage === 'saw' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="truncate">4. Normalisasi SAW</span>
                    </button>

                    {{-- 5. Predikat Kelulusan --}}
                    <button @click="activePage = 'predikat'" 
                            :class="activePage === 'predikat' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="truncate">5. Predikat Kelulusan</span>
                    </button>

                    {{-- 6. Skema Database --}}
                    <button @click="activePage = 'database'" 
                            :class="activePage === 'database' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                        <span class="truncate">6. Skema Database</span>
                    </button>

                    {{-- 7. Alur Kerja Pengguna --}}
                    <button @click="activePage = 'alur'" 
                            :class="activePage === 'alur' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="truncate">7. Alur Kerja Pengguna</span>
                    </button>
                </nav>
            </div>
        </div>

        {{-- Page content rendering --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm min-h-[550px] text-gray-600 leading-relaxed">
                
                {{-- Page 1: Spesifikasi Sistem --}}
                <div x-show="activePage === 'spesifikasi'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-1 rounded-md">Lingkungan Pengembangan</span>
                        <h2 class="text-xl font-bold text-gray-800 font-heading mt-2">1. Spesifikasi Perangkat Lunak & Sistem</h2>
                        <p class="text-xs text-gray-400">Persyaratan sistem, teknologi engine dasar, dan pustaka dependensi pihak ketiga.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-4 text-sm">
                        <p>
                            Sistem Informasi Pendukung Keputusan Evaluasi Baitul Arqam ini diimplementasikan dengan arsitektur modern yang menjamin skalabilitas, kecepatan eksekusi algoritma, serta keamanan data relasional.
                        </p>
                        
                        <h3 class="font-bold text-gray-800 text-sm mt-6 uppercase tracking-wider">Persyaratan Minimum Server (System Requirements):</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 space-y-1">
                                <span class="text-[10px] font-bold text-gray-400 uppercase">Server-Side Stack</span>
                                <ul class="list-disc pl-4 text-xs text-gray-600 space-y-1">
                                    <li>PHP >= 8.1 dengan ekstensi BCMath, Ctype, OpenSSL, PDO, Tokenizer, XML, GD, Mbstring.</li>
                                    <li>Web Server Apache HTTP Server atau Nginx.</li>
                                    <li>MySQL Database Server >= 8.0 / MariaDB >= 10.4.</li>
                                </ul>
                            </div>
                            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 space-y-1">
                                <span class="text-[10px] font-bold text-gray-400 uppercase">Client-Side Engine</span>
                                <ul class="list-disc pl-4 text-xs text-gray-600 space-y-1">
                                    <li>Modern Web Browser (Chrome, Firefox, Safari, Edge) berkemampuan kamera aktif untuk pembacaan QR Code.</li>
                                    <li>Koneksi HTTPS (wajib diaktifkan di production untuk mengizinkan akses hardware kamera webcam).</li>
                                </ul>
                            </div>
                        </div>

                        <h3 class="font-bold text-gray-800 text-sm mt-6 uppercase tracking-wider font-heading">Pustaka Dependensi Penting (Core Libraries):</h3>
                        <div class="overflow-x-auto border border-gray-100 rounded-2xl">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-800 font-bold">
                                        <th class="p-4">Nama Pustaka</th>
                                        <th class="p-4">Kegunaan & Penerapan Sistem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-gray-50">
                                        <td class="p-4 font-mono font-semibold text-gray-800">simplesoftwareio/simple-qrcode</td>
                                        <td class="p-4 text-gray-500">Membangun gambar QR Code secara dinamis untuk kartu identitas peserta yang terintegrasi di database.</td>
                                    </tr>
                                    <tr class="border-b border-gray-50">
                                        <td class="p-4 font-mono font-semibold text-gray-800">maatwebsite/excel</td>
                                        <td class="p-4 text-gray-500">Memproses berkas template Excel untuk impor data peserta secara massal maupun ekspor laporan akhir.</td>
                                    </tr>
                                    <tr class="border-b border-gray-50">
                                        <td class="p-4 font-mono font-semibold text-gray-800">barryvdh/laravel-dompdf</td>
                                        <td class="p-4 text-gray-500">Merender file PDF secara server-side untuk pembuatan sertifikat digital dan lembar fisik laporan nilai kelulusan.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Page 2: Kriteria & Parameter --}}
                <div x-show="activePage === 'kriteria'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-1 rounded-md">Variabel Keputusan</span>
                        <h2 class="text-xl font-bold text-gray-800 font-heading mt-2">2. Kriteria & Parameter Penilaian</h2>
                        <p class="text-xs text-gray-400">Struktur kriteria pembentuk nilai preferensi SAW, skala nilai, dan matriks parameter keputusan.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-4 text-sm">
                        <p>
                            Perankingan peserta didasarkan pada 5 kriteria dasar yang mewakili tiga aspek evaluasi pendidikan (Kognitif, Afektif, Psikomotorik) serta aspek kedisiplinan (Kehadiran):
                        </p>

                        <div class="space-y-3 mt-4">
                            <div class="flex items-start gap-4 p-4 border border-gray-100 rounded-2xl hover:border-primary/20 transition-colors">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0">C1</div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Pretest (Bobot Kognitif Awal)</h4>
                                    <p class="text-xs text-gray-500 mt-1">Ujian tertulis/online pilihan ganda yang dikerjakan peserta sebelum materi dimulai. Rentang nilai: 0 - 100.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 p-4 border border-gray-100 rounded-2xl hover:border-primary/20 transition-colors">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0">C2</div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Posttest (Bobot Kognitif Akhir)</h4>
                                    <p class="text-xs text-gray-500 mt-1">Ujian evaluasi akhir tertulis untuk melihat peningkatan pengetahuan peserta setelah materi selesai. Rentang nilai: 0 - 100.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 p-4 border border-gray-100 rounded-2xl hover:border-primary/20 transition-colors">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0">C3</div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Afektif (Penilaian Karakter & Sikap)</h4>
                                    <p class="text-xs text-gray-500 mt-1">Diinput oleh Fasilitator pendamping kelompok. Mengukur kedisiplinan sholat berjamaah, akhlak sosial, kesopanan, dan keaktifan diskusi kelompok. Rentang nilai: 0 - 100.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 p-4 border border-gray-100 rounded-2xl hover:border-primary/20 transition-colors">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0">C4</div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Psikomotorik (Kemampuan Praktik Ibadah)</h4>
                                    <p class="text-xs text-gray-500 mt-1">Mengukur kelancaran melafalkan ayat Al-Qur'an (tajwid), gerakan wudhu, tayamum, dan tata cara sholat wajib sesuai ketentuan tarjih. Rentang nilai: 0 - 100.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 p-4 border border-gray-100 rounded-2xl hover:border-primary/20 transition-colors">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0">C5</div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Kehadiran (Presensi Materi Sesi)</h4>
                                    <p class="text-xs text-gray-500 mt-1">Persentase kehadiran pada semua materi terjadwal. Kehadiran dihitung dari akumulasi presensi scan QR Code.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Page 3: Perhitungan AHP --}}
                <div x-show="activePage === 'ahp'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-1 rounded-md">Teori AHP</span>
                        <h2 class="text-xl font-bold text-gray-800 font-heading mt-2">3. Pembobotan Kriteria Dengan AHP</h2>
                        <p class="text-xs text-gray-400">Algoritma perbandingan berpasangan Saaty, eigenvector, lambda max, dan rasio konsistensi.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-4 text-sm leading-relaxed text-gray-600">
                        <p>
                            Metode <strong>Analytical Hierarchy Process (AHP)</strong> digunakan untuk menentukan bobot kriteria secara adil berdasarkan perbandingan kepentingan berpasangan. Berikut adalah langkah matematis terperinci yang dieksekusi oleh sistem:
                        </p>

                        <h3 class="font-bold text-gray-800 text-xs uppercase tracking-wider mt-4">1. Skala Penilaian Perbandingan Berpasangan (Saaty Scale):</h3>
                        <div class="overflow-x-auto border border-gray-100 rounded-2xl">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-800 font-bold">
                                        <th class="p-3">Intensitas Kepentingan</th>
                                        <th class="p-3">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-gray-50">
                                        <td class="p-3 font-bold">1</td>
                                        <td class="p-3">Kedua kriteria sama pentingnya (Equally important).</td>
                                    </tr>
                                    <tr class="border-b border-gray-50">
                                        <td class="p-3 font-bold">3</td>
                                        <td class="p-3">Kriteria yang satu sedikit lebih penting dari kriteria yang lain.</td>
                                    </tr>
                                    <tr class="border-b border-gray-50">
                                        <td class="p-3 font-bold">5</td>
                                        <td class="p-3">Kriteria yang satu jelas lebih penting dari kriteria yang lain.</td>
                                    </tr>
                                    <tr class="border-b border-gray-50">
                                        <td class="p-3 font-bold">7</td>
                                        <td class="p-3">Kriteria yang satu terbukti sangat lebih penting dari kriteria yang lain.</td>
                                    </tr>
                                    <tr class="border-b border-gray-50">
                                        <td class="p-3 font-bold">9</td>
                                        <td class="p-3">Kriteria yang satu mutlak lebih penting dari kriteria yang lain.</td>
                                    </tr>
                                    <tr class="border-b border-gray-50">
                                        <td class="p-3 font-bold">2, 4, 6, 8</td>
                                        <td class="p-3">Nilai kompromi/tengah antara dua pendapat yang berdekatan.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h3 class="font-bold text-gray-800 text-xs uppercase tracking-wider mt-6">2. Perhitungan Rasio Konsistensi (Consistency Ratio):</h3>
                        <p class="text-xs">
                            Sistem menghitung nilai indeks konsistensi (CI) dan rasio konsistensi (CR) untuk memvalidasi masukan pembobotan:
                        </p>
                        <div class="p-4 bg-gray-50 border border-gray-100 rounded-2xl space-y-2 text-xs">
                            <p><strong>Langkah A:</strong> Cari nilai Eigen terbesar (&lambda;<sub>max</sub>) dari perkalian matriks asli dengan bobot.</p>
                            <p><strong>Langkah B:</strong> Hitung Indeks Konsistensi: <code>CI = (&lambda;<sub>max</sub> - n) / (n - 1)</code>, dimana n = 5.</p>
                            <p><strong>Langkah C:</strong> Hitung Rasio Konsistensi: <code>CR = CI / RI</code>. Nilai Random Index (RI) untuk n=5 adalah <strong>1.12</strong>.</p>
                            <p class="font-bold text-primary mt-2">Apabila nilai CR &le; 0.1, maka matriks dinyatakan konsisten dan bobot kriteria aman disimpan ke database.</p>
                        </div>
                    </div>
                </div>

                {{-- Page 4: Normalisasi SAW --}}
                <div x-show="activePage === 'saw'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-1 rounded-md">Teori SAW</span>
                        <h2 class="text-xl font-bold text-gray-800 font-heading mt-2">4. Metode SAW (Simple Additive Weighting)</h2>
                        <p class="text-xs text-gray-400">Normalisasi data kriteria benefit dan akumulasi nilai preferensi peserta.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-4 text-sm text-gray-600 leading-relaxed">
                        <p>
                            Metode SAW (sering dikenal sebagai penjumlahan terbobot) menormalisasi matriks keputusan untuk meratakan skala data nilai yang bervariasi menjadi rentang angka desimal antara 0 sampai 1.
                        </p>

                        <h3 class="font-bold text-gray-800 text-xs uppercase tracking-wider mt-4">1. Tahapan Normalisasi Benefit:</h3>
                        <p class="text-xs">
                            Karena seluruh kriteria (C1-C5) adalah bernilai positif bagi kelulusan (Benefit), maka rumus normalisasi yang diimplementasikan adalah:
                        </p>
                        <div class="p-4 bg-gray-50 border border-gray-100 rounded-2xl text-center font-mono text-sm">
                            r<sub>ij</sub> = x<sub>ij</sub> / Max(x<sub>j</sub>)
                        </div>
                        <p class="text-xs text-gray-500">
                            Dimana:
                            <br>&bull; <code>r<sub>ij</sub></code> = Hasil normalisasi nilai peserta ke-i untuk kriteria ke-j.
                            <br>&bull; <code>x<sub>ij</sub></code> = Nilai asli peserta ke-i pada kriteria ke-j.
                            <br>&bull; <code>Max(x<sub>j</sub>)</code> = Nilai tertinggi yang didapatkan oleh salah satu peserta pada kriteria ke-j.
                        </p>

                        <h3 class="font-bold text-gray-800 text-xs uppercase tracking-wider mt-6">2. Perhitungan Skor Akhir (Skor Preferensi V<sub>i</sub>):</h3>
                        <div class="p-4 bg-gray-50 border border-gray-100 rounded-2xl text-center font-mono text-sm">
                            V<sub>i</sub> = W<sub>1</sub>(r<sub>i1</sub>) + W<sub>2</sub>(r<sub>i2</sub>) + W<sub>3</sub>(r<sub>i3</sub>) + W<sub>4</sub>(r<sub>i4</sub>) + W<sub>5</sub>(r<sub>i5</sub>)
                        </div>
                        <p class="text-xs text-gray-500">
                            Di mana W<sub>1</sub>..W<sub>5</sub> merupakan bobot kriteria hasil perhitungan AHP yang valid. Skor V<sub>i</sub> yang diperoleh digunakan sebagai nilai acuan penentu kelulusan dan pemeringkat.
                        </p>
                    </div>
                </div>

                {{-- Page 5: Predikat Kelulusan --}}
                <div x-show="activePage === 'predikat'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-1 rounded-md">Aturan Kelulusan</span>
                        <h2 class="text-xl font-bold text-gray-800 font-heading mt-2">5. Rubrik Predikat Nilai & Status Kelulusan</h2>
                        <p class="text-xs text-gray-400">Penggolongan otomatis berbasis nilai preferensi preferensi SAW.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-4 text-sm text-gray-600 leading-relaxed">
                        <p>
                            Sistem akan secara otomatis membagi predikat (kategori nilai) dan status kelulusan peserta berdasarkan nilai preferensi SAW ($V_i$) yang diperoleh peserta:
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            {{-- Predikat --}}
                            <div class="border border-gray-100 rounded-3xl overflow-hidden bg-white shadow-sm">
                                <div class="bg-gray-50 p-4 font-bold text-xs text-gray-700 border-b border-gray-100">Klasifikasi Predikat Nilai</div>
                                <table class="w-full text-left text-xs border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50/50 border-b border-gray-100 font-bold text-gray-600">
                                            <th class="p-3">Range Nilai V<sub>i</sub></th>
                                            <th class="p-3">Kategori Predikat</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <tr>
                                            <td class="p-3 font-mono font-semibold text-gray-700">&ge; 0.85</td>
                                            <td class="p-3 font-bold text-emerald-600">Amat Baik</td>
                                        </tr>
                                        <tr>
                                            <td class="p-3 font-mono font-semibold text-gray-700">&ge; 0.70</td>
                                            <td class="p-3 font-bold text-blue-600">Baik</td>
                                        </tr>
                                        <tr>
                                            <td class="p-3 font-mono font-semibold text-gray-700">&ge; 0.55</td>
                                            <td class="p-3 font-bold text-yellow-600">Cukup</td>
                                        </tr>
                                        <tr>
                                            <td class="p-3 font-mono font-semibold text-gray-700">&lt; 0.55</td>
                                            <td class="p-3 font-bold text-red-600">Kurang</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- Kelulusan --}}
                            <div class="border border-gray-100 rounded-3xl overflow-hidden bg-white shadow-sm">
                                <div class="bg-gray-50 p-4 font-bold text-xs text-gray-700 border-b border-gray-100">Klasifikasi Status Kelulusan</div>
                                <table class="w-full text-left text-xs border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50/50 border-b border-gray-100 font-bold text-gray-600">
                                            <th class="p-3">Range Nilai V<sub>i</sub></th>
                                            <th class="p-3">Kategori Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <tr>
                                            <td class="p-3 font-mono font-semibold text-gray-700">&ge; 0.80</td>
                                            <td class="p-3 font-bold text-emerald-600">Lulus Sangat Memuaskan</td>
                                        </tr>
                                        <tr>
                                            <td class="p-3 font-mono font-semibold text-gray-700">&ge; 0.70</td>
                                            <td class="p-3 font-bold text-blue-600">Lulus Memuaskan</td>
                                        </tr>
                                        <tr>
                                            <td class="p-3 font-mono font-semibold text-gray-700">&ge; 0.60</td>
                                            <td class="p-3 font-bold text-yellow-600">Lulus</td>
                                        </tr>
                                        <tr>
                                            <td class="p-3 font-mono font-semibold text-gray-700">&lt; 0.60</td>
                                            <td class="p-3 font-bold text-red-600">Tidak Lulus</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Page 6: Skema Database --}}
                <div x-show="activePage === 'database'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-1 rounded-md">Skema Relasi</span>
                        <h2 class="text-xl font-bold text-gray-800 font-heading mt-2">6. Skema Relasi Database</h2>
                        <p class="text-xs text-gray-400">Tabel master database MySQL, tipe data, kunci primer, dan kunci asing.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-4 text-sm text-gray-600 leading-relaxed">
                        <p>
                            Integritas data kriteria dan hasil perhitungan AHP-SAW dijaga melalui relasi tabel terstruktur:
                        </p>

                        <div class="space-y-6 mt-4">
                            {{-- Table 1 --}}
                            <div class="border border-gray-100 rounded-3xl p-6 space-y-3 bg-gray-50/50">
                                <h4 class="font-bold text-gray-800 font-mono text-sm">Tabel: events</h4>
                                <ul class="list-disc pl-5 text-xs text-gray-500 space-y-1.5">
                                    <li><code>id</code> (bigint, PK, auto-increment): ID Unik Event.</li>
                                    <li><code>nama_event</code> (varchar): Judul pelaksanaan Baitul Arqam.</li>
                                    <li><code>tgl_mulai</code> & <code>tgl_selesai</code> (date): Rentang pelaksanaan event.</li>
                                    <li><code>token_registrasi</code> (varchar): Token pendaftaran mandiri bagi peserta.</li>
                                </ul>
                            </div>

                            {{-- Table 2 --}}
                            <div class="border border-gray-100 rounded-3xl p-6 space-y-3 bg-gray-50/50">
                                <h4 class="font-bold text-gray-800 font-mono text-sm">Tabel: peserta</h4>
                                <ul class="list-disc pl-5 text-xs text-gray-500 space-y-1.5">
                                    <li><code>id</code> (bigint, PK, auto-increment): ID Unik Peserta.</li>
                                    <li><code>nama_lengkap</code> (varchar): Nama lengkap peserta beserta gelar.</li>
                                    <li><code>nik</code> & <code>no_telepon</code> (varchar): Data pelengkap pendaftaran.</li>
                                    <li><code>unit_kerja</code> (varchar): Fakultas / Unit instansi pengutus.</li>
                                </ul>
                            </div>

                            {{-- Table 3 --}}
                            <div class="border border-gray-100 rounded-3xl p-6 space-y-3 bg-gray-50/50">
                                <h4 class="font-bold text-gray-800 font-mono text-sm">Tabel: ahp_bobots</h4>
                                <ul class="list-disc pl-5 text-xs text-gray-500 space-y-1.5">
                                    <li><code>id</code> (bigint, PK, auto-increment): ID Pembobotan.</li>
                                    <li><code>event_id</code> (bigint, FK): Berelasi ke <code>events.id</code>.</li>
                                    <li><code>bobot_c1</code> s/d <code>bobot_c5</code> (double): Nilai bobot prioritas hasil perhitungan AHP.</li>
                                    <li><code>cr_value</code> (double): Rasio konsistensi matriks perbandingan berpasangan.</li>
                                </ul>
                            </div>

                            {{-- Table 4 --}}
                            <div class="border border-gray-100 rounded-3xl p-6 space-y-3 bg-gray-50/50">
                                <h4 class="font-bold text-gray-800 font-mono text-sm">Tabel: penilaian_akhirs</h4>
                                <ul class="list-disc pl-5 text-xs text-gray-500 space-y-1.5">
                                    <li><code>id</code> (bigint, PK): ID Penilaian.</li>
                                    <li><code>event_id</code> (bigint, FK) & <code>peserta_id</code> (bigint, FK).</li>
                                    <li><code>nilai_pretest</code> s/d <code>nilai_kehadiran</code> (double): Nilai kriteria mentah.</li>
                                    <li><code>skor_saw</code> (double): Nilai preferensi akhir ($V_i$) hasil perhitungan SAW.</li>
                                    <li><code>ranking</code> (integer): Peringkat kelulusan peserta.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Page 7: Alur Kerja Pengguna --}}
                <div x-show="activePage === 'alur'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-1 rounded-md">Alur Operasional</span>
                        <h2 class="text-xl font-bold text-gray-800 font-heading mt-2">7. Panduan Runtut Alur Penggunaan Sistem</h2>
                        <p class="text-xs text-gray-400">Panduan operasional harian bagi operator/admin dalam mengelola pelaksanaan Baitul Arqam.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-6 text-sm text-gray-600">
                        <p>
                            Untuk melakukan evaluasi pelatihan Baitul Arqam dari awal hingga akhir, operator sistem wajib mengikuti langkah operasional terstruktur di bawah ini:
                        </p>

                        <div class="relative pl-6 border-l-2 border-primary/20 space-y-8">
                            {{-- Step 1 --}}
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-white shadow"></span>
                                <h4 class="font-bold text-gray-800 text-sm">Langkah 1: Inisialisasi Event</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    Masuk ke menu <strong>Kelola Event</strong>, lalu buat event Baitul Arqam baru (contoh: "Baitul Arqam Dosen UMS"). Tentukan tanggal pelaksanaan dan simpan untuk menghasilkan token pendaftaran mandiri.
                                </p>
                            </div>

                            {{-- Step 2 --}}
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-white shadow"></span>
                                <h4 class="font-bold text-gray-800 text-sm">Langkah 2: Registrasi / Import Peserta</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    Unduh template berkas Excel yang disediakan di halaman detail event. Isi data kolom (nama, NIK, unit kerja) dengan benar, kemudian unggah kembali untuk mendaftarkan nama peserta secara massal.
                                </p>
                            </div>

                            {{-- Step 3 --}}
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-white shadow"></span>
                                <h4 class="font-bold text-gray-800 text-sm">Langkah 3: Pembuatan Jadwal Sesi & Bank Soal</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    Susun jadwal materi pelatihan pada event. Jadwal sesi ini akan bertindak sebagai acuan presensi kehadiran. Buat pula butir soal pretest dan posttest agar peserta dapat mengerjakan tes secara online.
                                </p>
                            </div>

                            {{-- Step 4 --}}
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-white shadow"></span>
                                <h4 class="font-bold text-gray-800 text-sm">Langkah 4: Pelaksanaan & Penginputan Nilai Praktik</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    Selama event berlangsung, panitia mencatat kehadiran peserta dengan memindai QR Code di ID Card peserta. Fasilitator atau penguji juga menginput nilai afektif (sikap) dan psikomotorik (praktik ibadah) peserta langsung ke sistem.
                                </p>
                            </div>

                            {{-- Step 5 --}}
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-white shadow"></span>
                                <h4 class="font-bold text-gray-800 text-sm">Langkah 5: Pembobotan AHP & Perankingan SAW</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    Setelah semua nilai terkumpul, buka tab AHP pada event dan tentukan matriks perbandingan tingkat kepentingan kriteria. Klik <strong>Simpan Bobot</strong> (pastikan konsisten), lalu tekan tombol <strong>Kalkulasi SAW</strong> untuk melakukan perankingan kelulusan otomatis.
                                </p>
                            </div>

                            {{-- Step 6 --}}
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-white shadow"></span>
                                <h4 class="font-bold text-gray-800 text-sm">Langkah 6: Ekspor Berkas Laporan</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    Unduh hasil evaluasi akhir yang telah ter-ranking dalam format berkas PDF atau lembar sebar Excel di tab <strong>Laporan</strong> untuk diserahkan kepada pimpinan universitas.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
