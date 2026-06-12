
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => 'Belum ada data',
    'description' => 'Data yang Anda cari belum tersedia.',
    'actionLabel' => null,
    'actionUrl' => null,
    'icon' => 'default',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title' => 'Belum ada data',
    'description' => 'Data yang Anda cari belum tersedia.',
    'actionLabel' => null,
    'actionUrl' => null,
    'icon' => 'default',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->merge(['class' => 'flex flex-col items-center justify-center py-12 px-6'])); ?>>
    
    <div class="w-32 h-32 mb-6 text-gray-200">
        <?php if($icon === 'search'): ?>
            <svg viewBox="0 0 128 128" fill="none" class="w-full h-full">
                <circle cx="52" cy="52" r="36" stroke="currentColor" stroke-width="4" />
                <line x1="78" y1="78" x2="110" y2="110" stroke="currentColor" stroke-width="6" stroke-linecap="round" />
                <circle cx="52" cy="52" r="20" stroke="currentColor" stroke-width="2" opacity="0.4" />
            </svg>
        <?php elseif($icon === 'document'): ?>
            <svg viewBox="0 0 128 128" fill="none" class="w-full h-full">
                <rect x="24" y="12" width="80" height="104" rx="8" stroke="currentColor" stroke-width="4" />
                <line x1="42" y1="40" x2="86" y2="40" stroke="currentColor" stroke-width="3" stroke-linecap="round" opacity="0.5" />
                <line x1="42" y1="56" x2="76" y2="56" stroke="currentColor" stroke-width="3" stroke-linecap="round" opacity="0.4" />
                <line x1="42" y1="72" x2="66" y2="72" stroke="currentColor" stroke-width="3" stroke-linecap="round" opacity="0.3" />
                <rect x="42" y="84" width="44" height="16" rx="4" stroke="currentColor" stroke-width="2" opacity="0.3" />
            </svg>
        <?php elseif($icon === 'people'): ?>
            <svg viewBox="0 0 128 128" fill="none" class="w-full h-full">
                <circle cx="64" cy="40" r="18" stroke="currentColor" stroke-width="4" />
                <path d="M28 108c0-19.882 16.118-36 36-36s36 16.118 36 36" stroke="currentColor" stroke-width="4" stroke-linecap="round" />
                <circle cx="96" cy="36" r="12" stroke="currentColor" stroke-width="3" opacity="0.4" />
                <path d="M82 100c4-12 14-18 14-18" stroke="currentColor" stroke-width="3" stroke-linecap="round" opacity="0.3" />
            </svg>
        <?php else: ?>
            <svg viewBox="0 0 128 128" fill="none" class="w-full h-full">
                <rect x="20" y="28" width="88" height="72" rx="8" stroke="currentColor" stroke-width="4" />
                <path d="M20 48h88" stroke="currentColor" stroke-width="3" opacity="0.4" />
                <circle cx="36" cy="38" r="4" fill="currentColor" opacity="0.3" />
                <circle cx="50" cy="38" r="4" fill="currentColor" opacity="0.3" />
                <circle cx="64" cy="38" r="4" fill="currentColor" opacity="0.3" />
                <rect x="36" y="60" width="56" height="4" rx="2" fill="currentColor" opacity="0.2" />
                <rect x="36" y="72" width="40" height="4" rx="2" fill="currentColor" opacity="0.15" />
                <rect x="36" y="84" width="24" height="4" rx="2" fill="currentColor" opacity="0.1" />
            </svg>
        <?php endif; ?>
    </div>

    
    <h3 class="text-lg font-semibold text-gray-600 font-heading mb-2"><?php echo e($title); ?></h3>
    <p class="text-sm text-gray-400 text-center max-w-sm mb-6"><?php echo e($description); ?></p>

    
    <?php if($actionLabel): ?>
        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['variant' => 'primary','href' => $actionUrl]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actionUrl)]); ?>
            <svg class="w-4 h-4 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <?php echo e($actionLabel); ?>

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
    <?php endif; ?>

    <?php echo e($slot); ?>

</div>
<?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/components/empty-state.blade.php ENDPATH**/ ?>