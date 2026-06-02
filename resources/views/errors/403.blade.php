@extends('layouts.main')

@section('title', 'Akses Ditolak')

@section('content')
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="text-center">
        <div class="text-8xl font-bold font-heading text-red-100 mb-4">403</div>
        <h1 class="text-2xl font-bold font-heading text-gray-800 mb-2">Akses Ditolak</h1>
        <p class="text-gray-500 mb-6">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white text-sm font-medium rounded-xl hover:bg-primary/90 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
