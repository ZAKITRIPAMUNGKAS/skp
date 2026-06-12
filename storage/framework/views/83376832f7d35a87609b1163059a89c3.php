<?php $__env->startSection('title', 'Penilaian Afektif'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto py-8 px-4">
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Penilaian Afektif','subtitle' => 'Pengisian kuesioner sikap dan kedisiplinan mandiri']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Penilaian Afektif','subtitle' => 'Pengisian kuesioner sikap dan kedisiplinan mandiri']); ?>
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

    <div class="space-y-3 mt-6">
        <?php $__currentLoopData = $subAspeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-xl border border-gray-100 hover:shadow-sm transition-all p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold
                            <?php echo e($sa['completed'] ? 'bg-green-50 text-green-600' : 'bg-primary/10 text-primary'); ?>">
                            <?php if($sa['completed']): ?>✓<?php else: ?><?php echo e($loop->iteration); ?><?php endif; ?>
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-gray-800"><?php echo e($sa['nama']); ?></p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                <?php echo e($sa['answered']); ?>/<?php echo e($sa['butirCount']); ?> pernyataan
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <?php if($sa['completed']): ?>
                            <span class="px-3 py-1 bg-green-50 text-green-600 text-xs font-semibold rounded-full border border-green-100">Selesai ✓</span>
                        <?php elseif($sa['status'] === 'aktif'): ?>
                            <a href="<?php echo e(route('peserta.afektif.fill', [$event, $sa['id']])); ?>"
                               class="px-4 py-2 bg-primary text-white text-xs font-semibold rounded-xl hover:bg-primary/90 transition-colors shadow-sm">
                                Isi Sekarang →
                            </a>
                        <?php elseif($sa['status'] === 'tutup'): ?>
                            <span class="px-3 py-1 bg-gray-100 text-gray-400 text-xs font-semibold rounded-full">Ditutup</span>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-yellow-50 text-yellow-600 text-xs font-semibold rounded-full border border-yellow-100">Belum Dibuka</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/peserta/afektif/index.blade.php ENDPATH**/ ?>