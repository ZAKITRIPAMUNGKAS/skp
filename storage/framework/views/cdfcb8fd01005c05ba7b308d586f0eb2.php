
<div class="space-y-6">
    <div>
        <h3 class="text-lg font-semibold font-heading text-gray-800">Riwayat Aktivitas Event</h3>
        <p class="text-sm text-gray-500 mt-1">Audit log aktivitas fasilitator dan admin pada event ini.</p>
    </div>

    <div class="bg-white border border-gray-150 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider rounded-tl-lg">Waktu</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider rounded-tr-lg">Detail Perubahan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $eventLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500"><?php echo e($log->created_at->format('d M Y H:i:s')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800"><?php echo e($log->user->name ?? 'Sistem'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap capitalize text-gray-600">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 border border-gray-200">
                                <?php echo e($log->role_user ?? ($log->user->role ?? '-')); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider rounded-lg 
                                <?php if($log->action == 'created'): ?> bg-green-50 text-green-600 
                                <?php elseif($log->action == 'updated'): ?> bg-blue-50 text-blue-600 
                                <?php elseif($log->action == 'deleted'): ?> bg-red-50 text-red-600 
                                <?php else: ?> bg-gray-100 text-gray-600 <?php endif; ?>">
                                <?php echo e($log->action); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600"><?php echo e($log->description); ?></td>
                        <td class="px-6 py-4 text-xs">
                            <?php if($log->old_values || $log->new_values): ?>
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 max-h-48 overflow-y-auto font-mono text-[11px] space-y-2">
                                    <?php if($log->old_values): ?>
                                        <div>
                                            <span class="text-red-600 font-semibold">Sebelum:</span>
                                            <pre class="whitespace-pre-wrap"><?php echo e(json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($log->new_values): ?>
                                        <div class="border-t border-gray-200/60 pt-2">
                                            <span class="text-green-600 font-semibold">Sesudah:</span>
                                            <pre class="whitespace-pre-wrap"><?php echo e(json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <span class="text-gray-400 font-italic">Tidak ada data detail</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Belum ada aktivitas','description' => 'Aktivitas audit log event ini masih kosong.','icon' => 'document']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Belum ada aktivitas','description' => 'Aktivitas audit log event ini masih kosong.','icon' => 'document']); ?>
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
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/admin/events/partials/tab-logs.blade.php ENDPATH**/ ?>