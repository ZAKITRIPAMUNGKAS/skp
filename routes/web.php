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
    if (function_exists('opcache_reset')) {
        if (opcache_reset()) {
            return "SUCCESS: OPcache PHP berhasil di-reset via Laravel Route! Memori cPanel sekarang menggunakan kode terbaru.";
        }
        return "WARNING: Fungsi opcache_reset tersedia namun gagal dijalankan.";
    }
    return "INFO: OPcache tidak aktif pada server ini.";
});

// ── Route Membuat Symlink Secara Aman di Hosting ──────
Route::get('/generate-symlink', function () {
    // Cari path folder storage di public_html secara otomatis/dinamis
    $publicStorage = base_path('../public_html/storage');
    
    if (file_exists($publicStorage)) {
        if (is_link($publicStorage)) {
            unlink($publicStorage);
        } else {
            // Rename folder fisik jika bukan symlink agar tidak bentrok
            rename($publicStorage, $publicStorage . '_backup_' . time());
        }
    }
    
    if (symlink(storage_path('app/public'), $publicStorage)) {
        return "SUCCESS: Symlink berhasil dibuat otomatis menuju " . $publicStorage;
    }
    
    return "FAILED: Gagal membuat symlink. Pastikan folder public_html dapat ditulis (writable).";
});

// ── Rute Admin ──────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Rute Global Admin Only (Hanya bisa diakses oleh Admin Utama, bukan Fasilitator)
    Route::middleware('admin_only')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('logs.index');
        Route::get('/participants', [ParticipantController::class, 'index'])->name('participants.index');
        Route::get('/participants/{peserta}', [ParticipantController::class, 'show'])->name('participants.show');
        Route::get('/participants/{peserta}/edit', [ParticipantController::class, 'edit'])->name('participants.edit');
        Route::put('/participants/{peserta}', [ParticipantController::class, 'update'])->name('participants.update');
        Route::delete('/participants/{peserta}', [ParticipantController::class, 'destroyParticipant'])->name('participants.destroyParticipant');
        Route::get('/soal', [SoalController::class, 'index'])->name('soal.index');
        
        // CRUD Galeri Pelatihan
        Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class)->except(['show']);
        
        // CRUD Testimoni (Apa Kata Mereka)
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)->except(['show']);
        
        // Rute untuk membuat event baru dan menyimpannya (hanya admin utama)
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });

    // Rute Event Listing (Bisa diakses Admin & Fasilitator, tapi isinya difilter)
    Route::get('/events', [EventController::class, 'index'])->name('events.index');

    // Rute Spesifik Event (Harus diverifikasi kepemilikan / penugasan via event_access)
    Route::middleware('event_access')->group(function () {
        Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::post('/events/{event}/facilitators', [EventController::class, 'assignFacilitators'])->name('events.assignFacilitators');
        Route::get('/events/{event}/report', [EventController::class, 'downloadReport'])->name('events.report');
        Route::get('/events/{event}/winners-report', [EventController::class, 'downloadWinnersReport'])->name('events.winnersReport');
        Route::get('/events/{event}/angket-report', [EventController::class, 'downloadAngketReport'])->name('events.angketReport');
        Route::get('/events/{event}/export-excel', [EventController::class, 'exportExcel'])->name('events.exportExcel');
        Route::get('/events/{event}/presentasi', [\App\Http\Controllers\Admin\PresentasiController::class, 'show'])->name('events.presentasi');

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

        // Pemindaian kehadiran
        Route::get('/events/{event}/absensi/{sesi}/scan', [AbsensiController::class, 'scanPage'])->name('absensi.scan');

        // Manajemen soal (pretest/posttest)
        Route::post('/events/{event}/soal', [SoalController::class, 'store'])->name('soal.store');
        Route::put('/events/{event}/soal/{soal}', [SoalController::class, 'update'])->name('soal.update');
        Route::delete('/events/{event}/soal/{soal}', [SoalController::class, 'destroy'])->name('soal.destroy');
        Route::post('/events/{event}/soal/reorder', [SoalController::class, 'reorder'])->name('soal.reorder');
        Route::get('/events/{event}/soal/material-data', [SoalController::class, 'getMaterialData'])->name('soal.materialData');
        Route::post('/events/{event}/soal/duplicate-posttest', [SoalController::class, 'duplicateToPosttest'])->name('soal.duplicatePosttest');
        Route::post('/events/{event}/soal/copy-from', [SoalController::class, 'copyFromEvent'])->name('soal.copyFrom');

        // Kontrol sesi tes (buka/tutup pretest/posttest)
        Route::post('/events/{event}/sesi-tes/open', [SesiTesController::class, 'open'])->name('sesiTes.open');
        Route::post('/events/{event}/sesi-tes/close', [SesiTesController::class, 'close'])->name('sesiTes.close');
        Route::get('/events/{event}/sesi-tes/{tipe}/status', [SesiTesController::class, 'status'])->name('sesiTes.status');

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

        // AHP & SAW
        Route::post('/events/{event}/ahp/calculate', [AhpSawController::class, 'calculateAhp'])->name('ahp.calculate');
        Route::post('/events/{event}/ahp/save', [AhpSawController::class, 'saveAhp'])->name('ahp.save');
        Route::get('/events/{event}/ahp/get', [AhpSawController::class, 'getAhp'])->name('ahp.get');
        Route::post('/events/{event}/saw/calculate', [AhpSawController::class, 'calculateSaw'])->name('saw.calculate');
    });

    Route::post('/absensi/scan', [AbsensiController::class, 'scan'])->name('absensi.process');
    Route::post('/soal/{soal}/copy-to-event', [SoalController::class, 'copyToEvent'])->name('soal.copyToEvent');
});

// ── Peserta Routes ────────────────────────────────────
Route::middleware(['auth', 'peserta'])->prefix('peserta')->name('peserta.')->group(function () {
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

    // Angket
    Route::get('/angket', [AngketPesertaController::class, 'indexRoot'])->name('angket.index_root');
    Route::get('/angket/{event}', [AngketPesertaController::class, 'fill'])->name('angket.fill');
    Route::post('/angket/{event}/save', [AngketPesertaController::class, 'save'])->name('angket.save');

    // Hasil Penilaian
    Route::get('/hasil', [\App\Http\Controllers\Peserta\DashboardController::class, 'hasil'])->name('hasil');
});
