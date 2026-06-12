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
            margin: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8.2pt;
            color: #1a1a1a;
            line-height: 1.35;
            background: #ffffff;
            margin: 0;
            padding: 0;
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
            position: relative;
            height: 270mm; /* Reduced to fit A4 page printing bounds with padding */
            padding: 30px 45px 50px 45px;
        }

        .page-break {
            page-break-after: always;
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

        /* Kop Surat Resmi */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .kop-table td {
            border: none !important;
            background: transparent !important;
            padding: 0 !important;
            vertical-align: middle;
        }

        .kop-logo-container {
            width: 45%;
            text-align: left;
            padding-left: 10px;
        }

        .kop-info-container {
            width: 55%;
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
            margin-bottom: 15px;
            margin-top: 5px;
        }

        /* Judul Dokumen (Samping Kiri & Kanan via tabel tipis) */
        .title-section-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .title-section-table td {
            border: none !important;
            background: transparent !important;
            padding: 0 !important;
            vertical-align: middle;
        }

        .title-section-left h1 {
            font-size: 15pt;
            font-weight: bold;
            color: #0b3a75;
            text-transform: uppercase;
            margin: 0;
        }

        .title-section-left .tag-event {
            font-size: 8.5pt;
            font-weight: bold;
            color: #0b3a75;
            margin-top: 2px;
        }

        .kontrol-dokumen-td {
            width: 110px;
            text-align: right;
        }

        .kontrol-dokumen {
            border: 2px solid #0b3a75;
            padding: 4px 10px;
            background-color: #f2f5fa;
            text-align: center;
            display: inline-block;
        }

        .kontrol-dokumen .nomor {
            font-size: 18px;
            font-weight: bold;
            line-height: 1;
            color: #0b3a75;
        }

        .kontrol-dokumen .teks {
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
            color: #555;
        }

        /* ========================================================
           KOTAK IDENTITAS UTAMA (Tabel Murni) - Lebar 98%
           ======================================================== */
        .box-peserta-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #0b3a75;
            margin-bottom: 15px;
            background-color: #fff;
        }

        .info-utama-td {
            padding: 10px 12px;
            vertical-align: middle;
        }

        .info-utama-td h2 {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 4px;
            text-transform: uppercase;
            color: #0b3a75;
        }

        .info-utama-td p {
            font-size: 10.5px;
            color: #333;
            margin: 1px 0;
        }

        .info-utama-td p strong {
            display: inline-block;
            width: 80px;
        }

        .status-box-td {
            color: white;
            padding: 0 12px;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            text-align: center;
            border-left: 2px solid #0b3a75;
            width: 130px;
            vertical-align: middle;
        }

        /* ========================================================
           LAYOUT DUA KOLOM (Tabel Murni) - Lebar 98% dengan margin auto
           ======================================================== */
        .layout-dua-kolom-table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Menggunakan proporsi lebar 48% agar terhindar dari overflow akibat padding/border */
        .kolom-kiri {
            width: 49%;
            padding-right: 8px;
            vertical-align: top;
        }

        .kolom-kanan {
            width: 49%;
            padding-left: 8px;
            vertical-align: top;
        }

        /* ========================================================
           DESAIN TABEL FORMULIR KORPORAT
           ======================================================== */
        .tabel-form {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            border: 1px solid #b2c8e3; /* garis-tabel */
            table-layout: fixed; /* Memaksa ukuran sel tetap patuh */
        }

        /* Header Blok Warna */
        .tabel-form th.header-blok {
            background-color: #0b3a75;
            color: #ffffff;
            text-align: left;
            padding: 4px 8px;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #0b3a75;
        }

        .tabel-form td {
            border: 1px solid #b2c8e3;
            padding: 5px 7px;
            font-size: 10px;
            vertical-align: middle;
            line-height: 1.3;
            word-wrap: break-word;      /* Mencegah teks panjang melebarkan tabel */
            overflow-wrap: break-word;
        }

        /* Kolom Label dengan Shading */
        .tabel-form td.label {
            background-color: #f2f5fa; /* abu-kertas biru */
            width: 38%;
            font-size: 8.5px;
            font-weight: bold;
            color: #0b3a75;
            text-transform: uppercase;
        }

        /* Kolom Isian Data */
        .tabel-form td.isian {
            width: 62%;
            background-color: #fff;
            color: #111;
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
            margin-top: 40px;
            margin-bottom: 20px;
            width: 100%;
        }

        .mascot-img {
            height: 140px;
            width: auto; /* Memastikan rasio gambar tetap proporsional */
            max-width: 100%;
            object-fit: contain;
        }

        /* ========================================================
           FOOTER 
           ======================================================== */
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

<div class="page @if(!$loop->last) page-break @endif">
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

    <!-- JUDUL DOKUMEN -->
    <table class="title-section-table">
        <tr>
            <td class="title-section-left">
                <h1>Formulir Biodata Peserta</h1>
                <div class="tag-event">{{ $event->nama_event }}</div>
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
                        <td class="label">Alamat Lengkap</td>
                        <td class="isian">{{ $p->alamat_rumah ?: '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Domisili</td>
                        <td class="isian font-tebal">
                            @php
                                $domisiliParts = array_filter(array_map(function($val) {
                                    $clean = trim(strval($val));
                                    return (strtolower($clean) === 'lainnya' || empty($clean)) ? null : $clean;
                                }, [
                                    $p->desa_kelurahan,
                                    $p->kecamatan,
                                    $p->kabupaten,
                                    $p->provinsi
                                ]));
                                $domisiliText = implode(', ', $domisiliParts);
                            @endphp
                            {{ $domisiliText ?: '—' }}
                        </td>
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

            </td>
        </tr>
    </table>

</div>
@empty
<div style="padding: 80px 20px; text-align: center;">
    <p style="font-family: Georgia, serif; font-size: 18pt; color: #1a1a1a; margin-bottom: 8px;">Belum Ada Data</p>
    <p style="font-size: 10pt; color: #555;">Tidak ditemukan peserta pada kegiatan ini.</p>
</div>
@endforelse

</body>
</html>