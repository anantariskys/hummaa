<x-app-layout>
    <x-tryout.hero-section/>

    <div class="bg-gray-50 py-12">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-semibold tracking-tight text-gray-900 sm:text-4xl">Daftar Event Tryout</h2>
            </div>

            @if($tryouts->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">Belum ada event tryout yang tersedia saat ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($tryouts as $event)
                        <x-tryout.event-list-card
                            :title="$event->title"
                            :subtitle="$event->subtitle"
                            :description="$event->description"
                            :badge="$event->badge"
                            :duration="$event->duration"
                            :questionCount="$event->question_count"
                            :testParts="$event->test_parts"
                            :tryoutId="$event->tryout ? $event->tryout->tryout_id : null"
                        />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>