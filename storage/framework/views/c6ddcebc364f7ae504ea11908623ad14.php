<?php $__env->startSection('title', 'Lupa Password — ARQAM App'); ?>

<?php $__env->startSection('content'); ?>
<style>
    body { background-color: #f8fafc; }

    :root {
        --premium-ease: cubic-bezier(0.65, 0, 0.076, 1);
    }

    .card-wrapper {
        animation: cardEntrance 0.9s var(--premium-ease) forwards;
        opacity: 0;
        transform: translateY(28px) scale(0.97);
    }

    @keyframes cardEntrance {
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    @keyframes floatY {
        0%, 100% { transform: translateY(0px); }
        50%       { transform: translateY(-10px); }
    }

    .animate-float { animation: floatY 4s ease-in-out infinite; }

    [x-cloak] { display: none !important; }
</style>

<div class="min-h-screen flex items-center justify-center p-4 lg:p-8 bg-gray-50/50">

    
    <div class="absolute top-4 left-4 z-50">
        <a href="<?php echo e(route('landing')); ?>"
           class="group flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-md border border-gray-100 rounded-full text-xs font-bold text-gray-500 hover:text-primary transition-all active:scale-95 shadow-sm">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Beranda
        </a>
    </div>

    
    <div class="card-wrapper w-full max-w-4xl">
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-primary/10 overflow-hidden flex flex-col lg:flex-row min-h-[560px]">

            
            <div class="relative lg:w-5/12 bg-gradient-to-br from-[#06293F] via-[#1A6D9B] to-[#155C84] flex flex-col items-center justify-center px-10 py-14 overflow-hidden">

                
                <div class="absolute top-[-15%] left-[-15%] w-[55%] h-[55%] bg-white/10 rounded-full blur-3xl animate-pulse pointer-events-none"></div>
                <div class="absolute bottom-[-15%] right-[-15%] w-[65%] h-[65%] bg-accent/20 rounded-full blur-3xl animate-pulse pointer-events-none" style="animation-delay:2s"></div>

                
                <div class="relative z-10 w-52 h-52 mb-6 animate-float">
                    <img src="<?php echo e(asset('images/arka/arka_fokus.png')); ?>" alt="Arka Fokus"
                         class="w-full h-full object-contain filter drop-shadow-2xl">
                </div>

                <h2 class="font-heading font-bold text-3xl text-white text-center leading-tight mb-3 tracking-tight relative z-10">
                    Lupa Password?
                </h2>
                <p class="text-white/75 text-sm text-center leading-relaxed relative z-10 max-w-[230px]">
                    Jangan khawatir! Hubungi Fasilitator Anda untuk memulihkan akses akun.
                </p>

                
                <div class="absolute bottom-8 left-0 right-0 flex justify-center gap-2 z-10">
                    <span class="w-6 h-1.5 bg-white/60 rounded-full"></span>
                    <span class="w-2 h-1.5 bg-white/30 rounded-full"></span>
                    <span class="w-2 h-1.5 bg-white/30 rounded-full"></span>
                </div>
            </div>

            
            <div class="lg:w-7/12 flex items-center justify-center p-8 lg:px-14">
                <div class="w-full max-w-md text-center">

                    
                    <div class="w-24 h-24 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>

                    
                    <h1 class="font-heading font-bold text-2xl lg:text-3xl text-gray-800 leading-tight mb-4">
                        Akses Akun Terkunci
                    </h1>
                    <p class="text-gray-500 leading-relaxed mb-8">
                        Demi menjaga keamanan data, proses pengaturan ulang (reset) password hanya dapat dilakukan melalui <strong>Fasilitator</strong> kelompok Anda atau <strong>Administrator</strong>. <br><br> Silakan hubungi mereka secara langsung untuk meminta akses kembali ke akun Anda.
                    </p>

                    
                    <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary-600 text-white font-bold py-4 px-8 rounded-2xl transition-all shadow-lg shadow-primary/25 active:scale-[0.98] text-sm w-full">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Halaman Login
                    </a>

                </div>
            </div>
            

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>