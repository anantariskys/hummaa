@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
        class="mb-4 rounded-lg bg-green-100 p-4 text-green-800">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
        class="mb-4 rounded-lg bg-red-100 p-4 text-red-800">
        {{ session('error') }}
    </div>
@endif
