@extends('layouts.main')

@section('title', $event->nama_event)

@section('breadcrumb')
    <a href="{{ auth()->user()->isFasilitator() ? route('admin.events.index') : route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Dashboard</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('admin.events.index') }}" class="text-sm text-gray-500 hover:text-primary transition-colors">Kelola Event</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-sm font-medium text-gray-700">{{ Str::limit($event->nama_event, 30) }}</span>
@endsection

@section('content')
<div x-data="{ activeTab: 'peserta' }">

    {{-- Event Header --}}
    <div class="bg-white rounded-2xl shadow-card border border-gray-100 p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-2xl font-bold font-heading text-gray-800">{{ $event->nama_event }}</h1>
                    <x-badge :type="$event->status">{{ ucfirst($event->status) }}</x-badge>
                </div>
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $event->tanggal_mulai->format('d M Y') }} — {{ $event->tanggal_selesai->format('d M Y') }}
                    </span>
                    @if($event->lokasi)
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $event->lokasi }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if($event->status === 'persiapan')
                    <form method="POST" action="{{ route('admin.events.updateStatus', $event) }}" class="inline">
                        @csrf
                        <input type="hidden" name="status" value="berlangsung">
                        <x-button type="submit" variant="success" size="sm">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                            Mulai Event
                        </x-button>
                    </form>
                @elseif($event->status === 'berlangsung')
                    <form method="POST" action="{{ route('admin.events.updateStatus', $event) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan event ini? Status yang sudah diselesaikan tidak dapat diubah kembali.');">
                        @csrf
                        <input type="hidden" name="status" value="selesai">
                        <x-button type="submit" variant="danger" size="sm">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0"/></svg>
                            Selesaikan Event
                        </x-button>
                    </form>
                @endif
                <x-button variant="ghost" size="sm" href="{{ route('admin.events.edit', $event) }}">
                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </x-button>
                <x-button variant="accent" size="sm" href="{{ route('admin.participants.idCards', $event) }}" target="_blank">
                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download ID Cards
                </x-button>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <x-stat-widget label="Total Peserta" :value="$totalPeserta . ($event->kuota ? ' / ' . $event->kuota : '')"
            :icon="'<svg class=\'w-6 h-6 text-primary\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z\' /></svg>'"
            iconBg="bg-primary/10">
            @if($event->kuota)
                <div class="mt-2 w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-primary h-1.5 rounded-full" style="width: {{ min(100, ($totalPeserta / $event->kuota) * 100) }}%"></div>
                </div>
            @endif
        </x-stat-widget>
        <x-stat-widget label="Selesai Pretest" :value="$completedPretest"
            :icon="'<svg class=\'w-6 h-6 text-secondary\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4\' /></svg>'"
            iconBg="bg-secondary/10" />
        <x-stat-widget label="Selesai Afektif" :value="$completedAfektif"
            :icon="'<svg class=\'w-6 h-6 text-accent\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z\' /></svg>'"
            iconBg="bg-accent/10" />
        <x-stat-widget label="Total Sesi" :value="$event->sesi_count"
            :icon="'<svg class=\'w-6 h-6 text-blue-600\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10\' /></svg>'"
            iconBg="bg-blue-50" />
    </div>

    {{-- Tabs --}}
    <div class="bg-white rounded-2xl shadow-card border border-gray-100 overflow-hidden">
        {{-- Tab Navigation --}}
        <div class="border-b border-gray-100 px-6 overflow-x-auto">
            <div class="flex gap-0 min-w-max">
                @php
                    $tabs = [
                        'peserta'    => ['label' => 'Peserta', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                        'sesi'       => ['label' => 'Sesi', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                        'pretest'    => ['label' => 'Pretest/Posttest', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                        'afektif'    => ['label' => 'Afektif', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                        'psikomotor' => ['label' => 'Psikomotor', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                        'angket'     => ['label' => 'Angket', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        'ahp'        => ['label' => 'AHP-SAW', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                        'laporan'    => ['label' => 'Laporan', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    ];
                    if (auth()->user()->isAdmin()) {
                        $tabs['fasilitator'] = ['label' => 'Fasilitator', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'];
                        $tabs['logs'] = ['label' => 'Log Aktivitas', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'];
                    }
                @endphp

                @foreach($tabs as $key => $tab)
                    <button @click="activeTab = '{{ $key }}'"
                        :class="activeTab === '{{ $key }}'
                            ? 'border-primary text-primary'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="flex items-center gap-2 px-4 py-3.5 text-sm font-medium border-b-2 transition-all whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tab['icon'] }}"/>
                        </svg>
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Tab Content --}}
        <div class="p-6">
            {{-- Peserta Tab --}}
            <div x-show="activeTab === 'peserta'" x-transition>
                @include('admin.events.partials.tab-peserta')
            </div>

            {{-- Sesi Tab --}}
            <div x-show="activeTab === 'sesi'" x-transition style="display: none;">
                @include('admin.events.partials.tab-sesi')
            </div>

            {{-- Pretest/Posttest Tab --}}
            <div x-show="activeTab === 'pretest'" x-transition style="display: none;">
                @include('admin.events.partials.tab-pretest')
            </div>

            {{-- Afektif Tab --}}
            <div x-show="activeTab === 'afektif'" x-transition style="display: none;">
                @include('admin.events.partials.tab-afektif')
            </div>

            {{-- Psikomotor Tab --}}
            <div x-show="activeTab === 'psikomotor'" x-transition style="display: none;">
                @include('admin.events.partials.tab-psikomotor')
            </div>

            {{-- Angket Tab --}}
            <div x-show="activeTab === 'angket'" x-transition style="display: none;">
                @include('admin.events.partials.tab-angket')
            </div>

            {{-- AHP-SAW Tab --}}
            <div x-show="activeTab === 'ahp'" x-transition style="display: none;">
                @include('admin.events.partials.tab-ahp')
            </div>

            {{-- Laporan Tab --}}
            <div x-show="activeTab === 'laporan'" x-transition style="display: none;">
                @include('admin.events.partials.tab-laporan')
            </div>

            @if(auth()->user()->isAdmin())
                {{-- Fasilitator Tab --}}
                <div x-show="activeTab === 'fasilitator'" x-transition style="display: none;">
                    @include('admin.events.partials.tab-fasilitator')
                </div>

                {{-- Logs Tab --}}
                <div x-show="activeTab === 'logs'" x-transition style="display: none;">
                    @include('admin.events.partials.tab-logs')
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
