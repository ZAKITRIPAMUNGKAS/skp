@extends('layouts.main')

@section('title', 'Detail Fasilitator — ' . $fasilitator->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.fasilitator.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Fasilitator
        </a>
        <x-page-header title="Detail Fasilitator" subtitle="Informasi akun dan riwayat penugasan event." />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Profile Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center text-center h-fit">
            <div class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center mb-4 ring-4 ring-primary/5">
                <span class="text-2xl font-bold text-primary">{{ strtoupper(substr($fasilitator->name, 0, 2)) }}</span>
            </div>
            
            <h3 class="text-lg font-bold text-gray-800">{{ $fasilitator->name }}</h3>
            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 capitalize">
                {{ $fasilitator->role }}
            </span>

            <div class="w-full border-t border-gray-100 my-5"></div>

            <div class="w-full space-y-4 text-left">
                <div>
                    <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Username</label>
                    <p class="text-sm font-semibold text-gray-800 font-mono mt-0.5">{{ $fasilitator->username }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Alamat Email</label>
                    <p class="text-sm font-medium text-gray-700 mt-0.5">{{ $fasilitator->email }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Akun Dibuat</label>
                    <p class="text-sm text-gray-600 mt-0.5">{{ $fasilitator->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- Assigned Events --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h4 class="text-base font-bold text-gray-800 mb-4 font-heading flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Event yang Ditugaskan
                </h4>

                <div class="divide-y divide-gray-100">
                    @forelse($fasilitator->assignedEvents as $event)
                        <div class="py-4 first:pt-0 last:pb-0 flex flex-col sm:flex-row sm:items-center justify-between gap-3 group">
                            <div>
                                <h5 class="font-semibold text-gray-800 group-hover:text-primary transition-colors">
                                    {{ $event->nama_event }}
                                </h5>
                                <div class="flex items-center gap-3 text-xs text-gray-400 mt-1">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}
                                    </span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $event->tempat }}
                                    </span>
                                </div>
                            </div>
                            
                            <a href="{{ route('admin.events.show', $event->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-primary/5 hover:bg-primary text-primary hover:text-white rounded-lg text-xs font-bold transition-all self-start sm:self-auto">
                                Detail Event
                            </a>
                        </div>
                    @empty
                        <div class="py-8 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-500">Belum ada penugasan event</p>
                            <p class="text-xs text-gray-400 mt-1">Fasilitator ini belum ditugaskan ke event mana pun.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
@endsection
