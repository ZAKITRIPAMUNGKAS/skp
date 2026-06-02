@extends('layouts.main')

@section('title', 'Scan Absensi')

@section('breadcrumb')
    <a href="{{ route('admin.events.show', $event) }}" class="text-sm text-gray-500 hover:text-primary transition-colors">{{ Str::limit($event->nama_event, 20) }}</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-sm font-medium text-gray-700">Scan Absensi: {{ $sesi->nama_sesi }}</span>
@endsection

@section('content')

    <x-page-header title="Scan Absensi" subtitle="Sesi: {{ $sesi->nama_sesi }}" />

    <x-card>
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">QR Scanner</h3>
            <p class="text-gray-500 mb-6">Fitur QR scanner akan tersedia di versi selanjutnya.</p>
            <x-button variant="ghost" href="{{ route('admin.events.show', $event) }}">← Kembali ke Event</x-button>
        </div>
    </x-card>

@endsection
