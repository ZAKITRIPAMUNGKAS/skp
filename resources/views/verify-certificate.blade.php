@extends('layouts.app')

@section('title', 'Verifikasi Sertifikat')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="p-8 text-center">
            <div class="mb-6 flex justify-center">
                <div class="w-20 h-20 bg-primary/10 rounded-2xl flex items-center justify-center">
                    <svg class="w-10 h-10 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>

            @if($status === 'valid')
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Sertifikat Valid</h1>
                <p class="text-sm text-gray-500 mb-8">Dokumen ini telah terverifikasi secara resmi oleh Sistem ARQAM.</p>

                <div class="space-y-4 text-left bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nama Peserta</p>
                        <p class="text-gray-800 font-bold text-lg">{{ $peserta->nama_lengkap }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">NIP / NBM</p>
                            <p class="text-gray-800 font-medium">{{ $peserta->nik ?? $peserta->nbm ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Instansi</p>
                            <p class="text-gray-800 font-medium">{{ $peserta->unit_kerja ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Kegiatan</p>
                        <p class="text-gray-800 font-bold">{{ $event->nama_event }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }}</p>
                    </div>
                    <div class="pt-4 border-t border-gray-200 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Predikat</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @if($penilaian->predikat=='Amat Baik') bg-green-100 text-green-800 @elseif($penilaian->predikat=='Baik') bg-blue-100 text-blue-800 @else bg-gray-100 text-gray-800 @endif">
                                {{ $penilaian->predikat }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Status</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $penilaian->status_kelulusan }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('landing') }}" class="inline-flex items-center text-sm font-semibold text-primary hover:underline">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Beranda
                    </a>
                </div>
            @else
                <h1 class="text-2xl font-bold text-red-600 mb-2">Sertifikat Tidak Valid</h1>
                <p class="text-sm text-gray-500 mb-8">Maaf, data sertifikat tidak ditemukan atau kode verifikasi salah.</p>
                
                <div class="p-12 bg-red-50 rounded-2xl border border-red-100 flex flex-col items-center">
                    <svg class="w-16 h-16 text-red-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-sm text-red-700 font-medium">Dokumen ini tidak dapat diverifikasi.</p>
                </div>

                <div class="mt-8">
                    <a href="{{ route('landing') }}" class="btn bg-primary text-white px-6 py-2.5 rounded-xl text-sm font-bold inline-block">
                        Kembali ke Beranda
                    </a>
                </div>
            @endif
        </div>
    </div>
    
    <p class="mt-8 text-xs text-gray-400">
        &copy; {{ date('Y') }} ARQAM App — Sistem Evaluasi Baitul Arqam.
    </p>
</div>
@endsection
