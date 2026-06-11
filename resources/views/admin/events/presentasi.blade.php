<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <title>Laporan Pelaksanaan Baitul Arqam  – {{ $event->nama_event }}</title>
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
        .slide { 
            position: absolute; 
            inset: 0; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            opacity: 0; 
            visibility: hidden; 
            transform: scale(0.96) translateY(20px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.8s; 
            background: #ffffff; 
            z-index: 0; 
            padding: 100px 4rem 80px 4rem; 
            box-sizing: border-box;
        }
        .slide.active { 
            opacity: 1; 
            visibility: visible; 
            transform: scale(1) translateY(0);
            z-index: 10; 
        }
        
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
        
        /* Content Styling */
        .content-box { background: white; border-radius: 6px; box-shadow: 0 10px 30px rgba(0, 33, 71, 0.08); padding: 1.5rem; border-top: 5px solid #FFD100; }
        .title-accent { display: inline-block; padding-bottom: 5px; border-bottom: 5px solid #FFD100; margin-bottom: 1.5rem; }
        
        /* Premium Stat Card */
        .premium-card { background: rgba(255, 255, 255, 0.85); border-left: 6px solid #002147; border-radius: 8px; box-shadow: 0 4px 15px rgba(0, 33, 71, 0.04); padding: 1.2rem; border-top: 1px solid rgba(226, 232, 240, 0.8); }

        /* PRELOADER SCREEN */
        #preloader {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at center, #002147 0%, #00122a 100%);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.8s;
        }
        #preloader.loaded {
            opacity: 0;
            visibility: hidden;
        }
        .preloader-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 209, 0, 0.1);
            border-top-color: #FFD100;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 1.5rem;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .pulse-logo {
            animation: pulse 2.5s infinite ease-in-out;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); filter: drop-shadow(0 0 10px rgba(255, 209, 0, 0.2)); }
            50% { transform: scale(1.06); filter: drop-shadow(0 0 25px rgba(255, 209, 0, 0.5)); }
        }

        /* SIDEBAR MENU */
        #sidebar {
            position: fixed;
            top: 0;
            right: -360px;
            width: 360px;
            height: 100vh;
            background: rgba(0, 33, 71, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            transition: right 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            border-left: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
        }
        #sidebar.open {
            right: 0;
        }
        .sidebar-item {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .sidebar-item.active {
            background: rgba(255, 209, 0, 0.15);
            border-left-color: #FFD100;
            color: #FFD100 !important;
        }
        .sidebar-item:hover:not(.active) {
            background: rgba(255, 255, 255, 0.05);
            border-left-color: rgba(255, 255, 255, 0.2);
            transform: translateX(4px);
        }

        /* BOTTOM DOTS NAVIGATION */
        .dots-nav {
            position: fixed;
            bottom: 22px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 100;
            background: rgba(0, 33, 71, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 9999px;
            padding: 8px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        .dot-item {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.35);
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }
        .dot-item.active {
            width: 28px;
            height: 10px;
            border-radius: 9999px;
            background: #FFD100;
            box-shadow: 0 0 12px rgba(255, 209, 0, 0.6);
        }
        .dot-item:hover:not(.active) {
            background: rgba(255, 255, 255, 0.8);
            transform: scale(1.3);
        }
        
        .dot-tooltip {
            position: absolute;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            background: #002147;
            color: #fff;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .dot-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border-width: 5px;
            border-style: solid;
            border-color: #002147 transparent transparent transparent;
        }
        .dot-item:hover .dot-tooltip {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }

        /* FLOATING NAVIGATION BUTTONS */
        .menu-trigger {
            position: fixed;
            top: 25px;
            right: 25px;
            z-index: 999;
            background: rgba(0, 33, 71, 0.8);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .menu-trigger:hover {
            background: #FFD100;
            color: #002147;
            transform: scale(1.08) rotate(90deg);
            box-shadow: 0 0 15px rgba(255, 209, 0, 0.4);
        }
        
        .btn-nav-circ {
            position: fixed;
            bottom: 22px;
            z-index: 100;
            background: rgba(0, 33, 71, 0.8);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.15);
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-nav-circ:hover {
            background: #FFD100;
            color: #002147;
            transform: translateY(-2px) scale(1.08);
            box-shadow: 0 0 15px rgba(255, 209, 0, 0.4);
        }
        .btn-nav-circ:active {
            transform: translateY(0) scale(0.95);
        }
        
        /* KEYBOARD KEYGUIDE */
        .keyguide {
            position: fixed;
            bottom: 35px;
            right: 90px;
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: #94a3b8;
            background: rgba(0, 33, 71, 0.6);
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            pointer-events: none;
            opacity: 0.8;
        }
        .keycap {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-bottom: 2px solid rgba(255, 255, 255, 0.35);
            border-radius: 4px;
            padding: 1px 5px;
            font-family: monospace;
            font-size: 10px;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>

{{-- ═══ PRELOADER SCREEN ═══ --}}
<div id="preloader">
    <div class="flex flex-col items-center">
        <!-- Pulse Logo MPKSDI / Muhammadiyah -->
        <div class="pulse-logo mb-6">
            <img src="{{ asset('logo.webp') }}" class="h-28" alt="Logo MPKSDI" onerror="this.src='https://upload.wikimedia.org/wikipedia/id/thumb/6/6f/Logo_Muhammadiyah.svg/1024px-Logo_Muhammadiyah.svg.png'">
        </div>
        <div class="preloader-spinner"></div>
        <h2 class="text-white text-xl font-bold tracking-wider uppercase">Laporan Analisis ArqamApp</h2>
        <p class="text-yellow-400 text-sm font-semibold mt-2 tracking-widest uppercase">Sedang Menyiapkan Data & Grafik...</p>
    </div>
</div>

{{-- ═══ FLOATING MENU TRIGGER ═══ --}}
<button class="menu-trigger" onclick="toggleSidebar()" title="Buka Navigasi (Shortcut: M)">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
</button>

{{-- ═══ SIDEBAR MENU PANEL ═══ --}}
<div id="sidebar">
    <div class="p-6 border-b border-white/10 flex justify-between items-center bg-navy-950/50">
        <div>
            <h3 class="text-white font-black text-lg tracking-wider">NAVIGASI</h3>
            <p class="text-xs text-gray-400 mt-0.5 uppercase tracking-widest font-semibold">{{ $event->nama_event }}</p>
        </div>
        <button onclick="toggleSidebar(false)" class="text-gray-400 hover:text-white transition-colors p-2 text-xl font-bold">&times;</button>
    </div>
    
    <div class="flex-1 overflow-y-auto py-4">
        @php
            $slideMenu = [
                ['title' => 'Cover Laporan', 'desc' => 'Judul Laporan & Data Pokok', 'icon' => '📄'],
                ['title' => 'Profil Demografi I', 'desc' => 'Gender & Pernikahan', 'icon' => '👥'],
                ['title' => 'Profil Demografi II', 'desc' => 'Sebaran Umur & Bahasa', 'icon' => '🎂'],
                ['title' => 'Keahlian Al-Qur\'an', 'desc' => 'Tingkat Kelancaran & Hafalan', 'icon' => '📖'],
                ['title' => 'Etos Keagamaan', 'desc' => 'Sholat & Kajian Keaktifan', 'icon' => '🕌'],
                ['title' => 'Presensi Kehadiran', 'desc' => 'Statistik Kehadiran Sesi', 'icon' => '📅'],
                ['title' => 'Rata-Rata Penilaian', 'desc' => 'Evaluasi Kategori C1 - C5', 'icon' => '📈'],
                ['title' => 'Distribusi Kelulusan', 'desc' => 'Kelulusan, Predikat & Kepuasan', 'icon' => '🏆'],
                ['title' => 'Peserta Terbaik', 'desc' => 'Apresiasi Top 3 Terbaik', 'icon' => '👑'],
            ];
        @endphp
        
        <div class="space-y-1 px-3">
            @foreach($slideMenu as $idx => $item)
            <button onclick="jumpTo({{ $idx }}); toggleSidebar(false);" class="sidebar-item w-full flex items-center gap-4 p-3 rounded-lg text-left text-gray-300 hover:text-white">
                <div class="text-2xl w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center border border-white/5">{{ $item['icon'] }}</div>
                <div>
                    <h4 class="font-bold text-sm leading-tight text-inherit">{{ $item['title'] }}</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5 leading-none">{{ $item['desc'] }}</p>
                </div>
            </button>
            @endforeach
        </div>
    </div>
    
        <img src="{{ asset('logo.webp') }}" class="h-10 mx-auto opacity-70 mb-2" alt="Logo LP3A UMS" onerror="this.src='https://upload.wikimedia.org/wikipedia/id/thumb/6/6f/Logo_Muhammadiyah.svg/1024px-Logo_Muhammadiyah.svg.png'">
        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">&copy; ArqamApp LP3A UMS</p>
    </div>
</div>

<div id="wrap">

{{-- ═══ SLIDE 1: COVER ═══ --}}
<div class="slide active p-10 flex" id="s1">
    <div class="shape-yellow-left"></div>
    <div class="shape-navy-right"></div>
    
    <div class="z-10 w-full h-full flex items-center">
        <div class="w-1/2 pl-12 pr-8 anim-right">
            <div class="flex items-center gap-4 mb-10">
                <img src="{{ asset('logo.webp') }}" class="h-20" alt="Logo MPKSDI" onerror="this.src='https://upload.wikimedia.org/wikipedia/id/thumb/6/6f/Logo_Muhammadiyah.svg/1024px-Logo_Muhammadiyah.svg.png'">
                <div>
                    <p class="text-sm font-black text-navy-900 tracking-widest uppercase">LP3A</p>
                    <p class="text-sm font-bold text-gray-600 tracking-wide uppercase">Universitas Muhammadiyah Surakarta</p>
                </div>
            </div>
            
            <h2 class="text-2xl font-bold text-navy-900 mb-2">LAPORAN PELAKSANAAN</h2>
            <h1 class="text-5xl md:text-5xl font-black text-navy-900 leading-tight mb-8 uppercase">{{ $event->nama_event }}</h1>
            
            <div class="w-32 h-3 bg-yellow-400 mb-8"></div>
            
            <p class="text-lg text-gray-700 font-semibold mb-2 flex items-center gap-3">
                <svg class="w-3 h-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
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
        <h2 class="text-3xl font-black text-white tracking-wider uppercase">Profil Demografi</h2>
    </div>

    <div class="max-w-7xl w-full mx-auto z-10 grid grid-cols-3 gap-8">
        <div class="content-box anim-up d1 flex flex-col items-center col-span-1">
            <h3 class="text-2xl font-bold text-navy-900 title-accent">Jenis Kelamin</h3>
            <div class="h-64 w-full flex justify-center"><canvas id="cGender"></canvas></div>
            <div class="flex gap-10 mt-6 w-full justify-center">
                <div class="text-center"><p class="text-3xl font-black text-navy-900">{{ $lakiLaki }}</p><p class="text-[10px] font-bold text-gray-500 uppercase mt-1">Laki-laki</p></div>
                <div class="text-center"><p class="text-3xl font-black text-yellow-500">{{ $perempuan }}</p><p class="text-[10px] font-bold text-gray-500 uppercase mt-1">Perempuan</p></div>
            </div>
        </div>
        
        <div class="content-box anim-up d2 flex flex-col items-center col-span-1">
            <h3 class="text-2xl font-bold text-navy-900 title-accent">Status Pernikahan</h3>
            <div class="h-64 w-full flex justify-center"><canvas id="cStatus"></canvas></div>
            <div class="flex gap-10 mt-6 w-full justify-center">
                <div class="text-center"><p class="text-3xl font-black text-navy-900">{{ $menikah }}</p><p class="text-[10px] font-bold text-gray-500 uppercase mt-1">Menikah</p></div>
                <div class="text-center"><p class="text-3xl font-black text-yellow-500">{{ $belumNikah }}</p><p class="text-[10px] font-bold text-gray-500 uppercase mt-1">Single</p></div>
            </div>
        </div>

        <div class="flex flex-col justify-between anim-up d3 col-span-1">
            <div class="premium-card">
                <h4 class="text-sm font-bold text-gray-400 uppercase">Rasio Jenis Kelamin</h4>
                <p class="text-2xl font-black text-navy-900 mt-2">{{ $total > 0 ? round(($lakiLaki / $total) * 100) : 0 }}% Laki-laki</p>
                <p class="text-xs text-gray-500 mt-1">Didominasi oleh kelompok gender pria.</p>
            </div>
            
            <div class="premium-card mt-4">
                <h4 class="text-sm font-bold text-gray-400 uppercase">Status Pernikahan</h4>
                <p class="text-2xl font-black text-navy-900 mt-2">{{ $total > 0 ? round(($menikah / $total) * 100) : 0 }}% Menikah</p>
                <p class="text-xs text-gray-500 mt-1">Sebagian besar peserta telah berkeluarga.</p>
            </div>
            
            <div class="premium-card mt-4">
                <h4 class="text-sm font-bold text-gray-400 uppercase">Pendidikan Terbanyak</h4>
                <p class="text-2xl font-black text-navy-900 mt-2">{{ $pendidikan->keys()->first() ?? 'S1' }}</p>
                <p class="text-xs text-gray-500 mt-1">Mayoritas lulusan berpendidikan sarjana.</p>
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

    <div class="max-w-7xl w-full mx-auto z-10 grid grid-cols-3 gap-8">
        <div class="content-box anim-up d1 col-span-1">
            <h3 class="text-xl font-bold text-navy-900 title-accent text-center w-full block">Sebaran Umur (Tahun)</h3>
            <div class="h-80"><canvas id="cUmur"></canvas></div>
        </div>
        <div class="content-box anim-up d2 col-span-1">
            <h3 class="text-xl font-bold text-navy-900 title-accent text-center w-full block">Bahasa Asing Dikuasai</h3>
            <div class="h-80"><canvas id="cBahasa"></canvas></div>
        </div>
        <div class="flex flex-col justify-between anim-up d3 col-span-1">
            <div class="premium-card">
                <h4 class="text-sm font-bold text-gray-400 uppercase">Statistik Umur</h4>
                <p class="text-xl font-black text-navy-900 mt-2">Rata-rata: {{ $avgUmur }} Tahun</p>
                <p class="text-xs text-gray-600 mt-1">Usia Termuda: <strong>{{ $minUmur }}</strong> s.d Tertua: <strong>{{ $maxUmur }}</strong> Tahun.</p>
            </div>
            
            <div class="premium-card mt-4">
                <h4 class="text-sm font-bold text-gray-400 uppercase">Penguasaan Bahasa</h4>
                <p class="text-xl font-black text-navy-900 mt-2">Inggris & Arab</p>
                <p class="text-xs text-gray-600 mt-1">Bahasa Inggris dikuasai oleh <strong>{{ $bahasaCount['Inggris'] }}</strong> peserta, Arab oleh <strong>{{ $bahasaCount['Arab'] }}</strong> peserta.</p>
            </div>

            <div class="premium-card mt-4 border-l-yellow-400">
                <h4 class="text-sm font-bold text-gray-400 uppercase">Rekomendasi</h4>
                <p class="text-xs text-gray-600 mt-1">Sebaran umur dewasa matang mendukung kelancaran diskusi interaktif dan logika berfikir.</p>
            </div>
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

    <div class="max-w-7xl w-full mx-auto z-10 grid grid-cols-3 gap-8">
        <div class="content-box anim-up d1 flex flex-col items-center col-span-1">
            <h3 class="text-xl font-bold text-navy-900 title-accent">Kemampuan Membaca</h3>
            <div class="h-80 w-full"><canvas id="cQuran"></canvas></div>
        </div>
        <div class="content-box anim-up d2 flex flex-col items-center col-span-1">
            <h3 class="text-xl font-bold text-navy-900 title-accent">Hafalan Qur'an</h3>
            <div class="h-80 w-full"><canvas id="cHafalan"></canvas></div>
        </div>
        <div class="flex flex-col justify-center anim-up d3 col-span-1 gap-6">
            <div class="premium-card">
                <h4 class="text-sm font-bold text-gray-400 uppercase">Tingkat Kefasihan</h4>
                <p class="text-2xl font-black text-navy-900 mt-2">{{ $lancarPersen }}% Lancar & Fasih</p>
                <p class="text-xs text-gray-500 mt-1">Mayoritas peserta telah mampu melantunkan bacaan Al-Qur'an secara baik dan benar.</p>
            </div>
            
            <div class="premium-card border-l-yellow-400">
                <h4 class="text-sm font-bold text-gray-400 uppercase">Statistik Hafalan</h4>
                <p class="text-lg font-black text-navy-900 mt-2">Juz 30 (Mendominasi)</p>
                <p class="text-xs text-gray-500 mt-1">Kelompok hafalan 1-10 surat hingga Juz 30 merupakan kategori terbesar.</p>
            </div>
        </div>
    </div>
</div>

{{-- ═══ SLIDE 5: AKTIVITAS ═══ --}}
<div class="slide p-10 pt-24" id="s5">
    <div class="shape-yellow-bar"></div>
    <div class="shape-navy-header"></div>
    <div class="shape-yellow-corner"></div>
    
    <div class="z-10 absolute top-8 left-16">
        <h2 class="text-3xl font-black text-white tracking-wider uppercase">Keagamaan & Keorganisasian</h2>
    </div>

    <div class="max-w-7xl w-full mx-auto z-10 grid grid-cols-4 gap-6">
        <div class="content-box anim-up d1 col-span-1">
            <h3 class="text-xs font-bold text-navy-900 text-center mb-4 border-b-2 border-yellow-400 pb-2 uppercase">Sholat di Masjid</h3>
            <div class="h-60"><canvas id="cSholat"></canvas></div>
        </div>
        <div class="content-box anim-up d2 col-span-1">
            <h3 class="text-xs font-bold text-navy-900 text-center mb-4 border-b-2 border-yellow-400 pb-2 uppercase">Kajian Agama</h3>
            <div class="h-60"><canvas id="cKajian"></canvas></div>
        </div>
        <div class="content-box anim-up d3 col-span-1">
            <h3 class="text-xs font-bold text-navy-900 text-center mb-4 border-b-2 border-yellow-400 pb-2 uppercase">Muhammadiyah</h3>
            <div class="h-60"><canvas id="cKeaktifan"></canvas></div>
        </div>
        <div class="flex flex-col justify-between anim-up d4 col-span-1">
            <div class="premium-card">
                <h4 class="text-xs font-bold text-gray-400 uppercase">Sholat Berjamaah</h4>
                <p class="text-md font-black text-navy-900 mt-1">Kategori Selalu & Sering</p>
                <p class="text-[10px] text-gray-500">Mencerminkan etos ibadah personal yang solid.</p>
            </div>
            <div class="premium-card mt-2">
                <h4 class="text-xs font-bold text-gray-400 uppercase">Kajian Keislaman</h4>
                <p class="text-md font-black text-navy-900 mt-1">Rutin Mingguan</p>
                <p class="text-[10px] text-gray-500">Menunjukkan minat pengembangan keilmuan berkala.</p>
            </div>
            <div class="premium-card mt-2 border-l-yellow-400">
                <h4 class="text-xs font-bold text-gray-400 uppercase">Pimpinan Cabang</h4>
                <p class="text-md font-black text-navy-900 mt-1">Keaktifan Terbesar</p>
                <p class="text-[10px] text-gray-500">Menunjukkan tingkat keterlibatan di tingkat Cabang/Daerah.</p>
            </div>
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

    <div class="max-w-7xl w-full mx-auto z-10 grid grid-cols-3 gap-8">
        <div class="content-box anim-up d1 h-96 col-span-2">
            <canvas id="cHadir"></canvas>
        </div>
        <div class="flex flex-col justify-between anim-up d2 col-span-1">
            <div class="premium-card">
                <h4 class="text-sm font-bold text-gray-400 uppercase">Sesi Kehadiran Terpadat</h4>
                <p class="text-lg font-black text-navy-900 mt-2">{{ $bestSesiNama }}</p>
                <p class="text-xs text-gray-600 mt-1">Total kehadiran terbanyak: <strong>{{ $bestSesiHadir }} Orang</strong>.</p>
            </div>

            <div class="premium-card mt-4">
                <h4 class="text-sm font-bold text-gray-400 uppercase">Kehadiran Rata-rata</h4>
                <p class="text-2xl font-black text-navy-900 mt-2">{{ round($avgKehadiran, 1) }}%</p>
                <p class="text-xs text-gray-500 mt-1">Tingkat presensi dan kedisiplinan yang sangat memuaskan.</p>
            </div>

            <div class="premium-card mt-4 border-l-yellow-400">
                <h4 class="text-sm font-bold text-gray-400 uppercase">Total Peserta Terdaftar</h4>
                <p class="text-xl font-black text-navy-900 mt-2">{{ $total }} Orang Aktif</p>
                <p class="text-xs text-gray-500 mt-1">Terdiri dari peserta utusan dari Amal Usaha Muhammadiyah (AUM).</p>
            </div>
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
                    ['label'=>'Pre-test (C1)','val'=>$avgPretest,'color'=>'text-blue-500'],
                    ['label'=>'Post-test (C2)','val'=>$avgPosttest,'color'=>'text-green-500'],
                    ['label'=>'Psikomotor (C3)','val'=>$avgPsikomotor,'color'=>'text-purple-500'],
                    ['label'=>'Afektif (C4)','val'=>$avgAfektif,'color'=>'text-red-500'],
                    ['label'=>'Kehadiran (C5)','val'=>$avgKehadiran,'color'=>'text-orange-500'],
                ];
            @endphp
            @foreach($nilais as $n)
            <div class="bg-white rounded-xl shadow-xl p-6 border-b-4 border-yellow-400 transform hover:-translate-y-2 transition-transform">
                <div class="text-4xl font-black {{ $n['color'] }}">{{ number_format($n['val'],1) }}</div>
                <div class="text-xs font-bold text-navy-900 mt-2 uppercase tracking-wider">{{ $n['label'] }}</div>
            </div>
            @endforeach
        </div>
        
        <div class="grid grid-cols-3 gap-8 items-center">
            <div class="bg-white p-6 rounded-2xl shadow-2xl col-span-2 h-80 border-4 border-navy-800">
                <canvas id="cNilai"></canvas>
            </div>
            <div class="col-span-1 space-y-3 text-left">
                <div class="bg-white/10 p-3.5 rounded-xl border border-white/20 text-white">
                    <h4 class="text-[10px] font-bold text-yellow-400 uppercase tracking-widest">Peningkatan Rata-rata</h4>
                    <p class="text-2xl font-black mt-1">+{{ $peningkatanRataRata }} Poin</p>
                    <p class="text-[9px] text-gray-300 leading-tight">Selisih rata-rata nilai post-test dan pre-test.</p>
                </div>
                <div class="bg-white/10 p-3.5 rounded-xl border border-white/20 text-white">
                    <h4 class="text-[10px] font-bold text-yellow-400 uppercase tracking-widest">Rata-rata N-Gain (Keefektifan)</h4>
                    <p class="text-2xl font-black mt-1">{{ number_format($avgNGain, 2) }}
                        <span class="text-xs font-normal text-yellow-300">
                            (@if($avgNGain > 0.7) Tinggi @elseif($avgNGain >= 0.3) Sedang @else Rendah @endif)
                        </span>
                    </p>
                    <p class="text-[9px] text-gray-300 leading-tight">Tingkat efektivitas peningkatan pengetahuan.</p>
                </div>
                <div class="bg-white/10 p-3.5 rounded-xl border border-white/20 text-white">
                    <h4 class="text-[10px] font-bold text-yellow-400 uppercase tracking-widest">N-Gain Tertinggi Peserta</h4>
                    <p class="text-2xl font-black mt-1">{{ number_format($maxNGain, 2) }}</p>
                    <p class="text-[9px] text-gray-300 leading-tight">Pencapaian gain kognitif maksimal individu.</p>
                </div>
            </div>
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

    <div class="max-w-7xl w-full mx-auto z-10 grid grid-cols-4 gap-6">
        <div class="content-box anim-up d1 flex flex-col items-center col-span-1">
            <h3 class="text-md font-bold text-navy-900 title-accent">Kelulusan</h3>
            <div class="h-60 w-full"><canvas id="cKelulusan"></canvas></div>
        </div>
        <div class="content-box anim-up d2 flex flex-col items-center col-span-1">
            <h3 class="text-md font-bold text-navy-900 title-accent">Predikat</h3>
            <div class="h-60 w-full"><canvas id="cPredikat"></canvas></div>
        </div>
        <div class="content-box anim-up d3 flex flex-col items-center col-span-1">
            <h3 class="text-md font-bold text-navy-900 title-accent">Kepuasan</h3>
            <div class="h-60 w-full"><canvas id="cAngket"></canvas></div>
        </div>
        <div class="flex flex-col justify-between anim-up d4 col-span-1">
            <div class="premium-card">
                <h4 class="text-xs font-bold text-gray-400 uppercase">Kelulusan Peserta</h4>
                <p class="text-xl font-black text-navy-900 mt-1">{{ $kelulusan->get('Lulus', 0) }} Lulus</p>
                <p class="text-[10px] text-gray-500">Berdasarkan pemenuhan nilai kriteria SAW minimum.</p>
            </div>
            
            <div class="premium-card mt-2">
                <h4 class="text-xs font-bold text-gray-400 uppercase">Rata-rata Skor SAW</h4>
                <p class="text-xl font-black text-navy-900 mt-1">{{ $avgSaw }}</p>
                <p class="text-[10px] text-gray-500">Skor agregat komprehensif seluruh peserta.</p>
            </div>
            
            <div class="premium-card mt-2 border-l-yellow-400">
                <h4 class="text-xs font-bold text-gray-400 uppercase">Evaluasi Penyelenggaraan</h4>
                <p class="text-sm font-black text-navy-900 mt-1">Sangat Baik & Baik</p>
                <p class="text-[10px] text-gray-500">Kepuasan pelayanan kepanitiaan dan materi dari narasumber.</p>
            </div>
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
                <p class="text-4xl font-black text-navy-900">{{ number_format($top3[1]->skor_saw ?? 0, 4) }}</p>
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
                <p class="text-5xl font-black text-navy-900">{{ number_format($top3[0]->skor_saw ?? 0, 4) }}</p>
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
                <p class="text-3xl font-black text-navy-900">{{ number_format($top3[2]->skor_saw ?? 0, 4) }}</p>
            </div>
            @else
            <p class="text-gray-400">Belum ada data</p>
            @endif
        </div>

    </div>
</div>

</div>{{-- end #wrap --}}

<button class="btn-nav-circ" style="left: 25px" onclick="go(-1)" title="Slide Sebelumnya (Shortcut: Arrow Left)">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
</button>

<div class="dots-nav" id="dots-container">
    @foreach($slideMenu as $idx => $item)
    <div class="dot-item" onclick="jumpTo({{ $idx }})">
        <div class="dot-tooltip">{{ $item['title'] }}</div>
    </div>
    @endforeach
</div>

<button class="btn-nav-circ" style="right: 25px" onclick="go(1)" title="Slide Selanjutnya (Shortcut: Arrow Right atau Space)">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
</button>

<div class="keyguide hidden md:flex">
    <span class="keycap">←</span>
    <span class="keycap">→</span>
    <span class="keycap">Space</span>
    <span>Navigasi</span>
    <span class="keycap ml-2">M</span>
    <span>Menu</span>
</div>

<script>
let cur = 0;
const slides = document.querySelectorAll('.slide');
let charted = false;

// Preloader dismissal on load
window.addEventListener('load', () => {
    const preloader = document.getElementById('preloader');
    if (preloader) {
        setTimeout(() => {
            preloader.classList.add('loaded');
            if (!charted && cur >= 1) { buildCharts(); charted = true; }
        }, 800);
    }
});

// Sidebar menu toggling
function toggleSidebar(open = null) {
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        if (open === null) {
            sidebar.classList.toggle('open');
        } else if (open) {
            sidebar.classList.add('open');
        } else {
            sidebar.classList.remove('open');
        }
    }
}

// Unified jumpTo function
function jumpTo(index) {
    if (index < 0 || index >= slides.length) return;
    slides[cur].classList.remove('active');
    cur = index;
    slides[cur].classList.add('active');
    
    // Update navigation UI elements
    updateNavigation();
    
    if (!charted && cur >= 1) {
        buildCharts();
        charted = true;
    }
}

function go(dir) {
    jumpTo(cur + dir);
}

// Handle updates of dots and sidebar highlights
function updateNavigation() {
    // 1. Update dots active state
    const dots = document.querySelectorAll('.dot-item');
    dots.forEach((dot, idx) => {
        if (idx === cur) {
            dot.classList.add('active');
        } else {
            dot.classList.remove('active');
        }
    });

    // 2. Update sidebar menu highlights
    const items = document.querySelectorAll('.sidebar-item');
    items.forEach((item, idx) => {
        if (idx === cur) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
}

// Keyboard navigation listener
document.addEventListener('keydown', e => {
    // Prevent default scroll behaviors for space bar or arrow keys on window
    if (['ArrowUp', 'ArrowDown', ' ', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
        e.preventDefault();
    }
    if (e.key === 'ArrowRight' || e.key === ' ') {
        go(1);
    } else if (e.key === 'ArrowLeft') {
        go(-1);
    } else if (e.key === 'm' || e.key === 'M') {
        toggleSidebar();
    } else if (e.key === 'Escape') {
        toggleSidebar(false);
    }
});

// Initialize first navigation state
document.addEventListener('DOMContentLoaded', () => {
    updateNavigation();
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
    nilai:   { labels: ['Pre-test','Post-test','Psikomotor','Afektif','Kehadiran'], data: [{{ round($avgPretest,1) }},{{ round($avgPosttest,1) }},{{ round($avgPsikomotor,1) }},{{ round($avgAfektif,1) }},{{ round($avgKehadiran,1) }}] },
    kelulusan: { labels: {!! json_encode($kelulusan->keys()->toArray()) !!}, data: {!! json_encode($kelulusan->values()->toArray()) !!} },
    predikat:  { labels: {!! json_encode($predikat->keys()->toArray()) !!}, data: {!! json_encode($predikat->values()->toArray()) !!} },
    angket:    { labels: {!! json_encode($angket->keys()->toArray()) !!}, data: {!! json_encode($angket->values()->toArray()) !!} },
};

const PALETTE = ['#002147', '#FFD100', '#10B981', '#EF4444', '#F97316', '#06B6D4', '#8B5CF6'];

function pie(id, labels, data) {
    new Chart(document.getElementById(id), { type:'pie', data:{ labels, datasets:[{ data, backgroundColor: PALETTE, borderWidth:3, borderColor:'#fff' }] }, options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ position:'bottom', labels:{ color: '#002147', font:{size:11, family:'Montserrat', weight:'bold'} } } } } });
}
function donut(id, labels, data) {
    new Chart(document.getElementById(id), { type:'doughnut', data:{ labels, datasets:[{ data, backgroundColor: PALETTE, borderWidth:2, borderColor:'#fff' }] }, options:{ responsive:true, maintainAspectRatio:false, cutout:'60%', plugins:{ legend:{ position:'bottom', labels:{ color: '#002147', font:{size:10, family:'Montserrat', weight:'bold'} } } } } });
}
function bar(id, labels, data, color='#002147', horiz=false) {
    new Chart(document.getElementById(id), { type:'bar', data:{ labels, datasets:[{ data, backgroundColor:color, borderRadius:4 }] }, options:{ indexAxis: horiz?'y':'x', responsive:true, maintainAspectRatio:false, plugins:{ legend:{ display:false } }, scales:{ x:{ticks:{font:{family:'Montserrat', weight:'600'}, color:'#002147'}}, y:{ticks:{font:{family:'Montserrat'}, color:'#002147'}} } } });
}
function radar(id, labels, data) {
    new Chart(document.getElementById(id), { type:'radar', data:{ labels, datasets:[{ data, backgroundColor:'rgba(255, 209, 0, 0.3)', borderColor:'#FFD100', pointBackgroundColor:'#002147', borderWidth:3 }] }, options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{display:false} }, scales:{ r:{ max:100, min:0, ticks:{display:false}, pointLabels:{font:{family:'Montserrat', weight:'bold', size: 12}, color:'#002147'} } } } });
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
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend:{ display:false } }, scales: { y:{ max: D.hadir.total + 2, ticks:{ font:{family:'Montserrat'} } }, x:{ ticks:{ font:{family:'Montserrat', size:10, weight:'bold'} } } } }
    });

    radar('cNilai', D.nilai.labels, D.nilai.data);
    pie('cKelulusan', D.kelulusan.labels, D.kelulusan.data);
    pie('cPredikat', D.predikat.labels, D.predikat.data);
    donut('cAngket', D.angket.labels, D.angket.data);
}
</script>
</body>
</html>
