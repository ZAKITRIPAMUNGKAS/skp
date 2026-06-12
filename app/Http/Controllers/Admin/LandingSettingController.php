<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class LandingSettingController extends Controller
{
    public function edit()
    {
        $settings = [
            'landing_header_images' => json_decode(SystemSetting::get('landing_header_images', '[]'), true) ?: [],
            'landing_header_subtitle' => SystemSetting::get('landing_header_subtitle', 'Baitul Arqam LP3A UMS'),
            'landing_header_title' => SystemSetting::get('landing_header_title', 'Kegiatan Baitul Arqam LP3A UMS'),
            'landing_about_subtitle' => SystemSetting::get('landing_about_subtitle', 'Tentang Aplikasi'),
            'landing_about_title' => SystemSetting::get('landing_about_title', 'Sistem Evaluasi Perkaderan Baitul Arqam Terpadu'),
            'landing_about_description' => SystemSetting::get('landing_about_description', '<strong>ARQAM App</strong> merupakan sistem resmi milik <strong>LP3A (Lembaga Pengembangan Persyarikatan Pengkaderan & Alumni)</strong> UMS yang dirancang dan dikembangkan secara khusus untuk mendukung penyelenggaraan serta evaluasi kegiatan <strong>Baitul Arqam</strong>. Sebagai unit kerja di bawah naungan Wakil Rektor III Bidang Al Islam Kemuhammadiyahan, Pengkaderan dan Alumni (sejak tahun 2025), LP3A bertugas membina, menyiapkan, dan memberdayakan kader persyarikatan secara presisi, objektif, dan transparan.'),
            'landing_advantages_subtitle' => SystemSetting::get('landing_advantages_subtitle', 'Keunggulan Sistem'),
            'landing_advantages_title' => SystemSetting::get('landing_advantages_title', 'Fitur Unggulan Sistem ARQAM'),
            'landing_advantages_description' => SystemSetting::get('landing_advantages_description', 'Solusi praktis untuk mengelola pelatihan dengan akurasi penilaian yang didukung oleh sistem pendukung keputusan yang cerdas.'),
        ];

        $defaultFeatures = [
            ['title' => 'Standardisasi Penilaian', 'description' => 'Menggunakan indikator penilaian terukur untuk objektivitas hasil evaluasi.'],
            ['title' => 'Kemudahan Akses', 'description' => 'Antarmuka yang dioptimalkan untuk perangkat mobile memudahkan peserta dan instruktur.'],
            ['title' => 'Laporan Real-time', 'description' => 'Hasil perhitungan SAW dan grafik demografi langsung tersaji secara instan.'],
        ];

        $rawFeatures = SystemSetting::get('landing_features');
        $features = $rawFeatures ? json_decode($rawFeatures, true) : $defaultFeatures;

        $defaultAdvantages = [
            ['title' => 'Ranah Kognitif (CBT)', 'description' => 'Fasilitas CBT cerdas untuk Pretest & Posttest dilengkapi Timer otomatis, anti-kecurangan, dan Auto-grading seketika.'],
            ['title' => 'Ranah Afektif', 'description' => 'Instrumen kuesioner skala Likert digital untuk mengukur aspek sikap peserta (Self-Assessment) dengan sinkronisasi bobot secara dinamis.'],
            ['title' => 'Ranah Psikomotor', 'description' => 'Penilaian observasi lapangan berbasis matriks rubric digital oleh Instruktur (MoT) yang dapat dikustomisasi sesuai kurikulum materi.'],
            ['title' => 'Kehadiran QR Code', 'description' => 'Sistem terintegrasi cetak ID Card pintar dengan QR Code Scanner untuk pencatatan absensi otomatis dan real-time.'],
            ['title' => 'Ranking & Penentuan Kelulusan', 'description' => 'Rekapitulasi nilai otomatis untuk menentukan predikat kelulusan kader secara objektif berdasarkan seluruh aspek penilaian.'],
            ['title' => 'Mobile-First UI', 'description' => 'Desain responsif paripurna yang memprioritaskan kenyamanan pengguna di perangkat seluler dengan navigasi Bottom Menu yang intuitif.'],
        ];

        $rawAdvantages = SystemSetting::get('landing_advantages');
        $advantages = $rawAdvantages ? json_decode($rawAdvantages, true) : $defaultAdvantages;

        return view('admin.settings.landing', compact('settings', 'features', 'advantages'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'landing_header_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'remove_images' => 'nullable|array',
            'landing_header_subtitle' => 'required|string|max:255',
            'landing_header_title' => 'required|string|max:255',
            'landing_about_subtitle' => 'required|string|max:255',
            'landing_about_title' => 'required|string|max:255',
            'landing_about_description' => 'required|string',
            'landing_advantages_subtitle' => 'required|string|max:255',
            'landing_advantages_title' => 'required|string|max:255',
            'landing_advantages_description' => 'required|string',
            'features' => 'nullable|array',
            'features.*.title' => 'required|string|max:255',
            'features.*.description' => 'required|string',
            'advantages' => 'nullable|array',
            'advantages.*.title' => 'required|string|max:255',
            'advantages.*.description' => 'required|string',
        ]);

        $currentImages = json_decode(SystemSetting::get('landing_header_images', '[]'), true) ?: [];

        // Hapus gambar yang dicentang
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $path) {
                if (($key = array_search($path, $currentImages)) !== false) {
                    unset($currentImages[$key]);
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
                }
            }
            $currentImages = array_values($currentImages);
        }

        // Tambah gambar baru
        if ($request->hasFile('landing_header_images')) {
            foreach ($request->file('landing_header_images') as $file) {
                // Convert to webp
                $image = imagecreatefromstring(file_get_contents($file->path()));
                if ($image !== false) {
                    $filename = uniqid('landing_') . '.webp';
                    $path = 'landing/' . $filename;
                    
                    ob_start();
                    imagewebp($image, null, 80); // 80 is quality
                    $webpData = ob_get_clean();
                    
                    \Illuminate\Support\Facades\Storage::disk('public')->put($path, $webpData);
                    imagedestroy($image);
                    
                    $currentImages[] = $path;
                } else {
                    // Fallback to normal store if not an image that can be created
                    $currentImages[] = $file->store('landing', 'public');
                }
            }
        }
        
        SystemSetting::set('landing_header_images', json_encode($currentImages));

        SystemSetting::set('landing_header_subtitle', $request->landing_header_subtitle);
        SystemSetting::set('landing_header_title', $request->landing_header_title);
        SystemSetting::set('landing_about_subtitle', $request->landing_about_subtitle);
        SystemSetting::set('landing_about_title', $request->landing_about_title);
        SystemSetting::set('landing_about_description', $request->landing_about_description);
        
        SystemSetting::set('landing_advantages_subtitle', $request->landing_advantages_subtitle);
        SystemSetting::set('landing_advantages_title', $request->landing_advantages_title);
        SystemSetting::set('landing_advantages_description', $request->landing_advantages_description);

        if ($request->has('features')) {
            SystemSetting::set('landing_features', json_encode(array_values($request->features)));
        } else {
            SystemSetting::set('landing_features', json_encode([]));
        }

        if ($request->has('advantages')) {
            SystemSetting::set('landing_advantages', json_encode(array_values($request->advantages)));
        } else {
            SystemSetting::set('landing_advantages', json_encode([]));
        }

        return redirect()->route('admin.settings.landing')->with('success', 'Pengaturan Landing Page berhasil disimpan.');
    }
}
