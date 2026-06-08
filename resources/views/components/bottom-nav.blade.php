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

<div x-data="{ evalMenuOpen: false }">
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
            <a href="{{ route('peserta.tes.index') }}"
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

        {{-- Evaluasi (Afektif & Angket) --}}
        <button @click="evalMenuOpen = true"
                class="inline-flex flex-col items-center justify-center flex-1 hover:bg-gray-50 group transition-colors {{ (Str::contains($currentRoute, 'peserta.afektif') || Str::contains($currentRoute, 'peserta.angket')) ? 'text-primary' : 'text-gray-500' }}">
            <svg class="w-5 h-5 mb-0.5 {{ (Str::contains($currentRoute, 'peserta.afektif') || Str::contains($currentRoute, 'peserta.angket')) ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }}"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="text-[10px] sm:text-xs font-medium">Evaluasi</span>
        </button>

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

    {{-- Backdrop --}}
    <div x-show="evalMenuOpen"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="evalMenuOpen = false"
         class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm lg:hidden"
         style="display: none;">
    </div>

    {{-- Bottom Drawer --}}
    <div x-show="evalMenuOpen"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         class="fixed bottom-0 left-0 right-0 bg-white rounded-t-[2rem] p-6 z-50 shadow-2xl border-t border-gray-100 lg:hidden flex flex-col"
         style="display: none; padding-bottom: calc(1.5rem + env(safe-area-inset-bottom));">
        
        {{-- Handle bar --}}
        <div class="w-12 h-1.5 bg-gray-200 rounded-full mx-auto mb-6 shrink-0"></div>

        <h4 class="text-base font-heading font-bold text-gray-800 mb-4 text-center shrink-0">Menu Evaluasi</h4>

        <div class="space-y-4 flex-1">
            {{-- Afektif --}}
            <a href="{{ route('peserta.afektif.index_root') }}"
               class="flex items-center gap-4 p-4 bg-gray-50 hover:bg-primary/5 rounded-2xl border border-gray-100 group transition-all">
                <div class="w-11 h-11 bg-primary/10 rounded-xl flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div class="text-left">
                    <h5 class="text-sm font-bold text-gray-800 group-hover:text-primary transition-colors">Evaluasi Afektif</h5>
                    <p class="text-xs text-gray-400 mt-0.5">Penilaian sikap dan kedisiplinan diri</p>
                </div>
                <svg class="w-4 h-4 text-gray-300 ml-auto group-hover:text-primary transition-colors shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            {{-- Angket --}}
            <a href="{{ route('peserta.angket.index_root') }}"
               class="flex items-center gap-4 p-4 bg-gray-50 hover:bg-primary/5 rounded-2xl border border-gray-100 group transition-all">
                <div class="w-11 h-11 bg-accent/10 rounded-xl flex items-center justify-center text-accent group-hover:bg-accent group-hover:text-white transition-colors shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.961 0 1.371 1.24.588 1.81l-3.97 2.87a1 1 0 00-.364 1.118l1.52 4.674c.3.922-.755 1.688-1.538 1.118l-3.971-2.87a1 1 0 00-1.175 0l-3.97 2.87c-.783.57-1.838-.197-1.538-1.118l1.52-4.674a1 1 0 00-.364-1.118l-3.97-2.87c-.784-.57-.373-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <div class="text-left">
                    <h5 class="text-sm font-bold text-gray-800 group-hover:text-accent transition-colors">Kuisioner</h5>
                    <p class="text-xs text-gray-400 mt-0.5">Umpan balik evaluasi penyelenggaraan Baitul Arqam</p>
                </div>
                <svg class="w-4 h-4 text-gray-300 ml-auto group-hover:text-accent transition-colors shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <button @click="evalMenuOpen = false"
                class="w-full py-3.5 bg-gray-100 text-gray-700 font-bold text-sm rounded-2xl hover:bg-gray-200 transition-colors mt-6 shrink-0">
            Tutup Menu
        </button>
    </div>
</div>

<style>
    /* Safe Area padding for iOS bottom bar */
    .pb-safe {
        padding-bottom: env(safe-area-inset-bottom);
    }
</style>

<style>
    /* Safe Area padding for iOS bottom bar */
    .pb-safe {
        padding-bottom: env(safe-area-inset-bottom);
    }
</style>
