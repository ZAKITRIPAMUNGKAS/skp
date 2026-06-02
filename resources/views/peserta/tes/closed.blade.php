@extends('layouts.main')

@section('title', ucfirst($tipe) . ' — Tes Ditutup')

@section('content')
<div class="max-w-lg mx-auto py-16 px-4 text-center">
    <div class="bg-white rounded-2xl shadow-card border border-gray-100 p-10">
        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h1 class="text-xl font-heading font-bold text-gray-800 mb-2">Tes {{ ucfirst($tipe) }} Belum Dibuka</h1>
        <p class="text-gray-500 text-sm mb-6">Tes akan dibuka oleh admin. Silakan tunggu informasi selanjutnya.</p>
        <a href="{{ route('peserta.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary/10 text-primary text-sm font-medium rounded-xl hover:bg-primary/20 transition-colors">
            ← Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
