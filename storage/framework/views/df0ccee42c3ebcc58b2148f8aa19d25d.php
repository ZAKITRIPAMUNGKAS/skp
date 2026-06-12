<?php $__env->startSection('title', 'Pengaturan Landing Page'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 font-heading">Pengaturan Landing Page</h1>
    </div>

    <?php if(session('success')): ?>
    <div class="bg-green-50 text-green-700 p-4 rounded-xl text-sm font-medium border border-green-200">
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.settings.landing.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>
        
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 space-y-6">
                <h3 class="text-lg font-bold text-gray-800 font-heading border-b border-gray-100 pb-3">Bagian Header (Gambar & Teks)</h3>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-4 md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Gambar Utama (Slider / Multiple)</label>
                        
                        <?php if(!empty($settings['landing_header_images'])): ?>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-4">
                                <?php $__currentLoopData = $settings['landing_header_images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="relative group rounded-lg overflow-hidden border border-gray-200">
                                        <img src="<?php echo e(asset('storage/' . $image)); ?>" class="w-full h-32 object-cover">
                                        <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
                                            <input type="checkbox" name="remove_images[]" value="<?php echo e($image); ?>" class="w-5 h-5 text-red-600 rounded border-gray-300 focus:ring-red-500">
                                            <span class="ml-2 text-white text-xs font-bold">Hapus</span>
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                        <input type="file" name="landing_header_images[]" accept="image/*" multiple class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm">
                        <p class="text-xs text-gray-500 mt-1">Anda dapat memilih lebih dari satu gambar (Multiple Select). Kosongkan jika tidak ingin menambah gambar.</p>
                        <?php $__errorArgs = ['landing_header_images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Alt Gambar Utama / Subtitle</label>
                        <input type="text" name="landing_header_subtitle" value="<?php echo e(old('landing_header_subtitle', $settings['landing_header_subtitle'])); ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" required>
                        <?php $__errorArgs = ['landing_header_subtitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Judul Teks Gambar Utama</label>
                        <input type="text" name="landing_header_title" value="<?php echo e(old('landing_header_title', $settings['landing_header_title'])); ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" required>
                        <?php $__errorArgs = ['landing_header_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 space-y-6">
                <h3 class="text-lg font-bold text-gray-800 font-heading border-b border-gray-100 pb-3">Bagian Tentang Aplikasi</h3>
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Label Section</label>
                    <input type="text" name="landing_about_subtitle" value="<?php echo e(old('landing_about_subtitle', $settings['landing_about_subtitle'])); ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" required>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Judul Utama</label>
                    <input type="text" name="landing_about_title" value="<?php echo e(old('landing_about_title', $settings['landing_about_title'])); ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" required>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Deskripsi Panjang (Dukung HTML/B tags)</label>
                    <textarea name="landing_about_description" rows="5" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" required><?php echo e(old('landing_about_description', $settings['landing_about_description'])); ?></textarea>
                    <p class="text-xs text-gray-500 mt-1">Anda dapat menggunakan tag <code>&lt;strong&gt;teks tebal&lt;/strong&gt;</code> untuk menebalkan tulisan.</p>
                </div>
                
                <div x-data="{
                        features: <?php echo e(json_encode(old('features', $features))); ?>,
                        addFeature() {
                            this.features.push({ title: '', description: '' });
                        },
                        removeFeature(index) {
                            this.features.splice(index, 1);
                        }
                    }" class="space-y-4 pt-4 border-t border-gray-100">
                    
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Daftar Fitur (01, 02, 03, dst)</label>
                        <button type="button" @click="addFeature()" class="px-3 py-1.5 bg-primary/10 text-primary text-xs font-bold rounded-lg hover:bg-primary/20 transition-colors">
                            + Tambah Fitur
                        </button>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(feature, index) in features" :key="index">
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 relative">
                                <button type="button" @click="removeFeature(index)" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                
                                <div class="space-y-3 pr-10">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Judul Fitur <span x-text="index + 1"></span></label>
                                        <input type="text" x-model="feature.title" :name="`features[${index}][title]`" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-1 focus:ring-primary" required>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Deskripsi Singkat</label>
                                        <textarea x-model="feature.description" :name="`features[${index}][description]`" rows="2" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-1 focus:ring-primary" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </template>
                        
                        <div x-show="features.length === 0" class="text-center py-6 bg-gray-50 border border-gray-200 border-dashed rounded-xl">
                            <p class="text-sm text-gray-500">Belum ada fitur ditambahkan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mt-6">
            <div class="p-6 space-y-6">
                <h3 class="text-lg font-bold text-gray-800 font-heading border-b border-gray-100 pb-3">Bagian Keunggulan Sistem</h3>
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Label Section</label>
                    <input type="text" name="landing_advantages_subtitle" value="<?php echo e(old('landing_advantages_subtitle', $settings['landing_advantages_subtitle'] ?? 'Keunggulan Sistem')); ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" required>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Judul Utama</label>
                    <input type="text" name="landing_advantages_title" value="<?php echo e(old('landing_advantages_title', $settings['landing_advantages_title'] ?? 'Fitur Unggulan Sistem ARQAM')); ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" required>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Deskripsi Singkat</label>
                    <textarea name="landing_advantages_description" rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm" required><?php echo e(old('landing_advantages_description', $settings['landing_advantages_description'] ?? 'Solusi praktis untuk mengelola pelatihan dengan akurasi penilaian yang didukung oleh sistem pendukung keputusan yang cerdas.')); ?></textarea>
                </div>
                
                <div x-data="{
                        advantages: <?php echo e(json_encode(old('advantages', $advantages))); ?>,
                        addAdvantage() {
                            this.advantages.push({ title: '', description: '' });
                        },
                        removeAdvantage(index) {
                            this.advantages.splice(index, 1);
                        }
                    }" class="space-y-4 pt-4 border-t border-gray-100">
                    
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Daftar Keunggulan</label>
                        <button type="button" @click="addAdvantage()" class="px-3 py-1.5 bg-primary/10 text-primary text-xs font-bold rounded-lg hover:bg-primary/20 transition-colors">
                            + Tambah Keunggulan
                        </button>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(advantage, index) in advantages" :key="index">
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 relative">
                                <button type="button" @click="removeAdvantage(index)" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                
                                <div class="space-y-3 pr-10">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Judul Keunggulan <span x-text="index + 1"></span></label>
                                        <input type="text" x-model="advantage.title" :name="`advantages[${index}][title]`" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-1 focus:ring-primary" required>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Deskripsi Singkat</label>
                                        <textarea x-model="advantage.description" :name="`advantages[${index}][description]`" rows="2" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-1 focus:ring-primary" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </template>
                        
                        <div x-show="advantages.length === 0" class="text-center py-6 bg-gray-50 border border-gray-200 border-dashed rounded-xl">
                            <p class="text-sm text-gray-500">Belum ada keunggulan ditambahkan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="flex justify-end pt-4">
            <button type="submit" class="px-6 py-2.5 bg-primary text-white font-bold rounded-xl hover:bg-primary-dark transition-all active:scale-95 shadow-sm shadow-primary/30">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/admin/settings/landing.blade.php ENDPATH**/ ?>