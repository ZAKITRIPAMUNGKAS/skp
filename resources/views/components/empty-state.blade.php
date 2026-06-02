{{-- Empty State Component --}}
@props([
    'title' => 'Belum ada data',
    'description' => 'Data yang Anda cari belum tersedia.',
    'actionLabel' => null,
    'actionUrl' => null,
    'icon' => 'default',
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center py-12 px-6']) }}>
    {{-- Illustration --}}
    <div class="w-32 h-32 mb-6 text-gray-200">
        @if($icon === 'search')
            <svg viewBox="0 0 128 128" fill="none" class="w-full h-full">
                <circle cx="52" cy="52" r="36" stroke="currentColor" stroke-width="4" />
                <line x1="78" y1="78" x2="110" y2="110" stroke="currentColor" stroke-width="6" stroke-linecap="round" />
                <circle cx="52" cy="52" r="20" stroke="currentColor" stroke-width="2" opacity="0.4" />
            </svg>
        @elseif($icon === 'document')
            <svg viewBox="0 0 128 128" fill="none" class="w-full h-full">
                <rect x="24" y="12" width="80" height="104" rx="8" stroke="currentColor" stroke-width="4" />
                <line x1="42" y1="40" x2="86" y2="40" stroke="currentColor" stroke-width="3" stroke-linecap="round" opacity="0.5" />
                <line x1="42" y1="56" x2="76" y2="56" stroke="currentColor" stroke-width="3" stroke-linecap="round" opacity="0.4" />
                <line x1="42" y1="72" x2="66" y2="72" stroke="currentColor" stroke-width="3" stroke-linecap="round" opacity="0.3" />
                <rect x="42" y="84" width="44" height="16" rx="4" stroke="currentColor" stroke-width="2" opacity="0.3" />
            </svg>
        @elseif($icon === 'people')
            <svg viewBox="0 0 128 128" fill="none" class="w-full h-full">
                <circle cx="64" cy="40" r="18" stroke="currentColor" stroke-width="4" />
                <path d="M28 108c0-19.882 16.118-36 36-36s36 16.118 36 36" stroke="currentColor" stroke-width="4" stroke-linecap="round" />
                <circle cx="96" cy="36" r="12" stroke="currentColor" stroke-width="3" opacity="0.4" />
                <path d="M82 100c4-12 14-18 14-18" stroke="currentColor" stroke-width="3" stroke-linecap="round" opacity="0.3" />
            </svg>
        @else
            <svg viewBox="0 0 128 128" fill="none" class="w-full h-full">
                <rect x="20" y="28" width="88" height="72" rx="8" stroke="currentColor" stroke-width="4" />
                <path d="M20 48h88" stroke="currentColor" stroke-width="3" opacity="0.4" />
                <circle cx="36" cy="38" r="4" fill="currentColor" opacity="0.3" />
                <circle cx="50" cy="38" r="4" fill="currentColor" opacity="0.3" />
                <circle cx="64" cy="38" r="4" fill="currentColor" opacity="0.3" />
                <rect x="36" y="60" width="56" height="4" rx="2" fill="currentColor" opacity="0.2" />
                <rect x="36" y="72" width="40" height="4" rx="2" fill="currentColor" opacity="0.15" />
                <rect x="36" y="84" width="24" height="4" rx="2" fill="currentColor" opacity="0.1" />
            </svg>
        @endif
    </div>

    {{-- Text --}}
    <h3 class="text-lg font-semibold text-gray-600 font-heading mb-2">{{ $title }}</h3>
    <p class="text-sm text-gray-400 text-center max-w-sm mb-6">{{ $description }}</p>

    {{-- Action --}}
    @if($actionLabel)
        <x-button variant="primary" :href="$actionUrl">
            <svg class="w-4 h-4 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            {{ $actionLabel }}
        </x-button>
    @endif

    {{ $slot }}
</div>
