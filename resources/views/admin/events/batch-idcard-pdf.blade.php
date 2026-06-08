<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 6mm; }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background: #fff;
        }

        .card-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 4mm;
        }

        .page-break { page-break-after: always; }

        /* ── Kartu ── */
        .card {
            width: 86mm;
            height: 137mm;
            overflow: hidden;
            position: relative;
            background: #fff;
            border: 0.5px solid #bfdbfe;
            border-radius: 2mm;
        }

        /* Background covers full card */
        .card-bg {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
        }

        /* Content above bg */
        .card-body {
            position: relative;
            z-index: 1;
            width: 100%;
            text-align: center;
        }

        /* ── Logo area ── */
        .logo-area {
            padding-top: 3.5mm;
            padding-bottom: 1.5mm;
        }
        .logo-badge {
            display: inline-block;
            background: #ffffff;
            border-radius: 5mm;
            padding: 1mm 3.5mm;
            box-shadow: 0 1px 4px rgba(0,0,0,0.15);
        }
        .logo-badge img {
            height: 7mm;
            object-fit: contain;
            vertical-align: middle;
        }

        /* ── PESERTA ── */
        .lbl-peserta {
            font-size: 20pt;
            font-weight: 900;
            color: #0d3a73;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            line-height: 1;
            margin-bottom: 0.5mm;
        }

        /* ── Nama Event ── */
        .lbl-event {
            font-size: 10pt;
            font-weight: 900;
            color: #0d3a73;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 3mm;
            margin-bottom: 0.5mm;
            line-height: 1.1;
        }

        /* ── Lokasi & Tanggal ── */
        .lbl-place {
            font-size: 7.5pt;
            font-weight: 700;
            color: #1a5276;
            text-transform: uppercase;
            line-height: 1;
            margin-bottom: 3mm;
        }

        /* ── Foto Kotak (1:1) ── */
        .photo-area { width: 100%; text-align: center; margin-bottom: 3mm; }
        .photo-square {
            display: inline-block;
            width: 27mm;
            height: 27mm;
            border-radius: 1.5mm;
            overflow: hidden;
            border: 2px solid #ffffff;
            box-shadow: 0 3px 8px rgba(0,0,0,0.18);
            background-color: #dbeafe;
            position: relative;
        }
        .photo-square img {
            width: 100%;
            height: auto;
            display: block;
        }
        .photo-placeholder {
            display: inline-block;
            width: 27mm;
            height: 27mm;
            border-radius: 1.5mm;
            border: 2px solid #ffffff;
            background: #dbeafe;
            text-align: center;
            padding-top: 6mm;
            color: #1a5276;
            font-size: 16pt;
            font-weight: bold;
        }

        /* ── Nickname ── */
        .nickname-area { margin-bottom: 2.5mm; }
        .nickname-badge {
            display: inline-block;
            background: #f5b300;
            color: #ffffff;
            font-size: 12pt;
            font-weight: 900;
            padding: 1.2mm 6.5mm;
            border-radius: 2mm;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        /* ── Nama Lengkap ── */
        .p-name {
            font-size: 8.5pt;
            font-weight: 900;
            color: #0d3a73;
            text-transform: uppercase;
            padding: 0 3mm;
            margin-bottom: 0.8mm;
            line-height: 1.2;
            word-wrap: break-word;
        }

        /* ── Unit Kerja ── */
        .p-unit {
            font-size: 6pt;
            color: #1a5276;
            font-weight: 600;
            padding: 0 4mm;
            margin-bottom: 2mm;
            line-height: 1.3;
        }

        /* ── QR Code murni ── */
        .qr-area { width: 100%; text-align: center; }
        .qr-box {
            display: inline-block;
            width: 22mm;
            height: 22mm;
            border: 1px solid #93c5fd;
            padding: 0.8mm;
            background: #fff;
            border-radius: 1.5mm;
        }
        .qr-box img { width: 100%; height: 100%; }
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
                            $qrc = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                                ->errorCorrection('M')
                                ->size(100)
                                ->margin(0)
                                ->generate($qrData);
                        @endphp
                        <td>
                            <div class="card">
                                <img class="card-bg" src="{{ public_path('IDCARD.png') }}">

                                <div class="card-body">

                                    {{-- Logo --}}
                                    <div class="logo-area">
                                        <div class="logo-badge">
                                            <img src="{{ public_path('logo.webp') }}" alt="UMS">
                                        </div>
                                    </div>

                                    {{-- PESERTA --}}
                                    <div class="lbl-peserta">PESERTA</div>

                                    {{-- Nama Event --}}
                                    <div class="lbl-event">{{ Str::limit($event->nama_event, 42) }}</div>

                                    {{-- Lokasi & Tanggal --}}
                                    <div class="lbl-place">
                                        {{ Str::limit($event->lokasi, 26) }},
                                        @if($event->tanggal_mulai && $event->tanggal_selesai)
                                            @if($event->tanggal_mulai->format('m Y') === $event->tanggal_selesai->format('m Y'))
                                                {{ $event->tanggal_mulai->format('d') }}-{{ $event->tanggal_selesai->format('d M Y') }}
                                            @else
                                                {{ $event->tanggal_mulai->format('d M Y') }} - {{ $event->tanggal_selesai->format('d M Y') }}
                                            @endif
                                        @elseif($event->tanggal_mulai)
                                            {{ $event->tanggal_mulai->format('d M Y') }}
                                        @endif
                                    </div>

                                     {{-- Foto Kotak --}}
                                     <div class="photo-area">
                                         @if($p->foto)
                                             <div class="photo-square">
                                                 <img src="{{ $p->foto_pdf_path }}" alt="Foto">
                                             </div>
                                         @else
                                             <div class="photo-placeholder">?</div>
                                         @endif
                                     </div>

                                    {{-- Nickname --}}
                                    @if($p->nama_panggilan)
                                        <div class="nickname-area">
                                            <span class="nickname-badge">{{ $p->nama_panggilan }}</span>
                                        </div>
                                    @endif

                                    {{-- Nama Lengkap --}}
                                    <div class="p-name">{{ Str::limit($p->nama_lengkap, 30) }}</div>

                                    {{-- Unit Kerja --}}
                                    <div class="p-unit">{{ Str::limit($p->unit_kerja ?? 'Peserta', 42) }}</div>

                                    {{-- QR murni --}}
                                    <div class="qr-area">
                                        <div class="qr-box">
                                            <img src="data:image/svg+xml;base64,{{ base64_encode($qrc) }}" alt="QR">
                                        </div>
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
