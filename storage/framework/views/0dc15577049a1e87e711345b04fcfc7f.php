<?php $__env->startSection('title', 'Pretest & Posttest'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto py-8 px-4">
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Pretest / Posttest','subtitle' => 'Evaluasi pemahaman awal dan akhir berdasarkan materi']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Pretest / Posttest','subtitle' => 'Evaluasi pemahaman awal dan akhir berdasarkan materi']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>

    <?php if($activeEvent): ?>
        <div class="mt-8 bg-white rounded-3xl border border-gray-100 p-6 md:p-8 shadow-sm mb-8">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-heading font-bold text-gray-800">Petunjuk Evaluasi</h3>
                    <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                        Evaluasi kognitif disesuaikan untuk masing-masing materi. Setiap materi memiliki **Pretest** (di awal sesi materi) dan **Posttest** (di akhir sesi materi). Pastikan Anda mengerjakan tes saat sesi materi yang bersangkutan telah dibuka oleh panitia.
                    </p>
                </div>
            </div>
        </div>

        <?php if($materials->isEmpty()): ?>
            <div class="flex flex-col items-center justify-center py-12 text-center bg-white border border-gray-100 rounded-[2.5rem] p-8">
                <h2 class="text-xl font-heading font-bold text-gray-800 mb-2">Belum Ada Materi</h2>
                <p class="text-gray-500 max-w-md mx-auto">Saat ini belum ada sesi materi yang diinput oleh panitia.</p>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6 md:p-8 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary font-bold text-xs flex items-center justify-center">
                                <?php echo e($material['urutan']); ?>

                            </span>
                            <h3 class="text-lg font-heading font-bold text-gray-800"><?php echo e($material['nama_sesi']); ?></h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="p-5 rounded-2xl bg-gray-50/50 border border-gray-100 flex flex-col justify-between">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Pretest</span>
                                    <?php if($material['pretest']['done']): ?>
                                        <span class="px-2 py-0.5 bg-green-50 text-green-600 text-[10px] font-bold rounded border border-green-200">Selesai</span>
                                    <?php elseif($material['pretest']['active']): ?>
                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[10px] font-bold rounded border border-emerald-200 animate-pulse">Aktif</span>
                                    <?php else: ?>
                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-400 text-[10px] font-bold rounded border border-gray-200">Belum Dibuka</span>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-4">
                                    <p class="text-xs text-gray-400">Total Soal: <span class="font-bold text-gray-700"><?php echo e($material['pretest']['total_soal']); ?> butir</span></p>
                                </div>

                                <?php if($material['pretest']['done']): ?>
                                    <div class="flex items-center gap-2 bg-green-50 p-3 rounded-xl border border-green-100 text-green-700">
                                        <svg class="w-4 h-4 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-xs font-medium">Jawaban telah berhasil dikumpulkan</span>
                                    </div>
                                <?php else: ?>
                                    <?php if($material['pretest']['active']): ?>
                                        <a href="<?php echo e(route('peserta.tes.instruction', [$activeEvent, $material['id'], 'pretest'])); ?>" class="w-full flex items-center justify-center gap-1.5 py-2.5 bg-primary text-white rounded-xl font-bold text-xs hover:bg-primary-600 transition-colors shadow-sm">
                                            Kerjakan Pretest
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </a>
                                    <?php else: ?>
                                        <button disabled class="w-full py-2.5 bg-gray-100 text-gray-400 rounded-xl font-bold text-xs cursor-not-allowed border border-gray-200">
                                            Sesi Belum Dibuka
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>

                            
                            <div class="p-5 rounded-2xl bg-gray-50/50 border border-gray-100 flex flex-col justify-between">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-xs font-bold uppercase tracking-wider text-amber-600">Posttest</span>
                                    <?php if($material['posttest']['done']): ?>
                                        <span class="px-2 py-0.5 bg-green-50 text-green-600 text-[10px] font-bold rounded border border-green-200">Selesai</span>
                                    <?php elseif($material['posttest']['active']): ?>
                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[10px] font-bold rounded border border-emerald-200 animate-pulse">Aktif</span>
                                    <?php else: ?>
                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-400 text-[10px] font-bold rounded border border-gray-200">Belum Dibuka</span>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-4">
                                    <p class="text-xs text-gray-400">Total Soal: <span class="font-bold text-gray-700"><?php echo e($material['posttest']['total_soal']); ?> butir</span></p>
                                </div>

                                <?php if($material['posttest']['done']): ?>
                                    <div class="flex items-center gap-2 bg-green-50 p-3 rounded-xl border border-green-100 text-green-700">
                                        <svg class="w-4 h-4 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-xs font-medium">Jawaban telah berhasil dikumpulkan</span>
                                    </div>
                                <?php else: ?>
                                    <?php if($material['posttest']['active']): ?>
                                        <a href="<?php echo e(route('peserta.tes.instruction', [$activeEvent, $material['id'], 'posttest'])); ?>" class="w-full flex items-center justify-center gap-1.5 py-2.5 bg-primary text-white rounded-xl font-bold text-xs hover:bg-primary-600 transition-colors shadow-sm">
                                            Kerjakan Posttest
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </a>
                                    <?php else: ?>
                                        <button disabled class="w-full py-2.5 bg-gray-100 text-gray-400 rounded-xl font-bold text-xs cursor-not-allowed border border-gray-200">
                                            Sesi Belum Dibuka
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="flex flex-col items-center justify-center py-20 text-center bg-white border border-gray-100 rounded-[2.5rem] mt-8 p-8">
            <div class="w-64 h-64 mb-8">
                <img src="<?php echo e(asset('images/arka/arka_fokus.png')); ?>" alt="No Event" class="w-full h-full object-contain opacity-50 grayscale">
            </div>
            <h2 class="text-3xl font-heading font-bold text-gray-800 mb-2">Belum Ada Acara Aktif</h2>
            <p class="text-gray-500 max-w-md mx-auto">Saat ini Anda belum terdaftar dalam Baitul Arqam yang sedang aktif. Silakan hubungi admin LP3A UMS jika terjadi kesalahan.</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/peserta/tes/index.blade.php ENDPATH**/ ?>