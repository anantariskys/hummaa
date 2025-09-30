@props([
    'title',
    'subtitle',
    'description',
    'badge' => null,
    'duration',
    'questionCount',
    'testParts' => [],
])

<div class="flex flex-col rounded-lg bg-white p-6 shadow-md">
    <div class="flex items-start justify-between">
        <div>
            <h3 class="text-xl font-bold text-gray-900">{{ $title }}</h3>
            <p class="text-sm text-gray-500">{{ $subtitle }}</p>
        </div>
        @if($badge)
            <span class="inline-flex items-center rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600">{{ $badge }}</span>
        @endif
    </div>

    <div class="mt-4 flex-grow">
        <p class="text-sm text-gray-700">{{ $description }}</p>
        <div class="mt-4 flex items-center space-x-6 text-sm text-gray-600">
            <div class="flex items-center gap-x-2">
                {{-- Icon Jam --}}
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" /></svg>
                <span>{{ $duration }}</span>
            </div>
            <div class="flex items-center gap-x-2">
                {{-- Icon Dokumen --}}
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zM10 8a.75.75 0 01.75.75v.008a.75.75 0 01-1.5 0V8.75A.75.75 0 0110 8zm0 3a.75.75 0 01.75.75v.008a.75.75 0 01-1.5 0V11.75A.75.75 0 0110 11zm-3-3a.75.75 0 01.75.75v.008a.75.75 0 01-1.5 0V8.75A.75.75 0 017 8zm0 3a.75.75 0 01.75.75v.008a.75.75 0 01-1.5 0V11.75A.75.75 0 017 11z" clip-rule="evenodd" /></svg>
                <span>{{ $questionCount }}</span>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-sm font-semibold text-gray-800">Bagian Tes:</p>
            <ul class="mt-1 list-disc list-inside space-y-1 text-sm text-gray-600">
                @foreach($testParts as $part)
                    <li>{{ $part }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mt-6">
        <x-primary-button class="w-full">{{ __('Daftar') }}</x-primary-button>
    </div>
</div>
