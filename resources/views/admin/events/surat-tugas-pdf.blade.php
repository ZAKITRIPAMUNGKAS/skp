<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Tugas Fasilitator - {{ $event->nama_event }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10.5pt;
            color: #333;
            line-height: 1.5;
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
        .ums-title-large {
            font-size: 32pt;
            font-weight: bold;
            color: #0b3a75;
            font-family: Arial, Helvetica, sans-serif;
            letter-spacing: -1.5px;
            line-height: 0.8;
            margin: 0;
        }
        .ums-subtitle-large {
            font-size: 7.5pt;
            font-weight: bold;
            color: #0b3a75;
            text-transform: uppercase;
            margin-top: 4px;
            letter-spacing: 0.2px;
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
            margin-bottom: 25px;
            margin-top: 5px;
        }
        /* Judul Surat */
        .surat-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .surat-title {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            color: #111;
            letter-spacing: 0.5px;
        }
        .surat-number {
            font-size: 9.5pt;
            margin-top: 4px;
            color: #333;
            font-weight: bold;
        }
        /* Isi Surat */
        .surat-body {
            margin-bottom: 25px;
            text-align: justify;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .table-data th, .table-data td {
            border: 1px solid #cccccc;
            padding: 8px 10px;
            text-align: left;
            font-size: 9.5pt;
        }
        .table-data th {
            background-color: #f2f5fa;
            font-weight: bold;
            color: #0b3a75;
        }
        .table-data tr:nth-child(even) {
            background-color: #fafafa;
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
        .social-icon {
            vertical-align: middle;
            margin-right: 4px;
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

        {{-- Judul Surat --}}
        <div class="surat-header">
            <h2 class="surat-title">SURAT TUGAS</h2>
            <div class="surat-number">Nomor: ST/{{ date('Y') }}/{{ str_pad($event->id, 4, '0', STR_PAD_LEFT) }}</div>
        </div>

        {{-- Isi Surat --}}
        <div class="surat-body">
            {{-- Assalamualaikum as Indonesian Text --}}
            <p style="margin-top: 0; font-weight: bold; font-style: italic;">Assalamu'alaikum Wr. Wb.</p>

            <p style="text-indent: 30px;">Lembaga Pengembangan Pembinaan Al-Islam dan Kemuhammadiyahan (LP3A) Universitas Muhammadiyah Surakarta dengan ini menugaskan kepada nama-nama berikut:</p>

            <table class="table-data">
                <thead>
                    <tr>
                        <th style="width: 8%; text-align: center;">No</th>
                        <th>Nama Lengkap</th>
                        <th>Alamat Email</th>
                        <th>Peran Tugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facilitators as $index => $f)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td style="font-weight: bold;">{{ $f->name }}</td>
                            <td>{{ $f->email }}</td>
                            <td>Fasilitator / Pendamping Lapangan</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #999; font-style: italic;">Belum ada fasilitator yang ditugaskan untuk event ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <p>Untuk bertindak sebagai <strong>Fasilitator / Pendamping</strong> pada kegiatan <strong>{{ $event->nama_event }}</strong>, yang akan dilaksanakan pada:</p>
            
            <table style="border: none; margin-left: 20px; font-size: 10pt; margin-bottom: 15px;">
                <tr>
                    <td style="padding: 2px 10px 2px 0; font-weight: bold; width: 80px; border: none; background: transparent;">Tanggal</td>
                    <td style="padding: 2px 5px; border: none; background: transparent;">:</td>
                    <td style="padding: 2px 10px; border: none; background: transparent;">
                        {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d F Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d F Y') }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 2px 10px 2px 0; font-weight: bold; border: none; background: transparent;">Tempat</td>
                    <td style="padding: 2px 5px; border: none; background: transparent;">:</td>
                    <td style="padding: 2px 10px; border: none; background: transparent;">{{ $event->lokasi ?? 'Ditentukan Panitia' }}</td>
                </tr>
            </table>

            <p style="margin-top: 15px; margin-bottom: 0; text-indent: 30px;">Demikian surat tugas ini dibuat untuk dilaksanakan dengan seksama dan penuh rasa tanggung jawab. Semoga Allah SWT senantiasa memberikan kemudahan dan petunjuk dalam menjalankan amanah ini.</p>
        </div>

        {{-- Ending Greeting & Signature Block Side-by-Side --}}
        <table style="width: 100%; border: none; border-collapse: collapse; margin-top: 25px;">
            <tr>
                <td style="width: 45%; vertical-align: top; text-align: left; border: none; background: transparent; padding: 0; font-weight: bold; font-style: italic; padding-top: 8px;">
                    Wassalamu'alaikum Wr. Wb.
                </td>
                <td style="width: 55%; vertical-align: top; text-align: left; border: none; background: transparent; padding: 0; padding-left: 40px; font-size: 10pt; line-height: 1.4;">
                    <div>Surakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                    <div style="font-weight: bold; margin-top: 3px;">
                        Kabid. Kaderisasi, Pembinaan Ortom<br>dan Beasiswa Kader
                    </div>
                    <div style="height: 40px; font-style: italic; color: #777; padding-top: 12px; font-size: 9pt;"></div>
                    <div style="font-weight: bold; font-size: 10.5pt; text-decoration: none;">Azizah Fatmawati, S.T., M.Cs</div>
                    <div style="font-size: 9pt; color: #555; margin-top: 1px;">NIDN. 0626118101</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
