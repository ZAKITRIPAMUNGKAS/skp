<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Buku Data Peserta – {{ $event->nama_event }}</title>
    <style>
        /* ========================================================
           PAGE SETUP & VARIABLES (Murni CSS untuk DomPDF)
           ======================================================== */
        @page {
            size: A4 portrait;
            margin: 30mm 15mm 15mm 15mm; /* Ditambah margin atas ke 30mm agar kop tidak mepet */
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 8.2pt;
            color: #1a1a1a;
            line-height: 1.35;
            background: #ffffff;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* ========================================================
           PAGE WRAPPER
           ======================================================== */
        .page {
            page-break-after: always;
            position: relative;
            height: 250mm; /* Menentukan tinggi relatif halaman agar footer-fixed bisa diposisikan absolute di paling bawah */
        }

        /* ========================================================
           KOP SURAT RESMI (Tabel Murni) - Lebar 98% mencegah overflow border
           ======================================================== */
        .kop-table {
            width: 98%;
            border-collapse: collapse;
            border-bottom: 4px solid #008fe2; /* Hijau gelap */
            margin: 0 auto 15px auto;
        }

        .kop-table td {
            vertical-align: middle;
            padding-bottom: 12px;
        }

        .logo-img {
            height: 48px;
            width: auto; /* Mencegah logo digepengin di DomPDF */
            max-width: 150px;
        }

        .judul-instansi-td {
            padding-left: 15px;
        }

        .judul-instansi-td h4 {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #555;
            margin-bottom: 2px;
            font-weight: normal;
        }

        .judul-instansi-td h1 {
            font-size: 22px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1px;
        }

        .tag-event-container {
            margin-top: 1px;
        }

        .tag-event {
            font-size: 10px;
            font-weight: bold;
            color: #008fe2;
            background-color: #e8f5e9;
            padding: 1px 6px;
            border: 1px solid #008fe2;
            display: inline-block;
        }

        .kontrol-dokumen-td {
            width: 110px;
            text-align: right;
        }

        .kontrol-dokumen {
            border: 2px solid #1a1a1a;
            padding: 5px 12px;
            background-color: #f2f4f5; /* abu-kertas */
            text-align: center;
            display: inline-block;
        }

        .kontrol-dokumen .nomor {
            font-size: 24px;
            font-weight: bold;
            line-height: 1;
        }

        .kontrol-dokumen .teks {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
            color: #1a1a1a;
        }

        /* ========================================================
           KOTAK IDENTITAS UTAMA (Tabel Murni) - Lebar 98%
           ======================================================== */
        .box-peserta-table {
            width: 98%;
            border-collapse: collapse;
            border: 2px solid #1a1a1a;
            margin: 0 auto 18px auto;
            background-color: #fff;
        }

        .info-utama-td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .info-utama-td h2 {
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 4px;
            text-transform: uppercase;
            color: #1a1a1a;
        }

        .info-utama-td p {
            font-size: 11.5px;
            color: #333;
            margin: 1px 0;
        }

        .info-utama-td p strong {
            display: inline-block;
            width: 80px;
        }

        .status-box-td {
            color: white;
            padding: 0 15px;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-align: center;
            border-left: 2px solid #1a1a1a;
            width: 140px;
            vertical-align: middle;
        }

        /* ========================================================
           LAYOUT DUA KOLOM (Tabel Murni) - Lebar 98% dengan margin auto
           ======================================================== */
        .layout-dua-kolom-table {
            width: 98%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        /* Menggunakan proporsi lebar 48% agar terhindar dari overflow akibat padding/border */
        .kolom-kiri {
            width: 48%;
            padding-right: 8px;
            vertical-align: top;
        }

        .kolom-kanan {
            width: 48%;
            padding-left: 8px;
            vertical-align: top;
        }

        /* ========================================================
           DESAIN TABEL FORMULIR KORPORAT
           ======================================================== */
        .tabel-form {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            border: 1px solid #b0bec5; /* garis-tabel */
            table-layout: fixed; /* Memaksa ukuran sel tetap patuh */
        }

        /* Header Blok Warna */
        .tabel-form th.header-blok {
            background-color: #b0bec5; /* garis-tabel */
            color: #000;
            text-align: left;
            padding: 5px 8px;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #b0bec5;
            border-bottom: 2px solid #1a1a1a;
        }

        .tabel-form td {
            border: 1px solid #b0bec5;
            padding: 6px 8px;
            font-size: 11px;
            vertical-align: middle;
            line-height: 1.35;
            word-wrap: break-word;      /* Mencegah teks panjang melebarkan tabel */
            overflow-wrap: break-word;
        }

        /* Kolom Label dengan Shading */
        .tabel-form td.label {
            background-color: #f2f4f5; /* abu-kertas */
            width: 38%;
            font-size: 9px;
            font-weight: bold;
            color: #555;
            text-transform: uppercase;
        }

        /* Kolom Isian Data */
        .tabel-form td.isian {
            width: 62%;
            background-color: #fff;
            color: #000;
        }

        .font-tebal { font-weight: bold; }
        .teks-merah { color: #a02c0b; font-weight: bold; }
        .teks-hijau { color: #1e7a52; font-weight: bold; }

        /* ========================================================
           ALASAN TIDAK HADIR
           ======================================================== */
        .alasan-box {
            margin-top: 5px;
            padding: 6px 10px;
            background-color: #fff;
            border: 1px dashed #a02c0b;
            font-size: 10px;
            color: #a02c0b;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* ========================================================
           MASKOT ARQA
           ======================================================== */
        .mascot-container {
            text-align: center;
            margin-top: 80px;
            margin-bottom: 80px;
            width: 100%;
        }

        .mascot-img {
            height: 300px;
            width: auto; /* Memastikan rasio gambar tetap proporsional */
            max-width: 100%;
            object-fit: contain;
        }

        /* ========================================================
           FOOTER 
           ======================================================== */

        .footer-line {
            height: 3px;
            background: #008fe2;
            margin-left: -15mm;
            margin-right: -15mm;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-text {
            font-size: 8pt;
            color: #555550;
            line-height: 1.3;
            padding-left: 15mm;
            padding-right: 15mm;
            padding-top: 4px;
        }

        .footer-text strong {
            color: #008fe2;
        }

        .footer-nomor {
            text-align: right;
            font-size: 8pt;
            font-weight: bold;
            color: #008fe2;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding-left: 15mm;
            padding-right: 15mm;
            padding-top: 4px;
        }
    </style>
</head>
<body>

@forelse($participants as $i => $ep)
@php
    $p        = $ep->peserta;
    $isOk     = $ep->konfirmasi_kesediaan === 'bersedia';
    $isNo     = $ep->konfirmasi_kesediaan === 'tidak_bersedia';
    $noUrut   = $i + 1;
    $totalAll = $participants->count();

    if ($isOk) {
        $colorTheme = '#114B32'; /* hijau-gelap */
        $label      = "BERSEDIA\nHADIR";
    } elseif ($isNo) {
        $colorTheme = '#a02c0b'; /* merah-bata */
        $label      = "TIDAK\nBERSEDIA";
    } else {
        $colorTheme = '#555555'; /* abu-abu */
        $label      = "BELUM\nKONFIRMASI";
    }

    // Identifikasi Peringatan Medis
    $normal = ['tidak', 'tidak ada', '-', 'insyaallah aman', 'aman', 'insya allah aman', 'normal'];
    $alertMakan = $p->catatan_makanan && !in_array(strtolower(trim($p->catatan_makanan)), $normal);
    $alertSehat = $p->catatan_kesehatan && !in_array(strtolower(trim($p->catatan_kesehatan)), $normal);
    $alertDuduk = str_contains(strtolower($p->aktivitas_duduk ?? ''), 'kesulitan');
    $alertSholat= str_contains(strtolower($p->aktivitas_sholat ?? ''), 'kesulitan');
    $alertTangga= str_contains(strtolower($p->aktivitas_tangga ?? ''), 'kesulitan');
@endphp

<div class="page">
    
    <!-- HEADER DOKUMEN -->
    <table class="kop-table">
        <tr>
            <td style="width: 50px;">
                <img src="{{ public_path('logo.webp') }}" class="logo-img" alt="Logo ArqamApp">
            </td>
            <td class="judul-instansi-td">
                <h4 style="margin-top: 20px; margin-bottom: 2px;">
    Majelis Pendidikan Kader PP Muhammadiyah
</h4>
                <h1>Formulir Biodata Peserta</h1>
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
    <table class="box-peserta-table">
        <tr>
            <td class="info-utama-td">
                <h2>{{ $p->nama_lengkap }}</h2>
                <p><strong>NIK</strong> : {{ $p->nik ?: '—' }}</p>
                <p><strong>WHATSAPP</strong> : {{ $p->no_hp ?: '—' }}</p>
            </td>
            <td class="status-box-td" style="background-color: {{ $colorTheme }};">
                {!! nl2br(e($label)) !!}
            </td>
        </tr>
    </table>

    <!-- LAYOUT DUA KOLOM -->
    <table class="layout-dua-kolom-table">
        <tr>
            <!-- KOLOM KIRI -->
            <td class="kolom-kiri">
                
                <table class="tabel-form">
                    <tr>
                        <th colspan="2" class="header-blok">Identitas Pribadi</th>
                    </tr>
                    <tr>
                        <td class="label">Nama Panggilan</td>
                        <td class="isian font-tebal">{{ $p->nama_panggilan ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jenis Kelamin</td>
                        <td class="isian font-tebal">
                            {{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : ($p->jenis_kelamin == 'P' ? 'Perempuan' : '—') }}{{ $p->umur ? ', ' . $p->umur . ' tahun' : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td class="isian">{{ $p->email ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Ukuran Kaos</td>
                        <td class="isian font-tebal">{{ $p->ukuran_kaos ?: '—' }}</td>
                    </tr>
                </table>

                <table class="tabel-form">
                    <tr>
                        <th colspan="2" class="header-blok">Domisili</th>
                    </tr>
                    <tr>
                        <td class="label">Provinsi</td>
                        <td class="isian font-tebal">{{ $p->provinsi ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kabupaten / Kota</td>
                        <td class="isian font-tebal">{{ $p->kabupaten ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kecamatan</td>
                        <td class="isian font-tebal">{{ $p->kecamatan ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Desa / Kelurahan</td>
                        <td class="isian font-tebal">{{ $p->desa_kelurahan ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Alamat Lengkap</td>
                        <td class="isian">{{ $p->alamat_rumah ?: '—' }}</td>
                    </tr>
                </table>

                <table class="tabel-form">
                    <tr>
                        <th colspan="2" class="header-blok" style="background-color: #ffd8cc; color: #a02c0b; border-color: #ffbba6;">Catatan Kesehatan & Makanan</th>
                    </tr>
                    <tr>
                        <td class="label">Pantangan Makan</td>
                        <td class="isian {{ $alertMakan ? 'teks-merah' : '' }}">{{ $p->catatan_makanan ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kondisi Kesehatan</td>
                        <td class="isian {{ $alertSehat ? 'teks-merah' : '' }}">{{ $p->catatan_kesehatan ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Pesan ke Panitia</td>
                        <td class="isian">{{ $p->catatan_panitia ?: '—' }}</td>
                    </tr>
                </table>

            </td>

            <!-- KOLOM KANAN -->
            <td class="kolom-kanan">
                
                <table class="tabel-form">
                    <tr>
                        <th colspan="2" class="header-blok">Data Persyarikatan</th>
                    </tr>
                    <tr>
                        <td class="label">Unit / Instansi</td>
                        <td class="isian font-tebal">{{ $p->unit_kerja ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Keaktifan Ortom</td>
                        <td class="isian font-tebal">{{ $p->keaktifan_ortom ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jabatan AUM</td>
                        <td class="isian font-tebal">{{ $p->jabatan_aum ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Baitul Arqam ke-</td>
                        <td class="isian font-tebal">{{ $p->arqam_ke ? $p->arqam_ke : '—' }}</td>
                    </tr>
                </table>

                <table class="tabel-form">
                    <tr>
                        <th colspan="2" class="header-blok">Fisik & Mobilitas</th>
                    </tr>
                    <tr>
                        <td class="label">Aktivitas Duduk</td>
                        <td class="isian {{ $alertDuduk ? 'teks-merah' : '' }}">{{ $p->aktivitas_duduk ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Aktivitas Sholat</td>
                        <td class="isian {{ $alertSholat ? 'teks-merah' : '' }}">{{ $p->aktivitas_sholat ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Aktivitas Tangga</td>
                        <td class="isian {{ $alertTangga ? 'teks-merah' : '' }}">{{ $p->aktivitas_tangga ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Keberangkatan</td>
                        <td class="isian">{{ $p->rencana_keberangkatan ?: '—' }}</td>
                    </tr>
                </table>

                <table class="tabel-form">
                    <tr>
                        <th colspan="2" class="header-blok" style="background-color: #c8e6c9; color: #1b5e20; border-color: #a5d6a7;">Status Akhir</th>
                    </tr>
                    <tr>
                        <td class="label">Konfirmasi</td>
                        <td class="isian teks-hijau">
                            @if($isOk)
                                Bersedia Hadir
                            @elseif($isNo)
                                Tidak Bersedia
                            @else
                                Belum Konfirmasi
                            @endif
                        </td>
                    </tr>
                </table>

                @if($isNo && $ep->alasan_tidak_hadir)
                <div class="alasan-box">
                    <strong>Alasan Tidak Hadir:</strong><br>
                    "{{ $ep->alasan_tidak_hadir }}"
                </div>
                @endif

                <!-- AREA MASKOT ARQA -->
                <div class="mascot-container">
                    <img src="{{ public_path('images/arka/arka_analisis.png') }}" class="mascot-img" alt="Arqa Mascot">
                </div>

            </td>
        </tr>
    </table>

    <!-- FOOTER PREMIUM -->
    <div class="footer-fixed">
        <div class="footer-line"></div>
        <table class="footer-table">
            <tr>
                <td class="footer-text">
                    Formulir Biodata Resmi &bull; Dicetak otomatis melalui sistem <strong>ArqamApp</strong>.
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
    <p style="font-family: Georgia, serif; font-size: 18pt; color: #1a1a1a; margin-bottom: 8px;">Belum Ada Data</p>
    <p style="font-size: 10pt; color: #555;">Tidak ditemukan peserta pada kegiatan ini.</p>
</div>
@endforelse

</body>
</html>