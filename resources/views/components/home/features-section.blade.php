<div class="bg-gray-50 py-16 sm:py-24">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-y-12 md:grid-cols-3 md:gap-x-8">

            @include('home.partials.feature-card', [
                'iconSrc' => asset('images/anytime.png'),
                'iconAlt' => 'Ikon Jam',
                'title' => 'Belajar Kapan Saja',
                'description' => 'Tak perlu khawatir soal waktu. Belajar bisa dilakukan kapan pun dan di mana pun hanya dengan HP. Lebih fleksibel dan praktis!'
            ])

            @include('home.partials.feature-card', [
                'iconSrc' => asset('images/akses-gratis.png'),
                'iconAlt' => 'Ikon Gembok',
                'title' => 'Akses Gratis',
                'description' => 'Langsung coba tanpa daftar! Dapatkan 5 soal uji coba secara gratis untuk tiap kategori soal.'
            ])

            @include('home.partials.feature-card', [
                'iconSrc' => asset('images/ribuan-soal.png'),
                'iconAlt' => 'Ikon Buku',
                'title' => 'Puluhan Ribu Soal',
                'description' => 'Kami menyediakan lebih dari 40.000 soal latihan yang siap bantu kamu menghadapi berbagai jenis ujian.'
            ])

        </div>
    </div>
</div>
