<?php $__env->startSection('title', 'Kelola Fasilitator — ARQAM'); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Kelola Fasilitator','subtitle' => 'Buat dan kelola akun fasilitator yang dapat mengelola event.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Kelola Fasilitator','subtitle' => 'Buat dan kelola akun fasilitator yang dapat mengelola event.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>

    
    <?php if(session('success')): ?>
        <div class="mb-4 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">
            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="mb-4 flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3"
         x-data="{ showAddModal: <?php echo e($errors->any() ? 'true' : 'false'); ?>, showResetModal: false, resetFasId: null, resetFasName: '' }">

        
        <form method="GET" action="<?php echo e(route('admin.fasilitator.index')); ?>" class="flex items-center gap-2 w-full sm:w-auto">
            <div class="relative flex-1 sm:flex-none">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                    placeholder="Cari nama, email, username..."
                    class="w-full sm:w-72 pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'primary']); ?>Cari <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
            <?php if(request()->filled('search')): ?>
                <a href="<?php echo e(route('admin.fasilitator.index')); ?>" class="text-xs text-gray-500 hover:text-red-500 underline transition-colors">Reset</a>
            <?php endif; ?>
        </form>

        
        <button type="button" @click="showAddModal = true"
            class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-all shadow-sm hover:shadow-md active:scale-95 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Fasilitator
        </button>

        
        
        
        <div x-show="showAddModal" x-cloak class="fixed inset-0 z-[80] overflow-y-auto" style="display:none;">
            <div x-show="showAddModal"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showAddModal = false"
                 class="fixed inset-0 bg-black/40 backdrop-blur-sm"></div>

            <div class="flex min-h-full items-center justify-center p-4">
                <div x-show="showAddModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     @click.outside="showAddModal = false"
                     class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">

                    
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-primary/5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 font-heading">Tambah Fasilitator Baru</h3>
                        </div>
                        <button @click="showAddModal = false"
                                class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    
                    <form method="POST" action="<?php echo e(route('admin.fasilitator.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="px-6 py-5 space-y-4">

                            
                            <?php if($errors->any()): ?>
                                <div class="p-3 bg-red-50 border border-red-200 rounded-xl">
                                    <ul class="text-xs text-red-700 space-y-1 list-disc list-inside">
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($err); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required
                                    placeholder="Contoh: Ahmad Fauzi, S.Pd."
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="<?php echo e(old('email')); ?>" required
                                    placeholder="fasilitator@example.com"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Username <span class="text-red-500">*</span></label>
                                <input type="text" name="username" value="<?php echo e(old('username')); ?>" required
                                    placeholder="fas_ahmad (huruf, angka, - atau _)"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-mono">
                                <p class="mt-1 text-[10px] text-gray-400">Digunakan untuk login. Hanya huruf, angka, strip, dan garis bawah.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Foto Profil (Maks. 2MB, otomatis dipotong 1x1)</label>
                                <div x-data="{ 
                                    previewUrl: '', 
                                    warning: '',
                                    handleFile(e) {
                                        const file = e.target.files[0];
                                        if (!file) return;
                                        if (file.size > 2 * 1024 * 1024) {
                                            this.warning = 'Ukuran berkas melebihi 2MB! Silakan pilih berkas yang lebih kecil atau kurangi ukurannya.';
                                            this.previewUrl = '';
                                            e.target.value = '';
                                            document.getElementById('cropped_foto_input').value = '';
                                            return;
                                        }
                                        this.warning = '';
                                        
                                        const reader = new FileReader();
                                        reader.onload = (event) => {
                                            const img = new Image();
                                            img.onload = () => {
                                                const canvas = document.createElement('canvas');
                                                const size = Math.min(img.width, img.height);
                                                canvas.width = size;
                                                canvas.height = size;
                                                const ctx = canvas.getContext('2d');
                                                ctx.drawImage(img, (img.width - size) / 2, (img.height - size) / 2, size, size, 0, 0, size, size);
                                                const croppedDataUrl = canvas.toDataURL('image/jpeg');
                                                this.previewUrl = croppedDataUrl;
                                                document.getElementById('cropped_foto_input').value = croppedDataUrl;
                                            };
                                            img.src = event.target.result;
                                        };
                                        reader.readAsDataURL(file);
                                    }
                                }">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center overflow-hidden shrink-0">
                                            <template x-if="previewUrl">
                                                <img :src="previewUrl" class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="!previewUrl">
                                                <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </template>
                                        </div>
                                        <div class="flex-1">
                                            <input type="file" accept="image/*" @change="handleFile($event)"
                                                   class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                                        </div>
                                    </div>
                                    <p x-show="warning" class="mt-2 text-xs font-semibold text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-100" x-text="warning" x-cloak></p>
                                    <input type="hidden" name="cropped_foto" id="cropped_foto_input">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password" required minlength="6"
                                        placeholder="Min. 6 karakter"
                                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password_confirmation" required minlength="6"
                                        placeholder="Ulangi password"
                                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                                </div>
                            </div>

                        </div>

                        
                        <div class="px-6 py-4 bg-gray-50/60 border-t border-gray-100 flex items-center justify-end gap-3">
                            <button type="button" @click="showAddModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 rounded-xl hover:bg-gray-100 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-all shadow-sm active:scale-95">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        
        
        <div x-show="showResetModal" x-cloak class="fixed inset-0 z-[80] overflow-y-auto" style="display:none;">
            <div x-show="showResetModal"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 @click="showResetModal = false"
                 class="fixed inset-0 bg-black/40 backdrop-blur-sm"></div>

            <div class="flex min-h-full items-center justify-center p-4">
                <div x-show="showResetModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     @click.outside="showResetModal = false"
                     class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">

                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-amber-50/60">
                        <h3 class="text-base font-semibold text-amber-800 font-heading">Reset Password Fasilitator</h3>
                        <button @click="showResetModal = false"
                                class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors text-gray-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" :action="'/admin/fasilitator/' + resetFasId + '/reset-password'">
                        <?php echo csrf_field(); ?>
                        <div class="px-6 py-5 space-y-4">
                            <p class="text-sm text-gray-600">
                                Reset password untuk: <span class="font-semibold text-gray-800" x-text="resetFasName"></span>
                            </p>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Password Baru <span class="text-red-500">*</span></label>
                                <input type="password" name="password" required minlength="6"
                                    placeholder="Min. 6 karakter"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-300/50 focus:border-amber-400 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" required minlength="6"
                                    placeholder="Ulangi password baru"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-300/50 focus:border-amber-400 outline-none transition-all">
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50/60 border-t border-gray-100 flex items-center justify-end gap-3">
                            <button type="button" @click="showResetModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 rounded-xl hover:bg-gray-100 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white text-sm font-semibold rounded-xl hover:bg-amber-600 transition-all shadow-sm active:scale-95">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        
        
        
    </div>

    
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden"
         x-data="{ showResetModal: false, resetFasId: null, resetFasName: '' }">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold text-gray-600">Fasilitator</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Username</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-center">Event Ditugaskan</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-center">Dibuat</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $fasilitators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50/50 transition-colors group">

                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full overflow-hidden bg-primary/10 flex items-center justify-center flex-shrink-0 ring-2 ring-primary/5">
                                    <?php if($fas->foto_url): ?>
                                        <img src="<?php echo e($fas->foto_url); ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <span class="text-xs font-bold text-primary"><?php echo e(strtoupper(substr($fas->name, 0, 2))); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800"><?php echo e($fas->name); ?></p>
                                    <p class="text-xs text-gray-400"><?php echo e($fas->email); ?></p>
                                </div>
                            </div>
                        </td>

                        
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-gray-100 text-gray-600 font-mono text-xs">
                                <?php echo e($fas->username); ?>

                            </span>
                        </td>

                        
                        <td class="px-6 py-4 text-center">
                            <?php if($fas->assigned_events_count > 0): ?>
                                <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-primary/10 text-primary">
                                    <?php echo e($fas->assigned_events_count); ?> event
                                </span>
                            <?php else: ?>
                                <span class="text-xs text-gray-400 italic">Belum ditugaskan</span>
                            <?php endif; ?>
                        </td>

                        
                        <td class="px-6 py-4 text-center text-gray-500 text-xs">
                            <?php echo e($fas->created_at->format('d M Y')); ?>

                        </td>

                        
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                
                                <a href="<?php echo e(route('admin.fasilitator.show', $fas->id)); ?>"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary/5 text-primary hover:bg-primary hover:text-white rounded-lg text-xs font-bold transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </a>

                                
                                <button type="button"
                                    @click="showResetModal = true; resetFasId = <?php echo e($fas->id); ?>; resetFasName = '<?php echo e(addslashes($fas->name)); ?>'"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-100 rounded-lg text-xs font-bold transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                    Reset Password
                                </button>

                                
                                <form method="POST" action="<?php echo e(route('admin.fasilitator.destroy', $fas->id)); ?>"
                                      onsubmit="return confirm('Hapus fasilitator \'<?php echo e(addslashes($fas->name)); ?>\'? Semua penugasan event-nya akan ikut dihapus.')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 hover:bg-red-600 hover:text-white rounded-lg text-xs font-bold transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-500">Belum ada fasilitator</p>
                                <p class="text-xs text-gray-400">Klik tombol "Tambah Fasilitator" untuk membuat akun baru.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($fasilitators->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            <?php echo e($fasilitators->links()); ?>

        </div>
        <?php endif; ?>

        
        <div x-show="showResetModal" x-cloak class="fixed inset-0 z-[80] overflow-y-auto" style="display:none;">
            <div x-show="showResetModal"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 @click="showResetModal = false"
                 class="fixed inset-0 bg-black/40 backdrop-blur-sm"></div>

            <div class="flex min-h-full items-center justify-center p-4">
                <div x-show="showResetModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     @click.outside="showResetModal = false"
                     class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">

                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-amber-50/60">
                        <h3 class="text-base font-semibold text-amber-800 font-heading">Reset Password Fasilitator</h3>
                        <button @click="showResetModal = false"
                                class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors text-gray-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form method="POST" :action="'/admin/fasilitator/' + resetFasId + '/reset-password'">
                        <?php echo csrf_field(); ?>
                        <div class="px-6 py-5 space-y-4">
                            <p class="text-sm text-gray-600">
                                Reset password untuk: <span class="font-semibold text-gray-800" x-text="resetFasName"></span>
                            </p>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Password Baru <span class="text-red-500">*</span></label>
                                <input type="password" name="password" required minlength="6"
                                    placeholder="Min. 6 karakter"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-300/50 focus:border-amber-400 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" required minlength="6"
                                    placeholder="Ulangi password baru"
                                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-300/50 focus:border-amber-400 outline-none transition-all">
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50/60 border-t border-gray-100 flex items-center justify-end gap-3">
                            <button type="button" @click="showResetModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 rounded-xl hover:bg-gray-100 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white text-sm font-semibold rounded-xl hover:bg-amber-600 transition-all shadow-sm active:scale-95">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/admin/fasilitator/index.blade.php ENDPATH**/ ?>