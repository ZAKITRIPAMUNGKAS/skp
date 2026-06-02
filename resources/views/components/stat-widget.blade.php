{{-- Stat Widget Component --}}
@props([
    'value' => '0',
    'label' => '',
    'icon' => null,
    'iconBg' => 'bg-primary/10',
    'iconColor' => 'text-primary',
    'change' => null,
    'changeType' => 'up',
])

<div class="bg-white rounded-2xl shadow-card border border-gray-100 p-6 hover:shadow-card-hover transition-all duration-200 group">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-500 mb-1">{{ $label }}</p>
            <p class="text-3xl font-bold text-gray-800 font-heading tracking-tight">{{ $value }}</p>

            @if($change)
                <div class="flex items-center gap-1.5 mt-2">
                    @if($changeType === 'up')
                        <span class="inline-flex items-center gap-0.5 text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                            {{ $change }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-0.5 text-xs font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                            </svg>
                            {{ $change }}
                        </span>
                    @endif
                </div>
            @endif
        </div>

        @if($icon)
            <div class="w-12 h-12 {{ $iconBg }} rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                {!! $icon !!}
            </div>
        @endif
    </div>
</div>
