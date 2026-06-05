<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 8mm; }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background: #fff;
        }

        .card-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 5mm;
        }

        .page-break { page-break-after: always; }

        /* Kartu */
        .card {
            width: 86mm;
            height: 137mm;
            background: #fff;
            overflow: hidden;
            position: relative;
            border: 0.5px solid #cbd5e1;
            border-radius: 3mm;
        }

        /* Header biru */
        .hdr-bg {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 39mm;
            background-color: #1A6D9B;
        }
        .hdr-gold {
            position: absolute;
            top: 39mm; left: 0;
            width: 100%; height: 2.5mm;
            background-color: #D4A017;
        }
        /* Footer */
        .ftr-bar {
            position: absolute;
            bottom: 0; left: 0;
            width: 100%; height: 4mm;
            background-color: #1A6D9B;
        }
        .ftr-gold {
            position: absolute;
            bottom: 4mm; left: 0;
            width: 100%; height: 1mm;
            background-color: #D4A017;
        }

        /* Konten flow */
        .card-body {
            position: relative;
            width: 100%;
            text-align: center;
        }

        .logo-wrap { padding-top: 3.5mm; padding-bottom: 2.5mm; }
        .logo-img { height: 11mm; object-fit: contain; }

        .photo-wrap { width: 100%; text-align: center; margin-bottom: 2.5mm; }
        .photo-box {
            display: inline-block;
            width: 27mm; height: 34mm;
            border: 2px solid #fff;
            border-radius: 2mm;
            overflow: hidden;
            background: #f1f5f9;
        }
        .photo-box img { width: 100%; height: 100%; object-fit: cover; }
        .photo-placeholder {
            display: inline-block;
            width: 27mm; height: 34mm;
            border: 2px solid #e2e8f0;
            border-radius: 2mm;
            background: #f1f5f9;
            text-align: center;
            padding-top: 10mm;
            color: #94a3b8;
            font-size: 20pt;
            font-weight: bold;
        }

        .p-name {
            font-size: 10pt;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            padding: 0 3mm;
            margin-bottom: 1mm;
            line-height: 1.2;
        }
        .p-unit {
            font-size: 6.5pt;
            color: #64748b;
            padding: 0 4mm;
            margin-bottom: 2mm;
            line-height: 1.3;
        }

        .pill-wrap { width: 100%; text-align: center; margin-bottom: 2.5mm; }
        .pill {
            display: inline-block;
            background-color: #1A6D9B;
            color: #fff;
            font-size: 5.5pt;
            font-weight: bold;
            padding: 0.8mm 3mm;
            border-radius: 1mm;
            text-transform: uppercase;
        }

        .qr-wrap { width: 100%; text-align: center; }
        .qr-box {
            display: inline-block;
            width: 27mm; height: 27mm;
            border: 1px solid #e2e8f0;
            padding: 1mm;
            background: #fff;
            border-radius: 1.5mm;
        }
        .qr-box img { width: 100%; height: 100%; }
        .scan-label {
            font-size: 5.5pt;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 1mm;
        }
    </style>
</head>
<body>
    @foreach($participants->chunk(4) as $chunk)
        <table class="card-grid {{ !$loop->last ? 'page-break' : '' }}">
            @foreach($chunk->chunk(2) as $row)
                <tr>
                    @foreach($row as $ep)
                        @php
                            $p   = $ep->peserta;
                            $qrData = $ep->qr_code;
                            if (empty($qrData)) {
                                $token = hash_hmac('sha256', $event->id . '-' . $p->id, config('app.key'));
                                $qrData = base64_encode(json_encode([
                                    'e' => $event->id,
                                    'p' => $p->id,
                                    't' => $token
                                ]));
                            }
                            $qrc = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(90)->margin(0)->generate($qrData);
                        @endphp
                        <td>
                            <div class="card">
                                <div class="hdr-bg"></div>
                                <div class="hdr-gold"></div>
                                <div class="ftr-gold"></div>
                                <div class="ftr-bar"></div>

                                <div class="card-body">

                                    <div class="logo-wrap">
                                        <img src="{{ public_path('logo.webp') }}" class="logo-img" alt="Logo">
                                    </div>

                                    <div class="photo-wrap">
                                        @if($p->foto)
                                            <div class="photo-box">
                                                <img src="{{ $p->foto_pdf_path }}" alt="Foto">
                                            </div>
                                        @else
                                            <div class="photo-placeholder">?</div>
                                        @endif
                                    </div>

                                    <div class="p-name">{{ Str::limit($p->nama_lengkap, 26) }}</div>
                                    <div class="p-unit">{{ Str::limit($p->unit_kerja ?? 'Peserta', 35) }}</div>

                                    <div class="pill-wrap">
                                        <span class="pill">{{ Str::limit($event->nama_event, 42) }}</span>
                                    </div>

                                    <div class="qr-wrap">
                                        <div class="qr-box">
                                            <img src="data:image/svg+xml;base64,{{ base64_encode($qrc) }}" alt="QR">
                                        </div>
                                        <div class="scan-label">Scan untuk Presensi</div>
                                    </div>

                                </div>
                            </div>
                        </td>
                    @endforeach
                    @if($row->count() < 2)
                        <td></td>
                    @endif
                </tr>
            @endforeach
        </table>
    @endforeach
</body>
</html>
