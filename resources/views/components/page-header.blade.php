{{-- Page Header Component --}}
@props([
    'title' => '',
    'subtitle' => '',
    'actionLabel' => null,
    'actionUrl' => null,
    'actionVariant' => 'primary',
    'actionIcon' => null,
])

<div {{ $attributes->merge(['class' => 'mb-8']) }}>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 font-heading tracking-tight">{{ $title }}</h1>
            @if($subtitle)
                <p class="text-sm text-gray-500 mt-1">{{ $subtitle }}</p>
            @endif
        </div>

        <div class="flex items-center gap-3">
            @if(isset($actions))
                {{ $actions }}
            @elseif($actionLabel)
                <x-button :variant="$actionVariant" :href="$actionUrl">
                    @if($actionIcon)
                        {!! $actionIcon !!}
                    @else
                        <svg class="w-4 h-4 -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    @endif
                    {{ $actionLabel }}
                </x-button>
            @endif
        </div>
    </div>
</div>
