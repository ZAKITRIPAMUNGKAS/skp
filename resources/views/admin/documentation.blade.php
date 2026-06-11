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
                <p class="text-sm text-gray-500 mt-1">Pusat dokumentasi sistem informasi pendukung keputusan evaluasi Baitul Arqam.</p>
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
            <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm min-h-[500px]">
                
                {{-- Page 1: Spesifikasi Sistem --}}
                <div x-show="activePage === 'spesifikasi'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <h2 class="text-xl font-bold text-gray-800 font-heading">1. Spesifikasi Sistem</h2>
                        <p class="text-xs text-gray-400">Teknis tumpukan perangkat lunak dan arsitektur pengembangan.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="prose prose-sm text-gray-600 leading-relaxed max-w-none space-y-4">
                        <p>
                            Sistem ini dikembangkan menggunakan kerangka kerja (framework) <strong>Laravel 10/11</strong> dengan teknologi server-side script PHP untuk memproses hitungan AHP (Analytical Hierarchy Process) dan SAW (Simple Additive Weighting).
                        </p>
                        <h4 class="font-bold text-gray-800 mt-6">Tumpukan Teknologi (Technology Stack):</h4>
                        <ul class="list-disc pl-5 space-y-2">
                            <li><strong>Backend:</strong> Laravel Framework dengan Eloquent ORM.</li>
                            <li><strong>Frontend:</strong> Tailwind CSS untuk manajemen antarmuka pengguna (UI) dan Alpine.js untuk penanganan komponen dinamis ringan di sisi klien.</li>
                            <li><strong>QR Code scanner:</strong> Lib html5-qrcode untuk pemindaian presensi peserta melalui kamera bawaan laptop/PC secara real-time.</li>
                        </ul>
                    </div>
                </div>

                {{-- Page 2: Kriteria & Parameter --}}
                <div x-show="activePage === 'kriteria'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <h2 class="text-xl font-bold text-gray-800 font-heading">2. Kriteria & Parameter</h2>
                        <p class="text-xs text-gray-400">Definisi variabel kriteria penilaian evaluasi.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="prose prose-sm text-gray-600 leading-relaxed max-w-none space-y-4">
                        <p>
                            Evaluasi Baitul Arqam dirumuskan berdasarkan 5 parameter kriteria berjenis <strong>Benefit</strong> (semakin besar nilainya semakin baik) untuk dihitung dalam sistem:
                        </p>
                        <div class="overflow-x-auto border border-gray-100 rounded-2xl mt-4">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-800 font-bold">
                                        <th class="p-4">Kode</th>
                                        <th class="p-4">Kriteria</th>
                                        <th class="p-4">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    <tr>
                                        <td class="p-4 font-mono font-bold text-primary">C1</td>
                                        <td class="p-4 font-semibold text-gray-800">Pretest</td>
                                        <td class="p-4 text-gray-500">Nilai kognitif awal peserta sebelum materi disampaikan.</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-mono font-bold text-primary">C2</td>
                                        <td class="p-4 font-semibold text-gray-800">Posttest</td>
                                        <td class="p-4 text-gray-500">Nilai kognitif akhir peserta setelah semua materi selesai diberikan.</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-mono font-bold text-primary">C3</td>
                                        <td class="p-4 font-semibold text-gray-800">Afektif</td>
                                        <td class="p-4 text-gray-500">Sikap, kedisiplinan sholat berjamaah, dan akhlak selama pelatihan.</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-mono font-bold text-primary">C4</td>
                                        <td class="p-4 font-semibold text-gray-800">Psikomotorik</td>
                                        <td class="p-4 text-gray-500">Keterampilan praktek ibadah (membaca Al-Qur'an, wudhu, sholat).</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-mono font-bold text-primary">C5</td>
                                        <td class="p-4 font-semibold text-gray-800">Kehadiran</td>
                                        <td class="p-4 text-gray-500">Jumlah kehadiran presensi pada seluruh sesi materi event.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Page 3: Perhitungan AHP --}}
                <div x-show="activePage === 'ahp'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <h2 class="text-xl font-bold text-gray-800 font-heading">3. Metode AHP (Analytical Hierarchy Process)</h2>
                        <p class="text-xs text-gray-400">Pembobotan prioritas kriteria dan evaluasi rasio konsistensi.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="prose prose-sm text-gray-600 leading-relaxed max-w-none space-y-4">
                        <p>
                            AHP memfasilitasi penentuan tingkat kepentingan antar kriteria dengan menggunakan matriks perbandingan berpasangan (diagonal utama bernilai 1.0).
                        </p>
                        
                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 space-y-4 my-4">
                            <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Langkah 1: Normalisasi Matriks & Eigenvector</h4>
                            <p class="text-xs">Membagi nilai setiap sel dengan total penjumlahan kolomnya, kemudian menghitung rata-rata baris untuk memperoleh bobot kriteria ($W_j$).</p>
                            
                            <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Langkah 2: Konsistensi Matriks (CR &le; 10%)</h4>
                            <div class="p-3 bg-white border border-gray-100 rounded-xl font-mono text-center text-xs">
                                CI = (&lambda;<sub>max</sub> - 5) / 4 &nbsp;&bull;&nbsp; CR = CI / 1.12
                            </div>
                            <p class="text-xs text-gray-500">Nilai indeks acak ($RI$) untuk kriteria berjumlah 5 adalah <strong>1.12</strong>. Perbandingan berpasangan dinyatakan konsisten jika nilai rasio konsistensi ($CR$) kurang dari atau sama dengan $0.1$.</p>
                        </div>

                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Uji Konsistensi Pada `AhpService.php`:</h4>
                        <div class="bg-slate-900 text-slate-300 rounded-2xl p-5 font-mono text-xs overflow-x-auto">
<pre>$ci = ($lambdaMax - $n) / ($n - 1);
$ri = 1.12; // Untuk 5 kriteria
$cr = $ci / $ri;
$isConsistent = $cr <= 0.1;</pre>
                        </div>
                    </div>
                </div>

                {{-- Page 4: Normalisasi SAW --}}
                <div x-show="activePage === 'saw'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <h2 class="text-xl font-bold text-gray-800 font-heading">4. Metode SAW (Simple Additive Weighting)</h2>
                        <p class="text-xs text-gray-400">Peringkat preferensi dengan normalisasi kriteria bertipe Benefit.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="prose prose-sm text-gray-600 leading-relaxed max-w-none space-y-4">
                        <p>
                            Setelah bobot $W_j$ diperoleh dari AHP, metode SAW digunakan untuk mengalkulasi nilai peserta:
                        </p>
                        
                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 space-y-4">
                            <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Rumus Normalisasi Benefit (r<sub>ij</sub>):</h4>
                            <div class="p-3 bg-white border border-gray-100 rounded-xl font-mono text-center text-sm">
                                r<sub>ij</sub> = x<sub>ij</sub> / Max<sub>i</sub>(x<sub>ij</sub>)
                            </div>
                            <p class="text-xs text-gray-500">Membagi nilai asli kriteria peserta dengan nilai tertinggi pada kolom kriteria tersebut.</p>

                            <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Rumus Skor Preferensi Akhir (V<sub>i</sub>):</h4>
                            <div class="p-3 bg-white border border-gray-100 rounded-xl font-mono text-center text-sm">
                                V<sub>i</sub> = &Sigma;<sub>j=1</sub><sup>n</sup> W<sub>j</sub> &times; r<sub>ij</sub>
                            </div>
                            <p class="text-xs text-gray-500">Peserta kemudian diurutkan/diranking berdasarkan hasil kalkulasi nilai preferensi SAW ($V_i$) terbesar.</p>
                        </div>
                    </div>
                </div>

                {{-- Page 5: Predikat Kelulusan --}}
                <div x-show="activePage === 'predikat'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <h2 class="text-xl font-bold text-gray-800 font-heading">5. Predikat Kelulusan</h2>
                        <p class="text-xs text-gray-400">Parameter rentang nilai untuk penentuan status kelulusan peserta.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="prose prose-sm text-gray-600 leading-relaxed max-w-none space-y-4">
                        <p>
                            Penentuan predikat dan status kelulusan dilakukan otomatis berdasarkan skor preferensi akhir SAW ($V_i$):
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div class="border border-gray-100 rounded-2xl overflow-hidden">
                                <div class="bg-gray-50 p-3 font-bold text-xs text-gray-700 border-b border-gray-100">Rentang Predikat</div>
                                <table class="w-full text-left text-xs">
                                    <tbody class="divide-y divide-gray-100">
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

                            <div class="border border-gray-100 rounded-2xl overflow-hidden">
                                <div class="bg-gray-50 p-3 font-bold text-xs text-gray-700 border-b border-gray-100">Status Kelulusan</div>
                                <table class="w-full text-left text-xs">
                                    <tbody class="divide-y divide-gray-100">
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
                </div>

                {{-- Page 6: Skema Database --}}
                <div x-show="activePage === 'database'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <h2 class="text-xl font-bold text-gray-800 font-heading">6. Skema Database</h2>
                        <p class="text-xs text-gray-400">Definisi tabel database relasional pendukung sistem.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="prose prose-sm text-gray-600 leading-relaxed max-w-none space-y-4">
                        <p>
                            Database MySQL dirancang menggunakan relasi data konsisten untuk menyimpan semua parameter evaluasi:
                        </p>
                        <div class="overflow-x-auto border border-gray-100 rounded-2xl mt-4">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-800 font-bold">
                                        <th class="p-4">Tabel</th>
                                        <th class="p-4">Kolom Utama</th>
                                        <th class="p-4">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    <tr>
                                        <td class="p-4 font-semibold text-gray-800">events</td>
                                        <td class="p-4 font-mono text-gray-500">id, nama_event, tgl_mulai</td>
                                        <td class="p-4">Menyimpan data induk pelaksanaan Baitul Arqam.</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-semibold text-gray-800">peserta</td>
                                        <td class="p-4 font-mono text-gray-500">id, nama_lengkap, unit_kerja</td>
                                        <td class="p-4">Mencatat profil peserta yang didaftarkan.</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-semibold text-gray-800">ahp_bobots</td>
                                        <td class="p-4 font-mono text-gray-500">event_id, bobot_c1..c5, cr_value</td>
                                        <td class="p-4">Menyimpan bobot prioritas hasil perhitungan AHP.</td>
                                    </tr>
                                    <tr>
                                        <td class="p-4 font-semibold text-gray-800">penilaian_akhirs</td>
                                        <td class="p-4 font-mono text-gray-500">peserta_id, skor_saw, ranking</td>
                                        <td class="p-4">Menyimpan skor akhir, peringkat, dan predikat hasil kalkulasi.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Page 7: Alur Kerja Pengguna --}}
                <div x-show="activePage === 'alur'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <h2 class="text-xl font-bold text-gray-800 font-heading">7. Alur Kerja Pengguna (Panduan Penggunaan)</h2>
                        <p class="text-xs text-gray-400">Tata cara bertahap untuk mengelola data Baitul Arqam.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="prose prose-sm text-gray-600 leading-relaxed max-w-none space-y-6">
                        <div class="flex items-start gap-4">
                            <span class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold shrink-0">1</span>
                            <div>
                                <h4 class="font-bold text-gray-800">Pendaftaran Event & Peserta</h4>
                                <p class="text-xs text-gray-500 mt-0.5">Membuat event di panel admin utama, dilanjutkan dengan mengunduh template Excel dan mengunggahnya kembali untuk mengimpor daftar peserta secara massal.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <span class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold shrink-0">2</span>
                            <div>
                                <h4 class="font-bold text-gray-800">Penyusunan Sesi & Ujian</h4>
                                <p class="text-xs text-gray-500 mt-0.5">Memasukkan jadwal materi untuk presensi QR-Code, serta merilis butir soal agar peserta dapat memulai ujian di halaman panel peserta.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <span class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold shrink-0">3</span>
                            <div>
                                <h4 class="font-bold text-gray-800">Penilaian Afektif & Psikomotorik</h4>
                                <p class="text-xs text-gray-500 mt-0.5">Penguji/Fasilitator memasukkan nilai kepribadian (afektif) dan praktik ibadah (psikomotorik) untuk masing-masing peserta.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <span class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold shrink-0">4</span>
                            <div>
                                <h4 class="font-bold text-gray-800">Peringkat Akhir (AHP-SAW) & Cetak Laporan</h4>
                                <p class="text-xs text-gray-500 mt-0.5">Melakukan pembobotan matriks berpasangan AHP pada menu event, menekan tombol hitung peringkat SAW, kemudian mencetak berkas laporan (Excel/PDF).</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
