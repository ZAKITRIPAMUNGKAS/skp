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
        .header {
            position: relative;
            border-bottom: 3px double #1A6D9B;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .logo-section {
            margin-right: 150px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #1A6D9B;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 12px;
            color: #4b5563;
            font-weight: bold;
        }
        .mascot {
            position: absolute;
            top: -10px;
            right: 0;
            width: 100px;
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

    <div class="header">
        <div class="logo-section">
            <h1>LAPORAN HASIL EVALUASI</h1>
            <h2>MAJELIS PENDIDIKAN KADER - PP MUHAMMADIYAH</h2>
            <p style="margin: 0; font-size: 9px; color: #6b7280;">Sistem Informasi Perkaderan ARQAM Digital</p>
        </div>
        <img src="{{ public_path('images/arka/arka_penilai.png') }}" class="mascot">
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
