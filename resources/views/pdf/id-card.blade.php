<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page { margin: 10mm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; background: #fff; }

        .page { page-break-after: always; width: 100%; }
        .page:last-child { page-break-after: avoid; }

        /* Menggunakan TABLE untuk grid agar 100% stabil di DomPDF */
        .grid-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 5mm; 
        }
        .grid-td { 
            width: 50%; 
            padding: 5mm; 
            vertical-align: top; 
            text-align: center; 
        }

        /* Ukuran standar ID Card (Portrait CR80) */
        .card {
            width: 54mm;
            height: 86mm;
            margin: 0 auto;
            border: 1px solid #ccc;
            border-radius: 4mm;
            overflow: hidden;
            background: #ffffff;
            /* Opsional: box-shadow tidak selalu bekerja di DomPDF, tapi bagus untuk preview */
            box-shadow: 0 0 5px rgba(0,0,0,0.1); 
        }

        /* --- CARD FRONT --- */
        .header-blue {
            background-color: #1A6D9B;
            height: 16mm;
            text-align: center;
            padding-top: 3mm;
        }
        .header-blue img {
            height: 10mm; /* Sesuaikan dengan logo Arqam App Anda */
        }
        .header-title {
            color: #ffffff;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .front-body {
            height: 52mm;
            padding: 4mm 2mm;
            text-align: center;
        }
        .event-title {
            font-size: 8px;
            font-weight: bold;
            color: #1A6D9B;
            margin-bottom: 2mm;
            text-transform: uppercase;
            background-color: #eef5f9;
            padding: 2px;
            border-radius: 2px;
        }
        .qr-box {
            width: 32mm;
            height: 32mm;
            margin: 0 auto 1.5mm auto;
            border: 1px solid #ddd;
            padding: 2px;
            background: #fff;
        }
        .qr-box img, .qr-box svg {
            width: 100%;
            height: 100%;
        }
        .scan-text {
            font-size: 8px;
            font-weight: bold;
            color: #e74c3c;
            letter-spacing: 0.5px;
        }

        .front-footer {
            background-color: #D4A017;
            height: 18mm;
            padding: 3mm 2mm;
            text-align: center;
            border-top: 2px solid #1A6D9B;
        }
        .participant-name {
            font-size: 10px;
            font-weight: bold;
            color: #ffffff;
            text-transform: uppercase;
            margin-bottom: 2px;
            line-height: 1.2;
        }
        .participant-unit {
            font-size: 7px;
            color: #222222;
            font-weight: bold;
            line-height: 1.2;
        }

        /* --- CARD BACK --- */
        .back-body {
            height: 70mm;
            padding: 5mm 4mm;
            text-align: left;
        }
        .back-title {
            font-size: 9px;
            font-weight: bold;
            color: #1A6D9B;
            text-align: center;
            margin-bottom: 4mm;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 3mm;
        }
        .rules-list {
            font-size: 7.5px;
            color: #333;
            padding-left: 3.5mm;
            line-height: 1.4;
        }
        .rules-list li {
            margin-bottom: 2.5mm;
            text-align: justify;
        }
    </style>
</head>
<body>
    @php $chunks = $participants->chunk(2); @endphp

    @foreach($chunks as $pair)
    <div class="page">
        <!-- BARIS 1: BAGIAN DEPAN (FRONT) -->
        <table class="grid-table">
            <tr>
                @foreach($pair as $ep)
                @php $p = $ep->peserta; @endphp
                <td class="grid-td">
                    <div class="card">
                        <!-- Header / Logo -->
                        <div class="header-blue">
                            {{-- Ganti teks ini dengan tag img logo Anda, contoh: --}}
                            {{-- <img src="{{ public_path('images/arqam-logo.png') }}" alt="Logo"> --}}
                            <div class="header-title">ARQAM APP</div>
                        </div>
                        
                        <!-- Body (Event Title & QR Code) -->
                        <div class="front-body">
                            <div class="event-title">{{ $event->nama_event }}</div>
                            
                            <div class="qr-box">
                                @if(isset($qrCodes[$ep->peserta_id]))
                                    <img src="data:image/svg+xml;base64,{{ $qrCodes[$ep->peserta_id] }}" alt="QR Code">
                                @else
                                    <div style="width:100%; height:100%; background:#f0f0f0; display:table;">
                                        <span style="display:table-cell; vertical-align:middle; font-size:6px; color:#999;">No QR</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="scan-text">SCAN UNTUK PRESENSI</div>
                        </div>

                        <!-- Footer (Participant Info) -->
                        <div class="front-footer">
                            <div class="participant-name">{{ $p->nama_lengkap }}</div>
                            <div class="participant-unit">{{ $p->unit_kerja ?? 'RS PKU MUHAMMADIYAH KRA' }}</div>
                        </div>
                    </div>
                </td>
                @endforeach
                
                {{-- Jika jumlah peserta ganjil, tambahkan sel kosong agar tata letak tidak rusak --}}
                @if($pair->count() == 1)
                <td class="grid-td"></td>
                @endif
            </tr>
        </table>

        <!-- BARIS 2: BAGIAN BELAKANG (BACK) -->
        <table class="grid-table">
            <tr>
                @foreach($pair as $ep)
                <td class="grid-td">
                    <div class="card">
                        <!-- Header / Logo -->
                        <div class="header-blue">
                            {{-- Ganti teks ini dengan tag img logo Muhammadiyah/RS --}}
                            <div class="header-title">ARQAM APP</div>
                        </div>
                        
                        <!-- Tata Tertib -->
                        <div class="back-body">
                            <div class="back-title">TATA TERTIB<br>BAITUL ARQAM TERPADU</div>
                            
                            <ul class="rules-list">
                                <li>ID Card wajib dikenakan selama acara berlangsung.</li>
                                <li>Presensi kehadiran dilakukan melalui scan QR Code.</li>
                                <li>Hadir di ruangan 5 menit sebelum materi dimulai.</li>
                                <li>Menjaga ketenangan dan adab selama sesi materi.</li>
                                <li>Tidak Mengoperasikan HP Smartphone selama sesi berlangsung.</li>
                                <li>Menjaga kebersihan dan fasilitas di lokasi acara.</li>
                            </ul>
                        </div>
                    </div>
                </td>
                @endforeach

                {{-- Jika jumlah peserta ganjil, tambahkan sel kosong --}}
                @if($pair->count() == 1)
                <td class="grid-td"></td>
                @endif
            </tr>
        </table>
    </div>
    @endforeach
</body>
</html>