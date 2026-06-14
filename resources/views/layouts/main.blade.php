<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ARQAM App') — Sistem Evaluasi Baitul Arqam</title>
    <link rel="icon" type="image/png" href="{{ asset('Logoums.png') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN with custom config --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#1A6D9B',
                            50: '#E8F4FA',
                            100: '#C5E3F2',
                            200: '#92CCE6',
                            300: '#5FB5DA',
                            400: '#2589B8',
                            500: '#1A6D9B',
                            600: '#155C84',
                            700: '#104B6D',
                            800: '#0B3A56',
                            900: '#06293F',
                        },
                        secondary: {
                            DEFAULT: '#2589B8',
                            50: '#EAF5FB',
                            100: '#CCEBF7',
                            200: '#99D6EF',
                            300: '#66C2E7',
                            400: '#47C8F0',
                            500: '#2589B8',
                            600: '#1E749D',
                            700: '#175F82',
                        },
                        accent: {
                            DEFAULT: '#D4A017',
                            50: '#FDF6E3',
                            100: '#FAEBBF',
                            200: '#F5D77F',
                            300: '#EFC33F',
                            400: '#D4A017',
                            500: '#B88A13',
                            600: '#9C740F',
                        },
                        surface: {
                            DEFAULT: '#F8F9FA',
                            50: '#FFFFFF',
                            100: '#F8F9FA',
                            200: '#E9ECEF',
                            300: '#DEE2E6',
                        },
                    },
                    fontFamily: {
                        heading: ['Poppins', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'card': '0 1px 3px 0 rgba(0,0,0,0.04), 0 1px 2px -1px rgba(0,0,0,0.04)',
                        'card-hover': '0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -2px rgba(0,0,0,0.05)',
                        'sidebar': '2px 0 8px rgba(0,0,0,0.08)',
                    },
                    animation: {
                        'slide-in': 'slideIn 0.3s ease-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'fade-in': 'fadeIn 0.2s ease-out',
                        'toast-in': 'toastIn 0.4s ease-out',
                        'toast-out': 'toastOut 0.3s ease-in forwards',
                    },
                    keyframes: {
                        slideIn: {
                            '0%': { transform: 'translateX(-100%)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(16px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        toastIn: {
                            '0%': { transform: 'translateX(100%)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        toastOut: {
                            '0%': { transform: 'translateX(0)', opacity: '1' },
                            '100%': { transform: 'translateX(100%)', opacity: '0' },
                        },
                    },
                },
            },
        }
    </script>

    {{-- Alpine.js (Stable Version) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    {{-- Global Styles --}}
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Poppins', sans-serif; }

        /* Scrollbar styling */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }

        /* Sidebar scrollbar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 2px; }

        /* Smooth transitions */
        .transition-sidebar { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), padding 0.3s cubic-bezier(0.4, 0, 0.2, 1); }

        /* Backdrop blur */
        .backdrop-blur-modal { backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); }

        /* Global Mobile Optimizations */
        button, a, input, select, textarea {
            touch-action: manipulation; /* Prevent double-tap zoom on fast clicks */
        }
        @media (max-width: 640px) {
            button, .btn {
                min-height: 44px; /* Apple Human Interface Guidelines minimum touch target */
            }
            .sidebar-scroll {
                -webkit-overflow-scrolling: touch;
            }
            input[type="text"], input[type="email"], input[type="password"], input[type="number"], select, textarea {
                font-size: 16px !important; /* Prevent iOS zoom on input focus */
            }
        }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-surface font-body text-gray-700 antialiased"
      x-data="{
          sidebarOpen: window.innerWidth >= 1024,
          sidebarCollapsed: (function() {
              try { return localStorage.getItem('sidebarCollapsed') === 'true'; }
              catch(e) { return false; }
          })(),
          init() {
              this.$watch('sidebarCollapsed', value => {
                  try { localStorage.setItem('sidebarCollapsed', value); }
                  catch(e) {}
              });
          },
          mobileMenu: false,
          loading: false,
          toasts: [],
          addToast(message, type = 'success', duration = 3000) {
              const id = Date.now();
              this.toasts.push({ id, message, type, removing: false });
              setTimeout(() => this.removeToast(id), duration);
          },
          removeToast(id) {
              const toast = this.toasts.find(t => t.id === id);
              if (toast) toast.removing = true;
              setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 300);
          }
      }"
      x-on:toast.window="addToast($event.detail.message, $event.detail.type || 'success', $event.detail.duration || 3000)"
      x-on:page-loading.window="loading = true"
>
    {{-- Premium Full-Page Loading Spinner --}}
    <div x-show="loading" 
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-white z-[99999] flex flex-col items-center justify-center"
         style="display: none;">
        <div class="flex flex-col items-center gap-4">
            <div class="relative w-12 h-12">
                <div class="absolute inset-0 border-4 border-primary/20 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
            </div>
            <p class="text-xs font-semibold text-primary uppercase tracking-widest animate-pulse">Memuat Halaman...</p>
        </div>
    </div>

    <div class="flex h-full">
        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Mobile overlay (Admin Only) --}}
        @if(auth()->check() && auth()->user()->isAdmin())
        <div x-show="mobileMenu"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenu = false"
             class="fixed inset-0 z-30 bg-black/50 lg:hidden"
             style="display: none;">
        </div>
        @endif

        {{-- Main content --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden lg:ml-64"
             :class="{ 'lg:ml-64': !sidebarCollapsed, 'lg:ml-20': sidebarCollapsed }">

            {{-- Topbar --}}
            @include('components.topbar')

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 @if(auth()->check() && auth()->user()->role === 'peserta') pb-24 lg:pb-8 @endif">
                <div class="max-w-[1280px] mx-auto animate-slide-up">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    {{-- Bottom Navigation for Peserta (Mobile Only) --}}
    @if(auth()->check() && auth()->user()->role === 'peserta')
        @include('components.bottom-nav')
    @endif

    {{-- Toast Container --}}
    <div class="fixed top-4 right-4 z-[100] flex flex-col gap-3 max-w-sm w-full pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <x-toast />
        </template>
    </div>

    @if(auth()->check() && auth()->user()->role === 'peserta')
    {{-- Sticky Notification Banner --}}
    <div x-data="{
            banners: [],
            addBanner(message, type, link) {
                const id = Date.now();
                this.banners.push({ id, message, type, link });
            },
            removeBanner(id) {
                this.banners = this.banners.filter(b => b.id !== id);
            }
         }"
         x-on:tes-notification.window="addBanner($event.detail.message, $event.detail.type, $event.detail.link)"
         class="fixed top-0 left-0 right-0 z-[200] flex flex-col gap-0 pointer-events-none">
        <template x-for="banner in banners" :key="banner.id">
            <div class="pointer-events-auto w-full"
                 x-transition:enter="transition ease-out duration-400"
                 x-transition:enter-start="opacity-0 -translate-y-full"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-full">
                <div class="flex items-center gap-4 px-4 py-3 text-white text-sm font-semibold shadow-lg"
                     :class="banner.type === 'pretest' ? 'bg-primary' : 'bg-emerald-600'">
                    <span class="w-2 h-2 rounded-full bg-white animate-ping flex-shrink-0"></span>
                    <span x-text="banner.message" class="flex-1"></span>
                    <a :href="banner.link" class="px-4 py-1.5 bg-white/20 hover:bg-white/30 rounded-lg text-xs font-bold transition-all border border-white/30 flex-shrink-0">
                        Kerjakan →
                    </a>
                    <button @click="removeBanner(banner.id)" class="flex-shrink-0 p-1 hover:bg-white/20 rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </template>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('notificationPoller', () => ({
                lastPretest: null,
                lastPosttest: null,
                eventId: null,
                init() {
                    this.poll();
                    setInterval(() => this.poll(), 25000);
                },
                poll() {
                    fetch('{{ route('peserta.notifications.poll') }}', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.success) return;
                        const pretestLink  = `/peserta/tes/${data.event_id}/${data.pretest_sesi_id}/pretest`;
                        const posttestLink = `/peserta/tes/${data.event_id}/${data.posttest_sesi_id}/posttest`;

                        // Pertama kali load — rekam status tanpa notifikasi
                        if (this.lastPretest === null) {
                            this.lastPretest  = data.pretest;
                            this.lastPosttest = data.posttest;

                            // Kalau saat load page sudah ada sesi aktif, tetap tampilkan banner
                            if (data.pretest) {
                                window.dispatchEvent(new CustomEvent('tes-notification', { detail: {
                                    message: '🔔 Sesi PRETEST sedang BERLANGSUNG! Segera kerjakan sekarang.',
                                    type: 'pretest', link: pretestLink
                                }}));
                            }
                            if (data.posttest) {
                                window.dispatchEvent(new CustomEvent('tes-notification', { detail: {
                                    message: '🔔 Sesi POSTTEST sedang BERLANGSUNG! Segera kerjakan sekarang.',
                                    type: 'posttest', link: posttestLink
                                }}));
                            }
                            return;
                        }

                        // Baru dibuka saat sedang di halaman
                        if (data.pretest && !this.lastPretest) {
                            window.dispatchEvent(new CustomEvent('tes-notification', { detail: {
                                message: '🔔 Sesi PRETEST baru saja DIBUKA! Segera kerjakan.',
                                type: 'pretest', link: pretestLink
                            }}));
                            window.dispatchEvent(new CustomEvent('toast', { detail: {
                                message: 'Sesi Pretest dibuka! Segera kerjakan.', type: 'info', duration: 8000
                            }}));
                        }
                        if (data.posttest && !this.lastPosttest) {
                            window.dispatchEvent(new CustomEvent('tes-notification', { detail: {
                                message: '🔔 Sesi POSTTEST baru saja DIBUKA! Segera kerjakan.',
                                type: 'posttest', link: posttestLink
                            }}));
                            window.dispatchEvent(new CustomEvent('toast', { detail: {
                                message: 'Sesi Posttest dibuka! Segera kerjakan.', type: 'info', duration: 8000
                            }}));
                        }

                        this.lastPretest  = data.pretest;
                        this.lastPosttest = data.posttest;
                    })
                    .catch(err => console.error('Polling error', err));
                }
            }));
        });
    </script>
    <div x-data="notificationPoller" class="hidden"></div>
    @endif

    @stack('scripts')

    {{-- Flash message to toast --}}
    @if(session('success'))
    <script>
        document.addEventListener('alpine:init', () => {
            setTimeout(() => {
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: { message: '{{ session("success") }}', type: 'success' }
                }));
            }, 100);
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        document.addEventListener('alpine:init', () => {
            setTimeout(() => {
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: { message: '{{ session("error") }}', type: 'error' }
                }));
            }, 100);
        });
    </script>
    @endif

    {{-- Global Loading Listener --}}
    <script>
        window.addEventListener('beforeunload', function(e) {
            const activeEl = document.activeElement;
            if (activeEl && activeEl.tagName === 'A') {
                const href = activeEl.getAttribute('href');
                const target = activeEl.getAttribute('target');
                const isDownload = href && (
                    href.includes('export') || 
                    href.includes('download') || 
                    href.includes('pdf') || 
                    href.includes('report') || 
                    activeEl.hasAttribute('download')
                );
                if (href && !href.startsWith('#') && !href.startsWith('javascript:') && target !== '_blank' && !isDownload) {
                    window.dispatchEvent(new CustomEvent('page-loading'));
                }
            } else if (activeEl && (activeEl.tagName === 'BUTTON' || activeEl.getAttribute('type') === 'submit')) {
                const form = activeEl.closest('form');
                if (form) {
                    const action = form.getAttribute('action') || '';
                    if (action.includes('export') || action.includes('download') || action.includes('pdf') || action.includes('report')) {
                        return;
                    }
                }
                window.dispatchEvent(new CustomEvent('page-loading'));
            }
        });
        
        // Also capture form submits to show loading, but check if the event was prevented/cancelled (e.g. by confirm() alert)
        document.addEventListener('submit', function(event) {
            const form = event.target;
            const action = form.getAttribute('action') || '';
            const isDownload = action.includes('export') || action.includes('download') || action.includes('pdf') || action.includes('report');
            
            if (isDownload) {
                return;
            }
            
            setTimeout(function() {
                if (!event.defaultPrevented) {
                    window.dispatchEvent(new CustomEvent('page-loading'));
                }
            }, 0);
        });
    </script>
</body>
</html>
