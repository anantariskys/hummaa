@props(['title', 'description'])

<div class="rounded-2xl border-4 border-main-bg bg-white shadow-sm">
    <div class="bg-white flex flex-col p-3 space-y-2">
        <div class="bg-card-diff-bg rounded-md p-2">
            <h3 class="text-md font-bold leading-6 text-gray-900">{{ $title }}</h3>
        </div>
        <div class="text-gray-950 text-sm p-2 bg-card-diff-bg rounded-md font-semibold">
            {{ $description }}
        </div>
    </div>
</div>
