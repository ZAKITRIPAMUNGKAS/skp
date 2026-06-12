
<?php $event = $event ?? null; ?>

<div class="space-y-6">
    
    <div>
        <label for="nama_event" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Event <span class="text-red-500">*</span></label>
        <input type="text" id="nama_event" name="nama_event"
            value="<?php echo e(old('nama_event', $event?->nama_event)); ?>"
            class="w-full px-4 py-3 text-sm border <?php echo e($errors->has('nama_event') ? 'border-red-300 bg-red-50/50' : 'border-gray-200'); ?> rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white"
            placeholder="Contoh: Baitul Arqam Angkatan I Tahun 2026" required>
        <?php $__errorArgs = ['nama_event'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Mulai <span class="text-red-500">*</span></label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                value="<?php echo e(old('tanggal_mulai', $event?->tanggal_mulai?->format('Y-m-d'))); ?>"
                class="w-full px-4 py-3 text-sm border <?php echo e($errors->has('tanggal_mulai') ? 'border-red-300' : 'border-gray-200'); ?> rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white" required>
            <?php $__errorArgs = ['tanggal_mulai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Selesai <span class="text-red-500">*</span></label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                value="<?php echo e(old('tanggal_selesai', $event?->tanggal_selesai?->format('Y-m-d'))); ?>"
                class="w-full px-4 py-3 text-sm border <?php echo e($errors->has('tanggal_selesai') ? 'border-red-300' : 'border-gray-200'); ?> rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white" required>
            <?php $__errorArgs = ['tanggal_selesai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="sm:col-span-2">
            <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi</label>
            <input type="text" id="lokasi" name="lokasi"
                value="<?php echo e(old('lokasi', $event?->lokasi)); ?>"
                class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white"
                placeholder="Contoh: Kampus Utama - Gedung Serbaguna">
            <?php $__errorArgs = ['lokasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="kuota" class="block text-sm font-medium text-gray-700 mb-1.5">Kuota Peserta</label>
            <input type="number" id="kuota" name="kuota"
                value="<?php echo e(old('kuota', $event?->kuota)); ?>"
                class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white"
                placeholder="Contoh: 100" min="0">
            <?php $__errorArgs = ['kuota'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    
    <div>
        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="4"
            class="w-full px-4 py-3 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white resize-none"
            placeholder="Deskripsi kegiatan..."><?php echo e(old('deskripsi', $event?->deskripsi)); ?></textarea>
        <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
        <select id="status" name="status"
            class="w-full px-4 py-3 text-sm border <?php echo e($errors->has('status') ? 'border-red-300' : 'border-gray-200'); ?> rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white" required>
            <option value="persiapan" <?php echo e(old('status', $event?->status) == 'persiapan' ? 'selected' : ''); ?>>Persiapan</option>
            <option value="berlangsung" <?php echo e(old('status', $event?->status) == 'berlangsung' ? 'selected' : ''); ?>>Berlangsung</option>
            <option value="selesai" <?php echo e(old('status', $event?->status) == 'selesai' ? 'selected' : ''); ?>>Selesai</option>
        </select>
        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>
<?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/admin/events/_form.blade.php ENDPATH**/ ?>