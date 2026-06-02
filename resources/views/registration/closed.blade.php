@extends('layouts.app')

@section('title', 'Pendaftaran Ditutup')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-[2.5rem] shadow-2xl shadow-primary/10 p-12 text-center">
        
        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-8">
            <svg class="w-10 h-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h2 class="text-2xl font-bold font-heading text-gray-800 mb-2">Pendaftaran Ditutup</h2>
        <p class="text-sm text-gray-500 mb-8">Mohon maaf, pendaftaran untuk event <strong>{{ $event->nama_event }}</strong> sudah berakhir atau ditutup.</p>

        <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-primary font-bold hover:underline">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
