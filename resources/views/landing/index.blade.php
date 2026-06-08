<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARQAM App — Sistem Evaluasi Terpadu Baitul Arqam</title>
    <link rel="icon" type="image/png" href="{{ asset('logoums.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Lenis Smooth Scroll CDN --}}
    <script src="https://unpkg.com/lenis@1.1.20/dist/lenis.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#1A6D9B', 50: '#E8F4FA', 100: '#C5E3F2', 600: '#155C84', 900: '#06293F' },
                        accent: { DEFAULT: '#D4A017', 50: '#FDF6E3', 600: '#9C740F' },
                        surface: '#F8FAFC',
                    },
                    fontFamily: { heading: ['Poppins', 'sans-serif'], body: ['Inter', 'sans-serif'] },
                    animation: { 
                        'floating-slow': 'floating 6s ease-in-out infinite',
                        'floating-fast': 'floating 4s ease-in-out infinite',
                        'blob': 'blob 7s infinite',
                        'spin-slow': 'spin 12s linear infinite',
                    },
                    keyframes: { 
                        floating: { 
                            '0%, 100%': { transform: 'translateY(0)' }, 
                            '50%': { transform: 'translateY(-15px)' } 
                        },
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' }
                        }
                    },
                    boxShadow: {
                        'soft': '0 20px 40px -15px rgba(0,0,0,0.05)',
                        'glow-primary': '0 0 20px rgba(26, 109, 155, 0.4)',
                        'glow-accent': '0 0 20px rgba(212, 160, 23, 0.4)',
                    }
                }
            }
        }
    </script>
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        
        /* Premium Glassmorphism */
        .glass-nav { 
            backdrop-filter: blur(20px); 
            -webkit-backdrop-filter: blur(20px); 
            background: rgba(255, 255, 255, 0.8); 
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        
        /* Rich Mesh Gradient Background */
        .hero-mesh { 
            background-color: #06293F;
            background-image: 
                radial-gradient(at 0% 0%, hsla(201, 71%, 35%, 1) 0px, transparent 50%),
                radial-gradient(at 100% 0%, hsla(201, 71%, 25%, 1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, hsla(201, 71%, 15%, 1) 0px, transparent 50%),
                radial-gradient(at 0% 100%, hsla(201, 71%, 20%, 1) 0px, transparent 50%);
        }
        
        .text-gradient-gold {
            background: linear-gradient(to right, #D4A017, #FFE082, #9C740F);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        
        /* Subtle Grid Pattern */
        .bg-grid-pattern {
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="font-body text-gray-700 antialiased overflow-x-hidden" 
      x-data="{ scrolled: false, showDev: false }" 
      @scroll.window="scrolled = (window.pageYOffset > 20)"
      :class="{'overflow-hidden': showDev}">

    {{-- Navigation --}}
    <nav :class="{'glass-nav shadow-sm': scrolled, 'bg-transparent': !scrolled}" class="fixed w-full z-50 transition-all duration-300 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3 flex-1">
                    <img src="{{ asset('logo.webp') }}" alt="Logo" class="h-10 object-contain transition-all" :class="{'brightness-0 invert': !scrolled, 'brightness-100': scrolled}">
                </div>
                <div class="hidden lg:flex space-x-8">
                    <a href="#tentang" class="text-base font-semibold transition-colors" :class="scrolled ? 'text-gray-600 hover:text-primary' : 'text-primary-100 hover:text-white'">Tentang</a>
                    <a href="#fitur" class="text-base font-semibold transition-colors" :class="scrolled ? 'text-gray-600 hover:text-primary' : 'text-primary-100 hover:text-white'">Fitur</a>
                    <a href="#alur" class="text-base font-semibold transition-colors" :class="scrolled ? 'text-gray-600 hover:text-primary' : 'text-primary-100 hover:text-white'">Alur</a>
                    <a href="#galeri" class="text-base font-semibold transition-colors" :class="scrolled ? 'text-gray-600 hover:text-primary' : 'text-primary-100 hover:text-white'">Galeri</a>
                    <a href="#testimoni" class="text-base font-semibold transition-colors" :class="scrolled ? 'text-gray-600 hover:text-primary' : 'text-primary-100 hover:text-white'">Testimoni</a>
                    <a href="#faq" class="text-base font-semibold transition-colors" :class="scrolled ? 'text-gray-600 hover:text-primary' : 'text-primary-100 hover:text-white'">FAQ</a>
                </div>
                <div class="flex flex-1 justify-end">
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('peserta.dashboard') }}" 
                           class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all shadow-lg hover:-translate-y-0.5"
                           :class="scrolled ? 'bg-primary text-white hover:shadow-primary/30' : 'bg-white text-primary hover:bg-white/90'">
                            Dashboard →
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all shadow-lg hover:-translate-y-0.5 border-2"
                           :class="scrolled ? 'bg-primary text-white border-primary hover:shadow-primary/30' : 'bg-transparent text-white border-white/30 hover:bg-white hover:text-primary'">
                            Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="hero-mesh min-h-screen pt-32 pb-20 flex items-center relative overflow-hidden">
        {{-- Background Decorations --}}
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 -left-32 w-[500px] h-[500px] bg-primary-400 rounded-full mix-blend-color-dodge filter blur-[100px] opacity-40 animate-blob"></div>
            <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-accent rounded-full mix-blend-color-dodge filter blur-[120px] opacity-30 animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm text-white text-sm font-medium mb-8" data-aos="fade-down">
                        <span class="w-2 h-2 rounded-full bg-scan-success animate-pulse"></span>
                        ARQAM App V2.0
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-heading font-extrabold text-white leading-tight mb-6" data-aos="fade-up" data-aos-delay="100">
                        Evaluasi Perkaderan <br /> 
                        <span class="text-gradient-gold drop-shadow-lg">Lebih Cerdas & Akurat</span>
                    </h1>
                    <p class="text-lg sm:text-xl text-primary-100 mb-8 max-w-2xl mx-auto lg:mx-0 leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                        Transformasi digital perkaderan untuk penilaian kognitif, afektif, dan psikomotor yang objektif dan transparan bagi setiap kader.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start" data-aos="fade-up" data-aos-delay="300">
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-accent text-white rounded-full font-bold text-lg hover:bg-accent-600 transition-all shadow-lg shadow-accent/30 hover:-translate-y-1 hover:shadow-xl text-center">
                            Mulai Sekarang
                        </a>
                        <a href="#fitur" class="px-8 py-4 bg-white/10 border border-white/20 text-white backdrop-blur-sm rounded-full font-bold text-lg hover:bg-white/20 transition-all text-center group flex items-center justify-center gap-2">
                            Pelajari Fitur
                            <svg class="w-5 h-5 group-hover:translate-y-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </a>
                    </div>
                </div>
                
                {{-- Hero Mockup Image --}}
                <div class="relative animate-floating-slow hidden lg:block perspective-1000">
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary-900 to-transparent rounded-3xl transform rotate-3 scale-105 opacity-40 blur-xl"></div>
                    <div class="bg-gray-900 rounded-[2.5rem] border-[12px] border-gray-800 shadow-2xl overflow-hidden relative z-10 aspect-[4/3] group transform hover:rotate-0 transition-transform duration-700">
                        <img src="{{ asset('hero.jpg') }}" alt="ARQAM Training" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-8">
                            <p class="text-white text-sm font-medium">Baitul Arqam Dosen UMS</p>
                        </div>
                    </div>
                    
                    {{-- Mascot Arka Floating --}}
                    <div class="absolute -top-20 -left-20 w-48 h-48 z-30 animate-floating-fast">
                        <div class="w-full h-full bg-white rounded-full border-8 border-white shadow-2xl overflow-hidden p-3 flex items-center justify-center">
                            <img src="{{ asset('images/arka/arka_pemandu.png') }}" alt="Arka" class="w-full h-full object-contain">
                        </div>
                    </div>
                    
                    {{-- Floating Badges --}}
                    <div class="absolute -top-10 -right-12 bg-white rounded-2xl p-4 shadow-2xl border border-gray-100 flex items-center gap-4 z-20 animate-floating-fast">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center font-bold text-xl shadow-inner">✓</div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Automasi</p>
                            <p class="text-sm font-bold text-gray-800">Sistem SAW</p>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-10 -right-4 bg-white rounded-2xl p-4 shadow-2xl border border-gray-100 flex items-center gap-4 z-20 animate-floating-fast" style="animation-delay: 1.5s">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center shadow-inner">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Kehadiran</p>
                            <p class="text-sm font-bold text-gray-800">QR Scanner</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Wave --}}
        <div class="absolute bottom-0 w-full leading-[0] z-20 pointer-events-none transform translate-y-1">
            <svg class="w-full h-12 sm:h-24 lg:h-32" viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path fill="#f8fafc" fill-opacity="1" d="M0,160L48,170.7C96,181,192,203,288,192C384,181,480,139,576,144C672,149,768,203,864,213.3C960,224,1056,192,1152,165.3C1248,139,1344,117,1392,106.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    {{-- Stats Section --}}
    <section id="statistik" class="relative -mt-16 z-30 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-soft border border-gray-100 p-8 sm:p-12">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-4 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                    <div class="text-center px-4 pt-4 md:pt-0" data-aos="fade-up" data-aos-delay="0">
                        <p class="text-4xl md:text-5xl font-heading font-black text-primary mb-2 flex justify-center items-baseline">
                            <span class="counter" data-target="{{ $totalEvents }}">0</span><span class="text-accent text-3xl">+</span>
                        </p>
                        <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-widest">Event Terlaksana</p>
                    </div>
                    <div class="text-center px-4 pt-8 md:pt-0" data-aos="fade-up" data-aos-delay="100">
                        <p class="text-4xl md:text-5xl font-heading font-black text-primary mb-2 flex justify-center items-baseline">
                            <span class="counter" data-target="{{ $totalAlumni }}">0</span><span class="text-accent text-3xl">+</span>
                        </p>
                        <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-widest">Alumni Kader</p>
                    </div>
                    <div class="text-center px-4 pt-8 md:pt-0" data-aos="fade-up" data-aos-delay="200">
                        <p class="text-4xl md:text-5xl font-heading font-black text-primary mb-2 flex justify-center items-baseline">
                            <span class="counter" data-target="{{ $totalSertifikat }}">0</span><span class="text-accent text-3xl">+</span>
                        </p>
                        <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-widest">Sertifikat Terbit</p>
                    </div>
                    <div class="text-center px-4 pt-8 md:pt-0" data-aos="fade-up" data-aos-delay="300">
                        <p class="text-4xl md:text-5xl font-heading font-black text-primary mb-2 flex justify-center items-baseline">
                            <span class="counter" data-target="{{ $totalMitra }}">0</span><span class="text-accent text-3xl">+</span>
                        </p>
                        <p class="text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-widest">Instansi Mitra</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Tentang Section --}}
    <section id="tentang" class="py-24 bg-white relative overflow-hidden">
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/2 -right-32 w-80 h-80 bg-primary/5 rounded-full filter blur-3xl"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Column 1: Image (Left) -->
                <div class="relative" data-aos="fade-right">
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary/15 to-accent/15 rounded-[2rem] transform rotate-3 scale-105 filter blur-lg"></div>
                    <div class="relative z-10 bg-white rounded-[2rem] border border-slate-100 shadow-soft overflow-hidden aspect-[4/3] group">
                        <img src="{{ asset('kegiatan.jpg') }}" alt="Baitul Arqam LP3A UMS" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent flex items-end p-6">
                            <p class="text-white text-sm font-semibold font-heading">Kegiatan Baitul Arqam LP3A UMS</p>
                        </div>
                    </div>
                </div>

                <!-- Column 2: Text & Features (Right) -->
                <div class="relative" data-aos="fade-left">
                    <div class="absolute -top-4 -left-4 w-12 h-12 bg-accent/20 rounded-2xl -z-10 animate-pulse"></div>
                    <span class="text-primary font-bold tracking-wider uppercase text-sm mb-2 block">Tentang Aplikasi</span>
                    <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-6 leading-tight">Sistem Evaluasi Perkaderan Baitul Arqam Terpadu</h2>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        <strong>ARQAM App</strong> merupakan sistem resmi milik <strong>LP3A (Lembaga Pengembangan Persyarikatan Pengkaderan & Alumni)</strong> UMS yang dirancang dan dikembangkan secara khusus untuk mendukung penyelenggaraan serta evaluasi kegiatan <strong>Baitul Arqam</strong>. Sebagai unit kerja di bawah naungan Wakil Rektor III Bidang Al Islam Kemuhammadiyahan, Pengkaderan dan Alumni (sejak tahun 2025), LP3A bertugas membina, menyiapkan, dan memberdayakan kader persyarikatan secara presisi, objektif, dan transparan.
                    </p>
                    
                    <div class="mt-8 space-y-4">
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0 font-bold text-sm">01</div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm mb-1 font-heading">Standardisasi Penilaian</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">Menggunakan indikator penilaian terukur untuk objektivitas hasil evaluasi.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-lg bg-accent/10 text-accent flex items-center justify-center shrink-0 font-bold text-sm">02</div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm mb-1 font-heading">Kemudahan Akses</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">Antarmuka yang dioptimalkan untuk perangkat mobile memudahkan peserta dan instruktur.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-lg bg-green-100 text-green-700 flex items-center justify-center shrink-0 font-bold text-sm">03</div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm mb-1 font-heading">Laporan Real-time</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">Hasil perhitungan SAW dan grafik demografi langsung tersaji secara instan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Alur Sistem Section --}}
    <section id="alur" class="py-24 bg-surface relative overflow-hidden bg-grid-pattern">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="text-primary font-bold tracking-wider uppercase text-sm mb-2 block">Standardisasi Penilaian</span>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-6">Alur Evaluasi Terintegrasi</h2>
                <p class="text-gray-500 text-lg">Proses terstruktur untuk memastikan objektivitas, mulai dari kehadiran hingga penerbitan sertifikat kelulusan.</p>
            </div>

            <div class="grid md:grid-cols-4 gap-12 md:gap-8 relative">
                {{-- Connector Line (Desktop Only) --}}
                <div class="hidden md:block absolute top-16 left-[10%] w-[80%] h-0.5 border-t-2 border-dashed border-primary/20 z-0"></div>

                <div class="relative z-10 flex flex-col items-center text-center group" data-aos="fade-up" data-aos-delay="0">
                    <div class="w-32 h-32 bg-white rounded-3xl shadow-soft border border-gray-100 flex items-center justify-center mb-6 group-hover:-translate-y-2 transition-transform duration-300 relative z-10 p-4">
                        <div class="absolute inset-0 bg-primary/5 rounded-3xl transform scale-0 group-hover:scale-100 transition-transform duration-300"></div>
                        <img src="{{ asset('images/arka/arka_pemandu.png') }}" alt="Step 1" class="w-full h-full object-contain relative z-10">
                        <div class="absolute -top-3 -right-3 w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold border-4 border-surface shadow-sm">1</div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Registrasi & Profil</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Peserta mendaftar dan melengkapi data identitas serta instansi asal.</p>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 flex flex-col items-center text-center group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-32 h-32 bg-white rounded-3xl shadow-soft border border-gray-100 flex items-center justify-center mb-6 group-hover:-translate-y-2 transition-transform duration-300 relative z-10 p-4">
                        <div class="absolute inset-0 bg-primary/5 rounded-3xl transform scale-0 group-hover:scale-100 transition-transform duration-300"></div>
                        <img src="{{ asset('images/arka/arka_scan.png') }}" alt="Step 2" class="w-full h-full object-contain relative z-10">
                        <div class="absolute -top-3 -right-3 w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold border-4 border-surface shadow-sm">2</div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Pelaksanaan Event</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Absensi QR Code, mengikuti materi, serta mengerjakan Pretest & Posttest.</p>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 flex flex-col items-center text-center group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-32 h-32 bg-white rounded-3xl shadow-soft border border-gray-100 flex items-center justify-center mb-6 group-hover:-translate-y-2 transition-transform duration-300 relative z-10 p-4">
                        <div class="absolute inset-0 bg-primary/5 rounded-3xl transform scale-0 group-hover:scale-100 transition-transform duration-300"></div>
                        <img src="{{ asset('images/arka/arka_fokus.png') }}" alt="Step 3" class="w-full h-full object-contain relative z-10">
                        <div class="absolute -top-3 -right-3 w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold border-4 border-surface shadow-sm">3</div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Evaluasi Perilaku</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Penilaian mandiri (Afektif) dan penilaian observasi (Psikomotor) oleh MoT.</p>
                </div>

                <!-- Step 4 -->
                <div class="relative z-10 flex flex-col items-center text-center group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-32 h-32 bg-primary rounded-3xl shadow-glow-primary flex items-center justify-center mb-6 group-hover:-translate-y-2 transition-transform duration-300 relative z-10 p-4">
                        <img src="{{ asset('images/arka/arka_selebrasi.png') }}" alt="Step 4" class="w-full h-full object-contain relative z-10">
                        <div class="absolute -top-3 -right-3 w-8 h-8 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold border-4 border-surface shadow-sm">4</div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Hasil & Sertifikat</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Sistem menghitung skor SAW dan menerbitkan sertifikat digital terverifikasi.</p>
                </div>
            </div>
            <!-- Algorithm Explanation Banner -->
            <div class="mt-24 bg-white rounded-[2rem] p-8 md:p-12 shadow-soft border border-gray-100 flex flex-col md:flex-row items-center gap-10 overflow-hidden relative" data-aos="fade-up">
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full filter blur-3xl -translate-y-1/2 translate-x-1/3"></div>
                
                <div class="flex-1 relative z-10">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="bg-primary-100 text-primary-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Teknologi Inti</span>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-heading font-bold text-gray-900 mb-4">Keunggulan Sistem Penilaian</h3>
                    <p class="text-gray-500 leading-relaxed mb-8 text-lg">
                        Kami menggunakan metode <span class="font-bold text-primary">Simple Additive Weighting (SAW)</span> untuk memastikan setiap nilai dihitung secara adil. Dengan pembobotan yang terukur, hasil evaluasi menjadi lebih dapat dipertanggungjawabkan dan sesuai dengan kriteria perkaderan.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                            <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                            <span class="text-sm font-semibold text-gray-700">100% Transparan</span>
                        </div>
                        <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                            <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                            <span class="text-sm font-semibold text-gray-700">Kalkulasi Akurat</span>
                        </div>
                        <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                            <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                            <span class="text-sm font-semibold text-gray-700">Otomatisasi Real-time</span>
                        </div>
                    </div>
                </div>

                <!-- Abstract Math/Algorithm Visual -->
                <div class="w-full md:w-80 h-80 bg-gray-900 rounded-[2rem] p-6 relative overflow-hidden group shadow-2xl flex-shrink-0">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-900 to-gray-900 opacity-90"></div>
                    <!-- Animated Math symbols -->
                    <div class="absolute inset-0 opacity-20 font-mono text-primary-400 text-sm overflow-hidden p-4">
                        <div class="animate-floating-slow">V_i = Σ w_j * r_ij</div>
                        <div class="animate-floating-fast mt-4 ml-8">r_ij = x_ij / Max(x_ij)</div>
                        <div class="animate-floating-slow mt-8 ml-4">W = [0.3, 0.4, 0.2, 0.1]</div>
                        <div class="animate-floating-fast mt-6 ml-12">SAW Decision Matrix</div>
                    </div>
                    <!-- Central Visual -->
                    <div class="relative z-10 w-full h-full border border-white/10 rounded-xl backdrop-blur-md flex flex-col items-center justify-center gap-4">
                        <div class="w-20 h-20 rounded-full border-4 border-primary border-t-accent animate-spin-slow flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                        </div>
                        <div class="text-center">
                            <div class="text-white font-bold tracking-wider text-sm mb-1">PROSES KALKULASI</div>
                            <div class="flex gap-1 justify-center">
                                <div class="w-2 h-2 rounded-full bg-accent animate-bounce" style="animation-delay: 0ms"></div>
                                <div class="w-2 h-2 rounded-full bg-accent animate-bounce" style="animation-delay: 150ms"></div>
                                <div class="w-2 h-2 rounded-full bg-accent animate-bounce" style="animation-delay: 300ms"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
     </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="fitur" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-accent font-bold tracking-wider uppercase text-sm mb-2 block">Keunggulan Sistem</span>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-6">Fitur Unggulan Sistem ARQAM</h2>
                <p class="text-gray-500 text-lg">Solusi praktis untuk mengelola pelatihan dengan akurasi penilaian yang didukung oleh sistem pendukung keputusan yang cerdas.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-surface rounded-3xl p-8 border border-gray-100 hover:border-primary/30 hover:shadow-xl hover:bg-white transition-all duration-300 group" data-aos="fade-up" data-aos-delay="0">
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-primary transition-all duration-300 shadow-sm">
                        <svg class="w-7 h-7 text-primary group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors">Ranah Kognitif (CBT)</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Fasilitas CBT (Computer Based Test) cerdas untuk Pretest & Posttest dilengkapi Timer otomatis, anti-kecurangan, dan Auto-grading seketika.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-surface rounded-3xl p-8 border border-gray-100 hover:border-accent/30 hover:shadow-xl hover:bg-white transition-all duration-300 group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-accent transition-all duration-300 shadow-sm">
                        <svg class="w-7 h-7 text-accent group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900 mb-3 group-hover:text-accent transition-colors">Ranah Afektif</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Instrumen kuesioner skala Likert digital untuk mengukur aspek sikap peserta (Self-Assessment) dengan sinkronisasi bobot secara dinamis.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-surface rounded-3xl p-8 border border-gray-100 hover:border-emerald-300 hover:shadow-xl hover:bg-white transition-all duration-300 group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-emerald-500 transition-all duration-300 shadow-sm">
                        <svg class="w-7 h-7 text-emerald-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900 mb-3 group-hover:text-emerald-600 transition-colors">Ranah Psikomotor</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Penilaian observasi lapangan berbasis matriks *rubric* digital oleh Instruktur (MoT) yang dapat dikustomisasi sesuai kurikulum materi.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-surface rounded-3xl p-8 border border-gray-100 hover:border-indigo-300 hover:shadow-xl hover:bg-white transition-all duration-300 group" data-aos="fade-up" data-aos-delay="0">
                    <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-indigo-500 transition-all duration-300 shadow-sm">
                        <svg class="w-7 h-7 text-indigo-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors">Kehadiran QR Code</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Sistem terintegrasi cetak ID Card pintar dengan QR Code Scanner untuk pencatatan absensi otomatis dan *real-time*.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-surface rounded-3xl p-8 border border-gray-100 hover:border-purple-300 hover:shadow-xl hover:bg-white transition-all duration-300 group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-purple-600 transition-all duration-300 shadow-sm">
                        <svg class="w-7 h-7 text-purple-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900 mb-3 group-hover:text-purple-600 transition-colors">Ranking & Penentuan Kelulusan</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Rekapitulasi nilai otomatis untuk menentukan predikat kelulusan kader secara objektif berdasarkan seluruh aspek penilaian.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-surface rounded-3xl p-8 border border-gray-100 hover:border-rose-300 hover:shadow-xl hover:bg-white transition-all duration-300 group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-rose-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-rose-500 transition-all duration-300 shadow-sm">
                        <svg class="w-7 h-7 text-rose-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900 mb-3 group-hover:text-rose-600 transition-colors">Mobile-First UI</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Desain responsif paripurna yang memprioritaskan kenyamanan pengguna di perangkat seluler dengan navigasi *Bottom Menu* yang intuitif.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Gallery Section --}}
    <section id="galeri" class="py-24 bg-surface relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-primary font-bold tracking-wider uppercase text-sm mb-2 block">Dokumentasi Kegiatan</span>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-6">Galeri Pelatihan Baitul Arqam</h2>
                <p class="text-gray-500 text-lg">Momen-momen inspiratif dalam proses perkaderan dan pembinaan ideologi.</p>
            </div>

            @if(isset($galleries) && $galleries->count() > 0)
                @php
                    $cols = [[], [], [], []];
                    foreach($galleries as $idx => $g) {
                        $cols[$idx % 4][] = $g;
                    }
                @endphp
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($cols as $colIdx => $colItems)
                        <div class="space-y-4 {{ $colIdx == 1 ? 'pt-8' : ($colIdx == 3 ? 'pt-12' : '') }}">
                            @foreach($colItems as $itemIdx => $gallery)
                                @php
                                    $aspect = (($colIdx + $itemIdx) % 2 == 0) ? 'aspect-[3/4]' : 'aspect-square';
                                @endphp
                                <div class="group relative overflow-hidden rounded-2xl {{ $aspect }}" data-aos="zoom-in" data-aos-delay="{{ $colIdx * 100 }}">
                                    <img src="{{ $gallery->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $gallery->title }}">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
                                        <p class="font-bold">{{ $gallery->title }}</p>
                                        <p class="text-xs">{{ $gallery->event_name ?? 'Baitul Arqam' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="space-y-4">
                        <div class="group relative overflow-hidden rounded-2xl aspect-[3/4]" data-aos="zoom-in">
                            <img src="{{ asset('images/gallery/gallery_discussion.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Gallery">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
                                <p class="font-bold">Sesi Diskusi</p>
                                <p class="text-xs">Baitul Arqam PDM</p>
                            </div>
                        </div>
                        <div class="group relative overflow-hidden rounded-2xl aspect-square" data-aos="zoom-in" data-aos-delay="100">
                            <img src="{{ asset('images/gallery/gallery_lecture.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Gallery">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
                                <p class="font-bold">Materi Ideologi</p>
                                <p class="text-xs">Aula Utama</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4 pt-8">
                        <div class="group relative overflow-hidden rounded-2xl aspect-square" data-aos="zoom-in" data-aos-delay="200">
                            <img src="{{ asset('images/gallery/gallery_opening.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Gallery">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
                                <p class="font-bold">Opening Ceremony</p>
                                <p class="text-xs">Muhammadiyah Center</p>
                            </div>
                        </div>
                        <div class="group relative overflow-hidden rounded-2xl aspect-[3/4]" data-aos="zoom-in" data-aos-delay="300">
                            <img src="{{ asset('images/gallery/gallery_focus_group.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Gallery">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
                                <p class="font-bold">Focus Group</p>
                                <p class="text-xs">Rapat Komisi</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="group relative overflow-hidden rounded-2xl aspect-[3/4]" data-aos="zoom-in" data-aos-delay="400">
                            <img src="{{ asset('images/gallery/gallery_outbound.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Gallery">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
                                <p class="font-bold">Outbound Session</p>
                                <p class="text-xs">Training Ground</p>
                            </div>
                        </div>
                        <div class="group relative overflow-hidden rounded-2xl aspect-square" data-aos="zoom-in" data-aos-delay="500">
                            <img src="{{ asset('images/gallery/gallery_closing.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Gallery">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
                                <p class="font-bold">Sesi Selebrasi</p>
                                <p class="text-xs">Penutupan</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4 pt-12">
                        <div class="group relative overflow-hidden rounded-2xl aspect-square" data-aos="zoom-in" data-aos-delay="600">
                            <img src="{{ asset('images/gallery/gallery_discussion.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Gallery">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
                                <p class="font-bold">Penutupan</p>
                                <p class="text-xs">Sesi Selebrasi</p>
                            </div>
                        </div>
                        <div class="group relative overflow-hidden rounded-2xl aspect-[3/4]" data-aos="zoom-in" data-aos-delay="700">
                            <img src="{{ asset('images/gallery/gallery_lecture.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Gallery">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-6 flex flex-col justify-end text-white">
                                <p class="font-bold">Ramah Tamah</p>
                                <p class="text-xs">Kebersamaan</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Testimonials Section --}}
    <section id="testimoni" class="py-24 bg-[#06293F] relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:40px_40px]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="text-accent font-bold tracking-wider uppercase text-sm mb-2 block" data-aos="fade-down">Testimoni</span>
                <h2 class="text-3xl md:text-5xl font-heading font-bold text-white mb-6" data-aos="fade-up">Apa Kata <span class="text-gradient-gold italic">Mereka</span>?</h2>
                <p class="text-primary-100 text-lg" data-aos="fade-up" data-aos-delay="100">Dengarkan pengalaman nyata dari tokoh dan penggerak perkaderan yang telah bertransformasi.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @if(isset($testimonials) && $testimonials->count() > 0)
                    @foreach($testimonials as $idx => $testimonial)
                        <div class="group relative h-[450px] rounded-[2rem] overflow-hidden bg-gray-900 border border-white/10" data-aos="fade-up" data-aos-delay="{{ $idx * 100 }}">
                            <img src="{{ $testimonial->photo_url }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-70 group-hover:opacity-40" alt="{{ $testimonial->name }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/20 to-transparent"></div>
                            
                            {{-- Default State: Name & Role --}}
                            <div class="absolute bottom-0 left-0 w-full p-8 transition-all duration-500 transform group-hover:translate-y-[-20px] group-hover:opacity-0">
                                <h3 class="text-2xl font-heading font-bold text-white mb-1">{{ $testimonial->name }}</h3>
                                <p class="text-accent font-medium">{{ $testimonial->role }}</p>
                            </div>

                            {{-- Hover State: The "Words" --}}
                            <div class="absolute inset-0 p-8 flex flex-col justify-center items-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-500 bg-primary/20 backdrop-blur-sm">
                                <div class="mb-4">
                                    <img src="{{ asset('Logoums.png') }}" class="h-12 w-auto mx-auto object-contain" alt="Logo UMS">
                                </div>
                                <h3 class="text-xl font-heading font-bold text-white mb-2">{{ $testimonial->name }}</h3>
                                <p class="text-primary-100 text-sm mb-6 uppercase tracking-widest font-bold">{{ $testimonial->role }}</p>
                                <p class="text-white/90 leading-relaxed italic">
                                    "{{ $testimonial->quote }}"
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="group relative h-[450px] rounded-[2rem] overflow-hidden bg-gray-900 border border-white/10" data-aos="fade-up" data-aos-delay="0">
                        <img src="{{ asset('images/testimonials/testimonial_1.png') }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-70 group-hover:opacity-40" alt="Testimonial">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/20 to-transparent"></div>
                        
                        <div class="absolute bottom-0 left-0 w-full p-8 transition-all duration-500 transform group-hover:translate-y-[-20px] group-hover:opacity-0">
                            <h3 class="text-2xl font-heading font-bold text-white mb-1">Ahmad Mujahid</h3>
                            <p class="text-accent font-medium">Master of Training</p>
                        </div>

                        <div class="absolute inset-0 p-8 flex flex-col justify-center items-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-500 bg-primary/20 backdrop-blur-sm">
                            <div class="mb-4">
                                <img src="{{ asset('Logoums.png') }}" class="h-12 w-auto mx-auto object-contain" alt="Logo UMS">
                            </div>
                            <h3 class="text-xl font-heading font-bold text-white mb-2">Ahmad Mujahid</h3>
                            <p class="text-primary-100 text-sm mb-6 uppercase tracking-widest font-bold">Master of Training</p>
                            <p class="text-white/90 leading-relaxed italic">
                                "Sistem ini sangat memudahkan kami para instruktur dalam melakukan scoring real-time. Objektivitas penilaian terjamin dengan algoritma SAW."
                            </p>
                        </div>
                    </div>

                    <div class="group relative h-[450px] rounded-[2rem] overflow-hidden bg-gray-900 border border-white/10" data-aos="fade-up" data-aos-delay="100">
                        <img src="{{ asset('images/testimonials/testimonial_2.png') }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-70 group-hover:opacity-40" alt="Testimonial">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/20 to-transparent"></div>
                        
                        <div class="absolute bottom-0 left-0 w-full p-8 transition-all duration-500 transform group-hover:translate-y-[-20px] group-hover:opacity-0">
                            <h3 class="text-2xl font-heading font-bold text-white mb-1">Siti Nurhaliza</h3>
                            <p class="text-accent font-medium">Peserta Baitul Arqam</p>
                        </div>

                        <div class="absolute inset-0 p-8 flex flex-col justify-center items-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-500 bg-primary/20 backdrop-blur-sm">
                            <div class="mb-4">
                                <img src="{{ asset('Logoums.png') }}" class="h-12 w-auto mx-auto object-contain" alt="Logo UMS">
                            </div>
                            <h3 class="text-xl font-heading font-bold text-white mb-2">Siti Nurhaliza</h3>
                            <p class="text-primary-100 text-sm mb-6 uppercase tracking-widest font-bold">Peserta Baitul Arqam</p>
                            <p class="text-white/90 leading-relaxed italic">
                                "Proses pretest dan posttest jadi lebih asyik karena langsung tahu skornya. Sertifikat juga bisa langsung didownload, praktis sekali!"
                            </p>
                        </div>
                    </div>

                    <div class="group relative h-[450px] rounded-[2rem] overflow-hidden bg-gray-900 border border-white/10" data-aos="fade-up" data-aos-delay="200">
                        <img src="{{ asset('images/testimonials/testimonial_3.png') }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-70 group-hover:opacity-40" alt="Testimonial">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/20 to-transparent"></div>
                        
                        <div class="absolute bottom-0 left-0 w-full p-8 transition-all duration-500 transform group-hover:translate-y-[-20px] group-hover:opacity-0">
                            <h3 class="text-2xl font-heading font-bold text-white mb-1">Rahmat Wijaya</h3>
                            <p class="text-accent font-medium">Pimpinan Wilayah</p>
                        </div>

                        <div class="absolute inset-0 p-8 flex flex-col justify-center items-center text-center opacity-0 group-hover:opacity-100 transition-opacity duration-500 bg-primary/20 backdrop-blur-sm">
                            <div class="mb-4">
                                <img src="{{ asset('Logoums.png') }}" class="h-12 w-auto mx-auto object-contain" alt="Logo UMS">
                            </div>
                            <h3 class="text-xl font-heading font-bold text-white mb-2">Rahmat Wijaya</h3>
                            <p class="text-primary-100 text-sm mb-6 uppercase tracking-widest font-bold">Pimpinan Wilayah</p>
                            <p class="text-white/90 leading-relaxed italic">
                                "Sebagai pengelola di tingkat wilayah, saya bisa memantau perkembangan kader dengan lebih mudah dan akurat melalui data statistik yang tersedia."
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- FAQ Section --}}
    <section id="faq" class="py-24 bg-surface">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-primary font-bold tracking-wider uppercase text-sm mb-2 block">Punya Pertanyaan?</span>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-gray-900 mb-6">Pertanyaan Populer</h2>
                <p class="text-gray-500 text-lg">Semua yang perlu Anda ketahui tentang sistem ARQAM App.</p>
            </div>

            <div class="space-y-4" x-data="{ active: 1 }">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-2xl border transition-all duration-300 overflow-hidden" data-aos="fade-up" data-aos-delay="100"
                     :class="active === 1 ? 'border-primary shadow-lg ring-1 ring-primary/5' : 'border-gray-100 shadow-sm hover:shadow-md'">
                    <button @click="active = active === 1 ? null : 1" class="w-full px-8 py-6 text-left flex justify-between items-center group">
                        <span class="font-bold text-lg transition-colors" :class="active === 1 ? 'text-primary' : 'text-gray-800 group-hover:text-primary'">Bagaimana cara mendaftar sebagai peserta?</span>
                        <div class="relative w-6 h-6 flex items-center justify-center">
                            <div class="absolute w-4 h-0.5 bg-current transition-transform duration-300" :class="active === 1 ? 'rotate-0' : 'rotate-90'"></div>
                            <div class="absolute w-4 h-0.5 bg-current"></div>
                        </div>
                    </button>
                    <div x-show="active === 1" x-collapse x-cloak>
                        <div class="px-8 pb-6 text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            Anda dapat mendaftar melalui tombol "Masuk" di navigasi atas, kemudian pilih "Daftar Akun". Pastikan Anda mengisi data instansi dengan benar agar diverifikasi oleh admin.
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-2xl border transition-all duration-300 overflow-hidden" data-aos="fade-up" data-aos-delay="200"
                     :class="active === 2 ? 'border-primary shadow-lg ring-1 ring-primary/5' : 'border-gray-100 shadow-sm hover:shadow-md'">
                    <button @click="active = active === 2 ? null : 2" class="w-full px-8 py-6 text-left flex justify-between items-center group">
                        <span class="font-bold text-lg transition-colors" :class="active === 2 ? 'text-primary' : 'text-gray-800 group-hover:text-primary'">Apakah sertifikat yang diterbitkan bersifat resmi?</span>
                        <div class="relative w-6 h-6 flex items-center justify-center">
                            <div class="absolute w-4 h-0.5 bg-current transition-transform duration-300" :class="active === 2 ? 'rotate-0' : 'rotate-90'"></div>
                            <div class="absolute w-4 h-0.5 bg-current"></div>
                        </div>
                    </button>
                    <div x-show="active === 2" x-collapse x-cloak>
                        <div class="px-8 pb-6 text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            Ya, sertifikat digital yang diterbitkan sistem ini dilengkapi dengan kode verifikasi unik (hash) dan QR Code yang dapat divalidasi langsung ke server MPKSDI Muhammadiyah.
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-2xl border transition-all duration-300 overflow-hidden" data-aos="fade-up" data-aos-delay="300"
                     :class="active === 3 ? 'border-primary shadow-lg ring-1 ring-primary/5' : 'border-gray-100 shadow-sm hover:shadow-md'">
                    <button @click="active = active === 3 ? null : 3" class="w-full px-8 py-6 text-left flex justify-between items-center group">
                        <span class="font-bold text-lg transition-colors" :class="active === 3 ? 'text-primary' : 'text-gray-800 group-hover:text-primary'">Bagaimana cara mengunduh sertifikat?</span>
                        <div class="relative w-6 h-6 flex items-center justify-center">
                            <div class="absolute w-4 h-0.5 bg-current transition-transform duration-300" :class="active === 3 ? 'rotate-0' : 'rotate-90'"></div>
                            <div class="absolute w-4 h-0.5 bg-current"></div>
                        </div>
                    </button>
                    <div x-show="active === 3" x-collapse x-cloak>
                        <div class="px-8 pb-6 text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            Setelah event dinyatakan selesai dan nilai Anda mencapai ambang batas kelulusan, tombol "Unduh Sertifikat" akan otomatis muncul di dashboard peserta Anda.
                        </div>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-2xl border transition-all duration-300 overflow-hidden" data-aos="fade-up" data-aos-delay="400"
                     :class="active === 4 ? 'border-primary shadow-lg ring-1 ring-primary/5' : 'border-gray-100 shadow-sm hover:shadow-md'">
                    <button @click="active = active === 4 ? null : 4" class="w-full px-8 py-6 text-left flex justify-between items-center group">
                        <span class="font-bold text-lg transition-colors" :class="active === 4 ? 'text-primary' : 'text-gray-800 group-hover:text-primary'">Apa peran MoT (Master of Training)?</span>
                        <div class="relative w-6 h-6 flex items-center justify-center">
                            <div class="absolute w-4 h-0.5 bg-current transition-transform duration-300" :class="active === 4 ? 'rotate-0' : 'rotate-90'"></div>
                            <div class="absolute w-4 h-0.5 bg-current"></div>
                        </div>
                    </button>
                    <div x-show="active === 4" x-collapse x-cloak>
                        <div class="px-8 pb-6 text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            MoT bertugas memberikan penilaian psikomotorik (keaktifan dan perilaku) secara langsung di lapangan melalui dashboard instruktur, yang nantinya akan digabung dengan nilai tes kognitif.
                        </div>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-white rounded-2xl border transition-all duration-300 overflow-hidden" data-aos="fade-up" data-aos-delay="500"
                     :class="active === 5 ? 'border-primary shadow-lg ring-1 ring-primary/5' : 'border-gray-100 shadow-sm hover:shadow-md'">
                    <button @click="active = active === 5 ? null : 5" class="w-full px-8 py-6 text-left flex justify-between items-center group">
                        <span class="font-bold text-lg transition-colors" :class="active === 5 ? 'text-primary' : 'text-gray-800 group-hover:text-primary'">Apakah data saya aman di sistem ini?</span>
                        <div class="relative w-6 h-6 flex items-center justify-center">
                            <div class="absolute w-4 h-0.5 bg-current transition-transform duration-300" :class="active === 5 ? 'rotate-0' : 'rotate-90'"></div>
                            <div class="absolute w-4 h-0.5 bg-current"></div>
                        </div>
                    </button>
                    <div x-show="active === 5" x-collapse x-cloak>
                        <div class="px-8 pb-6 text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            Kami menerapkan enkripsi data standar industri dan sistem autentikasi berlapis untuk memastikan informasi pribadi dan hasil evaluasi Anda hanya dapat diakses oleh pihak yang berwenang.
                        </div>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="bg-white rounded-2xl border transition-all duration-300 overflow-hidden" data-aos="fade-up" data-aos-delay="600"
                     :class="active === 6 ? 'border-primary shadow-lg ring-1 ring-primary/5' : 'border-gray-100 shadow-sm hover:shadow-md'">
                    <button @click="active = active === 6 ? null : 6" class="w-full px-8 py-6 text-left flex justify-between items-center group">
                        <span class="font-bold text-lg transition-colors" :class="active === 6 ? 'text-primary' : 'text-gray-800 group-hover:text-primary'">Bisakah diakses melalui smartphone?</span>
                        <div class="relative w-6 h-6 flex items-center justify-center">
                            <div class="absolute w-4 h-0.5 bg-current transition-transform duration-300" :class="active === 6 ? 'rotate-0' : 'rotate-90'"></div>
                            <div class="absolute w-4 h-0.5 bg-current"></div>
                        </div>
                    </button>
                    <div x-show="active === 6" x-collapse x-cloak>
                        <div class="px-8 pb-6 text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            Tentu! ARQAM App didesain dengan prinsip *Mobile-First*, sehingga Anda bisa mengerjakan tes, melakukan absensi QR, dan memantau nilai dengan nyaman melalui browser di smartphone Anda.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA / Active Event Section --}}
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-[#0A2E42] rounded-[2.5rem] p-8 md:p-16 shadow-2xl relative overflow-hidden border border-white/5" data-aos="fade-up">
                {{-- Subtle professional background gradient --}}
                <div class="absolute inset-0 bg-gradient-to-br from-primary-900 to-primary-800 opacity-50"></div>
                
                <div class="grid lg:grid-cols-2 gap-16 items-center relative z-10">
                    <div class="text-left">
                        <span class="text-accent font-bold uppercase tracking-widest text-xs mb-4 block" data-aos="fade-up" data-aos-delay="100">
                            Dashboard Terpadu
                        </span>
                        <h2 class="text-3xl md:text-5xl font-heading font-bold text-white mb-6 leading-tight" data-aos="fade-up" data-aos-delay="200">
                            Pantau Progres <br/>
                            Perkaderan Anda
                        </h2>
                        <p class="text-gray-300 mb-10 text-lg leading-relaxed max-w-xl" data-aos="fade-up" data-aos-delay="300">
                            Masuk ke dashboard untuk melihat hasil evaluasi, jadwal materi, dan status kelulusan Anda secara real-time dengan transparansi penuh.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4" data-aos="fade-up" data-aos-delay="400">
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-accent text-white rounded-xl font-bold text-lg hover:bg-accent-600 transition-all shadow-lg hover:shadow-accent/20 group">
                                Masuk ke Sistem
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>

                    <div class="relative" data-aos="fade-up" data-aos-delay="500">
                        @if($activeEvent)
                            {{-- Professional Event Card --}}
                            @php
                                $totalPeserta = $activeEvent->peserta()->count();
                                $kuota = $activeEvent->kuota ?: 100; // Default 100 if not set
                                $persen = min(100, round(($totalPeserta / $kuota) * 100));
                                $isFull = $totalPeserta >= $kuota;
                            @endphp
                            <div class="bg-white rounded-3xl p-8 shadow-2xl relative z-10 border border-gray-100 transform hover:-translate-y-1 transition-transform duration-300">
                                <div class="flex items-center justify-between mb-8">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full {{ $activeEvent->status === 'berlangsung' ? 'bg-green-500' : 'bg-blue-500' }} animate-pulse"></span>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                            {{ $activeEvent->status === 'persiapan' ? 'Pendaftaran Dibuka' : 'Event Sedang Berlangsung' }}
                                        </span>
                                    </div>
                                    <span class="px-3 py-1 {{ $isFull ? 'bg-red-50 text-red-600' : 'bg-primary-50 text-primary-600' }} rounded-full text-[9px] font-bold uppercase tracking-wider">
                                        {{ $isFull ? 'Kuota Penuh' : 'Kuota Terbatas' }}
                                    </span>
                                </div>
                                
                                <div class="flex gap-6 mb-8">
                                    <div class="w-20 h-20 bg-gray-50 rounded-2xl flex flex-col items-center justify-center border border-gray-100 flex-shrink-0">
                                        <span class="text-3xl font-black text-primary leading-none">{{ $activeEvent->tanggal_mulai->format('d') }}</span>
                                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-tighter">{{ $activeEvent->tanggal_mulai->format('M Y') }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight mb-2">{{ $activeEvent->nama_event }}</h3>
                                        <div class="flex items-center gap-1.5 text-gray-500">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span class="text-sm font-medium">{{ $activeEvent->lokasi }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="pt-6 border-t border-gray-100">
                                    <div class="flex justify-between items-center text-[10px] font-bold uppercase tracking-wider mb-2">
                                        <span class="text-gray-400">Progress Pendaftaran</span>
                                        <span class="text-primary-600">Terisi {{ $persen }}%</span>
                                    </div>
                                    <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-primary rounded-full transition-all duration-1000" style="width: {{ $persen }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Subtle depth layer --}}
                        <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-white/5 rounded-2xl z-0 border border-white/10"></div>
                        <div class="absolute -top-6 -left-6 w-16 h-16 bg-accent/10 rounded-full z-0 border border-white/5"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-100 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo.webp') }}" alt="Logo" class="h-10 grayscale hover:grayscale-0 transition-all">
                </div>
                <div class="text-sm text-gray-500 font-medium">
                    &copy; 2026 <button @click="showDev = true" class="text-primary/70 hover:text-primary font-bold transition-all hover:underline decoration-accent underline-offset-4">LP3A UMS</button>  All rights reserved.
                </div>
                <div class="flex space-x-4">
                    <a href="https://lp3a.ums.ac.id/" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-primary/10 hover:text-primary transition-colors" title="Website LP3A UMS">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/lp3aumsofficial/" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-primary/10 hover:text-primary transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
            </div>
        </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Animate On Scroll
            AOS.init({
                duration: 1000,
                once: true,
                easing: 'ease-out-cubic',
                offset: 50,
            });

            // Initialize Lenis Smooth Scroll
            const lenis = new Lenis({
                duration: 1.2,
                easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // premium exponential easing
                orientation: 'vertical',
                gestureOrientation: 'vertical',
                smoothWheel: true,
                wheelMultiplier: 1,
                touchMultiplier: 2,
                infinite: false,
            });

            function raf(time) {
                lenis.raf(time);
                requestAnimationFrame(raf);
            }

            requestAnimationFrame(raf);

            // Bind click on hash links to lenis scroll
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetEl = document.querySelector(targetId);
                    if (targetEl) {
                        lenis.scrollTo(targetEl, {
                            offset: -80, // match height of navigation header
                            duration: 1.5,
                        });
                    }
                });
            });

            // Smooth Number Counter Animation
            const counters = document.querySelectorAll('.counter');
            const speed = 200; 

            const animateCounters = () => {
                counters.forEach(counter => {
                    const updateCount = () => {
                        const target = +counter.getAttribute('data-target');
                        const count = +counter.innerText;
                        const inc = target / speed;

                        if (count < target) {
                            counter.innerText = Math.ceil(count + inc);
                            setTimeout(updateCount, 15);
                        } else {
                            counter.innerText = target;
                        }
                    };
                    
                    // Simple Intersection Observer to start counting when visible
                    const observer = new IntersectionObserver((entries) => {
                        if(entries[0].isIntersecting) {
                            updateCount();
                            observer.disconnect();
                        }
                    });
                    observer.observe(counter);
                });
            }
            
            // Allow AOS to finish before starting counter
            setTimeout(animateCounters, 500);
        });
    </script>
</body>
</html>
