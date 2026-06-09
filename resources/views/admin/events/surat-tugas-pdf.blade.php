<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Tugas Fasilitator - {{ $event->nama_event }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 10px 30px;
        }
        /* Kop Surat */
        .kop-table {
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 25px;
        }
        .kop-table td {
            border: none !important;
            background: transparent !important;
            padding: 0 !important;
        }
        .kop-title {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #114B32;
            margin: 0;
            line-height: 1.3;
        }
        .kop-subtitle {
            font-size: 11.5pt;
            margin: 3px 0 0 0;
            font-weight: bold;
            color: #000;
        }
        .kop-address {
            font-size: 7.5pt;
            margin: 5px 0 0 0;
            color: #555;
            font-style: italic;
        }
        /* Judul Surat */
        .surat-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .surat-title {
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin: 0;
        }
        .surat-number {
            font-size: 9.5pt;
            margin-top: 4px;
            color: #444;
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
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
            font-size: 10pt;
        }
        .table-data th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #114B32;
        }
        .table-data tr:nth-child(even) {
            background-color: #fafafa;
        }
        /* Tanda Tangan */
        .signature-container {
            margin-top: 40px;
            width: 100%;
        }
        .signature-table {
            width: 100%;
            border: none;
        }
        .signature-table td {
            border: none !important;
            background: transparent !important;
            width: 50%;
            text-align: center;
            font-size: 10.5pt;
            padding: 0 !important;
        }
        .signature-space {
            height: 65px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }
        .signature-nip {
            font-size: 9pt;
            color: #555;
        }
        /* Footer */
        .footer-note {
            position: fixed;
            bottom: -15px;
            left: 30px;
            right: 30px;
            text-align: center;
            font-size: 7.5pt;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 6px;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Kop Surat --}}
        <table class="kop-table">
            <tr>
                <td style="width: 15%; text-align: left; vertical-align: middle;">
                    <img src="https://upload.wikimedia.org/wikipedia/id/8/8a/Logo_UMS.png" style="width: 70px; height: auto;" alt="Logo UMS">
                </td>
                <td style="width: 85%; text-align: center; vertical-align: middle;">
                    <h1 class="kop-title">LEMBAGA PENGEMBANGAN PERSYARIKATAN PENGKADERAN & ALUMNI</h1>
                    <div class="kop-subtitle">UNIVERSITAS MUHAMMADIYAH SURAKARTA</div>
                    <div class="kop-address">Jl. A. Yani, Pabelan, Kartasura, Sukoharjo, Jawa Tengah 57162 | Telp: (0271) 717417 | Email: lpppa@ums.ac.id</div>
                </td>
            </tr>
        </table>

        {{-- Judul Surat --}}
        <div class="surat-header">
            <h2 class="surat-title">SURAT TUGAS</h2>
            <div class="surat-number">Nomor: ST/{{ date('Y') }}/{{ str_pad($event->id, 4, '0', STR_PAD_LEFT) }}</div>
        </div>

        {{-- Isi Surat --}}
        <div class="surat-body">
            <p style="margin-top: 0;">Bismillahirrohmanirrohim,</p>
            <p>Lembaga Pengembangan Persyarikatan Pengkaderan & Alumni (LPPPA) Universitas Muhammadiyah Surakarta dengan ini menugaskan kepada nama-nama berikut:</p>

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
            
            <table style="border: none; margin-left: 20px; font-size: 10.5pt;">
                <tr>
                    <td style="padding: 2px 10px 2px 0; font-weight: bold; width: 100px; border: none; background: transparent;">Tanggal</td>
                    <td style="padding: 2px 10px; border: none; background: transparent;">:</td>
                    <td style="padding: 2px 10px; border: none; background: transparent;">
                        {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d F Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d F Y') }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 2px 10px 2px 0; font-weight: bold; border: none; background: transparent;">Tempat</td>
                    <td style="padding: 2px 10px; border: none; background: transparent;">:</td>
                    <td style="padding: 2px 10px; border: none; background: transparent;">{{ $event->lokasi ?? 'Ditentukan Panitia' }}</td>
                </tr>
            </table>

            <p style="margin-top: 20px; margin-bottom: 0;">Demikian surat tugas ini dibuat untuk dilaksanakan dengan seksama dan penuh rasa tanggung jawab. Semoga Allah SWT senantiasa memberikan kemudahan dan petunjuk dalam menjalankan amanah ini.</p>
        </div>

        {{-- Tanda Tangan --}}
        <div class="signature-container">
            <table class="signature-table">
                <tr>
                    <td>
                        {{-- Spacing kiri kosong --}}
                    </td>
                    <td>
                        <div>Surakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                        <div style="font-weight: bold; margin-top: 4px; line-height: 1.3;">
                            Kabid. Kaderisasi, Pembinaan Ortom<br>dan Beasiswa Kader
                        </div>
                        <div class="signature-space"></div>
                        <div class="signature-name">Azizah Fatmawati, S.T., M.Cs</div>
                        <div class="signature-nip">NIDN. 0628048601</div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- Footer --}}
        <div class="footer-note">
            Dokumen ini diterbitkan secara elektronik oleh LPPPA UMS. Verifikasi keaslian dokumen dapat divalidasi melalui sistem ARQAM.
        </div>
    </div>
</body>
</html>
