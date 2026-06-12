
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'default',
    'size' => 'md',
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
    'type' => 'default',
    'size' => 'md',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $types = [
        'amat_baik' => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-emerald-600/10',
        'baik' => 'bg-blue-50 text-blue-700 border-blue-200 ring-blue-600/10',
        'cukup' => 'bg-amber-50 text-amber-700 border-amber-200 ring-amber-600/10',
        'kurang' => 'bg-red-50 text-red-700 border-red-200 ring-red-600/10',
        'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-emerald-600/10',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200 ring-amber-600/10',
        'danger' => 'bg-red-50 text-red-700 border-red-200 ring-red-600/10',
        'info' => 'bg-blue-50 text-blue-700 border-blue-200 ring-blue-600/10',
        'default' => 'bg-gray-50 text-gray-700 border-gray-200 ring-gray-600/10',
        'primary' => 'bg-primary-50 text-primary border-primary-200 ring-primary/10',
        'persiapan' => 'bg-gray-50 text-gray-600 border-gray-200 ring-gray-600/10',
        'berlangsung' => 'bg-blue-50 text-blue-700 border-blue-200 ring-blue-600/10',
        'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-emerald-600/10',
        'aktif' => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-emerald-600/10',
        'tutup' => 'bg-red-50 text-red-700 border-red-200 ring-red-600/10',
        'belum_buka' => 'bg-gray-50 text-gray-600 border-gray-200 ring-gray-600/10',
        'admin' => 'bg-purple-50 text-purple-700 border-purple-200 ring-purple-600/10',
        'peserta' => 'bg-teal-50 text-teal-700 border-teal-200 ring-teal-600/10',
    ];

    $sizes = [
        'xs' => 'text-[10px] px-1.5 py-0.5',
        'sm' => 'text-xs px-2 py-0.5',
        'md' => 'text-xs px-2.5 py-1',
        'lg' => 'text-sm px-3 py-1',
    ];

    $typeClass = $types[$type] ?? $types['default'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
?>

<span <?php echo e($attributes->merge(['class' => "inline-flex items-center font-medium rounded-full border ring-1 ring-inset $typeClass $sizeClass"])); ?>>
    <?php echo e($slot); ?>

</span>
<?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/components/badge.blade.php ENDPATH**/ ?>