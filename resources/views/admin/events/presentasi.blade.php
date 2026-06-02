<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presentasi Analisis – {{ $event->nama_event }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 900: '#002147', 800: '#003366', 700: '#004080' },
                        yellow: { 400: '#FFD100', 500: '#EAB308' }
                    },
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { margin: 0; overflow: hidden; background: #f8fafc; color: #002147; }
        #wrap { width: 100vw; height: 100vh; position: relative; }
        .slide { position: absolute; inset: 0; display: flex; flex-direction: column; opacity: 0; visibility: hidden; transition: opacity 0.5s ease, visibility 0.5s ease; background: #ffffff; z-index: 0; }
        .slide.active { opacity: 1; visibility: visible; z-index: 10; }
        
        /* Modern Kuning Geometric Shapes */
        .shape-yellow-left { position: absolute; left: 0; top: 0; bottom: 0; width: 300px; background-color: #FFD100; clip-path: polygon(0 0, 100% 0, 70% 100%, 0% 100%); z-index: 1; }
        .shape-navy-right { position: absolute; right: 0; top: 0; bottom: 0; width: 40%; background-color: #002147; clip-path: polygon(30% 0, 100% 0, 100% 100%, 0% 100%); z-index: 1; }
        .shape-yellow-corner { position: absolute; right: 0; bottom: 0; width: 250px; height: 250px; background-color: #FFD100; clip-path: polygon(100% 0, 0% 100%, 100% 100%); z-index: 2; }
        .shape-navy-header { position: absolute; left: 0; top: 0; right: 0; height: 120px; background-color: #002147; clip-path: polygon(0 0, 100% 0, 100% 100%, 0 70%); z-index: 1; }
        .shape-yellow-bar { position: absolute; left: 0; top: 0; bottom: 0; width: 40px; background-color: #FFD100; z-index: 2; }
        
        /* Animations */
        .anim-up, .anim-fade, .anim-right { opacity: 0; }
        .slide.active .anim-up   { animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .slide.active .anim-fade { animation: fadeIn 1s ease forwards; }
        .slide.active .anim-right{ animation: slideRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        
        @keyframes slideUp { from { opacity: 0; transform: translateY(50px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideRight { from { opacity: 0; transform: translateX(-50px); } to { opacity: 1; transform: translateX(0); } }
        
        .d1 { animation-delay: 0.1s; } .d2 { animation-delay: 0.2s; } .d3 { animation-delay: 0.3s; } .d4 { animation-delay: 0.4s; } .d5 { animation-delay: 0.5s; }
        
        /* Navigation */
        .nav-btn { position: fixed; bottom: 30px; z-index: 100; background: #002147; color: white; border: none; padding: 12px 24px; border-radius: 4px; cursor: pointer; font-weight: 700; transition: all 0.3s; border-bottom: 4px solid #00122a; }
        .nav-btn:hover { background: #FFD100; color: #002147; border-bottom: 4px solid #ccaa00; transform: translateY(-2px); }
        #ind { position: fixed; bottom: 40px; left: 50%; transform: translateX(-50%); z-index: 100; color: #002147; font-weight: 800; font-size: 1rem; background: rgba(255, 209, 0, 0.9); padding: 5px 15px; border-radius: 20px; }
        
        /* Content Styling */
        .content-box { background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 33, 71, 0.08); padding: 1.5rem; border-top: 5px solid #FFD100; }
        .title-accent { display: inline-block; padding-bottom: 5px; border-bottom: 5px solid #FFD100; margin-bottom: 1.5rem; }
    </style>
</head>
<body>
<div id="wrap">

{{-- ═══ SLIDE 1: COVER ═══ --}}
<div class="slide active p-10 flex" id="s1">
    <div class="shape-yellow-left"></div>
    <div class="shape-navy-right"></div>
    
    <div class="z-10 w-full h-full flex items-center">
        <div class="w-1/2 pl-12 pr-8 anim-right">
            <div class="flex items-center gap-4 mb-10">
                <img src="{{ asset('logo-mpksdi-1.png') }}" class="h-20" alt="Logo MPKSDI" onerror="this.src='https://upload.wikimedia.org/wikipedia/id/thumb/6/6f/Logo_Muhammadiyah.svg/1024px-Logo_Muhammadiyah.svg.png'">
                <div>
                    <p class="text-sm font-black text-navy-900 tracking-widest uppercase">MPKSDI</p>
                    <p class="text-sm font-bold text-gray-600 tracking-wide uppercase">Laporan Perkaderan</p>
                </div>
            </div>
            
            <h2 class="text-2xl font-bold text-navy-900 mb-2">PRESENTASI ANALISIS</h2>
            <h1 class="text-5xl md:text-6xl font-black text-navy-900 leading-tight mb-8 uppercase">{{ $event->nama_event }}</h1>
            
            <div class="w-32 h-3 bg-yellow-400 mb-8"></div>
            
            <p class="text-lg text-gray-700 font-semibold mb-2 flex items-center gap-3">
                <svg class="w-6 h-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $event->lokasi }}
            </p>
            <p class="text-lg text-gray-700 font-semibold flex items-center gap-3">
                <svg class="w-6 h-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d F Y') }} – {{ \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d F Y') }}
            </p>
        </div>
        
        <div class="w-1/2 flex flex-col justify-center items-end pr-20 anim-up d3">
            <div class="bg-white p-8 rounded-xl shadow-2xl mb-6 border-l-8 border-yellow-400 w-80 text-center transform hover:scale-105 transition-transform">
                <h3 class="text-6xl font-black text-navy-900">{{ $total }}</h3>
                <p class="text-gray-500 font-bold uppercase tracking-widest mt-2">Total Peserta</p>
            </div>
            <div class="bg-yellow-400 p-8 rounded-xl shadow-2xl w-80 text-center transform hover:scale-105 transition-transform">
                <h3 class="text-4xl font-black text-navy-900 uppercase">{{ $event->status }}</h3>
                <p class="text-navy-800 font-bold uppercase tracking-widest mt-2">Status Acara</p>
            </div>
        </div>
    </div>
</div>

{{-- ═══ SLIDE 2: DEMOGRAFI ═══ --}}
<div class="slide p-10 pt-24" id="s2">
    <div class="shape-yellow-bar"></div>
    <div class="shape-navy-header"></div>
    <div class="shape-yellow-corner"></div>
    
    <div class="z-10 absolute top-8 left-16">
        <h2 class="text-3xl font-black text-white tracking-wider uppercase">Profil Peserta</h2>
    </div>
    <div class="z-10 absolute top-8 right-16">
        <img src="{{ asset('logo-mpksdi-1.png') }}" class="h-12 brightness-0 invert" alt="Logo" onerror="this.style.display='none'">
    </div>

    <div class="max-w-6xl w-full mx-auto mt-12 z-10 grid grid-cols-1 md:grid-cols-2 gap-10">
        <div class="content-box anim-up d1 flex flex-col items-center">
            <h3 class="text-2xl font-bold text-navy-900 title-accent">Jenis Kelamin</h3>
            <div class="h-64 w-full flex justify-center"><canvas id="cGender"></canvas></div>
            <div class="flex gap-10 mt-6 w-full justify-center">
                <div class="text-center"><p class="text-4xl font-black text-navy-900">{{ $lakiLaki }}</p><p class="text-sm font-semibold text-gray-500 uppercase mt-1">Laki-laki</p></div>
                <div class="text-center"><p class="text-4xl font-black text-yellow-500">{{ $perempuan }}</p><p class="text-sm font-semibold text-gray-500 uppercase mt-1">Perempuan</p></div>
            </div>
        </div>
        
        <div class="content-box anim-up d2 flex flex-col items-center">
            <h3 class="text-2xl font-bold text-navy-900 title-accent">Status Pernikahan</h3>
            <div class="h-64 w-full flex justify-center"><canvas id="cStatus"></canvas></div>
            <div class="flex gap-10 mt-6 w-full justify-center">
                <div class="text-center"><p class="text-4xl font-black text-navy-900">{{ $menikah }}</p><p class="text-sm font-semibold text-gray-500 uppercase mt-1">Menikah</p></div>
                <div class="text-center"><p class="text-4xl font-black text-yellow-500">{{ $belumNikah }}</p><p class="text-sm font-semibold text-gray-500 uppercase mt-1">Belum Menikah</p></div>
            </div>
        </div>
    </div>
</div>

{{-- ═══ SLIDE 3: USIA & BAHASA ═══ --}}
<div class="slide p-10 pt-24" id="s3">
    <div class="shape-yellow-bar"></div>
    <div class="shape-navy-header"></div>
    <div class="shape-yellow-corner"></div>
    
    <div class="z-10 absolute top-8 left-16">
        <h2 class="text-3xl font-black text-white tracking-wider uppercase">Usia & Bahasa</h2>
    </div>

    <div class="max-w-6xl w-full mx-auto mt-12 z-10 grid grid-cols-1 md:grid-cols-2 gap-10">
        <div class="content-box anim-up d1">
            <h3 class="text-2xl font-bold text-navy-900 title-accent text-center w-full block">Sebaran Umur (Tahun)</h3>
            <div class="h-80"><canvas id="cUmur"></canvas></div>
        </div>
        <div class="content-box anim-up d2">
            <h3 class="text-2xl font-bold text-navy-900 title-accent text-center w-full block">Penguasaan Bahasa Asing</h3>
            <div class="h-80"><canvas id="cBahasa"></canvas></div>
        </div>
    </div>
</div>

{{-- ═══ SLIDE 4: AL-QUR'AN ═══ --}}
<div class="slide p-10 pt-24" id="s4">
    <div class="shape-yellow-bar"></div>
    <div class="shape-navy-header"></div>
    <div class="shape-yellow-corner"></div>
    
    <div class="z-10 absolute top-8 left-16">
        <h2 class="text-3xl font-black text-white tracking-wider uppercase">Keahlian Al-Qur'an</h2>
    </div>

    <div class="max-w-6xl w-full mx-auto mt-12 z-10 grid grid-cols-1 md:grid-cols-2 gap-10">
        <div class="content-box anim-up d1 flex flex-col items-center">
            <h3 class="text-2xl font-bold text-navy-900 title-accent">Kemampuan Membaca</h3>
            <div class="h-80 w-full"><canvas id="cQuran"></canvas></div>
        </div>
        <div class="content-box anim-up d2 flex flex-col items-center">
            <h3 class="text-2xl font-bold text-navy-900 title-accent">Hafalan Qur'an</h3>
            <div class="h-80 w-full"><canvas id="cHafalan"></canvas></div>
        </div>
    </div>
</div>

{{-- ═══ SLIDE 5: AKTIVITAS ═══ --}}
<div class="slide p-10 pt-24" id="s5">
    <div class="shape-yellow-bar"></div>
    <div class="shape-navy-header"></div>
    <div class="shape-yellow-corner"></div>
    
    <div class="z-10 absolute top-8 left-16">
        <h2 class="text-3xl font-black text-white tracking-wider uppercase">Aktivitas Keagamaan & Organisasi</h2>
    </div>

    <div class="max-w-7xl w-full mx-auto mt-16 z-10 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="content-box anim-up d1">
            <h3 class="text-lg font-bold text-navy-900 text-center mb-4 border-b-2 border-yellow-400 pb-2">Sholat di Masjid</h3>
            <div class="h-64"><canvas id="cSholat"></canvas></div>
        </div>
        <div class="content-box anim-up d2">
            <h3 class="text-lg font-bold text-navy-900 text-center mb-4 border-b-2 border-yellow-400 pb-2">Kajian Agama</h3>
            <div class="h-64"><canvas id="cKajian"></canvas></div>
        </div>
        <div class="content-box anim-up d3">
            <h3 class="text-lg font-bold text-navy-900 text-center mb-4 border-b-2 border-yellow-400 pb-2">Keaktifan Muhammadiyah</h3>
            <div class="h-64"><canvas id="cKeaktifan"></canvas></div>
        </div>
    </div>
</div>

{{-- ═══ SLIDE 6: KEHADIRAN ═══ --}}
<div class="slide p-10 pt-24" id="s6">
    <div class="shape-yellow-bar"></div>
    <div class="shape-navy-header"></div>
    <div class="shape-yellow-corner"></div>
    
    <div class="z-10 absolute top-8 left-16">
        <h2 class="text-3xl font-black text-white tracking-wider uppercase">Tingkat Kehadiran Per Sesi</h2>
    </div>

    <div class="max-w-6xl w-full mx-auto mt-12 z-10">
        <div class="content-box anim-up d1 h-96">
            <canvas id="cHadir"></canvas>
        </div>
        <div class="mt-8 text-center anim-fade d3">
            <p class="text-navy-900 font-semibold bg-yellow-100 inline-block px-6 py-3 rounded-full border border-yellow-400">Total Peserta Aktif Terdaftar: <span class="font-black text-xl ml-2">{{ $total }} Orang</span></p>
        </div>
    </div>
</div>

{{-- ═══ SLIDE 7: PENILAIAN ═══ --}}
<div class="slide p-10 flex flex-col justify-center items-center bg-navy-900" id="s7">
    <div class="shape-yellow-left w-20"></div>
    <div class="shape-yellow-corner opacity-50"></div>
    
    <div class="z-10 w-full max-w-6xl text-center">
        <h2 class="text-5xl font-black text-yellow-400 mb-2 uppercase anim-up">Rata-Rata Penilaian</h2>
        <p class="text-white text-lg font-light tracking-widest uppercase mb-10 anim-up d1">Evaluasi Akhir Baitul Arqam</p>
        
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-10 anim-up d2">
            @php
                $nilais = [
                    ['label'=>'Pre-test','val'=>$avgPretest,'color'=>'text-blue-500'],
                    ['label'=>'Post-test','val'=>$avgPosttest,'color'=>'text-green-500'],
                    ['label'=>'Afektif','val'=>$avgAfektif,'color'=>'text-red-500'],
                    ['label'=>'Psikomotor','val'=>$avgPsikomotor,'color'=>'text-purple-500'],
                    ['label'=>'Kehadiran','val'=>$avgKehadiran,'color'=>'text-orange-500'],
                ];
            @endphp
            @foreach($nilais as $n)
            <div class="bg-white rounded-xl shadow-xl p-6 border-b-4 border-yellow-400 transform hover:-translate-y-2 transition-transform">
                <div class="text-4xl font-black {{ $n['color'] }}">{{ number_format($n['val'],1) }}</div>
                <div class="text-xs font-bold text-navy-900 mt-2 uppercase tracking-wider">{{ $n['label'] }}</div>
            </div>
            @endforeach
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-2xl mx-auto w-full max-w-2xl anim-up d3 h-72 border-4 border-navy-800">
            <canvas id="cNilai"></canvas>
        </div>
    </div>
</div>

{{-- ═══ SLIDE 8: DISTRIBUSI KELULUSAN ═══ --}}
<div class="slide p-10 pt-24" id="s8">
    <div class="shape-yellow-bar"></div>
    <div class="shape-navy-header"></div>
    <div class="shape-yellow-corner"></div>
    
    <div class="z-10 absolute top-8 left-16">
        <h2 class="text-3xl font-black text-white tracking-wider uppercase">Penilaian Menyeluruh</h2>
    </div>

    <div class="max-w-7xl w-full mx-auto mt-12 z-10 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="content-box anim-up d1 flex flex-col items-center">
            <h3 class="text-xl font-bold text-navy-900 title-accent">Sebaran Kelulusan</h3>
            <div class="h-80 w-full"><canvas id="cKelulusan"></canvas></div>
        </div>
        <div class="content-box anim-up d2 flex flex-col items-center">
            <h3 class="text-xl font-bold text-navy-900 title-accent">Distribusi Predikat</h3>
            <div class="h-80 w-full"><canvas id="cPredikat"></canvas></div>
        </div>
        <div class="content-box anim-up d3 flex flex-col items-center">
            <h3 class="text-xl font-bold text-navy-900 title-accent">Feedback Penyelenggaraan</h3>
            <div class="h-80 w-full"><canvas id="cAngket"></canvas></div>
        </div>
    </div>
</div>

{{-- ═══ SLIDE 9: TOP PESERTA ═══ --}}
<div class="slide p-10 pt-24" id="s9">
    <div class="shape-yellow-bar"></div>
    <div class="shape-navy-header h-32"></div>
    <div class="absolute right-0 top-0 w-1/3 h-full bg-yellow-400 clip-path: polygon(20% 0, 100% 0, 100% 100%, 0% 100%); z-0 transform skewX(-10deg) translate-x-10"></div>
    
    <div class="z-10 absolute top-10 left-16 text-center w-[calc(100%-128px)]">
        <h2 class="text-5xl font-black text-white tracking-widest uppercase shadow-sm">Peserta Terbaik</h2>
    </div>

    <div class="max-w-6xl w-full mx-auto mt-20 z-10 relative grid grid-cols-3 gap-8 items-end h-[60vh]">
        
        {{-- Juara 2 --}}
        <div class="bg-white rounded-t-2xl shadow-2xl border-4 border-b-0 border-navy-900 p-8 text-center anim-up d3 relative h-[80%] flex flex-col justify-start pt-16">
            <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 w-20 h-20 bg-gray-200 text-gray-600 font-black text-4xl rounded-full flex items-center justify-center shadow-lg border-4 border-white">2</div>
            @if(isset($top3[1]))
            <h3 class="text-xl font-bold text-navy-900 uppercase">{{ $top3[1]->peserta->nama_lengkap ?? '-' }}</h3>
            <p class="text-gray-500 text-sm mt-2">{{ $top3[1]->peserta->unit_kerja ?? '' }}</p>
            <div class="mt-auto">
                <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">Skor Akhir</p>
                <p class="text-4xl font-black text-navy-900">{{ number_format($top3[1]->skor_saw ?? 0, 3) }}</p>
            </div>
            @else
            <p class="text-gray-400">Belum ada data</p>
            @endif
        </div>

        {{-- Juara 1 --}}
        <div class="bg-yellow-400 rounded-t-2xl shadow-2xl border-4 border-b-0 border-navy-900 p-8 text-center anim-up d1 relative h-full flex flex-col justify-start pt-20 z-20 transform scale-105">
            <div class="absolute -top-12 left-1/2 transform -translate-x-1/2 w-24 h-24 bg-white text-yellow-500 font-black text-5xl rounded-full flex items-center justify-center shadow-2xl border-4 border-navy-900">1</div>
            <div class="absolute -top-16 right-4 text-5xl">👑</div>
            @if(isset($top3[0]))
            <h3 class="text-2xl font-black text-navy-900 uppercase leading-snug">{{ $top3[0]->peserta->nama_lengkap ?? '-' }}</h3>
            <p class="text-navy-800 font-semibold text-sm mt-3">{{ $top3[0]->peserta->unit_kerja ?? '' }}</p>
            <div class="mt-auto bg-white/40 p-4 rounded-xl backdrop-blur-sm">
                <p class="text-xs text-navy-900 uppercase tracking-widest font-bold mb-1">Skor Akhir Tertinggi</p>
                <p class="text-5xl font-black text-navy-900">{{ number_format($top3[0]->skor_saw ?? 0, 3) }}</p>
            </div>
            @else
            <p class="text-navy-900/60">Belum ada data</p>
            @endif
        </div>

        {{-- Juara 3 --}}
        <div class="bg-white rounded-t-2xl shadow-2xl border-4 border-b-0 border-navy-900 p-8 text-center anim-up d2 relative h-[70%] flex flex-col justify-start pt-14">
            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 w-16 h-16 bg-orange-100 text-orange-600 font-black text-3xl rounded-full flex items-center justify-center shadow-lg border-4 border-white">3</div>
            @if(isset($top3[2]))
            <h3 class="text-lg font-bold text-navy-900 uppercase">{{ $top3[2]->peserta->nama_lengkap ?? '-' }}</h3>
            <p class="text-gray-500 text-sm mt-2">{{ $top3[2]->peserta->unit_kerja ?? '' }}</p>
            <div class="mt-auto">
                <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">Skor Akhir</p>
                <p class="text-3xl font-black text-navy-900">{{ number_format($top3[2]->skor_saw ?? 0, 3) }}</p>
            </div>
            @else
            <p class="text-gray-400">Belum ada data</p>
            @endif
        </div>

    </div>
</div>

</div>{{-- end #wrap --}}

<button class="nav-btn" style="left:30px" onclick="go(-1)">&#10094; Sebelumnya</button>
<div id="ind">1 / 9</div>
<button class="nav-btn" style="right:30px" onclick="go(1)">Selanjutnya &#10095;</button>

<script>
let cur = 0;
const slides = document.querySelectorAll('.slide');
const ind = document.getElementById('ind');
let charted = false;

function go(dir) {
    const next = cur + dir;
    if (next < 0 || next >= slides.length) return;
    slides[cur].classList.remove('active');
    cur = next;
    slides[cur].classList.add('active');
    ind.innerText = (cur + 1) + ' / ' + slides.length;
    if (!charted && cur >= 1) { buildCharts(); charted = true; }
}

document.addEventListener('keydown', e => {
    if (e.key === 'ArrowRight' || e.key === ' ') go(1);
    else if (e.key === 'ArrowLeft') go(-1);
});

// Data provided from backend controller
const D = {
    gender:  { labels: ['Laki-laki','Perempuan'], data: [{{ $lakiLaki }}, {{ $perempuan }}] },
    status:  { labels: ['Menikah','Belum Menikah'], data: [{{ $menikah }}, {{ $belumNikah }}] },
    umur:    { labels: {!! json_encode($umurLabels) !!}, data: {!! json_encode($umurData) !!} },
    bahasa:  { labels: {!! json_encode(array_keys($bahasaCount)) !!}, data: {!! json_encode(array_values($bahasaCount)) !!} },
    quran:   { labels: {!! json_encode($kemampuanQuran->keys()->toArray()) !!}, data: {!! json_encode($kemampuanQuran->values()->toArray()) !!} },
    hafalan: { labels: {!! json_encode($hafalan->keys()->toArray()) !!}, data: {!! json_encode($hafalan->values()->toArray()) !!} },
    sholat:  { labels: {!! json_encode($aktivitasSholat->keys()->toArray()) !!}, data: {!! json_encode($aktivitasSholat->values()->toArray()) !!} },
    kajian:  { labels: {!! json_encode($kajianAgama->keys()->toArray()) !!}, data: {!! json_encode($kajianAgama->values()->toArray()) !!} },
    keaktifan:{ labels: {!! json_encode(array_keys($keaktifanCount)) !!}, data: {!! json_encode(array_values($keaktifanCount)) !!} },
    hadir:   { labels: {!! json_encode($absensiPerSesi->pluck('nama')->toArray()) !!}, data: {!! json_encode($absensiPerSesi->pluck('hadir')->toArray()) !!}, total: {{ $total }} },
    nilai:   { labels: ['Pre-test','Post-test','Afektif','Psikomotor','Kehadiran'], data: [{{ round($avgPretest,1) }},{{ round($avgPosttest,1) }},{{ round($avgAfektif,1) }},{{ round($avgPsikomotor,1) }},{{ round($avgKehadiran,1) }}] },
    kelulusan: { labels: {!! json_encode($kelulusan->keys()->toArray()) !!}, data: {!! json_encode($kelulusan->values()->toArray()) !!} },
    predikat:  { labels: {!! json_encode($predikat->keys()->toArray()) !!}, data: {!! json_encode($predikat->values()->toArray()) !!} },
    angket:    { labels: {!! json_encode($angket->keys()->toArray()) !!}, data: {!! json_encode($angket->values()->toArray()) !!} },
};

const PALETTE = ['#002147', '#FFD100', '#004080', '#eab308', '#003366', '#fcd34d'];

function pie(id, labels, data) {
    new Chart(document.getElementById(id), { type:'pie', data:{ labels, datasets:[{ data, backgroundColor: PALETTE, borderWidth:3, borderColor:'#fff' }] }, options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ position:'bottom', labels:{ color: '#002147', font:{size:12, family:'Montserrat', weight:'bold'} } } } } });
}
function donut(id, labels, data) {
    new Chart(document.getElementById(id), { type:'doughnut', data:{ labels, datasets:[{ data, backgroundColor: PALETTE, borderWidth:2, borderColor:'#fff' }] }, options:{ responsive:true, maintainAspectRatio:false, cutout:'60%', plugins:{ legend:{ position:'bottom', labels:{ color: '#002147', font:{size:11, family:'Montserrat', weight:'bold'} } } } } });
}
function bar(id, labels, data, color='#002147', horiz=false) {
    new Chart(document.getElementById(id), { type:'bar', data:{ labels, datasets:[{ data, backgroundColor:color, borderRadius:4 }] }, options:{ indexAxis: horiz?'y':'x', responsive:true, maintainAspectRatio:false, plugins:{ legend:{ display:false } }, scales:{ x:{ticks:{font:{family:'Montserrat', weight:'600'}, color:'#002147'}}, y:{ticks:{font:{family:'Montserrat'}, color:'#002147'}} } } });
}
function radar(id, labels, data) {
    new Chart(document.getElementById(id), { type:'radar', data:{ labels, datasets:[{ data, backgroundColor:'rgba(255, 209, 0, 0.3)', borderColor:'#FFD100', pointBackgroundColor:'#002147', borderWidth:3 }] }, options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{display:false} }, scales:{ r:{ max:100, min:0, ticks:{display:false}, pointLabels:{font:{family:'Montserrat', weight:'bold', size: 14}, color:'#002147'} } } } });
}

function buildCharts() {
    Chart.defaults.font.family = 'Montserrat';
    Chart.defaults.color = '#002147';

    pie('cGender', D.gender.labels, D.gender.data);
    pie('cStatus', D.status.labels, D.status.data);
    bar('cUmur',   D.umur.labels,   D.umur.data, '#002147');
    bar('cBahasa', D.bahasa.labels, D.bahasa.data, '#FFD100', true);
    donut('cQuran',   D.quran.labels,   D.quran.data);
    donut('cHafalan', D.hafalan.labels, D.hafalan.data);
    pie('cSholat',   D.sholat.labels,   D.sholat.data);
    pie('cKajian',   D.kajian.labels,   D.kajian.data);
    bar('cKeaktifan',D.keaktifan.labels,D.keaktifan.data, '#002147');

    new Chart(document.getElementById('cHadir'), {
        type: 'bar',
        data: { labels: D.hadir.labels, datasets: [{ data: D.hadir.data, backgroundColor: '#FFD100', borderRadius: 4 }] },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend:{ display:false } }, scales: { y:{ max: D.hadir.total + 2, ticks:{ font:{family:'Montserrat'} } }, x:{ ticks:{ font:{family:'Montserrat', size:11, weight:'bold'} } } } }
    });

    radar('cNilai', D.nilai.labels, D.nilai.data);
    pie('cKelulusan', D.kelulusan.labels, D.kelulusan.data);
    pie('cPredikat', D.predikat.labels, D.predikat.data);
    donut('cAngket', D.angket.labels, D.angket.data);
}
</script>
</body>
</html>
