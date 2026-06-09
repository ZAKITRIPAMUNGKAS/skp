<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Angket Peserta – {{ $event->nama_event }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        body {
            font-family: 'Century Gothic', 'Segoe UI', -apple-system, BlinkMacSystemFont, Arial, sans-serif;
            font-size: 9pt;
            color: #334155;
            line-height: 1.5;
            background: #ffffff;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .page {
            page-break-after: always;
            position: relative;
            height: 260mm;
        }

        .page:last-child {
            page-break-after: avoid;
        }

        /* ========================================================
           KOP SURAT RESMI (Tabel Murni)
           ======================================================== */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 4px solid #1A56DB; /* Biru Arqam */
            margin-bottom: 20px;
        }

        .kop-table td {
            vertical-align: middle;
            padding-bottom: 12px;
        }

        .logo-img {
            height: 48px;
            width: auto;
            max-width: 140px;
        }

        .judul-instansi-td {
            padding-left: 15px;
        }

        .judul-instansi-td h4 {
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #64748B;
            margin-bottom: 2px;
            font-weight: 600;
        }

        .judul-instansi-td h1 {
            font-size: 20px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1E293B;
        }

        .tag-event-container {
            margin-top: 2px;
        }

        .tag-event {
            font-size: 9.5px;
            font-weight: bold;
            color: #1A56DB;
            background-color: #EFF6FF;
            padding: 2px 8px;
            border: 1px solid #BFDBFE;
            border-radius: 4px;
            display: inline-block;
        }

        .kontrol-dokumen-td {
            width: 120px;
            text-align: right;
        }

        .kontrol-dokumen {
            border: 1.5px solid #E2E8F0;
            padding: 6px 12px;
            background-color: #F8FAFC;
            text-align: center;
            display: inline-block;
            border-radius: 8px;
        }

        .kontrol-dokumen .nomor {
            font-size: 20px;
            font-weight: 800;
            line-height: 1;
            color: #1A56DB;
        }

        .kontrol-dokumen .teks {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 3px;
            color: #64748B;
        }

        /* ========================================================
           KOTAK IDENTITAS UTAMA
           ======================================================== */
        .box-peserta {
            width: 100%;
            border-left: 6px solid #1A56DB;
            background-color: #F8FAFC;
            padding: 12px 18px;
            margin-bottom: 20px;
            border-radius: 0 8px 8px 0;
        }

        .box-peserta h2 {
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 6px;
            text-transform: uppercase;
            color: #1E293B;
            letter-spacing: 0.5px;
        }

        .box-peserta p {
            font-size: 11px;
            color: #475569;
            margin: 2px 0;
        }

        .box-peserta p strong {
            display: inline-block;
            width: 90px;
            color: #64748B;
        }

        /* ========================================================
           TABEL ANGKET
           ======================================================== */
        .tabel-angket {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .tabel-angket th {
            background-color: #F1F5F9;
            color: #1E293B;
            padding: 10px 12px;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #E2E8F0;
            text-align: left;
            font-weight: 700;
        }

        .tabel-angket td {
            border-bottom: 1px solid #E2E8F0;
            padding: 9px 12px;
            font-size: 10.5px;
            vertical-align: middle;
            color: #334155;
        }

        .tabel-angket td.no {
            width: 5%;
            text-align: center;
            font-weight: bold;
            color: #64748B;
        }

        .tabel-angket td.item {
            width: 65%;
        }

        .tabel-angket td.jawaban {
            width: 30%;
            text-align: center;
            font-weight: 700;
        }

        /* ========================================================
           KOTAK KOMENTAR / SARAN
           ======================================================== */
        .komentar-box {
            background-color: #F8FAFC;
            border-left: 4px solid #FACA15; /* Kuning emas */
            padding: 12px 16px;
            border-radius: 0 6px 6px 0;
        }

        .komentar-title {
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748B;
            margin-bottom: 6px;
        }

        .komentar-content {
            font-family: Georgia, serif;
            font-size: 11px;
            font-style: italic;
            color: #334155;
            line-height: 1.6;
        }

        /* ========================================================
           FOOTER
           ======================================================== */
        .footer-fixed {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
        }

        .footer-line {
            height: 3px;
            background-color: #1A56DB;
            margin-bottom: 6px;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-text {
            font-size: 8pt;
            color: #64748B;
            line-height: 1.3;
            padding-left: 15mm;
        }

        .footer-text strong {
            color: #1A56DB;
        }

        .footer-nomor {
            text-align: right;
            font-size: 8pt;
            font-weight: bold;
            color: #1A56DB;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding-right: 15mm;
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
    
    <!-- HEADER DOKUMEN -->
    <table class="kop-table">
        <tr>
            <td style="width: 120px; vertical-align: middle;">
                <img src="{{ public_path('logo.png') }}" class="logo-img" alt="Logo UMS" onerror="this.style.display='none'">
            </td>
            <td class="judul-instansi-td">
                <h4 style="margin-top: 10px; margin-bottom: 2px; font-size: 11px;">Lembaga Agama Pengembangan Persyarikatan Pengkaderan & Alumni(LP3A)</h4>
                <h4 style="margin-top: 0; margin-bottom: 5px; font-weight: normal; font-size: 11px; color: #555;">Universitas Muhammadiyah Surakarta</h4>
                <h1>Laporan Angket Peserta</h1>
                <div class="tag-event-container">
                    <span class="tag-event">{{ $event->nama_event }}</span>
                </div>
            </td>
            <td class="kontrol-dokumen-td">
                <div class="kontrol-dokumen">
                    <div class="nomor">{{ str_pad($noUrut, 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="teks">Halaman {{ $noUrut }} / {{ $totalAll }}</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- KOTAK IDENTITAS UTAMA -->
    <div class="box-peserta">
        <h2>{{ $p->nama_lengkap }}</h2>
        <p><strong>NIP/NBM</strong>: {{ $p->nim_nip_nbm ?: '—' }}</p>
        <p><strong>UNIT KERJA</strong>: {{ $p->unit_kerja ?: '—' }}</p>
    </div>

    <!-- TABEL JAWABAN ANGKET -->
    <table class="tabel-angket">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th>Item Evaluasi Penyelenggaraan</th>
                <th style="width: 30%; text-align: center;">Tanggapan / Jawaban</th>
            </tr>
        </thead>
        <tbody>
            @foreach($angketItems as $i => $item)
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
                
                // Warna kontras dan modern
                $colorJawab = $jawabCode === 'A' ? '#10B981' : ($jawabCode === 'B' ? '#059669' : ($jawabCode === 'C' ? '#D97706' : '#EF4444'));
            @endphp
            <tr>
                <td class="no">{{ $i + 1 }}</td>
                <td class="item">{{ $item->teks_item }}</td>
                <td class="jawaban" style="color: {{ $colorJawab }};">{{ $jawabLabel }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- KOTAK KOMENTAR & MASKOT (Berdampingan agar menghemat ruang halaman) -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <tr>
            <td style="width: 78%; vertical-align: top; padding-right: 15px;">
                <div class="komentar-box">
                    <div class="komentar-title">Saran &amp; Komentar Peserta terhadap Acara:</div>
                    <div class="komentar-content">
                        "{{ $komentarTeks }}"
                    </div>
                </div>
            </td>
            <td style="width: 22%; vertical-align: middle; padding-left: 15px;">
                <img src="{{ public_path('images/arka/arka_analisis.png') }}" style="height: 75px; width: auto; object-fit: contain;" alt="Arqa Mascot" onerror="this.style.display='none'">
            </td>
        </tr>
    </table>

    <!-- FOOTER PREMIUM -->
    <div class="footer-fixed">
        <div class="footer-line"></div>
        <table class="footer-table">
            <tr>
                <td class="footer-text">
                    Laporan Angket Per-Peserta &bull; Dicetak otomatis melalui sistem <strong>ArqamApp</strong>.
                </td>
                <td class="footer-nomor">
                    {{ $event->nama_event }}
                </td>
            </tr>
        </table>
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
