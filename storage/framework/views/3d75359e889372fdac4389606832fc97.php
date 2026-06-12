
<?php
    $user = auth()->user();
    $isAdmin = $user && $user->isAdmin();
    $isFasilitator = $user && $user->isFasilitator();
    $currentRoute = request()->route() ? request()->route()->getName() : '';
?>


<aside class="fixed inset-y-0 left-0 z-40 bg-primary text-white transition-sidebar hidden lg:flex flex-col w-64"
       :class="sidebarCollapsed ? 'w-20' : 'w-64'">

    
    <div class="flex items-center h-16 px-4 border-b border-gray-150 bg-white">
        <div class="flex items-center gap-3 overflow-hidden w-full justify-center">
            <img src="<?php echo e(asset('logo.webp')); ?>" alt="Logo" class="h-12 object-contain transition-all duration-300" :class="sidebarCollapsed ? 'w-10 h-10' : 'w-auto max-w-[150px]'">
        </div>
    </div>

    
    <nav class="flex-1 overflow-y-auto sidebar-scroll py-4 px-3">
        <div x-show="!sidebarCollapsed" class="px-3 mb-2">
            <span class="text-[10px] font-semibold uppercase tracking-widest text-white/40">Menu Utama</span>
        </div>

        <?php if($isAdmin || $isFasilitator): ?>
            <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'dashboard','label' => 'Dashboard','route' => 'admin.dashboard','collapsed' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'dashboard','label' => 'Dashboard','route' => 'admin.dashboard','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
            <div x-show="!sidebarCollapsed" class="px-3 mt-5 mb-2">
                <span class="text-[10px] font-semibold uppercase tracking-widest text-white/40">Kelola</span>
            </div>
            <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'event','label' => 'Kelola Event','route' => 'admin.events.index','collapsed' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'event','label' => 'Kelola Event','route' => 'admin.events.index','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'quiz','label' => 'Bank Soal','route' => 'admin.soal.index','collapsed' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'quiz','label' => 'Bank Soal','route' => 'admin.soal.index','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
            
            <?php if($isAdmin): ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'people','label' => 'Kelola Peserta','route' => 'admin.participants.index','collapsed' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'people','label' => 'Kelola Peserta','route' => 'admin.participants.index','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'fasilitator','label' => 'Kelola Fasilitator','route' => 'admin.fasilitator.index','collapsed' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'fasilitator','label' => 'Kelola Fasilitator','route' => 'admin.fasilitator.index','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'image','label' => 'Galeri Pelatihan','route' => 'admin.galleries.index','collapsed' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'image','label' => 'Galeri Pelatihan','route' => 'admin.galleries.index','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'comment','label' => 'Testimoni','route' => 'admin.testimonials.index','collapsed' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'comment','label' => 'Testimoni','route' => 'admin.testimonials.index','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>

                <div x-show="!sidebarCollapsed" class="px-3 mt-5 mb-2">
                    <span class="text-[10px] font-semibold uppercase tracking-widest text-white/40">Sistem</span>
                </div>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'logs','label' => 'Log Aktivitas','route' => 'admin.logs.index','collapsed' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'logs','label' => 'Log Aktivitas','route' => 'admin.logs.index','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
            <?php endif; ?>
        <?php else: ?>
            
            <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'dashboard','label' => 'Dashboard','route' => 'peserta.dashboard','collapsed' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'dashboard','label' => 'Dashboard','route' => 'peserta.dashboard','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'event','label' => 'Jadwal Sesi','route' => 'peserta.jadwal','collapsed' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'event','label' => 'Jadwal Sesi','route' => 'peserta.jadwal','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'quiz','label' => 'Pretest / Posttest','route' => 'peserta.tes.index','collapsed' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'quiz','label' => 'Pretest / Posttest','route' => 'peserta.tes.index','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'affective','label' => 'Evaluasi Afektif','route' => 'peserta.afektif.index_root','collapsed' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'affective','label' => 'Evaluasi Afektif','route' => 'peserta.afektif.index_root','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'attendance','label' => 'Kehadiran','route' => 'peserta.kehadiran','collapsed' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'attendance','label' => 'Kehadiran','route' => 'peserta.kehadiran','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'survey','label' => 'Kuisioner','route' => 'peserta.angket.index_root','collapsed' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'survey','label' => 'Kuisioner','route' => 'peserta.angket.index_root','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'ranking','label' => 'Hasil Penilaian','route' => 'peserta.hasil','collapsed' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'ranking','label' => 'Hasil Penilaian','route' => 'peserta.hasil','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
        <?php endif; ?>
    </nav>

    
    <div class="border-t border-white/10 p-3">
        <div class="flex items-center gap-3 px-2 py-2 rounded-xl hover:bg-white/10 transition-colors cursor-pointer"
             x-data="{ showMenu: false }" @click="showMenu = !showMenu">
            <div class="w-9 h-9 rounded-full bg-accent/30 flex items-center justify-center flex-shrink-0 ring-2 ring-accent/50 overflow-hidden">
                <?php if(auth()->user()->foto): ?>
                    <img src="<?php echo e(auth()->user()->foto_url); ?>" referrerpolicy="no-referrer" class="w-full h-full object-cover">
                <?php elseif(auth()->user()->peserta && auth()->user()->peserta->foto): ?>
                    <img src="<?php echo e(auth()->user()->peserta->foto_url); ?>" referrerpolicy="no-referrer" class="w-full h-full object-cover">
                <?php else: ?>
                    <svg class="w-5 h-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                <?php endif; ?>
            </div>
            <div x-show="!sidebarCollapsed" x-transition class="flex-1 overflow-hidden">
                <p class="text-sm font-medium truncate"><?php echo e(auth()->check() ? auth()->user()->name : 'Guest'); ?></p>
                <p class="text-xs text-white/50 capitalize"><?php echo e(auth()->check() ? auth()->user()->role : ''); ?></p>
            </div>
            <svg x-show="!sidebarCollapsed" class="w-4 h-4 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01" />
            </svg>
        </div>
    </div>

    
    <button @click="sidebarCollapsed = !sidebarCollapsed"
            class="absolute -right-3 top-20 w-6 h-6 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-gray-50 transition-colors border border-gray-200 group">
        <svg class="w-3.5 h-3.5 text-gray-500 transition-transform duration-300"
             :class="sidebarCollapsed ? 'rotate-180' : ''"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>
</aside>


<aside class="fixed inset-y-0 left-0 z-50 w-72 bg-primary text-white flex flex-col lg:hidden transform transition-transform duration-300 -translate-x-full"
       :class="mobileMenu ? 'translate-x-0' : '-translate-x-full'">

    
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-150 bg-white text-gray-800">
        <div class="flex items-center justify-center w-full">
            <img src="<?php echo e(asset('logo.webp')); ?>" alt="Logo" class="h-12 object-contain">
        </div>
        <button @click="mobileMenu = false" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors">
            <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    
    <?php if($isAdmin || $isFasilitator): ?>
    <nav class="flex-1 overflow-y-auto sidebar-scroll py-4 px-3">
        <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'dashboard','label' => 'Dashboard','route' => 'admin.dashboard','collapsed' => false,'mobile' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'dashboard','label' => 'Dashboard','route' => 'admin.dashboard','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mobile' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
        <div class="px-3 mt-5 mb-2"><span class="text-[10px] font-semibold uppercase tracking-widest text-white/40">Kelola</span></div>
        <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'event','label' => 'Kelola Event','route' => 'admin.events.index','collapsed' => false,'mobile' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'event','label' => 'Kelola Event','route' => 'admin.events.index','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mobile' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'quiz','label' => 'Bank Soal','route' => 'admin.soal.index','collapsed' => false,'mobile' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'quiz','label' => 'Bank Soal','route' => 'admin.soal.index','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mobile' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
        <?php if($isAdmin): ?>
            <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'people','label' => 'Kelola Peserta','route' => 'admin.participants.index','collapsed' => false,'mobile' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'people','label' => 'Kelola Peserta','route' => 'admin.participants.index','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mobile' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'fasilitator','label' => 'Kelola Fasilitator','route' => 'admin.fasilitator.index','collapsed' => false,'mobile' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'fasilitator','label' => 'Kelola Fasilitator','route' => 'admin.fasilitator.index','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mobile' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'image','label' => 'Galeri Pelatihan','route' => 'admin.galleries.index','collapsed' => false,'mobile' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'image','label' => 'Galeri Pelatihan','route' => 'admin.galleries.index','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mobile' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'comment','label' => 'Testimoni','route' => 'admin.testimonials.index','collapsed' => false,'mobile' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'comment','label' => 'Testimoni','route' => 'admin.testimonials.index','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mobile' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
            <div class="px-3 mt-5 mb-2"><span class="text-[10px] font-semibold uppercase tracking-widest text-white/40">Sistem</span></div>
            <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['icon' => 'logs','label' => 'Log Aktivitas','route' => 'admin.logs.index','collapsed' => false,'mobile' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'logs','label' => 'Log Aktivitas','route' => 'admin.logs.index','collapsed' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'mobile' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
        <?php endif; ?>
    </nav>
    <?php else: ?>
    <nav class="flex-1 overflow-y-auto sidebar-scroll py-4 px-3 flex flex-col items-center justify-center text-center opacity-50 p-6">
        <svg class="w-12 h-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
        <p class="text-sm">Silakan gunakan navigasi di bagian bawah layar.</p>
    </nav>
    <?php endif; ?>

    
    <div class="border-t border-white/10 p-4">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-full bg-accent/30 flex items-center justify-center ring-2 ring-accent/50 overflow-hidden">
                <?php if(auth()->user()->foto): ?>
                    <img src="<?php echo e(auth()->user()->foto_url); ?>" referrerpolicy="no-referrer" class="w-full h-full object-cover">
                <?php elseif(auth()->user()->peserta && auth()->user()->peserta->foto): ?>
                    <img src="<?php echo e(auth()->user()->peserta->foto_url); ?>" referrerpolicy="no-referrer" class="w-full h-full object-cover">
                <?php else: ?>
                    <svg class="w-5 h-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                <?php endif; ?>
            </div>
            <div>
                <p class="text-sm font-medium"><?php echo e(auth()->check() ? auth()->user()->name : 'Guest'); ?></p>
                <p class="text-xs text-white/50 capitalize"><?php echo e(auth()->check() ? auth()->user()->role : ''); ?></p>
            </div>
        </div>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-white/10 text-white/70 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </button>
        </form>
    </div>
</aside>
<?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/components/sidebar.blade.php ENDPATH**/ ?>