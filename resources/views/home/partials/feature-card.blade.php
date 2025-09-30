@props([
    'iconSrc',
    'iconAlt',
    'title',
    'description'
])

<div class="text-center">
    <div class="flex justify-center">
        <img class="h-20 w-auto" src="{{ $iconSrc }}" alt="{{ $iconAlt }}">
    </div>
    <h3 class="mt-6 text-md font-bold tracking-tight text-gray-900">
        {{ $title }}
    </h3>
    <p class="mt-2 text-sm leading-7 text-gray-600">
        {{ $description }}
    </p>
</div>
