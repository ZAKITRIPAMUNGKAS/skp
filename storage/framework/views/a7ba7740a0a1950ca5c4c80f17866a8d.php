
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'loading' => false,
    'disabled' => false,
    'icon' => null,
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
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'loading' => false,
    'disabled' => false,
    'icon' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed gap-2';

    $variants = [
        'primary' => 'bg-primary text-white hover:bg-primary-600 focus:ring-primary/40 shadow-sm hover:shadow-md active:scale-[0.98]',
        'secondary' => 'bg-secondary text-white hover:bg-secondary-600 focus:ring-secondary/40 shadow-sm hover:shadow-md active:scale-[0.98]',
        'accent' => 'bg-accent text-white hover:bg-accent-500 focus:ring-accent/40 shadow-sm hover:shadow-md active:scale-[0.98]',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-400 shadow-sm hover:shadow-md active:scale-[0.98]',
        'ghost' => 'bg-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-800 focus:ring-gray-300',
        'outline' => 'border-2 border-primary text-primary hover:bg-primary hover:text-white focus:ring-primary/40',
        'outline-danger' => 'border-2 border-red-300 text-red-600 hover:bg-red-600 hover:text-white hover:border-red-600 focus:ring-red-400',
    ];

    $sizes = [
        'xs' => 'text-xs px-2.5 py-1.5',
        'sm' => 'text-sm px-3.5 py-2',
        'md' => 'text-sm px-5 py-2.5',
        'lg' => 'text-base px-6 py-3',
        'xl' => 'text-base px-8 py-3.5',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
?>

<?php if($href): ?>
    <a href="<?php echo e($href); ?>"
       <?php echo e($attributes->merge(['class' => $classes])); ?>>
        <?php if($icon): ?>
            <span class="w-4 h-4"><?php echo $icon; ?></span>
        <?php endif; ?>
        <?php echo e($slot); ?>

    </a>
<?php else: ?>
    <button type="<?php echo e($type); ?>"
            <?php echo e($disabled ? 'disabled' : ''); ?>

            <?php echo e($attributes->merge(['class' => $classes])); ?>

            <?php if($loading): ?> x-data="{ loading: false }" @click="loading = true" :disabled="loading" <?php endif; ?>>
        <?php if($loading): ?>
            <svg x-show="loading" class="animate-spin -ml-1 w-4 h-4" fill="none" viewBox="0 0 24 24" style="display:none">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        <?php endif; ?>
        <?php if($icon): ?>
            <span class="w-4 h-4" <?php if($loading): ?> x-show="!loading" <?php endif; ?>><?php echo $icon; ?></span>
        <?php endif; ?>
        <span <?php if($loading): ?> x-show="!loading" <?php endif; ?>><?php echo e($slot); ?></span>
        <?php if($loading): ?>
            <span x-show="loading" style="display:none">Memproses...</span>
        <?php endif; ?>
    </button>
<?php endif; ?>
<?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/components/button.blade.php ENDPATH**/ ?>