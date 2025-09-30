@props(['title', 'description', 'filters'])

<div class="rounded-xl bg-white p-3">
    <div class="mb-6 flex items-center">
        {{ $icon }}

        <div>
            <h1 class="text-2xl font-bold text-sblack">{{ $title }}</h1>
        </div>
    </div>

    <p class="mb-8 leading-relaxed text-sblack">
        {{ $description }}
    </p>

    <x-bank-soal.filter-bar 
    :action="route('bank-soal.index')" 
    :filters="$filters" 
    />

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        {{ $slot }}
    </div>
</div>
