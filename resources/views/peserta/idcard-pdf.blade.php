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
            line-height: 1.3;
        }

        .page-break { page-break-after: always; }

        /* ═══ FRONT CARD ═══ */
        .card-front {
            width: 86mm;
            height: 137mm;
            overflow: hidden;
            position: relative;
            background: #fff;
        }

        /* Background image covers full card */
        .card-bg {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
        }

        /* All content sits above bg */
        .card-content {
            position: relative;
            z-index: 1;
            width: 100%;
            text-align: center;
            padding-top: 16mm;
        }

        /* ── PESERTA label ── */
        .lbl-peserta {
            font-size: 22pt;
            font-weight: 900;
            color: #0d3a73;
            letter-spacing: 2px;
            text-transform: uppercase;
            line-height: 1;
            margin-bottom: 0.5mm;
        }

        /* ── Event name ── */
        .lbl-event {
            font-size: 11pt;
            font-weight: 900;
            color: #0d3a73;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.1;
            padding: 0 3mm;
            margin-bottom: 0.5mm;
        }

        /* ── Lokasi & Tanggal ── */
        .lbl-place {
            font-size: 8pt;
            font-weight: 700;
            color: #1a5276;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            line-height: 1;
            margin-bottom: 3mm;
        }

        /* ── Foto Kotak (1:1) ── */
        .photo-area {
            width: 100%;
            text-align: center;
            margin-bottom: 4mm;
        }
        .photo-square {
            display: inline-block;
            width: 30mm;
            height: 30mm;
            border-radius: 2mm;
            overflow: hidden;
            border: 2.5px solid #ffffff;
            box-shadow: 0 3px 10px rgba(0,0,0,0.18);
            background-color: #ffffff;
            position: relative;
        }
        .photo-square img {
            width: 100%;
            height: auto;
            min-height: 100%;
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            display: block;
        }
        .photo-placeholder {
            display: inline-block;
            width: 30mm;
            height: 30mm;
            border-radius: 2mm;
            border: 2.5px solid #ffffff;
            background: #dbeafe;
            text-align: center;
            padding-top: 7mm;
            color: #1a5276;
            font-size: 18pt;
            font-weight: bold;
        }

        /* ── Nickname badge ── */
        .nickname-area {
            margin-bottom: 3.5mm;
        }
        .nickname-badge {
            display: inline-block;
            background: #f5b300;
            color: #ffffff;
            font-size: 16pt;
            font-weight: 900;
            padding: 1.5mm 8mm;
            border-radius: 2.5mm;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        /* ── Nama Lengkap ── */
        .full-name {
            font-size: 10.5pt;
            font-weight: 900;
            color: #0d3a73;
            text-transform: uppercase;
            padding: 0 4mm;
            margin-bottom: 1.2mm;
            line-height: 1.2;
            word-wrap: break-word;
        }

        /* ── Unit Kerja ── */
        .unit-text {
            font-size: 7.5pt;
            color: #1a5276;
            font-weight: 600;
            padding: 0 5mm;
            margin-bottom: 2mm;
            line-height: 1.3;
        }

        /* ── QR Code ── */
        .qr-area {
            width: 100%;
            text-align: center;
        }
        .qr-box {
            display: inline-block;
            width: 25mm;
            height: 25mm;
            border: 1px solid #93c5fd;
            padding: 1mm;
            background: #fff;
            border-radius: 1.5mm;
        }
        .qr-box img {
            width: 100%;
            height: 100%;
        }

        /* ═══ BACK CARD ═══ */
        .card-back {
            width: 86mm;
            height: 137mm;
            overflow: hidden;
            position: relative;
            background: #fff;
        }
        .back-body {
            position: relative;
            z-index: 1;
            padding: 9mm 7mm 0;
        }
        .rules-title {
            font-size: 7.5pt;
            font-weight: 800;
            color: #0d3a73;
            text-transform: uppercase;
            border-bottom: 1.5px solid #f5b300;
            padding-bottom: 1.5mm;
            margin-bottom: 3mm;
        }
        .rule-table {
            width: 100%;
            border-collapse: collapse;
        }
        .rule-table td {
            padding: 0;
            vertical-align: top;
        }
        .rule-dot {
            width: 4mm;
            font-size: 11pt;
            color: #0d3a73;
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
    </style>
</head>
<body>

@php
    $idcardBgPath = public_path('IDCARD.png');
    $idcardBg = file_exists($idcardBgPath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($idcardBgPath))
        : '';
@endphp

{{-- ═════════════ FRONT SIDE ═════════════ --}}
<div class="card-front page-break">

    {{-- Background image --}}
    <img class="card-bg" src="{{ $idcardBg }}">

    {{-- Content --}}
    <div class="card-content">

        {{-- PESERTA --}}
        <div class="lbl-peserta">PESERTA</div>

        {{-- Nama Event --}}
        <div class="lbl-event">{{ $event->nama_event }}</div>

        {{-- Lokasi & Tanggal --}}
        <div class="lbl-place">
            {{ $event->lokasi }},
            @if($event->tanggal_mulai && $event->tanggal_selesai)
                @if($event->tanggal_mulai->format('m Y') === $event->tanggal_selesai->format('m Y'))
                    {{ $event->tanggal_mulai->format('d') }}-{{ $event->tanggal_selesai->format('d M Y') }}
                @else
                    {{ $event->tanggal_mulai->format('d M Y') }} - {{ $event->tanggal_selesai->format('d M Y') }}
                @endif
            @elseif($event->tanggal_mulai)
                {{ $event->tanggal_mulai->format('d M Y') }}
            @endif
        </div>

        {{-- Foto Kotak --}}
        <div class="photo-area">
            @if($peserta->foto && $peserta->foto_base64)
                <div class="photo-square">
                    <img src="{{ $peserta->foto_base64 }}" alt="Foto">
                </div>
            @else
                <div class="photo-placeholder">?</div>
            @endif
        </div>

        {{-- Nickname --}}
        @if($peserta->nama_panggilan)
            <div class="nickname-area">
                <span class="nickname-badge">{{ $peserta->nama_panggilan }}</span>
            </div>
        @endif

        {{-- Nama Lengkap --}}
        <div class="full-name">{{ $peserta->nama_lengkap }}</div>

        {{-- Unit Kerja --}}
        <div class="unit-text">{{ $peserta->unit_kerja ?? 'Peserta Baitul Arqam' }}</div>

        {{-- QR Code murni --}}
        <div class="qr-area">
            @php
                $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                    ->errorCorrection('M')
                    ->size(100)
                    ->margin(0)
                    ->generate($qrData);
            @endphp
            <div class="qr-box">
                <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
            </div>
        </div>

    </div>

</div>

{{-- ═════════════ BACK SIDE ═════════════ --}}
<div class="card-back">
    <img class="card-bg" src="{{ $idcardBg }}">

    <div class="back-body">
        <div class="rules-title" style="padding-top: 15mm;">Tata Tertib</div>
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
                <td class="rule-text">Hadir di ruangan 5 menit sebelum materi dimulai.</td>
            </tr>
            <tr>
                <td class="rule-dot">•</td>
                <td class="rule-text">Menjaga ketenangan dan adab selama sesi materi.</td>
            </tr>
            <tr>
                <td class="rule-dot">•</td>
                <td class="rule-text">Tidak mengoperasikan HP selama sesi berlangsung.</td>
            </tr>
            <tr>
                <td class="rule-dot">•</td>
                <td class="rule-text">Menjaga kebersihan dan fasilitas di lokasi acara.</td>
            </tr>
        </table>
        <div style="text-align: center; margin-top: 15px;">
              <img style="width: 90%;" src="{{ public_path('kata.png') }}" alt="Kata Penutup">
        </div>
    </div>
</div>

</body>
</html>
