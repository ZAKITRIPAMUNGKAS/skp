
<?php
    $eventSesis = $event->sesi()->orderBy('urutan')->get();
    $firstSesi = $eventSesis->first();

    $pretestSoal = $firstSesi ? \App\Models\Soal::where('event_id', $event->id)->where('event_sesi_id', $firstSesi->id)->where('tipe', 'pretest')->with('pilihanJawaban')->orderBy('urutan')->get() : collect();
    $posttestSoal = $firstSesi ? \App\Models\Soal::where('event_id', $event->id)->where('event_sesi_id', $firstSesi->id)->where('tipe', 'posttest')->with('pilihanJawaban')->orderBy('urutan')->get() : collect();
    $pretestSesi  = $firstSesi ? \App\Models\SesiTes::where('event_id', $event->id)->where('event_sesi_id', $firstSesi->id)->where('tipe', 'pretest')->first() : null;
    $posttestSesi = $firstSesi ? \App\Models\SesiTes::where('event_id', $event->id)->where('event_sesi_id', $firstSesi->id)->where('tipe', 'posttest')->first() : null;

    $pretestRemainingSecs = $pretestSesi && $pretestSesi->status === 'aktif' && $pretestSesi->waktu_mulai ? max(0, ($pretestSesi->waktu_mulai->timestamp + ($pretestSesi->durasi_menit * 60)) - now()->timestamp) : 0;
    $posttestRemainingSecs = $posttestSesi && $posttestSesi->status === 'aktif' && $posttestSesi->waktu_mulai ? max(0, ($posttestSesi->waktu_mulai->timestamp + ($posttestSesi->durasi_menit * 60)) - now()->timestamp) : 0;
?>

<?php if($eventSesis->isEmpty()): ?>
    <div class="py-8">
        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Belum ada Sesi / Materi','description' => 'Silakan buat sesi kegiatan/materi terlebih dahulu di tab Sesi.','icon' => 'document']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Belum ada Sesi / Materi','description' => 'Silakan buat sesi kegiatan/materi terlebih dahulu di tab Sesi.','icon' => 'document']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
    </div>
<?php else: ?>
<div x-data="soalManager()" x-init="init()">

    
    <div class="mb-6 bg-white rounded-2xl border border-gray-100 p-5 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <span class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </span>
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Materi / Sesi Evaluasi</label>
                <select x-model="selectedSesiId" @change="loadMaterialData()"
                        class="px-3 py-1.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-800 bg-gray-50/50 cursor-pointer focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    <?php $__currentLoopData = $eventSesis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sesi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($sesi->id); ?>">Sesi <?php echo e($sesi->urutan); ?>: <?php echo e($sesi->nama_sesi); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
    </div>

    
    <div class="flex items-center justify-between mb-6">
        <div class="flex gap-1 bg-gray-100 rounded-xl p-1">
            <button @click="subTab = 'pretest'"
                :class="subTab === 'pretest' ? 'bg-white shadow-sm text-primary font-semibold' : 'text-gray-500 hover:text-gray-700'"
                class="px-5 py-2 text-sm rounded-lg transition-all">
                Pretest <span class="ml-1 text-xs" x-text="'(' + pretestSoal.length + ')'"></span>
            </button>
            <button @click="subTab = 'posttest'"
                :class="subTab === 'posttest' ? 'bg-white shadow-sm text-primary font-semibold' : 'text-gray-500 hover:text-gray-700'"
                class="px-5 py-2 text-sm rounded-lg transition-all">
                Posttest <span class="ml-1 text-xs" x-text="'(' + posttestSoal.length + ')'"></span>
            </button>
        </div>

        <div class="flex items-center gap-3">
            
            <button @click="showCopyForm = true"
                class="text-xs px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors border border-blue-200 font-medium font-heading">
                Salin Soal Event Lain
            </button>

            
            <button @click="duplicateToPosttest()" x-show="subTab === 'posttest' && pretestSoal.length > 0"
                class="text-xs px-3 py-1.5 bg-accent/10 text-accent rounded-lg hover:bg-accent/20 transition-colors border border-accent/20">
                Copy soal Pretest → Posttest
            </button>
            <button @click="showForm = true; editingSoal = null; resetForm()"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-white text-sm rounded-xl hover:bg-primary/90 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Soal
            </button>
        </div>
    </div>

    
    <div class="bg-gray-50 rounded-xl border border-gray-100 p-4 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div>
                    <p class="text-sm font-semibold text-gray-800">
                        Status <span x-text="subTab === 'pretest' ? 'Pretest' : 'Posttest'" class="capitalize"></span>
                    </p>
                    <p class="text-xs text-gray-500 mt-0.5"
                       x-text="currentSesiStatus === 'aktif' ? 'Sedang berlangsung' : currentSesiStatus === 'tutup' ? 'Sudah ditutup' : 'Belum dibuka'"></p>
                </div>
                <template x-if="currentSesiStatus === 'aktif'">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-600 text-xs font-semibold rounded-full border border-green-100">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        AKTIF
                    </span>
                </template>
                <template x-if="currentSesiStatus === 'tutup'">
                    <span class="px-3 py-1 bg-gray-100 text-gray-500 text-xs font-semibold rounded-full">TUTUP</span>
                </template>
                <template x-if="currentSesiStatus === 'belum_buka'">
                    <span class="px-3 py-1 bg-yellow-50 text-yellow-600 text-xs font-semibold rounded-full border border-yellow-100">BELUM BUKA</span>
                </template>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <label class="text-xs text-gray-500">Durasi:</label>
                    <template x-if="currentSesiStatus === 'aktif'">
                        <span class="text-sm font-mono font-bold text-red-500 animate-pulse bg-red-50 px-3 py-1.5 rounded-lg border border-red-100"
                              x-text="subTab === 'pretest' ? pretestRemaining : posttestRemaining"></span>
                    </template>
                    <template x-if="currentSesiStatus !== 'aktif'">
                        <div class="flex items-center gap-1.5">
                            <input type="number" x-model="durasi" min="5" max="180"
                                class="w-20 px-3 py-1.5 text-sm border border-gray-200 rounded-lg text-center focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                            <span class="text-xs text-gray-400">menit</span>
                        </div>
                    </template>
                </div>
                <template x-if="currentSesiStatus !== 'aktif'">
                    <button @click="openTes()" :disabled="currentSoalList.length === 0"
                        class="px-4 py-2 bg-green-500 hover:bg-green-600 disabled:bg-gray-300 disabled:cursor-not-allowed text-white text-sm rounded-xl transition-colors font-medium">
                        Buka Tes
                    </button>
                </template>
                <template x-if="currentSesiStatus === 'aktif'">
                    <button @click="closeTes()"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm rounded-xl transition-colors font-medium">
                        Tutup Tes
                    </button>
                </template>
            </div>
        </div>
    </div>

    
    <div class="space-y-3" x-show="currentSoalList.length > 0">
        <template x-for="(soal, idx) in currentSoalList" :key="soal.id">
            <div class="bg-white rounded-xl border border-gray-100 hover:border-primary/20 hover:shadow-sm transition-all group"
                 draggable="true"
                 :data-id="soal.id"
                 @dragstart="$event.dataTransfer.setData('text/plain', soal.id)"
                 @dragover.prevent="$el.classList.add('border-primary', 'shadow-md')"
                 @dragleave="$el.classList.remove('border-primary', 'shadow-md')"
                 @drop.prevent="handleDrop($event, soal)">
                <div class="flex items-start gap-4 p-4">
                    
                    <div class="flex items-center gap-2 pt-0.5">
                        <div class="cursor-grab active:cursor-grabbing text-gray-300 hover:text-gray-500">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                        </div>
                        <span class="w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center text-xs font-bold text-primary" x-text="idx + 1"></span>
                    </div>

                    
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-800 leading-relaxed" x-text="soal.teks_soal.length > 100 ? soal.teks_soal.substring(0, 100) + '...' : soal.teks_soal"></p>
                        <div class="flex items-center gap-2 mt-2">
                            <template x-for="opt in soal.pilihan_jawaban" :key="opt.id">
                                <span :class="opt.is_correct ? 'bg-green-50 text-green-700 border-green-200 font-semibold' : 'bg-gray-50 text-gray-500 border-gray-100'"
                                    class="text-[10px] px-2 py-0.5 rounded border" x-text="opt.huruf"></span>
                            </template>
                            <span class="text-[10px] text-gray-400 ml-1">Jawaban: <span class="font-semibold text-green-600" x-text="soal.pilihan_jawaban.find(o => o.is_correct)?.huruf || '-'"></span></span>
                        </div>
                    </div>

                    
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button @click="editSoal(soal)" class="p-1.5 rounded-lg hover:bg-primary/10 text-gray-400 hover:text-primary transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <button @click="deleteSoal(soal)" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <template x-if="currentSoalList.length === 0">
        <div class="py-8">
            <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Belum ada soal','description' => 'Tambahkan soal baru untuk tes ini.','icon' => 'document']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Belum ada soal','description' => 'Tambahkan soal baru untuk tes ini.','icon' => 'document']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
        </div>
    </template>

    
    <div x-show="showForm" x-transition.opacity class="fixed inset-0 z-50 flex items-start justify-center bg-black/50 backdrop-blur-sm overflow-y-auto py-8"
         @click.self="showForm = false" style="display: none;">
        <div x-show="showForm" x-transition class="bg-white rounded-2xl shadow-2xl border border-gray-100 w-full max-w-4xl mx-4">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold font-heading text-gray-800" x-text="editingSoal ? 'Edit Soal' : 'Tambah Soal Baru'"></h3>
                <button @click="showForm = false" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-gray-100">
                
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Teks Soal <span class="text-red-500">*</span></label>
                        <textarea x-model="form.teks_soal" rows="5"
                            class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none resize-none"
                            style="font-family: 'Amiri', 'Scheherazade New', serif; font-size: 16px; line-height: 2;"
                            placeholder="Tuliskan pertanyaan..."></textarea>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700">Pilihan Jawaban</label>
                        <template x-for="(opt, i) in ['A', 'B', 'C', 'D']" :key="opt">
                            <div class="flex items-start gap-3">
                                <label class="flex items-center gap-2 mt-3">
                                    <input type="radio" x-model="form.jawaban_benar" :value="opt"
                                        class="w-4 h-4 text-primary focus:ring-primary">
                                    <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold transition-colors"
                                        :class="form.jawaban_benar === opt ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-500'"
                                        x-text="opt"></span>
                                </label>
                                <textarea x-model="form.pilihan[i].teks" rows="2"
                                    class="flex-1 px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none resize-none"
                                    style="font-family: 'Amiri', 'Scheherazade New', serif; font-size: 14px; line-height: 1.8;"
                                    :placeholder="'Jawaban ' + opt"></textarea>
                            </div>
                        </template>
                    </div>
                </div>

                
                <div class="p-6 bg-gray-50/50">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Preview</p>
                    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                        <p class="text-base text-gray-800 leading-relaxed mb-4"
                           style="font-family: 'Amiri', 'Scheherazade New', serif; font-size: 16px; line-height: 2;"
                           x-text="form.teks_soal || 'Pertanyaan akan tampil di sini...'"></p>
                        <div class="space-y-2">
                            <template x-for="(opt, i) in ['A', 'B', 'C', 'D']" :key="'preview_' + opt">
                                <div :class="form.jawaban_benar === opt ? 'border-green-300 bg-green-50' : 'border-gray-200 bg-white'"
                                    class="flex items-center gap-3 p-3 rounded-xl border transition-all">
                                    <span :class="form.jawaban_benar === opt ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-500'"
                                        class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="opt"></span>
                                    <span class="text-sm" style="font-family: 'Amiri', 'Scheherazade New', serif;"
                                        x-text="form.pilihan[i]?.teks || 'Jawaban ' + opt"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 bg-gray-50/50 rounded-b-2xl">
                <button @click="showForm = false"
                    class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">Batal</button>
                <button @click="saveSoal(false)"
                    class="px-4 py-2 bg-primary/10 text-primary text-sm rounded-xl hover:bg-primary/20 transition-colors font-medium">
                    Simpan & Tambah Lagi
                </button>
                <button @click="saveSoal(true)"
                    class="px-5 py-2 bg-primary text-white text-sm rounded-xl hover:bg-primary/90 transition-colors font-medium shadow-sm">
                    Simpan
                </button>
            </div>
        </div>
    </div>

    
    <div x-show="showCopyForm" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
         @click.self="showCopyForm = false" style="display: none;">
        <div x-show="showCopyForm" x-transition class="bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
                <h3 class="text-lg font-bold text-gray-800 font-heading">Salin Teks Soal</h3>
                <button @click="showCopyForm = false" class="p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-200 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="<?php echo e(route('admin.soal.copyFrom', $event)); ?>" method="POST" class="p-6">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="tipe" :value="subTab">
                <p class="text-sm text-gray-500 mb-4">Pilih event dan sesi sebelumnya untuk menyalin soal <span x-text="subTab" class="font-bold capitalize text-primary"></span> ke event ini.</p>
                
                <!-- Event Sumber -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Event Sumber</label>
                    <select name="source_event_id" x-model="selectedSourceEventId" @change="selectedSourceSesiId = ''" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50 cursor-pointer">
                        <option value="">-- Pilih Event --</option>
                        <template x-for="e in otherEvents" :key="e.id">
                            <option :value="e.id" x-text="e.nama_event + ' (' + (e.lokasi || 'Tidak Diketahui') + ')'"></option>
                        </template>
                    </select>
                </div>

                <!-- Sesi Sumber -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sesi Sumber</label>
                    <select name="source_event_sesi_id" x-model="selectedSourceSesiId" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50 cursor-pointer" :disabled="!selectedSourceEventId">
                        <option value="">-- Pilih Sesi --</option>
                        <template x-for="s in (otherEvents.find(e => e.id == selectedSourceEventId)?.sesi || [])" :key="s.id">
                            <option :value="s.id" x-text="'Sesi ' + s.urutan + ': ' + s.nama_sesi"></option>
                        </template>
                    </select>
                </div>

                <!-- Sesi Target -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sesi Target (Event Saat Ini)</label>
                    <select name="event_sesi_id" x-model="selectedSesiId" required class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50 cursor-pointer">
                        <?php $__currentLoopData = $eventSesis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sesi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($sesi->id); ?>">Sesi <?php echo e($sesi->urutan); ?>: <?php echo e($sesi->nama_sesi); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" @click="showCopyForm = false" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-xl transition-colors font-medium">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-colors shadow-sm" :disabled="!selectedSourceEventId || !selectedSourceSesiId">
                        Salin Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<link href="https://fonts.googleapis.com/css2?family=Amiri&family=Scheherazade+New&display=swap" rel="stylesheet">
<script>
function soalManager() {
    return {
        subTab: 'pretest',
        showForm: false,
        showCopyForm: false,
        editingSoal: null,
        durasi: 30,
        form: { teks_soal: '', pilihan: [{teks:''},{teks:''},{teks:''},{teks:''}], jawaban_benar: 'A' },
        pretestSoal: <?php echo json_encode($pretestSoal, 15, 512) ?>,
        posttestSoal: <?php echo json_encode($posttestSoal, 15, 512) ?>,
        pretestSesiStatus: '<?php echo e($pretestSesi?->status ?? "belum_buka"); ?>',
        posttestSesiStatus: '<?php echo e($posttestSesi?->status ?? "belum_buka"); ?>',
        pretestRemainingSecs: <?php echo e($pretestRemainingSecs); ?>,
        posttestRemainingSecs: <?php echo e($posttestRemainingSecs); ?>,
        pretestRemaining: '',
        posttestRemaining: '',
        preTarget: 0,
        postTarget: 0,
        selectedSesiId: <?php echo e($firstSesi?->id ?? 0); ?>,
        otherEvents: <?php echo json_encode(\App\Models\Event::where('id', '!=', $event->id)->with(['sesi' => function($q) { $q->orderBy('urutan'); }])->orderByDesc('tanggal_mulai')->get()) ?>,
        selectedSourceEventId: '',
        selectedSourceSesiId: '',

        get currentSoalList() { return this.subTab === 'pretest' ? this.pretestSoal : this.posttestSoal; },
        get currentSesiStatus() { return this.subTab === 'pretest' ? this.pretestSesiStatus : this.posttestSesiStatus; },

        init() {
            this.durasi = <?php echo e($pretestSesi?->durasi_menit ?? 30); ?>;
            
            this.$watch('subTab', (val) => {
                this.durasi = val === 'pretest' 
                    ? (this.pretestDurasi ?? 30)
                    : (this.posttestDurasi ?? 30);
            });

            this.preTarget = this.pretestRemainingSecs > 0 ? Date.now() + (this.pretestRemainingSecs * 1000) : 0;
            this.postTarget = this.posttestRemainingSecs > 0 ? Date.now() + (this.posttestRemainingSecs * 1000) : 0;

            const updateCountdown = () => {
                // Pretest
                if (this.preTarget > 0 && this.pretestSesiStatus === 'aktif') {
                    const diff = Math.max(0, Math.round((this.preTarget - Date.now()) / 1000));
                    if (diff <= 0) {
                        this.pretestRemaining = '';
                        this.pretestSesiStatus = 'tutup';
                        this.preTarget = 0;
                    } else {
                        const m = Math.floor(diff / 60);
                        const s = diff % 60;
                        this.pretestRemaining = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
                    }
                } else {
                    this.pretestRemaining = '';
                }

                // Posttest
                if (this.postTarget > 0 && this.posttestSesiStatus === 'aktif') {
                    const diff = Math.max(0, Math.round((this.postTarget - Date.now()) / 1000));
                    if (diff <= 0) {
                        this.posttestRemaining = '';
                        this.posttestSesiStatus = 'tutup';
                        this.postTarget = 0;
                    } else {
                        const m = Math.floor(diff / 60);
                        const s = diff % 60;
                        this.posttestRemaining = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
                    }
                } else {
                    this.posttestRemaining = '';
                }
            };

            updateCountdown();
            setInterval(updateCountdown, 1000);
        },

        async loadMaterialData() {
            if (!this.selectedSesiId) return;
            const res = await fetch('<?php echo e(route("admin.soal.materialData", $event)); ?>?event_sesi_id=' + this.selectedSesiId);
            if (res.ok) {
                const data = await res.json();
                this.pretestSoal = data.pretestSoal;
                this.posttestSoal = data.posttestSoal;
                this.pretestSesiStatus = data.pretestSesiStatus;
                this.posttestSesiStatus = data.posttestSesiStatus;
                this.pretestRemainingSecs = data.pretestRemainingSecs;
                this.posttestRemainingSecs = data.posttestRemainingSecs;
                this.pretestDurasi = data.pretestDurasi;
                this.posttestDurasi = data.posttestDurasi;
                this.preTarget = this.pretestRemainingSecs > 0 ? Date.now() + (this.pretestRemainingSecs * 1000) : 0;
                this.postTarget = this.posttestRemainingSecs > 0 ? Date.now() + (this.posttestRemainingSecs * 1000) : 0;
                this.durasi = this.subTab === 'pretest' ? data.pretestDurasi : data.posttestDurasi;
            }
        },

        resetForm() {
            this.form = { teks_soal: '', pilihan: [{teks:''},{teks:''},{teks:''},{teks:''}], jawaban_benar: 'A' };
        },

        editSoal(soal) {
            this.editingSoal = soal;
            this.form.teks_soal = soal.teks_soal;
            this.form.jawaban_benar = soal.pilihan_jawaban.find(o => o.is_correct)?.huruf || 'A';
            this.form.pilihan = soal.pilihan_jawaban.map(o => ({ teks: o.teks_pilihan }));
            this.showForm = true;
        },

        async saveSoal(closeAfter) {
            const url = this.editingSoal
                ? '<?php echo e(route("admin.soal.update", [$event, "__SOAL__"])); ?>'.replace('__SOAL__', this.editingSoal.id)
                : '<?php echo e(route("admin.soal.store", $event)); ?>';
            const method = this.editingSoal ? 'PUT' : 'POST';

            const res = await fetch(url, {
                method,
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>', 'Accept': 'application/json' },
                body: JSON.stringify({ ...this.form, tipe: this.subTab, event_sesi_id: this.selectedSesiId }),
            });
            const data = await res.json();

            if (data.status === 'success') {
                if (this.editingSoal) {
                    const list = this.subTab === 'pretest' ? this.pretestSoal : this.posttestSoal;
                    const idx = list.findIndex(s => s.id === this.editingSoal.id);
                    if (idx >= 0) list[idx] = data.soal;
                } else {
                    (this.subTab === 'pretest' ? this.pretestSoal : this.posttestSoal).push(data.soal);
                }
                if (closeAfter) { this.showForm = false; }
                else { this.editingSoal = null; this.resetForm(); }
            }
        },

        async deleteSoal(soal) {
            if (!confirm('Hapus soal ini?')) return;
            const url = '<?php echo e(route("admin.soal.destroy", [$event, "__SOAL__"])); ?>'.replace('__SOAL__', soal.id);
            await fetch(url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>', 'Accept': 'application/json' } });
            const list = this.subTab === 'pretest' ? this.pretestSoal : this.posttestSoal;
            const idx = list.findIndex(s => s.id === soal.id);
            if (idx >= 0) list.splice(idx, 1);
        },

        async handleDrop(event, targetSoal) {
            event.target.closest('[data-id]')?.classList.remove('border-primary', 'shadow-md');
            const draggedId = parseInt(event.dataTransfer.getData('text/plain'));
            if (draggedId === targetSoal.id) return;
            const list = this.subTab === 'pretest' ? this.pretestSoal : this.posttestSoal;
            const fromIdx = list.findIndex(s => s.id === draggedId);
            const toIdx = list.findIndex(s => s.id === targetSoal.id);
            if (fromIdx < 0 || toIdx < 0) return;
            const [item] = list.splice(fromIdx, 1);
            list.splice(toIdx, 0, item);
            const order = list.map((s, i) => ({ id: s.id, urutan: i + 1 }));
            await fetch('<?php echo e(route("admin.soal.reorder", $event)); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                body: JSON.stringify({ order }),
            });
        },

        async openTes() {
            const res = await fetch('<?php echo e(route("admin.sesiTes.open", $event)); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                body: JSON.stringify({ tipe: this.subTab, durasi_menit: this.durasi, event_sesi_id: this.selectedSesiId }),
            });
            if (res.ok) {
                if (this.subTab === 'pretest') {
                    this.pretestSesiStatus = 'aktif';
                    this.preTarget = Date.now() + (this.durasi * 60 * 1000);
                } else {
                    this.posttestSesiStatus = 'aktif';
                    this.postTarget = Date.now() + (this.durasi * 60 * 1000);
                }
            }
        },

        async closeTes() {
            if (!confirm('Tutup tes ' + this.subTab + '?')) return;
            const res = await fetch('<?php echo e(route("admin.sesiTes.close", $event)); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                body: JSON.stringify({ tipe: this.subTab, event_sesi_id: this.selectedSesiId }),
            });
            if (res.ok) {
                if (this.subTab === 'pretest') {
                    this.pretestSesiStatus = 'tutup';
                    this.preTarget = 0;
                } else {
                    this.posttestSesiStatus = 'tutup';
                    this.postTarget = 0;
                }
            }
        },

        async duplicateToPosttest() {
            if (!confirm('Ini akan mengganti semua soal Posttest dengan salinan soal Pretest untuk materi ini. Lanjutkan?')) return;
            const res = await fetch('<?php echo e(route("admin.soal.duplicatePosttest", $event)); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                body: JSON.stringify({ event_sesi_id: this.selectedSesiId }),
            });
            if (res.ok) { this.loadMaterialData(); }
        },
    };
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/admin/events/partials/tab-pretest.blade.php ENDPATH**/ ?>