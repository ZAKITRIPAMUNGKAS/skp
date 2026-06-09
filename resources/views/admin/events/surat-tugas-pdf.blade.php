<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Tugas Fasilitator - {{ $event->nama_event }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px 40px;
        }
        /* Kop Surat */
        .kop-surat {
            border-bottom: 3px double #000;
            padding-bottom: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        .kop-title {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #114B32;
            margin: 0;
        }
        .kop-subtitle {
            font-size: 11pt;
            margin: 2px 0 0 0;
            font-weight: normal;
            color: #555;
        }
        .kop-address {
            font-size: 8pt;
            margin: 5px 0 0 0;
            color: #666;
            font-style: italic;
        }
        /* Judul Surat */
        .surat-header {
            text-align: center;
            margin-bottom: 25px;
        }
        .surat-title {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin: 0;
        }
        .surat-number {
            font-size: 10pt;
            margin-top: 5px;
            color: #444;
        }
        /* Isi Surat */
        .surat-body {
            margin-bottom: 30px;
            text-align: justify;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table-data th, .table-data td {
            border: 1px solid #ddd;
            padding: 10px 12px;
            text-align: left;
            font-size: 10.5pt;
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
            margin-top: 50px;
            width: 100%;
        }
        .signature-table {
            width: 100%;
            border: none;
        }
        .signature-table td {
            border: none;
            width: 50%;
            text-align: center;
            font-size: 11pt;
        }
        .signature-space {
            height: 70px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }
        .signature-nip {
            font-size: 9.5pt;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Kop Surat --}}
        <div class="kop-surat">
            <h1 class="kop-title">MAJELIS PENDIDIKAN KADER DAN SUMBER DAYA INSANI</h1>
            <div class="kop-subtitle">PIMPINAN DAERAH MUHAMMADIYAH SURAKARTA</div>
            <div class="kop-address">Jl. Ronggowarsito No. 123, Surakarta, Jawa Tengah | Telp: (0271) 645123 | Email: mpksdi.solo@gmail.com</div>
        </div>

        {{-- Judul Surat --}}
        <div class="surat-header">
            <h2 class="surat-title">SURAT TUGAS</h2>
            <div class="surat-number">Nomor: ST/{{ date('Y') }}/{{ str_pad($event->id, 4, '0', STR_PAD_LEFT) }}</div>
        </div>

        {{-- Isi Surat --}}
        <div class="surat-body">
            <p>Bismillahirrohmanirrohim,</p>
            <p>Pimpinan Majelis Pendidikan Kader dan Sumber Daya Insani (MPKSDI) Pimpinan Daerah Muhammadiyah Surakarta dengan ini menugaskan kepada nama-nama berikut:</p>

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
            
            <table style="border: none; margin-left: 20px; font-size: 11pt;">
                <tr>
                    <td style="padding: 4px 10px 4px 0; font-weight: bold; width: 100px;">Tanggal</td>
                    <td style="padding: 4px 10px;">:</td>
                    <td style="padding: 4px 10px;">
                        {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d F Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d F Y') }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 4px 10px 4px 0; font-weight: bold;">Tempat</td>
                    <td style="padding: 4px 10px;">:</td>
                    <td style="padding: 4px 10px;">{{ $event->lokasi ?? 'Ditentukan Panitia' }}</td>
                </tr>
            </table>

            <p style="margin-top: 25px;">Demikian surat tugas ini dibuat untuk dilaksanakan dengan seksama dan penuh rasa tanggung jawab. Semoga Allah SWT senantiasa memberikan kemudahan dan petunjuk dalam menjalankan amanah ini.</p>
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
                        <div style="font-weight: bold; margin-top: 5px;">Ketua MPKSDI PDM Surakarta</div>
                        <div class="signature-space"></div>
                        <div class="signature-name">Dr. H. M. Fauzi, M.Ag.</div>
                        <div class="signature-nip">NBM. 823.123</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
