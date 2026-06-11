{{-- Laporan Tab Content --}}
<div class="space-y-6">

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
