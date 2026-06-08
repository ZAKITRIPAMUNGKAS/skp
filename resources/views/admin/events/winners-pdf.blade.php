<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Piagam Penghargaan - {{ $event->nama_event }}</title>
    
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #ffffff;
            /* Menggunakan Century Gothic & Segoe UI yang sangat geometris, clean, dan berciri khas modern muda */
            font-family: 'Century Gothic', 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #111827;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Container utama untuk A4 Landscape */
        .certificate-container {
            width: 297mm;
            height: 210mm;
            position: relative;
            overflow: hidden;
            background-color: #ffffff;
            page-break-after: always;
        }

        .certificate-container:last-child {
            page-break-after: avoid;
        }

        /* --- Elemen Grafis Latar Belakang (Style Anak Muda) --- */
        .shape-top-left {
            position: absolute;
            top: -100px;
            left: -100px;
            width: 380px;
            height: 380px;
            background-color: #1A56DB;
            border-radius: 50%;
            opacity: 0.08;
            z-index: 1;
        }

        /* Aksen garis miring di kanan */
        .shape-right-stripe-blue {
            position: absolute;
            top: -50px;
            right: 145px;
            bottom: -50px;
            width: 30px;
            background-color: #1A56DB;
            transform: skewX(-10deg);
            z-index: 1;
        }

        .shape-right-stripe {
            position: absolute;
            top: -50px;
            right: -80px;
            bottom: -50px;
            width: 210px;
            background-color: #FACA15;
            transform: skewX(-10deg);
            z-index: 2;
        }

        /* Pola Titik (Tech Vibe) */
        .dot-pattern {
            position: absolute;
            bottom: 30px;
            left: 30px;
            width: 200px;
            height: 150px;
            background-image: radial-gradient(#9CA3AF 15%, transparent 16%);
            background-size: 15px 15px;
            opacity: 0.2;
            z-index: 1;
        }

        /* --- Konten Utama --- */
        .content-wrapper {
            position: absolute;
            top: 15mm;
            left: 25mm;
            width: 210mm; /* Dibatasi agar tidak menabrak garis miring kanan di PDF */
            height: 180mm;
            z-index: 10;
        }

        /* Header */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .logo-img {
            height: 48px;
            max-width: 140px;
            display: inline-block;
            vertical-align: middle;
        }

        .header-text-td {
            padding-left: 18px;
            vertical-align: middle;
        }

        .header-text-td h3 {
            margin: 0;
            color: #6B7280;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2.5px;
            font-weight: 600;
        }

        .header-text-td h1 {
            margin: 4px 0 0 0;
            color: #111827;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .badge-td {
            text-align: right;
            vertical-align: middle;
        }

        .badge-top {
            background-color: #F3F4F6;
            color: #1A56DB;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 1px;
            display: inline-block;
            text-transform: uppercase;
        }

        /* Bagian Tengah (Gelar Juara) */
        .main-layout-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .award-title-box {
            margin-bottom: 5px;
        }

        .award-title {
            font-weight: 800;
            font-size: 44px;
            color: #1A56DB;
            text-transform: uppercase;
            background-color: #FACA15;
            padding: 5px 20px;
            border-radius: 8px;
            display: inline-block;
            margin: 0;
        }

        .award-subtitle {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            margin: 15px 0 25px 0;
            letter-spacing: 0.5px;
        }

        /* Info Penerima */
        .recipient-label {
            font-size: 12px;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .recipient-name {
            font-size: 30px;
            font-weight: 800;
            color: #111827;
            margin: 0;
            text-transform: uppercase;
        }

        .recipient-unit {
            font-size: 13px;
            color: #1A56DB;
            font-weight: 700;
            margin-top: 8px;
            margin-bottom: 20px;
            display: inline-block;
            background: #EFF6FF;
            padding: 6px 16px;
            border-radius: 20px;
        }

        .award-desc {
            font-size: 13px;
            line-height: 1.7;
            color: #4B5563;
            margin-top: 5px;
            width: 95%;
        }

        /* Tabel Nilai (Gaya Modern Card) */
        .score-section {
            margin-top: 35px;
            margin-bottom: 25px;
            width: 100%;
        }

        .score-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
        }

        .score-table th {
            font-size: 9px;
            text-transform: uppercase;
            color: #6B7280;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding-bottom: 8px;
            border-bottom: 2px solid #E5E7EB;
            text-align: center;
            width: 16.6%;
        }

        .score-table td {
            font-weight: 700;
            font-size: 17px;
            color: #111827;
            background-color: #F3F4F6;
            border-radius: 8px;
            padding: 10px 5px;
            text-align: center;
            width: 16.6%;
        }

        /* Menyoroti Nilai Akhir (SAW) */
        .score-table .final-score-header {
            color: #1A56DB;
            border-bottom-color: #1A56DB;
        }

        .score-table .final-score-value {
            background-color: #1A56DB;
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
        }

        /* Footer */
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            border-top: 2px dashed #E5E7EB;
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .footer-text {
            font-size: 11px;
            color: #6B7280;
            text-align: left;
            padding-top: 12px;
        }

        .footer-nomor {
            font-size: 11px;
            color: #6B7280;
            text-align: right;
            font-weight: 700;
            padding-top: 12px;
            padding-right: 15mm;
        }

        /* Tempat Maskot (Centering murni di DomPDF via table) */
        .mascot-container {
            text-align: center;
            vertical-align: middle;
        }

        .mascot-image-box {
            width: 110px;
            height: 110px;
            background-color: #ffffff;
            border-radius: 50%;
            display: inline-block;
            border: 6px solid #FACA15;
            text-align: center;
        }

        .mascot-img {
            width: 85px;
            height: 85px;
            margin-top: 7px;
        }

        .mascot-stamp {
            background-color: #111827;
            color: #FACA15;
            padding: 5px 15px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: -15px;
            display: inline-block;
            border: 2px solid #ffffff;
        }
    </style>
</head>
<body>

@foreach($winners as $index => $w)
@php
    $p = $w->peserta;
    $rankNum = $index + 1;
    
    // Predikat medali juara
    $medals = ['Juara I', 'Juara II', 'Juara III'];
    $medal = $medals[$index] ?? 'Juara';
@endphp

    <div class="certificate-container">
        
        <!-- Elemen Latar Belakang Geometris -->
        <div class="shape-top-left"></div>
        <div class="dot-pattern"></div>
        <div class="shape-right-stripe-blue"></div>
        <div class="shape-right-stripe"></div>

        <div class="content-wrapper">
            
            <!-- Header -->
            <table class="header-table">
                <tr>
                    <td style="width: 150px; vertical-align: middle;">
                        <img src="{{ public_path('Logoums.png') }}" class="logo-img" alt="Logo ArqamApp" onerror="this.style.display='none'">
                    </td>
                    <td class="header-text-td">
                        <h3 style="margin-top: 10px; margin-bottom: 2px; font-size: 10px;">Lembaga Agama Pengembangan Persyarikatan Pengkaderan & Alumni(LP3A)</h3>
                        <h3 style="margin-top: 0; margin-bottom: 5px; font-weight: normal; font-size: 10px; color: #555;">Universitas Muhammadiyah Surakarta</h3>
                        <h1>DOKUMEN PENGHARGAAN</h1>
                    </td>
                    <td class="badge-td">
                        <div class="badge-top">{{ $event->nama_event }}</div>
                    </td>
                </tr>
            </table>

            <!-- Konten Utama (Grid Kiri & Kanan) -->
            <table class="main-layout-table">
                <tr>
                    <!-- Kolom Kiri: Informasi Penerima & Penghargaan -->
                    <td style="width: 75%; vertical-align: top; padding-right: 30px;">
                        <div class="award-title-box">
                            <h1 class="award-title">{{ $medal }}</h1>
                        </div>
                        <div class="award-subtitle">Peserta Terbaik Baitul Arqam</div>

                        <div class="recipient-label">Diberikan secara resmi kepada:</div>
                        <h2 class="recipient-name">{{ $p->nama_lengkap }}</h2>
                        <div>
                            <span class="recipient-unit">{{ $p->unit_kerja ?: '—' }}</span>
                        </div>

                        <p class="award-desc">
                            Atas pencapaian luar biasa dan keaktifan tinggi selama mengikuti kegiatan perkaderan Baitul Arqam. Peserta berhasil lulus dengan hasil prestasi sangat memuaskan serta menduduki peringkat terbaik ke-{{ $rankNum }} berdasarkan evaluasi komprehensif AHP-SAW.
                        </p>
                    </td>

                    <!-- Kolom Kanan: Maskot & Stempel Verified -->
                    <td style="width: 25%; vertical-align: middle; text-align: center;">
                        <div class="mascot-container">
                            <table style="width: 120px; height: 120px; border-radius: 50%; border: 6px solid #FACA15; background-color: #ffffff; border-collapse: collapse; margin: 0 auto;">
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <img src="{{ public_path('images/arka/arka_selebrasi.png') }}" class="mascot-img" alt="Mascot" onerror="this.style.display='none'">
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div class="mascot-stamp">VERIFIED</div>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Tabel Nilai Modern -->
            <div class="score-section">
                <table class="score-table">
                    <thead>
                        <tr>
                            <th>Pretest (C1)</th>
                            <th>Posttest (C2)</th>
                            <th>Psikomotor (C3)</th>
                            <th>Afektif (C4)</th>
                            <th>Kehadiran (C5)</th>
                            <th class="final-score-header">SKOR SAW</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ round($w->nilai_pretest, 2) }}</td>
                            <td>{{ round($w->nilai_posttest, 2) }}</td>
                            <td>{{ round($w->nilai_psikomotor, 2) }}</td>
                            <td>{{ round($w->nilai_afektif, 2) }}</td>
                            <td>{{ round($w->nilai_kehadiran, 2) }}</td>
                            <td class="final-score-value">{{ number_format($w->skor_saw, 4) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <table class="footer-table">
                <tr>
                    <td class="footer-text">
                        Dokumen Penghargaan Resmi • Di-generate otomatis melalui sistem <strong style="color: #1A56DB;">ArqamApp</strong>.
                    </td>
                    <td class="footer-nomor">
                        ID: <strong style="color: #1A56DB;">ARQ-{{ date('Y') }}-{{ sprintf('%03d', $p->id ?? 0) }}</strong>
                    </td>
                </tr>
            </table>
        </div>

    </div>
@endforeach

</body>
</html>