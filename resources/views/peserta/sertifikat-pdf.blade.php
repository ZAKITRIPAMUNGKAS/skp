<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat - {{ $peserta->nama_lengkap }}</title>
    <style>
        @page { margin: 0; }
        body { 
            margin: 0; 
            padding: 0; 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            color: #111827; 
            background: #ffffff;
        }
        
        .border-emerald { 
            position: absolute; 
            top: 0; left: 0; right: 0; bottom: 0; 
            border: 22px solid #1A6D9B; 
        }
        .border-gold { 
            position: absolute; 
            top: 28px; left: 28px; right: 28px; bottom: 28px; 
            border: 3px solid #fbbf24; 
        }
        
        .bg-pattern {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            opacity: 0.03;
            z-index: 1;
        }

        .content { 
            position: relative; 
            padding: 70px 100px; 
            text-align: center; 
            z-index: 10;
        }
        
        .header-section { margin-bottom: 30px; }
        .logo-top { width: 80px; margin-bottom: 15px; }
        .org-name { font-size: 20px; font-weight: bold; color: #155C84; text-transform: uppercase; margin-bottom: 4px; }
        .dept-name { font-size: 12px; color: #6b7280; letter-spacing: 2px; text-transform: uppercase; font-weight: bold; }
        
        .main-title { 
            font-size: 64px; 
            font-weight: bold; 
            color: #1A6D9B; 
            margin: 25px 0; 
            letter-spacing: 8px; 
            text-transform: uppercase;
        }
        .subtitle { font-size: 18px; color: #4b5563; margin-bottom: 25px; font-style: italic; }
        
        .peserta-name { 
            font-size: 40px; 
            font-weight: bold; 
            color: #111827; 
            margin: 15px 0; 
            border-bottom: 2px solid #fbbf24; 
            display: inline-block; 
            padding: 0 50px 8px 50px; 
        }
        .peserta-info { font-size: 14px; color: #6b7280; margin-bottom: 35px; }
        
        .description { 
            font-size: 16px; 
            line-height: 1.8; 
            color: #374151; 
            max-width: 90%; 
            margin: 0 auto 35px auto; 
        }
        .event-highlight { color: #1A6D9B; font-weight: bold; font-size: 18px; }
        
        .result-badge { 
            background: #f0f9ff; 
            border: 2px solid #1A6D9B; 
            padding: 12px 35px; 
            display: inline-block; 
            border-radius: 50px; 
            margin-bottom: 45px;
            box-shadow: 0 4px 6px rgba(26, 109, 155, 0.1);
        }
        .predikat-text { font-size: 18px; font-weight: bold; color: #155C84; text-transform: uppercase; }
        
        .footer-section { margin-top: 10px; }
        .signature-table { width: 100%; border-collapse: collapse; }
        .signature-table td { width: 33.3%; vertical-align: bottom; text-align: center; padding: 0 20px; }
        
        .sign-title { font-size: 13px; color: #6b7280; margin-bottom: 70px; }
        .sign-name { font-size: 16px; font-weight: bold; color: #111827; }
        .sign-line { border-top: 1px solid #111827; width: 80%; margin: 5px auto 0 auto; }
        
        .qr-wrapper { position: absolute; bottom: 70px; left: 100px; text-align: center; }
        .qr-img { border: 1px solid #e5e7eb; padding: 2px; background: white; }
        .qr-label { font-size: 8px; color: #9ca3af; margin-top: 5px; text-transform: uppercase; font-weight: bold; }

        .arka-selebrasi {
            position: absolute;
            bottom: 40px;
            right: 40px;
            width: 150px;
            z-index: 5;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="border-emerald"></div>
    <div class="border-gold"></div>
    <div class="bg-pattern"></div>

    <img src="{{ public_path('images/arka/arka_selebrasi.png') }}" class="arka-selebrasi">

    <div class="content">
        <div class="header-section">
            <img src="{{ public_path('logo.png') }}" class="logo-top">
            <div class="org-name">PIMPINAN DAERAH MUHAMMADIYAH KARANGANYAR</div>
            <div class="dept-name">Majelis Pendidikan Kader dan Sumber Daya Insani</div>
        </div>

        <div class="main-title">SERTIFIKAT</div>
        <p class="subtitle">Diberikan secara istimewa kepada:</p>

        <div class="peserta-name">{{ $peserta->nama_lengkap }}</div>
        <div class="peserta-info">NIK/NBM: {{ $peserta->nik ?? $peserta->nbm ?? '-' }} | Instansi: {{ $peserta->unit_kerja ?? '-' }}</div>

        <p class="description">
            Telah mengikuti seluruh rangkaian perkaderan dan dinyatakan <br>
            <strong style="text-transform: uppercase; color: #1A6D9B; font-size: 20px;">{{ $skor->status_kelulusan }}</strong><br>
            dalam kegiatan <span class="event-highlight">{{ $event->nama_event }}</span><br>
            yang diselenggarakan pada {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d F Y') }} s.d {{ \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d F Y') }}<br>
            bertempat di {{ $event->lokasi }}.
        </p>

        <div class="result-badge">
            <span class="predikat-text">Predikat: {{ $skor->predikat }}</span>
        </div>

        <div class="footer-section">
            <table class="signature-table">
                <tr>
                    <td>
                        <div class="sign-title">Ketua Instruktur</div>
                        <div class="sign-name">_____________________</div>
                        <div class="sign-line"></div>
                    </td>
                    <td>
                        {{-- Center space --}}
                    </td>
                    <td>
                        <div class="sign-title">Master of Training</div>
                        <div class="sign-name">_____________________</div>
                        <div class="sign-line"></div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="qr-wrapper">
            @php
                $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(80)->margin(0)->generate($verificationUrl);
            @endphp
            <div class="qr-img">
                <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" style="width: 80px; height: 80px;">
            </div>
            <div class="qr-label">Scan untuk Verifikasi</div>
        </div>
    </div>
</body>
</html>
