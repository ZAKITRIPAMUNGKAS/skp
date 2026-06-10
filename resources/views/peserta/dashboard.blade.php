@extends('layouts.main')

@section('title', 'Dashboard Peserta')

@push('styles')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .ticket-cut {
        clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%, 0% 70%, 10px 60%, 10px 40%, 0% 30%);
    }
    .step-line {
        background: repeating-linear-gradient(to bottom, #E2E8F0 0%, #E2E8F0 50%, transparent 50%, transparent 100%);
        background-size: 2px 8px;
    }
    @keyframes float-slow {
        0%, 100% { transform: translateY(0) rotate(0); }
        50% { transform: translateY(-10px) rotate(2deg); }
    }
    .animate-float-slow { animation: float-slow 4s ease-in-out infinite; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="space-y-8 pb-12">

    {{-- PROFILE INCOMPLETE REMINDER --}}
    @if(!$peserta->isComplete())
    @php
        $missingFields = [];
        if (empty($peserta->nama_lengkap)) $missingFields[] = 'Nama Lengkap';
        if (empty($peserta->nama_panggilan)) $missingFields[] = 'Nama Panggilan';
        if (empty($peserta->no_hp)) $missingFields[] = 'No. HP';
        if (empty($peserta->unit_kerja)) $missingFields[] = 'Unit Kerja';
        if (empty($peserta->jenis_kelamin)) $missingFields[] = 'Jenis Kelamin';
        if (empty($peserta->nik)) $missingFields[] = 'NIK';
        if (empty($peserta->tempat_lahir)) $missingFields[] = 'Tempat Lahir';
        if (empty($peserta->tanggal_lahir)) $missingFields[] = 'Tanggal Lahir';
        if (empty($peserta->status_pernikahan)) $missingFields[] = 'Status Pernikahan';
        if (empty($peserta->jabatan_aum)) $missingFields[] = 'Jabatan AUM';
        if (empty($peserta->ukuran_kaos)) $missingFields[] = 'Ukuran Kaos';
        if (empty($peserta->alamat_rumah)) $missingFields[] = 'Alamat Rumah';
    @endphp
    <div class="relative overflow-hidden bg-gradient-to-r from-amber-500 to-orange-600 rounded-3xl p-6 md:p-8 text-white shadow-lg shadow-orange-200/50 mb-8 animate-fade-in group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 group-hover:scale-110 transition-transform duration-500"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center p-1 border border-white/20 backdrop-blur-sm shrink-0">
                    <img src="{{ asset('images/arka/arka_alert.png') }}" alt="Alert" class="w-full h-full object-contain drop-shadow-lg">
                </div>
                <div class="text-center md:text-left">
                    <h4 class="text-xl font-heading font-bold mb-1">Profil Belum Lengkap!</h4>
                    <p class="text-orange-50/90 text-sm leading-relaxed">
                        Data diri Anda belum lengkap (Yang masih kosong: <strong class="text-white underline">{{ implode(', ', $missingFields) }}</strong>). Mohon lengkapi data Anda untuk mempermudah proses evaluasi dan penerbitan sertifikat.
                    </p>
                </div>
            </div>
            <a href="{{ route('peserta.profile.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-orange-600 rounded-2xl font-bold text-sm hover:bg-orange-50 transition-all shadow-md active:scale-95 shrink-0">
                Lengkapi Profil Sekarang
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>
    @endif

    @if($activeEvent)
    @if($activeEvent->status === 'persiapan')
        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-xl p-8 md:p-12 text-center max-w-2xl mx-auto space-y-6 animate-fade-in my-8">
            <div class="w-32 h-32 mx-auto bg-amber-50 rounded-full flex items-center justify-center border border-amber-100">
                <img src="{{ asset('images/arka/arka_penilai.png') }}" alt="Mascot Waiting" class="w-24 h-24 object-contain">
            </div>
            <div class="space-y-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-850 uppercase tracking-wider">
                    Status: Persiapan
                </span>
                <h2 class="text-2xl md:text-3xl font-heading font-extrabold text-gray-800">Kegiatan Belum Dimulai</h2>
            </div>
            <p class="text-gray-500 text-sm leading-relaxed max-w-md mx-auto">
                Kegiatan <strong>{{ $activeEvent->nama_event }}</strong> saat ini masih dalam tahap persiapan. Seluruh fitur evaluasi, tes mandiri, jadwal, dan presensi kehadiran akan diaktifkan secara otomatis setelah event dimulai oleh panitia.
            </p>
            <div class="pt-4">
                <a href="{{ route('peserta.profile.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-2xl font-bold text-sm hover:bg-primary/95 transition-all shadow-md active:scale-95">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Lengkapi / Edit Profil Saya
                </a>
            </div>
        </div>
    @else
        {{-- 1. PREMIUM WELCOME BANNER --}}
        <div class="relative overflow-hidden bg-primary rounded-[2.5rem] shadow-2xl shadow-primary/20">
            {{-- Background Decorations --}}
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-20 -mt-20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-accent/20 rounded-full -ml-32 -mb-32 blur-3xl"></div>
            
            <div class="relative px-8 py-10 md:px-12 md:py-14 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex-1 text-center md:text-left space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-white/90 text-xs font-bold uppercase tracking-widest border border-white/20">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Peserta Aktif
                    </div>
                    <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-white leading-[1.1]">
                        Assalamu'alaikum,<br>
                        <span class="text-accent-200">{{ $peserta->nama_lengkap }}</span>
                    </h1>
                    <p class="text-primary-100 text-lg max-w-lg leading-relaxed">
                        Senang melihat Anda kembali. Mari selesaikan tahapan evaluasi Baitul Arqam Anda hari ini dengan semangat!
                    </p>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 pt-2">
                        <div class="px-5 py-3 bg-white/10 rounded-2xl border border-white/20 backdrop-blur-sm">
                            <span class="block text-[10px] text-primary-200 uppercase font-bold tracking-wider mb-0.5">Progress Sesi</span>
                            <span class="text-xl font-bold text-white">{{ $progress['attended'] ?? 0 }} / {{ $progress['total_sesi'] ?? 0 }}</span>
                        </div>
                        <div class="px-5 py-3 bg-white/10 rounded-2xl border border-white/20 backdrop-blur-sm">
                            <span class="block text-[10px] text-primary-200 uppercase font-bold tracking-wider mb-0.5">Status Akhir</span>
                            <span class="text-xl font-bold text-white">
                                @if($activeEvent->status == 'selesai')
                                    {{ $scores->predikat ?? 'Menunggu' }}
                                @else
                                    Sedang Berjalan
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="w-64 h-64 md:w-80 md:h-80 flex-shrink-0 animate-float-slow">
                    <img src="{{ asset('images/arka/arka_greeting.png') }}" alt="Arka Greeting" class="w-full h-full object-contain drop-shadow-2xl">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        {{-- LEFT COLUMN: TICKET & QUICK STATS (4 cols) --}}
        <div class="lg:col-span-4 space-y-8">
            {{-- Digital ID Card --}}
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-primary to-accent rounded-[2rem] blur opacity-25 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative bg-white rounded-[2rem] overflow-hidden shadow-xl border border-gray-100 ticket-cut">
                    {{-- Header ID Card --}}
                    <div class="bg-primary p-6 text-white text-center">
                        <div class="w-16 h-16 bg-white rounded-2xl mx-auto mb-4 p-2 shadow-lg">
                            <img src="{{ url('/logo.webp') }}" class="w-full h-full object-contain" alt="Logo">
                        </div>
                        <h3 class="font-heading font-bold text-lg mb-1">{{ $activeEvent->nama_event }}</h3>
                        <p class="text-primary-100 text-xs font-medium uppercase tracking-widest">{{ $peserta->unit_kerja }}</p>
                    </div>

                    {{-- QR Body --}}
                    <div class="p-8 flex flex-col items-center">
                        {{-- Foto Profil Peserta --}}
                        <div class="w-24 h-24 rounded-full border-4 border-slate-50 overflow-hidden mb-6 shadow-md flex-shrink-0">
                            @if($peserta->foto)
                                <img src="{{ $peserta->foto_url }}" class="w-full h-full object-cover" alt="Foto">
                            @else
                                <div class="w-full h-full bg-primary/10 flex items-center justify-center font-bold text-2xl text-primary font-heading">
                                    {{ strtoupper(substr($peserta->nama_lengkap, 0, 2)) }}
                                </div>
                            @endif
                        </div>

                        <div class="relative">
                            <div class="absolute -inset-4 bg-primary/5 rounded-[2rem] animate-pulse"></div>
                            @if($eventPeserta && $eventPeserta->qr_code)
                                @php
                                    $qrSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(180)->margin(1)->generate($eventPeserta->qr_code);
                                @endphp
                                <div class="relative bg-white p-3 rounded-2xl shadow-inner border border-gray-100">
                                    {!! $qrSvg !!}
                                </div>
                            @else
                                <div class="w-40 h-40 bg-gray-50 rounded-2xl flex flex-col items-center justify-center text-center p-4 border-2 border-dashed border-gray-200">
                                    <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase leading-tight">QR Code<br>Belum Tersedia</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="mt-8 text-center space-y-4 w-full">
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">ID Peserta</p>
                                <p class="text-lg font-mono font-bold text-gray-800">{{ 'ARQ-'.str_pad($peserta->id, 4, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            
                            <hr class="border-dashed border-gray-200">
                            
                            <a href="{{ route('peserta.idcard.download', $activeEvent) }}" 
                               class="inline-flex items-center justify-center gap-3 w-full py-4 bg-gray-900 text-white rounded-2xl font-bold text-sm hover:bg-primary transition-all active:scale-95 shadow-lg">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                Cetak ID Card
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stat Row --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm">
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-500 mb-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Kehadiran</p>
                    <p class="text-xl font-extrabold text-gray-800">{{ round((($progress['attended'] ?? 0) / max(($progress['total_sesi'] ?? 1), 1)) * 100) }}%</p>
                </div>
                <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm">
                    <div class="w-10 h-10 rounded-2xl bg-accent/10 flex items-center justify-center text-accent mb-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Sesi Lulus</p>
                    <p class="text-xl font-extrabold text-gray-800">{{ $progress['attended'] ?? 0 }} / {{ $progress['total_sesi'] ?? 0 }}</p>
                </div>
            </div>

        </div>

        {{-- MAIN COLUMN: TASKS & PROGRESS (8 cols) --}}
        <div class="lg:col-span-8 space-y-8">
            
            {{-- Tasks Card --}}
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
                <div class="px-8 py-8 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-heading font-bold text-gray-800">Tahapan Evaluasi</h3>
                        <p class="text-sm text-gray-500">Selesaikan seluruh tugas untuk mendapatkan sertifikat.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="h-2 w-32 bg-gray-100 rounded-full overflow-hidden">
                            @php
                                $completedCount = (($progress['pretest'] ?? false)?1:0) + (($progress['posttest'] ?? false)?1:0) + (($progress['afektif'] ?? false)?1:0) + (($progress['angket'] ?? false)?1:0);
                                $taskPercent = ($completedCount / 4) * 100;
                            @endphp
                            <div class="h-full bg-primary transition-all duration-1000" style="width: {{ $taskPercent }}%"></div>
                        </div>
                        <span class="text-xs font-bold text-primary">{{ round($taskPercent) }}%</span>
                    </div>
                </div>

                <div class="p-8">
                    <div class="relative space-y-8">
                        {{-- Dotted vertical line --}}
                        <div class="absolute left-6 top-2 bottom-2 w-0.5 step-line"></div>

                        {{-- Step: Pretest --}}
                        <div class="relative flex items-start gap-6 group">
                            <div class="relative z-10 w-12 h-12 flex-shrink-0 rounded-2xl flex items-center justify-center transition-all duration-300 {{ ($progress['pretest'] ?? false) ? 'bg-green-500 text-white shadow-lg shadow-green-200' : 'bg-white border-2 border-gray-200 text-gray-400 group-hover:border-primary/30' }}">
                                @if($progress['pretest'] ?? false)
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                @else
                                    <span class="font-bold">01</span>
                                @endif
                            </div>
                            <div class="flex-1 pt-1">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                                    <div>
                                        <h4 class="text-lg font-bold {{ ($progress['pretest'] ?? false) ? 'text-gray-800' : 'text-gray-500' }}">Pretest</h4>
                                        <p class="text-sm text-gray-400">Evaluasi pemahaman awal sebelum materi dimulai.</p>
                                        @if(($progress['pretest_total'] ?? 0) > 0)
                                            <p class="text-xs text-primary font-bold mt-1">Progres: {{ $progress['pretest_done'] }} / {{ $progress['pretest_total'] }} Materi</p>
                                        @endif
                                        @if($sesiStatus['pretest'] && !($progress['pretest'] ?? false))
                                            <div x-data="{
                                                remaining: '',
                                                init() {
                                                    const remainingSecs = {{ $sesiStatus['pretest_remaining_seconds'] }};
                                                    if (remainingSecs > 0) {
                                                        const target = Date.now() + (remainingSecs * 1000);
                                                        const update = () => {
                                                            const diff = Math.max(0, Math.round((target - Date.now()) / 1000));
                                                            if (diff <= 0) {
                                                                 this.remaining = '';
                                                            } else {
                                                                const m = Math.floor(diff / 60);
                                                                const s = diff % 60;
                                                                this.remaining = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
                                                            }
                                                        };
                                                        update();
                                                        setInterval(update, 1000);
                                                    }
                                                }
                                            }">
                                                <p class="text-xs text-accent font-bold mt-1 flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    <span>Durasi: <span :class="remaining ? 'text-red-500 animate-pulse font-mono' : ''" x-text="remaining ? remaining : '{{ $sesiStatus['pretest_durasi'] }} Menit'"></span></span>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                    @if($progress['pretest'] ?? false)
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-bold uppercase tracking-wider border border-green-100">
                                            Sudah Dikerjakan
                                        </div>
                                    @else
                                        @if($sesiStatus['pretest'] && $sesiStatus['pretest_event_sesi_id'])
                                            <a href="{{ route('peserta.tes.instruction', [$activeEvent, $sesiStatus['pretest_event_sesi_id'], 'pretest']) }}" class="inline-flex items-center gap-2 px-5 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary-600 transition-all shadow-md active:scale-95">
                                                Kerjakan Sekarang
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                            </a>
                                        @else
                                            <a href="{{ route('peserta.tes.index') }}" class="px-4 py-1.5 bg-gray-100 text-gray-500 hover:text-primary rounded-lg text-xs font-bold uppercase tracking-widest border border-gray-200">Lihat Daftar Tes</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Step: Afektif --}}
                        <div class="relative flex items-start gap-6 group">
                            <div class="relative z-10 w-12 h-12 flex-shrink-0 rounded-2xl flex items-center justify-center transition-all duration-300 {{ ($progress['afektif'] ?? false) ? 'bg-green-500 text-white shadow-lg shadow-green-200' : 'bg-white border-2 border-gray-200 text-gray-400 group-hover:border-primary/30' }}">
                                @if($progress['afektif'] ?? false)
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                @else
                                    <span class="font-bold">02</span>
                                @endif
                            </div>
                            <div class="flex-1 pt-1">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                                    <div>
                                        <h4 class="text-lg font-bold {{ ($progress['afektif'] ?? false) ? 'text-gray-800' : 'text-gray-500' }}">Penilaian Afektif</h4>
                                        <p class="text-sm text-gray-400">Pengisian kuesioner sikap dan kedisiplinan mandiri.</p>
                                    </div>
                                    @if($progress['afektif'] ?? false)
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-bold uppercase tracking-wider border border-green-100">
                                            Sudah Dikerjakan
                                        </div>
                                    @else
                                        @if($activeEvent->status == 'berlangsung')
                                            <a href="{{ route('peserta.afektif.index', $activeEvent) }}" class="inline-flex items-center gap-2 px-5 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary-600 transition-all shadow-md active:scale-95">
                                                Isi Kuesioner
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                            </a>
                                        @else
                                            <span class="px-4 py-1.5 bg-gray-100 text-gray-400 rounded-lg text-xs font-bold uppercase tracking-widest border border-gray-200">Menunggu Event Berjalan</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Step: Posttest --}}
                        <div class="relative flex items-start gap-6 group">
                            <div class="relative z-10 w-12 h-12 flex-shrink-0 rounded-2xl flex items-center justify-center transition-all duration-300 {{ ($progress['posttest'] ?? false) ? 'bg-green-500 text-white shadow-lg shadow-green-200' : 'bg-white border-2 border-gray-200 text-gray-400 group-hover:border-primary/30' }}">
                                @if($progress['posttest'] ?? false)
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                @else
                                    <span class="font-bold">03</span>
                                @endif
                            </div>
                            <div class="flex-1 pt-1">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                                    <div>
                                        <h4 class="text-lg font-bold {{ ($progress['posttest'] ?? false) ? 'text-gray-800' : 'text-gray-500' }}">Posttest</h4>
                                        <p class="text-sm text-gray-400">Evaluasi pemahaman akhir setelah seluruh materi selesai.</p>
                                        @if(($progress['posttest_total'] ?? 0) > 0)
                                            <p class="text-xs text-primary font-bold mt-1">Progres: {{ $progress['posttest_done'] }} / {{ $progress['posttest_total'] }} Materi</p>
                                        @endif
                                        @if($sesiStatus['posttest'] && !($progress['posttest'] ?? false))
                                            <div x-data="{
                                                remaining: '',
                                                init() {
                                                    const remainingSecs = {{ $sesiStatus['posttest_remaining_seconds'] }};
                                                    if (remainingSecs > 0) {
                                                        const target = Date.now() + (remainingSecs * 1000);
                                                        const update = () => {
                                                            const diff = Math.max(0, Math.round((target - Date.now()) / 1000));
                                                            if (diff <= 0) {
                                                                this.remaining = '';
                                                            } else {
                                                                const m = Math.floor(diff / 60);
                                                                const s = diff % 60;
                                                                this.remaining = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
                                                            }
                                                        };
                                                        update();
                                                        setInterval(update, 1000);
                                                    }
                                                }
                                            }">
                                                <p class="text-xs text-accent font-bold mt-1 flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    <span>Durasi: <span :class="remaining ? 'text-red-500 animate-pulse font-mono' : ''" x-text="remaining ? remaining : '{{ $sesiStatus['posttest_durasi'] }} Menit'"></span></span>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                    @if($progress['posttest'] ?? false)
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-bold uppercase tracking-wider border border-green-100">
                                            Sudah Dikerjakan
                                        </div>
                                    @else
                                        @if($sesiStatus['posttest'] && $sesiStatus['posttest_event_sesi_id'])
                                            <a href="{{ route('peserta.tes.instruction', [$activeEvent, $sesiStatus['posttest_event_sesi_id'], 'posttest']) }}" class="inline-flex items-center gap-2 px-5 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary-600 transition-all shadow-md active:scale-95">
                                                Mulai Posttest
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                            </a>
                                        @else
                                            <a href="{{ route('peserta.tes.index') }}" class="px-4 py-1.5 bg-gray-100 text-gray-500 hover:text-primary rounded-lg text-xs font-bold uppercase tracking-widest border border-gray-200">Lihat Daftar Tes</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Step: Angket --}}
                        <div class="relative flex items-start gap-6 group">
                            <div class="relative z-10 w-12 h-12 flex-shrink-0 rounded-2xl flex items-center justify-center transition-all duration-300 {{ ($progress['angket'] ?? false) ? 'bg-green-500 text-white shadow-lg shadow-green-200' : 'bg-white border-2 border-gray-200 text-gray-400 group-hover:border-primary/30' }}">
                                @if($progress['angket'] ?? false)
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                @else
                                    <span class="font-bold">04</span>
                                @endif
                            </div>
                            <div class="flex-1 pt-1">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                                    <div>
                                        <h4 class="text-lg font-bold {{ ($progress['angket'] ?? false) ? 'text-gray-800' : 'text-gray-500' }}">Angket Penyelenggaraan</h4>
                                        <p class="text-sm text-gray-400">Masukan dan saran untuk evaluasi penyelenggaraan Baitul Arqam.</p>
                                    </div>
                                    @if($progress['angket'] ?? false)
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-bold uppercase tracking-wider border border-green-100">
                                            Sudah Dikerjakan
                                        </div>
                                    @else
                                        @if($activeEvent->status == 'selesai')
                                            <a href="{{ route('peserta.angket.fill', $activeEvent) }}" class="inline-flex items-center gap-2 px-5 py-2 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary-600 transition-all shadow-md active:scale-95">
                                                Isi Angket
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                            </a>
                                        @else
                                            <span class="px-4 py-1.5 bg-gray-100 text-gray-400 rounded-lg text-xs font-bold uppercase tracking-widest border border-gray-200">Setelah Event Selesai</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Materials Download Card --}}
            @if($materials && $materials->count() > 0)
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
                <div class="px-8 py-8 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-heading font-bold text-gray-800">Materi Sesi Kegiatan</h3>
                        <p class="text-sm text-gray-500">Unduh file presentasi dan dokumen materi pelatihan.</p>
                    </div>
                </div>
                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    <th class="pb-3 w-16">Sesi</th>
                                    <th class="pb-3">Judul Sesi / Pemateri</th>
                                    <th class="pb-3 text-center w-24">Kehadiran</th>
                                    <th class="pb-3 text-right w-40">Materi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($materials as $material)
                                    @php
                                        $isAttended = in_array($material->id, $attendedSessionIds);
                                    @endphp
                                    <tr class="group hover:bg-gray-50/50 transition-colors">
                                        <td class="py-4 font-heading font-extrabold text-gray-400">
                                            {{ str_pad($material->urutan, 2, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="py-4">
                                            <div class="font-bold text-gray-800 text-sm leading-snug group-hover:text-primary transition-colors">
                                                {{ $material->nama_sesi }}
                                            </div>
                                            @if($material->pemateri)
                                                <div class="text-xs text-gray-400 mt-0.5 font-medium flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                    {{ $material->pemateri }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-4 text-center">
                                            @if($isAttended)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-600 border border-green-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                    Hadir
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-50 text-gray-400 border border-gray-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                                                    Belum
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 text-right">
                                            @if($material->file_materi)
                                                <a href="{{ asset('storage/' . $material->file_materi) }}" target="_blank"
                                                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary/10 hover:bg-primary text-primary hover:text-white text-xs font-bold rounded-xl transition-all border border-primary/20 hover:border-transparent active:scale-95 shadow-sm">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                                    Unduh
                                                </a>
                                            @else
                                                <span class="text-xs text-gray-400 font-medium italic">Belum Diunggah</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Competency Radar Chart & Info --}}
            @if($chartData)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-8">
                    <h3 class="text-lg font-heading font-bold text-gray-800 mb-6">Analisis Kompetensi</h3>
                    <div class="h-64 relative">
                        <canvas id="radarChart"></canvas>
                    </div>
                </div>
                <div class="bg-primary-900 rounded-[2.5rem] shadow-xl p-8 text-white relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-accent mb-6 border border-white/20">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="text-xl font-bold mb-3">Tentang Penilaian</h4>
                        <p class="text-primary-100 text-sm leading-relaxed mb-6">
                            Sistem ini menggunakan metode <strong class="text-white">AHP (Analytic Hierarchy Process)</strong> dan <strong class="text-white">SAW (Simple Additive Weighting)</strong> untuk menghitung hasil evaluasi akhir secara objektif dan akurat.
                        </p>
                        <div class="space-y-3">
                            @foreach($chartData['labels'] as $index => $label)
                            <div class="flex items-center justify-between text-xs border-b border-white/10 pb-2">
                                <span class="text-primary-300 font-medium">{{ $label }}</span>
                                <span class="font-bold text-accent">{{ $chartData['data'][$index] }}%</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Result Celebration (If Graduated) --}}
            @if($activeEvent->status == 'selesai' && $scores && $scores->ranking)
                <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl relative overflow-hidden group">
                    {{-- Animated background glows --}}
                    <div class="absolute top-0 right-0 w-80 h-80 bg-primary/20 rounded-full blur-[100px] -mr-40 -mt-40 animate-pulse"></div>
                    <div class="absolute bottom-0 left-0 w-80 h-80 bg-accent/10 rounded-full blur-[100px] -ml-40 -mb-40"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                        <div class="flex-1 text-center md:text-left">
                            <p class="text-accent font-bold uppercase tracking-widest text-xs mb-3">PENGUMUMAN HASIL AKHIR</p>
                            <h3 class="text-4xl md:text-5xl font-heading font-extrabold mb-4 leading-tight">
                                Anda Meraih Predikat<br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent to-yellow-200">
                                    {{ $scores->predikat }}
                                </span>
                            </h3>
                            <p class="text-gray-400 text-lg mb-8 max-w-md">
                                Selamat! Berdasarkan pengolahan data sistem, Anda menempati peringkat <strong class="text-white text-xl">#{{ $scores->ranking }}</strong> dari seluruh peserta.
                            </p>
                            
                            @if(!str_contains($scores->status_kelulusan, 'Tidak Lulus') && !empty($scores->status_kelulusan))
                                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                                    @if($hasRtl)
                                        <a href="{{ route('peserta.sertifikat.download', $activeEvent) }}" target="_blank"
                                           class="inline-flex items-center gap-3 px-8 py-4 bg-accent text-gray-900 rounded-2xl font-bold hover:bg-accent-300 transition-all shadow-xl shadow-accent/20 active:scale-95">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            Download Sertifikat Resmi
                                        </a>
                                    @else
                                        <div class="space-y-4">
                                            <div class="p-4 bg-white/5 border border-white/10 text-primary-100 rounded-2xl text-xs max-w-md">
                                                <strong>Pemberitahuan:</strong> Anda wajib mengisi Rencana Tindak Lanjut (RTL) terlebih dahulu untuk mengunduh sertifikat resmi.
                                            </div>
                                            <a href="{{ route('peserta.rtl.index', $activeEvent) }}"
                                               class="inline-flex items-center gap-2.5 px-6 py-3 bg-amber-500 text-gray-900 rounded-2xl font-bold hover:bg-amber-400 transition-all shadow-lg active:scale-95 text-sm">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                                Isi Rencana Tindak Lanjut (RTL)
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-shrink-0 w-48 h-48 md:w-64 md:h-64 relative group">
                            <div class="absolute inset-0 bg-accent/20 rounded-full blur-3xl animate-pulse"></div>
                            <img src="{{ asset('images/arka/arka_selebrasi.png') }}" alt="Celebration" class="relative z-10 w-full h-full object-contain animate-float-slow">
                        </div>
                    </div>
                </div>
            @endif

        </div>
    @endif
    @else
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-64 h-64 mb-8">
                <img src="{{ asset('images/arka/arka_fokus.png') }}" alt="No Event" class="w-full h-full object-contain opacity-50 grayscale">
            </div>
            <h2 class="text-3xl font-heading font-bold text-gray-800 mb-2">Belum Ada Acara Aktif</h2>
            <p class="text-gray-500 max-w-md mx-auto">Saat ini Anda belum terdaftar dalam Baitul Arqam yang sedang aktif. Silakan hubungi admin MPKSDI jika terjadi kesalahan.</p>
        </div>
    @endif

</div>

@if($chartData)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('radarChart').getContext('2d');
    
    // Create gradient
    const gradient = ctx.createRadialGradient(
        ctx.canvas.width / 2, ctx.canvas.height / 2, 0,
        ctx.canvas.width / 2, ctx.canvas.height / 2, 200
    );
    gradient.addColorStop(0, 'rgba(26, 109, 155, 0.4)');
    gradient.addColorStop(1, 'rgba(26, 109, 155, 0.05)');

    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Skor Kompetensi',
                data: {!! json_encode($chartData['data']) !!},
                fill: true,
                backgroundColor: gradient,
                borderColor: '#1A6D9B',
                borderWidth: 3,
                pointBackgroundColor: '#1A6D9B',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                lineTension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    angleLines: { color: 'rgba(0,0,0,0.05)' },
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    pointLabels: {
                        color: '#64748B',
                        font: {
                            family: "'Poppins', sans-serif",
                            size: 10,
                            weight: '600'
                        }
                    },
                    suggestedMin: 0,
                    suggestedMax: 100,
                    ticks: { display: false }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { family: "'Poppins', sans-serif", size: 14 },
                    bodyFont: { family: "'Inter', sans-serif", size: 12 },
                    cornerRadius: 12,
                    displayColors: false
                }
            }
        }
    });
});
</script>
@endif
@endsection
