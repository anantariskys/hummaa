<div class="bg-white pb-20">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Kenapa PPPKin Berbeda</h2>
            <p class="mt-6 text-lg leading-8 text-gray-600">
                Belajar di PPPKin bukan hanya soal latihan soal, tapi juga pengalaman belajar yang terarah, interaktif, dan mudah diakses untuk bantu kamu lolos seleksi!
            </p>
        </div>

        <div class="mx-auto mt-16 max-w-4xl space-y-6">
            @include('home.partials.feature-item', [
                'title' => '📝 Tryout Interaktif',
                'description' => 'Simulasi ujian nyata dengan tampilan yang menyerupai tes sebenarnya, bantu kamu lebih siap dan percaya diri.'
            ])

            @include('home.partials.feature-item', [
                'title' => '📚 Materi Lengkap',
                'description' => 'Materi belajar tersusun rapi berdasarkan topik dan jenis ujian, mudah dipahami oleh siapa pun.'
            ])

            @include('home.partials.feature-item', [
                'title' => '🤖 Bank Soal',
                'description' => 'Akses ribuan soal latihan yang terus diperbarui, dilengkapi dengan fitur chatbot AI untuk tanya-jawab cepat dan akurat.'
            ])

            @include('home.partials.feature-item', [
                'title' => '💬 Forum Diskusi',
                'description' => 'Tempat bertanya, berbagi tips, dan diskusi dengan sesama pejuang seleksi. Belajar jadi lebih seru dan tidak sendirian.'
            ])
        </div>
    </div>
</div>
