<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'ARQAM App'); ?> — Sistem Evaluasi Baitul Arqam</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('Logoums.png')); ?>">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#1A6D9B', 400: '#2589B8', 500: '#1A6D9B', 600: '#155C84' },
                        secondary: { DEFAULT: '#2589B8' },
                        accent: { DEFAULT: '#D4A017' },
                    },
                    fontFamily: {
                        heading: ['Poppins', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Poppins', sans-serif; }
    </style>
    <?php echo $__env->yieldContent('head_extra'); ?>
</head>
<body class="h-full font-body antialiased"
      x-data="{ loading: false }"
      x-on:page-loading.window="loading = true">
      
    
    <div x-show="loading" 
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-white z-[99999] flex flex-col items-center justify-center"
         style="display: none;">
        <div class="flex flex-col items-center gap-4">
            <div class="relative w-12 h-12">
                <div class="absolute inset-0 border-4 border-primary/20 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
            </div>
            <p class="text-xs font-semibold text-primary uppercase tracking-widest animate-pulse">Memuat Halaman...</p>
        </div>
    </div>

    <?php echo $__env->yieldContent('content'); ?>

    
    <script>
        window.addEventListener('beforeunload', function(e) {
            const activeEl = document.activeElement;
            if (activeEl && activeEl.tagName === 'A') {
                const href = activeEl.getAttribute('href');
                const target = activeEl.getAttribute('target');
                if (href && !href.startsWith('#') && !href.startsWith('javascript:') && target !== '_blank') {
                    window.dispatchEvent(new CustomEvent('page-loading'));
                }
            } else if (activeEl && (activeEl.tagName === 'BUTTON' || activeEl.getAttribute('type') === 'submit')) {
                window.dispatchEvent(new CustomEvent('page-loading'));
            }
        });
        
        document.addEventListener('submit', function() {
            window.dispatchEvent(new CustomEvent('page-loading'));
        });
    </script>
</body>
</html>
<?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/layouts/app.blade.php ENDPATH**/ ?>