@extends('layouts.main')

@section('title', 'Buat Event Baru')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Dashboard</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('admin.events.index') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Kelola Event</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-sm font-medium text-gray-700">Buat Event Baru</span>
@endsection

@section('content')

    <x-page-header title="Buat Event Baru" subtitle="Tambah kegiatan Baitul Arqam baru" />

    <x-card>
        <form method="POST" action="{{ route('admin.events.store') }}">
            @csrf
            @include('admin.events._form')

            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <x-button variant="ghost" href="{{ route('admin.events.index') }}">Batal</x-button>
                <x-button type="submit" variant="primary" icon='<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'>
                    Simpan Event
                </x-button>
            </div>
        </form>
    </x-card>

@endsection
