@extends('layouts.app')

@section('title', 'Pendaftaran Baitul Arqam — ' . $event->nama_event)

@section('head_extra')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
<style>
    [x-cloak] { display: none !important; }
    html { scroll-behavior: smooth; background-color: #F1F5F9; font-family: 'Inter', sans-serif; }
    h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
    
    .primary-blue { background-color: #1A6D9B; }
    .text-primary { color: #1A6D9B; }
    .border-primary { border-color: #1A6D9B; }
    .bg-primary-light { background-color: rgba(26, 109, 155, 0.05); }

    .input-modern {
        width: 100%;
        padding: 1rem 1.25rem;
        background-color: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 0.875rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: #1e293b;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }
    .input-modern:focus {
        background-color: #ffffff;
        border-color: #1A6D9B;
        box-shadow: 0 0 0 4px rgba(26, 109, 155, 0.15);
        outline: none;
    }
    .input-modern::placeholder {
        color: #94a3b8;
    }

    .hero-mesh { 
        background-color: #06293F;
        background-image: 
            radial-gradient(at 0% 0%, hsla(201, 71%, 35%, 1) 0px, transparent 50%),
            radial-gradient(at 100% 0%, hsla(201, 71%, 25%, 1) 0px, transparent 50%);
    }

    .animate-shake { animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both; }
    @keyframes shake { 
        10%, 90% { transform: translate3d(-1px, 0, 0); } 
        20%, 80% { transform: translate3d(2px, 0, 0); } 
        30%, 50%, 70% { transform: translate3d(-4px, 0, 0); } 
        40%, 60% { transform: translate3d(4px, 0, 0); } 
    }

    .blob {
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(26, 109, 155, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        z-index: -1;
        animation: float 20s infinite alternate;
    }
    @keyframes float {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(50px, 50px) scale(1.2); }
    }
    
    /* Custom Scrollbar for a cleaner look */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-slate-100 font-sans text-slate-700 pb-10" x-data="registrationWizard()">
    
    {{-- Top Header Section --}}
    <div class="hero-mesh pb-24 pt-8 px-4 md:px-8 shadow-lg relative overflow-hidden">
        <div class="absolute top-[-50px] right-[-50px] w-64 h-64 bg-accent/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-[-100px] left-[-50px] w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="max-w-4xl mx-auto flex items-center justify-between relative z-10">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl flex items-center justify-center shadow-xl overflow-hidden shrink-0">
                    <img src="{{ asset('logo-mpksdi-1.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                </div>
                <div class="flex flex-col text-white">
                    <h1 class="text-xl font-extrabold leading-tight tracking-tight">Pendaftaran Peserta</h1>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="w-1.5 h-1.5 bg-accent rounded-full animate-pulse shrink-0"></span>
                        <p class="text-xs font-medium text-blue-100/90 whitespace-normal leading-snug">{{ $event->nama_event }}</p>
                    </div>
                </div>
            </div>
            
            <div class="md:hidden flex flex-col items-end" x-show="step > 0" x-cloak>
                <div class="bg-white/10 backdrop-blur-md px-3 py-1.5 rounded-xl border border-white/20 text-center">
                    <span class="text-[9px] font-bold text-white/70 uppercase tracking-widest block mb-0.5">Langkah</span>
                    <span class="text-lg font-black text-white leading-none"><span x-text="step"></span><span class="text-white/40 text-sm">/5</span></span>
                </div>
            </div>
        </div>

        {{-- Progress Bar --}}
        <div class="max-w-4xl mx-auto mt-8 relative z-10 transition-all duration-500" :class="step === 0 ? 'opacity-0 h-0' : 'opacity-100'">
            <div class="h-1.5 w-full bg-white/10 rounded-full overflow-hidden backdrop-blur-sm">
                <div class="h-full bg-gradient-to-right from-accent to-accent-600 transition-all duration-500 ease-out rounded-full shadow-[0_0_15px_rgba(212,160,23,0.5)]" 
                     style="background-color: #D4A017;"
                     :style="`width: ${(step === 0 ? 0 : step / 5) * 100}%`"></div>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 -mt-12 relative z-20 flex flex-col md:flex-row gap-6 lg:gap-8 pb-28 md:pb-10">
        
        {{-- Desktop Navigation Sidebar --}}
        <aside class="hidden md:block w-[260px] lg:w-[280px] flex-shrink-0 transition-opacity duration-500" :class="step === 0 ? 'opacity-0 pointer-events-none' : 'opacity-100'">
            <nav class="bg-white p-6 rounded-[1.5rem] shadow-sm border border-slate-200 sticky top-8">
                <div class="mb-6 px-2">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Progress Pendaftaran</h3>
                </div>
                <ul class="space-y-2">
                    <template x-for="(title, index) in stepTitles" :key="index">
                        <li>
                            <div class="flex items-center gap-4 group p-3 rounded-xl transition-all duration-300 relative"
                                :class="step === (index + 1) ? 'bg-slate-50 border border-slate-100' : 'border border-transparent'">
                                
                                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-0 bg-primary rounded-r-full transition-all duration-300"
                                     :class="step === (index + 1) ? 'h-8' : 'h-0'"></div>

                                <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs transition-all duration-300 relative z-10"
                                    :class="step > (index + 1) ? 'bg-emerald-100 text-emerald-700' : (step === (index + 1) ? 'bg-primary text-white shadow-md shadow-primary/20 scale-105' : 'bg-slate-100 text-slate-400')">
                                    <template x-if="step > (index + 1)">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </template>
                                    <template x-if="step <= (index + 1)">
                                        <span x-text="index + 1"></span>
                                    </template>
                                </div>
                                <div>
                                    <p class="text-xs font-bold tracking-tight transition-colors duration-300"
                                        :class="step === (index + 1) ? 'text-slate-900' : 'text-slate-500'" x-text="title"></p>
                                </div>
                            </div>
                        </li>
                    </template>
                </ul>
            </nav>
        </aside>

        {{-- Main Form Area --}}
        <main class="flex-grow w-full max-w-2xl mx-auto md:mx-0 transition-all duration-500">
            
            <form action="{{ route('registration.store', $event->registration_token) }}" method="POST" enctype="multipart/form-data" id="regForm" @input="saveCache" @submit="handleSubmit($event)"
                  class="bg-white p-6 sm:p-10 rounded-[1.5rem] shadow-sm border border-slate-200 relative min-h-[400px]">
                @csrf
                
                {{-- STEP 0: LANDING / INFO PAGE --}}
                <section x-show="step === 0" x-cloak x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="text-center py-4">
                        <div class="flex justify-center mb-6 relative">
                            <div class="absolute inset-0 bg-primary/20 blur-2xl rounded-full w-32 h-32 mx-auto mt-8"></div>
                            <img src="{{ asset('images/arka/arka_greeting.png') }}" alt="Arka Greeting" class="w-40 h-40 object-contain relative z-10 drop-shadow-xl hover:scale-105 transition-transform duration-500">
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight leading-tight mb-4">Pendaftaran Terpadu<br><span class="text-primary">Baitul Arqam</span></h2>
                        <p class="text-slate-500 text-sm leading-relaxed max-w-md mx-auto mb-8 font-medium">
                            Selamat datang. Sistem akan menyimpan pengisian formulir Anda secara otomatis. Anda dapat keluar dan melanjutkannya kembali nanti di perangkat yang sama.
                        </p>

                        <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-3 text-left">
                            <div class="bg-blue-50/80 p-4 rounded-2xl border border-blue-100 flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-0.5">Waktu Pelaksanaan</p>
                                    <p class="text-xs font-semibold text-slate-700">
                                        {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d M Y') }} 
                                        @if($event->tanggal_selesai && $event->tanggal_mulai != $event->tanggal_selesai)
                                            - {{ \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d M Y') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="bg-amber-50/80 p-4 rounded-2xl border border-amber-100 flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-amber-500 uppercase tracking-widest mb-0.5">Lokasi</p>
                                    <p class="text-xs font-semibold text-slate-700">{{ $event->lokasi ?? 'Lokasi belum ditentukan' }}</p>
                                </div>
                            </div>
                        </div>

                        @if($event->deskripsi)
                        <div class="mb-8 p-5 bg-slate-50 rounded-2xl border border-slate-100 text-left">
                            <h3 class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Tentang Kegiatan</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $event->deskripsi }}</p>
                        </div>
                        @endif

                        <div class="bg-white rounded-2xl p-6 text-left border-[1.5px] border-slate-200 shadow-sm mb-2">
                            <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                Harap Siapkan Data Berikut:
                            </h3>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                                    <span class="text-xs sm:text-sm text-slate-600 font-semibold leading-snug">Identitas Resmi (KTP / NIK 16 Digit)</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                                    <span class="text-xs sm:text-sm text-slate-600 font-semibold leading-snug">Nomor Baku Muhammadiyah (Jika memiliki)</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                                    <span class="text-xs sm:text-sm text-slate-600 font-semibold leading-snug">Detail Unit Kerja / Instansi Amal Usaha</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                                    <span class="text-xs sm:text-sm text-slate-600 font-semibold leading-snug">File Pas Foto Formal (Ukuran Maksimal 2MB)</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>

                {{-- STEP 1: BIODATA DASAR --}}
                <section x-show="step === 1" x-cloak x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="mb-8 border-b border-slate-100 pb-5">
                        <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-widest rounded-lg mb-2">Tahap 1</span>
                        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Biodata Dasar</h2>
                        <p class="text-sm text-slate-500 mt-1">Lengkapi informasi pribadi sesuai dengan identitas resmi (KTP).</p>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_lengkap" placeholder="Contoh: budiono siregar, S.Kpl" required class="input-modern">
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">NIK <span class="text-red-500">*</span></label>
                                <input type="tel" name="nik" placeholder="16 digit NIK" required pattern="[0-9]{16}" class="input-modern">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">NBM (Bila punya)</label>
                                <input type="text" name="nbm" placeholder="Nomor Baku Muhammadiyah" class="input-modern">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach(['L' => 'Laki-laki', 'P' => 'Perempuan'] as $val => $label)
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="jenis_kelamin" value="{{ $val }}" required class="peer sr-only">
                                        <div class="p-3 text-center rounded-xl border-[1.5px] border-slate-200 bg-white font-semibold text-sm text-slate-600 transition-all peer-checked:border-primary peer-checked:bg-primary-light peer-checked:text-primary hover:border-slate-300 shadow-sm peer-checked:shadow-none">
                                            {{ $label }}
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Umur <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" name="umur" placeholder="Contoh: 30" required class="input-modern pr-16">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium text-xs">Tahun</span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Tempat Lahir <span class="text-red-500">*</span></label>
                                <input type="text" name="tempat_lahir" placeholder="Kota/Kabupaten" required class="input-modern">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_lahir" required class="input-modern">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Status Pernikahan <span class="text-red-500">*</span></label>
                            <select name="status_pernikahan" required class="input-modern">
                                <option value="">Pilih Status</option>
                                <option value="Menikah">Menikah</option>
                                <option value="Belum Menikah">Belum Menikah</option>
                                <option value="Janda/Duda">Janda/Duda</option>
                            </select>
                        </div>

                        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 space-y-5">
                            <h4 class="text-xs font-bold text-slate-800 flex items-center gap-2 border-b border-slate-200 pb-3">
                                <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"/></svg>
                                Domisili (Jawa Tengah)
                            </h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1.5 ml-1">Kabupaten / Kota <span class="text-red-500">*</span></label>
                                    <select name="kabupaten" x-model="selectedKab" @change="fetchKecamatans()" required class="input-modern py-2.5 text-sm">
                                        <option value="">Pilih Kabupaten</option>
                                        <template x-for="kab in kabupatens" :key="kab.id"><option :value="kab.id" x-text="kab.name"></option></template>
                                    </select>
                                    <input type="hidden" name="kabupaten_name" :value="kabName">
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[11px] font-semibold text-slate-500 mb-1.5 ml-1">Kecamatan <span class="text-red-500">*</span></label>
                                        <select name="kecamatan" x-model="selectedKec" @change="fetchDesas()" :disabled="!selectedKab" required class="input-modern py-2.5 text-sm disabled:bg-slate-100 disabled:opacity-60">
                                            <option value="">Pilih Kecamatan</option>
                                            <template x-for="kec in kecamatans" :key="kec.id"><option :value="kec.id" x-text="kec.name"></option></template>
                                        </select>
                                        <input type="hidden" name="kecamatan_name" :value="kecName">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-slate-500 mb-1.5 ml-1">Desa / Kelurahan <span class="text-red-500">*</span></label>
                                        <select name="desa_kelurahan" x-model="selectedDesa" :disabled="!selectedKec" required class="input-modern py-2.5 text-sm disabled:bg-slate-100 disabled:opacity-60">
                                            <option value="">Pilih Desa</option>
                                            <template x-for="desa in desas" :key="desa.id"><option :value="desa.name" x-text="desa.name"></option></template>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1.5 ml-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                                    <textarea name="alamat_rumah" rows="2" placeholder="Nama Jalan, Blok, RT/RW" required class="input-modern resize-none text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- STEP 2: PEKERJAAN & KONTAK --}}
                <section x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="mb-8 border-b border-slate-100 pb-5">
                        <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-widest rounded-lg mb-2">Tahap 2</span>
                        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Pekerjaan & Kontak</h2>
                        <p class="text-sm text-slate-500 mt-1">Informasi instansi Amal Usaha dan data kontak aktif.</p>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Jabatan di AUM <span class="text-red-500">*</span></label>
                                <input type="text" name="jabatan_aum" placeholder="Contoh: Guru, Staff" required class="input-modern">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Unit Kerja / Instansi <span class="text-red-500">*</span></label>
                                <input type="text" name="unit_kerja" placeholder="Contoh: SMA Muh 1" required class="input-modern">
                            </div>
                        </div>

                        <div class="h-[1px] w-full bg-slate-100"></div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">WhatsApp Aktif <span class="text-red-500">*</span></label>
                                <div class="relative flex items-center">
                                    <div class="absolute left-1.5 w-10 h-[calc(100%-12px)] bg-slate-50 rounded-l-lg flex items-center justify-center border-r border-slate-200 text-slate-600 font-bold text-xs pointer-events-none">+62</div>
                                    <input type="tel" name="no_hp" placeholder="812xxxxxxxx" required class="input-modern pl-14">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Email Aktif <span class="text-red-500">*</span></label>
                                <input type="email" name="email" placeholder="nama@email.com" required class="input-modern">
                            </div>
                        </div>

                        <div class="h-[1px] w-full bg-slate-100"></div>

                        <div class="space-y-5" x-data="{ 
                            eduLevels: ['SD', 'SMP', 'SMA', 'S1'],
                            shouldShow(lvl) {
                                const map = { 'SD': 1, 'SMP': 2, 'SMA': 3, 'S1': 4 };
                                return map[lvl] <= map[selectedEdu];
                            }
                        }">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Pendidikan Terakhir <span class="text-red-500">*</span></label>
                                <select name="pendidikan_terakhir" x-model="selectedEdu" required class="input-modern">
                                    <option value="">Pilih Pendidikan Terakhir</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP / MTs</option>
                                    <option value="SMA">SMA / SMK / MA</option>
                                    <option value="S1">S1 (Sarjana)</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5" x-show="shouldShow('SD')" x-transition>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Nama SD <span class="text-red-500">*</span></label>
                                    <input type="text" name="pendidikan_sd" placeholder="SD Negeri / Swasta" :required="shouldShow('SD')" class="input-modern">
                                </div>
                                <div x-show="shouldShow('SMP')">
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Nama SMP / MTs <span class="text-red-500">*</span></label>
                                    <input type="text" name="pendidikan_smp" placeholder="Nama Sekolah" :required="shouldShow('SMP')" class="input-modern">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5" x-show="shouldShow('SMA')" x-transition>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Nama SMA / SMK / MA <span class="text-red-500">*</span></label>
                                    <input type="text" name="pendidikan_sma" placeholder="Nama Sekolah" :required="shouldShow('SMA')" class="input-modern">
                                </div>
                                <div x-show="shouldShow('S1')">
                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">S1 (Nama Kampus & Prodi) <span class="text-red-500">*</span></label>
                                    <input type="text" name="pendidikan_s1" placeholder="Contoh: UMS - Arsitektur" :required="shouldShow('S1')" class="input-modern">
                                </div>
                            </div>
                        </div>

                        <div class="h-[1px] w-full bg-slate-100"></div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-3 ml-1">Bahasa yang Dikuasai</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                @foreach(['Inggris', 'Arab', 'Mandarin', 'Jepang'] as $lang)
                                <label class="relative cursor-pointer group">
                                    <input type="checkbox" name="bahasa_dikuasai[]" value="Bahasa {{ $lang }}" class="peer sr-only">
                                    <div class="p-3 text-center rounded-xl border-[1.5px] border-slate-200 bg-white font-medium text-xs text-slate-600 transition-all peer-checked:border-primary peer-checked:bg-primary-light peer-checked:text-primary hover:border-slate-300 shadow-sm peer-checked:shadow-none">
                                        {{ $lang }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                {{-- STEP 3: LATAR KEAGAMAAN --}}
                <section x-show="step === 3" x-cloak x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="mb-8 border-b border-slate-100 pb-5">
                        <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-widest rounded-lg mb-2">Tahap 3</span>
                        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Latar Keagamaan</h2>
                        <p class="text-sm text-slate-500 mt-1">Pilih yang paling sesuai dengan rutinitas harian Anda.</p>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2.5 ml-1">Kemampuan Membaca Al-Qur'an <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach(["Iqro'", "Terbata-bata", "Lancar belum fasih", "Lancar dan Fasih", "Bersanad Ulama"] as $opt)
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="kemampuan_baca_quran" value="{{ $opt }}" required class="peer sr-only">
                                    <div class="p-3.5 rounded-xl border-[1.5px] border-slate-200 bg-white font-medium text-sm text-slate-700 transition-all peer-checked:border-primary peer-checked:bg-primary-light peer-checked:text-primary hover:border-slate-300 shadow-sm flex items-center justify-between gap-2">
                                        <span class="leading-tight">{{ $opt }}</span>
                                        <div class="w-4 h-4 shrink-0 rounded-full border-2 border-slate-300 peer-checked:border-primary peer-checked:bg-primary transition-all"></div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2.5 ml-1">Jumlah Hafalan Al-Qur'an <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach(["1-10 surat", "10-20 surat", "1 juz", "5 juz", "10 juz", "30 juz"] as $opt)
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="hafalan_quran_1" value="{{ $opt }}" required class="peer sr-only">
                                    <div class="py-3 px-2 text-center rounded-xl border-[1.5px] border-slate-200 bg-white font-bold text-xs text-slate-600 transition-all peer-checked:border-primary peer-checked:bg-primary peer-checked:text-white hover:border-slate-300 shadow-sm leading-tight flex items-center justify-center min-h-[44px]">
                                        {{ $opt }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2.5 ml-1">Rutinitas Sholat Berjamaah di Masjid <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach(["Selalu", "Sering", "Kadang-kadang", "Jarang"] as $opt)
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="aktivitas_sholat_masjid" value="{{ $opt }} di masjid" required class="peer sr-only">
                                    <div class="p-3.5 rounded-xl border-[1.5px] border-slate-200 bg-white font-medium text-sm text-slate-700 transition-all peer-checked:border-primary peer-checked:bg-primary-light peer-checked:text-primary hover:border-slate-300 shadow-sm flex items-center justify-between gap-2">
                                        <span class="leading-tight">{{ $opt }} di masjid</span>
                                        <div class="w-4 h-4 shrink-0 rounded-full border-2 border-slate-300 peer-checked:border-primary peer-checked:bg-primary transition-all"></div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2.5 ml-1">Kehadiran Kajian Ilmu Agama <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach(["Seminggu 1-3x", "Seminggu 1x", "Sebulan 1x", "Tidak pernah"] as $opt)
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="aktivitas_kajian_agama" value="{{ $opt }}" required class="peer sr-only">
                                    <div class="p-3.5 rounded-xl border-[1.5px] border-slate-200 bg-white font-medium text-sm text-slate-700 transition-all peer-checked:border-primary peer-checked:bg-primary-light peer-checked:text-primary hover:border-slate-300 shadow-sm flex items-center justify-between gap-2">
                                        <span class="leading-tight">{{ $opt }}</span>
                                        <div class="w-4 h-4 shrink-0 rounded-full border-2 border-slate-300 peer-checked:border-primary peer-checked:bg-primary transition-all"></div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2.5 ml-1">Jumlah Buku Agama yang Dimiliki <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach(["1 - 5 buku", "6 - 10 buku", "11 - 20 buku", "Lebih dari 20 buku"] as $opt)
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="jumlah_buku_agama_text" value="{{ $opt }}" required class="peer sr-only">
                                    <div class="p-3.5 rounded-xl border-[1.5px] border-slate-200 bg-white font-medium text-sm text-slate-700 transition-all peer-checked:border-primary peer-checked:bg-primary-light peer-checked:text-primary hover:border-slate-300 shadow-sm flex items-center justify-between gap-2">
                                        <span class="leading-tight">{{ $opt }}</span>
                                        <div class="w-4 h-4 shrink-0 rounded-full border-2 border-slate-300 peer-checked:border-primary peer-checked:bg-primary transition-all"></div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                {{-- STEP 4: KEMUHAMMADIYAHAN --}}
                <section x-show="step === 4" x-cloak x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="mb-8 border-b border-slate-100 pb-5">
                        <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-widest rounded-lg mb-2">Tahap 4</span>
                        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Kemuhammadiyahan</h2>
                        <p class="text-sm text-slate-500 mt-1">Pemahaman dan keaktifan Anda di Persyarikatan.</p>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2.5 ml-1">Sumber Informasi Muhammadiyah <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 gap-2.5">
                                    @foreach(['Kajian', 'Buku', 'Internet/Sosmed'] as $opt)
                                    <label class="relative cursor-pointer group">
                                        <input type="checkbox" name="sumber_info_muhammadiyah[]" value="{{ $opt }}" class="peer sr-only">
                                        <div class="p-3 rounded-xl border-[1.5px] border-slate-200 bg-white font-medium text-sm text-slate-700 transition-all peer-checked:border-primary peer-checked:bg-primary-light peer-checked:text-primary hover:border-slate-300 shadow-sm flex items-center justify-between gap-2">
                                            <span>{{ $opt }}</span>
                                            <div class="w-4 h-4 shrink-0 rounded border-2 border-slate-300 peer-checked:border-primary peer-checked:bg-primary transition-all flex items-center justify-center">
                                                <svg class="w-3 h-3 text-white scale-0 peer-checked:scale-100 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            </div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2.5 ml-1">Suara Muhammadiyah <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 gap-2.5">
                                    @foreach(['Berlangganan', 'Terkadang beli', 'Tidak pernah'] as $opt)
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="langganan_suara_muhammadiyah" value="{{ $opt }}" required class="peer sr-only">
                                        <div class="p-3 rounded-xl border-[1.5px] border-slate-200 bg-white font-medium text-sm text-slate-700 transition-all peer-checked:border-primary peer-checked:bg-primary-light peer-checked:text-primary hover:border-slate-300 shadow-sm flex items-center justify-between gap-2">
                                            <span>{{ $opt }}</span>
                                            <div class="w-4 h-4 shrink-0 rounded-full border-2 border-slate-300 peer-checked:border-primary peer-checked:bg-primary transition-all"></div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2.5 ml-1">Lembaga ZIS yang Diikuti <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                @foreach(['BAZNAS', 'LAZISMU', 'LAZISNU', 'LAINNYA'] as $opt)
                                <label class="relative cursor-pointer group">
                                    <input type="checkbox" name="lembaga_zis_diikuti[]" value="{{ $opt }}" class="peer sr-only">
                                    <div class="p-3 text-center rounded-xl border-[1.5px] border-slate-200 bg-white font-bold text-xs text-slate-600 transition-all peer-checked:border-primary peer-checked:bg-primary peer-checked:text-white hover:border-slate-300 shadow-sm peer-checked:shadow-none min-h-[44px] flex items-center justify-center">
                                        {{ $opt }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 space-y-5">
                            <h4 class="text-xs font-bold text-slate-800 flex items-center gap-2 border-b border-slate-200 pb-3">Tokoh Inspirasi</h4>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1.5 ml-1">Tokoh Muhammadiyah Paling Berpengaruh <span class="text-red-500">*</span></label>
                                    <input type="text" name="tokoh_berpengaruh" required class="input-modern text-sm py-2.5">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1.5 ml-1">Alasan Memilih Tokoh Tersebut <span class="text-red-500">*</span></label>
                                    <textarea name="alasan_pilih_tokoh" rows="2" required class="input-modern text-sm resize-none"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2.5 ml-1">Keaktifan Pimpinan <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 gap-2.5">
                                    @foreach(['Pusat', 'Wilayah', 'Daerah', 'Cabang'] as $opt)
                                    <label class="relative cursor-pointer group">
                                        <input type="checkbox" name="keaktifan_muhammadiyah[]" value="Pimpinan {{ $opt }}" class="peer sr-only">
                                        <div class="p-3 rounded-xl border-[1.5px] border-slate-200 bg-white font-medium text-sm text-slate-700 transition-all peer-checked:border-primary peer-checked:bg-primary-light peer-checked:text-primary hover:border-slate-300 shadow-sm flex items-center justify-between gap-2">
                                            <span>Pimpinan {{ $opt }}</span>
                                            <div class="w-4 h-4 shrink-0 rounded border-2 border-slate-300 peer-checked:border-primary peer-checked:bg-primary transition-all flex items-center justify-center">
                                                <svg class="w-3 h-3 text-white scale-0 peer-checked:scale-100 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            </div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2.5 ml-1">Keaktifan ORTOM <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 gap-2.5">
                                    @foreach(['Aisyiyah', 'Hizbul Wathon', 'Tapak Suci', 'Pemuda Muhammadiyah'] as $opt)
                                    <label class="relative cursor-pointer group">
                                        <input type="checkbox" name="keaktifan_ortom[]" value="{{ $opt }}" class="peer sr-only">
                                        <div class="p-3 rounded-xl border-[1.5px] border-slate-200 bg-white font-medium text-sm text-slate-700 transition-all peer-checked:border-primary peer-checked:bg-primary-light peer-checked:text-primary hover:border-slate-300 shadow-sm flex items-center justify-between gap-2">
                                            <span>{{ $opt }}</span>
                                            <div class="w-4 h-4 shrink-0 rounded border-2 border-slate-300 peer-checked:border-primary peer-checked:bg-primary transition-all flex items-center justify-center">
                                                <svg class="w-3 h-3 text-white scale-0 peer-checked:scale-100 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            </div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- STEP 5: HARAPAN & FOTO --}}
                <section x-show="step === 5" x-cloak x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="mb-8 border-b border-slate-100 pb-5">
                        <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-widest rounded-lg mb-2">Tahap 5</span>
                        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Harapan & Dokumen</h2>
                        <p class="text-sm text-slate-500 mt-1">Selesaikan pendaftaran dengan melampirkan pas foto formal.</p>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Organisasi Lain (Selain Muhammadiyah) <span class="text-red-500">*</span></label>
                                <textarea name="organisasi_lain" rows="2" placeholder="Isi '-' jika tidak ada" required class="input-modern resize-none"></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Harapan Tentang PCM <span class="text-red-500">*</span></label>
                                <textarea name="harapan_pcm" rows="2" required class="input-modern resize-none"></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5 ml-1">Harapan Mengikuti Baitul Arqam <span class="text-red-500">*</span></label>
                                <textarea name="harapan_mengikuti_ba" rows="2" required class="input-modern resize-none"></textarea>
                            </div>
                        </div>
                        
                        <div class="mt-4"
                             x-data="{
                                preview: null,
                                fileName: '',
                                fileSize: '',
                                hasError: false,
                                errorMsg: '',
                                MAX_SIZE: 2 * 1024 * 1024,
                                handleFile(event) {
                                    const file = event.target.files[0];
                                    if (!file) return;

                                    this.hasError  = false;
                                    this.errorMsg  = '';
                                    this.preview   = null;
                                    this.fileName  = '';
                                    this.fileSize  = '';

                                    if (file.size > this.MAX_SIZE) {
                                        this.hasError = true;
                                        this.errorMsg = 'Ukuran foto ' + (file.size / 1024 / 1024).toFixed(1) + 'MB melebihi batas 2MB. Silakan pilih foto yang lebih kecil atau kompres terlebih dahulu.';
                                        event.target.value = '';
                                        return;
                                    }

                                    this.preview  = URL.createObjectURL(file);
                                    this.fileName = file.name;
                                    this.fileSize = (file.size / 1024).toFixed(0) + ' KB';
                                }
                             }">
                            <label class="block text-xs font-bold text-slate-700 mb-2 ml-1">
                                Unggah Pas Foto Formal
                                <span class="text-slate-400 font-normal">(Opsional)</span>
                            </label>

                            {{-- Error Alert --}}
                            <div x-show="hasError" x-transition
                                 class="mb-3 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3">
                                <svg class="w-5 h-5 shrink-0 mt-0.5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-xs font-semibold leading-snug" x-text="errorMsg"></p>
                            </div>

                            {{-- Upload Area --}}
                            <div class="p-8 rounded-2xl border-2 border-dashed transition-all relative overflow-hidden"
                                 :class="hasError
                                    ? 'bg-red-50 border-red-300'
                                    : (preview ? 'bg-emerald-50 border-emerald-300' : 'bg-slate-50 border-slate-300 group hover:border-primary')">

                                <div class="flex flex-col items-center text-center relative z-10">

                                    {{-- Preview Box --}}
                                    <div class="w-28 h-36 rounded-xl border shadow-md flex items-center justify-center overflow-hidden mb-4 transition-all"
                                         :class="preview ? 'border-emerald-300' : 'bg-white border-slate-200'">
                                        <template x-if="preview">
                                            <img :src="preview" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!preview">
                                            <div class="flex flex-col items-center" :class="hasError ? 'text-red-300' : 'text-slate-300'">
                                                <svg class="w-10 h-10 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        </template>
                                    </div>

                                    {{-- Status teks --}}
                                    <template x-if="preview">
                                        <div>
                                            <div class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full mb-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                Foto siap dikirim
                                            </div>
                                            <p class="text-[11px] text-slate-500 mt-1" x-text="fileName + ' · ' + fileSize"></p>
                                        </div>
                                    </template>
                                    <template x-if="!preview">
                                        <div>
                                            <h3 class="text-sm font-bold" :class="hasError ? 'text-red-700' : 'text-slate-800'">
                                                <span x-text="hasError ? 'Pilih Foto Lain' : 'Pilih Pas Foto'"></span>
                                            </h3>
                                            <p class="text-xs text-slate-500 mt-1 max-w-[250px]">
                                                Format JPG/PNG, <strong>maksimal 2MB</strong>.<br>Diutamakan latar merah/biru.
                                            </p>
                                        </div>
                                    </template>

                                    <div class="mt-4 px-6 py-2 bg-white border rounded-lg text-xs font-bold shadow-sm transition-all cursor-pointer"
                                         :class="hasError
                                            ? 'border-red-300 text-red-600 hover:bg-red-500 hover:text-white hover:border-red-500'
                                            : 'border-slate-300 text-slate-700 group-hover:bg-primary group-hover:text-white group-hover:border-primary'">
                                        <span x-text="preview ? 'Ganti Foto' : 'Pilih File'"></span>
                                    </div>
                                </div>

                                <input type="file" name="foto" accept="image/jpeg,image/png,image/jpg,image/webp"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                       @change="handleFile($event)">
                            </div>
                        </div>
                    </div>
                </section>

                {{-- NAV BAR (MOBILE FIXED, DESKTOP IN-FORM) --}}
                <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 p-3 sm:p-4 z-40 md:static md:bg-transparent md:border-none md:p-0 md:mt-10 flex items-center gap-3 shadow-[0_-4px_15px_rgba(0,0,0,0.05)] md:shadow-none" :class="step === 0 ? 'justify-center' : 'justify-between'">
                    
                    <button type="button" x-show="step > 1" @click="prevStep()" 
                            class="w-[45%] md:w-auto px-4 py-3 bg-slate-100 text-slate-600 text-[13px] font-bold rounded-xl hover:bg-slate-200 transition-all flex items-center justify-center gap-2 border border-slate-200">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                        <span>KEMBALI</span>
                    </button>
                    
                    <div x-show="step === 1" class="hidden md:block w-[45%] md:w-auto"></div>

                    <button type="button" x-show="step === 0" @click="nextStep()" 
                            class="w-full md:w-auto md:min-w-[250px] px-8 py-4 bg-primary text-white text-[14px] font-black rounded-xl shadow-lg hover:bg-primary-600 transition-all flex items-center justify-center gap-3">
                        MULAI MENGISI FORMULIR
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>

                    <button type="button" x-show="step > 0 && step < 5" @click="nextStep()" 
                            class="w-[55%] md:w-auto px-6 py-3 bg-slate-800 text-white text-[13px] font-bold rounded-xl shadow-md hover:bg-slate-900 transition-all flex items-center justify-center gap-2 md:ml-auto">
                        LANJUTKAN
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                    </button>

                    <button type="submit" x-show="step === 5" 
                            class="w-[55%] md:w-auto px-6 py-3 bg-primary text-white text-[13px] font-bold rounded-xl shadow-md shadow-primary/20 hover:bg-primary-600 transition-all flex items-center justify-center gap-2 md:ml-auto">
                        KIRIM DATA
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </button>
                </div>
            </form>
        </main>
    </div>
</div>

<script>
function registrationWizard() {
    return {
        step: 0,
        stepTitles: ['Biodata Dasar', 'Pekerjaan & Kontak', 'Latar Keagamaan', 'Kemuhammadiyahan', 'Harapan & Foto'],
        
        kabupatens: [], kecamatans: [], desas: [],
        selectedKab: '', selectedKec: '', selectedDesa: '',
        selectedEdu: '',
        kabName: '', kecName: '',
        
        cacheKey: 'arqam_reg_{{ $event->registration_token }}',

        init() { 
            this.fetchKabupatens();
            this.restoreCache();
        },

        async fetchKabupatens() {
            try {
                const res = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/regencies/33.json');
                this.kabupatens = await res.json();
            } catch(e) { console.error("Gagal load API:", e); }
        },

        async fetchKecamatans() {
            if (!this.selectedKab) return;
            try {
                const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${this.selectedKab}.json`);
                this.kecamatans = await res.json();
                this.desas = []; this.selectedKec = ''; this.selectedDesa = '';
                const kab = this.kabupatens.find(k => k.id == this.selectedKab);
                this.kabName = kab ? kab.name : '';
            } catch(e) { console.error(e); }
        },

        async fetchDesas() {
            if (!this.selectedKec) return;
            try {
                const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${this.selectedKec}.json`);
                this.desas = await res.json();
                this.selectedDesa = '';
                const kec = this.kecamatans.find(k => k.id == this.selectedKec);
                this.kecName = kec ? kec.name : '';
            } catch(e) { console.error(e); }
        },

        nextStep() {
            if (this.step === 0) {
                this.step = 1;
                this.saveCache();
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return;
            }

            const currentStepEl = document.querySelector(`section[x-show="step === ${this.step}"]`);
            const inputs = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;

            for (let input of inputs) {
                if (!input.checkValidity()) {
                    isValid = false;
                    input.reportValidity();
                    break;
                }
            }

            if (isValid) {
                if (this.step < 5) {
                    this.step++;
                    this.saveCache();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            } else {
                const formArea = document.getElementById('regForm');
                formArea.classList.add('animate-shake');
                setTimeout(() => formArea.classList.remove('animate-shake'), 500);
            }
        },

        prevStep() {
            if (this.step > 1) {
                this.step--;
                this.saveCache();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else if (this.step === 1) {
                this.step = 0;
                this.saveCache();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },

        saveCache() {
            const form = document.getElementById('regForm');
            if(!form) return;
            const data = new FormData(form);
            const obj = { _step: this.step }; 
            for (let [key, value] of data.entries()) {
                if(key === '_token' || key === 'foto') continue;
                if(obj[key]) {
                    if(Array.isArray(obj[key])) obj[key].push(value);
                    else obj[key] = [obj[key], value];
                } else {
                    obj[key] = value;
                }
            }
            localStorage.setItem(this.cacheKey, JSON.stringify(obj));
        },

        restoreCache() {
            const cachedStr = localStorage.getItem(this.cacheKey);
            if(!cachedStr) return;
            try {
                const cached = JSON.parse(cachedStr);
                if(cached._step !== undefined) {
                    this.step = parseInt(cached._step);
                }
                
                setTimeout(async () => {
                    const form = document.getElementById('regForm');
                    if(!form) return;
                    
                    if(cached.kabupaten) {
                        this.selectedKab = cached.kabupaten;
                        await this.fetchKecamatans();
                        if(cached.kecamatan) {
                            this.selectedKec = cached.kecamatan;
                            await this.fetchDesas();
                            if(cached.desa_kelurahan) {
                                this.selectedDesa = cached.desa_kelurahan;
                            }
                        }
                    }

                    for(let key in cached) {
                        if(key === '_step' || key === 'kabupaten' || key === 'kecamatan' || key === 'desa_kelurahan') continue;
                        let val = cached[key];
                        if(Array.isArray(val)) {
                            val.forEach(v => {
                                let el = form.querySelector(`[name="${key}"][value="${v}"]`);
                                if(el) el.checked = true;
                            });
                        } else {
                            let el = form.querySelector(`[name="${key}"]`);
                            if(!el) continue;
                            if(el.type === 'radio') {
                                let radio = form.querySelector(`[name="${key}"][value="${val}"]`);
                                if(radio) radio.checked = true;
                            } else if(el.type === 'checkbox') {
                                if(el.value === val) el.checked = true;
                            } else {
                                el.value = val;
                            }
                        }
                    }
                }, 150); 
            } catch(e) {
                console.error("Gagal memulihkan cache:", e);
            }
        },
        
        clearCache() {
            localStorage.removeItem(this.cacheKey);
        },

        handleSubmit(event) {
            const form = event.target;
            
            if (!form.checkValidity()) {
                event.preventDefault();
                
                const invalidEl = form.querySelector(':invalid');
                if (invalidEl) {
                    const section = invalidEl.closest('section');
                    if (section) {
                        const xShow = section.getAttribute('x-show');
                        const match = xShow ? xShow.match(/step === (\d+)/) : null;
                        if (match) {
                            this.step = parseInt(match[1]);
                            this.saveCache();
                            this.$nextTick(() => {
                                invalidEl.focus();
                                invalidEl.reportValidity();
                            });
                        }
                    }
                }
            } else {
                this.clearCache();
            }
        }
    }
}
</script>
@endsection
