<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Hasil Evaluasi - {{ $event->nama_event }}</title>
    <style>
        @page { margin: 30px; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 10px; 
            color: #333;
            line-height: 1.4;
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
        .event-details {
            width: 100%;
            margin-bottom: 20px;
            background-color: #f9fafb;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        .event-details td {
            padding: 3px 8px;
        }
        .label {
            font-weight: bold;
            color: #374151;
            width: 100px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.data-table th {
            background-color: #1A6D9B;
            color: white;
            padding: 8px 4px;
            text-align: center;
            font-size: 9px;
            text-transform: uppercase;
            border: 1px solid #155C84;
        }
        table.data-table td {
            border: 1px solid #e5e7eb;
            padding: 6px 4px;
            text-align: center;
        }
        .text-left { text-align: left !important; }
        .font-bold { font-weight: bold; }
        .row-even { background-color: #f9fafb; }
        
        .predikat-amat-baik { color: #1A6D9B; font-weight: bold; }
        .predikat-baik { color: #2563eb; font-weight: bold; }
        .predikat-cukup { color: #d97706; font-weight: bold; }
        .predikat-kurang { color: #dc2626; font-weight: bold; }
        
        .status-lulus { color: #1A6D9B; font-weight: bold; }
        .status-tidak { color: #dc2626; font-weight: bold; }
        
        .footer {
            margin-top: 40px;
            width: 100%;
        }
        .signature-wrapper {
            float: right;
            width: 200px;
            text-align: center;
        }
        .signature-space {
            height: 70px;
        }
        .clear { clear: both; }
    </style>
</head>
<body>

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
        <h2 class="surat-title">LAPORAN HASIL EVALUASI</h2>
    </div>

    <table class="event-details">
        <tr>
            <td class="label">Nama Kegiatan</td>
            <td style="width: 300px;">: {{ $event->nama_event }}</td>
            <td class="label">Total Peserta</td>
            <td>: {{ $penilaian->count() }} Orang</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td>: {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }}</td>
            <td class="label">Lokasi</td>
            <td>: {{ $event->lokasi }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;">Rank</th>
                <th class="text-left">Nama Peserta</th>
                <th class="text-left">Instansi</th>
                <th>Pre</th>
                <th>Post</th>
                <th>Gain</th>
                <th>Afk</th>
                <th>Psi</th>
                <th>Hdr</th>
                <th>Skor</th>
                <th>Predikat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penilaian as $index => $row)
            <tr class="{{ $index % 2 == 1 ? 'row-even' : '' }}">
                <td class="font-bold">{{ $row->ranking ?: ($index + 1) }}</td>
                <td class="text-left font-bold">{{ $row->peserta->nama_lengkap ?? '-' }}</td>
                <td class="text-left" style="font-size: 9px;">{{ $row->peserta->unit_kerja ?? '-' }}</td>
                <td>{{ number_format($row->nilai_pretest, 0) }}</td>
                <td>{{ number_format($row->nilai_posttest, 0) }}</td>
                <td class="font-bold">{{ number_format($row->n_gain_score, 2) }}</td>
                <td>{{ number_format($row->nilai_afektif, 0) }}</td>
                <td>{{ number_format($row->nilai_psikomotor, 0) }}</td>
                <td>{{ number_format($row->nilai_kehadiran, 0) }}</td>
                <td class="font-bold">{{ number_format($row->skor_saw * 100, 1) }}</td>
                <td>
                    @php
                        $pClass = '';
                        if($row->predikat == 'Amat Baik') $pClass = 'predikat-amat-baik';
                        elseif($row->predikat == 'Baik') $pClass = 'predikat-baik';
                        elseif($row->predikat == 'Cukup') $pClass = 'predikat-cukup';
                        elseif($row->predikat == 'Kurang') $pClass = 'predikat-kurang';
                    @endphp
                    <span class="{{ $pClass }}">{{ $row->predikat }}</span>
                </td>
                <td>
                    <span class="{{ str_contains($row->status_kelulusan, 'Tidak') ? 'status-tidak' : 'status-lulus' }}">
                        {{ $row->status_kelulusan ?: 'N/A' }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="padding: 30px;">Belum ada data evaluasi tersedia.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-wrapper">
            <p>{{ $event->lokasi }}, {{ now()->format('d M Y') }}</p>
            <p>Master of Training,</p>
            <div class="signature-space"></div>
            <p class="font-bold">( __________________________ )</p>
        </div>
        <div class="clear"></div>
        
        <p style="margin-top: 50px; font-size: 8px; color: #9ca3af; text-align: center;">
            Dokumen ini dihasilkan secara otomatis oleh Sistem ARQAM App.<br>
            Keaslian data dapat diverifikasi melalui sistem administrasi pusat.
        </p>
    </div>

</body>
</html>
