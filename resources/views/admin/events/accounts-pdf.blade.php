<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Akun Peserta - {{ $event->nama_event }}</title>
    <style>
        @page { margin: 0; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 11px; 
            color: #333;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 15px;
            background-color: #1A6D9B; /* Arqam Blue */
        }
        .container {
            margin-left: 35px;
            margin-right: 35px;
            padding-top: 40px;
            padding-bottom: 40px;
        }
        .header {
            position: relative;
            margin-bottom: 30px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 20px;
        }
        .header-content {
            margin-right: 120px;
        }
        .header h1 {
            color: #1A6D9B;
            font-size: 24px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header h2 {
            font-size: 14px;
            color: #4b5563;
            margin: 5px 0 0 0;
            font-weight: normal;
        }
        .mascot {
            position: absolute;
            top: -10px;
            right: 0;
            width: 90px;
        }
        .info-box {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            border: 1px solid #e5e7eb;
        }
        .info-box p {
            margin: 0 0 8px 0;
            line-height: 1.5;
        }
        .password-highlight {
            display: inline-block;
            background-color: #fef2f2;
            color: #dc2626;
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: bold;
            border: 1px dashed #f87171;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #1A6D9B;
            color: white;
            text-align: left;
            padding: 10px 12px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .username-badge {
            background-color: #e0f2fe;
            color: #0369a1;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            font-size: 9px;
            color: #9ca3af;
            text-align: center;
        }
        .event-meta {
            color: #6b7280;
            font-size: 10px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="sidebar"></div>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <h1>Daftar Akun Login</h1>
                <h2>Sistem Evaluasi Perkaderan ARQAM</h2>
                <div class="event-meta">
                    <strong>Event:</strong> {{ $event->nama_event }}<br>
                    <strong>Lokasi:</strong> {{ $event->lokasi }} | 
                    <strong>Waktu:</strong> {{ $event->tanggal_mulai->format('d M Y') }}
                </div>
            </div>
            <img src="{{ public_path('images/arka/arka_greeting.png') }}" class="mascot">
        </div>

        <div class="info-box">
            <p>Berikut adalah kredensial login untuk masing-masing peserta. Gunakan <strong>Username</strong> di bawah ini untuk masuk ke aplikasi.</p>
            <p>
                <span class="password-highlight">Password Default: {{ $defaultPassword }}</span>
                <span style="font-size: 9px; color: #6b7280; margin-left: 10px;">*Peserta disarankan segera mengubah password setelah login pertama.</span>
            </p>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Nama Lengkap</th>
                    <th>Username (Login)</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participants as $index => $ep)
                    <tr>
                        <td style="text-align: center; color: #9ca3af;">{{ $index + 1 }}</td>
                        <td><strong style="color: #111827;">{{ $ep->peserta->nama_lengkap }}</strong></td>
                        <td><span class="username-badge">{{ $ep->peserta->user->username ?? '-' }}</span></td>
                        <td style="color: #6b7280;">{{ $ep->peserta->user->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Dicetak otomatis oleh Sistem ARQAM pada {{ now()->format('d/m/Y H:i') }}</p>
            <p>&copy; {{ date('Y') }} Lembaga Agama Pengembangan Persyarikatan Pengkaderan & Alumni (LP3A) Universitas Muhammadiyah Surakarta</p>
        </div>
    </div>
</body>
</html>
