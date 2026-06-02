{{-- Form Input Component --}}
@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'helper' => '',
    'required' => false,
    'disabled' => false,
    'value' => '',
    'rows' => 3,
])

@php
    $hasError = $errors->has($name);
    $inputId = $name . '_' . uniqid();
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'mb-5']) }}>
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700 mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    @if($type === 'textarea')
        <textarea
            id="{{ $inputId }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            class="w-full px-4 py-3 text-sm border rounded-xl outline-none transition-all duration-200 resize-none
                   {{ $hasError
                       ? 'border-red-300 bg-red-50/50 focus:ring-2 focus:ring-red-200 focus:border-red-400'
                       : 'border-gray-200 bg-gray-50/50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary' }}
                   {{ $disabled ? 'opacity-60 cursor-not-allowed bg-gray-100' : '' }}"
        >{{ old($name, $value) }}</textarea>
    @else
        <div class="relative">
            <input
                id="{{ $inputId }}"
                type="{{ $type }}"
                name="{{ $name }}"
                value="{{ old($name, $value) }}"
                placeholder="{{ $placeholder }}"
                {{ $required ? 'required' : '' }}
                {{ $disabled ? 'disabled' : '' }}
                {{ $attributes->except('class') }}
                class="w-full px-4 py-3 text-sm border rounded-xl outline-none transition-all duration-200
                       {{ $hasError
                           ? 'border-red-300 bg-red-50/50 focus:ring-2 focus:ring-red-200 focus:border-red-400'
                           : 'border-gray-200 bg-gray-50/50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary' }}
                       {{ $disabled ? 'opacity-60 cursor-not-allowed bg-gray-100' : '' }}"
            >

            @if($type === 'password')
                <button type="button"
                        x-data="{ show: false }"
                        @click="show = !show; $el.previousElementSibling.type = show ? 'text' : 'password'"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            @endif
        </div>
    @endif

    @if($hasError)
        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ $errors->first($name) }}
        </p>
    @elseif($helper)
        <p class="mt-1.5 text-xs text-gray-400">{{ $helper }}</p>
    @endif
</div>
