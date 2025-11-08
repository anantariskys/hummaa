<x-app-layout>
    <x-tryout.hero-section/>

    <div class="bg-gray-50 py-12">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-semibold tracking-tight text-gray-900 sm:text-4xl">Daftar Event Tryout</h2>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($tryouts as $tryout)
                    <x-tryout.event-list-card
                        :title="$tryout->title"
                        :subtitle="$tryout->subtitle"
                        :description="$tryout->description"
                        :badge="$tryout->badge"
                        :duration="$tryout->duration"
                        :questionCount="$tryout->question_count"
                        :testParts="$tryout->test_parts"
                    />
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
