{{-- Data Table Component --}}
@props([
    'searchable' => true,
    'searchPlaceholder' => 'Cari data...',
])

<div x-data="{
        search: '',
        currentPage: 1,
        sortCol: null,
        sortDir: 'asc',
     }"
     class="bg-white rounded-2xl shadow-card border border-gray-100 overflow-hidden">

    {{-- Table Header --}}
    <div class="px-6 py-4 border-b border-gray-100">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            @if(isset($title))
                <div>
                    {{ $title }}
                </div>
            @endif

            <div class="flex items-center gap-3">
                @if($searchable)
                    <div class="relative flex-1 sm:flex-none">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text"
                               x-model="search"
                               placeholder="{{ $searchPlaceholder }}"
                               class="w-full sm:w-64 pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all bg-gray-50/50 hover:bg-white">
                    </div>
                @endif

                @if(isset($actions))
                    {{ $actions }}
                @endif
            </div>
        </div>
    </div>

    {{-- Table Content --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            @if(isset($head))
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        {{ $head }}
                    </tr>
                </thead>
            @endif
            <tbody class="divide-y divide-gray-50">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    {{-- Pagination / Footer --}}
    @if(isset($pagination))
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
            {{ $pagination }}
        </div>
    @endif
</div>
