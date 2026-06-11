<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ucfirst($tipe) }} — {{ $event->nama_event }}</title>
    <link rel="icon" type="image/png" href="{{ asset('Logoums.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&family=Amiri&family=Scheherazade+New&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#1A6D9B', 50: '#E8F4FA', 100: '#D1E9F5', 600: '#155C84' },
                        accent: { DEFAULT: '#D4A017', 50: '#FFF8E1' },
                    },
                    fontFamily: {
                        heading: ['Poppins', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                        arabic: ['Amiri', 'Scheherazade New', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        @keyframes pulse-red { 0%, 100% { color: #ef4444; } 50% { color: #fca5a5; } }
        .timer-critical { animation: pulse-red 1s ease-in-out infinite; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen" x-data="tesApp()">

    {{-- Top Bar --}}
    <header class="sticky top-0 z-30 bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h1 class="text-sm font-heading font-bold text-gray-800">{{ ucfirst($tipe) }}</h1>
                <span class="text-xs text-gray-400">{{ $event->nama_event }}</span>
            </div>
            <div class="flex items-center gap-4">
                {{-- Timer --}}
                <div :class="remainingSeconds < 300 ? 'timer-critical' : 'text-gray-700'"
                     class="text-lg font-mono font-bold flex items-center gap-1.5">
                    <svg class="w-5 h-5" :class="remainingSeconds < 300 ? 'text-red-400' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span x-text="formatTime(remainingSeconds)"></span>
                </div>
            </div>
        </div>
        {{-- Progress bar --}}
        <div class="h-1 bg-gray-100">
            <div class="h-full bg-primary transition-all duration-300" :style="'width:' + answeredPercent + '%'"></div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 py-6 flex gap-6">

        {{-- LEFT: Navigation Grid --}}
        <aside class="w-64 flex-shrink-0 hidden lg:block">
            <div class="sticky top-20 bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-800">Navigasi Soal</h3>
                    <span class="text-xs text-gray-400" x-text="answeredCount + '/' + questions.length"></span>
                </div>
                <div class="grid grid-cols-5 gap-2">
                    <template x-for="(q, i) in questions" :key="q.id">
                        <button @click="currentIndex = i"
                            :class="{
                                'bg-primary text-white shadow-sm': currentIndex === i,
                                'bg-green-100 text-green-700 border-green-200': currentIndex !== i && answers[q.id],
                                'bg-gray-50 text-gray-500 border-gray-200': currentIndex !== i && !answers[q.id]
                            }"
                            class="w-9 h-9 rounded-lg border text-xs font-bold transition-all hover:shadow-md"
                            x-text="i + 1"></button>
                    </template>
                </div>

                <div class="mt-5 pt-4 border-t border-gray-100 space-y-2">
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <span class="w-3 h-3 rounded bg-green-100 border border-green-200"></span> Sudah dijawab
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <span class="w-3 h-3 rounded bg-gray-50 border border-gray-200"></span> Belum dijawab
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <span class="w-3 h-3 rounded bg-primary"></span> Soal aktif
                    </div>
                </div>
            </div>
        </aside>

        {{-- RIGHT: Question Display --}}
        <main class="flex-1 min-w-0">
            {{-- Question Card --}}
            <template x-if="currentQuestion">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    {{-- Question Header --}}
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                        <p class="text-sm font-semibold text-gray-600">
                            Soal <span class="text-primary" x-text="currentIndex + 1"></span>
                            dari <span x-text="questions.length"></span>
                        </p>
                        <span x-show="answers[currentQuestion.id]"
                              class="text-xs px-2 py-1 bg-green-50 text-green-600 rounded-lg border border-green-100 font-medium">
                            ✓ Dijawab
                        </span>
                    </div>

                    {{-- Question Text --}}
                    <div class="px-6 py-6">
                        <p class="text-gray-800 leading-relaxed mb-8"
                           style="font-family: 'Amiri', 'Scheherazade New', serif; font-size: 18px; line-height: 2.2;"
                           x-text="currentQuestion.teks_soal"></p>

                        {{-- Answer Options --}}
                        <div class="space-y-3">
                            <template x-for="opt in currentQuestion.pilihan_jawaban" :key="opt.id">
                                <button @click="selectAnswer(currentQuestion.id, opt.id)"
                                    :class="answers[currentQuestion.id] === opt.id
                                        ? 'border-primary bg-primary/5 shadow-sm ring-2 ring-primary/20'
                                        : 'border-gray-200 bg-white hover:border-primary/30 hover:shadow-sm'"
                                    class="w-full flex items-center gap-4 p-4 rounded-2xl border-2 transition-all text-left group">
                                    <span :class="answers[currentQuestion.id] === opt.id
                                            ? 'bg-primary text-white'
                                            : 'bg-gray-100 text-gray-500 group-hover:bg-primary/10 group-hover:text-primary'"
                                        class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold flex-shrink-0 transition-colors"
                                        x-text="opt.huruf"></span>
                                    <span class="text-sm text-gray-700 leading-relaxed"
                                          style="font-family: 'Amiri', 'Scheherazade New', serif; font-size: 15px; line-height: 1.8;"
                                          x-text="opt.teks_pilihan"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- Navigation --}}
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex items-center justify-between">
                        <button @click="prevQuestion()" :disabled="currentIndex === 0"
                            class="flex items-center gap-2 px-5 py-2.5 text-sm font-medium rounded-xl transition-colors disabled:opacity-30 disabled:cursor-not-allowed bg-white border border-gray-200 text-gray-700 hover:bg-gray-50">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            Sebelumnya
                        </button>

                        <template x-if="currentIndex < questions.length - 1">
                            <button @click="nextQuestion()"
                                class="flex items-center gap-2 px-5 py-2.5 text-sm font-medium rounded-xl bg-primary text-white hover:bg-primary/90 transition-colors shadow-sm">
                                Selanjutnya
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </template>

                        <template x-if="currentIndex === questions.length - 1">
                            <button @click="showReview = true"
                                class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold rounded-xl bg-accent text-white hover:bg-accent/90 transition-colors shadow-sm">
                                Review & Kumpulkan
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </button>
                        </template>
                    </div>
                </div>
            </template>

            {{-- Mobile Navigation Grid --}}
            <div class="mt-4 lg:hidden bg-white rounded-2xl border border-gray-200 shadow-sm p-4">
                <p class="text-sm font-semibold text-gray-800 mb-3">Navigasi Soal</p>
                <div class="grid grid-cols-8 gap-2">
                    <template x-for="(q, i) in questions" :key="'mob_'+q.id">
                        <button @click="currentIndex = i"
                            :class="{
                                'bg-primary text-white': currentIndex === i,
                                'bg-green-100 text-green-700': currentIndex !== i && answers[q.id],
                                'bg-gray-50 text-gray-500': currentIndex !== i && !answers[q.id]
                            }"
                            class="w-full h-8 rounded-lg text-xs font-bold transition-all"
                            x-text="i + 1"></button>
                    </template>
                </div>
            </div>
        </main>
    </div>

    {{-- Review Modal --}}
    <div x-show="showReview" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm overflow-y-auto py-8">
        <div x-show="showReview" x-transition class="bg-white rounded-2xl shadow-2xl border border-gray-100 w-full max-w-xl mx-4">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-heading font-bold text-gray-800">Review Jawaban</h3>
            </div>
            <div class="px-6 py-4 max-h-96 overflow-y-auto">
                <template x-if="unansweredCount > 0">
                    <div class="bg-red-50 text-red-700 text-sm p-3 rounded-xl mb-4 border border-red-100">
                        ⚠ Ada <strong x-text="unansweredCount"></strong> soal yang belum dijawab!
                    </div>
                </template>

                <div class="space-y-1.5">
                    <template x-for="(q, i) in questions" :key="'rev_'+q.id">
                        <div @click="showReview = false; currentIndex = i"
                             :class="answers[q.id] ? 'bg-green-50 border-green-100' : 'bg-red-50 border-red-100'"
                             class="flex items-center justify-between px-4 py-2.5 rounded-xl border cursor-pointer hover:shadow-sm transition-all">
                            <span class="text-sm font-medium text-gray-700">Soal <span x-text="i+1"></span></span>
                            <template x-if="answers[q.id]">
                                <span class="text-xs text-green-600 font-semibold">
                                    ✓ <span x-text="getAnswerLetter(q)"></span>
                                </span>
                            </template>
                            <template x-if="!answers[q.id]">
                                <span class="text-xs text-red-500 font-semibold">Belum dijawab</span>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 flex gap-3">
                <button @click="showReview = false"
                    class="flex-1 px-4 py-2.5 text-sm font-medium bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                    Kembali ke Soal
                </button>
                <button @click="showSubmitConfirm = true"
                    class="flex-1 px-4 py-2.5 text-sm font-bold bg-primary text-white rounded-xl hover:bg-primary/90 transition-colors shadow-sm">
                    Kumpulkan Jawaban
                </button>
            </div>
        </div>
    </div>

    {{-- Submit Confirmation Modal --}}
    <div x-show="showSubmitConfirm" x-transition.opacity class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div x-show="showSubmitConfirm" x-transition class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4 text-center">
            <div class="w-14 h-14 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-lg font-heading font-bold text-gray-800 mb-2">Kumpulkan Jawaban?</h3>
            <p class="text-gray-500 text-sm mb-6">Tindakan ini tidak dapat dibatalkan. Jawaban Anda akan langsung dinilai.</p>
            <div class="flex gap-3">
                <button @click="showSubmitConfirm = false"
                    class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm rounded-xl hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button @click="submitAnswers()" :disabled="isSubmitting"
                    class="flex-1 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors disabled:opacity-60">
                    <span x-show="!isSubmitting">Ya, Kumpulkan</span>
                    <span x-show="isSubmitting">Mengirim...</span>
                </button>
            </div>
        </div>
    </div>

    <script>
    function tesApp() {
        const storageKey = 'arqam_tes_{{ $event->id }}_{{ $eventSesi->id }}_{{ $tipe }}';

        return {
            questions: @json($questions),
            currentIndex: 0,
            answers: {},
            showReview: false,
            showSubmitConfirm: false,
            isSubmitting: false,
            remainingSeconds: {{ $remainingSeconds }},
            timerInterval: null,
            tabViolations: 0,
            maxViolations: 3,

            get currentQuestion() { return this.questions[this.currentIndex] || null; },
            get answeredCount() { return Object.keys(this.answers).length; },
            get unansweredCount() { return this.questions.length - this.answeredCount; },
            get answeredPercent() { return this.questions.length ? Math.round((this.answeredCount / this.questions.length) * 100) : 0; },

            init() {
                // Restore from localStorage
                const saved = localStorage.getItem(storageKey);
                if (saved) {
                    try { this.answers = JSON.parse(saved); } catch(e) {}
                }

                // Anti Copy-Paste & Right Click
                document.addEventListener('contextmenu', e => e.preventDefault());
                document.addEventListener('copy', e => e.preventDefault());
                document.addEventListener('cut', e => e.preventDefault());
                document.addEventListener('paste', e => e.preventDefault());
                
                // Anti keyboard shortcut for print, copy, inspect
                document.addEventListener('keydown', e => {
                    if (
                        e.ctrlKey && (e.key === 'c' || e.key === 'v' || e.key === 'u' || e.key === 'p' || e.key === 's') || 
                        e.key === 'F12'
                    ) {
                        e.preventDefault();
                    }
                });

                // Focus/Blur Warning
                window.addEventListener('blur', () => {
                    if (this.isSubmitting) return;
                    this.tabViolations++;
                    if (this.tabViolations >= this.maxViolations) {
                        alert('Anda telah melanggar batas maksimal meninggalkan halaman ujian! Jawaban Anda akan otomatis dikumpulkan.');
                        this.submitAnswers();
                    } else {
                        alert(`PERINGATAN: Anda meninggalkan halaman ujian! (${this.tabViolations}/${this.maxViolations} pelanggaran). Jika melanggar lagi, ujian Anda akan otomatis dikumpulkan.`);
                    }
                });

                // Target timestamp is current time + remainingSeconds (system clock drift proof)
                const targetTime = Date.now() + (this.remainingSeconds * 1000);

                // Update remaining seconds immediately
                this.remainingSeconds = Math.max(0, Math.round((targetTime - Date.now()) / 1000));

                if (this.remainingSeconds <= 0) {
                    this.submitAnswers(true);
                    return;
                }

                // Start countdown
                this.timerInterval = setInterval(() => {
                    this.remainingSeconds = Math.max(0, Math.round((targetTime - Date.now()) / 1000));
                    if (this.remainingSeconds <= 0) {
                        clearInterval(this.timerInterval);
                        this.submitAnswers(true);
                    }
                }, 1000);
            },

            selectAnswer(soalId, pilihanId) {
                this.answers[soalId] = pilihanId;
                localStorage.setItem(storageKey, JSON.stringify(this.answers));
            },

            prevQuestion() { if (this.currentIndex > 0) this.currentIndex--; },
            nextQuestion() { if (this.currentIndex < this.questions.length - 1) this.currentIndex++; },

            getAnswerLetter(q) {
                const pId = this.answers[q.id];
                const opt = q.pilihan_jawaban.find(o => o.id === pId);
                return opt ? opt.huruf : '-';
            },

            formatTime(s) {
                const m = Math.floor(s / 60);
                const sec = s % 60;
                return String(m).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
            },

            async submitAnswers(isAutoSubmit = false) {
                if (this.isSubmitting) return;
                this.isSubmitting = true;

                const payload = Object.entries(this.answers).map(([soalId, pilihanId]) => ({
                    soal_id: parseInt(soalId),
                    pilihan_id: parseInt(pilihanId),
                }));

                const executeSubmit = async () => {
                    try {
                        const res = await fetch('{{ route("peserta.tes.submit", [$event, $eventSesi, $tipe]) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ answers: payload }),
                        });
                        const data = await res.json();

                        if (data.status === 'success') {
                            localStorage.removeItem(storageKey);
                            localStorage.removeItem(storageKey + '_target');
                            clearInterval(this.timerInterval);
                            window.location.href = '{{ route("peserta.tes.index") }}';
                        }
                    } catch (e) {
                        alert('Gagal mengirim jawaban. Silakan coba lagi.');
                        this.isSubmitting = false;
                    }
                };

                if (isAutoSubmit) {
                    // Beri jeda acak 0 - 5 detik (jitter) untuk memecah lonjakan request bersamaan
                    const jitterDelay = Math.random() * 5000;
                    setTimeout(executeSubmit, jitterDelay);
                } else {
                    await executeSubmit();
                }
            },
        };
    }
    </script>
</body>
</html>
