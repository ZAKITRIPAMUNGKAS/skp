<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Angket Peserta - {{ $event->nama_event }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .page {
            page-break-after: always;
            position: relative;
            padding: 30px 45px 50px 45px;
            box-sizing: border-box;
            min-height: 297mm;
        }
        .page:last-child {
            page-break-after: avoid;
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
        /* Judul Laporan */
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
            color: #0b3a75;
            font-weight: bold;
        }
        /* Identitas Peserta */
        .box-peserta {
            width: 100%;
            border-left: 5px solid #0b3a75;
            background-color: #f4f7fa;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 0 4px 4px 0;
        }
        .box-peserta h2 {
            font-size: 13pt;
            font-weight: bold;
            margin: 0 0 5px 0;
            color: #111;
        }
        .box-peserta p {
            font-size: 9.5pt;
            color: #555;
            margin: 2px 0;
        }
        .box-peserta p strong {
            display: inline-block;
            width: 90px;
            color: #444;
        }

        /* Tabel Data Angket */
        .tabel-angket {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .tabel-angket th, .tabel-angket td {
            border: 1px solid #cccccc;
            padding: 7px 10px;
            text-align: left;
            font-size: 9pt;
        }
        .tabel-angket th {
            background-color: #f2f5fa;
            font-weight: bold;
            color: #0b3a75;
            text-transform: uppercase;
            font-size: 8.5pt;
            letter-spacing: 0.2px;
        }
        .tabel-angket td.no {
            width: 6%;
            text-align: center;
            font-weight: bold;
            color: #555;
        }
        .tabel-angket td.item {
            width: 64%;
        }
        .tabel-angket td.jawaban {
            width: 30%;
            text-align: center;
            font-weight: bold;
        }
        .tabel-angket tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Komentar Box */
        .komentar-box {
            background-color: #fbfbfb;
            border-left: 4px solid #ffd000;
            padding: 10px 15px;
            border-radius: 0 4px 4px 0;
            border: 1px solid #eaeaea;
        }
        .komentar-title {
            font-size: 8.5pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #555;
            margin-bottom: 4px;
        }
        .komentar-content {
            font-family: Georgia, serif;
            font-size: 10pt;
            font-style: italic;
            color: #222;
            line-height: 1.5;
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

@forelse($participants as $idx => $ep)
@php
    $p = $ep->peserta;
    $noUrut = $idx + 1;
    $totalAll = $participants->count();
    
    // Cari komentar evaluasi peserta ini
    $komentarObj = $komentars->where('peserta_id', $p->id)->first();
    $komentarTeks = $komentarObj ? $komentarObj->komentar : '— (Tidak ada saran/komentar tertulis)';
@endphp

<div class="page">
    <!-- Top Left Accent Bar -->
    <div class="top-left-bar"></div>

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

    {{-- Judul Laporan --}}
    <div class="surat-header">
        <h2 class="surat-title">LAPORAN ANGKET PESERTA</h2>
        <div class="surat-number">{{ $event->nama_event }}</div>
        <div style="font-size: 9pt; margin-top: 3px; color: #555; font-weight: bold;">Halaman {{ $noUrut }} dari {{ $totalAll }}</div>
    </div>

    <!-- IDENTITAS PESERTA -->
    <div class="box-peserta">
        <h2>{{ $p->nama_lengkap }}</h2>
        <p><strong>NIP/NBM</strong>: {{ $p->nik ?? $p->nbm ?? '—' }}</p>
        <p><strong>UNIT KERJA</strong>: {{ $p->unit_kerja ?: '—' }}</p>
    </div>

    @php
        $categoryLabels = [
            'A' => 'Materi & Narasumber',
            'B' => 'Fasilitator',
            'C' => 'Panitia',
            'D' => 'Lokasi Baitul Arqam',
            'E' => 'Konsumsi',
            'F' => 'Kepuasan Pengguna',
            'G' => 'Dampak & Manfaat Kegiatan',
            'H' => 'Kejelasan Informasi & Panduan',
            'I' => 'Kepuasan Umum & Voting',
        ];
        $groupedItems = $angketItems->groupBy('kategori');
    @endphp

    <!-- TABEL JAWABAN ANGKET PER KATEGORI -->
    @foreach($groupedItems as $kategori => $itemsInGroup)
    <div style="margin-bottom: 12px; page-break-inside: avoid;">
        <h3 style="font-size: 8.5pt; font-weight: bold; margin-bottom: 5px; color: #0b3a75; border-left: 3px solid #0b3a75; padding-left: 6px; text-transform: uppercase;">
            {{ $kategori }} - {{ $categoryLabels[$kategori] ?? 'Kategori ' . $kategori }}
        </h3>
        <table class="tabel-angket" style="margin-bottom: 0;">
            <thead>
                <tr>
                    <th style="width: 6%; text-align: center;">No</th>
                    <th>Item Evaluasi Penyelenggaraan</th>
                    <th style="width: 30%; text-align: center;">Tanggapan / Jawaban</th>
                </tr>
            </thead>
            <tbody>
                @foreach($itemsInGroup as $i => $item)
                @php
                    // Dapatkan jawaban peserta ini untuk item angket saat ini
                    $jawabObj = $jawabanAngket->where('peserta_id', $p->id)->where('item_id', $item->id)->first();
                    $jawabCode = $jawabObj ? $jawabObj->jawaban : '—';
                    
                    // Konversi kode jawaban ke teks keterangan yang mudah dipahami
                    $mapLabel = [
                        'A' => 'Sangat Baik (A)',
                        'B' => 'Baik (B)',
                        'C' => 'Cukup (C)',
                        'D' => 'Kurang (D)'
                    ];
                    $jawabLabel = $mapLabel[$jawabCode] ?? 'Belum Mengisi';
                    
                    // Warna kontras
                    $colorJawab = $jawabCode === 'A' ? '#10B981' : ($jawabCode === 'B' ? '#059669' : ($jawabCode === 'C' ? '#D97706' : '#EF4444'));
                @endphp
                <tr>
                    <td class="no">{{ $loop->iteration }}</td>
                    <td class="item">{{ $item->teks_item }}</td>
                    <td class="jawaban" style="color: {{ $colorJawab }};">{{ $jawabLabel }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach

    <!-- KOTAK KOMENTAR & MASKOT (Berdampingan agar menghemat ruang halaman) -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 15px; page-break-inside: avoid;">
        <tr>
            <td style="width: 78%; vertical-align: top; padding-right: 15px;">
                <div class="komentar-box">
                    <div class="komentar-title">Saran &amp; Komentar Peserta terhadap Acara:</div>
                    <div class="komentar-content">
                        "{{ $komentarTeks }}"
                    </div>
                </div>
            </td>
            <td style="width: 22%; vertical-align: middle; padding-left: 15px; text-align: center;">
                <img src="{{ public_path('images/arka/arka_analisis.png') }}" style="height: 70px; width: auto; object-fit: contain;" alt="Arqa Mascot" onerror="this.style.display='none'">
            </td>
        </tr>
    </table>

    {{-- Footer Accent at the very bottom --}}
    <div class="footer-fixed">
        <table class="footer-social-table">
            <tr>
                <td>
                    <!-- Globe Web Icon -->
                    <span style="display: inline-block; width: 12px; height: 12px; margin-right: 4px; vertical-align: middle;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#0b3a75" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 12px; height: 12px; display: block;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                    </span>
                    lp3a.ums.ac.id
                </td>
                <td>
                    <!-- Instagram Icon -->
                    <span style="display: inline-block; width: 12px; height: 12px; margin-right: 4px; vertical-align: middle;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#0b3a75" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 12px; height: 12px; display: block;">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </span>
                    @lp3aums
                </td>
                <td>
                    <!-- Email Icon -->
                    <span style="display: inline-block; width: 12px; height: 12px; margin-right: 4px; vertical-align: middle;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#0b3a75" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 12px; height: 12px; display: block;">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </span>
                    lp3a@ums.ac.id
                </td>
            </tr>
        </table>
        <div class="footer-yellow-bar"></div>
    </div>
</div>

@empty
<div style="padding: 80px 20px; text-align: center;">
    <p style="font-family: Georgia, serif; font-size: 18pt; color: #1e293b; margin-bottom: 8px;">Belum Ada Data Angket</p>
    <p style="font-size: 10pt; color: #64748B;">Tidak ditemukan pengisian angket pada kegiatan ini.</p>
</div>
@endforelse

</body>
</html>
