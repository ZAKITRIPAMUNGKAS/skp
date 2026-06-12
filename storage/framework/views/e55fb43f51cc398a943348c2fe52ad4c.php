<?php $__env->startSection('title', 'Dokumentasi Sistem - ArqamApp'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6" x-data="{ activePage: 'spesifikasi' }">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800 font-heading">Dokumentasi & Panduan Pengembang</h1>
                <p class="text-sm text-gray-500 mt-1">Pusat dokumentasi sistem informasi pendukung keputusan evaluasi Baitul Arqam secara komprehensif.</p>
            </div>
        </div>
        
        
        <div class="flex items-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-2xl text-xs font-semibold self-start md:self-auto">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>v2.0 (Stable)</span>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <div class="lg:col-span-1 lg:sticky lg:top-8 self-start space-y-4">
            <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-6">
                <div>
                    <h3 class="font-bold text-gray-400 font-heading text-[10px] uppercase tracking-wider">Daftar Dokumentasi</h3>
                    <p class="text-[11px] text-gray-500 mt-0.5">Pilih modul dokumentasi di bawah ini:</p>
                </div>

                <nav class="space-y-1.5">
                    
                    <button @click="activePage = 'spesifikasi'" 
                            :class="activePage === 'spesifikasi' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span class="truncate">1. Spesifikasi Sistem</span>
                    </button>

                    
                    <button @click="activePage = 'kriteria'" 
                            :class="activePage === 'kriteria' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span class="truncate">2. Kriteria & Parameter</span>
                    </button>

                    
                    <button @click="activePage = 'ahp'" 
                            :class="activePage === 'ahp' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2a2 2 0 00-2 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="truncate">3. Perhitungan AHP</span>
                    </button>

                    
                    <button @click="activePage = 'saw'" 
                            :class="activePage === 'saw' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="truncate">4. Normalisasi SAW</span>
                    </button>

                    
                    <button @click="activePage = 'predikat'" 
                            :class="activePage === 'predikat' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="truncate">5. Predikat & N-Gain</span>
                    </button>

                    
                    <button @click="activePage = 'database'" 
                            :class="activePage === 'database' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                        <span class="truncate">6. Skema Database</span>
                    </button>

                    
                    <button @click="activePage = 'alur'" 
                            :class="activePage === 'alur' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="truncate">7. Alur Kerja Pengguna</span>
                    </button>

                    
                    <button @click="activePage = 'simulasi'" 
                            :class="activePage === 'simulasi' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h-6a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2v-5M17 14l4-4m0 0l-4-4m4 4H7" />
                        </svg>
                        <span class="truncate">8. Simulasi Perhitungan</span>
                    </button>

                    
                    <button @click="activePage = 'akses'" 
                            :class="activePage === 'akses' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span class="truncate">9. Hak Akses & Glosarium</span>
                    </button>

                    
                    <button @click="activePage = 'maintenance'" 
                            :class="activePage === 'maintenance' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="truncate">10. Pemeliharaan Sistem</span>
                    </button>

                    
                    <button @click="activePage = 'changelog'" 
                            :class="activePage === 'changelog' ? 'bg-primary/10 text-primary font-bold' : 'text-gray-600 hover:text-primary hover:bg-gray-50'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-left text-sm transition-all group">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="truncate">11. Changelog & Riwayat Pembaruan</span>
                    </button>
                </nav>
            </div>
        </div>

        
        <div class="lg:col-span-3">
            <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm min-h-[550px] text-gray-600 leading-relaxed font-sans">
                
                
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

                
                <div x-show="activePage === 'kriteria'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-1 rounded-md">Variabel Keputusan & Rubrik</span>
                        <h2 class="text-xl font-bold text-gray-800 font-heading mt-2">2. Kriteria & Parameter Penilaian</h2>
                        <p class="text-xs text-gray-400">Struktur kriteria pembentuk nilai preferensi SAW, skala nilai, dan detail rubrik penilaian per kriteria.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-4 text-sm text-gray-600">
                        <p>
                            Evaluasi Baitul Arqam dirumuskan berdasarkan 5 parameter kriteria berjenis <strong>Benefit</strong> (semakin besar nilainya semakin baik) dengan urutan pemetaan variabel riil sistem sebagai berikut:
                        </p>

                        <div class="space-y-4 mt-4">
                            <div class="p-5 border border-gray-100 rounded-3xl space-y-2">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">C1</span>
                                    <h4 class="font-bold text-gray-800 text-sm">Pretest (Bobot Kognitif Awal)</h4>
                                </div>
                                <p class="text-xs text-gray-500 leading-relaxed">Ujian tertulis/online pilihan ganda yang dikerjakan peserta secara mandiri sebelum materi dimulai. Nilai dihitung berdasarkan persentase jawaban benar: <code>(Jawaban Benar / Total Soal) * 100</code>.</p>
                            </div>

                            <div class="p-5 border border-gray-100 rounded-3xl space-y-2">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">C2</span>
                                    <h4 class="font-bold text-gray-800 text-sm">Posttest (Bobot Kognitif Akhir)</h4>
                                </div>
                                <p class="text-xs text-gray-500 leading-relaxed">Ujian evaluasi akhir tertulis untuk melihat peningkatan pengetahuan peserta setelah materi selesai. Dihitung menggunakan formula yang sama seperti pretest: <code>(Jawaban Benar / Total Soal) * 100</code>.</p>
                            </div>

                            <div class="p-5 border border-gray-100 rounded-3xl space-y-2">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">C3</span>
                                    <h4 class="font-bold text-gray-800 text-sm">Psikomotorik (Kemampuan Praktik Ibadah)</h4>
                                </div>
                                <p class="text-xs text-gray-500 leading-relaxed">Dinilai oleh **Fasilitator/Penguji** (bukan oleh peserta) menggunakan skala skor 1-4 untuk aspek ibadah (sholat, tayamum, wudhu, mengaji) dan outbound (kerjasama, disiplin, semangat), yang kemudian dikonversikan otomatis ke skala 0-100:</p>
                                <div class="p-3 bg-white border border-gray-100 rounded-xl font-mono text-[11px] text-center">
                                    Nilai C3 = (Total Skor yang Diperoleh / Total Skor Maksimal Template) * 100
                                </div>
                            </div>

                            <div class="p-5 border border-gray-100 rounded-3xl space-y-2">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">C4</span>
                                    <h4 class="font-bold text-gray-800 text-sm">Afektif (Evaluasi Karakter & Sikap Mandiri)</h4>
                                </div>
                                <p class="text-xs text-gray-500 leading-relaxed">Penilaian ini **diisi sendiri oleh Peserta secara mandiri (Self-Assessment)** melalui pengisian kuesioner skala Likert (Sangat Setuju - SS, Setuju - S, Tidak Setuju - TS, Sangat Tidak Setuju - STS) di panel peserta masing-masing. Sistem secara otomatis menghitung akumulasi jawaban positif & negatif peserta lalu mengonversikannya ke skala 0-100:</p>
                                <div class="p-3 bg-white border border-gray-100 rounded-xl font-mono text-[11px] text-center">
                                    Nilai C4 = (Total Skor Jawaban Likert / Skor Maksimal Butir) * 100
                                </div>
                            </div>

                            <div class="p-5 border border-gray-100 rounded-3xl space-y-2">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">C5</span>
                                    <h4 class="font-bold text-gray-800 text-sm">Kehadiran (Presensi Sesi Materi)</h4>
                                </div>
                                <p class="text-xs text-gray-500 leading-relaxed">Kehadiran dihitung otomatis secara realtime oleh sistem dari jumlah kehadiran sesi materi terjadwal:</p>
                                <div class="p-3 bg-white border border-gray-100 rounded-xl font-mono text-[11px] text-center">
                                    C5 = (Jumlah Sesi Dihadiri / Total Sesi Terjadwal) * 100
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
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

                
                <div x-show="activePage === 'predikat'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-1 rounded-md">Aturan Kelulusan & N-Gain</span>
                        <h2 class="text-xl font-bold text-gray-800 font-heading mt-2">5. Rubrik Predikat Nilai & Keefektifan N-Gain</h2>
                        <p class="text-xs text-gray-400">Penggolongan otomatis berbasis nilai preferensi preferensi SAW dan analisis efektivitas peningkatan kognitif.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-4 text-sm text-gray-600 leading-relaxed">
                        <p>
                            Sistem akan secara otomatis membagi predikat (kategori nilai) dan status kelulusan peserta berdasarkan nilai preferensi SAW ($V_i$) yang diperoleh peserta:
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            
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

                        <hr class="border-gray-100 my-6">

                        
                        <div class="space-y-4">
                            <h3 class="text-base font-bold text-gray-800 font-heading">Kalkulasi Keefektifan Pembelajaran (Normalized Gain - N-Gain)</h3>
                            <p class="text-sm">
                                Sistem ini juga mengimplementasikan rumus **N-Gain Score (oleh Richard Hake)** untuk mengevaluasi seberapa efektif metode pembelajaran/materi yang disampaikan selama pelatihan dengan membandingkan nilai Pretest dan Posttest peserta.
                            </p>
                            <div class="p-4 bg-gray-50 border border-gray-100 rounded-2xl text-center font-mono text-xs">
                                N-Gain Score = (Posttest - Pretest) / (100 - Pretest)
                            </div>
                            
                            <h4 class="font-bold text-gray-800 text-xs uppercase tracking-wider mt-4">Mengapa Menggunakan N-Gain? (Menghindari Bias Akademik):</h4>
                            <p class="text-xs leading-relaxed text-gray-500">
                                Jika sistem hanya menghitung selisih nilai biasa (<code>Posttest - Pretest</code>), maka akan terjadi bias yang tidak adil bagi peserta. Sebagai contoh:
                                <br>&bull; <strong>Peserta X</strong>: Pretest = 20, Posttest = 60. Selisih peningkatan = <strong>40 poin</strong>.
                                <br>&bull; <strong>Peserta Y</strong>: Pretest = 90, Posttest = 100. Selisih peningkatan = <strong>10 poin</strong>.
                                <br>Secara selisih biasa, Peserta X terkesan menyerap materi jauh lebih baik daripada Peserta Y. Namun secara akademis, Peserta Y berhasil memaksimalkan potensinya hingga sempurna (100% dari potensi yang tersisa), sementara Peserta X hanya menyerap 50% dari potensi yang tersisa.
                                <br><br>
                                Dengan rumus N-Gain Hake, bias ini dinormalisasi:
                                <br>&bull; N-Gain Peserta X = <code>(60 - 20) / (100 - 20) = 40 / 80 = 0.50</code> (Kategori: <strong>Sedang</strong>)
                                <br>&bull; N-Gain Peserta Y = <code>(100 - 90) / (100 - 90) = 10 / 10 = 1.00</code> (Kategori: <strong>Tinggi</strong>)
                                <br>Hal ini memberikan penilaian efektivitas belajar yang jauh lebih adil dan akurat secara ilmiah.
                            </p>

                            <h4 class="font-bold text-gray-800 text-xs uppercase tracking-wider mt-4">Fungsi Hasil Analisis N-Gain bagi Penyelenggara:</h4>
                            <p class="text-xs leading-relaxed text-gray-500">
                                Pengelompokan kategori N-Gain rata-rata kelas/angkatan membantu penyelenggara melakukan evaluasi kurikulum:
                            </p>
                            <ul class="list-disc pl-5 text-xs text-slate-500 space-y-1">
                                <li><strong>Tinggi (N-Gain > 0.70)</strong>: Pembelajaran sangat efektif. Peserta menyerap materi pelatihan kognitif secara optimal.</li>
                                <li><strong>Sedang (0.30 &le; N-Gain &le; 0.70)</strong>: Pembelajaran cukup efektif. Peningkatan pengetahuan peserta berada di level rata-rata.</li>
                                <li><strong>Rendah (N-Gain &lt; 0.30)</strong>: Pembelajaran kurang efektif. Penyelenggara perlu mengevaluasi kurikulum, metode penyampaian fasilitator, atau kualitas materi yang diajarkan karena daya serap kognitif peserta sangat minim.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                
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
                            
                            <div class="border border-gray-100 rounded-3xl p-6 space-y-3 bg-gray-50/50">
                                <h4 class="font-bold text-gray-800 font-mono text-sm">Tabel: events</h4>
                                <ul class="list-disc pl-5 text-xs text-gray-500 space-y-1.5">
                                    <li><code>id</code> (bigint, PK, auto-increment): ID Unik Event.</li>
                                    <li><code>nama_event</code> (varchar): Judul pelaksanaan Baitul Arqam.</li>
                                    <li><code>tgl_mulai</code> & <code>tgl_selesai</code> (date): Rentang pelaksanaan event.</li>
                                    <li><code>token_registrasi</code> (varchar): Token pendaftaran mandiri bagi peserta.</li>
                                </ul>
                            </div>

                            
                            <div class="border border-gray-100 rounded-3xl p-6 space-y-3 bg-gray-50/50">
                                <h4 class="font-bold text-gray-800 font-mono text-sm">Tabel: peserta</h4>
                                <ul class="list-disc pl-5 text-xs text-gray-500 space-y-1.5">
                                    <li><code>id</code> (bigint, PK, auto-increment): ID Unik Peserta.</li>
                                    <li><code>nama_lengkap</code> (varchar): Nama lengkap peserta beserta gelar.</li>
                                    <li><code>nik</code> & <code>no_telepon</code> (varchar): Data pelengkap pendaftaran.</li>
                                    <li><code>unit_kerja</code> (varchar): Fakultas / Unit instansi pengutus.</li>
                                </ul>
                            </div>

                            
                            <div class="border border-gray-100 rounded-3xl p-6 space-y-3 bg-gray-50/50">
                                <h4 class="font-bold text-gray-800 font-mono text-sm">Tabel: ahp_bobot</h4>
                                <ul class="list-disc pl-5 text-xs text-gray-500 space-y-1.5">
                                    <li><code>id</code> (bigint, PK, auto-increment): ID Pembobotan.</li>
                                    <li><code>event_id</code> (bigint, FK): Berelasi ke <code>events.id</code>.</li>
                                    <li><code>bobot_c1</code> s/d <code>bobot_c5</code> (double): Nilai bobot prioritas hasil perhitungan AHP.</li>
                                    <li><code>cr_value</code> (double): Rasio konsistensi matriks perbandingan berpasangan.</li>
                                </ul>
                            </div>

                            
                            <div class="border border-gray-100 rounded-3xl p-6 space-y-3 bg-gray-50/50">
                                <h4 class="font-bold text-gray-800 font-mono text-sm">Tabel: penilaian_akhir</h4>
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

                
                <div x-show="activePage === 'alur'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-1 rounded-md">Alur Operasional & Penilaian</span>
                        <h2 class="text-xl font-bold text-gray-800 font-heading mt-2">7. Panduan Runtut Alur Kerja & Mekanisme Penilaian</h2>
                        <p class="text-xs text-gray-400">Langkah operasional pengelolaan data serta metode pengisian nilai per tahapan alur.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-6 text-sm text-gray-600">
                        <p>
                            Untuk melakukan evaluasi pelatihan Baitul Arqam dari awal hingga akhir, operator wajib mengikuti alur kerja dan mekanisme input nilai di bawah ini:
                        </p>

                        <div class="relative pl-6 border-l-2 border-primary/20 space-y-8">
                            
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-white shadow"></span>
                                <h4 class="font-bold text-gray-800 text-sm">Langkah 1: Inisialisasi & Pengaturan Event</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    Membuat event Baitul Arqam baru di menu dashboard. Di sini token pendaftaran dihasilkan otomatis.
                                </p>
                            </div>

                            
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-white shadow"></span>
                                <h4 class="font-bold text-gray-800 text-sm">Langkah 2: Registrasi / Import Peserta (Pengisian Data Profil)</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    Operator mengisi berkas Excel berisi profil peserta. Sistem memproses Excel dan memetakan identitas unik (ID Peserta) yang berelasi dengan tabel <code>penilaian_akhir</code> yang bernilai mula-mula 0.
                                </p>
                            </div>

                            
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-white shadow"></span>
                                <h4 class="font-bold text-gray-800 text-sm">Langkah 3: Pembuatan Jadwal & Pelaksanaan Pretest (Penilaian C1)</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    Operator mengaktifkan Ujian Pretest. Peserta masuk ke panel akun masing-masing untuk menjawab pertanyaan. Setelah ujian disubmit, sistem akan mengotomatisasi pengisian kolom <code>nilai_pretest</code> (kriteria C1) peserta dengan skala 0-100.
                                </p>
                            </div>

                            
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-white shadow"></span>
                                <h4 class="font-bold text-gray-800 text-sm">Langkah 4: Presensi Sesi Scan QR Code (Penilaian C5)</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    Pada setiap awal materi kajian, panitia membuka kamera scanner QR Code dan memindai ID card peserta. Setiap hasil scan akan menambah record log kehadiran. Nilai akhir kriteria C5 dihitung secara dinamis dari persentase materi yang dihadiri.
                                </p>
                            </div>

                            
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-white shadow"></span>
                                <h4 class="font-bold text-gray-800 text-sm">Langkah 5: Penginputan Evaluasi Praktik Psikomotorik (Penilaian C3)</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    **Penguji Ibadah / Fasilitator** membuka panel penginputan psikomotorik pada detail event, dan memberikan nilai (skor 1 s/d 4) untuk aspek-aspek praktik ibadah (wudhu, sholat, tayamum, mengaji) dan outbound. Nilai dikonversi otomatis oleh sistem ke skala 0-100 ke kolom <code>nilai_psikomotor</code>.
                                </p>
                            </div>

                            
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-white shadow"></span>
                                <h4 class="font-bold text-gray-800 text-sm">Langkah 6: Pengisian Kuesioner Afektif Mandiri (Penilaian C4)</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    **Peserta mengisi sendiri secara mandiri** kuisioner pernyataan sikap/karakter (skala Likert) pada halaman akun peserta masing-masing. Hasil isian peserta secara otomatis dikonversi oleh sistem ke skala 0-100 dan disimpan pada kolom <code>nilai_afektif</code>.
                                </p>
                            </div>

                            
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-white shadow"></span>
                                <h4 class="font-bold text-gray-800 text-sm">Langkah 7: Ujian Akhir Posttest (Penilaian C2)</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    Di akhir pelatihan, operator membuka sesi Posttest. Hasil pengerjaan soal pilihan ganda oleh peserta secara otomatis disimpan ke kolom <code>nilai_posttest</code> (kriteria C2).
                                </p>
                            </div>

                            
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-white shadow"></span>
                                <h4 class="font-bold text-gray-800 text-sm">Langkah 8: Sinkronisasi AHP-SAW (Peringkat Akhir)</h4>
                                <p class="text-xs text-gray-500 mt-1">
                                    Operator menyimpan konfigurasi bobot AHP. Saat operator menekan tombol <strong>Recalculate / Hitung Ranking SAW</strong>, sistem memproses normalisasi SAW untuk C1-C5 dari seluruh peserta, menghitung nilai preferensi akhir, menentukan status kelulusan, dan menetapkan urutan peringkat di database.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div x-show="activePage === 'simulasi'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-1 rounded-md">Simulasi Riil</span>
                        <h2 class="text-xl font-bold text-gray-800 font-heading mt-2">8. Simulasi Kasus Perhitungan Sistem</h2>
                        <p class="text-xs text-gray-400">Contoh perhitungan numerik dari nilai mentah peserta hingga hasil pemeringkatan akhir SAW sesuai dengan alur variabel data riil sistem.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-6 text-sm text-gray-600 leading-relaxed font-sans">
                        
                        
                        <div class="space-y-2">
                            <h3 class="font-bold text-gray-800 text-sm">Tahap 1: Data Mentah Nilai Peserta (Contoh Kasus 3 Alternatif)</h3>
                            <p class="text-xs">Berikut adalah contoh nilai mentah dari 3 orang peserta yang terdaftar:</p>
                            <div class="overflow-x-auto border border-gray-100 rounded-2xl">
                                <table class="w-full text-left text-xs border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-800 font-bold">
                                            <th class="p-3">Nama Peserta (Alternatif)</th>
                                            <th class="p-3">C1 (Pretest)</th>
                                            <th class="p-3">C2 (Posttest)</th>
                                            <th class="p-3">C3 (Psikomotor)</th>
                                            <th class="p-3">C4 (Afektif)</th>
                                            <th class="p-3">C5 (Kehadiran)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-b border-gray-50">
                                            <td class="p-3 font-semibold text-gray-800">Peserta A (A<sub>1</sub>)</td>
                                            <td class="p-3 font-mono">80.00</td>
                                            <td class="p-3 font-mono">85.00</td>
                                            <td class="p-3 font-mono">75.00</td>
                                            <td class="p-3 font-mono">90.00</td>
                                            <td class="p-3 font-mono">100.00</td>
                                        </tr>
                                        <tr class="border-b border-gray-50">
                                            <td class="p-3 font-semibold text-gray-800">Peserta B (A<sub>2</sub>)</td>
                                            <td class="p-3 font-mono">70.00</td>
                                            <td class="p-3 font-mono">95.00</td>
                                            <td class="p-3 font-mono">90.00</td>
                                            <td class="p-3 font-mono">80.00</td>
                                            <td class="p-3 font-mono">90.00</td>
                                        </tr>
                                        <tr class="border-b border-gray-50">
                                            <td class="p-3 font-semibold text-gray-800">Peserta C (A<sub>3</sub>)</td>
                                            <td class="p-3 font-mono">90.00</td>
                                            <td class="p-3 font-mono">80.00</td>
                                            <td class="p-3 font-mono">85.00</td>
                                            <td class="p-3 font-mono">95.00</td>
                                            <td class="p-3 font-mono">100.00</td>
                                        </tr>
                                        <tr class="bg-gray-50/50 font-bold">
                                            <td class="p-3 text-primary text-xs">Nilai Maksimum Kolom (Max)</td>
                                            <td class="p-3 font-mono text-primary">90.00</td>
                                            <td class="p-3 font-mono text-primary">95.00</td>
                                            <td class="p-3 font-mono text-primary">90.00</td>
                                            <td class="p-3 font-mono text-primary">95.00</td>
                                            <td class="p-3 font-mono text-primary">100.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        
                        <div class="space-y-2">
                            <h3 class="font-bold text-gray-800 text-sm">Tahap 2: Bobot Kriteria AHP yang Diperoleh (Contoh W)</h3>
                            <p class="text-xs">Diperoleh vektor bobot prioritas konsisten dari AHP untuk masing-masing kriteria:</p>
                            <div class="p-4 bg-gray-50 border border-gray-100 rounded-2xl font-mono text-xs text-center flex flex-wrap gap-4 justify-center">
                                <span>W<sub>C1</sub> (Pretest) = <strong>0.10</strong></span>
                                <span>W<sub>C2</sub> (Posttest) = <strong>0.25</strong></span>
                                <span>W<sub>C3</sub> (Psikomotor) = <strong>0.30</strong></span>
                                <span>W<sub>C4</sub> (Afektif) = <strong>0.25</strong></span>
                                <span>W<sub>C5</sub> (Kehadiran) = <strong>0.10</strong></span>
                            </div>
                        </div>

                        
                        <div class="space-y-2">
                            <h3 class="font-bold text-gray-800 text-sm">Tahap 3: Normalisasi Matriks SAW (Nilai r<sub>ij</sub>)</h3>
                            <p class="text-xs">Melakukan normalisasi dengan pembagi nilai maksimum kriteria (Benefit):</p>
                            <ul class="list-disc pl-5 text-xs text-slate-500 space-y-1">
                                <li>r<sub>11</sub> (Peserta A, C1) = 80.00 / 90.00 = <strong>0.8889</strong></li>
                                <li>r<sub>22</sub> (Peserta B, C2) = 95.00 / 95.00 = <strong>1.0000</strong></li>
                                <li>r<sub>33</sub> (Peserta C, C3) = 85.00 / 90.00 = <strong>0.9444</strong></li>
                            </ul>
                            <div class="overflow-x-auto border border-gray-100 rounded-2xl mt-2">
                                <table class="w-full text-left text-xs border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-800 font-bold">
                                            <th class="p-3">Alternatif</th>
                                            <th class="p-3">r<sub>i1</sub> (Pretest)</th>
                                            <th class="p-3">r<sub>i2</sub> (Posttest)</th>
                                            <th class="p-3">r<sub>i3</sub> (Psikomotor)</th>
                                            <th class="p-3">r<sub>i4</sub> (Afektif)</th>
                                            <th class="p-3">r<sub>i5</sub> (Kehadiran)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="font-mono">
                                        <tr class="border-b border-gray-50">
                                            <td class="p-3 font-semibold text-gray-800 font-sans">Peserta A (A<sub>1</sub>)</td>
                                            <td class="p-3">0.8889</td>
                                            <td class="p-3">0.8947</td>
                                            <td class="p-3">0.8333</td>
                                            <td class="p-3">0.9474</td>
                                            <td class="p-3">1.0000</td>
                                        </tr>
                                        <tr class="border-b border-gray-50">
                                            <td class="p-3 font-semibold text-gray-800 font-sans">Peserta B (A<sub>2</sub>)</td>
                                            <td class="p-3">0.7778</td>
                                            <td class="p-3">1.0000</td>
                                            <td class="p-3">1.0000</td>
                                            <td class="p-3">0.8421</td>
                                            <td class="p-3">0.9000</td>
                                        </tr>
                                        <tr class="border-b border-gray-50">
                                            <td class="p-3 font-semibold text-gray-800 font-sans">Peserta C (A<sub>3</sub>)</td>
                                            <td class="p-3">1.0000</td>
                                            <td class="p-3">0.8421</td>
                                            <td class="p-3">0.9444</td>
                                            <td class="p-3">1.0000</td>
                                            <td class="p-3">1.0000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        
                        <div class="space-y-2">
                            <h3 class="font-bold text-gray-800 text-sm">Tahap 4: Hasil Skor Preferensi (V<sub>i</sub>) & Peringkat Akhir</h3>
                            <p class="text-xs">Menghitung penjumlahan terbobot <code>V<sub>i</sub> = &Sigma; (W<sub>j</sub> * r<sub>ij</sub>)</code>:</p>
                            
                            <div class="p-4 bg-gray-50 border border-gray-100 rounded-2xl space-y-1.5 text-xs font-mono">
                                <div>V<sub>A</sub> = (0.10 * 0.8889) + (0.25 * 0.8947) + (0.30 * 0.8333) + (0.25 * 0.9474) + (0.10 * 1.0000) = <strong>0.8994</strong></div>
                                <div>V<sub>B</sub> = (0.10 * 0.7778) + (0.25 * 1.0000) + (0.30 * 1.0000) + (0.25 * 0.8421) + (0.10 * 0.9000) = <strong>0.9283</strong></div>
                                <div>V<sub>C</sub> = (0.10 * 1.0000) + (0.25 * 0.8421) + (0.30 * 0.9444) + (0.25 * 1.0000) + (0.10 * 1.0000) = <strong>0.9438</strong></div>
                            </div>

                            <p class="text-xs mt-3">Hasil akhir pemeringkatan yang disimpan ke tabel database:</p>
                            <div class="overflow-x-auto border border-gray-100 rounded-2xl">
                                <table class="w-full text-left text-xs border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-800 font-bold">
                                            <th class="p-3">Peringkat</th>
                                            <th class="p-3">Nama Peserta</th>
                                            <th class="p-3">Skor Preferensi (V<sub>i</sub>)</th>
                                            <th class="p-3">Predikat Nilai</th>
                                            <th class="p-3">Status Kelulusan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-b border-gray-50 bg-emerald-50/25">
                                            <td class="p-3 font-bold text-center">1</td>
                                            <td class="p-3 font-semibold">Peserta C</td>
                                            <td class="p-3 font-mono font-bold text-primary">0.9438</td>
                                            <td class="p-3 text-emerald-600 font-bold">Amat Baik</td>
                                            <td class="p-3 text-emerald-600 font-semibold">Lulus Sangat Memuaskan</td>
                                        </tr>
                                        <tr class="border-b border-gray-50">
                                            <td class="p-3 font-bold text-center">2</td>
                                            <td class="p-3 font-semibold">Peserta B</td>
                                            <td class="p-3 font-mono font-bold text-primary">0.9283</td>
                                            <td class="p-3 text-emerald-600 font-bold">Amat Baik</td>
                                            <td class="p-3 text-emerald-600 font-semibold">Lulus Sangat Memuaskan</td>
                                        </tr>
                                        <tr class="border-b border-gray-50">
                                            <td class="p-3 font-bold text-center">3</td>
                                            <td class="p-3 font-semibold">Peserta A</td>
                                            <td class="p-3 font-mono font-bold text-primary">0.8994</td>
                                            <td class="p-3 text-emerald-600 font-bold">Amat Baik</td>
                                            <td class="p-3 text-emerald-600 font-semibold">Lulus Sangat Memuaskan</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                
                <div x-show="activePage === 'akses'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-1 rounded-md">Hak Akses & Istilah</span>
                        <h2 class="text-xl font-bold text-gray-800 font-heading mt-2">9. Hak Akses Pengguna & Glosarium Istilah</h2>
                        <p class="text-xs text-gray-400">Penjelasan peran otorisasi sistem (Role-Based Access Control) dan glosarium istilah Baitul Arqam.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-6 text-sm text-gray-600">
                        
                        <div class="space-y-3">
                            <h3 class="font-bold text-gray-850 text-sm uppercase tracking-wider">Pembagian Peran Pengguna (User Roles):</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 space-y-1">
                                    <h4 class="font-bold text-xs text-gray-800">Administrator</h4>
                                    <p class="text-[11px] text-gray-500">Memiliki akses penuh atas seluruh data: kelola event, import peserta, set up bobot kriteria AHP, hitung peringkat SAW, dan cetak laporan akhir.</p>
                                </div>
                                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 space-y-1">
                                    <h4 class="font-bold text-xs text-gray-800">Fasilitator / Penguji</h4>
                                    <p class="text-[11px] text-gray-500">Membantu melakukan penilaian psikomotorik (C3) peserta kelompoknya. Membantu pemindaian presensi scan QR Code.</p>
                                </div>
                                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 space-y-1">
                                    <h4 class="font-bold text-xs text-gray-800">Peserta</h4>
                                    <p class="text-[11px] text-gray-500">Mengakses jadwal sesi, mengerjakan Pretest/Posttest, melakukan self-assessment afektif (C4), serta melihat sertifikat & hasil kelulusannya sendiri.</p>
                                </div>
                            </div>
                        </div>

                        
                        <div class="space-y-3">
                            <h3 class="font-bold text-gray-850 text-sm uppercase tracking-wider">Glosarium Istilah:</h3>
                            <div class="overflow-x-auto border border-gray-100 rounded-2xl">
                                <table class="w-full text-left text-xs border-collapse">
                                    <thead>
                                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-800 font-bold">
                                            <th class="p-3">Istilah</th>
                                            <th class="p-3">Definisi Singkat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-b border-gray-50">
                                            <td class="p-3 font-semibold text-gray-800">Baitul Arqam</td>
                                            <td class="p-3 text-gray-500">Bentuk pembinaan kemuhammadiyahan untuk menyamakan visi, pemikiran, dan amalan ibadah seluruh civitas akademika.</td>
                                        </tr>
                                        <tr class="border-b border-gray-50">
                                            <td class="p-3 font-semibold text-gray-800">Consistent Ratio (CR)</td>
                                            <td class="p-3 text-gray-500">Parameter ukur konsistensi pembuat keputusan AHP. Nilai batas toleransi ilmiah maksimal adalah 0.10.</td>
                                        </tr>
                                        <tr class="border-b border-gray-50">
                                            <td class="p-3 font-semibold text-gray-800">Benefit Criterion</td>
                                            <td class="p-3 text-gray-500">Jenis kriteria penilaian keputusan di mana nilai yang lebih besar dianggap lebih menguntungkan (benefit) bagi alternatif.</td>
                                        </tr>
                                        <tr class="border-b border-gray-50">
                                            <td class="p-3 font-semibold text-gray-800">Alternatif</td>
                                            <td class="p-3 text-gray-500">Istilah bagi entitas/pilihan dalam pendukung keputusan (dalam sistem ini adalah Peserta Baitul Arqam).</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div x-show="activePage === 'maintenance'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-1 rounded-md">Pemeliharaan & Cache</span>
                        <h2 class="text-xl font-bold text-gray-800 font-heading mt-2">10. Pemeliharaan & Pembersihan Cache Sistem</h2>
                        <p class="text-xs text-gray-400">Instruksi pembersihan cache (optimisasi view, config, route) dan perbaikan symlink di web server hosting.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-4 text-sm text-gray-600 leading-relaxed">
                        <p>
                            Saat melakukan pembaruan kode atau mengalami kendala tampilan asset/gambar yang tidak sinkron, Anda dapat menggunakan rute-rute pemeliharaan otomatis yang sudah disediakan sistem secara aman:
                        </p>

                        <div class="space-y-4 mt-4">
                            
                            <div class="p-5 border border-gray-100 rounded-3xl space-y-2 bg-gray-50/50">
                                <h4 class="font-bold text-gray-800 text-sm">1. Pembersihan Seluruh Cache Aplikasi</h4>
                                <p class="text-xs text-gray-500 leading-relaxed">
                                    Untuk menghapus cache view, konfigurasi lama, cache route, dan log cache foto sementara, buka tautan berikut di browser Anda:
                                </p>
                                <div class="p-3 bg-white border border-gray-100 rounded-xl font-mono text-[11px] text-center text-primary">
                                    domain-aplikasi.com/clear-opcache-action
                                </div>
                            </div>

                            
                            <div class="p-5 border border-gray-100 rounded-3xl space-y-2 bg-gray-50/50">
                                <h4 class="font-bold text-gray-800 text-sm">2. Regenerasi Symlink Direktori Storage</h4>
                                <p class="text-xs text-gray-500 leading-relaxed">
                                    Jika foto profil peserta atau asset gambar di hosting tidak tampil (error 404), tautan symlink storage Anda mungkin terputus. Lakukan regenerasi otomatis tanpa SSH dengan mengakses:
                                </p>
                                <div class="p-3 bg-white border border-gray-100 rounded-xl font-mono text-[11px] text-center text-primary">
                                    domain-aplikasi.com/generate-symlink
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div x-show="activePage === 'changelog'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest bg-primary/10 px-2.5 py-1 rounded-md">Riwayat Pembaruan</span>
                        <h2 class="text-xl font-bold text-gray-800 font-heading mt-2">11. Changelog & Riwayat Pembaruan Sistem</h2>
                        <p class="text-xs text-gray-400">Pencatatan rilis versi (versioning) dan perbaikan bug/fitur yang telah diimplementasikan.</p>
                    </div>
                    <hr class="border-gray-100">
                    <div class="space-y-6 text-sm text-gray-600 leading-relaxed">
                        
                        
                        <details class="group bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm mb-4" open>
                            <summary class="cursor-pointer p-4 bg-gray-50 flex items-center justify-between font-heading font-bold text-gray-800 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-2.5 h-2.5 bg-primary rounded-full shadow-[0_0_0_3px_rgba(26,109,155,0.2)]"></span>
                                    v2.0.1 (12 Juni 2026) <span class="text-[10px] font-bold px-2 py-1 bg-green-100 text-green-700 rounded-lg ml-2">Terbaru</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </summary>
                            <div class="p-5 border-t border-gray-100">
                                <p class="text-xs text-gray-500 mb-3">Rilis penyempurnaan UI/UX, penyesuaian form, dan perbaikan keamanan (*Security & Bug Fixes*).</p>
                                <ul class="list-disc pl-4 text-xs space-y-1.5 text-gray-600">
                                    <li><strong>Enhancement (Form Pendaftaran):</strong> Menambahkan fitur Konfirmasi Kehadiran di awal. Peserta yang "Tidak Bersedia" dapat memberikan alasan & submit tanpa memproses seluruh formulir.</li>
                                    <li><strong>Enhancement (Alamat & Domisili):</strong> Pemisahan input <em>Alamat Sesuai KTP</em> dan <em>Wilayah Domisili</em>. Dropdown Provinsi sekarang mengambil data seluruh Indonesia dari API EMSIFA, bukan hanya Jawa Tengah.</li>
                                    <li><strong>Bug Fix (Profil):</strong> Memperbaiki bug di mana input <em>checkbox</em> (contoh: Kemampuan Bahasa) tidak terhapus di profil ketika peserta mengosongkan pilihannya.</li>
                                    <li><strong>Enhancement (Label):</strong> Penggantian label UI dari "Harapan PCM" menjadi "Harapan Baitul Arqam" (digabung) dan "NIK" menjadi "NIK / NBM".</li>
                                    <li><strong>Redesain (Landing Page):</strong> Mengubah tampilan *event* menjadi model *Timeline Linimasa (Accordion)* interaktif.</li>
                                    <li><strong>Fix (Kuota Logika):</strong> Memperbaiki bug persentase *progress bar* di mana event berkuota tak terbatas (0) salah dilabeli penuh.</li>
                                    <li><strong>Enhancement (Dokumentasi):</strong> Merapikan antarmuka changelog menjadi model <em>dropdown (accordion)</em>.</li>
                                    <li><strong>Security (Sistem):</strong> Menutup celah bypass IDOR pada EventController.</li>
                                </ul>
                            </div>
                        </details>

                        
                        <details class="group bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
                            <summary class="cursor-pointer p-4 bg-gray-50 flex items-center justify-between font-heading font-bold text-gray-800 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-2.5 h-2.5 bg-gray-400 rounded-full"></span>
                                    v2.0.0 (Rilis Stabil)
                                </div>
                                <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </summary>
                            <div class="p-5 border-t border-gray-100">
                                <p class="text-xs text-gray-500 mb-3">Rilis utama fungsionalitas AHP-SAW dan manajemen Baitul Arqam.</p>
                                <ul class="list-disc pl-4 text-xs space-y-1.5 text-gray-500">
                                    <li><strong>Fitur:</strong> Implementasi sistem pendukung keputusan (SPK) integrasi AHP dan SAW.</li>
                                    <li><strong>Fitur:</strong> Presensi digital berbasis *QR-Code* dengan enkripsi *hash*.</li>
                                    <li><strong>Fitur:</strong> Bank soal dinamis untuk ujian pretest dan posttest kognitif peserta.</li>
                                    <li><strong>Fitur:</strong> Template rubrik dinamis untuk evaluasi afektif dan ujian psikomotorik.</li>
                                    <li><strong>Fitur:</strong> Cetak sertifikat dinamis dan laporan format PDF & Excel terintegrasi.</li>
                                </ul>
                            </div>
                        </details>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/admin/documentation.blade.php ENDPATH**/ ?>