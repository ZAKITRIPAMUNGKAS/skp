<?php $__env->startSection('title', 'Kelola Peserta — ARQAM'); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Kelola Peserta','subtitle' => 'Daftar seluruh peserta yang terdaftar di sistem.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Kelola Peserta','subtitle' => 'Daftar seluruh peserta yang terdaftar di sistem.']); ?>
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

    <div class="mb-6 flex justify-end">
        <a href="<?php echo e(route('admin.participants.batchCropPage')); ?>" class="inline-flex items-center gap-2 px-4 py-2.5 bg-accent hover:bg-accent-600 active:scale-95 text-white text-sm font-bold rounded-xl shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Auto-Crop Pas Foto Lama (Deteksi Wajah)
        </a>
    </div>

    
    <div class="mb-6 bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
        <form method="GET" action="<?php echo e(route('admin.participants.index')); ?>" class="flex flex-wrap items-center gap-3">
            <div class="relative">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                    placeholder="Cari nama, NIK, alasan..."
                    class="w-64 pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <select name="event_id" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-white text-gray-700">
                <option value="">Semua Event</option>
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($event->id); ?>" <?php echo e(request('event_id') == $event->id ? 'selected' : ''); ?>><?php echo e(Str::limit($event->nama_event, 25)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="kesediaan" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-white text-gray-700">
                <option value="">Semua Kesediaan</option>
                <option value="bersedia" <?php echo e(request('kesediaan') == 'bersedia' ? 'selected' : ''); ?>>Bersedia</option>
                <option value="tidak_bersedia" <?php echo e(request('kesediaan') == 'tidak_bersedia' ? 'selected' : ''); ?>>Tidak Hadir</option>
                <option value="belum_konfirmasi" <?php echo e(request('kesediaan') == 'belum_konfirmasi' ? 'selected' : ''); ?>>Belum Konfirmasi</option>
            </select>

            <select name="jenis_kelamin" class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-white text-gray-700">
                <option value="">Semua Jenis Kelamin</option>
                <option value="L" <?php echo e(request('jenis_kelamin') == 'L' ? 'selected' : ''); ?>>Laki-Laki</option>
                <option value="P" <?php echo e(request('jenis_kelamin') == 'P' ? 'selected' : ''); ?>>Perempuan</option>
            </select>

            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'primary']); ?>Filter <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
            <?php if(request()->anyFilled(['search', 'event_id', 'kesediaan', 'jenis_kelamin'])): ?>
                <a href="<?php echo e(route('admin.participants.index')); ?>" class="text-xs text-gray-500 hover:text-red-500 underline transition-colors">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold text-gray-600">Peserta</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Unit Kerja</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Status Kesediaan (Event)</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-center">Terdaftar Pada</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                    <?php if($p->foto): ?>
                                        <img src="<?php echo e($p->foto_url); ?>" referrerpolicy="no-referrer" class="w-10 h-10 rounded-full object-cover">
                                    <?php else: ?>
                                        <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800"><?php echo e($p->nama_lengkap); ?></p>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] px-1 bg-gray-100 text-gray-500 rounded font-mono"><?php echo e($p->user->username); ?></span>
                                        <span class="text-[10px] text-gray-400"><?php echo e($p->email); ?></span>
                                        <?php if($p->jenis_kelamin): ?>
                                            <span class="text-[10px] px-1 bg-blue-50 text-blue-600 rounded"><?php echo e($p->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan'); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600"><?php echo e($p->unit_kerja ?? '-'); ?></td>
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                <?php $__empty_2 = true; $__currentLoopData = $p->eventPeserta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <div class="flex flex-col gap-0.5">
                                        <span class="text-xs font-medium text-gray-700"><?php echo e(optional($ep->event)->nama_event ?? 'Event'); ?></span>
                                        <div class="flex items-center flex-wrap gap-1.5">
                                            <?php if($ep->konfirmasi_kesediaan === 'bersedia'): ?>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-green-50 text-green-700 border border-green-200">
                                                    Bersedia
                                                </span>
                                            <?php elseif($ep->konfirmasi_kesediaan === 'tidak_bersedia'): ?>
                                                <button type="button"
                                                    @click="$dispatch('open-alasan-modal', { 
                                                        pesertaNama: '<?php echo e(addslashes($p->nama_lengkap)); ?>', 
                                                        eventNama: '<?php echo e(addslashes(optional($ep->event)->nama_event)); ?>', 
                                                        alasan: '<?php echo e(addslashes($ep->alasan_tidak_hadir)); ?>' 
                                                    })"
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-50 text-red-700 border border-red-200 hover:bg-red-100 hover:border-red-300 transition-colors shadow-sm cursor-pointer"
                                                    title="Klik untuk melihat alasan">
                                                    Tidak Hadir ⓘ
                                                </button>
                                                <?php if($ep->alasan_tidak_hadir): ?>
                                                    <span class="text-[10px] text-red-600 italic max-w-[220px] truncate block mt-0.5" title="<?php echo e($ep->alasan_tidak_hadir); ?>">
                                                        (<?php echo e(Str::limit($ep->alasan_tidak_hadir, 25)); ?>)
                                                    </span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-50 text-gray-600 border border-gray-200">
                                                    Belum Konfirmasi
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    <span class="text-xs text-gray-400 italic">Belum terdaftar event</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center text-gray-500"><?php echo e($p->created_at->format('d M Y')); ?></td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?php echo e(route('admin.participants.show', $p)); ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary/5 text-primary hover:bg-primary hover:text-white rounded-lg text-xs font-bold transition-all">
                                    Detail
                                </a>
                                <a href="<?php echo e(route('admin.participants.edit', $p)); ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-xs font-bold transition-all">
                                    Edit
                                </a>
                                <form method="POST" action="<?php echo e(route('admin.participants.destroyParticipant', $p)); ?>" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peserta ini beserta akun loginnya?')" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 hover:bg-red-600 hover:text-white rounded-lg text-xs font-bold transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                            Tidak ada data peserta ditemukan.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if($participants->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            <?php echo e($participants->links()); ?>

        </div>
        <?php endif; ?>
    </div>

    
    <div x-data="{ 
            showModal: false, 
            pesertaNama: '', 
            eventNama: '', 
            alasan: '' 
         }"
         x-on:open-alasan-modal.window="
            pesertaNama = $event.detail.pesertaNama;
            eventNama = $event.detail.eventNama;
            alasan = $event.detail.alasan;
            showModal = true;
         "
         x-show="showModal"
         x-cloak
         class="fixed inset-0 z-[80] overflow-y-auto"
         style="display: none;">
         
         <div x-show="showModal"
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0"
              @click="showModal = false"
              class="fixed inset-0 bg-black/40 backdrop-blur-sm">
         </div>

         <div class="flex min-h-full items-center justify-center p-4">
              <div x-show="showModal"
                   x-transition:enter="transition ease-out duration-300"
                   x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                   x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                   x-transition:leave="transition ease-in duration-200"
                   x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                   x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                   @click.outside="showModal = false"
                   class="relative w-full sm:max-w-lg bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-gray-100">
                   
                   
                   <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between">
                       <div class="flex items-center gap-3">
                           <div class="w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center">
                               <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                               </svg>
                           </div>
                           <div class="text-left">
                               <h3 class="text-base font-bold text-gray-800 font-heading">Alasan Tidak Hadir</h3>
                               <p class="text-[11px] text-gray-400">Keterangan berhalangan menghadiri event</p>
                           </div>
                       </div>
                       <button @click="showModal = false"
                               class="w-8 h-8 rounded-xl hover:bg-gray-50 flex items-center justify-center transition-colors text-gray-400 hover:text-gray-600 cursor-pointer">
                           <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                           </svg>
                       </button>
                   </div>
                   
                   
                   <div class="p-6 space-y-4.5 text-left">
                       <div class="grid grid-cols-2 gap-4">
                           <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-4">
                               <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Peserta</span>
                               <p class="text-xs font-bold text-gray-800" x-text="pesertaNama"></p>
                           </div>
                           <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-4">
                               <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Event</span>
                               <p class="text-xs font-bold text-gray-700" x-text="eventNama"></p>
                           </div>
                       </div>
                       
                       <div>
                           <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Keterangan / Alasan Detail</span>
                           <div class="bg-red-50/20 border-l-4 border-red-500 rounded-r-2xl p-4">
                               <p class="text-xs text-gray-600 leading-relaxed whitespace-pre-wrap font-medium" x-text="alasan || 'Tidak ada alasan detail ditulis.'"></p>
                           </div>
                       </div>
                   </div>
                   
                   
                   <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-50 flex items-center justify-end">
                       <button type="button" @click="showModal = false"
                               class="px-5 py-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 transition-all rounded-xl text-xs font-bold shadow-sm cursor-pointer active:scale-95">
                           Tutup
                       </button>
                   </div>
              </div>
         </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/admin/participants/index.blade.php ENDPATH**/ ?>