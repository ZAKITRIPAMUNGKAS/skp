
<div>

    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <h3 class="text-lg font-semibold font-heading text-gray-800">Daftar Peserta (<?php echo e($participants->count()); ?>)</h3>
        <div class="flex flex-wrap items-center gap-3">
            <?php if($participants->count() > 0): ?>
                <a href="<?php echo e(route('admin.participants.accountsPdf', $event)); ?>" target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-transparent border border-gray-200 text-gray-600 text-[13px] font-semibold rounded-full hover:bg-gray-50 transition-all" title="Download PDF Akun Login">
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Akun PDF
                </a>
                <a href="<?php echo e(route('admin.participants.pdf', $event)); ?>" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-50 text-blue-700 text-[13px] font-bold rounded-full hover:bg-blue-100 transition-all shadow-sm" title="Lihat Data Lengkap (PDF)">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Data Lengkap
                </a>
                <a href="<?php echo e(route('admin.participants.export', $event)); ?>"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-transparent border border-gray-200 text-gray-500 text-[13px] font-semibold rounded-full hover:bg-gray-50 transition-all" title="Export Excel">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Excel
                </a>
            <?php endif; ?>

            <button type="button" class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-50 text-green-700 border border-green-200 text-[13px] font-semibold rounded-full hover:bg-green-100 transition-all shadow-sm" @click="$dispatch('open-modal-show-import')">
                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import Excel
            </button>

            <button type="button" class="inline-flex items-center gap-2 px-4 py-2.5 bg-transparent border-2 border-dashed border-gray-300 text-gray-600 text-[13px] font-semibold rounded-full hover:border-gray-400 hover:bg-gray-50 transition-all" @click="$dispatch('open-modal-show-add-manual')">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Manual
            </button>

            
            <div x-data="{ 
                copyText: '<?php echo e($event->registration_token ? route('registration.form', $event->registration_token) : '#'); ?>',
                copied: false,
                copy() {
                    if(this.copyText === '#') return;
                    navigator.clipboard.writeText(this.copyText);
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                }
            }" class="relative">
                <button @click="copy()" 
                    :class="copied ? 'bg-green-600 shadow-green-200' : 'bg-primary shadow-primary/20'"
                    class="inline-flex items-center gap-2 px-6 py-2.5 text-white text-[13px] font-bold rounded-full hover:scale-[1.02] transition-all shadow-md active:scale-95">
                    <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                    <svg x-show="copied" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span x-text="copied ? 'Link Tersalin!' : 'Bagikan Link Pendaftaran'"></span>
                </button>
            </div>
        </div>
    </div>

    
    <?php if($participants->count()): ?>
    <div class="overflow-x-auto border border-gray-100 rounded-xl">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/50">
                    <th class="text-left px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Peserta</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Unit Kerja</th>
                    <th class="text-center px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Kesediaan</th>
                    <th class="text-center px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">QR Code</th>
                    <th class="text-center px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Evaluasi</th>
                    <th class="text-right px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__currentLoopData = $participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $p = $ep->peserta; ?>
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                    <?php if($p->foto): ?>
                                        <img src="<?php echo e($p->foto_url); ?>" referrerpolicy="no-referrer" class="w-9 h-9 rounded-full object-cover" alt="">
                                    <?php else: ?>
                                        <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 text-sm"><?php echo e(Str::limit($p->nama_lengkap, 35)); ?></p>
                                    <div class="flex items-center gap-2">
                                        <p class="text-[10px] bg-gray-100 text-gray-600 px-1 rounded font-mono">ID: <?php echo e($p->user->username); ?></p>
                                        <p class="text-[10px] text-gray-400"><?php echo e($p->email); ?></p>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-sm"><?php echo e($p->unit_kerja ?? '-'); ?></td>
                        <td class="px-4 py-3 text-center text-sm">
                            <?php if($ep->konfirmasi_kesediaan === 'bersedia'): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                    Bersedia
                                </span>
                            <?php elseif($ep->konfirmasi_kesediaan === 'tidak_bersedia'): ?>
                                <button type="button" 
                                    @click="$dispatch('open-alasan-modal', { 
                                        pesertaNama: '<?php echo e(addslashes($p->nama_lengkap)); ?>', 
                                        eventNama: '<?php echo e(addslashes($event->nama_event)); ?>', 
                                        alasan: '<?php echo e(addslashes($ep->alasan_tidak_hadir)); ?>' 
                                    })"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200 hover:bg-red-100 hover:border-red-300 transition-colors shadow-sm cursor-pointer"
                                    title="Klik untuk melihat alasan">
                                    Tidak Hadir ⓘ
                                </button>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-50 text-gray-600 border border-gray-200">
                                    Belum Konfirmasi
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <?php if($ep->qr_code): ?>
                                <?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => ['type' => 'berlangsung']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'berlangsung']); ?>QR ✓ <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
                            <?php else: ?>
                                <form method="POST" action="<?php echo e(route('admin.participants.generateQr', [$event, $p])); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-xs text-primary hover:underline">Generate QR</button>
                                </form>
                            <?php endif; ?>
                        </td>
                        <?php
                            $preSoalCount = \App\Models\Soal::where('event_id', $event->id)->where('tipe', 'pretest')->count();
                            $preAnsweredCount = \App\Models\JawabanPeserta::where('event_id', $event->id)
                                ->where('peserta_id', $p->id)
                                ->whereHas('soal', fn($q) => $q->where('tipe', 'pretest'))
                                ->count();
                            $preDone = $preSoalCount > 0 && $preAnsweredCount >= $preSoalCount;

                            $postSoalCount = \App\Models\Soal::where('event_id', $event->id)->where('tipe', 'posttest')->count();
                            $postAnsweredCount = \App\Models\JawabanPeserta::where('event_id', $event->id)
                                ->where('peserta_id', $p->id)
                                ->whereHas('soal', fn($q) => $q->where('tipe', 'posttest'))
                                ->count();
                            $postDone = $postSoalCount > 0 && $postAnsweredCount >= $postSoalCount;

                            $afkDone = \App\Models\AfektifJawaban::where('event_id', $event->id)
                                ->where('peserta_id', $p->id)
                                ->exists();
                            $psiDone = \App\Models\PsikomotorNilai::where('event_id', $event->id)
                                ->where('peserta_id', $p->id)
                                ->exists();
                        ?>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-1.5">
                                <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded text-[10px] font-semibold <?php echo e($preDone ? 'bg-green-50 text-green-600 border border-green-200' : 'bg-gray-50 text-gray-400 border border-gray-150'); ?>" title="Pretest">
                                    Pre <?php echo e($preDone ? '✓' : '✗'); ?>

                                </span>
                                <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded text-[10px] font-semibold <?php echo e($postDone ? 'bg-green-50 text-green-600 border border-green-200' : 'bg-gray-50 text-gray-400 border border-gray-150'); ?>" title="Posttest">
                                    Post <?php echo e($postDone ? '✓' : '✗'); ?>

                                </span>
                                <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded text-[10px] font-semibold <?php echo e($afkDone ? 'bg-green-50 text-green-600 border border-green-200' : 'bg-gray-50 text-gray-400 border border-gray-150'); ?>" title="Afektif">
                                    Afk <?php echo e($afkDone ? '✓' : '✗'); ?>

                                </span>
                                <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded text-[10px] font-semibold <?php echo e($psiDone ? 'bg-green-50 text-green-600 border border-green-200' : 'bg-gray-50 text-gray-400 border border-gray-150'); ?>" title="Psikomotor">
                                    Psi <?php echo e($psiDone ? '✓' : '✗'); ?>

                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                
                                <a href="<?php echo e(route('admin.participants.downloadIdCard', [$event, $p])); ?>" target="_blank"
                                   class="p-1.5 rounded-lg hover:bg-blue-50 text-gray-400 hover:text-blue-600 transition-colors"
                                   title="Download ID Card">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>

                                <form method="POST" action="<?php echo e(route('admin.participants.destroy', [$event, $p])); ?>"
                                      onsubmit="return confirm('Hapus peserta ini dari event?')" class="inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100" title="Hapus dari Event">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    
    <?php if($participants->hasPages()): ?>
    <div class="mt-4">
        <?php echo e($participants->links()); ?>

    </div>
    <?php endif; ?>
    
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Belum ada peserta','description' => 'Tambahkan peserta melalui upload Excel atau input manual.','icon' => 'people']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Belum ada peserta','description' => 'Tambahkan peserta melalui upload Excel atau input manual.','icon' => 'people']); ?>
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
    <?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'show-import','title' => 'Import Peserta dari Excel']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'show-import','title' => 'Import Peserta dari Excel']); ?>
        <div class="space-y-6">
            
            <div class="bg-blue-50 rounded-xl p-4">
                <h4 class="text-sm font-semibold text-blue-800 mb-2">Step 1 — Download Template</h4>
                <p class="text-xs text-blue-600 mb-3">Download template Excel V2 dengan format kolom lengkap (Nama, NIK, Homebase, Kesediaan, dsb.)</p>
                <a href="<?php echo e(route('admin.participants.template', $event)); ?>"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download Template
                </a>
            </div>

            
            <form method="POST" action="<?php echo e(route('admin.participants.import', $event)); ?>" enctype="multipart/form-data" x-data="{ loading: false }" @submit="loading = true">
                <?php echo csrf_field(); ?>
                <h4 class="text-sm font-semibold text-gray-800 mb-2">Step 2 — Upload File</h4>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center mb-4 hover:border-primary/40 transition-colors">
                    <input type="file" name="file" accept=".csv,.xlsx,.xls" required
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    <p class="text-xs text-gray-400 mt-2">Format: CSV, XLSX, XLS (maks 5MB)</p>
                </div>

                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Jika NIK/Email duplikat:</label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 text-sm text-gray-600">
                            <input type="radio" name="duplicate_action" value="update" checked class="text-primary focus:ring-primary">
                            Update data profil (Rekomendasi)
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600">
                            <input type="radio" name="duplicate_action" value="skip" class="text-primary focus:ring-primary">
                            Lewati duplikat
                        </label>
                    </div>
                </div>

                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'primary','class' => 'w-full relative flex justify-center items-center',':disabled' => 'loading']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'primary','class' => 'w-full relative flex justify-center items-center',':disabled' => 'loading']); ?>
                    <span x-show="!loading" class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Import Peserta
                    </span>
                    <span x-show="loading" class="flex items-center" x-cloak>
                        <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Mengimport data, mohon tunggu...
                    </span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
            </form>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'show-add-manual','title' => 'Tambah Peserta Manual']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'show-add-manual','title' => 'Tambah Peserta Manual']); ?>
        <form method="POST" action="<?php echo e(route('admin.participants.store', $event)); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" required
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50"
                        placeholder="Dr. Ahmad Fauzi, M.Pd.">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-xs text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="email" name="email"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50"
                        placeholder="email@example.com">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                        <input type="text" name="no_hp"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50"
                            placeholder="08123456789">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unit Kerja</label>
                        <input type="text" name="unit_kerja"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50"
                            placeholder="Fakultas Teknik">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                    <input type="file" name="foto" accept="image/*"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                </div>
                <div x-data="{ autoPass: true }">
                    <label class="flex items-center gap-2 text-sm text-gray-700 mb-2">
                        <input type="checkbox" x-model="autoPass" name="auto_password" value="1" checked class="rounded text-primary focus:ring-primary">
                        Generate password otomatis
                    </label>
                    <div x-show="!autoPass" x-transition>
                        <input type="password" name="password" minlength="6" autocomplete="new-password"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-gray-50/50"
                            placeholder="Minimal 6 karakter">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['variant' => 'ghost','type' => 'button','@click' => 'show = false']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'ghost','type' => 'button','@click' => 'show = false']); ?>Batal <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'primary']); ?>Tambah Peserta <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
            </div>
        </form>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>

    
    <div x-data="{ 
            showModal: false, 
            pesertaNama: '', 
            eventNama: '', 
            alasan: '' 
         }"
         x-on:open-alasan-modal.window="
            pesertaNama = $event.detail.pesertaNama;
            eventNama = $event.detail.eventNama;
            alasan = $event.detail.alasan;
            showModal = true;
         "
         x-show="showModal"
         x-cloak
         class="fixed inset-0 z-[80] overflow-y-auto"
         style="display: none;">
         
         <div x-show="showModal"
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0"
              @click="showModal = false"
              class="fixed inset-0 bg-black/40 backdrop-blur-sm">
         </div>

         <div class="flex min-h-full items-center justify-center p-4">
             <div x-show="showModal"
                  x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                  x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                  x-transition:leave="transition ease-in duration-200"
                  x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                  x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                  @click.outside="showModal = false"
                  class="relative w-full sm:max-w-lg bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-gray-100">
                  
                  
                  <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between">
                      <div class="flex items-center gap-3">
                          <div class="w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center">
                              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                              </svg>
                          </div>
                          <div class="text-left">
                              <h3 class="text-base font-bold text-gray-800 font-heading">Alasan Tidak Hadir</h3>
                              <p class="text-[11px] text-gray-400">Keterangan berhalangan menghadiri event</p>
                          </div>
                      </div>
                      <button @click="showModal = false"
                              class="w-8 h-8 rounded-xl hover:bg-gray-50 flex items-center justify-center transition-colors text-gray-400 hover:text-gray-600 cursor-pointer">
                          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                          </svg>
                      </button>
                  </div>
                  
                  
                  <div class="p-6 space-y-4.5 text-left">
                      <div class="grid grid-cols-2 gap-4">
                          <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-4">
                              <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Peserta</span>
                              <p class="text-xs font-bold text-gray-800" x-text="pesertaNama"></p>
                          </div>
                          <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-4">
                              <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Event</span>
                              <p class="text-xs font-bold text-gray-700" x-text="eventNama"></p>
                          </div>
                      </div>
                      
                      <div>
                          <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Keterangan / Alasan Detail</span>
                          <div class="bg-red-50/20 border-l-4 border-red-500 rounded-r-2xl p-4">
                              <p class="text-xs text-gray-600 leading-relaxed whitespace-pre-wrap font-medium" x-text="alasan || 'Tidak ada alasan detail ditulis.'"></p>
                          </div>
                      </div>
                  </div>
                  
                  
                  <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-50 flex items-center justify-end">
                      <button type="button" @click="showModal = false"
                              class="px-5 py-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 transition-all rounded-xl text-xs font-bold shadow-sm cursor-pointer active:scale-95">
                          Tutup
                      </button>
                  </div>
             </div>
         </div>
    </div>

</div>
<?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/admin/events/partials/tab-peserta.blade.php ENDPATH**/ ?>