<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scan Absensi — {{ $sesi->nama_sesi }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logo-mpksdi-1.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: { bg: '#0D1117', card: '#161B22', border: '#30363D', text: '#C9D1D9', muted: '#8B949E' },
                        scan: { success: '#39D353', error: '#FF4444', warning: '#F0883E', duplicate: '#D29922' },
                    },
                    fontFamily: {
                        heading: ['Poppins', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        @keyframes borderPulse {
            0%, 100% { border-color: #39D353; box-shadow: 0 0 0 0 rgba(57, 211, 83, 0.2); }
            50% { border-color: #2ea043; box-shadow: 0 0 20px 4px rgba(57, 211, 83, 0.15); }
        }
        .scan-ready { animation: borderPulse 2s ease-in-out infinite; }
        @keyframes flashSuccess { 0% { background-color: rgba(57, 211, 83, 0.15); } 100% { background-color: transparent; } }
        @keyframes flashDuplicate { 0% { background-color: rgba(210, 153, 34, 0.15); } 100% { background-color: transparent; } }
        @keyframes flashError { 0% { background-color: rgba(255, 68, 68, 0.15); } 100% { background-color: transparent; } }
        .flash-success { animation: flashSuccess 0.6s ease-out; }
        .flash-duplicate { animation: flashDuplicate 0.6s ease-out; }
        .flash-error { animation: flashError 0.6s ease-out; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .slide-up { animation: slideUp 0.3s ease-out; }
    </style>
</head>
<body class="bg-dark-bg min-h-screen text-dark-text font-body"
      x-data="scannerApp()"
      @keydown.escape.window="goBack()">

    {{-- Flash overlay --}}
    <div x-show="flashClass" x-transition.opacity.duration.300ms
         :class="flashClass" class="fixed inset-0 z-50 pointer-events-none"></div>

    {{-- Offline Banner --}}
    <div x-show="isOffline" x-transition
         class="fixed top-0 left-0 right-0 z-40 bg-scan-warning/90 text-dark-bg text-center py-2 text-sm font-semibold">
        ⚠ Offline — data akan tersimpan saat online kembali
    </div>

    {{-- HEADER (Sticky) --}}
    <header class="sticky top-0 z-30 bg-dark-card/95 backdrop-blur-sm border-b border-dark-border">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            {{-- Left: Event + Session --}}
            <div>
                <h1 class="text-lg font-heading font-bold text-white">{{ $event->nama_event }}</h1>
                <p class="text-sm text-dark-muted mt-0.5">Sesi: {{ $sesi->nama_sesi }}</p>
            </div>

            {{-- Center: Counter --}}
            <div class="text-center">
                <div class="flex items-baseline justify-center gap-2">
                    <span class="text-4xl font-heading font-extrabold text-scan-success" x-text="hadirCount">{{ $hadirCount }}</span>
                    <span class="text-xl text-dark-muted font-medium">/ {{ $totalPeserta }}</span>
                    <span class="text-sm text-dark-muted ml-1">peserta hadir</span>
                </div>
            </div>

            {{-- Right: Close button --}}
            <div class="flex items-center gap-3">
                <span class="text-xs text-dark-muted bg-dark-bg px-2 py-1 rounded-lg border border-dark-border">ESC untuk kembali</span>
                <button @click="showCloseModal = true"
                    class="px-4 py-2 bg-scan-error/10 hover:bg-scan-error/20 text-scan-error rounded-xl text-sm font-semibold transition-all border border-scan-error/20">
                    Tutup Sesi
                </button>
            </div>
        </div>

        {{-- Progress bar --}}
        <div class="h-1 bg-dark-bg">
            <div class="h-full bg-scan-success transition-all duration-500 ease-out"
                 :style="'width: ' + ({{ $totalPeserta }} > 0 ? '(hadirCount / {{ $totalPeserta }} * 100)' : '0') + '%'"></div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-8 space-y-8">

        {{-- SCAN AREA --}}
        <div class="bg-dark-card rounded-2xl border border-dark-border p-8 text-center">
            <div class="mb-6">
                <div class="w-16 h-16 bg-scan-success/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-scan-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-heading font-bold text-white mb-1">Scan QR Code Peserta</h2>
                <p class="text-dark-muted text-sm">Arahkan barcode scanner ke QR code peserta</p>
            </div>

            <form @submit.prevent="handleScan()">
                <input type="text"
                    x-ref="scanInput"
                    x-model="qrCode"
                    :class="scanState === 'ready' ? 'scan-ready' : ''"
                    class="w-full max-w-lg mx-auto block text-lg px-6 py-4 bg-dark-bg border-2 border-scan-success/40 rounded-2xl text-white text-center outline-none placeholder:text-dark-muted/50 transition-all focus:border-scan-success"
                    placeholder="Menunggu scan..."
                    autocomplete="off"
                    autofocus>
            </form>

            <p class="text-xs text-dark-muted mt-4">
                <span class="inline-flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full animate-pulse" :class="scanState === 'ready' ? 'bg-scan-success' : 'bg-scan-warning'"></span>
                    <span x-text="scanState === 'ready' ? 'Scanner siap' : 'Memproses...'"></span>
                </span>
            </p>
        </div>

        {{-- RESULT AREA --}}
        <div x-show="result" x-transition class="slide-up">
            {{-- Success --}}
            <template x-if="result && result.status === 'success'">
                <div class="bg-dark-card rounded-2xl border border-scan-success/30 p-8 text-center">
                    <div class="mb-4">
                        <template x-if="result.foto">
                            <img :src="result.foto" class="w-28 h-28 rounded-full mx-auto border-4 border-scan-success object-cover">
                        </template>
                        <template x-if="!result.foto">
                            <div class="w-28 h-28 rounded-full mx-auto border-4 border-scan-success bg-scan-success/10 flex items-center justify-center">
                                <span class="text-3xl font-bold text-scan-success" x-text="result.nama ? result.nama.substring(0,2).toUpperCase() : ''"></span>
                            </div>
                        </template>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-white mb-1" x-text="result.nama"></h3>
                    <p class="text-dark-muted text-sm mb-3" x-text="result.unit_kerja || '-'"></p>
                    <p class="text-scan-success/70 text-xs mb-4">Waktu scan: <span x-text="result.waktu_scan"></span></p>
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-scan-success/10 text-scan-success text-sm font-bold rounded-full border border-scan-success/20">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        HADIR ✓
                    </span>
                </div>
            </template>

            {{-- Duplicate --}}
            <template x-if="result && result.status === 'duplicate'">
                <div class="bg-dark-card rounded-2xl border border-scan-duplicate/30 p-8 text-center">
                    <div class="w-16 h-16 bg-scan-duplicate/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-scan-duplicate" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <h3 class="text-lg font-heading font-bold text-white mb-1" x-text="result.nama"></h3>
                    <p class="text-scan-duplicate text-sm mb-4">Sudah absen pada <span x-text="result.waktu_scan"></span></p>
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-scan-duplicate/10 text-scan-duplicate text-sm font-bold rounded-full border border-scan-duplicate/20">
                        ⚠ DUPLIKAT
                    </span>
                </div>
            </template>

            {{-- Error --}}
            <template x-if="result && result.status === 'error'">
                <div class="bg-dark-card rounded-2xl border border-scan-error/30 p-8 text-center">
                    <div class="w-16 h-16 bg-scan-error/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-scan-error" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <p class="text-scan-error text-lg font-semibold" x-text="result.message || 'QR Code tidak dikenali'"></p>
                </div>
            </template>
        </div>

        {{-- SCAN HISTORY --}}
        <div class="bg-dark-card rounded-2xl border border-dark-border overflow-hidden">
            <div class="px-6 py-4 border-b border-dark-border flex items-center justify-between">
                <h3 class="text-sm font-semibold text-white font-heading">Riwayat Scan Terbaru</h3>
                <span class="text-xs text-dark-muted" x-text="history.length + ' scan terakhir'"></span>
            </div>
            <div class="divide-y divide-dark-border">
                <template x-if="history.length === 0">
                    <div class="px-6 py-8 text-center text-dark-muted text-sm">Belum ada scan</div>
                </template>
                <template x-for="(item, i) in history" :key="i">
                    <div class="flex items-center gap-4 px-6 py-3 hover:bg-dark-bg/50 transition-colors">
                        <div class="w-8 h-8 rounded-full bg-scan-success/10 flex items-center justify-center flex-shrink-0">
                            <template x-if="item.foto">
                                <img :src="item.foto" class="w-8 h-8 rounded-full object-cover">
                            </template>
                            <template x-if="!item.foto">
                                <span class="text-xs font-bold text-scan-success" x-text="item.nama ? item.nama.substring(0,2).toUpperCase() : ''"></span>
                            </template>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate" x-text="item.nama"></p>
                            <p class="text-xs text-dark-muted" x-text="item.unit_kerja || '-'"></p>
                        </div>
                        <span class="text-xs text-dark-muted font-mono" x-text="item.waktu_scan"></span>
                    </div>
                </template>
            </div>
        </div>

    </main>

    {{-- Close Session Modal --}}
    <div x-show="showCloseModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm">
        <div x-show="showCloseModal" x-transition class="bg-dark-card rounded-2xl border border-dark-border p-8 max-w-sm w-full mx-4 text-center">
            <div class="w-14 h-14 bg-scan-error/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-scan-error" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            </div>
            <h3 class="text-lg font-heading font-bold text-white mb-2">Tutup Sesi Absensi?</h3>
            <p class="text-dark-muted text-sm mb-6">Sudah <strong class="text-scan-success" x-text="hadirCount"></strong> / {{ $totalPeserta }} peserta yang hadir.</p>
            <div class="flex gap-3">
                <button @click="showCloseModal = false"
                    class="flex-1 px-4 py-2.5 bg-dark-bg border border-dark-border rounded-xl text-dark-text text-sm font-medium hover:bg-dark-border/50 transition-colors">
                    Batal
                </button>
                <button @click="goBack()"
                    class="flex-1 px-4 py-2.5 bg-scan-error/20 border border-scan-error/30 rounded-xl text-scan-error text-sm font-semibold hover:bg-scan-error/30 transition-colors">
                    Tutup Sesi
                </button>
            </div>
        </div>
    </div>

    <script>
    function scannerApp() {
        return {
            // State
            qrCode: '',
            scanState: 'ready',
            result: null,
            hadirCount: {{ $hadirCount }},
            showCloseModal: false,
            isOffline: !navigator.onLine,
            offlineQueue: [],
            flashClass: '',

            // History (last 10)
            history: @json($recentScans),

            // Audio context
            audioCtx: null,

            init() {
                // Focus input
                this.$nextTick(() => this.$refs.scanInput?.focus());

                // Online/offline detection
                window.addEventListener('online', () => {
                    this.isOffline = false;
                    this.syncOfflineQueue();
                });
                window.addEventListener('offline', () => { this.isOffline = true; });

                // Keep focus on input
                document.addEventListener('click', (e) => {
                    if (!this.showCloseModal) {
                        this.$refs.scanInput?.focus();
                    }
                });
            },

            async handleScan() {
                const code = this.qrCode.trim();
                if (!code) return;

                this.scanState = 'processing';
                this.qrCode = '';
                this.result = null;

                if (this.isOffline) {
                    this.offlineQueue.push({ qr_code: code, sesi_id: {{ $sesi->id }}, timestamp: Date.now() });
                    this.result = { status: 'success', nama: 'Tersimpan (Offline)', waktu_scan: new Date().toLocaleTimeString('id-ID') };
                    this.playBeep('success');
                    this.showFlash('success');
                    this.resetAfterDelay();
                    return;
                }

                try {
                    const res = await fetch('{{ route("admin.absensi.process") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ qr_code: code, sesi_id: {{ $sesi->id }} }),
                    });

                    const data = await res.json();
                    this.result = data;

                    if (data.status === 'success') {
                        this.hadirCount = data.hadir_count;
                        this.history.unshift({
                            nama: data.nama,
                            unit_kerja: data.unit_kerja,
                            foto: data.foto,
                            waktu_scan: data.waktu_scan,
                        });
                        if (this.history.length > 10) this.history.pop();
                        this.playBeep('success');
                        this.showFlash('success');
                    } else if (data.status === 'duplicate') {
                        this.playBeep('duplicate');
                        this.showFlash('duplicate');
                    } else {
                        this.playBeep('error');
                        this.showFlash('error');
                    }
                } catch (err) {
                    this.result = { status: 'error', message: 'Koneksi gagal' };
                    this.playBeep('error');
                    this.showFlash('error');
                }

                this.resetAfterDelay();
            },

            showFlash(type) {
                this.flashClass = `flash-${type}`;
                setTimeout(() => { this.flashClass = ''; }, 600);
            },

            resetAfterDelay() {
                this.scanState = 'ready';
                this.$nextTick(() => this.$refs.scanInput?.focus());

                setTimeout(() => {
                    this.result = null;
                }, 3000);
            },

            // Web Audio API beeps
            playBeep(type) {
                try {
                    if (!this.audioCtx) this.audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                    const ctx = this.audioCtx;
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.connect(gain);
                    gain.connect(ctx.destination);

                    if (type === 'success') {
                        osc.frequency.value = 880;
                        osc.type = 'sine';
                        gain.gain.value = 0.3;
                        osc.start();
                        osc.stop(ctx.currentTime + 0.12);
                    } else if (type === 'duplicate') {
                        osc.frequency.value = 440;
                        osc.type = 'triangle';
                        gain.gain.value = 0.25;
                        osc.start();
                        osc.stop(ctx.currentTime + 0.25);
                    } else {
                        osc.frequency.value = 220;
                        osc.type = 'sawtooth';
                        gain.gain.value = 0.2;
                        osc.start();
                        osc.stop(ctx.currentTime + 0.35);
                    }
                } catch (e) {}
            },

            async syncOfflineQueue() {
                if (this.offlineQueue.length === 0) return;
                const queue = [...this.offlineQueue];
                this.offlineQueue = [];

                for (const item of queue) {
                    try {
                        await fetch('{{ route("admin.absensi.process") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(item),
                        });
                    } catch (e) {
                        this.offlineQueue.push(item);
                    }
                }
            },

            goBack() {
                window.location.href = '{{ route("admin.events.show", $event) }}';
            }
        };
    }
    </script>
</body>
</html>
