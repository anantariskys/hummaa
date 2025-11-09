@props([
    'title',
    'subtitle',
    'description',
    'badge',
    'duration',
    'questionCount',
    'testParts',
    'tryoutId' => null  // Tambahkan ini
])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
    <!-- Badge -->
    <div class="bg-teal-500 text-white px-4 py-2">
        <span class="text-sm font-semibold">{{ $badge }}</span>
    </div>
    
    <!-- Content -->
    <div class="p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $title }}</h3>
        <p class="text-sm text-gray-600 mb-4">{{ $subtitle }}</p>
        <p class="text-sm text-gray-700 mb-4">{{ $description }}</p>
        
        <!-- Info -->
        <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
            <span>⏱️ {{ $duration }}</span>
            <span>📝 {{ $questionCount }}</span>
        </div>
        
        <!-- Test Parts -->
        <div class="mb-4">
            <p class="text-xs text-gray-500 mb-2">Bagian Tes:</p>
            <div class="flex flex-wrap gap-2">
                @foreach($testParts as $part)
                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">{{ $part }}</span>
                @endforeach
            </div>
        </div>
        
        <!-- Action Button -->
        @if($tryoutId)
            <a href="{{ route('tryout.start', $tryoutId) }}" 
               class="block w-full bg-teal-500 hover:bg-teal-600 text-white text-center py-2 rounded-lg transition-colors duration-200">
                Mulai Tryout
            </a>
        @else
            <button disabled 
                    class="block w-full bg-gray-300 text-gray-500 text-center py-2 rounded-lg cursor-not-allowed">
                Tryout Belum Tersedia
            </button>
        @endif
    </div>
</div>