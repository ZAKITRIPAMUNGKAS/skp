
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'value' => '0',
    'label' => '',
    'icon' => null,
    'iconBg' => 'bg-primary/10',
    'iconColor' => 'text-primary',
    'change' => null,
    'changeType' => 'up',
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
    'value' => '0',
    'label' => '',
    'icon' => null,
    'iconBg' => 'bg-primary/10',
    'iconColor' => 'text-primary',
    'change' => null,
    'changeType' => 'up',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="bg-white rounded-2xl shadow-card border border-gray-100 p-6 hover:shadow-card-hover transition-all duration-200 group">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-500 mb-1"><?php echo e($label); ?></p>
            <p class="text-3xl font-bold text-gray-800 font-heading tracking-tight"><?php echo e($value); ?></p>

            <?php if($change): ?>
                <div class="flex items-center gap-1.5 mt-2">
                    <?php if($changeType === 'up'): ?>
                        <span class="inline-flex items-center gap-0.5 text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                            <?php echo e($change); ?>

                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-0.5 text-xs font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                            </svg>
                            <?php echo e($change); ?>

                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if($icon): ?>
            <div class="w-12 h-12 <?php echo e($iconBg); ?> rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                <?php echo $icon; ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/components/stat-widget.blade.php ENDPATH**/ ?>