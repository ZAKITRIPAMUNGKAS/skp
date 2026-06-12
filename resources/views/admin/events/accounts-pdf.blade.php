<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Akun Peserta - {{ $event->nama_event }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .container {
            padding: 30px 45px 50px 45px;
            position: relative;
        }
        /* Top Left Yellow Accent Bar */
        .top-left-bar {
            position: absolute;
            top: 0;
            left: 0;
            width: 15px;
            height: 105px;
            background-color: #ffd000;
        }
        /* Kop Surat */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .kop-table td {
            border: none !important;
            background: transparent !important;
            padding: 0 !important;
        }
        .kop-logo-container {
            width: 45%;
            vertical-align: middle;
            text-align: left;
            padding-left: 10px;
        }
        .kop-info-container {
            width: 55%;
            vertical-align: middle;
            text-align: right;
            line-height: 1.3;
        }
        .kop-dept-title {
            font-size: 9.5pt;
            font-weight: bold;
            color: #0b3a75;
            margin: 0;
        }
        .kop-dept-subtitle {
            font-size: 8.5pt;
            font-weight: bold;
            color: #444444;
            margin: 2px 0 0 0;
        }
        .kop-address {
            font-size: 6.8pt;
            color: #666666;
            margin-top: 4px;
            line-height: 1.4;
        }
        .header-line {
            border-bottom: 2px solid #0b3a75;
            margin-bottom: 20px;
            margin-top: 5px;
        }
        
        /* Judul Halaman */
        .title-header {
            text-align: center;
            margin-bottom: 15px;
        }
        .title-text {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            color: #0b3a75;
            letter-spacing: 0.5px;
        }
        .title-meta {
            font-size: 9.5pt;
            margin-top: 4px;
            color: #333;
            font-weight: bold;
        }

        /* Info Kredensial */
        .info-box {
            background-color: #f2f5fa;
            border-radius: 6px;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #d0daf0;
        }
        .info-box p {
            margin: 0 0 6px 0;
            line-height: 1.4;
            font-size: 9.5pt;
        }
        .password-highlight {
            display: inline-block;
            background-color: #fef2f2;
            color: #dc2626;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: bold;
            border: 1px dashed #f87171;
            font-size: 9pt;
        }

        /* Table Data */
        table.table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            page-break-inside: auto;
        }
        table.table-data th, table.table-data td {
            border: 1px solid #cccccc;
            padding: 7px 9px;
            font-size: 9pt;
            vertical-align: middle;
        }
        table.table-data th {
            background-color: #0b3a75;
            color: white;
            font-weight: bold;
            text-align: left;
            text-transform: uppercase;
        }
        table.table-data tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        table.table-data thead {
            display: table-header-group;
        }
        table.table-data tr:nth-child(even) {
            background-color: #fafafa;
        }
        
        .username-badge {
            background-color: #e0f2fe;
            color: #0369a1;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
        }

        /* Footer fixed position at the page bottom */
        .footer-fixed {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #ffffff;
            text-align: center;
        }
        .footer-social-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        .footer-social-table td {
            text-align: center;
            font-size: 8pt;
            color: #0b3a75;
            font-weight: bold;
            border: none !important;
            background: transparent !important;
            padding: 0 !important;
            vertical-align: middle;
        }
        .footer-yellow-bar {
            width: 100%;
            height: 10px;
            background-color: #ffd000;
        }
    </style>
</head>
<body>
    <!-- Top Left Accent Bar -->
    <div class="top-left-bar"></div>

    <div class="container">
        {{-- Kop Surat --}}
        <table class="kop-table">
            <tr>
                <td class="kop-logo-container">
                    <table style="border: none; border-collapse: collapse;">
                        <tr style="vertical-align: middle; padding: 0; border: none; background: transparent;">
                            <img src="{{ public_path('logo.png') }}" style="width: 200px; height: auto;" alt="Logo UMS">
                        </tr>
                    </table>
                </td>
                <td class="kop-info-container">
                    <h1 class="kop-dept-title">Lembaga Pengembangan Pembinaan Al-Islam & Kemuhammadiyahan (LP3A)</h1>
                    <div class="kop-dept-subtitle">Universitas Muhammadiyah Surakarta</div>
                    <div class="kop-address">
                        Gedung Induk Siti Walidah Lantai 3 Sayap Selatan, Jl. A. Yani No.157, Pabelan, Kartasura, Sukoharjo 57162, Jawa Tengah<br>
                        Telp. +62 271-717417 | E-mail: lp3a@ums.ac.id | Website: https://lp3a.ums.ac.id
                    </div>
                </td>
            </tr>
        </table>

        {{-- Divider Line --}}
        <div class="header-line"></div>

        {{-- Judul --}}
        <div class="title-header">
            <h2 class="title-text">DAFTAR AKUN PESERTA</h2>
            <div class="title-meta">Event: {{ $event->nama_event }}</div>
        </div>

        <div class="info-box">
            <p style="margin-bottom: 8px;">Berikut adalah kredensial login untuk masing-masing peserta. Gunakan <strong>Username</strong> di bawah ini untuk masuk ke aplikasi.</p>
            <table style="width: 100%; border: none; border-collapse: collapse; margin-top: 0;">
                <tr style="border: none; background: transparent;">
                    <td style="width: 215px; padding: 0; border: none; background: transparent; vertical-align: middle; white-space: nowrap;">
                        <span class="password-highlight" style="white-space: nowrap;">Password: 4 Digit Terakhir NIK</span>
                    </td>
                    <td style="padding: 0; border: none; background: transparent; vertical-align: middle; padding-left: 10px; color: #666; font-size: 8.5pt;">
                        *Jika NIK belum terisi di sistem, password default adalah <strong>{{ $defaultPassword }}</strong>.
                    </td>
                </tr>
            </table>
        </div>

        <table class="table-data">
            <thead>
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <th style="width: 35%;">Nama Lengkap</th>
                    <th style="width: 20%;">Username (Login)</th>
                    <th style="width: 15%;">Password</th>
                    <th style="width: 25%;">Email / NIK</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participants as $index => $ep)
                    @php
                        $nik = $ep->peserta->nik;
                        $cleanedNik = preg_replace('/[^0-9]/', '', $nik);
                        if (strlen($cleanedNik) >= 4) {
                            $passText = substr($cleanedNik, -4);
                        } elseif (strlen($cleanedNik) > 0) {
                            $passText = $cleanedNik;
                        } else {
                            $passText = $defaultPassword;
                        }
                    @endphp
                    <tr>
                        <td style="text-align: center; color: #666;">{{ $index + 1 }}</td>
                        <td><strong style="color: #111;">{{ $ep->peserta->nama_lengkap }}</strong></td>
                        <td><span class="username-badge">{{ $ep->peserta->user->username ?? '-' }}</span></td>
                        <td><span class="username-badge" style="background-color: #fef2f2; color: #dc2626; border: 1px dashed #f87171;">{{ $passText }}</span></td>
                        <td style="color: #555; font-size: 8.5pt;">
                            {{ $ep->peserta->user->email }}<br>
                            <span style="color: #777;">NIK: {{ $nik ?? '-' }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
