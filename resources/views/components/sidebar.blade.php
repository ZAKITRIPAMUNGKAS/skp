{{-- Sidebar Component --}}
@php
    $user = auth()->user();
    $isAdmin = $user && $user->isAdmin();
    $isFasilitator = $user && $user->isFasilitator();
    $currentRoute = request()->route() ? request()->route()->getName() : '';
@endphp

{{-- Desktop Sidebar --}}
<aside class="fixed inset-y-0 left-0 z-40 bg-primary text-white transition-sidebar hidden lg:flex flex-col w-64"
       :class="sidebarCollapsed ? 'w-20' : 'w-64'">

    {{-- Logo --}}
    <div class="flex items-center h-16 px-4 border-b border-gray-150 bg-white">
        <div class="flex items-center gap-3 overflow-hidden w-full justify-center">
            <img src="{{ asset('logo.webp') }}" alt="Logo" class="h-12 object-contain transition-all duration-300" :class="sidebarCollapsed ? 'w-10 h-10' : 'w-auto max-w-[150px]'">
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto sidebar-scroll py-4 px-3">
        <div x-show="!sidebarCollapsed" class="px-3 mb-2">
            <span class="text-[10px] font-semibold uppercase tracking-widest text-white/40">Menu Utama</span>
        </div>

        @if($isAdmin || $isFasilitator)
            {{-- Admin & Fasilitator Menu --}}
            @if($isAdmin)
                <x-sidebar-item icon="dashboard" label="Dashboard" route="admin.dashboard" :collapsed="false" />
            @endif

            <div x-show="!sidebarCollapsed" class="px-3 mt-5 mb-2">
                <span class="text-[10px] font-semibold uppercase tracking-widest text-white/40">Kelola</span>
            </div>
            <x-sidebar-item icon="event" label="Kelola Event" route="admin.events.index" :collapsed="false" />
            
            @if($isAdmin)
                <x-sidebar-item icon="people" label="Kelola Peserta" route="admin.participants.index" :collapsed="false" />
                <x-sidebar-item icon="fasilitator" label="Kelola Fasilitator" route="admin.fasilitator.index" :collapsed="false" />
                <x-sidebar-item icon="quiz" label="Bank Soal" route="admin.soal.index" :collapsed="false" />
                <x-sidebar-item icon="image" label="Galeri Pelatihan" route="admin.galleries.index" :collapsed="false" />
                <x-sidebar-item icon="comment" label="Testimoni" route="admin.testimonials.index" :collapsed="false" />

                <div x-show="!sidebarCollapsed" class="px-3 mt-5 mb-2">
                    <span class="text-[10px] font-semibold uppercase tracking-widest text-white/40">Sistem</span>
                </div>
                <x-sidebar-item icon="logs" label="Log Aktivitas" route="admin.logs.index" :collapsed="false" />
            @endif
        @else
            {{-- Peserta Menu --}}
            <x-sidebar-item icon="dashboard" label="Dashboard" route="peserta.dashboard" :collapsed="false" />
            <x-sidebar-item icon="event" label="Jadwal Sesi" route="peserta.jadwal" :collapsed="false" />
            <x-sidebar-item icon="quiz" label="Pretest / Posttest" route="peserta.tes.index" :collapsed="false" />
            <x-sidebar-item icon="affective" label="Evaluasi Afektif" route="peserta.afektif.index_root" :collapsed="false" />
            <x-sidebar-item icon="attendance" label="Kehadiran" route="peserta.kehadiran" :collapsed="false" />
            <x-sidebar-item icon="survey" label="Kuisioner" route="peserta.angket.index_root" :collapsed="false" />
            <x-sidebar-item icon="ranking" label="Hasil Penilaian" route="peserta.hasil" :collapsed="false" />
        @endif
    </nav>

    {{-- User Info --}}
    <div class="border-t border-white/10 p-3">
        <div class="flex items-center gap-3 px-2 py-2 rounded-xl hover:bg-white/10 transition-colors cursor-pointer"
             x-data="{ showMenu: false }" @click="showMenu = !showMenu">
            <div class="w-9 h-9 rounded-full bg-accent/30 flex items-center justify-center flex-shrink-0 ring-2 ring-accent/50 overflow-hidden">
                @if(auth()->user()->foto)
                    <img src="{{ auth()->user()->foto_url }}" class="w-full h-full object-cover">
                @elseif(auth()->user()->peserta && auth()->user()->peserta->foto)
                    <img src="{{ auth()->user()->peserta->foto_url }}" class="w-full h-full object-cover">
                @else
                    <span class="text-sm font-semibold text-accent">{{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'U' }}</span>
                @endif
            </div>
            <div x-show="!sidebarCollapsed" x-transition class="flex-1 overflow-hidden">
                <p class="text-sm font-medium truncate">{{ auth()->check() ? auth()->user()->name : 'Guest' }}</p>
                <p class="text-xs text-white/50 capitalize">{{ auth()->check() ? auth()->user()->role : '' }}</p>
            </div>
            <svg x-show="!sidebarCollapsed" class="w-4 h-4 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01" />
            </svg>
        </div>
    </div>

    {{-- Collapse toggle --}}
    <button @click="sidebarCollapsed = !sidebarCollapsed"
            class="absolute -right-3 top-20 w-6 h-6 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-gray-50 transition-colors border border-gray-200 group">
        <svg class="w-3.5 h-3.5 text-gray-500 transition-transform duration-300"
             :class="sidebarCollapsed ? 'rotate-180' : ''"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>
</aside>

{{-- Mobile Sidebar --}}
<aside class="fixed inset-y-0 left-0 z-50 w-72 bg-primary text-white flex flex-col lg:hidden transform transition-transform duration-300 -translate-x-full"
       :class="mobileMenu ? 'translate-x-0' : '-translate-x-full'">

    {{-- Mobile Logo --}}
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-150 bg-white text-gray-800">
        <div class="flex items-center justify-center w-full">
            <img src="{{ asset('logo.webp') }}" alt="Logo" class="h-12 object-contain">
        </div>
        <button @click="mobileMenu = false" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors">
            <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Mobile Navigation (Admin & Fasilitator) --}}
    @if($isAdmin || $isFasilitator)
    <nav class="flex-1 overflow-y-auto sidebar-scroll py-4 px-3">
        @if($isAdmin)
            <x-sidebar-item icon="dashboard" label="Dashboard" route="admin.dashboard" :collapsed="false" :mobile="true" />
        @endif
        <div class="px-3 mt-5 mb-2"><span class="text-[10px] font-semibold uppercase tracking-widest text-white/40">Kelola</span></div>
        <x-sidebar-item icon="event" label="Kelola Event" route="admin.events.index" :collapsed="false" :mobile="true" />
        @if($isAdmin)
            <x-sidebar-item icon="people" label="Kelola Peserta" route="admin.participants.index" :collapsed="false" :mobile="true" />
            <x-sidebar-item icon="fasilitator" label="Kelola Fasilitator" route="admin.fasilitator.index" :collapsed="false" :mobile="true" />
            <x-sidebar-item icon="quiz" label="Bank Soal" route="admin.soal.index" :collapsed="false" :mobile="true" />
            <x-sidebar-item icon="image" label="Galeri Pelatihan" route="admin.galleries.index" :collapsed="false" :mobile="true" />
            <x-sidebar-item icon="comment" label="Testimoni" route="admin.testimonials.index" :collapsed="false" :mobile="true" />
            <div class="px-3 mt-5 mb-2"><span class="text-[10px] font-semibold uppercase tracking-widest text-white/40">Sistem</span></div>
            <x-sidebar-item icon="logs" label="Log Aktivitas" route="admin.logs.index" :collapsed="false" :mobile="true" />
        @endif
    </nav>
    @else
    <nav class="flex-1 overflow-y-auto sidebar-scroll py-4 px-3 flex flex-col items-center justify-center text-center opacity-50 p-6">
        <svg class="w-12 h-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
        <p class="text-sm">Silakan gunakan navigasi di bagian bawah layar.</p>
    </nav>
    @endif

    {{-- Mobile User Info --}}
    <div class="border-t border-white/10 p-4">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-full bg-accent/30 flex items-center justify-center ring-2 ring-accent/50 overflow-hidden">
                @if(auth()->user()->foto)
                    <img src="{{ auth()->user()->foto_url }}" class="w-full h-full object-cover">
                @elseif(auth()->user()->peserta && auth()->user()->peserta->foto)
                    <img src="{{ auth()->user()->peserta->foto_url }}" class="w-full h-full object-cover">
                @else
                    <span class="text-sm font-semibold text-accent">{{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'U' }}</span>
                @endif
            </div>
            <div>
                <p class="text-sm font-medium">{{ auth()->check() ? auth()->user()->name : 'Guest' }}</p>
                <p class="text-xs text-white/50 capitalize">{{ auth()->check() ? auth()->user()->role : '' }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-white/10 text-white/70 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </button>
        </form>
    </div>
</aside>
