<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Scan Absensi — <?php echo e($sesi->nama_sesi); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('Logoums.png')); ?>">
    
    
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
                        primary: { DEFAULT: '#1A6D9B', 50: '#E8F4FA', 100: '#D1E9F5', 600: '#155C84' },
                        accent: { DEFAULT: '#D4A017', 50: '#FFF8E1' },
                        scan: { success: '#10B981', error: '#EF4444', warning: '#F59E0B', duplicate: '#F59E0B' },
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
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        
        .hero-mesh { 
            background-color: #06293F;
            background-image: 
                radial-gradient(at 0% 0%, hsla(201, 71%, 35%, 1) 0px, transparent 50%),
                radial-gradient(at 100% 0%, hsla(201, 71%, 25%, 1) 0px, transparent 50%);
        }

        @keyframes borderPulse {
            0%, 100% { border-color: #1A6D9B; box-shadow: 0 0 0 0 rgba(26, 109, 155, 0.2); }
            50% { border-color: #D4A017; box-shadow: 0 0 20px 4px rgba(212, 160, 23, 0.15); }
        }
        .scan-ready { animation: borderPulse 2s ease-in-out infinite; }
        
        @keyframes flashSuccess { 0% { background-color: rgba(16, 185, 129, 0.15); } 100% { background-color: transparent; } }
        @keyframes flashDuplicate { 0% { background-color: rgba(245, 158, 11, 0.15); } 100% { background-color: transparent; } }
        @keyframes flashError { 0% { background-color: rgba(239, 68, 68, 0.15); } 100% { background-color: transparent; } }
        
        .flash-success { animation: flashSuccess 0.6s ease-out; }
        .flash-duplicate { animation: flashDuplicate 0.6s ease-out; }
        .flash-error { animation: flashError 0.6s ease-out; }
        
        @keyframes slideUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        .slide-up { animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) both; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen font-body antialiased flex flex-col"
      x-data="scannerApp()"
      @keydown.escape.window="goBack()">

    
    <div x-show="flashClass" x-transition.opacity.duration.300ms
         :class="flashClass" class="fixed inset-0 z-50 pointer-events-none"></div>

    
    <div x-show="isOffline" x-transition x-cloak
         class="fixed top-0 left-0 right-0 z-50 bg-amber-500 text-white text-center py-2 text-xs font-bold shadow-md">
        ⚠ Offline — data akan tersimpan saat online kembali
    </div>

    
    <header class="hero-mesh text-white sticky top-0 z-30 shadow-lg border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <div class="flex items-center gap-4">
                <button @click="goBack()" class="p-2.5 bg-white/10 hover:bg-white/20 rounded-xl transition-all border border-white/10 group">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <div>
                    <span class="text-[10px] font-black text-blue-200/70 uppercase tracking-widest block"><?php echo e($event->nama_event); ?></span>
                    <h1 class="text-lg font-heading font-black text-white leading-tight">Presensi Sesi: <?php echo e($sesi->nama_sesi); ?></h1>
                </div>
            </div>

            
            <div class="bg-white/5 border border-white/10 p-3 rounded-2xl md:min-w-[280px] flex items-center justify-between gap-4">
                <div>
                    <span class="text-[10px] font-bold text-blue-200/80 uppercase tracking-wider block">Peserta Hadir</span>
                    <div class="flex items-baseline gap-1 mt-0.5">
                        <span class="text-2xl font-black text-accent" x-text="hadirCount"><?php echo e($hadirCount); ?></span>
                        <span class="text-sm text-blue-100/60">/ <?php echo e($totalPeserta); ?></span>
                    </div>
                </div>
                <div class="w-24 h-1.5 bg-white/10 rounded-full overflow-hidden shrink-0">
                    <div class="h-full bg-accent transition-all duration-500 ease-out rounded-full"
                         :style="'width: ' + (<?php echo e($totalPeserta); ?> > 0 ? (hadirCount / <?php echo e($totalPeserta); ?> * 100) : 0) + '%'"></div>
                </div>
            </div>

            
            <div class="flex items-center gap-3 self-end md:self-auto">
                <span class="hidden md:inline-block text-[10px] font-bold tracking-wider text-blue-200/60 bg-white/5 px-2.5 py-1.5 rounded-lg border border-white/5 uppercase">ESC untuk kembali</span>
                <button @click="showCloseModal = true"
                    class="px-4 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-200 hover:text-white rounded-xl text-sm font-bold transition-all border border-red-500/30">
                    Tutup Sesi
                </button>
            </div>
        </div>
    </header>

    
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            
            <div class="lg:col-span-2 space-y-6">
                
                
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 text-center relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary/5 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-accent/5 rounded-full blur-2xl pointer-events-none"></div>
                    
                    <div class="mb-6">
                        <div class="w-14 h-14 bg-primary/5 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-primary/10">
                            <svg class="w-7 h-7 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-heading font-black text-slate-800 mb-1">Arahkan Barcode Scanner</h2>
                        <p class="text-slate-400 text-sm font-medium">Klik pada input di bawah lalu gunakan Barcode Scanner Anda</p>
                    </div>

                    <form @submit.prevent="handleScan()" class="relative max-w-lg mx-auto">
                        <input type="text"
                            x-ref="scanInput"
                            x-model="qrCode"
                            :class="scanState === 'ready' ? 'scan-ready' : 'border-slate-200'"
                            class="w-full text-lg px-6 py-4 bg-slate-50 border-2 rounded-2xl text-slate-800 text-center outline-none placeholder:text-slate-400/70 font-semibold transition-all focus:bg-white"
                            placeholder="Menunggu scan barcode..."
                            autocomplete="off"
                            autofocus>
                    </form>

                    <div class="mt-4 flex items-center justify-center">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold"
                             :class="scanState === 'ready' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/50' : 'bg-amber-50 text-amber-700 border border-amber-200/50'">
                            <span class="w-2.5 h-2.5 rounded-full shrink-0 animate-pulse" :class="scanState === 'ready' ? 'bg-emerald-500' : 'bg-amber-500'"></span>
                            <span x-text="scanState === 'ready' ? 'Scanner Siap Mendeteksi' : 'Sedang Memproses...'"></span>
                        </div>
                    </div>
                </div>

                
                <div x-show="result" x-transition class="slide-up">
                    
                    
                    <template x-if="result && result.status === 'success'">
                        <div class="bg-emerald-50/60 rounded-[2rem] border-2 border-emerald-200 shadow-md p-8 text-center relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/5 rounded-bl-[4rem] pointer-events-none"></div>
                            
                            <div class="mb-4 relative inline-block">
                                <template x-if="result.foto">
                                    <img :src="result.foto" class="w-24 h-24 rounded-full mx-auto border-4 border-emerald-400 object-cover shadow-md">
                                </template>
                                <template x-if="!result.foto">
                                    <div class="w-24 h-24 rounded-full mx-auto border-4 border-emerald-400 bg-emerald-100 flex items-center justify-center shadow-md">
                                        <span class="text-2xl font-black text-emerald-700" x-text="result.nama ? result.nama.substring(0,2).toUpperCase() : 'PS'"></span>
                                    </div>
                                </template>
                                <div class="absolute -bottom-1 -right-1 bg-emerald-500 text-white rounded-full p-1.5 shadow-md border-2 border-white">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </div>
                            
                            <h3 class="text-xl font-heading font-black text-slate-800 mb-1" x-text="result.nama"></h3>
                            <p class="text-slate-500 text-sm font-semibold mb-4" x-text="result.unit_kerja || 'Instansi belum diisi'"></p>
                            
                            <div class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-100 text-emerald-800 text-sm font-black rounded-xl border border-emerald-200">
                                HADIR DI SESI ✓ (Jam <span x-text="result.waktu_scan"></span>)
                            </div>
                        </div>
                    </template>

                    
                    <template x-if="result && result.status === 'duplicate'">
                        <div class="bg-amber-50/60 rounded-[2rem] border-2 border-amber-200 shadow-md p-8 text-center relative overflow-hidden">
                            <div class="w-14 h-14 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4 border border-amber-200/50">
                                <svg class="w-7 h-7 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <h3 class="text-lg font-heading font-bold text-slate-800 mb-1" x-text="result.nama"></h3>
                            <p class="text-amber-800 text-sm font-semibold mb-4">Sudah Melakukan Absensi pada Jam <span x-text="result.waktu_scan"></span></p>
                            
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-100 text-amber-800 text-xs font-bold rounded-xl border border-amber-200/50">
                                ⚠ PRESENSI DUPLIKAT
                            </span>
                        </div>
                    </template>

                    
                    <template x-if="result && result.status === 'error'">
                        <div class="bg-red-50/60 rounded-[2rem] border-2 border-red-200 shadow-md p-8 text-center relative overflow-hidden">
                            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-200/50">
                                <svg class="w-7 h-7 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            </div>
                            <h3 class="text-lg font-heading font-black text-red-800 mb-1">Gagal Memproses Barcode</h3>
                            <p class="text-red-700/80 text-sm font-medium" x-text="result.message || 'QR Code tidak terdaftar pada event ini'"></p>
                        </div>
                    </template>
                </div>
            </div>

            
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden sticky top-28">
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <h3 class="text-sm font-bold text-slate-800 font-heading">Riwayat Absensi</h3>
                        <span class="text-[10px] font-bold text-slate-400 bg-slate-200/70 px-2 py-0.5 rounded-md" x-text="history.length + ' data terakhir'"></span>
                    </div>
                    <div class="divide-y divide-slate-100 max-h-[480px] overflow-y-auto">
                        <template x-if="history.length === 0">
                            <div class="px-6 py-12 text-center text-slate-400 text-sm font-medium">Belum ada aktivitas absensi</div>
                        </template>
                        <template x-for="(item, i) in history" :key="i">
                            <div class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition-colors">
                                <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center shrink-0 border border-slate-100 overflow-hidden">
                                    <template x-if="item.foto">
                                        <img :src="item.foto" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!item.foto">
                                        <span class="text-xs font-bold text-primary" x-text="item.nama ? item.nama.substring(0,2).toUpperCase() : 'PS'"></span>
                                    </template>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-800 truncate" x-text="item.nama"></p>
                                    <p class="text-xs text-slate-400 truncate" x-text="item.unit_kerja || 'Instansi belum diisi'"></p>
                                </div>
                                <span class="text-xs text-slate-500 font-semibold bg-slate-100 px-2 py-1 rounded" x-text="item.waktu_scan"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

        </div>
    </main>

    
    <div x-show="showCloseModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak>
        <div x-show="showCloseModal" x-transition class="bg-white rounded-3xl p-8 max-w-sm w-full mx-4 text-center border border-slate-100 shadow-2xl">
            <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-100">
                <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            </div>
            <h3 class="text-lg font-heading font-black text-slate-800 mb-2">Tutup Sesi Absensi?</h3>
            <p class="text-slate-500 text-sm mb-6">Sebanyak <strong class="text-primary" x-text="hadirCount"></strong> dari <?php echo e($totalPeserta); ?> peserta terdata hadir.</p>
            <div class="flex gap-3">
                <button @click="showCloseModal = false"
                    class="flex-1 px-4 py-2.5 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-colors">
                    Batal
                </button>
                <button @click="goBack()"
                    class="flex-1 px-4 py-2.5 bg-red-500 text-white text-sm font-bold rounded-xl hover:bg-red-600 transition-colors shadow-sm shadow-red-500/20">
                    Ya, Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
    function scannerApp() {
        return {
            qrCode: '',
            scanState: 'ready',
            result: null,
            hadirCount: <?php echo e($hadirCount); ?>,
            showCloseModal: false,
            isOffline: !navigator.onLine,
            offlineQueue: [],
            flashClass: '',
            history: <?php echo json_encode($recentScans, 15, 512) ?>,
            audioCtx: null,

            init() {
                this.$nextTick(() => this.$refs.scanInput?.focus());

                window.addEventListener('online', () => {
                    this.isOffline = false;
                    this.syncOfflineQueue();
                });
                window.addEventListener('offline', () => { this.isOffline = true; });

                document.addEventListener('click', (e) => {
                    if (!this.showCloseModal) {
                        this.$refs.scanInput?.focus();
                    }
                });

                // Polling data terbaru secara berkala setiap 5 detik
                setInterval(() => {
                    this.fetchRecentScans();
                }, 5000);
            },

            async fetchRecentScans() {
                if (this.isOffline || this.scanState === 'processing') return;

                try {
                    const res = await fetch('<?php echo e(route("admin.absensi.recent", [$event, $sesi])); ?>', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (res.ok) {
                        const data = await res.json();
                        this.hadirCount = data.hadir_count;
                        this.history = data.recent_scans;
                    }
                } catch (e) {
                    console.error('Gagal mengambil data terbaru:', e);
                }
            },

            async handleScan() {
                const code = this.qrCode.trim();
                if (!code) return;

                this.scanState = 'processing';
                this.qrCode = '';
                this.result = null;

                if (this.isOffline) {
                    this.offlineQueue.push({ qr_code: code, sesi_id: <?php echo e($sesi->id); ?>, timestamp: Date.now() });
                    this.result = { status: 'success', nama: 'Tersimpan (Offline)', waktu_scan: new Date().toLocaleTimeString('id-ID') };
                    this.playBeep('success');
                    this.showFlash('success');
                    this.resetAfterDelay();
                    return;
                }

                try {
                    const res = await fetch('<?php echo e(route("admin.absensi.process")); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ qr_code: code, sesi_id: <?php echo e($sesi->id); ?> }),
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
                    this.result = { status: 'error', message: 'Koneksi ke server gagal' };
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
                }, 4000);
            },

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
                        await fetch('<?php echo e(route("admin.absensi.process")); ?>', {
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
                window.location.href = '<?php echo e(route("admin.events.show", $event)); ?>';
            }
        };
    }
    </script>
</body>
</html>
<?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/admin/absensi/scan.blade.php ENDPATH**/ ?>