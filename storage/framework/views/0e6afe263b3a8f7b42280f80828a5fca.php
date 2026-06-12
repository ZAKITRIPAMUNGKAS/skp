
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h3 class="text-xl font-bold font-heading text-gray-800">Manajemen Fasilitator</h3>
            <p class="text-xs text-gray-500 mt-1">Tugaskan instruktur / fasilitator untuk membantu mendampingi dan mengelola event ini.</p>
        </div>
        <?php if(count($assignedFasilitatorIds) > 0): ?>
            <div class="flex-shrink-0">
                <a href="<?php echo e(route('admin.events.facilitatorsPdf', $event)); ?>" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-700 border border-red-200 text-xs font-bold rounded-xl hover:bg-red-100 transition-all shadow-sm">
                    <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Unduh Surat Tugas (PDF)
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm">
        <form method="POST" action="<?php echo e(route('admin.events.assignFacilitators', $event)); ?>">
            <?php echo csrf_field(); ?>
            <div class="space-y-6">
                <div class="flex items-center gap-2 pb-4 border-b border-gray-100">
                    <div class="w-2 h-2 rounded-full bg-primary animate-pulse"></div>
                    <span class="text-sm font-bold text-gray-800">Pilih Fasilitator yang Ditugaskan:</span>
                </div>
                
                <?php if(count($allFasilitators) > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                        <?php $__currentLoopData = $allFasilitators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fasilitator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $isChecked = in_array($fasilitator->id, $assignedFasilitatorIds);
                            ?>
                            <label x-data="{ checked: <?php echo e($isChecked ? 'true' : 'false'); ?> }"
                                   :class="checked ? 'border-primary bg-primary/5 ring-2 ring-primary/10 shadow-md' : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50/50 bg-white'"
                                   class="relative flex flex-col p-5 rounded-3xl border transition-all cursor-pointer select-none group w-full text-center">
                                
                                
                                <div class="absolute top-4 right-4 z-10">
                                    <input type="checkbox" name="facilitators[]" value="<?php echo e($fasilitator->id); ?>"
                                           @change="checked = $el.checked"
                                           <?php if($isChecked): ?> checked <?php endif; ?>
                                           class="w-5 h-5 text-primary focus:ring-primary/20 rounded-lg border-gray-300 cursor-pointer transition-all">
                                </div>
                                
                                
                                <div class="w-full aspect-square rounded-2xl overflow-hidden mb-4 bg-slate-50 flex items-center justify-center border border-gray-100 shrink-0">
                                    <?php if($fasilitator->foto_url): ?>
                                        <img src="<?php echo e($fasilitator->foto_url); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    <?php else: ?>
                                        <div :class="checked ? 'bg-primary/10 text-primary' : 'bg-slate-100 text-slate-400'" 
                                             class="w-full h-full flex items-center justify-center transition-colors">
                                            <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                
                                <div class="min-w-0">
                                    <span class="block text-sm font-bold text-gray-800 truncate group-hover:text-primary transition-colors" x-text="'<?php echo e(addslashes($fasilitator->name)); ?>'"></span>
                                    <div class="flex flex-col gap-0.5 mt-1 items-center">
                                        <span class="text-[10px] text-gray-400 truncate max-w-full px-2" x-text="'<?php echo e(addslashes($fasilitator->email)); ?>'"></span>
                                    </div>
                                </div>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12 text-gray-400 border-2 border-dashed border-gray-150 rounded-2xl bg-gray-50/30">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p class="text-sm font-semibold text-gray-600">Belum ada user Fasilitator</p>
                        <p class="text-xs text-gray-400 mt-1">Belum ada user dengan role <strong>Fasilitator</strong> di dalam sistem.</p>
                    </div>
                <?php endif; ?>

                <div class="flex justify-end pt-5 border-t border-gray-100 mt-6">
                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'primary','class' => 'px-6 py-3 font-semibold shadow-md hover:scale-[1.01] active:scale-95 transition-all']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'primary','class' => 'px-6 py-3 font-semibold shadow-md hover:scale-[1.01] active:scale-95 transition-all']); ?>
                        Simpan Penugasan Fasilitator
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
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/admin/events/partials/tab-fasilitator.blade.php ENDPATH**/ ?>