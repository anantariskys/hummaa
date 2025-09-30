@props(['action' => '#', 'filters' => []]) 

<form action="{{ $action }}" method="GET" class="mb-8">
    <div class="flex w-full flex-col items-center gap-4 md:flex-row">
        
        <div class="relative w-full flex-grow ">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-main-bg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
            <input type="text" name="search" placeholder="Cari"
                value="{{ $filters['search'] ?? '' }}"
                class="w-full rounded-xl border border-main-bg py-2 pl-10 pr-4 shadow-xl text-gray-700 focus:border-main-bg focus:ring-main-bg">
        </div>
    
        <div x-data="{ 
            open: false, 
            selectedYear: '{{ $filters['year'] ?? 'Tahun' }}', 
            yearValue: '{{ $filters['year'] ?? '' }}' 
         }" 
         class="relative w-full md:w-auto">
            
            <input type="hidden" name="year" x-model="yearValue">

            <button type="button" @click="open = !open"
                class="flex w-full min-w-[150px] items-center justify-between rounded-xl border border-main-bg bg-white px-4 py-2 text-gray-700 shadow-xl focus:outline-none focus:ring-2 focus:ring-main-bg focus:ring-offset-2">
                <span x-text="selectedYear"></span>
                <svg class="ml-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
    
            <div x-show="open" 
                 @click.away="open = false"
                 x-transition
                 class="absolute right-0 z-10 mt-2 w-full origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                 style="display: none;">
                <div class="py-1">
                    @for ($year = 2025; $year >= 2015; $year--)
                    <a href="#" @click.prevent="selectedYear = '{{ $year }}'; yearValue = '{{ $year }}'; open = false; $nextTick(() => { $el.closest('form').submit() });"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        {{ $year }}
                     </a>
                    @endfor
                </div>
            </div>
        </div>

        {{-- <button type="submit" class="rounded-md bg-main-bg px-6 py-2 text-white">Filter</button> --}}
    </div>
</form>