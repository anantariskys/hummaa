<x-app-layout>
    @php
        // Data Dummy
        $tryouts = [
            [
                'title' => 'TPA',
                'subtitle' => 'Tes Potensi Akademik',
                'description' => 'Menilai kemampuan kognitif dan kapasitas intelektual',
                'badge' => 'Lanjutan',
                'duration' => '120 menit',
                'questionCount' => '80 soal',
                'testParts' => ['Penalaran Verbal', 'Penalaran Kuantitatif', 'Penulisan Analitis'],
            ],
            [
                'title' => 'TKB',
                'subtitle' => 'Tes Kompetensi Dasar',
                'description' => 'Mengevaluasi pengetahuan dasar dan kompetensi umum',
                'badge' => 'Menengah',
                'duration' => '90 menit',
                'questionCount' => '60 soal',
                'testParts' => ['Pengetahuan Umum', 'Matematika Dasar', 'Kemampuan Bahasa'],
            ],
            [
                'title' => 'TIU',
                'subtitle' => 'Tes Intelegensi Umum',
                'description' => 'Menilai kemampuan kognitif dan kapasitas intelektual',
                'badge' => 'Lanjutan',
                'duration' => '60 menit',
                'questionCount' => '50 soal',
                'testParts' => ['Penalaran Logis', 'Pengenalan Pola', 'Intelegensi Spesial'],
            ],
            [
                'title' => 'TIU',
                'subtitle' => 'Tes Intelegensi Umum',
                'description' => 'Menilai kemampuan kognitif dan kapasitas intelektual',
                'badge' => null,
                'duration' => '60 menit',
                'questionCount' => '50 soal',
                'testParts' => ['Penalaran Logis', 'Pengenalan Pola', 'Intelegensi Spesial'],
            ],
        ];
    @endphp

    <x-tryout.hero-section/>

    <div class="bg-gray-50 py-12">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-semibold tracking-tight text-gray-900 sm:text-4xl">Daftar Event Tryout</h2>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($tryouts as $tryout)
                    <x-tryout.event-list-card
                        :title="$tryout['title']"
                        :subtitle="$tryout['subtitle']"
                        :description="$tryout['description']"
                        :badge="$tryout['badge']"
                        :duration="$tryout['duration']"
                        :questionCount="$tryout['questionCount']"
                        :testParts="$tryout['testParts']"
                    />
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
