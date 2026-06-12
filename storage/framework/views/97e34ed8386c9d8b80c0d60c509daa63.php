
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'padding' => 'p-6',
    'hover' => false,
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
    'padding' => 'p-6',
    'hover' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->merge([
    'class' => "bg-white rounded-2xl shadow-card border border-gray-100 overflow-hidden transition-all duration-200 " .
               ($hover ? 'hover:shadow-card-hover hover:-translate-y-0.5 cursor-pointer ' : '') .
               $padding
])); ?>>
    <?php if(isset($header)): ?>
        <div class="border-b border-gray-100 -mx-6 -mt-6 px-6 py-4 mb-6 bg-gray-50/50">
            <?php echo e($header); ?>

        </div>
    <?php endif; ?>

    <?php echo e($slot); ?>


    <?php if(isset($footer)): ?>
        <div class="border-t border-gray-100 -mx-6 -mb-6 px-6 py-4 mt-6 bg-gray-50/30">
            <?php echo e($footer); ?>

        </div>
    <?php endif; ?>
</div>
<?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/components/card.blade.php ENDPATH**/ ?>