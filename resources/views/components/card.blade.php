{{-- Card Component --}}
@props([
    'padding' => 'p-6',
    'hover' => false,
])

<div {{ $attributes->merge([
    'class' => "bg-white rounded-2xl shadow-card border border-gray-100 overflow-hidden transition-all duration-200 " .
               ($hover ? 'hover:shadow-card-hover hover:-translate-y-0.5 cursor-pointer ' : '') .
               $padding
]) }}>
    @if(isset($header))
        <div class="border-b border-gray-100 -mx-6 -mt-6 px-6 py-4 mb-6 bg-gray-50/50">
            {{ $header }}
        </div>
    @endif

    {{ $slot }}

    @if(isset($footer))
        <div class="border-t border-gray-100 -mx-6 -mb-6 px-6 py-4 mt-6 bg-gray-50/30">
            {{ $footer }}
        </div>
    @endif
</div>
