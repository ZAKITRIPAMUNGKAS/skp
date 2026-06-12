<?php $__env->startSection('title', 'Kehadiran Sesi'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto py-8 px-4">
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Kehadiran','subtitle' => 'Riwayat kehadiran sesi Baitul Arqam']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Kehadiran','subtitle' => 'Riwayat kehadiran sesi Baitul Arqam']); ?>
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
        
        <div class="mt-8 bg-gradient-to-r from-primary to-secondary rounded-[2.5rem] p-8 text-white shadow-xl shadow-primary/10 mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center md:text-left">
                <span class="px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-white/95 text-xs font-bold uppercase tracking-widest border border-white/20">
                    Rekapitulasi Kehadiran
                </span>
                <h3 class="text-3xl font-heading font-extrabold text-white">Persentase Kehadiran Anda</h3>
                <p class="text-primary-100 text-sm max-w-md">
                    Kehadiran Anda dicatat oleh panitia saat memindai Kode QR Anda di setiap sesi.
                </p>
            </div>
            
            <div class="flex items-center gap-6 shrink-0 bg-white/10 p-6 rounded-3xl border border-white/20 backdrop-blur-sm">
                <div class="text-center">
                    <span class="block text-4xl font-black text-accent-200">
                        <?php echo e($totalSessions > 0 ? round(($attendedCount / $totalSessions) * 100) : 0); ?>%
                    </span>
                    <span class="text-xs text-white/70 font-semibold uppercase tracking-wider block mt-1">Kehadiran</span>
                </div>
                <div class="h-12 w-[1px] bg-white/20"></div>
                <div class="text-center">
                    <span class="block text-2xl font-bold text-white">
                        <?php echo e($attendedCount); ?> / <?php echo e($totalSessions); ?>

                    </span>
                    <span class="text-xs text-white/70 font-semibold uppercase tracking-wider block mt-1">Sesi Terdaftar</span>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-[2.5rem] border border-gray-100 p-8 shadow-sm">
            <h3 class="text-xl font-heading font-bold text-gray-800 mb-8">Riwayat Sesi & Presensi</h3>
            
            <?php if($sessions->count() > 0): ?>
                <div class="relative space-y-8 pl-8 md:pl-12">
                    
                    <div class="absolute left-[19px] md:left-[23px] top-2 bottom-2 w-[2px] bg-gray-100"></div>

                    <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sesi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-4 group">
                            
                            <div class="absolute left-[-29px] md:left-[-33px] top-1 md:top-auto z-10 w-8 h-8 rounded-full border-2 flex items-center justify-center transition-colors duration-300
                                <?php echo e($sesi['attended'] ? 'bg-green-500 border-green-500 text-white' : 'bg-white border-gray-200 text-gray-300 group-hover:border-primary/45'); ?>">
                                <?php if($sesi['attended']): ?>
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <?php else: ?>
                                    <span class="text-xs font-bold"><?php echo e(str_pad($sesi['urutan'], 2, '0', STR_PAD_LEFT)); ?></span>
                                <?php endif; ?>
                            </div>

                            
                            <div class="flex-1">
                                <h4 class="text-base font-bold text-gray-800 transition-colors group-hover:text-primary">
                                    <?php echo e($sesi['nama_sesi']); ?>

                                </h4>
                                <p class="text-xs text-gray-400 mt-1">
                                    Sesi ke-<?php echo e($sesi['urutan']); ?> pada <?php echo e($activeEvent->nama_event); ?>

                                </p>
                            </div>

                            
                            <div class="flex items-center shrink-0">
                                <?php if($sesi['attended']): ?>
                                    <div class="bg-green-50 border border-green-100 rounded-2xl px-4 py-2 flex flex-col items-end">
                                        <span class="text-xs font-bold text-green-600">Hadir</span>
                                        <span class="text-[10px] text-green-500 font-mono mt-0.5">
                                            <?php echo e($sesi['waktu_scan'] ? $sesi['waktu_scan']->format('d M Y - H:i') : ''); ?> WIB
                                        </span>
                                    </div>
                                <?php else: ?>
                                    <span class="px-4 py-1.5 bg-rose-50 text-rose-600 text-xs font-semibold rounded-full border border-rose-100">
                                        Tidak Hadir
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-sm font-semibold">Belum ada sesi yang terdaftar untuk acara ini.</p>
                </div>
            <?php endif; ?>
        </div>
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

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/peserta/kehadiran/index.blade.php ENDPATH**/ ?>