<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Peserta – {{ $event->nama_event }}</title>
    <style>
        @page {
            margin: 10mm 12mm 12mm 12mm;
            size: a4 landscape;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 8px;
            color: #334155;
            background: #fff;
            line-height: 1.3;
        }

        /* ══════════════════════════════════════════
           HEADER (KOP SURAT)
        ══════════════════════════════════════════ */
        .header-container {
            width: 100%;
            margin-bottom: 15px;
            border-bottom: 2.5px double #1A6D9B;
            padding-bottom: 12px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-logo-text {
            width: 75%;
            vertical-align: bottom;
        }

        .header-mascot {
            width: 25%;
            text-align: right;
            vertical-align: bottom;
        }

        .org-label {
            font-size: 8.5px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 3px;
        }

        .main-title {
            font-size: 22px;
            font-weight: 800;
            color: #1A6D9B;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            line-height: 1;
        }

        .sub-title {
            font-size: 11.5px;
            font-weight: 600;
            color: #D4A017;
            margin-top: 4px;
        }

        .header-info {
            margin-top: 10px;
        }

        .info-pill {
            display: inline-block;
            padding: 2.5px 10px;
            border-radius: 4px;
            font-size: 7px;
            font-weight: bold;
            margin-right: 5px;
            text-transform: uppercase;
        }

        .pill-blue { background: #E0F2FE; color: #0369A1; border: 0.5px solid #BAE6FD; }
        .pill-gold { background: #FEFCE8; color: #854D0E; border: 0.5px solid #FEF08A; }

        .mascot-img {
            height: 60px;
            margin-bottom: -5px;
        }

        /* ══════════════════════════════════════════
           DATA TABLE
        ══════════════════════════════════════════ */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .data-table thead {
            display: table-header-group;
        }

        .data-table thead th {
            text-align: left;
            font-size: 7px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
            padding: 10px 8px;
            border-bottom: 1.5px solid #1A6D9B;
            background: #F8FAFC;
        }

        /* Grid lines for ultra-tidy look */
        .data-table th, .data-table td {
            border-right: 0.1mm solid #F1F5F9;
        }
        .data-table th:last-child, .data-table td:last-child {
            border-right: none;
        }

        .w-no { width: 30px; text-align: center !important; }
        .w-bio { width: 235px; }
        .w-instansi { width: 205px; }
        .w-extra { width: auto; }

        .data-table tr {
            page-break-inside: avoid;
        }

        .data-table tbody td {
            padding: 12px 8px;
            vertical-align: top;
            border-bottom: 0.5px solid #F1F5F9;
        }

        .bg-stripe { background: #FCFDFF; }

        .no-val {
            font-size: 9.5px;
            font-weight: bold;
            color: #94A3B8;
            text-align: center;
        }

        /* ══════════════════════════════════════════
           CONTENT BLOCKS
        ══════════════════════════════════════════ */
        .section-tag {
            display: inline-block;
            font-size: 6px;
            font-weight: 800;
            color: #1A6D9B;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            background: #F0F9FF;
            padding: 1px 4px;
            border-radius: 2px;
            margin-bottom: 6px;
            border: 0.2px solid #BAE6FD;
        }

        .kv-group { width: 100%; }
        .kv-row { width: 100%; margin-bottom: 2.5px; }
        
        /* Stable Inline-Block columns for DomPDF */
        .kv-key { 
            display: inline-block; 
            width: 65px; 
            font-size: 7px; 
            color: #94A3B8; 
            font-weight: 600;
            vertical-align: top;
        }
        .kv-val { 
            display: inline-block; 
            width: 155px; 
            font-size: 8.5px; 
            color: #1e293b; 
            vertical-align: top;
        }
        .kv-val.bold { font-weight: bold; color: #1A6D9B; }

        .mono-box {
            font-family: 'Courier New', monospace;
            font-size: 8px;
            background: #F8FAFC;
            padding: 0 3px;
            border: 0.5px solid #E2E8F0;
            border-radius: 2px;
            color: #475569;
        }

        .edu-list { font-size: 7.5px; color: #1e293b; margin-top: 4px; }
        .edu-item { margin-bottom: 3px; border-left: 2px solid #1A6D9B; padding-left: 6px; }
        .edu-lvl { font-size: 5.5px; font-weight: 800; color: #1A6D9B; text-transform: uppercase; display: block; margin-bottom: 1px; }
        .edu-val { font-size: 7.5px; color: #334155; }

        /* Religious Grid (Stable Layout) */
        .rel-grid { width: 100%; }
        .rel-item {
            display: inline-block;
            width: 48%;
            vertical-align: top;
            margin-bottom: 6px;
            padding-right: 2%;
        }
        .rel-label { font-size: 5.8px; font-weight: 800; color: #94A3B8; text-transform: uppercase; display: block; margin-bottom: 1px; }
        .rel-text { font-size: 7.8px; color: #334155; display: block; }

        /* Harapan Box */
        .harapan-box {
            margin-top: 8px;
            padding: 8px;
            background: #F8FAFC;
            border: 0.5px solid #E2E8F0;
            border-radius: 4px;
        }
        .harapan-label { font-size: 5.8px; font-weight: 800; color: #0369A1; text-transform: uppercase; margin-bottom: 3px; }
        .harapan-content { font-size: 7.8px; color: #475569; font-style: italic; line-height: 1.4; }

        .meta-stamp { font-size: 6px; color: #cbd5e1; margin-top: 8px; font-style: italic; }

        .footer {
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px solid #F1F5F9;
        }
        .footer-table { width: 100%; }
        .footer-cell { font-size: 7px; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.8px; }

    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header-container">
        <table class="header-table">
            <tr>
                <td class="header-logo-text">
                    <div class="org-label">Majelis Pendidikan Kader &mdash; PP Muhammadiyah</div>
                    <div class="main-title">Laporan Data Pendaftaran</div>
                    <div class="sub-title">{{ $event->nama_event }}</div>
                    <div class="header-info">
                        <span class="info-pill pill-blue">{{ $participants->count() }} TOTAL PESERTA</span>
                        <span class="info-pill pill-gold">DICETAK: {{ now()->format('d F Y, H:i') }}</span>
                    </div>
                </td>
                <td class="header-mascot">
                    <img src="{{ public_path('images/arka/arka_analisis.png') }}" class="mascot-img">
                </td>
            </tr>
        </table>
    </div>

    {{-- DATA TABLE --}}
    <table class="data-table">
        <thead>
            <tr>
                <th class="w-no">No</th>
                <th class="w-bio">Profil & Kontak Peserta</th>
                <th class="w-instansi">Instansi & Alamat Domisili</th>
                <th class="w-extra">Keagamaan & Harapan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participants as $i => $ep)
                @php $p = $ep->peserta; @endphp
                <tr class="{{ $i % 2 == 1 ? 'bg-stripe' : '' }}">
                    
                    <td class="no-val">{{ $i + 1 }}</td>

                    {{-- BIO --}}
                    <td>
                        <span class="section-tag">Identitas Peserta</span>
                        <div class="kv-group">
                            <div class="kv-row">
                                <div class="kv-key">Nama</div>
                                <div class="kv-val bold">{{ $p->nama_lengkap }}</div>
                            </div>
                            <div class="kv-row">
                                <div class="kv-key">NIK/NBM</div>
                                <div class="kv-val">{{ $p->nik ?: '—' }} / {{ $p->nbm ?: '—' }}</div>
                            </div>
                            <div class="kv-row">
                                <div class="kv-key">Gender/TTL</div>
                                <div class="kv-val">{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}, {{ $p->tempat_lahir ?: '—' }} {{ $p->tanggal_lahir ? $p->tanggal_lahir->format('d/m/Y') : '' }}</div>
                            </div>
                            <div class="kv-row">
                                <div class="kv-key">Kontak</div>
                                <div class="kv-val">{{ $p->no_hp ?: '—' }}</div>
                            </div>
                            <div class="kv-row">
                                <div class="kv-key">Email</div>
                                <div class="kv-val">{{ $p->email }}</div>
                            </div>
                            <div class="kv-row">
                                <div class="kv-key">Username</div>
                                <div class="kv-val"><span class="mono-box">{{ $p->user->username ?? '—' }}</span></div>
                            </div>
                        </div>
                    </td>

                    {{-- WORK --}}
                    <td>
                        <span class="section-tag">Unit Kerja / Instansi</span>
                        <div class="kv-group">
                            <div class="kv-row">
                                <div class="kv-key">Instansi</div>
                                <div class="kv-val bold">{{ $p->unit_kerja ?: '—' }}</div>
                            </div>
                            <div class="kv-row">
                                <div class="kv-key">Jabatan</div>
                                <div class="kv-val">{{ $p->jabatan_aum ?: '—' }}</div>
                            </div>
                        </div>
                        
                        <div style="margin-top:8px;">
                            <span class="section-tag">Riwayat Pendidikan (Terakhir: {{ $p->pendidikan_terakhir ?: '—' }})</span>
                            <div class="edu-list">
                                <div class="edu-item">
                                    <span class="edu-lvl">SD</span>
                                    <span class="edu-val">{{ $p->pendidikan_sd ?: '—' }}</span>
                                </div>
                                <div class="edu-item">
                                    <span class="edu-lvl">SMP / MTs</span>
                                    <span class="edu-val">{{ $p->pendidikan_smp ?: '—' }}</span>
                                </div>
                                <div class="edu-item">
                                    <span class="edu-lvl">SMA / SMK / MA</span>
                                    <span class="edu-val">{{ $p->pendidikan_sma ?: '—' }}</span>
                                </div>
                                <div class="edu-item">
                                    <span class="edu-lvl">S1 (Sarjana)</span>
                                    <span class="edu-val">{{ $p->pendidikan_s1 ?: '—' }}</span>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top:8px;">
                            <span class="section-tag">Alamat Domisili</span>
                            <div class="kv-val" style="width: 100%; margin-left: 0; font-size: 8px;">
                                {{ $p->alamat_rumah ?: '—' }}<br>
                                <span style="font-size: 7px; color: #94A3B8;">{{ $p->desa_kelurahan }}, {{ $p->kecamatan }}, {{ $p->kabupaten }}</span>
                            </div>
                        </div>
                    </td>

                    {{-- RELIGIOUS --}}
                    <td>
                        <span class="section-tag">Aktivitas Keagamaan</span>
                        <div class="rel-grid">
                            <div class="rel-item">
                                <span class="rel-label">Baca Quran</span>
                                <span class="rel-text">{{ $p->kemampuan_baca_quran ?: '—' }}</span>
                            </div>
                            <div class="rel-item">
                                <span class="rel-label">Hafalan</span>
                                <span class="rel-text">{{ $p->hafalan_quran_1 ?: '—' }}</span>
                            </div>
                            <div class="rel-item">
                                <span class="rel-label">Sholat Masjid</span>
                                <span class="rel-text">{{ $p->aktivitas_sholat_masjid ?: '—' }}</span>
                            </div>
                            <div class="rel-item">
                                <span class="rel-label">Kajian</span>
                                <span class="rel-text">{{ $p->aktivitas_kajian_agama ?: '—' }}</span>
                            </div>
                        </div>

                        <div class="harapan-box">
                            <div class="harapan-label">Harapan Mengikuti</div>
                            <div class="harapan-content">
                                @if($p->harapan_mengikuti_ba)
                                    "{{ Str::limit($p->harapan_mengikuti_ba, 160) }}"
                                @else
                                    <span style="color: #cbd5e1;">Tidak ada data.</span>
                                @endif
                            </div>
                        </div>
                        <div class="meta-stamp">Terdaftar: {{ $ep->created_at->format('d/m/Y H:i') }}</div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td class="footer-cell">ARQAM Digital &mdash; Sistem Manajemen Perkaderan</td>
                <td class="footer-cell" style="text-align: right;">Laporan Otomatis &mdash; {{ now()->format('d F Y') }}</td>
            </tr>
        </table>
    </div>

</body>

</html>