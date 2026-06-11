@extends('layouts.main')

@section('title', 'Dokumentasi Sistem - ArqamApp')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800 font-heading">Dokumentasi Sistem</h1>
            <p class="text-sm text-gray-500 mt-1">Panduan arsitektur sistem, database, dan detail perhitungan evaluasi AHP-SAW.</p>
        </div>
    </div>

    {{-- Main Container --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        {{-- Navigation sidebar inside documentation page --}}
        <div class="lg:col-span-1 bg-white rounded-3xl border border-gray-100 p-6 shadow-sm h-fit space-y-6">
            <h3 class="font-bold text-gray-800 font-heading text-base">Daftar Isi</h3>
            <nav class="space-y-2">
                <a href="#arsitektur" class="block text-sm font-semibold text-primary hover:text-primary-600">1. Arsitektur Sistem</a>
                <a href="#fitur" class="block text-sm font-semibold text-gray-600 hover:text-primary transition-colors">2. Fitur & Alur Pengguna</a>
                <a href="#algoritma" class="block text-sm font-semibold text-gray-600 hover:text-primary transition-colors">3. Perhitungan AHP-SAW</a>
                <a href="#database" class="block text-sm font-semibold text-gray-600 hover:text-primary transition-colors">4. Struktur Tabel Database</a>
            </nav>
        </div>

        {{-- Content Area --}}
        <div class="lg:col-span-3 bg-white rounded-3xl border border-gray-100 p-8 shadow-sm space-y-8 max-h-[80vh] overflow-y-auto sidebar-scroll">
            {{-- Section 1 --}}
            <section id="arsitektur" class="space-y-3">
                <h2 class="text-xl font-bold text-gray-800 font-heading border-b border-gray-100 pb-3 flex items-center gap-2">
                    <span class="w-1.5 h-6 rounded-full bg-primary inline-block"></span>
                    1. Arsitektur Sistem
                </h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    <strong>ArqamApp</strong> dibangun menggunakan Framework <strong>Laravel 10/11</strong> dengan perpaduan <strong>Tailwind CSS</strong> dan <strong>Alpine.js</strong> untuk sisi visual yang interaktif (TALL Stack minimalis).
                </p>
                <ul class="list-disc pl-5 space-y-2 text-sm text-gray-600">
                    <li><strong>Backend:</strong> PHP 8.x dengan database MySQL.</li>
                    <li><strong>Frontend:</strong> Blade Views terintegrasi dengan Livewire atau Alpine.js untuk mendukung pemindaian QR Code secara langsung.</li>
                    <li><strong>Keamanan:</strong> Dilengkapi dengan Route Middleware Auth khusus untuk memisahkan hak akses antara Administrator dan Peserta Baitul Arqam.</li>
                </ul>
            </section>

            {{-- Section 2 --}}
            <section id="fitur" class="space-y-3">
                <h2 class="text-xl font-bold text-gray-800 font-heading border-b border-gray-100 pb-3 flex items-center gap-2">
                    <span class="w-1.5 h-6 rounded-full bg-cyan-500 inline-block"></span>
                    2. Fitur & Alur Pengguna
                </h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Sistem ini mengotomatiskan seluruh alur evaluasi Baitul Arqam, mulai dari:
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <h4 class="font-bold text-sm text-gray-800 mb-1">Presensi QR-Code</h4>
                        <p class="text-xs text-gray-500">Panitia memindai ID Card Peserta untuk mencatat kehadiran secara real-time pada setiap sesi materi.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <h4 class="font-bold text-sm text-gray-800 mb-1">Ujian Online Terpadu</h4>
                        <p class="text-xs text-gray-500">Peserta mengerjakan Pre-test dan Post-test langsung dari panel peserta mereka dengan pengawasan waktu otomatis.</p>
                    </div>
                </div>
            </section>

            {{-- Section 3 --}}
            <section id="algoritma" class="space-y-3">
                <h2 class="text-xl font-bold text-gray-800 font-heading border-b border-gray-100 pb-3 flex items-center gap-2">
                    <span class="w-1.5 h-6 rounded-full bg-yellow-500 inline-block"></span>
                    3. Perhitungan AHP-SAW
                </h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Penilaian akhir dan perankingan kelulusan peserta menggunakan metode hibrida:
                </p>
                <div class="p-5 rounded-2xl bg-primary/5 border border-primary/10 space-y-3">
                    <h4 class="font-bold text-sm text-primary">Analytical Hierarchy Process (AHP)</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Digunakan untuk menghitung bobot prioritas dari setiap kriteria (Kognitif, Afektif, Psikomotorik, dan Presensi Kehadiran) berdasarkan matriks perbandingan berpasangan.
                    </p>
                    
                    <h4 class="font-bold text-sm text-primary">Simple Additive Weighting (SAW)</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Digunakan untuk melakukan normalisasi matriks keputusan nilai peserta dan menjumlahkan hasil perkalian nilai normalisasi dengan bobot kriteria AHP untuk mendapatkan skor akhir peserta.
                    </p>
                </div>
            </section>

            {{-- Section 4 --}}
            <section id="database" class="space-y-3">
                <h2 class="text-xl font-bold text-gray-800 font-heading border-b border-gray-100 pb-3 flex items-center gap-2">
                    <span class="w-1.5 h-6 rounded-full bg-emerald-500 inline-block"></span>
                    4. Struktur Tabel Database
                </h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Sistem ini mengelola data relasional kompleks yang mencakup tabel-tabel utama berikut:
                </p>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-500 border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 bg-gray-50 text-gray-700 font-bold">
                                <th class="p-3">Nama Tabel</th>
                                <th class="p-3">Deskripsi Utama</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100">
                                <td class="p-3 font-semibold text-gray-800">events</td>
                                <td class="p-3">Menyimpan data induk pelaksanaan Baitul Arqam.</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="p-3 font-semibold text-gray-800">peserta</td>
                                <td class="p-3">Mencatat profil peserta, unit kerja, dan token ujian.</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="p-3 font-semibold text-gray-800">absensi</td>
                                <td class="p-3">Data kehadiran peserta pada setiap sesi materi.</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="p-3 font-semibold text-gray-800">nilai_akhir</td>
                                <td class="p-3">Hasil kalkulasi bobot AHP-SAW untuk laporan akhir.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
