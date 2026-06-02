{{-- Button Component --}}
@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'loading' => false,
    'disabled' => false,
    'icon' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed gap-2';

    $variants = [
        'primary' => 'bg-primary text-white hover:bg-primary-600 focus:ring-primary/40 shadow-sm hover:shadow-md active:scale-[0.98]',
        'secondary' => 'bg-secondary text-white hover:bg-secondary-600 focus:ring-secondary/40 shadow-sm hover:shadow-md active:scale-[0.98]',
        'accent' => 'bg-accent text-white hover:bg-accent-500 focus:ring-accent/40 shadow-sm hover:shadow-md active:scale-[0.98]',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-400 shadow-sm hover:shadow-md active:scale-[0.98]',
        'ghost' => 'bg-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-800 focus:ring-gray-300',
        'outline' => 'border-2 border-primary text-primary hover:bg-primary hover:text-white focus:ring-primary/40',
        'outline-danger' => 'border-2 border-red-300 text-red-600 hover:bg-red-600 hover:text-white hover:border-red-600 focus:ring-red-400',
    ];

    $sizes = [
        'xs' => 'text-xs px-2.5 py-1.5',
        'sm' => 'text-sm px-3.5 py-2',
        'md' => 'text-sm px-5 py-2.5',
        'lg' => 'text-base px-6 py-3',
        'xl' => 'text-base px-8 py-3.5',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}"
       {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span class="w-4 h-4">{!! $icon !!}</span>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}"
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge(['class' => $classes]) }}
            @if($loading) x-data="{ loading: false }" @click="loading = true" :disabled="loading" @endif>
        @if($loading)
            <svg x-show="loading" class="animate-spin -ml-1 w-4 h-4" fill="none" viewBox="0 0 24 24" style="display:none">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @endif
        @if($icon)
            <span class="w-4 h-4" @if($loading) x-show="!loading" @endif>{!! $icon !!}</span>
        @endif
        <span @if($loading) x-show="!loading" @endif>{{ $slot }}</span>
        @if($loading)
            <span x-show="loading" style="display:none">Memproses...</span>
        @endif
    </button>
@endif
