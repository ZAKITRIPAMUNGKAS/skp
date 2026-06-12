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
            'landing_header_image' => SystemSetting::get('landing_header_image'),
            'landing_header_subtitle' => SystemSetting::get('landing_header_subtitle', 'Baitul Arqam LP3A UMS'),
            'landing_header_title' => SystemSetting::get('landing_header_title', 'Kegiatan Baitul Arqam LP3A UMS'),
            'landing_about_subtitle' => SystemSetting::get('landing_about_subtitle', 'Tentang Aplikasi'),
            'landing_about_title' => SystemSetting::get('landing_about_title', 'Sistem Evaluasi Perkaderan Baitul Arqam Terpadu'),
            'landing_about_description' => SystemSetting::get('landing_about_description', 'ARQAM App merupakan sistem resmi milik LP3A (Lembaga Pengembangan Persyarikatan Pengkaderan & Alumni) UMS yang dirancang dan dikembangkan secara khusus untuk mendukung penyelenggaraan serta evaluasi kegiatan Baitul Arqam. Sebagai unit kerja di bawah naungan Wakil Rektor III Bidang Al Islam Kemuhammadiyahan, Pengkaderan dan Alumni (sejak tahun 2025), LP3A bertugas membina, menyiapkan, dan memberdayakan kader persyarikatan secara presisi, objektif, dan transparan.'),
        ];

        $defaultFeatures = [
            ['title' => 'Standardisasi Penilaian', 'description' => 'Menggunakan indikator penilaian terukur untuk objektivitas hasil evaluasi.'],
            ['title' => 'Kemudahan Akses', 'description' => 'Antarmuka yang dioptimalkan untuk perangkat mobile memudahkan peserta dan instruktur.'],
            ['title' => 'Laporan Real-time', 'description' => 'Hasil perhitungan SAW dan grafik demografi langsung tersaji secara instan.'],
        ];

        $rawFeatures = SystemSetting::get('landing_features');
        $features = $rawFeatures ? json_decode($rawFeatures, true) : $defaultFeatures;

        return view('admin.settings.landing', compact('settings', 'features'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'landing_header_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'landing_header_subtitle' => 'required|string|max:255',
            'landing_header_title' => 'required|string|max:255',
            'landing_about_subtitle' => 'required|string|max:255',
            'landing_about_title' => 'required|string|max:255',
            'landing_about_description' => 'required|string',
            'features' => 'nullable|array',
            'features.*.title' => 'required|string|max:255',
            'features.*.description' => 'required|string',
        ]);

        if ($request->hasFile('landing_header_image')) {
            $path = $request->file('landing_header_image')->store('landing', 'public');
            SystemSetting::set('landing_header_image', $path);
        }

        SystemSetting::set('landing_header_subtitle', $request->landing_header_subtitle);
        SystemSetting::set('landing_header_title', $request->landing_header_title);
        SystemSetting::set('landing_about_subtitle', $request->landing_about_subtitle);
        SystemSetting::set('landing_about_title', $request->landing_about_title);
        SystemSetting::set('landing_about_description', $request->landing_about_description);
        
        $features = $request->features ?? [];
        SystemSetting::set('landing_features', json_encode(array_values($features)));

        return back()->with('success', 'Pengaturan landing page berhasil disimpan.');
    }
}
