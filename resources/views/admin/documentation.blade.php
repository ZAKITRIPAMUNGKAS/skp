@extends('layouts.main')

@section('title', 'Dokumentasi Sistem - ArqamApp')

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
            <h1 class="text-2xl font-bold text-gray-800 font-heading">Dokumentasi Teknis Sistem</h1>
            <p class="text-sm text-gray-500 mt-1">Dokumentasi resmi arsitektur perangkat lunak, database, dan detail formulasi matematika AHP-SAW pada ArqamApp.</p>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Sticky Navigation Menu --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm sticky top-6 space-y-4">
                <h3 class="font-bold text-gray-800 font-heading text-sm uppercase tracking-wider text-primary">Daftar Materi</h3>
                <nav class="space-y-1">
                    <a href="#arsitektur" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold text-primary bg-primary/5 hover:bg-primary/5 transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                        Arsitektur Sistem
                    </a>
                    <a href="#algoritma-ahp" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-primary hover:bg-gray-50 transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-transparent group-hover:bg-primary"></span>
                        Formulasi AHP
                    </a>
                    <a href="#algoritma-saw" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-primary hover:bg-gray-50 transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-transparent group-hover:bg-primary"></span>
                        Normalisasi SAW
                    </a>
                    <a href="#skema-database" class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-primary hover:bg-gray-50 transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-transparent group-hover:bg-primary"></span>
                        Skema Database
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
            {{-- Arsitektur --}}
            <div id="arsitektur" class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 font-heading">1. Arsitektur & Teknologi</h2>
                        <p class="text-xs text-gray-400">Teknis tumpukan perangkat lunak dan alur data.</p>
                    </div>
                </div>
                <hr class="border-gray-100">
                <p class="text-sm text-gray-600 leading-relaxed">
                    Sistem dirancang menggunakan pendekatan arsitektur MVC (Model-View-Controller) yang efisien, tangguh, dan terukur.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-4">
                    <div class="border border-gray-100 rounded-2xl p-4 bg-gray-50">
                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Laravel 11 Engine</h4>
                        <p class="text-[11px] text-gray-500 mt-1">Menggunakan routing, ORM Eloquent, dan transaction database untuk konsistensi data evaluasi.</p>
                    </div>
                    <div class="border border-gray-100 rounded-2xl p-4 bg-gray-50">
                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Tailwind UI System</h4>
                        <p class="text-[11px] text-gray-500 mt-1">Desain responsif berbasis komponen utilitas CSS dengan transisi mikro interaktif.</p>
                    </div>
                    <div class="border border-gray-100 rounded-2xl p-4 bg-gray-50">
                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">QR Code Engine</h4>
                        <p class="text-[11px] text-gray-500 mt-1">Mengintegrasikan generator QR Code instan untuk melacak presensi & profil fisik peserta.</p>
                    </div>
                </div>
            </div>

            {{-- Formulasi AHP --}}
            <div id="algoritma-ahp" class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-yellow-400/20 text-yellow-500 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2a2 2 0 00-2 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 font-heading">2. Formulasi Pembobotan AHP</h2>
                        <p class="text-xs text-gray-400">Pencarian bobot prioritas kriteria dengan uji konsistensi.</p>
                    </div>
                </div>
                <hr class="border-gray-100">
                
                <div class="space-y-4 text-sm text-gray-600 leading-relaxed">
                    <p>
                        Pembobotan kriteria didasarkan pada perbandingan berpasangan (pairwise comparison matrix) yang membandingkan 5 kriteria:
                        <span class="inline-flex gap-1 font-bold text-xs text-primary">C1 (Pretest)</span>,
                        <span class="inline-flex gap-1 font-bold text-xs text-primary">C2 (Posttest)</span>,
                        <span class="inline-flex gap-1 font-bold text-xs text-primary">C3 (Afektif)</span>,
                        <span class="inline-flex gap-1 font-bold text-xs text-primary">C4 (Psikomotorik)</span>, dan
                        <span class="inline-flex gap-1 font-bold text-xs text-primary">C5 (Kehadiran)</span>.
                    </p>

                    <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 space-y-4">
                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Tahapan Kalkulasi AHP:</h4>
                        <ol class="list-decimal pl-5 space-y-2 text-xs">
                            <li>
                                <strong>Normalisasi Kolom Matriks:</strong>
                                <div class="my-2 p-3 bg-white border border-gray-100 rounded-xl font-mono text-center text-sm">
                                    X<sub>ij-normalized</sub> = X<sub>ij</sub> / &Sigma;<sub>i=1</sub><sup>n</sup> X<sub>ij</sub>
                                </div>
                            </li>
                            <li>
                                <strong>Menghitung Eigenvector (Bobot Prioritas W<sub>i</sub>):</strong>
                                <div class="my-2 p-3 bg-white border border-gray-100 rounded-xl font-mono text-center text-sm">
                                    W<sub>i</sub> = (&Sigma;<sub>j=1</sub><sup>n</sup> X<sub>ij-normalized</sub>) / n
                                </div>
                            </li>
                            <li>
                                <strong>Uji Konsistensi (Consistency Ratio - CR):</strong>
                                <div class="my-2 p-3 bg-white border border-gray-100 rounded-xl font-mono text-center text-sm">
                                    CI = (&lambda;<sub>max</sub> - n) / (n - 1) &nbsp;&bull;&nbsp; CR = CI / RI
                                </div>
                                <p class="mt-1.5 text-gray-500">Nilai perbandingan dinyatakan <strong>KONSISTEN</strong> apabila nilai <strong>CR &le; 0.1 (10%)</strong>.</p>
                            </li>
                        </ol>
                    </div>

                    {{-- Code Snippet AHP --}}
                    <div class="space-y-2">
                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Implementasi Kode PHP (AhpService.php):</h4>
                        <div class="bg-slate-900 text-slate-300 rounded-2xl p-5 font-mono text-xs overflow-x-auto">
<pre class="leading-relaxed"><span class="text-teal-400">// Menghitung Eigenvector & Lambda Max</span>
$colSums = array_fill(0, $n, 0);
for ($j = 0; $j &lt; $n; $j++) {
    for ($i = 0; $i &lt; $n; $i++) {
        $colSums[$j] += $matrix[$i][$j];
    }
}
$normalized = [];
for ($i = 0; $i &lt; $n; $i++) {
    for ($j = 0; $j &lt; $n; $j++) {
        $normalized[$i][$j] = $matrix[$i][$j] / $colSums[$j];
    }
    $weights[$i] = array_sum($normalized[$i]) / $n;
}</pre>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Formulasi SAW --}}
            <div id="algoritma-saw" class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-cyan-400/20 text-cyan-500 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 font-heading">3. Perankingan Metode SAW</h2>
                        <p class="text-xs text-gray-400">Normalisasi benefit dan penjumlahan bobot preferensi.</p>
                    </div>
                </div>
                <hr class="border-gray-100">
                
                <div class="space-y-4 text-sm text-gray-600 leading-relaxed">
                    <p>
                        Setelah memperoleh bobot konsisten dari metode AHP, sistem melakukan normalisasi nilai peserta menggunakan metode <strong>Simple Additive Weighting (SAW)</strong> dengan jenis kriteria bertipe <strong>Benefit</strong> (semakin besar nilai, semakin baik).
                    </p>

                    <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 space-y-4">
                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Formulasi Normalisasi SAW:</h4>
                        <div class="p-3 bg-white border border-gray-100 rounded-xl font-mono text-center text-sm">
                            r<sub>ij</sub> = x<sub>ij</sub> / x<sub>j-max</sub>
                        </div>
                        <p class="text-xs text-gray-500">
                            Dimana <code>x<sub>ij</sub></code> adalah nilai kriteria peserta ke-i pada kriteria ke-j, dan <code>x<sub>j-max</sub></code> adalah nilai tertinggi di antara seluruh peserta pada kriteria ke-j.
                        </p>
                        
                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Kalkulasi Skor Preferensi Akhir V<sub>i</sub>:</h4>
                        <div class="p-3 bg-white border border-gray-100 rounded-xl font-mono text-center text-sm">
                            V<sub>i</sub> = &Sigma;<sub>j=1</sub><sup>n</sup> W<sub>j</sub> &times; r<sub>ij</sub>
                        </div>
                        <p class="text-xs text-gray-500">
                            Peserta diurutkan berdasarkan nilai preferensi tertinggi <code>V<sub>i</sub></code> untuk menentukan peringkat akhir secara otomatis.
                        </p>
                    </div>

                    {{-- Code Snippet SAW --}}
                    <div class="space-y-2">
                        <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider">Implementasi Kode Normalisasi & Kalkulasi (SawService.php):</h4>
                        <div class="bg-slate-900 text-slate-300 rounded-2xl p-5 font-mono text-xs overflow-x-auto">
<pre class="leading-relaxed"><span class="text-teal-400">// Rumus Benefit normalisasi r_ij = nilai / nilai_max</span>
$r = [
    $p->nilai_pretest / $maxC1,
    $p->nilai_posttest / $maxC2,
    $p->nilai_psikomotor / $maxC3,
    $p->nilai_afektif / $maxC4,
    $p->nilai_kehadiran / $maxC5,
];

<span class="text-teal-400">// Nilai Preferensi V_i = Penjumlahan (Bobot_j * R_ij)</span>
$vi = 0;
for ($j = 0; $j &lt; 5; $j++) {
    $vi += $weights[$j] * $r[$j];
}</pre>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Skema Database --}}
            <div id="skema-database" class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-400/20 text-emerald-500 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 font-heading">4. Skema Database Relasional</h2>
                        <p class="text-xs text-gray-400">Definisi struktur data tabel inti evaluasi sistem.</p>
                    </div>
                </div>
                <hr class="border-gray-100">

                <div class="space-y-4 text-sm text-gray-600">
                    <p>
                        Entitas database dirancang menggunakan relasi erat untuk menjamin integritas referensial data kelulusan peserta.
                    </p>

                    <div class="overflow-x-auto border border-gray-100 rounded-2xl">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100 text-gray-800 font-bold">
                                    <th class="p-4">Nama Tabel</th>
                                    <th class="p-4">Kolom Penting</th>
                                    <th class="p-4">Relasi & Aturan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr>
                                    <td class="p-4 font-semibold text-gray-800">events</td>
                                    <td class="p-4 font-mono text-gray-500">id, nama_event, tgl_mulai</td>
                                    <td class="p-4 text-xs">Tabel induk pelaksanaan event Baitul Arqam.</td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-semibold text-gray-800">peserta</td>
                                    <td class="p-4 font-mono text-gray-500">id, nama_lengkap, unit_kerja</td>
                                    <td class="p-4 text-xs">Mencatat profil peserta yang didaftarkan.</td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-semibold text-gray-800">ahp_bobots</td>
                                    <td class="p-4 font-mono text-gray-500">event_id, bobot_c1..c5, cr_value</td>
                                    <td class="p-4 text-xs">Relasi <code>One-to-One</code> ke tabel <code>events</code> untuk menyimpan pembobotan AHP.</td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-semibold text-gray-800">penilaian_akhirs</td>
                                    <td class="p-4 font-mono text-gray-500">peserta_id, nilai_pretest..nilai_kehadiran, skor_saw, ranking</td>
                                    <td class="p-4 text-xs">Menyimpan nilai mentah kriteria beserta skor preferensi & peringkat akhir SAW.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
