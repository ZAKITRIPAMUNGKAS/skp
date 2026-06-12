
<?php
    $existingBobot = \App\Models\AhpBobot::where('event_id', $event->id)->first();
?>

<div x-data="ahpSawManager()" x-init="init()">
    
    <div class="flex gap-1 bg-gray-100 rounded-xl p-1 mb-6 w-fit">
        <button @click="subTab='ahp'" :class="subTab==='ahp' ? 'bg-white shadow-sm text-primary font-semibold' : 'text-gray-500'" class="px-5 py-2 text-sm rounded-lg transition-all">Bobot AHP</button>
        <button @click="subTab='saw'" :class="subTab==='saw' ? 'bg-white shadow-sm text-primary font-semibold' : 'text-gray-500'" class="px-5 py-2 text-sm rounded-lg transition-all">Ranking SAW</button>
    </div>

    
    <div x-show="subTab==='ahp'">
        <div class="bg-white rounded-xl border border-gray-200 p-6 relative overflow-hidden">
            <h3 class="text-sm font-semibold text-gray-800 mb-1">Matriks Perbandingan Berpasangan</h3>
            <p class="text-xs text-gray-400 mb-4">Masukkan nilai pada segitiga atas. Diagonal=1, bawah diagonal otomatis.</p>

            <div class="overflow-x-auto mb-4">
                <table class="text-sm border-collapse w-full">
                    <thead>
                        <tr>
                            <th class="px-3 py-2 bg-primary text-white font-semibold text-xs rounded-tl-lg"></th>
                            <template x-for="(label, j) in labels" :key="'th'+j">
                                <th class="px-3 py-2 bg-primary text-white font-semibold text-xs text-center" x-text="'C'+(j+1)" :class="j===4 ? 'rounded-tr-lg' : ''"></th>
                            </template>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(li, i) in labels" :key="'row'+i">
                            <tr :class="i % 2 === 0 ? 'bg-gray-50/50' : ''">
                                <td class="px-3 py-2 font-semibold text-xs text-gray-600" x-text="'C'+(i+1)+' '+li"></td>
                                <template x-for="(lj, j) in labels" :key="'cell'+i+'_'+j">
                                    <td class="px-2 py-1 text-center">
                                        <template x-if="i === j">
                                            <span class="text-xs font-bold text-gray-400">1</span>
                                        </template>
                                        <template x-if="i < j">
                                            <select x-model="matrix[i+'_'+j]" @change="recalculate()"
                                                class="w-16 h-8 text-center text-xs border border-gray-200 rounded-lg focus:ring-primary focus:border-primary outline-none">
                                                <option value="9">9</option><option value="8">8</option><option value="7">7</option><option value="6">6</option><option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option>
                                                <option value="1" selected>1</option>
                                                <option value="1/2">1/2</option><option value="1/3">1/3</option><option value="1/4">1/4</option><option value="1/5">1/5</option><option value="1/6">1/6</option><option value="1/7">1/7</option><option value="1/8">1/8</option><option value="1/9">1/9</option>
                                            </select>
                                        </template>
                                        <template x-if="i > j">
                                            <span class="text-xs text-gray-400" x-text="getInverse(j+'_'+i)"></span>
                                        </template>
                                    </td>
                                </template>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            
            <div class="grid grid-cols-5 gap-2 text-[9px] text-gray-400 mb-6 bg-gray-50 p-3 rounded-lg">
                <span>1 = Sama penting</span><span>3 = Sedikit lebih penting</span><span>5 = Lebih penting</span><span>7 = Sangat lebih penting</span><span>9 = Mutlak lebih penting</span>
            </div>

            
            <template x-if="result">
                <div class="space-y-4">
                    <div class="grid grid-cols-5 gap-3">
                        <template x-for="(w, idx) in result.weights" :key="'w'+idx">
                            <div class="bg-gray-50 rounded-xl p-3 text-center border border-gray-100">
                                <p class="text-[10px] text-gray-400 uppercase" x-text="result.labels[idx]"></p>
                                <p class="text-lg font-bold text-primary" x-text="(w*100).toFixed(2) + '%'"></p>
                                <p class="text-[9px] text-gray-400" x-text="w.toFixed(6)"></p>
                            </div>
                        </template>
                    </div>

                    <div class="p-4 rounded-xl" :class="result.is_consistent ? 'bg-green-50 border border-green-100' : 'bg-red-50 border border-red-100'">
                        <div>
                            <span class="text-xs font-semibold" :class="result.is_consistent ? 'text-green-700' : 'text-red-700'">
                                CR = <span x-text="result.cr.toFixed(4)"></span>
                            </span>
                            <p class="text-[10px] mt-0.5 font-bold" :class="result.is_consistent ? 'text-green-600' : 'text-red-600'"
                               x-text="result.is_consistent ? '✓ Konsisten (CR ≤ 0.1)' : '✗ TIDAK KONSISTEN — Revisi matriks!'"></p>
                            
                            <!-- Penjelasan Real Inkonsistensi AHP -->
                            <template x-if="!result.is_consistent">
                                <div class="mt-2 text-[10px] text-red-600 leading-relaxed border-t border-red-200/60 pt-2">
                                    <p class="font-semibold mb-1">Kenapa tidak konsisten?</p>
                                    <p>Nilai CR &gt; 0.10 menunjukkan adanya konflik logika perbandingan. Silakan periksa kembali bobot kepentingan antar kriteria.</p>
                                    <p class="mt-1 font-medium bg-red-100/50 p-2 rounded border border-red-200 text-red-700">
                                        <strong>Logika Dasar:</strong> Jika Anda menilai <strong><span x-text="result.labels[0]"></span> lebih penting dari <span x-text="result.labels[1]"></span></strong>, 
                                        dan <strong><span x-text="result.labels[1]"></span> lebih penting dari <span x-text="result.labels[2]"></span></strong>, 
                                        maka secara logis seharusnya <strong><span x-text="result.labels[0]"></span> juga jauh lebih penting dari <span x-text="result.labels[2]"></span></strong>. 
                                        Jika di dalam matriks Anda justru mengisi sebaliknya, sistem akan mendeteksinya sebagai tidak konsisten.
                                    </p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <button @click="saveBobot()" :disabled="!result.is_consistent || isSaving"
                        class="px-6 py-2.5 bg-primary text-white text-sm rounded-xl hover:bg-primary/90 transition-colors font-medium shadow-sm disabled:opacity-40 disabled:cursor-not-allowed">
                        <span x-text="isSaving ? 'Menyimpan...' : 'Simpan Bobot'"></span>
                    </button>
                </div>
            </template>
        </div>
    </div>

    
    <div x-show="subTab==='saw'">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-gray-800">Ranking Peserta (SAW)</h3>
            <button @click="calculateSaw()" :disabled="isCalculating"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-white text-sm rounded-xl hover:bg-primary/90 transition-colors shadow-sm font-medium disabled:opacity-60">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                <span x-text="isCalculating ? 'Menghitung...' : 'Hitung Ranking'"></span>
            </button>
        </div>

        
        <div x-show="showWarningModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showWarningModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showWarningModal" x-transition.scale class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                                <span class="text-yellow-600 text-xl">⚠</span>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-semibold text-gray-900" id="modal-title">Peserta dengan nilai belum lengkap</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-3">Peserta berikut belum memiliki nilai lengkap. Apakah Anda ingin melanjutkan hitung ranking tanpa mereka (nilai kosong dianggap 0)?</p>
                                    <ul class="text-xs text-yellow-700 bg-yellow-50 p-3 rounded-xl space-y-1 max-h-48 overflow-y-auto w-full text-left">
                                        <template x-for="inc in sawIncomplete" :key="inc.nama">
                                            <li>• <span class="font-bold" x-text="inc.nama"></span> <span class="text-yellow-600" x-text="'(' + inc.missing.join(', ') + ' kosong)'"></span></li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex gap-3 justify-end">
                        <button type="button" @click="showWarningModal = false" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="button" @click="calculateSaw(true)" class="px-5 py-2.5 bg-yellow-500 text-white text-sm font-semibold rounded-xl hover:bg-yellow-600 transition-colors">
                            Ya, Hitung Tetap Lanjutkan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        
        <template x-if="sawRows.length > 0">
            <div class="bg-white rounded-xl border border-gray-200 overflow-x-auto shadow-sm">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Rank</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Nama Peserta</th>
                            <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500">C1</th>
                            <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500">C2</th>
                            <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500">C3</th>
                            <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500">C4</th>
                            <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500">C5</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-primary">Skor</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500">Predikat</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500">Status Kelulusan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(row, i) in sawRows" :key="row.peserta_id">
                            <tr :class="i % 2 === 0 ? 'bg-gray-50/30' : ''" class="hover:bg-primary/5 transition-colors">
                                <td class="px-4 py-3 text-sm font-bold text-gray-700">
                                    <span x-show="i === 0">👑</span> <span x-text="i + 1"></span>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm font-medium text-gray-800" x-text="row.nama"></p>
                                    <p class="text-[10px] text-gray-400" x-text="row.unit_kerja"></p>
                                </td>
                                <td class="px-3 py-3 text-center text-xs" x-text="row.c1.toFixed(2)"></td>
                                <td class="px-3 py-3 text-center text-xs" x-text="row.c2.toFixed(2)"></td>
                                <td class="px-3 py-3 text-center text-xs" x-text="row.c3.toFixed(2)"></td>
                                <td class="px-3 py-3 text-center text-xs" x-text="row.c4.toFixed(2)"></td>
                                <td class="px-3 py-3 text-center text-xs" x-text="row.c5.toFixed(2)"></td>
                                <td class="px-4 py-3 text-center text-sm font-bold text-primary" x-text="row.skor_saw.toFixed(4)"></td>
                                <td class="px-4 py-3 text-center">
                                    <span :class="{
                                        'bg-green-50 text-green-700 border-green-200': row.predikat==='Amat Baik',
                                        'bg-blue-50 text-blue-700 border-blue-200': row.predikat==='Baik',
                                        'bg-yellow-50 text-yellow-700 border-yellow-200': row.predikat==='Cukup',
                                        'bg-red-50 text-red-700 border-red-200': row.predikat==='Kurang'
                                    }" class="text-[10px] px-2 py-1 rounded-full border font-semibold" x-text="row.predikat"></span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span :class="{
                                        'bg-green-100 text-green-800 border-green-300': row.status_kelulusan==='Lulus Sangat Memuaskan',
                                        'bg-blue-100 text-blue-800 border-blue-300': row.status_kelulusan==='Lulus Memuaskan',
                                        'bg-teal-100 text-teal-800 border-teal-300': row.status_kelulusan==='Lulus',
                                        'bg-red-100 text-red-800 border-red-300': row.status_kelulusan==='Tidak Lulus'
                                    }" class="text-[10px] px-2 py-1 rounded border font-bold" x-text="row.status_kelulusan"></span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </template>

        <template x-if="sawRows.length === 0 && !isCalculating">
            <div class="py-8"><?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Belum ada ranking','description' => 'Klik \'Hitung Ranking\' untuk menghitung ranking peserta.','icon' => 'chart']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Belum ada ranking','description' => 'Klik \'Hitung Ranking\' untuk menghitung ranking peserta.','icon' => 'chart']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?></div>
        </template>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function ahpSawManager() {
    return {
        subTab: 'ahp',
        labels: ['Pretest','Posttest','Afektif','Psikomotor','Kehadiran'],
        matrix: {},
        result: null, isSaving: false,
        sawRows: [], sawIncomplete: [], isCalculating: false, showWarningModal: false,

        init() {
            // Initialize matrix with defaults
            for (let i = 0; i < 5; i++) for (let j = i+1; j < 5; j++) this.matrix[i+'_'+j] = '1';
            // Load existing
            this.loadExisting();
        },

        getInverse(key) {
            const v = this.matrix[key];
            if (!v || v === '1') return '1';
            if (v.includes('/')) { const p = v.split('/'); return p[1]; }
            return '1/' + v;
        },

        async recalculate() {
            const res = await fetch('<?php echo e(route("admin.ahp.calculate", $event)); ?>', {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>'},
                body: JSON.stringify({ matrix: this.matrix }),
            });
            this.result = await res.json();
        },

        async saveBobot() {
            this.isSaving = true;
            await fetch('<?php echo e(route("admin.ahp.save", $event)); ?>', {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>'},
                body: JSON.stringify({ matrix: this.matrix }),
            });
            this.isSaving = false;
        },

        async loadExisting() {
            const res = await fetch('<?php echo e(route("admin.ahp.get", $event)); ?>');
            const data = await res.json();
            if (data.bobot && data.bobot.matriks) {
                try {
                    this.matrix = JSON.parse(data.bobot.matriks);
                    await this.recalculate();
                } catch(e) {}
            }
        },

        async calculateSaw(force = false) {
            this.isCalculating = true;
            this.showWarningModal = false;
            const res = await fetch('<?php echo e(route("admin.saw.calculate", $event)); ?>', {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>'},
                body: JSON.stringify({ force: force })
            });
            const data = await res.json();
            
            if (data.status === 'warning') {
                this.sawIncomplete = data.incomplete;
                this.showWarningModal = true;
            } else if (data.error) { 
                alert(data.error); 
            } else {
                this.sawRows = data.rows;
                this.sawIncomplete = [];
            }
            this.isCalculating = false;
        },
    };
}
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\website\SKRIPSI\SISTEM\resources\views/admin/events/partials/tab-ahp.blade.php ENDPATH**/ ?>