@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
    <div class="w-full max-w-lg bg-white rounded-[2.5rem] shadow-2xl shadow-primary/10 p-8 lg:p-12 text-center">
        
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
            <svg class="w-12 h-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h2 class="text-3xl font-bold font-heading text-gray-800 mb-2">Pendaftaran Berhasil!</h2>
        <p class="text-gray-500 mb-8">Selamat, Anda telah terdaftar sebagai peserta dalam event <strong>{{ $event->nama_event }}</strong>.</p>

        <div class="bg-primary/5 rounded-[2rem] p-8 mb-8 text-left border border-primary/10">
            <h3 class="text-sm font-bold text-primary uppercase tracking-widest mb-4">Akun Login Anda</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-gray-100">
                    <span class="text-xs text-gray-400 font-bold">USERNAME</span>
                    <span class="text-sm font-mono font-bold text-gray-800">{{ $username }}</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-gray-100">
                    <span class="text-xs text-gray-400 font-bold">PASSWORD</span>
                    <span class="text-sm font-mono font-bold text-gray-800">{{ $password }}</span>
                </div>
            </div>
            <p class="text-[10px] text-gray-400 mt-4 leading-relaxed">
                <span class="text-primary font-bold">Catatan:</span> Harap simpan informasi di atas. Anda dapat menggunakan username atau email untuk masuk ke dashboard peserta.
            </p>
        </div>

        <div class="space-y-3">
            <a href="{{ route('login') }}" class="block w-full bg-primary hover:bg-primary-600 text-white font-bold py-4 rounded-2xl transition-all shadow-lg shadow-primary/20 active:scale-[0.98]">
                Masuk ke Dashboard
            </a>
            <p class="text-xs text-gray-400">Silakan login untuk mengakses materi dan evaluasi.</p>
        </div>

    </div>
</div>
@endsection
