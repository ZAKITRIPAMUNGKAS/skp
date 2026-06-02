{{-- Topbar Component --}}
<header class="sticky top-0 z-[40] bg-white/80 backdrop-blur-sm border-b border-gray-200/60">
    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
        {{-- Left: Hamburger + Breadcrumb --}}
        <div class="flex items-center gap-4">
            {{-- Mobile hamburger --}}
            <button @click="mobileMenu = true"
                    class="lg:hidden w-10 h-10 rounded-xl hover:bg-gray-100 flex items-center justify-center transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            {{-- Breadcrumb --}}
            <nav class="hidden sm:flex items-center text-sm">
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('peserta.dashboard') }}"
                   class="text-gray-400 hover:text-primary transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </a>
                @hasSection('breadcrumb')
                    <svg class="w-4 h-4 text-gray-300 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    @yield('breadcrumb')
                @endif
            </nav>
        </div>

        {{-- Right: Notifications + Profile --}}
        <div class="flex items-center gap-2">
            {{-- Notification bell --}}
            <div x-data="{ notifOpen: false }" class="relative">
                <button @click="notifOpen = !notifOpen"
                        class="relative w-10 h-10 rounded-xl hover:bg-gray-100 flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    {{-- Notification dot --}}
                    <span class="absolute top-2 right-2 w-2 h-2 bg-accent rounded-full ring-2 ring-white"></span>
                </button>

                {{-- Notification dropdown --}}
                <div x-show="notifOpen" @click.outside="notifOpen = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden"
                     style="display: none;">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-800 font-heading">Notifikasi</h3>
                    </div>
                    <div class="py-2 max-h-64 overflow-y-auto">
                        <div class="px-4 py-8 text-center">
                            <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <p class="text-sm text-gray-400">Belum ada notifikasi</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="w-px h-6 bg-gray-200 mx-1 hidden sm:block"></div>

            <div x-data="{ profileOpen: false }" class="relative" @click.stop>
                <button @click="profileOpen = !profileOpen"
                        class="flex items-center gap-3 pl-2 pr-3 py-1.5 rounded-xl hover:bg-gray-100 transition-colors cursor-pointer">
                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center overflow-hidden border border-gray-100">
                        @if(auth()->user()->peserta && auth()->user()->peserta->foto)
                            <img src="{{ asset('storage/' . auth()->user()->peserta->foto) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-xs font-semibold text-primary">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="hidden sm:block text-left">
                        <p class="text-sm font-medium text-gray-700 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 capitalize leading-tight">{{ auth()->user()->role }}</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 hidden sm:block transition-transform duration-200"
                         :class="profileOpen ? 'rotate-180' : ''"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Profile dropdown menu --}}
                <div x-show="profileOpen" @click.outside="profileOpen = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden"
                     style="display: none;">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="py-1">
                        <a href="{{ auth()->user()->role === 'peserta' ? route('peserta.profile.index') : '#' }}" 
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-primary transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profil Saya
                        </a>
                    </div>
                    <div class="border-t border-gray-100 py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
