<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\SoalController;
use App\Http\Controllers\Admin\SesiTesController;
use App\Http\Controllers\Admin\AfektifController;
use App\Http\Controllers\Admin\PsikomotorController;
use App\Http\Controllers\Admin\AngketController;
use App\Http\Controllers\Admin\AhpSawController;
use App\Http\Controllers\Admin\FasilitatorController;
use App\Http\Controllers\Peserta\TesController;
use App\Http\Controllers\Peserta\AfektifPesertaController;
use App\Http\Controllers\Peserta\AngketPesertaController;

/*
|--------------------------------------------------------------------------
| Rute Web
|--------------------------------------------------------------------------
*/

// ── Rute Guest ──────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ── Logout ────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ── Reset Password ───────────────────────────────────
Route::get('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForm'])->name('password.forgot');
Route::post('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'verify'])->name('password.verify');
Route::get('/reset-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'reset'])->name('password.reset.submit');

// ── Verifikasi ──────────────────────────────────────
Route::get('/verify/{hash}', [\App\Http\Controllers\VerifyController::class, 'verify'])->name('certificate.verify');

// ── Pendaftaran Event Publik ─────────────────────────
Route::get('/register/event/{token}', [\App\Http\Controllers\EventRegistrationController::class, 'show'])->name('registration.form');
Route::post('/register/event/{token}', [\App\Http\Controllers\EventRegistrationController::class, 'store'])->name('registration.store');
Route::get('/register/event/{token}/success', [\App\Http\Controllers\EventRegistrationController::class, 'success'])->name('registration.success');

// ── Alihkan root ke landing ───────────────────────────
Route::get('/', [\App\Http\Controllers\LandingController::class, 'index'])->name('landing');

// ── Temporary OPcache Clear Route ────────────────────
Route::get('/clear-opcache-action', function() {
    // Clear Laravel caches
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');

    // Clean photo cache
    $photoCacheDir = storage_path('photo_cache');
    $photoCacheMsg = "";
    if (file_exists($photoCacheDir)) {
        $files = glob($photoCacheDir . '/*');
        $deletedCount = 0;
        foreach ($files as $file) {
            if (is_file($file)) {
                @unlink($file);
                $deletedCount++;
            }
        }
        $photoCacheMsg = " & Cache foto dibersihkan ($deletedCount file)";
    }

    $opcacheMsg = "OPcache tidak aktif pada server ini.";
    if (function_exists('opcache_reset')) {
        if (opcache_reset()) {
            $opcacheMsg = "OPcache PHP berhasil di-reset!";
        } else {
            $opcacheMsg = "Fungsi opcache_reset tersedia namun gagal dijalankan.";
        }
    }
    return "SUCCESS: Seluruh cache Laravel (Route, Config, Cache, View) berhasil dibersihkan!" . $photoCacheMsg . " & " . $opcacheMsg;
});

// ── Route Membuat Symlink Secara Aman di Hosting ──────
Route::get('/generate-symlink', function () {
    // Cari path folder storage di public_html secara otomatis/dinamis
    $publicStorage = base_path('../public_html/storage');
    $targetStorage = storage_path('app/public');
    
    if (file_exists($publicStorage)) {
        if (is_link($publicStorage)) {
            @unlink($publicStorage);
        } else {
            // Rename folder fisik jika bukan symlink agar tidak bentrok
            @rename($publicStorage, $publicStorage . '_backup_' . time());
        }
    }
    
    // Gunakan shell_exec sebagai fallback jika fungsi php symlink() di-disable di php.ini hosting
    if (function_exists('symlink')) {
        if (@symlink($targetStorage, $publicStorage)) {
            return "SUCCESS: Symlink berhasil dibuat otomatis via symlink() menuju " . $publicStorage;
        }
    }
    
    // Fallback 1: Gunakan shell_exec jika tersedia
    if (function_exists('shell_exec')) {
        $output = @shell_exec("ln -s " . escapeshellarg($targetStorage) . " " . escapeshellarg($publicStorage) . " 2>&1");
        if (file_exists($publicStorage)) {
            return "SUCCESS: Symlink berhasil dibuat otomatis via terminal (ln -s) menuju " . $publicStorage;
        }
    }
    
    // Fallback 2: Gunakan popen jika shell_exec tidak ada tapi popen ada
    if (function_exists('popen')) {
        $handle = @popen("ln -s " . escapeshellarg($targetStorage) . " " . escapeshellarg($publicStorage) . " 2>&1", 'r');
        if (is_resource($handle)) {
            @pclose($handle);
        }
        if (file_exists($publicStorage)) {
            return "SUCCESS: Symlink berhasil dibuat otomatis via popen (ln -s) menuju " . $publicStorage;
        }
    }
    
    // Fallback 3: Gunakan system jika tersedia
    if (function_exists('system')) {
        ob_start();
        @system("ln -s " . escapeshellarg($targetStorage) . " " . escapeshellarg($publicStorage) . " 2>&1");
        ob_end_clean();
        if (file_exists($publicStorage)) {
            return "SUCCESS: Symlink berhasil dibuat otomatis via system (ln -s) menuju " . $publicStorage;
        }
    }
    
    return "FAILED: Semua fungsi eksekusi (symlink, shell_exec, popen, system) dinonaktifkan di server. Silakan hubungi penyedia hosting atau jalankan manual lewat SSH: 'ln -s " . $targetStorage . " " . $publicStorage . "'";
});

// ── Rute Admin ──────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/video', [\App\Http\Controllers\Admin\DashboardController::class, 'video'])->name('dashboard.video');
    Route::get('/dashboard/documentation', [\App\Http\Controllers\Admin\DashboardController::class, 'documentation'])->name('dashboard.documentation');
    Route::get('/soal', [SoalController::class, 'index'])->name('soal.index');

    // Rute Global Admin Only (Hanya bisa diakses oleh Admin Utama, bukan Fasilitator)
    Route::middleware('admin_only')->group(function () {
        Route::get('/logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('logs.index');
        Route::post('/logs/clear-soal', [\App\Http\Controllers\Admin\ActivityLogController::class, 'clearSoal'])->name('logs.clearSoal');
        Route::post('/logs/clear-peserta', [\App\Http\Controllers\Admin\ActivityLogController::class, 'clearPeserta'])->name('logs.clearPeserta');
        Route::get('/participants', [ParticipantController::class, 'index'])->name('participants.index');
        Route::get('/participants/batch-crop', [ParticipantController::class, 'batchCropPage'])->name('participants.batchCropPage');
        Route::post('/participants/{peserta}/update-cropped', [ParticipantController::class, 'updateCroppedPhoto'])->name('participants.updateCroppedPhoto');
        Route::get('/participants/{peserta}', [ParticipantController::class, 'show'])->name('participants.show');
        Route::get('/participants/{peserta}/edit', [ParticipantController::class, 'edit'])->name('participants.edit');
        Route::put('/participants/{peserta}', [ParticipantController::class, 'update'])->name('participants.update');
        Route::delete('/participants/{peserta}', [ParticipantController::class, 'destroyParticipant'])->name('participants.destroyParticipant');

        // CRUD Galeri Pelatihan
        Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class)->except(['show']);
        
        // CRUD Testimoni (Apa Kata Mereka)
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)->except(['show']);
        
        // Pengaturan Landing Page
        Route::get('/settings/landing', [\App\Http\Controllers\Admin\LandingSettingController::class, 'edit'])->name('settings.landing');
        Route::post('/settings/landing', [\App\Http\Controllers\Admin\LandingSettingController::class, 'update'])->name('settings.landing.update');
        
        // Pengaturan Sertifikat
        Route::get('/settings/certificate', [\App\Http\Controllers\Admin\CertificateSettingController::class, 'edit'])->name('settings.certificate');
        Route::post('/settings/certificate', [\App\Http\Controllers\Admin\CertificateSettingController::class, 'update'])->name('settings.certificate.update');
        
        // Rute untuk membuat event baru dan menyimpannya (hanya admin utama)
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

        // Kelola Fasilitator
        Route::get('/fasilitator', [FasilitatorController::class, 'index'])->name('fasilitator.index');
        Route::get('/fasilitator/{id}', [FasilitatorController::class, 'show'])->name('fasilitator.show');
        Route::post('/fasilitator', [FasilitatorController::class, 'store'])->name('fasilitator.store');
        Route::delete('/fasilitator/{id}', [FasilitatorController::class, 'destroy'])->name('fasilitator.destroy');
        Route::post('/fasilitator/{id}/reset-password', [FasilitatorController::class, 'resetPassword'])->name('fasilitator.resetPassword');
    });

    // Rute Event Listing (Bisa diakses Admin & Fasilitator, tapi isinya difilter)
    Route::get('/events', [EventController::class, 'index'])->name('events.index');

    // Profil Admin & Fasilitator
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');

    // Rute Spesifik Event (Harus diverifikasi kepemilikan / penugasan via event_access)
    Route::middleware('event_access')->group(function () {
        Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
        Route::get('/events/{event}/report', [EventController::class, 'downloadReport'])->name('events.report');
        Route::get('/events/{event}/winners-report', [EventController::class, 'downloadWinnersReport'])->name('events.winnersReport');
        Route::get('/events/{event}/angket-report', [EventController::class, 'downloadAngketReport'])->name('events.angketReport');
        Route::get('/events/{event}/export-excel', [EventController::class, 'exportExcel'])->name('events.exportExcel');
        Route::get('/events/{event}/export-sus-excel', [EventController::class, 'exportSusExcel'])->name('events.exportSusExcel');
        Route::get('/events/{event}/facilitators/pdf', [EventController::class, 'downloadSuratTugas'])->name('events.facilitatorsPdf');
        Route::get('/events/{event}/presentasi', [\App\Http\Controllers\Admin\PresentasiController::class, 'show'])->name('events.presentasi');
        Route::get('/events/{event}/statistics', [EventController::class, 'statistics'])->name('events.statistics');
        // Manajemen soal (pretest/posttest) - Boleh diakses Fasilitator
        Route::post('/events/{event}/soal', [SoalController::class, 'store'])->name('soal.store');
        Route::put('/events/{event}/soal/{soal}', [SoalController::class, 'update'])->name('soal.update');
        Route::delete('/events/{event}/soal/{soal}', [SoalController::class, 'destroy'])->name('soal.destroy');
        Route::post('/events/{event}/soal/reorder', [SoalController::class, 'reorder'])->name('soal.reorder');
        Route::get('/events/{event}/soal/material-data', [SoalController::class, 'getMaterialData'])->name('soal.materialData');
        Route::post('/events/{event}/soal/duplicate-posttest', [SoalController::class, 'duplicateToPosttest'])->name('soal.duplicatePosttest');
        Route::post('/events/{event}/soal/copy-from', [SoalController::class, 'copyFromEvent'])->name('soal.copyFrom');

        // Kontrol sesi tes (buka/tutup pretest/posttest) - Boleh diakses Fasilitator
        Route::post('/events/{event}/sesi-tes/open', [SesiTesController::class, 'open'])->name('sesiTes.open');
        Route::post('/events/{event}/sesi-tes/close', [SesiTesController::class, 'close'])->name('sesiTes.close');
        Route::get('/events/{event}/sesi-tes/{tipe}/status', [SesiTesController::class, 'status'])->name('sesiTes.status');

        // Pemindaian kehadiran - Boleh diakses Fasilitator
        Route::get('/events/{event}/absensi/{sesi}/scan', [AbsensiController::class, 'scanPage'])->name('absensi.scan');
        Route::get('/events/{event}/absensi/{sesi}/recent', [AbsensiController::class, 'recentScans'])->name('absensi.recent');

        // RTL - Boleh diakses Fasilitator
        Route::get('/events/{event}/rtl/{rtl}', [\App\Http\Controllers\Admin\RtlController::class, 'show'])->name('events.rtl.show');
        Route::post('/events/{event}/rtl-soal', [\App\Http\Controllers\Admin\RtlSoalController::class, 'store'])->name('events.rtlSoal.store');
        Route::put('/events/{event}/rtl-soal/{soal}', [\App\Http\Controllers\Admin\RtlSoalController::class, 'update'])->name('events.rtlSoal.update');
        Route::delete('/events/{event}/rtl-soal/{soal}', [\App\Http\Controllers\Admin\RtlSoalController::class, 'destroy'])->name('events.rtlSoal.destroy');
        Route::post('/events/{event}/rtl-soal/reorder', [\App\Http\Controllers\Admin\RtlSoalController::class, 'reorder'])->name('events.rtlSoal.reorder');
        Route::put('/events/{event}/rtl-deadline', [\App\Http\Controllers\Admin\RtlSoalController::class, 'updateDeadline'])->name('events.rtlDeadline.update');

        // Rute-rute Edit & Hapus yang dilarang bagi Fasilitator (Admin Utama Only)
        Route::middleware('admin_only')->group(function () {
            Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
            Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
            Route::post('/events/{event}/status', [EventController::class, 'updateStatus'])->name('events.updateStatus');
            Route::post('/events/{event}/reset', [EventController::class, 'resetEvent'])->name('events.reset');
            Route::post('/events/{event}/facilitators', [EventController::class, 'assignFacilitators'])->name('events.assignFacilitators');

            // Manajemen sesi (di dalam event)
            Route::post('/events/{event}/sessions', [SessionController::class, 'store'])->name('sessions.store');
            Route::put('/events/{event}/sessions/{session}', [SessionController::class, 'update'])->name('sessions.update');
            Route::delete('/events/{event}/sessions/{session}', [SessionController::class, 'destroy'])->name('sessions.destroy');
            Route::post('/events/{event}/sessions/reorder', [SessionController::class, 'reorder'])->name('sessions.reorder');

            // Manajemen peserta (di dalam event)
            Route::post('/events/{event}/participants', [ParticipantController::class, 'store'])->name('participants.store');
            Route::delete('/events/{event}/participants/{participant}', [ParticipantController::class, 'destroy'])->name('participants.destroy');
            Route::get('/events/{event}/participants/template', [ParticipantController::class, 'downloadTemplate'])->name('participants.template');
            Route::post('/events/{event}/participants/import', [ParticipantController::class, 'import'])->name('participants.import');
            Route::post('/events/{event}/participants/{participant}/qr', [ParticipantController::class, 'generateQr'])->name('participants.generateQr');
            Route::get('/events/{event}/participants/{participant}/idcard', [ParticipantController::class, 'downloadIdCard'])->name('participants.downloadIdCard');
            Route::get('/events/{event}/participants/{participant}/sertifikat', [ParticipantController::class, 'downloadSertifikat'])->name('participants.downloadSertifikat');
            Route::get('/events/{event}/id-cards', [ParticipantController::class, 'downloadIdCards'])->name('participants.idCards');
            Route::get('/events/{event}/accounts-pdf', [ParticipantController::class, 'downloadAccounts'])->name('participants.accountsPdf');
            Route::get('/events/{event}/participants-pdf', [ParticipantController::class, 'participantsPdf'])->name('participants.pdf');
            Route::get('/events/{event}/participants-export', [ParticipantController::class, 'export'])->name('participants.export');

            // Manajemen afektif
            Route::post('/events/{event}/afektif/sub-aspek', [AfektifController::class, 'storeSubAspek'])->name('afektif.storeSubAspek');
            Route::put('/events/{event}/afektif/sub-aspek/{subAspek}', [AfektifController::class, 'updateSubAspek'])->name('afektif.updateSubAspek');
            Route::delete('/events/{event}/afektif/sub-aspek/{subAspek}', [AfektifController::class, 'destroySubAspek'])->name('afektif.destroySubAspek');
            Route::post('/events/{event}/afektif/sub-aspek/{subAspek}/toggle', [AfektifController::class, 'toggleStatus'])->name('afektif.toggleStatus');
            Route::post('/events/{event}/afektif/sub-aspek/{subAspek}/butir', [AfektifController::class, 'storeButir'])->name('afektif.storeButir');
            Route::put('/events/{event}/afektif/butir/{butir}', [AfektifController::class, 'updateButir'])->name('afektif.updateButir');
            Route::delete('/events/{event}/afektif/butir/{butir}', [AfektifController::class, 'destroyButir'])->name('afektif.destroyButir');
            Route::post('/events/{event}/afektif/sub-aspek/{subAspek}/butir/reorder', [AfektifController::class, 'reorderButir'])->name('afektif.reorderButir');
            Route::get('/events/{event}/afektif/summary', [AfektifController::class, 'summary'])->name('afektif.summary');

            // Manajemen psikomotor
            Route::post('/events/{event}/psikomotor/init', [PsikomotorController::class, 'initTemplates'])->name('psikomotor.init');
            Route::get('/events/{event}/psikomotor/data', [PsikomotorController::class, 'data'])->name('psikomotor.data');
            Route::post('/events/{event}/psikomotor/save-row', [PsikomotorController::class, 'saveRow'])->name('psikomotor.saveRow');
            Route::post('/events/{event}/psikomotor/save-all', [PsikomotorController::class, 'saveAll'])->name('psikomotor.saveAll');

            // Manajemen angket
            Route::post('/events/{event}/angket/item', [AngketController::class, 'storeItem'])->name('angket.storeItem');
            Route::put('/events/{event}/angket/item/{item}', [AngketController::class, 'updateItem'])->name('angket.updateItem');
            Route::delete('/events/{event}/angket/item/{item}', [AngketController::class, 'destroyItem'])->name('angket.destroyItem');
            Route::post('/events/{event}/angket/reorder', [AngketController::class, 'reorderItems'])->name('angket.reorder');
            Route::get('/events/{event}/angket/summary', [AngketController::class, 'summary'])->name('angket.summary');
            Route::post('/events/{event}/angket/generate-sus', [AngketController::class, 'generateSus'])->name('angket.generateSus');

            // AHP & SAW
            Route::post('/events/{event}/ahp/calculate', [AhpSawController::class, 'calculateAhp'])->name('ahp.calculate');
            Route::post('/events/{event}/ahp/save', [AhpSawController::class, 'saveAhp'])->name('ahp.save');
            Route::get('/events/{event}/ahp/get', [AhpSawController::class, 'getAhp'])->name('ahp.get');
            Route::post('/events/{event}/saw/calculate', [AhpSawController::class, 'calculateSaw'])->name('saw.calculate');
        });
    });

    Route::post('/absensi/scan', [AbsensiController::class, 'scan'])->name('absensi.process');
    Route::post('/soal/copy-bulk', [SoalController::class, 'copyBulk'])->name('soal.copyBulk');
    Route::post('/soal/{soal}/copy-to-event', [SoalController::class, 'copyToEvent'])->name('soal.copyToEvent');
});

// ── Peserta Routes ────────────────────────────────────
Route::middleware(['auth', 'peserta', 'profile_completed', 'event_started'])->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Peserta\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications/poll', [\App\Http\Controllers\Peserta\NotificationController::class, 'poll'])->name('notifications.poll');
    
    // Profil
    Route::get('/profile', [\App\Http\Controllers\Peserta\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [\App\Http\Controllers\Peserta\ProfileController::class, 'update'])->name('profile.update');

    // Pretest / Posttest
    Route::get('/tes', [TesController::class, 'index'])->name('tes.index');
    Route::get('/tes/{event}/{eventSesi}/{tipe}', [TesController::class, 'instruction'])->name('tes.instruction');
    Route::get('/tes/{event}/{eventSesi}/{tipe}/take', [TesController::class, 'take'])->name('tes.take');
    Route::post('/tes/{event}/{eventSesi}/{tipe}/submit', [TesController::class, 'submit'])->name('tes.submit');
    Route::get('/tes/{event}/{eventSesi}/{tipe}/result', [TesController::class, 'result'])->name('tes.result');

    // Affective evaluation (peserta)
    Route::get('/afektif', [AfektifPesertaController::class, 'indexRoot'])->name('afektif.index_root');
    Route::get('/afektif/{event}', [AfektifPesertaController::class, 'index'])->name('afektif.index');
    Route::get('/afektif/{event}/{subAspek}', [AfektifPesertaController::class, 'fill'])->name('afektif.fill');
    Route::post('/afektif/{event}/{subAspek}/save', [AfektifPesertaController::class, 'save'])->name('afektif.save');

    // Kehadiran
    Route::get('/kehadiran', [\App\Http\Controllers\Peserta\DashboardController::class, 'kehadiran'])->name('kehadiran');

    // Jadwal Sesi
    Route::get('/jadwal', [\App\Http\Controllers\Peserta\DashboardController::class, 'jadwal'])->name('jadwal');

    // Sertifikat & ID Card
    Route::get('/sertifikat/{event}', [\App\Http\Controllers\Peserta\DashboardController::class, 'downloadSertifikat'])->name('sertifikat.download');
    Route::get('/idcard/{event}', [\App\Http\Controllers\Peserta\DashboardController::class, 'downloadIdCard'])->name('idcard.download');

    // RTL (Rencana Tindak Lanjut)
    Route::get('/rtl/{event}', [\App\Http\Controllers\Peserta\DashboardController::class, 'rtlPage'])->name('rtl.index');
    Route::post('/rtl/{event}/submit', [\App\Http\Controllers\Peserta\DashboardController::class, 'submitRtl'])->name('rtl.submit');

    // Angket
    Route::get('/angket', [AngketPesertaController::class, 'indexRoot'])->name('angket.index_root');
    Route::get('/angket/{event}', [AngketPesertaController::class, 'fill'])->name('angket.fill');
    Route::post('/angket/{event}/save', [AngketPesertaController::class, 'save'])->name('angket.save');

    // Hasil Penilaian
    Route::get('/hasil', [\App\Http\Controllers\Peserta\DashboardController::class, 'hasil'])->name('hasil');
});

// ── Rute Sementara Hapus Semua Peserta ──
Route::get('/rahasia-hapus-peserta', function() {
    if (!auth()->check() || !auth()->user()->isAdmin()) {
        return 'Akses ditolak. Anda harus login sebagai admin.';
    }

    \Illuminate\Support\Facades\DB::beginTransaction();
    try {
        // 1. Hapus pendaftaran event
        \App\Models\EventPeserta::query()->delete();
        
        // 2. Hapus profile peserta
        \App\Models\Peserta::query()->delete();
        
        // 3. Hapus user account yang role-nya peserta
        \App\Models\User::where('role', 'peserta')->delete();

        \Illuminate\Support\Facades\DB::commit();
        return 'Sukses! Seluruh data peserta dan akun loginnya telah berhasil dihapus.';
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\DB::rollBack();
        return 'Gagal menghapus data: ' . $e->getMessage();
    }
});

