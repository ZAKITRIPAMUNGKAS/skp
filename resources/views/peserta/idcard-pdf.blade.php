<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ID Card – {{ $peserta->nama_lengkap }}</title>
    <style>
        @page {
            margin: 0;
            size: 86mm 137mm;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background: #fff;
            color: #1e293b;
            line-height: 1.3;
        }

        .page-break { page-break-after: always; }

        /* ═══════════════════════════
           FRONT SIDE
        ═══════════════════════════ */
        .card-front {
            width: 86mm;
            height: 137mm;
            background: #fff;
            overflow: hidden;
            position: relative;
        }

        /* Header biru — background saja, posisi absolute */
        .hdr-bg {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 39mm;
            background-color: #1A6D9B;
        }
        .hdr-gold {
            position: absolute;
            top: 39mm; left: 0;
            width: 100%; height: 2.5mm;
            background-color: #D4A017;
        }
        /* Footer bar */
        .ftr-bar {
            position: absolute;
            bottom: 0; left: 0;
            width: 100%; height: 4mm;
            background-color: #1A6D9B;
        }
        .ftr-gold {
            position: absolute;
            bottom: 4mm; left: 0;
            width: 100%; height: 1mm;
            background-color: #D4A017;
        }

        /* Semua konten menggunakan flow biasa (relative) */
        .front-body {
            position: relative;
            width: 100%;
            text-align: center;
        }

        /* Logo */
        .logo-wrap {
            padding-top: 4mm;
            padding-bottom: 3mm;
        }
        .logo-img {
            height: 12mm;
            object-fit: contain;
        }

        /* Foto */
        .photo-wrap {
            width: 100%;
            text-align: center;
            margin-bottom: 3mm;
        }
        .photo-box {
            display: inline-block;
            width: 28mm;
            height: 35mm;
            border: 2px solid #ffffff;
            border-radius: 2mm;
            overflow: hidden;
            background: #f1f5f9;
        }
        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .photo-placeholder {
            display: inline-block;
            width: 28mm;
            height: 35mm;
            border: 2px solid #e2e8f0;
            border-radius: 2mm;
            background: #f1f5f9;
            text-align: center;
            padding-top: 11mm;
            color: #94a3b8;
            font-size: 22pt;
            font-weight: bold;
        }

        /* Nama */
        .name {
            font-size: 10.5pt;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            line-height: 1.2;
            padding: 0 4mm;
            margin-bottom: 1mm;
            word-wrap: break-word;
        }
        .unit {
            font-size: 7pt;
            color: #64748b;
            padding: 0 5mm;
            margin-bottom: 2.5mm;
            line-height: 1.3;
            word-wrap: break-word;
        }

        /* Badge event */
        .pill-wrap {
            width: 100%;
            text-align: center;
            margin-bottom: 3mm;
        }
        .pill {
            display: inline-block;
            background-color: #1A6D9B;
            color: #ffffff;
            font-size: 6pt;
            font-weight: bold;
            padding: 1mm 3.5mm;
            border-radius: 1mm;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* QR Code */
        .qr-wrap {
            width: 100%;
            text-align: center;
        }
        .qr-box {
            display: inline-block;
            width: 28mm;
            height: 28mm;
            border: 1px solid #e2e8f0;
            padding: 1mm;
            background: #fff;
            border-radius: 1.5mm;
        }
        .qr-box img {
            width: 100%;
            height: 100%;
        }
        .scan-label {
            font-size: 6pt;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-top: 1.5mm;
        }

        /* ═══════════════════════════
           BACK SIDE
        ═══════════════════════════ */
        .card-back {
            width: 86mm;
            height: 137mm;
            background: #fff;
            overflow: hidden;
            position: relative;
        }
        .back-body {
            padding: 9mm 7mm 0;
        }
        .back-header {
            text-align: center;
            padding-bottom: 3mm;
            border-bottom: 2px solid #1A6D9B;
            margin-bottom: 4mm;
        }
        .back-logo {
            height: 13mm;
            object-fit: contain;
            margin-bottom: 1.5mm;
        }
        .back-title {
            font-size: 9.5pt;
            font-weight: 800;
            color: #1A6D9B;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .rules-title {
            font-size: 7.5pt;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            border-bottom: 1.5px solid #D4A017;
            padding-bottom: 1.5mm;
            margin-bottom: 3mm;
        }

        /* Tabel bullet untuk DomPDF — paling stabil */
        .rule-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1mm;
        }
        .rule-table td {
            padding: 0;
            vertical-align: top;
        }
        .rule-dot {
            width: 4mm;
            font-size: 11pt;
            color: #1A6D9B;
            font-weight: bold;
            padding-right: 1mm;
            line-height: 1.3;
        }
        .rule-text {
            font-size: 7.5pt;
            color: #334155;
            line-height: 1.4;
            padding-bottom: 2mm;
        }

        .back-footer {
            position: absolute;
            bottom: 9mm;
            left: 0;
            width: 100%;
            text-align: center;
        }
        .org {
            font-size: 7pt;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
        }
        .org-sub {
            font-size: 5.5pt;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 0.8mm;
            letter-spacing: 0.3px;
        }
    </style>
</head>
<body>

{{-- ═════════════ FRONT SIDE ═════════════ --}}
<div class="card-front page-break">

    {{-- Background elemen (absolute) --}}
    <div class="hdr-bg"></div>
    <div class="hdr-gold"></div>
    <div class="ftr-gold"></div>
    <div class="ftr-bar"></div>

    {{-- Konten mengalir normal --}}
    <div class="front-body">

        <div class="logo-wrap">
            <img src="{{ public_path('logo.webp') }}" class="logo-img" alt="Logo">
        </div>

        <div class="photo-wrap">
            @if($peserta->foto)
                <div class="photo-box">
                    <img src="{{ $peserta->foto_pdf_path }}" alt="Foto Peserta">
                </div>
            @else
                <div class="photo-placeholder">?</div>
            @endif
        </div>

        <div class="name">{{ $peserta->nama_lengkap }}</div>
        <div class="unit">{{ $peserta->unit_kerja ?? 'Peserta Baitul Arqam' }}</div>

        <div class="pill-wrap">
            <span class="pill">{{ Str::limit($event->nama_event, 42) }}</span>
        </div>

        <div class="qr-wrap">
            @php
                $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(90)->margin(0)->generate($qrData);
            @endphp
            <div class="qr-box">
                <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
            </div>
            <div class="scan-label">Scan untuk Presensi</div>
        </div>

    </div>
</div>

{{-- ═════════════ BACK SIDE ═════════════ --}}
<div class="card-back">

    <div class="ftr-gold"></div>
    <div class="ftr-bar"></div>

    <div class="back-body">

        <div class="back-header">
            <img src="{{ public_path('logo-mpksdi-1.png') }}" class="back-logo" alt="Logo MPKSDI">
            <div class="back-title">Baitul Arqam Terpadu</div>
        </div>

        <div class="rules-title">Tata Tertib</div>

        <table class="rule-table">
            <tr>
                <td class="rule-dot">•</td>
                <td class="rule-text">ID Card wajib dikenakan selama acara berlangsung.</td>
            </tr>
            <tr>
                <td class="rule-dot">•</td>
                <td class="rule-text">Presensi kehadiran dilakukan melalui scan QR Code.</td>
            </tr>
            <tr>
                <td class="rule-dot">•</td>
                <td class="rule-text">Hadir di ruangan 15 menit sebelum materi dimulai.</td>
            </tr>
            <tr>
                <td class="rule-dot">•</td>
                <td class="rule-text">Menjaga ketenangan dan adab selama sesi materi.</td>
            </tr>
            <tr>
                <td class="rule-dot">•</td>
                <td class="rule-text">Dilarang merokok di seluruh area kegiatan.</td>
            </tr>
            <tr>
                <td class="rule-dot">•</td>
                <td class="rule-text">Menjaga kebersihan dan fasilitas di lokasi acara.</td>
            </tr>
        </table>

    </div>

    <div class="back-footer">
        <div class="org">Majelis Pendidikan Kader &amp; SDI</div>
        <div class="org-sub">Pimpinan Daerah Muhammadiyah Karanganyar</div>
    </div>

</div>

</body>
</html>
