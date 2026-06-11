@extends('layouts.main')

@section('title', 'Rencana Tindak Lanjut (RTL) — ARQAM')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Rencana Tindak Lanjut (RTL)</h1>
            <p class="text-sm text-gray-500 mt-1">Susun rencana aksi nyata Anda pasca pelatihan Baitul Arqam sebagai syarat penerbitan sertifikat resmi.</p>
        </div>
        <div>
            <a href="{{ route('peserta.hasil') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-xl text-sm font-bold transition-all">
                ← Kembali
            </a>
        </div>
    </div>

    {{-- Countdown Timer if not submitted and deadline exists --}}
    @if(!$rtl && $event->rtl_deadline)
        <div class="bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-3xl p-6 shadow-md flex flex-col md:flex-row items-center justify-between gap-4"
             x-data="rtlCountdown('{{ $event->rtl_deadline->toIso8601String() }}')">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-white/20 rounded-2xl">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold">Batas Waktu Pengumpulan RTL</h2>
                    <p class="text-xs text-white/90">Sertifikat tidak dapat diunduh jika melewati batas waktu ini.</p>
                </div>
            </div>
            <div class="flex items-center gap-3 text-center">
                <div class="bg-white/10 backdrop-blur-sm px-3.5 py-2 rounded-xl min-w-[60px]">
                    <span class="text-xl font-extrabold block leading-tight" x-text="days">00</span>
                    <span class="text-[9px] uppercase tracking-wider font-bold">Hari</span>
                </div>
                <div class="bg-white/10 backdrop-blur-sm px-3.5 py-2 rounded-xl min-w-[60px]">
                    <span class="text-xl font-extrabold block leading-tight" x-text="hours">00</span>
                    <span class="text-[9px] uppercase tracking-wider font-bold">Jam</span>
                </div>
                <div class="bg-white/10 backdrop-blur-sm px-3.5 py-2 rounded-xl min-w-[60px]">
                    <span class="text-xl font-extrabold block leading-tight" x-text="minutes">00</span>
                    <span class="text-[9px] uppercase tracking-wider font-bold">Menit</span>
                </div>
                <div class="bg-white/10 backdrop-blur-sm px-3.5 py-2 rounded-xl min-w-[60px]">
                    <span class="text-xl font-extrabold block leading-tight" x-text="seconds">00</span>
                    <span class="text-[9px] uppercase tracking-wider font-bold">Detik</span>
                </div>
            </div>
        </div>
    @endif

    @if($rtl)
        {{-- Read-Only View (RTL Submitted) --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-gray-50 pb-5">
                <div class="space-y-1">
                    <span class="px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 rounded-full">
                        RTL Telah Disubmit
                    </span>
                    <h2 class="text-xl font-bold text-gray-800 mt-2">{{ $rtl->judul_kegiatan }}</h2>
                    <p class="text-xs text-gray-400">Kategori: <strong class="text-primary font-bold">{{ $rtl->kategori_rtl }}</strong></p>
                </div>
                <div>
                    <a href="{{ route('peserta.sertifikat.download', $event) }}" target="_blank"
                       class="px-5 py-2.5 bg-gradient-to-r from-primary to-primary-700 hover:from-primary-600 hover:to-primary-800 text-white rounded-xl text-sm font-bold shadow-md transition-all active:scale-95 inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download Sertifikat
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($rtl->jawaban as $jw)
                    <div class="space-y-2">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $jw->soal?->pertanyaan }}</h3>
                        @if($jw->soal?->tipe === 'upload')
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 flex items-center justify-center">
                                <img src="{{ asset($jw->jawaban) }}" alt="Bukti Upload" class="max-h-60 rounded-xl object-contain shadow-sm border border-gray-200">
                            </div>
                        @else
                            <p class="text-sm text-gray-700 leading-relaxed bg-gray-55/40 p-4 rounded-2xl border border-gray-50/70 whitespace-pre-wrap">{{ $jw->jawaban }}</p>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Langkah-langkah Timeline --}}
            <div class="space-y-4 pt-4 border-t border-gray-100">
                <h3 class="text-sm font-bold text-gray-800">Alur & Langkah Pelaksanaan</h3>
                <div class="relative pl-6 border-l-2 border-primary-100 space-y-6">
                    @foreach($rtl->langkah_langkah as $step)
                        <div class="relative">
                            <span class="absolute -left-[31px] top-1 w-6 h-6 rounded-full bg-primary border-4 border-white text-white font-extrabold text-[10px] flex items-center justify-center">
                                {{ $step['step'] }}
                            </span>
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <p class="text-sm font-semibold text-gray-800">{{ $step['deskripsi'] }}</p>
                                <span class="px-2.5 py-1 text-[10px] font-bold text-primary bg-primary-50 rounded-full shrink-0">
                                    Target: {{ $step['target_tanggal'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        {{-- Stepper Wizard Form --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8" x-data="rtlWizard()">
            {{-- Stepper Progress Bar --}}
            <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-50">
                <template x-for="(s, index) in steps" :key="index">
                    <div class="flex items-center flex-1 last:flex-none">
                        <div class="flex flex-col items-center relative">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300"
                                 :class="step > index ? 'bg-primary text-white' : (step === index ? 'bg-primary-50 text-primary border-2 border-primary' : 'bg-gray-100 text-gray-400')">
                                <template x-if="step > index">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                </template>
                                <template x-if="step <= index">
                                    <span x-text="index + 1"></span>
                                </template>
                            </div>
                            <span class="text-[10px] font-semibold mt-2 absolute top-10 whitespace-nowrap text-gray-500" x-text="s.label"></span>
                        </div>
                        <div class="h-1 flex-1 mx-4 transition-all duration-300" 
                             :class="step > index ? 'bg-primary' : 'bg-gray-100'"
                             x-show="index < steps.length - 1"></div>
                    </div>
                </template>
            </div>

            {{-- Form Element --}}
            <form action="{{ route('peserta.rtl.submit', $event) }}" method="POST" id="rtlForm" enctype="multipart/form-data" class="space-y-6 pt-4">
                @csrf
                
                {{-- Step 0: Informasi Umum --}}
                <div x-show="step === 0" x-transition>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Judul Rencana Tindak Lanjut</label>
                            <input type="text" name="judul_kegiatan" required placeholder="Contoh: Optimalisasi Peran Ranting Aisyiyah Melalui Kajian Rutin"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm bg-gray-50/50">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Bidang / Kategori RTL</label>
                            <select name="kategori_rtl" required
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm bg-gray-50/50">
                                <option value="Ibadah & Keagamaan">Ibadah & Keagamaan</option>
                                <option value="Organisasi & Kepemimpinan">Organisasi & Kepemimpinan</option>
                                <option value="Sosial Kemasyarakatan">Sosial Kemasyarakatan</option>
                                <option value="Amal Usaha Muhammadiyah (AUM)">Amal Usaha Muhammadiyah (AUM)</option>
                                <option value="Kaderisasi & Dakwah">Kaderisasi & Dakwah</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Step 1: Pertanyaan RTL --}}
                <div x-show="step === 1" x-transition style="display: none;">
                    <div class="space-y-6">
                        @foreach($rtlSoal as $soal)
                            <div>
                                @if($soal->tipe === 'deskripsi')
                                    <div class="bg-gray-50 border border-gray-150 p-5 rounded-2xl text-sm text-gray-700 leading-relaxed">
                                        <div class="flex items-start gap-2.5">
                                            <div class="p-1.5 bg-primary/10 rounded-lg text-primary mt-0.5">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800 mb-1">Penjelasan Teknis</p>
                                                {!! nl2br(e($soal->pertanyaan)) !!}
                                            </div>
                                        </div>
                                    </div>
                                @elseif($soal->tipe === 'essay')
                                    <label class="block text-sm font-bold text-gray-700 mb-2">{{ $soal->pertanyaan }} <span class="text-red-500">*</span></label>
                                    <textarea name="answers[{{ $soal->id }}]" required rows="3" placeholder="Tuliskan jawaban Anda..."
                                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm bg-gray-50/50"></textarea>
                                @elseif($soal->tipe === 'upload')
                                    <label class="block text-sm font-bold text-gray-700 mb-1">{{ $soal->pertanyaan }} <span class="text-red-500">*</span></label>
                                    <p class="text-[11px] text-gray-400 mb-2.5">Maksimal ukuran file gambar adalah 5MB (Format: JPG, JPEG, PNG)</p>
                                    <input type="file" name="answers[{{ $soal->id }}]" required accept="image/*"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 file:cursor-pointer cursor-pointer border border-gray-200 rounded-xl p-2.5 bg-gray-50/50">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Step 2: Alur & Langkah Pelaksanaan --}}
                <div x-show="step === 2" x-transition style="display: none;">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <h3 class="text-sm font-bold text-gray-800">Langkah & Alur Kerja Pelaksanaan</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Definisikan langkah-langkah kerja yang berurutan untuk RTL Anda.</p>
                            </div>
                            <button type="button" @click="addStep()"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary-50 hover:bg-primary-100 text-primary text-xs font-bold rounded-xl transition-colors">
                                + Tambah Langkah
                            </button>
                        </div>

                        <div class="space-y-3">
                            <template x-for="(item, index) in stepsList" :key="index">
                                <div class="bg-gray-55/40 p-4 rounded-2xl border border-gray-100 space-y-3 relative group">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-primary" x-text="'Langkah #' + (index + 1)"></span>
                                        <button type="button" @click="removeStep(index)" x-show="stepsList.length > 1"
                                                class="text-red-500 hover:text-red-600 font-semibold text-xs">
                                            Hapus
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <div class="md:col-span-2">
                                            <input type="text" :name="'steps['+index+'][deskripsi]'" required placeholder="Deskripsi tindakan (Misal: Koordinasi dengan Ketua PCM)"
                                                   class="w-full px-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm bg-white">
                                        </div>
                                        <div>
                                            <input type="text" :name="'steps['+index+'][target_tanggal]'" required placeholder="Target Waktu (Misal: Minggu I Juli)"
                                                   class="w-full px-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm bg-white">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-between items-center pt-6 border-t border-gray-50">
                    <button type="button" @click="prevStep()" x-show="step > 0"
                            class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-bold transition-all">
                        Sebelumnya
                    </button>
                    <div x-show="step === 0"></div> {{-- Placeholder --}}
                    
                    <button type="button" @click="nextStep()" x-show="step < steps.length - 1"
                            class="px-5 py-2.5 bg-primary hover:bg-primary-600 text-white rounded-xl text-sm font-bold shadow-md transition-all active:scale-95">
                        Berikutnya
                    </button>

                    <button type="submit" x-show="step === steps.length - 1"
                            class="px-6 py-2.5 bg-gradient-to-r from-primary to-primary-700 hover:from-primary-600 hover:to-primary-800 text-white rounded-xl text-sm font-bold shadow-md transition-all active:scale-95 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Submit & Selesaikan RTL
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function rtlCountdown(deadlineString) {
        return {
            deadline: new Date(deadlineString).getTime(),
            days: '00',
            hours: '00',
            minutes: '00',
            seconds: '00',
            interval: null,
            init() {
                this.updateTime();
                this.interval = setInterval(() => {
                    this.updateTime();
                }, 1000);
            },
            updateTime() {
                const now = new Date().getTime();
                const distance = this.deadline - now;

                if (distance < 0) {
                    clearInterval(this.interval);
                    this.days = '00';
                    this.hours = '00';
                    this.minutes = '00';
                    this.seconds = '00';
                    return;
                }

                const d = Math.floor(distance / (1000 * 60 * 60 * 24));
                const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((distance % (1000 * 60)) / 1000);

                this.days = d.toString().padStart(2, '0');
                this.hours = h.toString().padStart(2, '0');
                this.minutes = m.toString().padStart(2, '0');
                this.seconds = s.toString().padStart(2, '0');
            }
        }
    }

    function rtlWizard() {
        return {
            step: 0,
            steps: [
                { label: 'Informasi Kegiatan' },
                { label: 'Pertanyaan RTL' },
                { label: 'Langkah Kerja' }
            ],
            stepsList: [
                { deskripsi: '', target_tanggal: '' }
            ],
            addStep() {
                this.stepsList.push({ deskripsi: '', target_tanggal: '' });
            },
            removeStep(index) {
                if (this.stepsList.length > 1) {
                    this.stepsList.splice(index, 1);
                }
            },
            nextStep() {
                // Perform quick HTML validation check for the current visible step fields
                const currentStepDiv = document.querySelector(`#rtlForm > div:nth-of-type(${this.step + 1})`);
                const inputs = currentStepDiv.querySelectorAll('input[required], textarea[required], select[required]');
                
                let allValid = true;
                inputs.forEach(input => {
                    if (!input.reportValidity()) {
                        allValid = false;
                    }
                });

                if (allValid) {
                    this.step++;
                }
            },
            prevStep() {
                if (this.step > 0) {
                    this.step--;
                }
            }
        }
    }
</script>
@endpush
