{{-- Bottom Navigation for Mobile (Peserta Only) --}}
@php
    $currentRoute = request()->route() ? request()->route()->getName() : '';
    $event = null;
    $peserta = auth()->user()->peserta;
    if ($peserta) {
        $eventPeserta = \App\Models\EventPeserta::where('peserta_id', $peserta->id)->latest()->first();
        if ($eventPeserta && $eventPeserta->event) {
            $event = $eventPeserta->event;
        }
    }
@endphp

<div class="fixed bottom-0 left-0 z-40 w-full h-16 bg-white border-t border-gray-200 lg:hidden flex justify-around items-stretch pb-safe shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">

    {{-- Beranda --}}
    <a href="{{ route('peserta.dashboard') }}"
       class="inline-flex flex-col items-center justify-center flex-1 hover:bg-gray-50 group transition-colors {{ $currentRoute == 'peserta.dashboard' ? 'text-primary' : 'text-gray-500' }}">
        <svg class="w-5 h-5 mb-0.5 {{ $currentRoute == 'peserta.dashboard' ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <span class="text-[10px] sm:text-xs font-medium">Beranda</span>
    </a>

    {{-- Jadwal --}}
    <a href="{{ route('peserta.jadwal') }}"
       class="inline-flex flex-col items-center justify-center flex-1 hover:bg-gray-50 group transition-colors {{ $currentRoute == 'peserta.jadwal' ? 'text-primary' : 'text-gray-500' }}">
        <svg class="w-5 h-5 mb-0.5 {{ $currentRoute == 'peserta.jadwal' ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <span class="text-[10px] sm:text-xs font-medium">Jadwal</span>
    </a>

    {{-- Tes (Pretest / Posttest) --}}
    @if($event)
        <a href="{{ route('peserta.tes.instruction', [$event, 'pretest']) }}"
           class="inline-flex flex-col items-center justify-center flex-1 hover:bg-gray-50 group transition-colors {{ Str::contains($currentRoute, 'peserta.tes') ? 'text-primary' : 'text-gray-500' }}">
            <svg class="w-5 h-5 mb-0.5 {{ Str::contains($currentRoute, 'peserta.tes') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <span class="text-[10px] sm:text-xs font-medium">Tes</span>
        </a>
    @else
        <div class="inline-flex flex-col items-center justify-center flex-1 text-gray-300 cursor-not-allowed">
            <svg class="w-5 h-5 mb-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <span class="text-[10px] sm:text-xs font-medium">Tes</span>
        </div>
    @endif

    {{-- Profil --}}
    <a href="{{ route('peserta.profile.index') }}"
       class="inline-flex flex-col items-center justify-center flex-1 hover:bg-gray-50 group transition-colors {{ $currentRoute == 'peserta.profile.index' ? 'text-primary' : 'text-gray-500' }}">
        <svg class="w-5 h-5 mb-0.5 {{ $currentRoute == 'peserta.profile.index' ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        <span class="text-[10px] sm:text-xs font-medium">Profil</span>
    </a>

</div>

<style>
    /* Safe Area padding for iOS bottom bar */
    .pb-safe {
        padding-bottom: env(safe-area-inset-bottom);
    }
</style>
